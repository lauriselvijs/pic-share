<?php

namespace App\Services;

use App\Http\Resources\AdminCollection;
use App\Http\Resources\AdminResource;
use App\Jobs\ProcessDeleteAdmins;
use App\Models\Admin;
use App\Models\AdminRole;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;

class AdminService
{
    public final const ADMIN_CACHE_KEY  = 'delete_admins';
    public final const ADMIN_CACHE_EXPIRATION_TIME  = 60;
    public final const THROTTLE_KEY = 'admin';
    public final const THROTTLE_ATTEMPTS = 10;
    public final const THROTTLED_RECORDS = 5;

    public function __construct(private Admin $admin)
    {
        $this->admin = $admin;
    }


    public function throttleRequest(): AdminCollection
    {
        $admins = RateLimiter::attempt(self::THROTTLE_KEY, self::THROTTLE_ATTEMPTS, function () {
            return Admin::latest()->cursorPaginate(Admin::PER_PAGE);
        });

        if ($admins) {
            return new AdminCollection($admins);
        }

        return new AdminCollection(Admin::latest()->take(self::THROTTLED_RECORDS)->get());
    }

    /**
     * Store admin in database.
     *
     * @param array<string, mixed> $adminData
     * @return AdminResource
     */
    public function store(array $adminData): AdminResource
    {
        $adminRole = AdminRole::where('role', $adminData['role'])->first();

        unset($adminData["role"]);

        $admin = Admin::create($adminData);
        $admin->roles()->attach($adminRole->id);
        $admin->refresh();

        return new AdminResource($admin);
    }

    /**
     * Update admin
     *
     * @param array<string, mixed> $adminData
     * @param Admin $admin
     * @return AdminResource
     */
    public function update(array $adminData, Admin $admin): AdminResource
    {
        $role = $adminData['role'];

        if ($admin->roles()->where('role', $role)->doesntExist()) {
            $newAdminRole = AdminRole::where('role', $role)->first();
            $admin->roles()->syncWithoutDetaching([$newAdminRole->id]);
            $admin->refresh();
        }

        unset($adminData['role']);
        $admin->update($adminData);

        return new AdminResource($admin);
    }

    public function delete(Admin $admin)
    {
        DB::transaction(function () use ($admin) {
            $admin->roles()->detach();
            $admin->delete();
        });
    }

    public function deleteAdmins(string $key): bool
    {
        $ids = $this->getIdsForDeletionFromCacheUsing($key);

        if ($ids) {
            DB::transaction(function () use ($ids, $key) {
                Admin::whereIn('id', $ids)->lazyById()->each(function ($admin) {
                    $this->delete($admin);
                });

                ProcessDeleteAdmins::dispatch(
                    $ids,
                    $key,
                    self::ADMIN_CACHE_KEY,
                    self::ADMIN_CACHE_EXPIRATION_TIME
                )->afterCommit();
            });

            $this->clearCache();

            return true;
        }

        return false;
    }

    /**
     * Store ids for deletion
     *
     * @param array<integer> $ids
     * @return string|boolean
     */
    public function storeIdsForDeletion(array $ids): string|bool
    {
        $cacheFull = $this->cacheFull();

        if ($cacheFull) {
            return false;
        }

        $key = Str::uuid();

        // Store the data in Redis with the specified key
        Redis::transaction(function ($redis) use ($key, $ids) {
            $redis->set(self::ADMIN_CACHE_KEY, json_encode([
                'key' => $key,
                'ids' => $ids,
            ]), 'ex', self::ADMIN_CACHE_EXPIRATION_TIME);
        });

        return $key;
    }

    public function getIdsForDeletionFromCacheUsing(string $deleteKey): array|bool
    {
        $cache = Redis::get(self::ADMIN_CACHE_KEY);
        $ids = json_decode($cache, true);

        if (isset($ids['key']) && $ids['key'] === $deleteKey) {
            return $ids['ids'];
        }

        return false;
    }

    public function cacheFull(): bool|array
    {
        $cache = Redis::get(self::ADMIN_CACHE_KEY);

        if ($cache) {
            return true;
        }

        return false;
    }

    public function clearCache(): void
    {
        Redis::command('del', [self::ADMIN_CACHE_KEY]);
    }
}
