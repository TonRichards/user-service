<?php

namespace App\Http\Controllers\Api\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\ApplicationService;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApplicationResource;
use App\Http\Resources\ApplicationCollection;
use App\Http\Requests\ApplicationStoreRequest;
use App\Http\Requests\ApplicationUpdateRequest;

class ApplicationController extends Controller
{
    public function __construct(protected ApplicationService $applicationService) {}

    public function store(ApplicationStoreRequest $request): JsonResponse
    {
        $application = $this->applicationService->store($request->validated());

        return response()->created(new ApplicationResource($application));
    }

    public function index(Request $request): JsonResponse
    {
        $applications = $this->applicationService->getApplications();

        return response()->success(new ApplicationCollection($applications));
    }

    public function show(Request $request, $id): JsonResponse
    {
        $application = $this->applicationService->getById($id);

        return response()->success(new ApplicationResource($application));
    }

    public function update(ApplicationUpdateRequest $request, $id): JsonResponse
    {
        $application = $this->applicationService->update($request->validated(), $id);

        return response()->success(new ApplicationResource($application));
    }

    public function destroy($id): JsonResponse
    {
        $application = $this->applicationService->delete($id);

        return response()->success();
    }
}