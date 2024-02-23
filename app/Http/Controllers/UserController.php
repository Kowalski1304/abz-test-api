<?php

namespace App\Http\Controllers;

use App\Service\UsersListService;
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
     * @param UsersListService $service
     * @return JsonResponse
     */
    public function usersList(IndexRequest $request, UsersListService $service) :JsonResponse
    {
        return $service->usersList($request);
    }
}
