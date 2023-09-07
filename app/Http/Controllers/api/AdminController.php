<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\AuthAdminRequest;
use App\Http\Requests\api\QueueAdminForDeletionRequest;
use App\Http\Requests\api\StoreAdminRequest;
use App\Http\Requests\api\UpdateAdminRequest;
use App\Http\Resources\AdminCollection;
use App\Http\Resources\AdminResource;
use App\Models\Admin;
use App\Services\AdminService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class AdminController extends Controller
{
    public function __construct(private AdminService $adminService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): AdminCollection
    {
        $admins = $this->adminService->throttleRequest();

        return $admins;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdminRequest $request): AdminResource
    {
        $admin = $this->adminService->store($request->validated());

        return $admin;
    }

    /**
     * Display the specified resource.
     */
    public function show(Admin $admin): AdminResource
    {
        return new AdminResource($admin);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAdminRequest $request, Admin $admin): AdminResource|Response
    {
        $updatedAdmin = $this->adminService->update($request->validated(), $admin);

        if ($updatedAdmin) {
            return $updatedAdmin;
        }

        return response('', Response::HTTP_SERVICE_UNAVAILABLE);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $admin): Response
    {
        $this->authorize('delete', $admin);

        $this->adminService->delete($admin);

        return response()->noContent();
    }

    public function queueForDeletion(QueueAdminForDeletionRequest $request): Response|JsonResponse
    {
        $key = $this->adminService->storeIdsForDeletion($request->validated('ids'));

        if ($key) {
            return response()->json(['key' => $key])->setStatusCode(Response::HTTP_CREATED);
        }

        return response('', Response::HTTP_SERVICE_UNAVAILABLE);
    }

    public function deleteAdmins(string $key): Response
    {
        $busId = $this->adminService->deleteAdmins($key);

        if ($busId) {
            return response()->json(['bus_id' => $busId])->setStatusCode(Response::HTTP_OK);
        }

        return response('', Response::HTTP_NOT_FOUND);
    }


    function login(AuthAdminRequest $request): JsonResponse
    {
        $token = $this->adminService->login($request->validated());

        if ($token) {
            return response()->json(['token' => $token])->setStatusCode(Response::HTTP_OK);
        }

        // throw new AuthenticationException;
        return response()->json(['message' => 'The provided credentials are incorrect.'])->setStatusCode(Response::HTTP_UNAUTHORIZED);
    }

    function logout(): Response
    {
        $this->adminService->logout();

        return response('', Response::HTTP_OK);
    }
}
