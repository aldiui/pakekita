<?php

namespace App\Models;

use App\Models\Barang;
use App\Models\Stok;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailStok extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function stok()
    {
        return $this->belongsTo(Stok::class);
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
