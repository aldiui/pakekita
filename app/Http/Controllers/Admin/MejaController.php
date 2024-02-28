<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Meja;
use App\Traits\ApiResponder;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Ramsey\id\id;

class MejaController extends Controller
{
    use ApiResponder;

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $mejas = Meja::all();
            if ($request->input("mode") == "datatable") {
                return DataTables::of($mejas)
                    ->addColumn('aksi', function ($meja) {
                        $editButton = '<button class="btn btn-sm btn-warning me-1 d-inline-flex" onclick="getModal(`createModal`, `/admin/meja/' . $meja->id . '`, [`id`, `nama`])"><i class="bi bi-pencil-square me-1"></i>Edit</button>';
                        $deleteButton = '<button class="btn btn-sm btn-danger d-inline-flex" onclick="confirmDelete(`/admin/meja/' . $meja->id . '`, `meja-table`)"><i class="bi bi-trash me-1"></i>Hapus</button>';
                        return $editButton . $deleteButton;
                    })
                    ->addIndexColumn()
                    ->rawColumns(['aksi'])
                    ->make(true);
            }

            return $this->successResponse($mejas, 'Data Meja ditemukan.');
        }

        return view('admin.meja.index');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|unique:mejas',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'Data tidak valid.', 422);
        }

        $meja = Meja::create([
            'nama' => $request->input('nama'),
        ]);

        return $this->successResponse($meja, 'Data Meja ditambahkan.', 201);
    }

    public function show($id)
    {
        $meja = Meja::find($id);

        if (!$meja) {
            return $this->errorResponse(null, 'Data Meja tidak ditemukan.', 404);
        }

        return $this->successResponse($meja, 'Data Meja ditemukan.');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|unique:mejas,nama,' . $id . ',id',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'Data tidak valid.', 422);
        }

        $meja = Meja::find($id);

        if (!$meja) {
            return $this->errorResponse(null, 'Data Meja tidak ditemukan.', 404);
        }

        $meja->update(['nama' => $request->input('nama')]);

        return $this->successResponse($meja, 'Data Meja diubah.');
    }

    public function destroy($id)
    {
        $meja = Meja::find($id);

        if (!$meja) {
            return $this->errorResponse(null, 'Data Meja tidak ditemukan.', 404);
        }

        $meja->delete();

        return $this->successResponse(null, 'Data Meja dihapus.');
    }
}
