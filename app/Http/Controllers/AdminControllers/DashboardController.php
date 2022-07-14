<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin_dashboard.index');
    }
}
