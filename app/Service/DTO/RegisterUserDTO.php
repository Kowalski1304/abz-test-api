<?php

namespace App\Service\DTO;

use Illuminate\Support\Facades\Hash;

class RegisterUserDTO
{

    /**
     * @param $request
     * @param $photo
     * @return array
     */
    public function prepareUsersData($request, $photo) :array
    {
        return [
            'name'  => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'position_id' => $request->position_id,
            'password'  => Hash::make($request->password),
            'photo'  => $photo,
        ];
    }
}
