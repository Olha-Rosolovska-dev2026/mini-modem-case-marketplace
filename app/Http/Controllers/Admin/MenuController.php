<?php

/*
 * Developer: Olha Rosolovska
 * Project: Mini Modem Case - CMS & Marketplace
 * File: Admin navigation menu controller
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MenuController extends Controller
{
    public function index()
    {
        return view('admin.menus.index', [
            'menus' => Menu::with('rootItems.children')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'location' => ['required', 'in:header,footer,sidebar'],
        ]);
        $data['slug'] = Str::slug($data['name']);

        Menu::create($data);

        return back()->with('status', 'Menu created.');
    }

    public function storeItem(Request $request, Menu $menu)
    {
        $data = $request->validate([
            'label' => ['required', 'string', 'max:120'],
            'url' => ['required', 'string', 'max:255'],
            'parent_id' => ['nullable', 'exists:menu_items,id'],
            'target' => ['required', 'in:_self,_blank'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        $menu->items()->create($data + ['sort_order' => $data['sort_order'] ?? 0]);

        return back()->with('status', 'Menu item added.');
    }

    public function destroyItem(MenuItem $item)
    {
        $item->delete();

        return back()->with('status', 'Menu item removed.');
    }
}
