<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Menu;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    use ApiResponder;

    public function index(Request $request)
    {
        $query = Menu::with(['kategori']);

        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('nama', 'like', '%' . $searchTerm . '%')
                    ->orWhere('harga', 'like', '%' . $searchTerm . '%');
            });

            if ($request->has('kategori') && $request->kategori != 'semua') {
                $query->whereHas('kategori', function ($q) use ($request) {
                    $q->where('nama', $request->kategori);
                });
            }
        } else if ($request->has('kategori') && $request->kategori != 'semua') {
            $query->whereHas('kategori', function ($q) use ($request) {
                $q->where('nama', $request->kategori);
            });
        }

        $menus = $query->paginate(8);
        $kategori = Kategori::where('jenis', 'Menu')->get();

        if ($request->ajax()) {
            return view('kasir.menu.data', compact('menus'))->render();
        }

        return view('kasir.menu.index', compact('menus', 'kategori'));
    }

}
