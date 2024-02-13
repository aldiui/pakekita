<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Meja;
use App\Traits\ApiResponder;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;

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
                        $editButton = '<button class="btn btn-sm btn-warning me-1" onclick="getModal(`editModal`, `/admin/meja/' . $meja->uuid . '`, [`uuid`, `kode_meja`])"><i class="bx bx-edit"></i>Edit</button>';
                        $deleteButton = '<button class="btn btn-sm btn-danger" onclick="confirmDelete(`/admin/meja/' . $meja->uuid . '`, `meja-table`)"><i class="bx bx-trash"></i>Hapus</button>';
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

        $uuid = Uuid::uuid4()->toString();

        $meja = Meja::create([
            'uuid' => $uuid,
            'kode_meja' => $request->input('kode_meja'),
        ]);

        return $this->successResponse($meja, 'Data meja ditambahkan.', 201);
    }

    public function show($uuid)
    {
        $meja = Meja::where('uuid', $uuid)->first();

        if (!$meja) {
            return $this->errorResponse(null, 'Data meja tidak ditemukan.', 404);
        }

        return $this->successResponse($meja, 'Data meja ditemukan.');
    }

    public function update(Request $request, $uuid)
    {
        $validator = Validator::make($request->all(), [
            'kode_meja' => 'required|unique:mejas,kode_meja,' . $uuid . ',uuid',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'Data tidak valid.', 422);
        }

        $meja = Meja::where('uuid', $uuid)->first();

        if (!$meja) {
            return $this->errorResponse(null, 'Data meja tidak ditemukan.', 404);
        }

        $meja->update(['kode_meja' => $request->input('kode_meja')]);

        return $this->successResponse($meja, 'Data meja diubah.');
    }

    public function destroy($uuid)
    {
        $meja = Meja::where('uuid', $uuid)->first();

        if (!$meja) {
            return $this->errorResponse(null, 'Data meja tidak ditemukan.', 404);
        }

        $meja->delete();

        return $this->successResponse(null, 'Data meja dihapus.');
    }
}
