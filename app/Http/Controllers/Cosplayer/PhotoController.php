<?php

namespace App\Http\Controllers\Cosplayer;

use App\Http\Controllers\Controller;
use App\Models\CosplayerPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;



class PhotoController extends Controller
{
public function index()
{
    $user = auth()->user();

    $photos = $user->photos()
        ->latest()
        ->paginate(12);

    return view('cosplayer.photos.index', compact('photos'));
}




    public function store(Request $request)
    {
        $data = $request->validate([
    'photo' => ['required', 'image', 'max:5120'],
    'caption' => ['nullable', 'string', 'max:120'],
], [
    'photo.required' => 'Tenés que seleccionar una foto.',
    'photo.image' => 'El archivo debe ser una imagen válida (JPG/PNG/WebP, etc).',
    'photo.max' => 'La foto no puede superar los 5MB.',
    'caption.max' => 'La descripción no puede superar los 120 caracteres.',
]);


        $path = $request->file('photo')->store('cosplayers/' . auth()->id(), 'public');

        CosplayerPhoto::create([
            'user_id' => auth()->id(),
            'path' => $path,
            'caption' => $data['caption'] ?? null,
        ]);

        return redirect()->route('cosplayer.fotos.index')->with('status', 'Foto subida ✅');
    }

    public function destroy(CosplayerPhoto $photo)
    {
        abort_unless($photo->user_id === auth()->id(), 403);

        Storage::disk('public')->delete($photo->path);
        $photo->delete();

        return redirect()->route('cosplayer.fotos.index')->with('status', 'Foto eliminada ✅');
    }
}
