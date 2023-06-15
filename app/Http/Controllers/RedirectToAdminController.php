<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RedirectToAdminController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return redirect(\route('filament.pages.dashboard'));
    }
}
