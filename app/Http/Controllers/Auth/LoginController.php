<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\RouteAttributes\Attributes\Route;

class LoginController extends Controller
{
    #[Route("GET", "login", "login", ["guest"])]
    public function loginView()
    {
        return view("auth.login");
    }

    #[Route("POST", "login", "authenticate")]
    public function login(LoginRequest $request)
    {
        $user = User::findUser($request->email)->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'La cuenta esta inactiva o el correo no esta registrado.',
            ])->onlyInput('email');
        }

        $credentials = $request->only(["email", "password"]);

        if (!Auth::attempt($credentials)) {
            return back()->withErrors([
                'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
            ])->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->intended("/");
    }

    #[Route("POST", "logout", "logout")]
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect("/");
    }
}
