<?php

namespace App\Http\Controllers;

use App\Service\PositionService;
use Illuminate\Http\JsonResponse;

class PositionController extends Controller
{
    /**
     * @param PositionService $service
     * @return JsonResponse
     */
    public function positionsList(PositionService $service) :JsonResponse
    {
        return $service->positionsList();
    }
}
