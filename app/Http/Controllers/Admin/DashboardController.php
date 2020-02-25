<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Spot;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $spot_count = Spot::count();
        $event_count = Event::where('event_type', 'event')->count();
        $promotion_count = Event::where('event_type', 'promotion')->count();
        $competition_count = Event::where('event_type', 'competition')->count();
        $user_count = User::count();
        $users = User::all();
        return view('admin.home', compact('users', 'user_count', 'spot_count', 'event_count', 'promotion_count'));
    }
}
