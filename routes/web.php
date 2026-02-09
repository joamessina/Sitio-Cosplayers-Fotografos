<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Public\FotografoController;
use App\Http\Controllers\Fotografo\FotografoDashboardController;
use App\Http\Controllers\Fotografo\AlbumController;
use App\Http\Controllers\Fotografo\ProfileController;
use App\Http\Controllers\Cosplayer\CosplayerDashboardController;
use App\Http\Controllers\Cosplayer\PhotoController;
use App\Http\Controllers\Cosplayer\CosplayerProfileController;
use App\Http\Controllers\Public\PublicAlbumController;
use App\Http\Controllers\Public\AlbumPublicController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Public\PortfolioController;


Route::get('/', [HomeController::class, 'index'])->name('home');


Route::get('/dashboard', function () {
    $role = auth()->user()->role;

    return $role === 'fotografo'
        ? redirect()->route('fotografo.dashboard')
        : redirect()->route('cosplayer.dashboard');
})->middleware(['auth'])->name('dashboard');



/**
 * Sección Fotógrafo
 */
Route::middleware(['auth', 'role:fotografo'])
    ->prefix('fotografo')
    ->name('fotografo.')
    ->group(function () {
        Route::get('/dashboard', [FotografoDashboardController::class, 'index'])->name('dashboard');

        // Perfil fotógrafo
        Route::get('/perfil', [ProfileController::class, 'edit'])->name('perfil.edit');
        Route::post('/perfil', [ProfileController::class, 'update'])->name('perfil.update');

        // Álbumes (MVP)
        Route::get('/albums', [AlbumController::class, 'index'])->name('albums.index');
        Route::get('/albums/create', [AlbumController::class, 'create'])->name('albums.create');
        Route::post('/albums', [AlbumController::class, 'store'])->name('albums.store');
        Route::get('/albums/{album}/edit', [AlbumController::class, 'edit'])->name('albums.edit');
        Route::put('/albums/{album}', [AlbumController::class, 'update'])->name('albums.update');
        Route::delete('/albums/{album}', [AlbumController::class, 'destroy'])->name('albums.destroy');

        
    });

/**
 * Sección Cosplayer
 */
Route::middleware(['auth', 'role:cosplayer'])
    ->prefix('cosplayer')
    ->name('cosplayer.')
    ->group(function () {
        Route::get('/dashboard', [CosplayerDashboardController::class, 'index'])->name('dashboard');

        // Fotos cosplayer (MVP: sube a storage local)
        Route::get('/mis-fotos', [\App\Http\Controllers\Cosplayer\MisFotosController::class, 'index'])->name('fotos.index');
        Route::post('/mis-fotos', [\App\Http\Controllers\Cosplayer\MisFotosController::class, 'store'])->name('fotos.store');
        Route::delete('/mis-fotos/{photo}', [\App\Http\Controllers\Cosplayer\MisFotosController::class, 'destroy'])->name('fotos.destroy');

        // Perfil cosplayer
        Route::get('/perfil', [CosplayerProfileController::class, 'edit'])->name('perfil.edit');
        Route::post('/perfil', [CosplayerProfileController::class, 'update'])->name('perfil.update');
        Route::post('/perfil/fotos', [CosplayerProfileController::class, 'updatePhotos'])->name('perfil.updatePhotos');
    });

/**
 * Público (sin login)
 */


Route::get('/fotografos', [FotografoController::class, 'index'])->name('fotografos.index');
Route::get('/fotografos/{user}', [FotografoController::class, 'show'])->name('fotografos.show');
Route::get('/albumes', [AlbumPublicController::class, 'index'])->name('albumes.index');
Route::get('/albumes', [AlbumPublicController::class, 'index'])->name('albumes.index');
Route::get('/albumes/{album}', [AlbumPublicController::class, 'show'])->name('albumes.show');

Route::get('/@{username}', [PortfolioController::class, 'show'])->name('portfolio.show');

require __DIR__.'/auth.php';
