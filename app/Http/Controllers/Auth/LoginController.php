<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
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
        if (!Auth::attempt($request->except(["_token"]))) {
            return "Las credenciales no coinciden con nuestros registros.";
        }

        $request->session()->regenerate();

        return redirect()->intended("/");
    }
}
