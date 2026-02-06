<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        // Últimos 6 álbumes públicos
        $latestAlbums = Album::where('is_public', true)
            ->with('user.photographerProfile')
            ->latest()
            ->take(6)
            ->get();

        // Total de fotógrafos
        $totalFotografos = User::where('role', 'fotografo')->count();

        // Total de álbumes públicos
        $totalAlbums = Album::where('is_public', true)->count();

        return view('welcome', compact('latestAlbums', 'totalFotografos', 'totalAlbums'));
    }
}