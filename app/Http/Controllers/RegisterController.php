<?php

namespace App\Http\Controllers;

use App\Http\Requests\Register\RegisterRequest;
use App\Service\RegisterUserService;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{
    /**
     * @param RegisterRequest $request
     * @param RegisterUserService $service
     * @return JsonResponse
     */
    public function store(RegisterRequest $request, RegisterUserService $service): JsonResponse
    {
        return $service->store($request);
    }
}
