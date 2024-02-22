<?php

namespace App\Service;

use App\Models\Token;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class TokenService
{
    /**
     * @return JsonResponse
     */
    public function index() :JsonResponse
    {
        $token = Str::random(344);

        Token::create([
            'token' => $token,
        ]);

        return response()->json([
            'success' => true,
            'token' => $token,
        ]);
    }
}
