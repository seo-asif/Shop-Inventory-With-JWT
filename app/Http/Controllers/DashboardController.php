<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class DashboardController extends Controller
{
    public function dashboardPage(): View
    {
        return view('pages.dashboard.dashboard-page');
    }

    public function profilePage(): View
    {
        return view('pages.dashboard.profile-page');
    }
}
