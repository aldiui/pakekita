<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Traits\ApiResponder;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;

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
                        $editButton = '<button class="btn btn-sm btn-warning me-1" onclick="getSelectEdit(), getModal(`editModal`, `/admin/menu/' . $menu->uuid . '`, [`uuid`,`nama`, `deskripsi`, `harga`, `image`])"><i class="bx bx-edit"></i>Edit</button>';
                        $deleteButton = '<button class="btn btn-sm btn-danger" onclick="confirmDelete(`/admin/menu/' . $menu->uuid . '`, `menu-table`)"><i class="bx bx-trash"></i>Hapus</button>';
                        return $editButton . $deleteButton;
                    })
                    ->addColumn('img', function ($menu) {
                        return '<img src="/storage/image/menu/' . $menu->image . '" width="150px" alt="">';
                    })
                    ->addIndexColumn()
                    ->rawColumns(['aksi', 'img'])
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
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'Data tidak valid.', 422);
        }

        $uuid = Uuid::uuid4()->toString();

        if ($request->hasFile('image')) {
            $image = $request->file('image')->hashName();
            $request->file('image')->storeAs('public/image/menu', $image);
        }

        $menu = Menu::create([
            'uuid' => $uuid,
            'nama' => $request->input('nama'),
            'deskripsi' => $request->input('deskripsi'),
            'harga' => $request->input('harga'),
            'image' => $image ?? null,
        ]);

        return $this->successResponse($menu, 'Data menu ditambahkan.', 201);
    }

    public function show($uuid)
    {
        $menu = Menu::where('uuid', $uuid)->first();

        if (!$menu) {
            return $this->errorResponse(null, 'Data menu tidak ditemukan.', 404);
        }

        return $this->successResponse($menu, 'Data menu ditemukan.');
    }

    public function update(Request $request, $uuid)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'harga' => 'required|numeric',
            'image' => 'image|mimes:png,jpg,jpeg',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'Data tidak valid.', 422);
        }

        $menu = Menu::where('uuid', $uuid)->first();

        if (!$menu) {
            return $this->errorResponse(null, 'Data menu tidak ditemukan.', 404);
        }

        $updateMenu = [
            'nama' => $request->input('nama'),
            'deskripsi' => $request->input('deskripsi'),
            'harga' => $request->input('harga'),
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

    public function destroy($uuid)
    {
        $menu = Menu::where('uuid', $uuid)->first();

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
