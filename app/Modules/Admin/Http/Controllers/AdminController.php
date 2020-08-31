<?php

namespace App\Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{

        public function login(Request $request)
    {
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required',
                'status' => 'required|numeric',
            ]);
            if (!$validator->fails()) {
                $credentials = $request->only('email', 'password', 'status');
                if (Auth::attempt($credentials)) {
                    return redirect('/admin/dashboard');

                } else {
                    return view('Admin::login', ['error' => 'Wrong Credentials']);
                }
            } else {
                return view('Admin::login', ['error' => 'Email and Password should not be blank']);
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
	
	public function dashboard(Request $request)
    {
        return view('Admin::welcome');
    }
}
