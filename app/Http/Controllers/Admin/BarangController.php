<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Traits\ApiResponder;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Ramsey\id\id;

class BarangController extends Controller
{
    use ApiResponder;

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $barangs = Barang::with(['unit', 'kategori'])->get();
            if ($request->input("mode") == "datatable") {
                return DataTables::of($barangs)
                    ->addColumn('aksi', function ($barang) {
                        $editButton = '<button class="btn btn-sm btn-warning me-1 d-inline-flex" onclick="getSelectEdit(), getModal(`createModal`, `/admin/barang/' . $barang->id . '`, [`id`, ,`kategori_id`,`unit_id`,`nama`, `deskripsi`, `qty`, `image`])"><i class="bi bi-pencil-square me-2"></i>Edit</button>';
                        $deleteButton = '<button class="btn btn-sm btn-danger d-inline-flex" onclick="confirmDelete(`/admin/barang/' . $barang->id . '`, `barang-table`)"><i class="bi bi-trash me-2"></i>Hapus</button>';
                        return $editButton . $deleteButton;
                    })
                    ->addColumn('kategori', function ($barang) {
                        return $barang->kategori->nama;
                    })
                    ->addColumn('quantity', function ($barang) {
                        return $barang->qty . ' ' . $barang->unit->nama;
                    })
                    ->addColumn('img', function ($barang) {
                        return '<img src="/storage/image/barang/' . $barang->image . '" width="150px" alt="">';
                    })
                    ->addIndexColumn()
                    ->rawColumns(['aksi', 'img', 'quantity', 'kategori'])
                    ->make(true);
            }

            return $this->successResponse($barangs, 'Data Barang ditemukan.');
        }

        return view('admin.barang.index');
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
            $request->file('image')->storeAs('public/image/barang', $image);
        }

        $barang = Barang::create([
            'nama' => $request->nama,
            'kategori_id' => $request->kategori_id,
            'unit_id' => $request->unit_id,
            'deskripsi' => $request->deskripsi,
            'qty' => $request->qty,
            'image' => $image ?? null,
        ]);

        return $this->successResponse($barang, 'Data Barang ditambahkan.', 201);
    }

    public function show($id)
    {
        $barang = Barang::find($id);

        if (!$barang) {
            return $this->errorResponse(null, 'Data Barang tidak ditemukan.', 404);
        }

        return $this->successResponse($barang, 'Data Barang ditemukan.');
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

        $barang = Barang::find($id);

        if (!$barang) {
            return $this->errorResponse(null, 'Data Barang tidak ditemukan.', 404);
        }

        $updateBarang = [
            'nama' => $request->nama,
            'kategori_id' => $request->kategori_id,
            'unit_id' => $request->unit_id,
            'deskripsi' => $request->deskripsi,
            'qty' => $request->qty,
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

        return $this->successResponse($barang, 'Data Barang diubah.');
    }

    public function destroy($id)
    {
        $barang = Barang::find($id);

        if (!$barang) {
            return $this->errorResponse(null, 'Data Barang tidak ditemukan.', 404);
        }

        if (Storage::exists('public/image/barang/' . $barang->image)) {
            Storage::delete('public/image/barang/' . $barang->image);
        }

        $barang->delete();

        return $this->successResponse(null, 'Data Barang dihapus.');
    }
}