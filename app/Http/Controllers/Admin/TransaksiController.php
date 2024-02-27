<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Traits\ApiResponder;
use DataTables;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    use ApiResponder;

    public function index(Request $request)
    {
        $bulan = $request->input("bulan");
        $tahun = $request->input("tahun");

        if ($request->ajax()) {
            $transaksis = Transaksi::with('pembayaran')->withCount('detailTransaksis')->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->latest()->get();
            if ($request->input("mode") == "datatable") {
                return DataTables::of($transaksis)
                    ->addColumn('total_rupiah', function ($transaksi) {
                        return formatRupiah($transaksi->total);
                    })
                    ->addColumn('tgl', function ($transaksi) {
                        return formatTanggal($transaksi->tanggal);
                    })
                    ->addColumn('pembayaran', function ($transaksi) {
                        return $transaksi->pembayaran->nama ?? 'Cash';
                    })
                    ->addIndexColumn()
                    ->rawColumns(['tgl', 'total_rupiah', 'pembayaran'])
                    ->make(true);
            }
        }

        return view('admin.transaksi.index');
    }
}
