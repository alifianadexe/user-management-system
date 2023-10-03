<?php

namespace App\Http\Controllers;

// use App\Http\Requests\RegisterRequest;
use App\Models\User;
use DateTime;

class RegisterController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store()
    {
        $attributes = request()->validate([
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|confirmed|min:8|max:255',
            'firstname' => 'required',
            'lastname' => 'required',
            'phone_number' => 'required|min:12|max:255',
        ]);

        // Set Attribute Default
        $attributes['status'] = "pending";
        $attributes['create_at'] = date('Y-m-d H:i:s');
        $attributes['ownership'] = "user";

        $user = User::create($attributes);

        auth()->login($user);

        return redirect('/dashboard');
    }
}
