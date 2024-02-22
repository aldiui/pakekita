<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use App\Traits\ApiResponder;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
                        $editButton = '<button class="btn btn-sm btn-warning me-1 d-inline-flex" onclick="getModal(`editModal`, `/admin/unit/' . $unit->id . '`, [`id`, `nama`])"><i class="bi bi-pencil-square me-2"></i>Edit</button>';
                        $deleteButton = '<button class="btn btn-sm btn-danger d-inline-flex" onclick="confirmDelete(`/admin/unit/' . $unit->id . '`, `unit-table`)"><i class="bi bi-trash me-2"></i>Hapus</button>';
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

        $unit = Unit::create([
            'nama' => $request->input('nama'),
        ]);

        return $this->successResponse($unit, 'Data unit ditambahkan.', 201);
    }

    public function show($id)
    {
        $unit = Unit::find($id);

        if (!$unit) {
            return $this->errorResponse(null, 'Data unit tidak ditemukan.', 404);
        }

        return $this->successResponse($unit, 'Data unit ditemukan.');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'Data tidak valid.', 422);
        }

        $unit = Unit::find($id);

        if (!$unit) {
            return $this->errorResponse(null, 'Data unit tidak ditemukan.', 404);
        }

        $unit->update(['nama' => $request->input('nama')]);

        return $this->successResponse($unit, 'Data unit diubah.');
    }

    public function destroy($id)
    {
        $unit = Unit::find($id);

        if (!$unit) {
            return $this->errorResponse(null, 'Data unit tidak ditemukan.', 404);
        }

        $unit->delete();

        return $this->successResponse(null, 'Data unit dihapus.');
    }
}
