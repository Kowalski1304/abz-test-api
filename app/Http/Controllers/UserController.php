<?php

namespace App\Http\Controllers;

use App\Service\UserIndexService;
use App\Service\UserShowService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Requests\User\IndexRequest;

class UserController extends Controller
{

    /**
     * @param Request $request
     * @param UserShowService $service
     * @return JsonResponse
     */
    public function show(Request $request, UserShowService $service) :JsonResponse
    {
        return $service->show($request);
    }

    /**
     * @param IndexRequest $request
     * @param UserIndexService $service
     * @return JsonResponse
     */
    public function index(IndexRequest $request, UserIndexService $service) :JsonResponse
    {
        return $service->index($request);
    }
}
