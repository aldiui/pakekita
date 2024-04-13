<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DetailTransaksi;
use App\Models\Kategori;
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
                    ->addColumn('badge', function ($transaksi) {
                        return statusBadge($transaksi->status);
                    })
                    ->addIndexColumn()
                    ->rawColumns(['tgl', 'total_rupiah', 'badge'])
                    ->make(true);
            }
        }

        return view('admin.transaksi.index');
    }

    public function pendapatan(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $kategori = $request->kategori;
        if ($request->ajax()) {
            $query = DetailTransaksi::with(['transaksi', 'menu', 'menu.kategori'])
                ->whereMonth('created_at', $bulan)
                ->whereYear('created_at', $tahun)
                ->when($kategori, function ($query) use ($kategori) {
                    $query->whereHas('menu', function ($query) use ($kategori) {
                        $query->where('kategori_id', $kategori);
                    });
                });

            $transaksis = $query->latest()->get();

            if ($request->mode == "datatable") {
                return DataTables::of($transaksis)
                    ->addColumn('total_harga', function ($transaksi) {
                        return formatRupiah($transaksi->total_harga);
                    })
                    ->addColumn('tanggal', function ($transaksi) {
                        return formatTanggal($transaksi->created_at);
                    })
                    ->addColumn('pesanan', function ($transaksi) {
                        return $transaksi->transaksi->pesanan;
                    })
                    ->addColumn('menu', function ($transaksi) {
                        return $transaksi->menu->nama;
                    })
                    ->addColumn('kategori', function ($transaksi) {
                        return $transaksi->menu->kategori->nama;
                    })
                    ->addIndexColumn()
                    ->rawColumns(['tanggal', 'total_harga', 'pesanan', 'menu', 'kategori'])
                    ->make(true);
            }
        }
        
        $kategori = Kategori::where('jenis', 'Menu')->get();
        return view('admin.transaksi.pendapatan', compact('kategori'));
    }
}