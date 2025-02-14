<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Route;

class MeController extends Controller
{
    #[Route("GET", "me", "me")]
    public function me()
    {
        return auth()->user();
    }
}
