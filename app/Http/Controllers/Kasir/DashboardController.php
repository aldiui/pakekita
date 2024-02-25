<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('kasir.dashboard.index');
    }
}
