<?php

namespace App\Services;

use App\Jobs\ProcessDeleteAdmins;
use App\Models\Admin;
use App\Models\AdminRole;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;

class AdminService
{

    public final const ADMIN_CACHE_KEY  = 'delete_admins';
    public final const ADMIN_CACHE_EXPIRATION_TIME  = 60;

    /**
     * Store admin in database.
     *
     * @param array<string, mixed> $adminData
     * @return Admin
     */
    public function store(array $adminData): Admin
    {
        $role = AdminRole::where('role', $adminData['role'])->first();

        unset($adminData["role"]);

        $admin = Admin::create($adminData);
        $admin->roles()->attach($role->id);
        $admin->refresh();

        return $admin;
    }

    /**
     * Update admin
     *
     * @param array<string, mixed> $adminData
     * @param Admin $admin
     * @return Admin
     */
    public function update(array $adminData, Admin $admin): Admin
    {
        $role = $adminData['role'];

        if ($admin->roles()->where('role', $role)->doesntExist()) {
            $newRole = AdminRole::where('role', $role)->first();
            $admin->roles()->syncWithoutDetaching([$newRole->id]);
            $admin->refresh();
        }

        unset($adminData['role']);
        $admin->update($adminData);

        return $admin;
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
                $admins = Admin::whereIn('id', $ids)->get();
                $admins->each(function ($admin) {
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

    public function storeIdsForDeletion(array $ids): string|bool
    {
        $cacheFull = $this->cacheFull();

        if ($cacheFull) {
            return true;
        }

        $key = Str::uuid();

        // Store the data in Redis with the specified key
        Redis::transaction(function ($redis) use ($key, $ids) {
            $redis->set(self::ADMIN_CACHE_KEY, json_encode([
                'key' => $key,
                'ids' => $ids,
            ]));;

            // $redis->expire(self::ADMIN_CACHE_KEY, self::ADMIN_CACHE_EXPIRATION_TIME);
        });

        return $key;
    }

    public function getIdsForDeletionFromCacheUsing(string $deleteKey): array|bool
    {
        $ids = $this->getIdsForDeletionFromCache();

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
        Redis::forget(self::ADMIN_CACHE_KEY);
    }
}
