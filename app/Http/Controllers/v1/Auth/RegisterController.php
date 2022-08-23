<?php
/*
  Authors : Sayna (Rahul Jograna)
  Website : https://sayna.io/
  App Name : Grocery Delivery App
  This App Template Source code is licensed as per the
  terms found in the Website https://sayna.io/license
  Copyright and Good Faith Purchasers © 2021-present Sayna.
*/
namespace App\Http\Controllers\v1\Auth;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Models\ReferralCodes;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\User as UserResource;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Notifications\UserVerifyNotification;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use JWTAuth;
use Str;
use Validator;

class RegisterController extends Controller
{
    /**
     * Register
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function register(Request $request): JsonResponse
    {
        $inputs = $request->all();

        $validator = Validator::make($inputs, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'unique:users', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:6'],
            'confirm_password' => ['required', 'same:password'],
            'cover' => ['required', 'string'],
            'mobile' => ['required', 'numeric', 'unique:users', 'digits:10'],
            'country_code' => ['required', 'string'],
            'lat' => [],
            'lng' => [],
            'gender' => [],
            'verified' => [],
            'type' => [],
            'dob' => [],
            'date' => [],
            'fcm_token' => [],
            'others' => [],
            'stripe_key' => [],
            'extra_field' => [],
            'status' => []
        ]);

        if ($validator->fails()) {
            return new JsonResponse([
                'success' => false,
                'errors' => $validator->errors()
            ], 500);
        }

        try {
            $user = User::create(array_merge(
                $validator->validated(),
                ['password' => Hash::make($inputs['password'])]
            ));

            $token = JWTAuth::fromUser($user);

            ReferralCodes::create(['uid'=>$user->id,'code'=> Str::random(256)]);

            return new JsonResponse([
                'success' => true,
                'message' => 'L\'utilisateur a bien été créé avec succès.',
                'data' => [
                    'user' => $user,
                    'token' => $token
                ],
            ], 201);

        } catch (ValidationException $exception){
            return new JsonResponse([
                'error' => true,
                'message' => $exception->getMessage()
            ], 409);
        }
    }
}
