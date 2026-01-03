<?php

namespace App\Http\Controllers\Fotografo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('fotografo.perfil.edit');
    }

    public function update(Request $request)
    {
        // MVP: después guardamos PhotographerProfile
        return redirect()->route('fotografo.perfil.edit')->with('status', 'Perfil actualizado (MVP)');
    }
}
