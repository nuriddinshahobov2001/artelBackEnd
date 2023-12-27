<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    public function index()
    {
        return view('admin.profile.change_password');
    }

    public function store(PasswordRequest $request)
    {
        $data = $request->validated();

        $user = User::where('id', Auth::id())->first();

        if (Hash::check($data['oldPassword'], $user->password)) {
            $user->update([
                'password' => Hash::make($data['password'])
            ]);

            return redirect()->back()->with('success', 'Пароль был успешно изменен!');
        } else {
            return redirect()->back()->with('error', 'Старый пароль неверен!');
        }
    }
}
