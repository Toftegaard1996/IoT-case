<?php

namespace App\Http\Controllers;

use App\Models\office;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        return Inertia::render('Dashboard', [
            'data' => office::whereDate('measured_at' == date('Y-m-d'))->get()
        ]);
    }
}
