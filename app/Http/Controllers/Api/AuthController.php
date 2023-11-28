<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\SendCodeMail;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        try {
            $validateUser = Validator::make($request->all(),
                [
                    'name' => 'required',
                    'phone' => 'required|unique:users,phone',
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
                'phone' => $request->phone,
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

    public function login(Request $request): JsonResponse
    {
        try {
            $validateUser = Validator::make($request->all(),
                [
                    'phone' => 'required',
                    'password' => 'required'
                ]);

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            if (!Auth::attempt($request->only(['phone', 'password']))) {
                return response()->json([
                    'status' => false,
                    'message' => 'Телефон или пароль не правильный!',
                ],401);
            }

            $user = User::where('phone', $request->email)->first();

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

    public function forget_password(Request $request): JsonResponse
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

    public function check_code(Request $request): JsonResponse
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

    public function change_password(Request $request): JsonResponse
    {
        $data = Validator::make($request->all(), [
            'email' => 'required|email',
            'code' => 'required',
            'password' => 'required|string|min:6',
        ]);

        if ($data->fails()) {
            return response()->json([
                'message' => false,
                'info' => $data->errors()->first(),
            ]);
        }

        $password = $data->validated();

        $user = User::where('email', $password['email'])->first();

        if (!$user) {
            return response()->json([
                'message' => false,
                'info' => 'Неверный e-mail',
            ]);
        }

        if ($user->code !== $password['code']) {
            return response()->json([
                'message' => false,
                'info' => 'Неверный код',
            ]);
        }

        $user->password = Hash::make($password['password']);
        $user->code = 0;
        $user->save();

        return response()->json([
            'message' => true,
            'info' => 'Пароль успешно изменен!',
        ]);
    }


    public function logout(Request $request): JsonResponse
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
