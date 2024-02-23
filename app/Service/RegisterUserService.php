<?php

namespace App\Service;

use App\Http\Requests\Register\RegisterRequest;
use App\Models\Token;
use App\Models\User;
use App\Service\DTO\RegisterUserDTO;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Tinify\Tinify;

class RegisterUserService
{
    protected $dto;

    public function __construct()
    {
        $this->dto = resolve(RegisterUserDTO::class);
    }

    /**
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function store(RegisterRequest $request): JsonResponse
    {
        if (!$this->tokenVerification($request)) {
            return response()->json([
                'success' => false,
                'message' => 'The token expired.',
            ], 401);
        }

        try {
            $photo = $this->coverAndOptimizeImages($request->file('photo'));

            $user = User::create($this->dto->prepareUsersData($request, $photo));

            Auth::login($user);

            Token::where('token', $request->token)->delete();

            return response()->json([
                'success' => true,
                'user_id' => $user->id,
                'message' => 'New user successfully registered',
            ], 200);

        } catch (UniqueConstraintViolationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'User with this phone or email already exist'
            ], 409);
        }
    }

    /**
     * @param $photo
     * @return string
     */
    private function coverAndOptimizeImages($photo): string
    {
        $pathImages = base_path('images\users\\');
        $name = $pathImages . \Illuminate\Support\Str::random(15) . ".jpg";

        $manager = new ImageManager(Driver::class);
        $manager->read($photo)
            ->crop(70, 70, position: 'center')
            ->save($name);

        Tinify::setKey(env('TINIFY_API_KEY'));
        \Tinify\fromFile($name)->toFile($name);

        return $name;
    }

    /**
     * @param $request
     * @return bool
     */
    private function tokenVerification($request): bool
    {
        $token = Token::whereRaw('BINARY token = ?', [$request->token])->first();
        if (!empty($token)) {
            return $token->created_at
                    ->diffInMinutes(Carbon::now()) <= 40;
        }

        return false;
    }
}
