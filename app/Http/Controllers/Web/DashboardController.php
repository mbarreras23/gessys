<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Spatie\RouteAttributes\Attributes\Route;

class DashboardController extends Controller
{
    #[Route("GET", "/", "welcome")]
    public function welcome()
    {
        return view("welcome");
    }
}
