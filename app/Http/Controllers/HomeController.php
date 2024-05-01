<?php

namespace App\Http\Controllers;

use App\Models\Meja;
use App\Models\Menu;
use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

class HomeController extends Controller
{

    public function index(Request $request)
    {
        Config::set('app.name', 'Absensi');

        $query = Menu::with(['kategori']);

        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('nama', 'like', '%' . $searchTerm . '%')
                    ->orWhere('harga_jual', 'like', '%' . $searchTerm . '%');
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
        $meja = Meja::all();

        if ($request->ajax()) {
            return view('home.data', compact('menus'))->render();
        }

        return view('home.index', compact('menus', 'kategori', 'meja'));
    }
}