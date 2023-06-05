<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
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
        $this->adminService = $adminService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): AdminCollection
    {
        return new AdminCollection(Admin::latest()->cursorPaginate(Admin::PER_PAGE));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdminRequest $request): AdminResource
    {
        $admin = $this->adminService->store($request->validated());

        return new AdminResource($admin);
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
    public function update(UpdateAdminRequest $request, Admin $admin): AdminResource
    {
        $admin = $this->adminService->update($request->validated(), $admin);

        return new AdminResource($admin);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $admin): Response
    {
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
        $idFound = $this->adminService->deleteAdmins($key);

        if ($idFound) {
            return response('', Response::HTTP_OK);
        }

        return response('', Response::HTTP_NOT_FOUND);
    }
}
