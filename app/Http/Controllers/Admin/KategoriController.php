<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Traits\ApiResponder;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
                        $editButton = '<button class="btn btn-sm btn-warning me-1 d-inline-flex" onclick="getModal(`editModal`, `/admin/kategori/' . $kategori->id . '`, [`id`, `nama`, `jenis`])"><i class="bi bi-pencil-square me-1"></i>Edit</button>';
                        $deleteButton = '<button class="btn btn-sm btn-danger d-inline-flex" onclick="confirmDelete(`/admin/kategori/' . $kategori->id . '`, `kategori-table`)"><i class="bi bi-trash me-1"></i>Hapus</button>';
                        return $editButton . $deleteButton;
                    })
                    ->addIndexColumn()
                    ->rawColumns(['aksi'])
                    ->make(true);
            }

            return $this->successResponse($kategoris, 'Data Kategori ditemukan.');
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

        $kategori = Kategori::create([
            'nama' => $request->input('nama'),
            'jenis' => $request->input('jenis'),
        ]);

        return $this->successResponse($kategori, 'Data Kategori ditambahkan.', 201);
    }

    public function show($id)
    {
        if ($id == "Barang" || $id == "Menu") {
            $kategorisByJenis = Kategori::where('jenis', $id)->get();
            return $this->successResponse($kategorisByJenis, 'Data Kategori ditemukan.');
        }

        $kategori = Kategori::find($id);

        if (!$kategori) {
            return $this->errorResponse(null, 'Data Kategori tidak ditemukan.', 404);
        }

        return $this->successResponse($kategori, 'Data Kategori ditemukan.');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'jenis' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'Data tidak valid.', 422);
        }

        $kategori = Kategori::find($id);

        if (!$kategori) {
            return $this->errorResponse(null, 'Data Kategori tidak ditemukan.', 404);
        }

        $kategori->update([
            'nama' => $request->input('nama'),
            'jenis' => $request->input('jenis'),
        ]);

        return $this->successResponse($kategori, 'Data Kategori diubah.');
    }

    public function destroy($id)
    {
        $kategori = Kategori::find($id);

        if (!$kategori) {
            return $this->errorResponse(null, 'Data Kategori tidak ditemukan.', 404);
        }

        $kategori->delete();

        return $this->successResponse(null, 'Data Kategori dihapus.');
    }
}