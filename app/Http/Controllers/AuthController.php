<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller{
    
    public function showLogin(){
        return view('auth.login');
    }

    public function login (Request $request){
        $credentials = $request->only('email', 'password');

        Log::info('Intento de login', ['email' => $credentials['email']]);

        if(Auth::attempt($credentials)){
            $request->session()->regenerate();

            Log::info('Login correcto', ['email' => $credentials['email']]);

            return redirect()->intended(route ('dashboard'));
        }

        Log::warning('Login fallido', ['email' => $credentials['email']]);

        return back()->withErrors([
            'email' => 'Credenciales inválidas.'
        ])->onlyInput('email');
    }

    public function logout(Request $request){
        
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}