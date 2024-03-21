<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Menu;
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
                    ->addColumn('cetak', function ($transaksi) {
                        return '<a href="' . route('kasir.transaksi.show', $transaksi->kode) . '" class="btn btn-sm btn-info"><i class="bi bi-printer"></i></a>';
                    })
                    ->addIndexColumn()
                    ->rawColumns(['tgl', 'total_rupiah', 'cetak', 'badge'])
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
            'pembayaran' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'Data tidak valid.', 422);
        }

        $dataTransaksi = [
            'pesanan' => $request->pesanan,
            'bayar' => $request->bayar,
            'pembayaran' => $request->pembayaran,
            'total' => $request->grandTotal,
            'user_id' => Auth::user()->id ?? null,
            'kode' => 'TRX' . date('Ymd') . rand(1111, 9999),
        ];

        if ($request->has('meja_id')) {
            $dataTransaksi['meja_id'] = $request->meja_id;
        }

        $detailPesanan = [];
        $data = $request->only(['menu_id', 'qty', 'total']);

        foreach ($data['menu_id'] as $key => $menuId) {
            $detailPesanan[] = [
                'menu_id' => $menuId,
                'qty' => $data['qty'][$key],
                'total_harga' => $data['total'][$key],
            ];
        }

        if ($request->pembayaran == 'Cash') {
            $transaksi = Transaksi::create($dataTransaksi);
            $transaksi->detailTransaksis()->createMany($detailPesanan);
            $transaksi->update(['status' => 1]);
            return $this->successResponse($transaksi, 'Data Transaksi ditambahkan.', 201);
        }

        $itemDetails = [];
        foreach ($detailPesanan as $detail) {
            $menu = Menu::find($detail['menu_id']);
            $itemDetails[] = [
                'id' => $detail['menu_id'],
                'price' => $detail['total_harga'],
                'quantity' => $detail['qty'],
                'name' => $menu->nama,
            ];
        }

        \Midtrans\Config::$serverKey = config('services.midtrans.serverKey');
        \Midtrans\Config::$isProduction = config('services.midtrans.isProduction');
        \Midtrans\Config::$isSanitized = config('services.midtrans.isSanitized');
        \Midtrans\Config::$is3ds = config('services.midtrans.is3ds');

        $payload = [
            'transaction_details' => [
                'order_id' => $dataTransaksi['kode'],
                'gross_amount' => $dataTransaksi['total'],
            ],
            'customer_details' => [
                'first_name' => $dataTransaksi['pesanan'],
            ],
            'item_details' => $itemDetails,
        ];

        $snapToken = \Midtrans\Snap::getSnapToken($payload);
        $snapTokenData = [
            'snapToken' => $snapToken,
            'kode' => $dataTransaksi['kode'],
        ];

        return $this->successResponse($snapTokenData, 'Data Transaksi ditambahkan.', 201);
    }

    public function saveTransfer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pesanan' => 'required',
            'grandTotal' => 'required',
            'pembayaran' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'Data tidak valid.', 422);
        }

        $transaksi = Transaksi::create([
            'kode' => $request->kode,
            'pesanan' => $request->pesanan,
            'bayar' => $request->bayar,
            'pembayaran' => $request->pembayaran,
            'total' => $request->grandTotal,
            'user_id' => Auth::user()->id ?? null,
            'meja_id' => $request->meja_id ?? null,
        ]);

        $data = $request->only(['menu_id', 'qty', 'total']);
        foreach ($data['menu_id'] as $key => $menuId) {
            $detailPesanan[] = [
                'menu_id' => $menuId,
                'qty' => $data['qty'][$key],
                'total_harga' => $data['total'][$key],
                'transaksi_id' => $transaksi->id,
            ];
        }

        $transaksi->detailTransaksis()->createMany($detailPesanan);

        return $this->successResponse($transaksi, 'Data Transaksi ditambahkan.', 201);
    }

    public function show($kode)
    {
        $transaksi = Transaksi::where('kode', $kode)->with('detailTransaksis')->first();

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
