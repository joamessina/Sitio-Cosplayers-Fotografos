<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\ShopItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ShopItemController extends Controller
{
    public function index()
    {
        $items = auth()->user()->shopItems()
            ->latest()
            ->paginate(12);

        return view('shop.index', compact('items'));
    }

    public function create()
    {
        return view('shop.create');
    }

    public function store(Request $request)
    {
        // Si PHP rechazó el request por post_max_size, $_FILES y $_POST quedan vacíos
        if (
            $request->server('CONTENT_LENGTH') > 0 &&
            empty($_FILES) && empty($_POST)
        ) {
            return back()->withErrors(['photos' => 'El total de archivos supera el límite permitido. Intentá con menos fotos o de menor tamaño.']);
        }

        $validated = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'price'       => ['required', 'numeric', 'min:0', 'max:9999999'],
            'instagram'   => ['nullable', 'string', 'max:100', 'regex:/^[a-zA-Z0-9._]+$/'],
            'photos'      => ['nullable', 'array', 'max:10'],
            'photos.*'    => ['image', 'mimes:jpeg,png,jpg,webp', 'max:51200'],
        ], [
            'title.required'      => 'El título es obligatorio',
            'title.max'           => 'El título no puede superar los 255 caracteres',
            'description.max'     => 'La descripción no puede superar los 2000 caracteres',
            'price.required'      => 'El precio es obligatorio',
            'price.numeric'       => 'El precio debe ser un número',
            'price.min'           => 'El precio no puede ser negativo',
            'instagram.regex'     => 'El handle de Instagram solo puede tener letras, números, puntos y guiones bajos',
            'photos.max'          => 'Podés subir hasta 10 fotos',
            'photos.*.image'      => 'Todos los archivos deben ser imágenes',
            'photos.*.mimes'      => 'Las imágenes deben ser JPG, PNG o WEBP',
            'photos.*.max'        => 'Cada imagen no puede superar los 50MB',
        ]);

        $photoPaths = [];
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $photoPaths[] = $photo->store('shop-items', 'public');
            }
        }

        ShopItem::create([
            'user_id'     => auth()->id(),
            'title'       => $validated['title'],
            'description' => $validated['description'] ?? null,
            'price'       => $validated['price'],
            'instagram'   => $validated['instagram'] ?? null,
            'photos'      => $photoPaths ?: null,
            'status'      => 'active',
        ]);

        return redirect()
            ->route('mi-shop.index')
            ->with('status', '¡Publicación creada exitosamente!');
    }

    public function edit(ShopItem $shopItem)
    {
        if ($shopItem->user_id !== auth()->id()) {
            abort(403);
        }

        return view('shop.edit', compact('shopItem'));
    }

    public function update(Request $request, ShopItem $shopItem)
    {
        if ($shopItem->user_id !== auth()->id()) {
            abort(403);
        }

        if (
            $request->server('CONTENT_LENGTH') > 0 &&
            empty($_FILES) && empty($_POST)
        ) {
            return back()->withErrors(['new_photos' => 'El total de archivos supera el límite permitido. Intentá con menos fotos o de menor tamaño.']);
        }

        $validated = $request->validate([
            'title'        => ['required', 'string', 'max:255'],
            'description'  => ['nullable', 'string', 'max:2000'],
            'price'        => ['required', 'numeric', 'min:0', 'max:9999999'],
            'instagram'    => ['nullable', 'string', 'max:100', 'regex:/^[a-zA-Z0-9._]+$/'],
            'status'       => ['required', 'in:active,sold,inactive'],
            'new_photos'   => ['nullable', 'array'],
            'new_photos.*' => ['image', 'mimes:jpeg,png,jpg,webp', 'max:51200'],
            'remove_photos'=> ['nullable', 'array'],
        ], [
            'title.required'      => 'El título es obligatorio',
            'title.max'           => 'El título no puede superar los 255 caracteres',
            'description.max'     => 'La descripción no puede superar los 2000 caracteres',
            'price.required'      => 'El precio es obligatorio',
            'price.numeric'       => 'El precio debe ser un número',
            'price.min'           => 'El precio no puede ser negativo',
            'status.required'     => 'El estado es obligatorio',
            'status.in'           => 'Estado inválido',
            'instagram.regex'     => 'El handle de Instagram solo puede tener letras, números, puntos y guiones bajos',
            'new_photos.*.image'  => 'Todos los archivos deben ser imágenes',
            'new_photos.*.mimes'  => 'Las imágenes deben ser JPG, PNG o WEBP',
            'new_photos.*.max'    => 'Cada imagen no puede superar los 50MB',
        ]);

        $currentPhotos = $shopItem->photos ?? [];

        // Eliminar fotos marcadas
        $removePhotos = $request->input('remove_photos', []);
        foreach ($removePhotos as $path) {
            if (in_array($path, $currentPhotos)) {
                Storage::disk('public')->delete($path);
                $currentPhotos = array_values(array_filter($currentPhotos, fn($p) => $p !== $path));
            }
        }

        // Agregar fotos nuevas
        if ($request->hasFile('new_photos')) {
            foreach ($request->file('new_photos') as $photo) {
                if (count($currentPhotos) >= 10) break;
                $currentPhotos[] = $photo->store('shop-items', 'public');
            }
        }

        $shopItem->update([
            'title'       => $validated['title'],
            'description' => $validated['description'] ?? null,
            'price'       => $validated['price'],
            'instagram'   => $validated['instagram'] ?? null,
            'status'      => $validated['status'],
            'photos'      => count($currentPhotos) ? array_values($currentPhotos) : null,
        ]);

        return redirect()
            ->route('mi-shop.index')
            ->with('status', 'Publicación actualizada correctamente');
    }

    public function destroy(ShopItem $shopItem)
    {
        if ($shopItem->user_id !== auth()->id()) {
            abort(403);
        }

        // Borrar fotos del storage
        foreach ($shopItem->photos ?? [] as $path) {
            Storage::disk('public')->delete($path);
        }

        $shopItem->delete();

        return redirect()
            ->route('mi-shop.index')
            ->with('status', 'Publicación eliminada');
    }
}
