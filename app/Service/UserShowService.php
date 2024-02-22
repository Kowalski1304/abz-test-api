<?php

namespace App\Service;

use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class UserShowService
{
    /**
     * @param $request
     * @return JsonResponse
     */
    public function show($request) :JsonResponse
    {
        $validator = Validator::make(['user_id' => $request->user_id], [
            'user_id' => ['required', 'integer'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'fails' => $validator->errors(),
            ], 400);
        }

        try {
            $user = User::findOrFail($request->user_id);

            return response()->json([
                'success' => true,
                'user' => $user,
            ], 200);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'The user with the requested identifier does not exist',
                'fails' => [
                    'user_id' => [
                        'User not found'
                    ],
                ],
            ], 404);
        }
    }
}
