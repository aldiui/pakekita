<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Unit;
use App\Traits\ApiResponder;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;

class BarangController extends Controller
{
    use ApiResponder;

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $barangs = Barang::all();
            if ($request->input("mode") == "datatable") {
                return DataTables::of($barangs)
                    ->addColumn('aksi', function ($barang) {
                        $editButton = '<button class="btn btn-sm btn-warning me-1" onclick="getSelectEdit(), getModal(`editModal`, `/admin/barang/' . $barang->uuid . '`, [`uuid`, ,`kategori_id`,`unit_id`,`nama`, `deskripsi`, `qty`, `image`])"><i class="bx bx-edit"></i>Edit</button>';
                        $deleteButton = '<button class="btn btn-sm btn-danger" onclick="confirmDelete(`/admin/barang/' . $barang->uuid . '`, `barang-table`)"><i class="bx bx-trash"></i>Hapus</button>';
                        return $editButton . $deleteButton;
                    })
                    ->addColumn('img', function ($barang) {
                        return '<img src="/storage/image/barang/' . $barang->image . '" width="150px" alt="">';
                    })
                    ->addIndexColumn()
                    ->rawColumns(['aksi', 'img'])
                    ->make(true);
            }

            return $this->successResponse($barangs, 'Data barang ditemukan.');
        }

        return view('admin.barang.index');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'qty' => 'required|numeric',
            'kategori_id' => 'required|exists:kategoris,uuid',
            'unit_id' => 'required|exists:units,uuid',
            'image' => 'image|mimes:png,jpg,jpeg',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'Data tidak valid.', 422);
        }

        $getKategori = Kategori::where('uuid', $request->kategori_id)->first();
        $getUnit = Unit::where('uuid', $request->unit_id)->first();

        $uuid = Uuid::uuid4()->toString();

        if ($request->hasFile('image')) {
            $image = $request->file('image')->hashName();
            $request->file('image')->storeAs('public/image/barang', $image);
        }

        $barang = Barang::create([
            'uuid' => $uuid,
            'nama' => $request->input('nama'),
            'kategori_id' => $getKategori->id,
            'unit_id' => $getUnit->id,
            'deskripsi' => $request->input('deskripsi'),
            'qty' => $request->input('qty'),
            'image' => $image ?? null,
        ]);

        return $this->successResponse($barang, 'Data barang ditambahkan.', 201);
    }

    public function show($uuid)
    {
        $barang = Barang::where('uuid', $uuid)->first();

        if (!$barang) {
            return $this->errorResponse(null, 'Data barang tidak ditemukan.', 404);
        }

        return $this->successResponse($barang, 'Data barang ditemukan.');
    }

    public function update(Request $request, $uuid)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'qty' => 'required|numeric',
            'kategori_id' => 'required|exists:kategoris,uuid',
            'unit_id' => 'required|exists:units,uuid',
            'image' => 'image|mimes:png,jpg,jpeg',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'Data tidak valid.', 422);
        }

        $barang = Barang::where('uuid', $uuid)->first();

        if (!$barang) {
            return $this->errorResponse(null, 'Data barang tidak ditemukan.', 404);
        }

        $getKategori = Kategori::where('uuid', $request->kategori_id)->first();
        $getUnit = Unit::where('uuid', $request->unit_id)->first();

        $updateBarang = [
            'nama' => $request->input('nama'),
            'kategori_id' => $getKategori->id,
            'unit_id' => $getUnit->id,
            'deskripsi' => $request->input('deskripsi'),
            'qty' => $request->input('qty'),
        ];

        if ($request->hasFile('image')) {
            if (Storage::exists('public/image/barang/' . $barang->image)) {
                Storage::delete('public/image/barang/' . $barang->image);
            }
            $image = $request->file('image')->hashName();
            $request->file('image')->storeAs('public/image/barang', $image);
            $updateBarang['image'] = $image;
        }

        $barang->update($updateBarang);

        return $this->successResponse($barang, 'Data barang diubah.');
    }

    public function destroy($uuid)
    {
        $barang = Barang::where('uuid', $uuid)->first();

        if (!$barang) {
            return $this->errorResponse(null, 'Data barang tidak ditemukan.', 404);
        }

        if (Storage::exists('public/image/barang/' . $barang->image)) {
            Storage::delete('public/image/barang/' . $barang->image);
        }

        $barang->delete();

        return $this->successResponse(null, 'Data barang dihapus.');
    }
}
