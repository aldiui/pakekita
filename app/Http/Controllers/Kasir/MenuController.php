<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $menus = Menu::with(['kategori'])->paginate(12);

        if ($request->ajax()) {
            return view('kasir.menu.data', compact('menus'));
        }

        return view('kasir.menu.index', compact('menus'));
    }
}
