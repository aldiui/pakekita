<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use ApiResponder;

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = User::all();
            if ($request->input("mode") == "datatable") {
                return DataTables::of($users)
                    ->addColumn('aksi', function ($user) {
                        $editButton = '<button class="btn btn-sm btn-warning me-1" onclick="getSelectEdit(), getModal(`editModal`, `/admin/barang/' . $user->id . '`, [`id`, ,`kategori_id`,`unit_id`,`nama`, `deskripsi`, `qty`, `image`])"><i class="bx bx-edit"></i>Edit</button>';
                        $deleteButton = '<button class="btn btn-sm btn-danger" onclick="confirmDelete(`/admin/barang/' . $user->id . '`, `barang-table`)"><i class="bx bx-trash"></i>Hapus</button>';
                        return $editButton . $deleteButton;
                    })
                    ->addColumn('img', function ($user) {
                        return '<img src="/storage/image/user/' . $user->image . '" width="150px" alt="">';
                    })
                    ->addIndexColumn()
                    ->rawColumns(['aksi', 'img'])
                    ->make(true);
            }

            return $this->successResponse($users, 'Data user ditemukan.');
        }

        return view('admin.user.index'); 
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'qty' => 'required|numeric',
            'kategori_id' => 'required|exists:kategoris,id',
            'unit_id' => 'required|exists:units,id',
            'image' => 'image|mimes:png,jpg,jpeg',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'Data tidak valid.', 422);
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image')->hashName();
            $request->file('image')->storeAs('public/image/user', $image);
        }

        $user = User::create([
            'nama' => $request->input('nama'),
            'kategori_id' => $request->input('kategori_id'),
            'unit_id' => $request->input('unit_id'),
            'deskripsi' => $request->input('deskripsi'),
            'qty' => $request->input('qty'),
            'image' => $image ?? null,
        ]);

        return $this->successResponse($user, 'Data user ditambahkan.', 201);
    }

    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return $this->errorResponse(null, 'Data user tidak ditemukan.', 404);
        }

        return $this->successResponse($user, 'Data user ditemukan.');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'qty' => 'required|numeric',
            'kategori_id' => 'required|exists:kategoris,id',
            'unit_id' => 'required|exists:units,id',
            'image' => 'image|mimes:png,jpg,jpeg',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'Data tidak valid.', 422);
        }

        $user = User::find($id);

        if (!$user) {
            return $this->errorResponse(null, 'Data user tidak ditemukan.', 404);
        }

        $updateBarang = [
            'nama' => $request->input('nama'),
            'kategori_id' => $request->input('kategori_id'),
            'unit_id' => $request->input('unit_id'),
            'deskripsi' => $request->input('deskripsi'),
            'qty' => $request->input('qty'),
        ];

        if ($request->hasFile('image')) {
            if (Storage::exists('public/image/user/' . $user->image)) {
                Storage::delete('public/image/user/' . $user->image);
            }
            $image = $request->file('image')->hashName();
            $request->file('image')->storeAs('public/image/user', $image);
            $updateBarang['image'] = $image;
        }

        $user->update($updateBarang);

        return $this->successResponse($user, 'Data user diubah.');
    }

    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return $this->errorResponse(null, 'Data user tidak ditemukan.', 404);
        }

        if (Storage::exists('public/image/user/' . $user->image)) {
            Storage::delete('public/image/user/' . $user->image);
        }

        $user->delete();

        return $this->successResponse(null, 'Data user dihapus.');
    }

}