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
                        $editButton = '<button class="btn btn-sm btn-warning me-1 d-inline-flex" onclick="getModal(`editModal`, `/admin/meja/' . $meja->id . '`, [`id`, `kode_meja`])"><i class="bi bi-pencil-square me-1"></i>Edit</button>';
                        $deleteButton = '<button class="btn btn-sm btn-danger d-inline-flex" onclick="confirmDelete(`/admin/meja/' . $meja->id . '`, `meja-table`)"><i class="bi bi-trash me-1"></i>Hapus</button>';
                        return $editButton . $deleteButton;
                    })
                    ->addIndexColumn()
                    ->rawColumns(['aksi'])
                    ->make(true);
            }

            return $this->successResponse($mejas, 'Data meja ditemukan.');
        }

        return view('admin.meja.index');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode_meja' => 'required|unique:mejas',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'Data tidak valid.', 422);
        }

        $meja = Meja::create([
            'kode_meja' => $request->input('kode_meja'),
        ]);

        return $this->successResponse($meja, 'Data meja ditambahkan.', 201);
    }

    public function show($id)
    {
        $meja = Meja::find($id);

        if (!$meja) {
            return $this->errorResponse(null, 'Data meja tidak ditemukan.', 404);
        }

        return $this->successResponse($meja, 'Data meja ditemukan.');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'kode_meja' => 'required|unique:mejas,kode_meja,' . $id . ',id',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'Data tidak valid.', 422);
        }

        $meja = Meja::find($id);

        if (!$meja) {
            return $this->errorResponse(null, 'Data meja tidak ditemukan.', 404);
        }

        $meja->update(['kode_meja' => $request->input('kode_meja')]);

        return $this->successResponse($meja, 'Data meja diubah.');
    }

    public function destroy($id)
    {
        $meja = Meja::find($id);

        if (!$meja) {
            return $this->errorResponse(null, 'Data meja tidak ditemukan.', 404);
        }

        $meja->delete();

        return $this->successResponse(null, 'Data meja dihapus.');
    }
}