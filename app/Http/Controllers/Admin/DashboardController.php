<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $bulan = $request->input("bulan");
            $tahun = $request->input("tahun");
            $startDate = Carbon::createFromDate($tahun, $bulan, 1)->startOfMonth();
            $endDate = Carbon::createFromDate($tahun, $bulan, 1)->endOfMonth();

            $transaksiPerBulan = Transaksi::whereBetween('created_at', [$startDate, $endDate])->get();

            $labels = [];
            $transaksi = [];

            $transaksiPerHari = $transaksiPerBulan->groupBy(function ($item) {
                return $item->created_at->toDateString();
            });

            $dates = Carbon::parse($startDate);
            while ($dates <= $endDate) {
                $dateString = $dates->toDateString();
                $labels[] = $dates->format('d');
                $transaksi[] = $transaksiPerHari->has($dateString) ? $transaksiPerHari[$dateString]->sum('total') : 0;
                $dates->addDay();
            }

            return response()->json([
                'labels' => $labels,
                'transaksi' => $transaksi,
            ]);
        }

        $transaksiHariIni = Transaksi::whereDate('created_at', date('Y-m-d'))->sum("total");
        return view('admin.dashboard.index', compact('transaksiHariIni'));
    }
}
