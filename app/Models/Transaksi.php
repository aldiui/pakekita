<?php

namespace App\Models;

use App\Models\DetailTransaksi;
use App\Models\Meja;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function detailTransaksis()
    {
        return $this->hasMany(DetailTransaksi::class);
    }

    public function meja()
    {
        return $this->belongsTo(Meja::class);
    }
}
