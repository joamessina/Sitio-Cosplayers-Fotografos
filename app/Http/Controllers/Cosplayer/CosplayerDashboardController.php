<?php


namespace App\Http\Controllers\Cosplayer;

use App\Http\Controllers\Controller;
use App\Models\CosplayerPhoto;

class CosplayerDashboardController extends Controller
{
    public function index()
    {
        $photosCount = CosplayerPhoto::where('user_id', auth()->id())->count();

        $latestPhotos = CosplayerPhoto::where('user_id', auth()->id())
            ->latest()
            ->take(8)
            ->get();

        return view('cosplayer.dashboard', compact('photosCount', 'latestPhotos'));
    }
}
