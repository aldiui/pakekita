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
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        if ($request->ajax()) {
            $transaksis = Transaksi::withCount('detailTransaksis')->whereMonth('created_at', $bulan)->whereYear('created_at', $tahun)->latest()->get();
            if ($request->mode == "datatable") {
                return DataTables::of($transaksis)
                    ->addColumn('total_rupiah', function ($transaksi) {
                        return formatRupiah($transaksi->total);
                    })
                    ->addColumn('tgl', function ($transaksi) {
                        return formatTanggal($transaksi->created_at);
                    })
                    ->addColumn('pembayaran', function ($transaksi) {
                        return 'Cash';
                    })
                    ->addIndexColumn()
                    ->rawColumns(['tgl', 'total_rupiah', 'pembayaran'])
                    ->make(true);
            }
        }

        return view('admin.transaksi.index');
    }
}
