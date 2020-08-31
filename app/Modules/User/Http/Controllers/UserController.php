<?php

namespace App\Modules\User\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\User\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function signUp(Request $request)
    {
        if ($request->isMethod('post')) {

            try{
                $user = new User();
                $user->name = $request->name;
                $user->email = $request->email;
                $user->password = Hash::make($request->password);
                $user->status = 1;
                $user->created_at = now();
                $user->updated_at = now();
                $user->save();
                return view('User::signup', ['success' => 'Successfully Sign Up Done']);
            }catch (\Exception $e){
                return view('User::signup', ['error' => 'Email already exist',]);
            }

        }
        return view('User::signup');
    }

    public function login(Request $request)
    {
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required',
            ]);
            if (!$validator->fails()) {
                $credentials = $request->only('email', 'password');
                if (Auth::attempt($credentials)) {
                    return redirect('/user/dashboard');

                } else {
                    return view('User::login', ['error' => 'Wrong Credentials']);
                }
            } else {
                return view('User::login', ['error' => 'Email and Password should not be blank']);
            }
        }
        return view('User::login');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        Session::flush();
        return Redirect::to('/');
    }
}
