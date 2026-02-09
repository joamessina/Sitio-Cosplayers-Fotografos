<?php


namespace App\Http\Controllers\Cosplayer;

use App\Http\Controllers\Controller;
use App\Models\Photo;

class CosplayerDashboardController extends Controller
{
    public function index()
    {
        $photosCount = Photo::where('user_id', auth()->id())->count();

        $latestPhotos = Photo::where('user_id', auth()->id())
            ->latest()
            ->take(8)
            ->get();

        return view('cosplayer.dashboard', compact('photosCount', 'latestPhotos'));
    }
}
