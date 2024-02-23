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
            $menus = Menu::all();
            if ($request->input("mode") == "datatable") {
                return DataTables::of($menus)
                    ->addColumn('aksi', function ($menu) {
                        $editButton = '<button class="btn btn-sm btn-warning me-1 d-inline-flex" onclick="getSelectEdit(), getModal(`editModal`, `/admin/menu/' . $menu->id . '`, [`id`, `kategori_id`, `nama`, `deskripsi`, `harga`, `image`])"><i class="bI bi-pencil-square me-1"></i>Edit</button>';
                        $deleteButton = '<button class="btn btn-sm btn-danger d-inline-flex" onclick="confirmDelete(`/admin/menu/' . $menu->id . '`, `menu-table`)"><i class="bi bi-trash me-1"></i>Hapus</button>';
                        return $editButton . $deleteButton;
                    })
                    ->addColumn('kategori', function ($barang) {
                        return $barang->load('kategori')->nama;
                    })
                    ->addColumn('img', function ($menu) {
                        return '<img src="/storage/image/menu/' . $menu->image . '" width="150px" alt="">';
                    })
                    ->addColumn('rupiah', function ($menu) {
                        return formatRupiah($menu->harga);
                    })
                    ->addIndexColumn()
                    ->rawColumns(['aksi', 'img', 'kategori', 'rupiah'])
                    ->make(true);
            }

            return $this->successResponse($menus, 'Data menu ditemukan.');
        }

        return view('admin.menu.index');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'harga' => 'required|numeric',
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
            'nama' => $request->input('nama'),
            'deskripsi' => $request->input('deskripsi'),
            'harga' => $request->input('harga'),
            'image' => $image ?? null,
            'kategori_id' => $request->input('kategori_id'),
        ]);

        return $this->successResponse($menu, 'Data menu ditambahkan.', 201);
    }

    public function show($id)
    {
        $menu = Menu::find($id);

        if (!$menu) {
            return $this->errorResponse(null, 'Data menu tidak ditemukan.', 404);
        }

        return $this->successResponse($menu, 'Data menu ditemukan.');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'harga' => 'required|numeric',
            'image' => 'image|mimes:png,jpg,jpeg',
            'kategori_id' => 'required|exists:kategoris,id',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'Data tidak valid.', 422);
        }

        $menu = Menu::find($id);

        if (!$menu) {
            return $this->errorResponse(null, 'Data menu tidak ditemukan.', 404);
        }

        $updateMenu = [
            'nama' => $request->input('nama'),
            'deskripsi' => $request->input('deskripsi'),
            'harga' => $request->input('harga'),
            'kategori_id' => $request->input('kategori_id'),

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

        return $this->successResponse($menu, 'Data menu diubah.');
    }

    public function destroy($id)
    {
        $menu = Menu::find($id);

        if (!$menu) {
            return $this->errorResponse(null, 'Data menu tidak ditemukan.', 404);
        }

        if (Storage::exists('public/image/menu/' . $menu->image)) {
            Storage::delete('public/image/menu/' . $menu->image);
        }

        $menu->delete();

        return $this->successResponse(null, 'Data menu dihapus.');
    }
}