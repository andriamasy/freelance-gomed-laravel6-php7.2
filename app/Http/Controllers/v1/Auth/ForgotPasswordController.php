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

use App\Mail\SendPasswordResetLink;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Mail;
use \Validator;
use Str;
use DB;

class ForgotPasswordController extends Controller
{
    public function forgot(Request $request): JsonResponse
    {
        $inputs = $request->all();

        $validator = Validator::make($inputs, [
            'email' => 'required|email|exists:users'
        ]);

        if ($validator->fails()) {
            return new JsonResponse([
                'success' => false,
                'errors' => $validator->errors()
            ], 500);
        }

        DB::table('password_resets')->where('email', $inputs['email'])->delete();

        DB::table('password_resets')->insert([
            'email' => $inputs['email'],
            'token' => $token = Str::random(50),
            'created_at' => new \DateTime('now')
        ]);

        Mail::to($inputs['email'])->send(new SendPasswordResetLink($token));

        return new JsonResponse([
            'success' => true,
            'message' => "Password reset link sent."
        ]);
    }
}
