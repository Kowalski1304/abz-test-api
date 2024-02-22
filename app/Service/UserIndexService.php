<?php

namespace App\Service;

use App\Models\User;
use App\Service\DTO\UserIndexDTO;
use Illuminate\Http\JsonResponse;

class UserIndexService
{
    protected $dto;

    public function __construct()
    {
        $this->dto = resolve(UserIndexDTO::class);
    }

    /**
     * @param $request
     * @return JsonResponse
     */
    public function index($request) :JsonResponse
    {
        $query = User::orderBy('created_at');

        if ($request->offset !== null) {
            $users = $query->offset($request->offset)
                ->limit($request->count)
                ->get();
        }

        if ($request->offset == null) {
            $users = $query->paginate($request->count, ['*'], 'page', $request->page);

            if ($users->lastPage() < $request->page) {
                return response()->json([
                    'success' => false,
                    'message' => 'Page not found',
                ], 404);
            }

            $data['page'] = intval($request->page);
            $data['lastPage'] = $users->lastPage();
            $data['next_url'] = $users->nextPageUrl();
            $data['prev_url'] = $users->previousPageUrl();
        }

        $users_transform = $users->map(function ($user) {
            return $this->dto->prepareUsersData($user);
        });

        return response()->json([
            'success' => true,
            'page' => $data['page'] ?? null,
            'total_pages' => $data['lastPage'] ?? null,
            'total_users' => User::all()->count(),
            'count' => $request->count,
            'links' => [
                'next_url' => $data['next_url'] ?? null,
                'prev_url' => $data['prev_url'] ?? null,
            ],
            'users' => $users_transform,
        ], 200);
    }
}
