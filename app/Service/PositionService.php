<?php

namespace App\Service;

use App\Models\Position;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class PositionService
{
    /**
     * @return JsonResponse
     */
    public function index() :JsonResponse
    {
        try {
            $position = Position::all('id', 'name');

            return response()->json([
                'success' => true,
                'position' => $position,
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Positions not found'
            ], 422);
        }
    }
}
