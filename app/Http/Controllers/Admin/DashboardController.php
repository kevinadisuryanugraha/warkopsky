<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\CustomerStory;
use App\Models\MenuItem;
use App\Models\GalleryItem;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard homepage with KPIs and quick actions.
     */
    public function index()
    {
        $kpis = [
            'pending_reservations' => Reservation::where('status', 'pending')->count(),
            'pending_stories' => CustomerStory::where('status', 'pending')->count(),
            'total_menus' => MenuItem::count(),
            'total_photos' => GalleryItem::count(),
        ];

        // Recent 5 reservations
        $recentReservations = Reservation::orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Recent 5 pending stories
        $pendingStories = CustomerStory::where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('kpis', 'recentReservations', 'pendingStories'));
    }
}
