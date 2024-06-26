<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Traits\ApiResponder;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class MenuController extends Controller
{
    use ApiResponder;

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $menus = Menu::with(['kategori'])->get();
            if ($request->mode == "datatable") {
                return DataTables::of($menus)
                    ->addColumn('aksi', function ($menu) {
                        $editButton = '<button class="btn btn-sm btn-warning me-1 d-inline-flex" onclick="getSelectEdit(), getModal(`createModal`, `/admin/menu/' . $menu->id . '`, [`id`, `kategori_id`, `nama`, `deskripsi`, `harga_pokok`, `harga_jual`, `image`])"><i class="bI bi-pencil-square me-1"></i>Edit</button>';
                        $deleteButton = '<button class="btn btn-sm btn-danger d-inline-flex" onclick="confirmDelete(`/admin/menu/' . $menu->id . '`, `menu-table`)"><i class="bi bi-trash me-1"></i>Hapus</button>';
                        return $editButton . $deleteButton;
                    })
                    ->addColumn('kategori', function ($barang) {
                        return $barang->kategori->nama;
                    })
                    ->addColumn('img', function ($menu) {
                        return '<img src="/storage/image/menu/' . $menu->image . '" width="150px" alt="">';
                    })
                    ->addColumn('pokok', function ($menu) {
                        return formatRupiah($menu->harga_pokok);
                    })
                    ->addColumn('jual', function ($menu) {
                        return formatRupiah($menu->harga_jual);
                    })
                    ->addIndexColumn()
                    ->rawColumns(['aksi', 'img', 'kategori', 'pokok', 'jual'])
                    ->make(true);
            }

            return $this->successResponse($menus, 'Data Menu ditemukan.');
        }

        return view('admin.menu.index');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'harga_pokok' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'image' => 'image|mimes:png,jpg,jpeg',
            'kategori_id' => 'required|exists:kategoris,id',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'Data tidak valid.', 422);
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image')->hashName();
            $request->file('image')->storeAs('public/image/menu', $image);
        }

        $menu = Menu::create([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'harga_pokok' => $request->harga_pokok,
            'harga_jual' => $request->harga_jual,
            'image' => $image ?? null,
            'kategori_id' => $request->kategori_id,
        ]);

        return $this->successResponse($menu, 'Data Menu ditambahkan.', 201);
    }

    public function show($id)
    {
        $menu = Menu::find($id);

        if (!$menu) {
            return $this->errorResponse(null, 'Data Menu tidak ditemukan.', 404);
        }

        return $this->successResponse($menu, 'Data Menu ditemukan.');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'harga_pokok' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'image' => 'image|mimes:png,jpg,jpeg',
            'kategori_id' => 'required|exists:kategoris,id',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'Data tidak valid.', 422);
        }

        $menu = Menu::find($id);

        if (!$menu) {
            return $this->errorResponse(null, 'Data Menu tidak ditemukan.', 404);
        }

        $updateMenu = [
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'harga_pokok' => $request->harga_pokok,
            'harga_jual' => $request->harga_jual,
            'kategori_id' => $request->kategori_id,

        ];

        if ($request->hasFile('image')) {
            if (Storage::exists('public/image/menu/' . $menu->image)) {
                Storage::delete('public/image/menu/' . $menu->image);
            }
            $image = $request->file('image')->hashName();
            $request->file('image')->storeAs('public/image/menu', $image);
            $updateMenu['image'] = $image;
        }

        $menu->update($updateMenu);

        return $this->successResponse($menu, 'Data Menu diubah.');
    }

    public function destroy($id)
    {
        $menu = Menu::find($id);

        if (!$menu) {
            return $this->errorResponse(null, 'Data Menu tidak ditemukan.', 404);
        }

        if (Storage::exists('public/image/menu/' . $menu->image)) {
            Storage::delete('public/image/menu/' . $menu->image);
        }

        $menu->delete();

        return $this->successResponse(null, 'Data Menu dihapus.');
    }
}
