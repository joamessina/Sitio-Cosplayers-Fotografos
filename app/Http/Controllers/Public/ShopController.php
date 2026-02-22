<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\ShopItem;

class ShopController extends Controller
{
    public function index()
    {
        $items = ShopItem::with('user.photographerProfile', 'user.cosplayerProfile')
            ->whereIn('status', ['active', 'sold'])
            ->latest()
            ->paginate(12);

        return view('public.shop.index', compact('items'));
    }

    public function show(ShopItem $shopItem)
    {
        if ($shopItem->status === 'inactive') {
            abort(404);
        }

        $shopItem->load('user.photographerProfile', 'user.cosplayerProfile');

        return view('public.shop.show', compact('shopItem'));
    }
}
