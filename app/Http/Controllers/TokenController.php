<?php

namespace App\Http\Controllers;

use App\Service\TokenService;
use Illuminate\Http\JsonResponse;

class TokenController extends Controller
{
    /**
     * @param TokenService $service
     * @return JsonResponse
     */
    public function index(TokenService $service) :JsonResponse
    {
        return $service->index();
    }
}
