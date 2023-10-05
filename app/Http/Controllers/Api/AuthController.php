<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\SendCodeMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {

            $validateUser = Validator::make($request->all(),
                [
                    'name' => 'required',
                    'email' => 'required|email|unique:users,email',
                    'password' => 'required'
                ]);

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            return response()->json([
                'status' => true,
                'message' => 'User Created Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function login(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(),
                [
                    'email' => 'required|email',
                    'password' => 'required'
                ]);

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            if (!Auth::attempt($request->only(['email', 'password']))) {
                return response()->json([
                    'status' => false,
                    'message' => 'Email & Password does not match with our record.',
                ],401);
            }

            $user = User::where('email', $request->email)->first();

            return response()->json([
                'status' => true,
                'message' => 'User Logged In Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function forget_password(Request $request)
    {
        $data = Validator::make($request->all(), [
           'email' => 'required|email'
        ]);
        $email = $data->validated();

        $user = User::where('email', $email['email'])->first();

        if ($user) {
            $code =mt_rand(1000, 9999);
            $user->code = $code;
            $user->save();

            Mail::to($user->email)->send(new SendCodeMail($user->code));

            return response()->json([
                'message' => true,
                'info' => 'Проверьте свой e-mail'
            ]);
        } else {
            return response()->json([
                'message' => false,
                'info' => 'Неверный e-mail'
            ]);
        }
    }

    public function check_code(Request $request)
    {
        $data = Validator::make($request->all(), [
            'code' => 'required|integer',
            'email' => 'required|email'
        ]);
        $code = $data->validated();

        $user = User::where([
            ['code', $code['code']],
            ['email', $code['email']]
        ])->first();

        if ($user) {
            return response()->json([
                'message' => true
            ]);
        } else {
            return response()->json([
                'message' => false,
            ]);
        }
    }

    public function change_password(Request $request)
    {
        $data = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'string'
        ]);

        $password = $data->validated();

        $user = User::where('email', $password['email'])->first();
        if ($user) {
            $user->password = Hash::make($password['password']);
            $user->save();

            return response()->json([
                'message' => true,
                'info' => 'Пароль успешно изменен!',
            ]);
        } else {
            return response()->json([
                'message' => false,
                'info' => 'Неверный e-mail'
            ]);
        }
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();

            return response()->json([
                'status' => true,
                'message' => 'User Logged Out Successfully',
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }


}
