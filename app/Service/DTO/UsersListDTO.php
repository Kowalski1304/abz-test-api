<?php

namespace App\Service\DTO;

use App\Models\User;

class UsersListDTO
{
    /**
     * @param $request
     * @return array
     */
    public function prepareOffsetPagesData($request) :array
    {
        return [
            'page'  => intval($request->page),
            'lastPage' => null,
            'count' => $request->count,
            'next_url' => null,
            'prev_url' => null,
        ];
    }

    /**
     * @param $request
     * @param $users
     * @return array
     */
    public function preparePagesData($request, $users) :array
    {
        return [
            'page'  => intval($request->page),
            'lastPage' => $users->lastPage(),
            'count' => $request->count,
            'next_url' => $users->nextPageUrl(),
            'prev_url' => $users->previousPageUrl(),
        ];
    }

    /**
     * @param $user
     * @return array
     */
    public function prepareUsersData($user) :array
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'position' => $user->position->name,
            'position_id' => $user->position_id,
            'registration_timestamp' => strtotime($user->created_at),
            'photo' => $user->photo,
        ];
    }

    /**
     * @param $data
     * @param $usersPaginate
     * @return array
     */
    public function prepareResponseData($data, $usersPaginate) :array
    {
        return [
            'success' => true,
            'page' => $data['page'],
            'total_pages' => $data['lastPage'],
            'total_users' => User::all()->count(),
            'count' => $data['count'],
            'links' => [
                'next_url' => $data['next_url'],
                'prev_url' => $data['prev_url'],
            ],
            'users' => $usersPaginate,
        ];
    }
}
