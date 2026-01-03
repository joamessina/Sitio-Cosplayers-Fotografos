<?php

namespace App\Http\Controllers\Fotografo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    public function index()
    {
        return view('fotografo.albums.index');
    }

    public function create()
    {
        return view('fotografo.albums.create');
    }

    public function store(Request $request)
    {
        // MVP: después guardamos en tabla albums
        return redirect()->route('fotografo.albums.index')->with('status', 'Álbum creado (MVP)');
    }

    public function edit($album)
    {
        return view('fotografo.albums.edit', compact('album'));
    }

    public function update(Request $request, $album)
    {
        return redirect()->route('fotografo.albums.index')->with('status', 'Álbum actualizado (MVP)');
    }

    public function destroy($album)
    {
        return redirect()->route('fotografo.albums.index')->with('status', 'Álbum eliminado (MVP)');
    }
}
