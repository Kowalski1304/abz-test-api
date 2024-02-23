<?php

namespace App\Service;

use App\Models\User;
use App\Service\DTO\UsersListDTO;
use Illuminate\Http\JsonResponse;

class UsersListService
{
    protected $dto;

    public function __construct()
    {
        $this->dto = resolve(UsersListDTO::class);
    }

    /**
     * @param $request
     * @return JsonResponse
     */
    public function usersList($request): JsonResponse
    {
        $query = User::orderBy('created_at');

        if ($request->offset !== null) {
            $users = $query->offset($request->offset)
                ->limit($request->count)
                ->get();

            $data = $this->dto->prepareOffsetPagesData($request);
        }

        if ($request->offset == null) {
            $users = $query->paginate($request->count, ['*'], 'page', $request->page);

            $data = $this->dto->preparePagesData($request, $users);

            if ($users->lastPage() < $request->page) {
                return response()->json([
                    'success' => false,
                    'message' => 'Page not found',
                ], 404);
            }
        }

        $usersPaginate = $users->map(function ($user) {
            return $this->dto->prepareUsersData($user);
        });

        return response()->json([
            $this->dto->prepareResponseData($data, $usersPaginate)
        ], 200);
    }
}
