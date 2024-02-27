<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Traits\ApiResponder;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TransaksiController extends Controller
{
    use ApiResponder;

    public function index(Request $request)
    {
        $bulan = $request->input("bulan");
        $tahun = $request->input("tahun");

        if ($request->ajax()) {
            $transaksis = Transaksi::withCount('detailTransaksis')->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->latest()->get();
            if ($request->input("mode") == "datatable") {
                return DataTables::of($transaksis)
                    ->addColumn('total_rupiah', function ($transaksi) {
                        return formatRupiah($transaksi->total);
                    })
                    ->addColumn('tgl', function ($transaksi) {
                        return formatTanggal($transaksi->tanggal);
                    })
                    ->addIndexColumn()
                    ->rawColumns(['tgl', 'total_rupiah'])
                    ->make(true);
            }
        }

        return view('kasir.transaksi.index');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pesanan' => 'required',
            'grandTotal' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'Data tidak valid.', 422);
        }

        $transaksi = Transaksi::create([
            'pesanan' => $request->input('pesanan'),
            'total' => $request->input('grandTotal'),
            'user_id' => Auth::user()->id,
            'kode' => 'TRX-' . uniqid(),
            'tanggal' => now()->toDateString(),
        ]);

        $detailPesanan = [];
        $data = $request->only(['menu_id', 'qty', 'total']);

        foreach ($data['menu_id'] as $key => $menuId) {
            $detailPesanan[] = [
                'transaksi_id' => $transaksi->id,
                'menu_id' => $menuId,
                'qty' => $data['qty'][$key],
                'total_harga' => $data['total'][$key],
            ];
        }

        $transaksi->detailTransaksis()->createMany($detailPesanan);

        return $this->successResponse($transaksi, 'Data Transaksi ditambahkan.', 201);
    }
}
