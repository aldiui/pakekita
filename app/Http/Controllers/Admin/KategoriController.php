<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Traits\ApiResponder;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;

class KategoriController extends Controller
{
    use ApiResponder;

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $kategoris = Kategori::all();
            if ($request->input("mode") == "datatable") {
                return DataTables::of($kategoris)
                    ->addColumn('aksi', function ($kategori) {
                        $editButton = '<button class="btn btn-sm btn-warning me-1" onclick="getModal(`editModal`, `/admin/kategori/' . $kategori->uuid . '`, [`uuid`, `nama`, `jenis`])"><i class="bx bx-edit"></i>Edit</button>';
                        $deleteButton = '<button class="btn btn-sm btn-danger" onclick="confirmDelete(`/admin/kategori/' . $kategori->uuid . '`, `kategori-table`)"><i class="bx bx-trash"></i>Hapus</button>';
                        return $editButton . $deleteButton;
                    })
                    ->addIndexColumn()
                    ->rawColumns(['aksi'])
                    ->make(true);
            }

            if ($request->input("jenis")) {
                $kategorisByJenis = Kategori::where('jenis', $request->input("jenis"))->get();
                return $this->successResponse($kategorisByJenis, 'Data kategori ditemukan.');
            }

            return $this->successResponse($kategoris, 'Data kategori ditemukan.');

        }

        return view('admin.kategori.index');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'jenis' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'Data tidak valid.', 422);
        }

        $uuid = Uuid::uuid4()->toString();

        $kategori = Kategori::create([
            'uuid' => $uuid,
            'nama' => $request->input('nama'),
            'jenis' => $request->input('jenis'),
        ]);

        return $this->successResponse($kategori, 'Data kategori ditambahkan.', 201);
    }

    public function show($uuid)
    {
        $kategori = Kategori::where('uuid', $uuid)->first();

        if (!$kategori) {
            return $this->errorResponse(null, 'Data kategori tidak ditemukan.', 404);
        }

        return $this->successResponse($kategori, 'Data kategori ditemukan.');
    }

    public function update(Request $request, $uuid)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'jenis' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'Data tidak valid.', 422);
        }

        $kategori = Kategori::where('uuid', $uuid)->first();

        if (!$kategori) {
            return $this->errorResponse(null, 'Data kategori tidak ditemukan.', 404);
        }

        $kategori->update([
            'nama' => $request->input('nama'),
            'jenis' => $request->input('jenis'),
        ]);

        return $this->successResponse($kategori, 'Data kategori diubah.');
    }

    public function destroy($uuid)
    {
        $kategori = Kategori::where('uuid', $uuid)->first();

        if (!$kategori) {
            return $this->errorResponse(null, 'Data kategori tidak ditemukan.', 404);
        }

        $kategori->delete();

        return $this->successResponse(null, 'Data kategori dihapus.');
    }
}
