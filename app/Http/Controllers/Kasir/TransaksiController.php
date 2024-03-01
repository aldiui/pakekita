<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Traits\ApiResponder;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\Printer;

class TransaksiController extends Controller
{
    use ApiResponder;

    public function index(Request $request)
    {
        $bulan = $request->input("bulan");
        $tahun = $request->input("tahun");

        if ($request->ajax()) {
            $transaksis = Transaksi::with('pembayaran')->withCount('detailTransaksis')->whereMonth('created_at', $bulan)->whereYear('created_at', $tahun)->latest()->get();
            if ($request->input("mode") == "datatable") {
                return DataTables::of($transaksis)
                    ->addColumn('total_rupiah', function ($transaksi) {
                        return formatRupiah($transaksi->total);
                    })
                    ->addColumn('tgl', function ($transaksi) {
                        return formatTanggal($transaksi->created_at);
                    })
                    ->addColumn('pembayaran', function ($transaksi) {
                        return $transaksi->pembayaran->nama ?? 'Cash';
                    })
                    ->addColumn('cetak', function ($transaksi) {
                        return '<a href="' . route('kasir.transaksi.show', $transaksi->kode) . '" class="btn btn-sm btn-info"><i class="bi bi-printer"></i></a>';
                    })
                    ->addIndexColumn()
                    ->rawColumns(['tgl', 'total_rupiah', 'pembayaran', 'cetak'])
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
            'bayar' => $request->input('bayar'),
            'total' => $request->input('grandTotal'),
            'user_id' => Auth::user()->id ?? null,
            'pembayaran_id' => $request->input('pembayaran_id') == "Cash" ? null : $request->input('pembayaran_id'),
            'meja_id' => $request->input('meja_id'),
            'kode' => 'TRX-' . uniqid(),
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

    public function show($kode)
    {
        $transaksi = Transaksi::where('kode', $kode)->with('pembayaran', 'detailTransaksis')->first();

        if (!$transaksi) {
            return $this->errorResponse(null, 'Data Transaksi tidak ditemukan.', 404);
        }

        $content = "";
        $content .= buatBaris1Kolom("Pakekita", "tengah");
        $content .= buatBaris1Kolom("Tasikmalaya, Jawa Barat", "tengah");
        $content .= buatBaris1Kolom("");
        $content .= buatBaris1Kolom("Tanggal : " . formatTanggal($transaksi->created_at, 'd/m/Y H:i:s'));
        $content .= buatBaris1Kolom("Kode Transaksi : " . $transaksi->kode);
        $content .= buatBaris1Kolom("Pesanan : " . $transaksi->pesanan);
        $content .= buatBaris1Kolom("Pembayaran : " . ($transaksi->pembayaran_id == null ? "Cash" : $transaksi->pembayaran->nama));
        $content .= buatBaris1Kolom("Meja : " . ($transaksi->meja_id == null ? "Umum" : $transaksi->meja->nama));
        $content .= buatBaris1Kolom("");
        $content .= buatBaris1Kolom("-----------------------------------");
        $content .= buatBaris3Kolom("Menu", "Qty", "Total");
        $content .= buatBaris1Kolom("-----------------------------------");
        foreach ($transaksi->detailTransaksis as $detailTransaksi) {
            $content .= buatBaris3Kolom($detailTransaksi->menu->nama, $detailTransaksi->qty, formatRupiah($detailTransaksi->total_harga));
        }
        $content .= buatBaris1Kolom("-----------------------------------");
        $content .= buatBaris3Kolom("Total", "", formatRupiah($transaksi->total));
        if ($transaksi->pembayaran_id == null) {
            $content .= buatBaris3Kolom("Dibayar", "", formatRupiah($transaksi->bayar));
            $content .= buatBaris3Kolom("Kembalian", "", formatRupiah($transaksi->bayar - $transaksi->total));
        }
        $content .= buatBaris1Kolom("");
        $content .= buatBaris1Kolom("Terima kasih sudah memesan ke cafe kami, ditunggu kedatangannya kembali", "tengah");

        $connector = new FilePrintConnector("php://stdout");
        $printer = new Printer($connector);
        $printer->text($content);
        $printer->cut();
        $printer->close();

        return response()->make($content, 200)->header('Content-Type', 'text/plain');
    }
}
