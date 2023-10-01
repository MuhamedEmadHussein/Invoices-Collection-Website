<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    //
    use AuthenticatesUsers;
    use AuthenticatesUsers;

    protected function authenticated(Request $request, $user)
    {
        
        if ($user->Status !== 'مفعل') {
            auth()->logout(); 
            session()->flash('Not Verified', 'الحساب غير مفعل');
            return redirect()->route('login');
        }
        return redirect()->route('index');
    }

}