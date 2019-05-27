<?php

namespace App\Http\Controllers\auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use AuthenticatesUsers;

class AdminLoginController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('guest:admin');
    }

    public function username()
    {
        return 'username';
    }

    public function showLoginForm()
    {
        return view('auth.admin-login');
    }

    public function login(Request $request)
    {
        //validate the form data
        $this->validate($request, 
        [
            'username' => 'required|min:5',
            'password' =>'required|min:6'
        ]);

        //attempt to log user in
        if(Auth::guard('admin')->attempt(['username' => $request->username, 'password' => $request->password], $request->remember))
        {
            //if succesfull then redirect to intended location
            return redirect()->intended(route('admin.dashboard'));
        }
        

        //unsuccesfull redirect back with form data
        return redirect()->back()->withInput($request->only('username','remember'));
    }
}
