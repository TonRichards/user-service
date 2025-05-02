<?php

namespace App\Http\Controllers\Api\Option;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Services\SelectOptionService;

class SelectOptionController extends Controller
{
    public function __construct(
        protected SelectOptionService $selectOptionService,
    ) {}

    public function users(Request $request): JsonResponse
    {
        $data = $this->selectOptionService->getUserOptions($request);

        return response()->success(['data' => $data]);
    }

    public function organizations(Request $request): JsonResponse
    {
        $data = $this->selectOptionService->getOrganizationOptions($request);

        return response()->success(['data' => $data]);
    }

    public function roles(Request $request): JsonResponse
    {
        $data = $this->selectOptionService->getRoleOptions($request);

        return response()->success(['data' => $data]);
    }
}
