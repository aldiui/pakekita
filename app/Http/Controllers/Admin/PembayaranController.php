<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Traits\ApiResponder;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PembayaranController extends Controller
{
    use ApiResponder;

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $pembayarans = Pembayaran::all();
            if ($request->input("mode") == "datatable") {
                return DataTables::of($pembayarans)
                    ->addColumn('aksi', function ($pembayaran) {
                        $editButton = '<button class="btn btn-sm btn-warning  d-inline-flex me-1" onclick="getModal(`editModal`, `/admin/pembayaran/' . $pembayaran->id . '`, [`id`, `nama`, `jenis`, `no_rekening`, `image`])"><i class="bi bi-pencil-square me-1"></i>Edit</button>';
                        $deleteButton = '<button class="btn btn-sm btn-danger d-inline-flex" onclick="confirmDelete(`/admin/pembayaran/' . $pembayaran->id . '`, `pembayaran-table`)"><i class="bi bi-trash me-1"></i>Hapus</button>';
                        return $editButton . $deleteButton;
                    })
                    ->addColumn('img', function ($pembayaran) {
                        return '<img src="/storage/image/pembayaran/' . $pembayaran->image . '" width="150px" alt="">';
                    })
                    ->addIndexColumn()
                    ->rawColumns(['aksi', 'img'])
                    ->make(true);
            }

            return $this->successResponse($pembayarans, 'Data Pembayaran ditemukan.');
        }

        return view('admin.pembayaran.index');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'jenis' => 'required',
            'no_rekening' => 'required|numeric',
            'image' => 'image|mimes:png,jpg,jpeg',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'Data tidak valid.', 422);
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image')->hashName();
            $request->file('image')->storeAs('public/image/pembayaran', $image);
        }

        $pembayaran = Pembayaran::create([
            'nama' => $request->input('nama'),
            'jenis' => $request->input('jenis'),
            'no_rekening' => $request->input('no_rekening'),
            'image' => $image ?? null,
        ]);

        return $this->successResponse($pembayaran, 'Data Pembayaran ditambahkan.', 201);
    }

    public function show($id)
    {
        $pembayaran = Pembayaran::find($id);

        if (!$pembayaran) {
            return $this->errorResponse(null, 'Data Pembayaran tidak ditemukan.', 404);
        }

        return $this->successResponse($pembayaran, 'Data Pembayaran ditemukan.');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'jenis' => 'required',
            'no_rekening' => 'required|numeric',
            'image' => 'image|mimes:png,jpg,jpeg',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'Data tidak valid.', 422);
        }

        $pembayaran = Pembayaran::find($id);

        if (!$pembayaran) {
            return $this->errorResponse(null, 'Data Pembayaran tidak ditemukan.', 404);
        }

        $updatePembayaran = [
            'nama' => $request->input('nama'),
            'jenis' => $request->input('jenis'),
            'no_rekening' => $request->input('no_rekening'),
        ];

        if ($request->hasFile('image')) {
            if (Storage::exists('public/image/pembayaran/' . $pembayaran->image)) {
                Storage::delete('public/image/pembayaran/' . $pembayaran->image);
            }
            $image = $request->file('image')->hashName();
            $request->file('image')->storeAs('public/image/pembayaran', $image);
            $updatePembayaran['image'] = $image;
        }

        $pembayaran->update($updatePembayaran);

        return $this->successResponse($pembayaran, 'Data Pembayaran diubah.');
    }

    public function destroy($id)
    {
        $pembayaran = Pembayaran::find($id);

        if (!$pembayaran) {
            return $this->errorResponse(null, 'Data Pembayaran tidak ditemukan.', 404);
        }

        if (Storage::exists('public/image/pembayaran/' . $pembayaran->image)) {
            Storage::delete('public/image/pembayaran/' . $pembayaran->image);
        }

        $pembayaran->delete();

        return $this->successResponse(null, 'Data Pembayaran dihapus.');
    }
}
