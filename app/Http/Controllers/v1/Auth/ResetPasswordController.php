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

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use JWTAuth;
use Validator;

class ResetPasswordController extends Controller
{
    /**
     * Handle reset password
     */
    public function reset(Request $request, string $token): JsonResponse
    {
        if (strlen($token) !== 50) {
            return new JsonResponse([
                'success' => false,
                'message' => "Token not valid."
            ], 500);
        }

        $data = DB::table('password_resets')->where('token', $token)->first();

        if (! $data || now()->diffInDays(Carbon::parse($data->created_at)) <= 2) { // token expired in 2 days or 48 hours
            $inputs = $request->all();

            $validator = Validator::make($inputs, [
                'email' => ['required', 'exists:users', 'email'],
                'password' => ['required', 'string', 'min:6'],
                'confirm_password' => ['required', 'same:password'],
            ]);

            if ($validator->fails()) {
                return new JsonResponse([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 500);
            }

            if ($user = User::where('email', $inputs['email'])->first()) {
                $token = JWTAuth::fromUser($user);

                $user->update([
                    'password' => Hash::make($inputs['password'])
                ]);

                return new JsonResponse([
                    'error' => false,
                    'message' => 'Password reset successfully.',
                    'data' => [
                        'user' => $user,
                        'token' => $token
                    ],
                ], 201);
            }
        }

        return new JsonResponse([
            'success' => false,
            'message' => "Token expired."
        ], 500);
    }
}
