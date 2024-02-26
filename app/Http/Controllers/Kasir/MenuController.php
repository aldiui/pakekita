<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    use ApiResponder;

    public function index(Request $request)
    {
        $menus = Menu::with(['kategori'])->paginate(8);

        if ($request->ajax()) {
            return view('kasir.menu.data', compact('menus'))->render();
        }

        return view('kasir.menu.index', compact('menus'));
    }

}