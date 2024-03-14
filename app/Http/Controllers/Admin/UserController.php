<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ApiResponder;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    use ApiResponder;

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = User::all();
            if ($request->mode == "datatable") {
                return DataTables::of($users)
                    ->addColumn('aksi', function ($user) {
                        $editButton = '<button class="btn btn-sm btn-warning  d-inline-flex me-1" onclick="getModal(`createModal`, `/admin/user/' . $user->id . '`, [`id`, `nama`, `email`, `role`, `image`])"><i class="bi bi-pencil-square me-1"></i>Edit</button>';
                        $deleteButton = '<button class="btn btn-sm btn-danger d-inline-flex" onclick="confirmDelete(`/admin/user/' . $user->id . '`, `user-table`)"><i class="bi bi-trash me-1"></i>Hapus</button>';
                        return $editButton . $deleteButton;
                    })
                    ->addColumn('img', function ($user) {
                        return '<img src="/storage/image/user/' . $user->image . '" width="150px" alt="">';
                    })
                    ->addIndexColumn()
                    ->rawColumns(['aksi', 'img'])
                    ->make(true);
            }

            return $this->successResponse($users, 'Data User ditemukan.');
        }

        return view('admin.user.index');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'role' => 'required',
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
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
            'image' => $image ?? null,
        ]);

        return $this->successResponse($user, 'Data User ditambahkan.', 201);
    }

    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return $this->errorResponse(null, 'Data User tidak ditemukan.', 404);
        }

        return $this->successResponse($user, 'Data User ditemukan.');
    }

    public function update(Request $request, $id)
    {
        $dataValidator = [
            'nama' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'image' => 'image|mimes:png,jpg,jpeg',
        ];

        if ($request->password != null) {
            $dataValidator['password'] = 'required|min:8|confirmed';
        }

        $validator = Validator::make($request->all(), $dataValidator);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'Data tidak valid.', 422);
        }

        $user = User::find($id);

        if (!$user) {
            return $this->errorResponse(null, 'Data User tidak ditemukan.', 404);
        }

        $updateUser = [
            'nama' => $request->nama,
            'email' => $request->email,
            'role' => $request->role,
        ];

        if ($request->password != null) {
            $updateAdmin['password'] = bcrypt($request->password);
        }

        if ($request->hasFile('image')) {
            if (Storage::exists('public/image/user/' . $user->image)) {
                Storage::delete('public/image/user/' . $user->image);
            }
            $image = $request->file('image')->hashName();
            $request->file('image')->storeAs('public/image/user', $image);
            $updateUser['image'] = $image;
        }

        $user->update($updateUser);

        return $this->successResponse($user, 'Data User diubah.');
    }

    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return $this->errorResponse(null, 'Data User tidak ditemukan.', 404);
        }

        if (Storage::exists('public/image/user/' . $user->image)) {
            Storage::delete('public/image/user/' . $user->image);
        }

        $user->delete();

        return $this->successResponse(null, 'Data User dihapus.');
    }
}
