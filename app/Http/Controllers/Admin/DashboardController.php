<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $bulan = $request->bulan;
            $tahun = $request->tahun;
            $kategori = $request->kategori;

            $startDate = Carbon::createFromDate($tahun, $bulan, 1)->startOfMonth();
            $endDate = Carbon::createFromDate($tahun, $bulan, 1)->endOfMonth();

            $transaksiPerBulan = Transaksi::where('status', '1')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->with('detailTransaksis')
                ->get();

            $labels = [];
            $transaksiPerHari = [];

            foreach ($transaksiPerBulan as $transaksi) {
                foreach ($transaksi->detailTransaksis as $detailTransaksi) {
                    $dateString = $transaksi->created_at->toDateString();
                    $menu = $detailTransaksi->menu;

                    if (!$kategori || $menu->kategori_id == $kategori) {
                        $hargaJual = $menu->harga_jual;
                        $transaksiPerHari[$dateString][] = $hargaJual;
                    }
                }
            }

            $transaksiTotalPerbulan = 0;
            $dates = Carbon::parse($startDate);
            $transaksi = [];
            while ($dates <= $endDate) {
                $dateString = $dates->toDateString();
                $transaksiPerHariIni = isset($transaksiPerHari[$dateString]) ? array_sum($transaksiPerHari[$dateString]) : 0;
                $labels[] = $dates->format('d');
                $transaksi[] = $transaksiPerHariIni;
                $transaksiTotalPerbulan += $transaksiPerHariIni;
                $dates->addDay();
            }

            return response()->json([
                'labels' => $labels,
                'transaksi' => $transaksi,
                'total' => formatRupiah($transaksiTotalPerbulan),
                'bulan' => formatTanggal($startDate->format('F'), 'F'),
            ]);
        }

        $kategori = Kategori::where('jenis', 'Menu')->get();
        $transaksiHariIni = Transaksi::where('status', '1')->whereDate('created_at', date('Y-m-d'))->sum("total");
        return view('admin.dashboard.index', compact('kategori', 'transaksiHariIni'));
    }
}