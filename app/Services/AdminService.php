<?php

namespace App\Services;

use App\Http\Resources\AdminCollection;
use App\Http\Resources\AdminResource;
use App\Jobs\ProcessDeleteAdmins;
use App\Models\Admin;
use App\Models\AdminRole;
use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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

    public final const TOKEN_NAME = "admin";

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
    public function update(Admin $admin, array $adminData): AdminResource
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

    /**
     * Returns tuple that consists of true and bus id for deleted admin report or false if cant delete admins
     *
     * @param string $key
     * @return boolean
     */
    public function deleteAdmins(string $key): bool
    {
        $ids = $this->getIdsForDeletionFromCacheUsing($key);
        $jobBatch = [];

        if ($ids) {
            DB::transaction(function () use ($ids, $key, &$jobBatch) {
                Admin::whereIn('id', $ids)->lazyById()->each(function (Admin $admin) use ($key, &$jobBatch) {
                    $this->delete($admin);

                    $jobBatch = [...$jobBatch, new ProcessDeleteAdmins($admin, $key)];
                });

                // REVIEW: For dispatching jobs within database transaction use after commit to dispatch job after transaction is finished
                // ProcessDeleteAdmins::dispatch(
                //     $id,
                //     $key,
                // )->afterCommit();
            });

            $this->clearCache();

            $busId = Bus::batch(
                $jobBatch
            )->then(function (Batch $batch) {
                // All jobs completed successfully...
            })->catch(function (Batch $batch, \Throwable $e) {
                // First batch job failure detected...
            })->finally(function (Batch $batch) {
                // The batch has finished executing...
            })->name('Deleted admins report')->dispatch();

            return [true, $busId];
        }

        return false;
    }

    /**
     * Store ids for deletion
     *
     * @param array<int> $ids
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
            ]), self::ADMIN_CACHE_EXPIRATION_TIME);
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


    function login($validatedAdmin, $header): string|bool
    {
        $admin = Admin::where('email', $validatedAdmin['email'])->first();
        $adminAbilities = [];

        if ($header === config('auth.admin_key')) {
            $adminAbilities = [...$adminAbilities, 'admin:modify'];
        }

        if (!$admin || !Hash::check($validatedAdmin['password'], $admin->password)) {
            return false;
        }

        $token = $admin->createToken(self::TOKEN_NAME,  $adminAbilities)->plainTextToken;

        return $token;
    }

    function logout(): void
    {
        auth()->user()->currentAccessToken()->delete();
    }
}
