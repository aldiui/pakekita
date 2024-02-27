<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Traits\ApiResponder;

class PembayaranController extends Controller
{
    use ApiResponder;

    public function show($id)
    {
        $pembayaran = Pembayaran::find($id);

        if (!$pembayaran) {
            return $this->errorResponse(null, 'Data Pembayaran tidak ditemukan.', 404);
        }

        return $this->successResponse($pembayaran, 'Data Pembayaran ditemukan.');
    }
}
