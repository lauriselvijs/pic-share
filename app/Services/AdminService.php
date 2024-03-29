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
use Illuminate\Support\ValidatedInput;

class AdminService
{
    private const ADMIN_CACHE_KEY  = 'delete_admins';
    private const ADMIN_CACHE_EXPIRATION_TIME = 60;

    private const THROTTLE_KEY = 'admin';
    private const THROTTLE_ATTEMPTS = 10;
    private const THROTTLED_OUTPUT_RECORDS = 5;

    public function throttleRequest(): AdminCollection
    {
        $admins = RateLimiter::attempt(self::THROTTLE_KEY, self::THROTTLE_ATTEMPTS, function () {
            return Admin::latest()->cursorPaginate(Admin::PER_PAGE);
        });

        if ($admins) {
            return new AdminCollection($admins);
        }

        return new AdminCollection(Admin::latest()->take(self::THROTTLED_OUTPUT_RECORDS)->get());
    }

    /**
     * Store admin in database.
     *
     * @param ValidatedInput $admin
     * @return AdminResource
     */
    public function store(ValidatedInput $admin): AdminResource
    {
        $admin->password = Hash::make($admin->password);

        $role = AdminRole::where('role', $admin->role)->first();

        unset($admin->role);

        $admin = Admin::create($admin->toArray());
        $admin->roles()->attach($role->id);
        $admin->refresh();

        return new AdminResource($admin);
    }

    /**
     * Update admin
     *
     * @param ValidatedInput $newAdmin
     * @param Admin $admin
     * @return AdminResource
     */
    public function update(ValidatedInput $newAdmin, Admin $admin): AdminResource
    {
        if (isset($newAdmin->password)) {
            $newAdmin->password = Hash::make($newAdmin->password);
        }

        if (isset($newAdmin->role)) {
            $role = $newAdmin->role;

            $newAdminRole = AdminRole::where('role', $role)->first();
            $admin->roles()->syncWithoutDetaching([$newAdminRole->id]);
            $admin->refresh();

            unset($newAdmin->role);
        };

        $admin->fill($newAdmin->toArray());
        $admin->save();

        return new AdminResource($admin);
    }

    public function delete(Admin $admin): void
    {
        // REVIEW: If in pivot table cascadeOnDelete dont need to detach
        // DB::transaction(function () use ($admin) {
        //     $admin->roles()->detach();
        //     $admin->delete();
        // });
        auth('admin')->user()->tokens()->delete();

        $admin->delete();
    }

    public function getIdsForDeletionFromCacheUsing(string $deleteKey): array|bool
    {
        Redis::command('persist', [self::ADMIN_CACHE_KEY]);

        $cache = Redis::get(self::ADMIN_CACHE_KEY);
        $ids = json_decode($cache, true);

        if (isset($ids['key']) && $ids['key'] === $deleteKey) {
            return $ids['ids'];
        }

        return false;
    }

    public function clearCache(): void
    {
        Redis::command('del', [self::ADMIN_CACHE_KEY]);
    }

    /**
     * Returns tuple that consists of true and bus id for deleted admin report or false if cant delete admins
     *
     * @param string $key
     * @return boolean|array<int, \Illuminate\Bus\Batch>
     */
    public function deleteAdmins(string $key): bool|array
    {
        $ids = $this->getIdsForDeletionFromCacheUsing($key);
        $jobBatch = [];

        if ($ids) {
            DB::transaction(function () use ($ids, $key, &$jobBatch) {
                Admin::whereIn('id', $ids)->lazyById()->each(function (Admin $admin) use ($key, &$jobBatch) {
                    $this->delete($admin);

                    $jobBatch = [...$jobBatch, new ProcessDeleteAdmins($admin, $key)];

                    // REVIEW: For dispatching jobs within database transaction use after commit to dispatch job after transaction is finished
                    // dispatch(new ProcessDeleteAdmins($admin, $key))->afterCommit();
                    // ProcessDeleteAdmins::dispatch(
                    //     $id,
                    //     $key,
                    // )->afterCommit();
                });
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

            return $busId;
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


    public function cacheFull(): bool
    {
        $cache = Redis::get(self::ADMIN_CACHE_KEY);

        if ($cache) {
            return true;
        }

        return false;
    }

    function login(ValidatedInput $adminData): string|bool
    {
        $admin = Admin::where('email', $adminData->email)->first();

        if ($admin && Hash::check($adminData->password, $admin->password)) {
            $tokenName = Str::uuid();

            $token = $admin->createToken($tokenName, ['admin:create', 'admin:update', 'admin:delete'])->plainTextToken;

            return $token;
        }

        return false;
    }

    function logout(mixed $user): void
    {
        $user->currentAccessToken()->delete();
    }
}
