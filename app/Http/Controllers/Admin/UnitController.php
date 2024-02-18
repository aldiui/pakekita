<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use App\Traits\ApiResponder;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;

class UnitController extends Controller
{
    use ApiResponder;

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $units = Unit::all();
            if ($request->input("mode") == "datatable") {
                return DataTables::of($units)
                    ->addColumn('aksi', function ($unit) {
                        $editButton = '<button class="btn btn-sm btn-warning me-1" onclick="getModal(`editModal`, `/admin/unit/' . $unit->uuid . '`, [`uuid`, `nama`])"><i class="bx bx-edit"></i>Edit</button>';
                        $deleteButton = '<button class="btn btn-sm btn-danger" onclick="confirmDelete(`/admin/unit/' . $unit->uuid . '`, `unit-table`)"><i class="bx bx-trash"></i>Hapus</button>';
                        return $editButton . $deleteButton;
                    })
                    ->addIndexColumn()
                    ->rawColumns(['aksi'])
                    ->make(true);
            }

            return $this->successResponse($units, 'Data unit ditemukan.');
        }

        return view('admin.unit.index');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'Data tidak valid.', 422);
        }

        $uuid = Uuid::uuid4()->toString();

        $unit = Unit::create([
            'uuid' => $uuid,
            'nama' => $request->input('nama'),
        ]);

        return $this->successResponse($unit, 'Data unit ditambahkan.', 201);
    }

    public function show($uuid)
    {
        $unit = Unit::where('uuid', $uuid)->first();

        if (!$unit) {
            return $this->errorResponse(null, 'Data unit tidak ditemukan.', 404);
        }

        return $this->successResponse($unit, 'Data unit ditemukan.');
    }

    public function update(Request $request, $uuid)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'Data tidak valid.', 422);
        }

        $unit = Unit::where('uuid', $uuid)->first();

        if (!$unit) {
            return $this->errorResponse(null, 'Data unit tidak ditemukan.', 404);
        }

        $unit->update(['nama' => $request->input('nama')]);

        return $this->successResponse($unit, 'Data unit diubah.');
    }

    public function destroy($uuid)
    {
        $unit = Unit::where('uuid', $uuid)->first();

        if (!$unit) {
            return $this->errorResponse(null, 'Data unit tidak ditemukan.', 404);
        }

        $unit->delete();

        return $this->successResponse(null, 'Data unit dihapus.');
    }
}