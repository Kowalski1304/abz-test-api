<?php

namespace App\Service\DTO;

class UserIndexDTO
{

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
}
