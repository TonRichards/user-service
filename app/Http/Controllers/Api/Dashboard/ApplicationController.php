<?php

namespace App\Http\Controllers\Api\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\ApplicationService;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApplicationResource;
use App\Http\Requests\ApplicationStoreRequest;

class ApplicationController extends Controller
{
    public function __construct(protected ApplicationService $applicationService) {}

    public function store(ApplicationStoreRequest $request): JsonResponse
    {
        $application = $this->applicationService->store($request->validated());

        return response()->created(new ApplicationResource($application));
    }
}
