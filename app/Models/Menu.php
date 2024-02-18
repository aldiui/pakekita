<?php

namespace App\Models;

use App\Models\Kategori;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $hidden = [
        'id',
        'kategori_id',
        'created_at',
        'updated_at',
    ];

    public function toArray()
    {
        $array = [
            "uuid" => $this->uuid,
            "nama" => $this->nama,
            "harga" => $this->harga,
            "deskripsi" => $this->deskripsi,
            "image" => $this->image,
            "rupiah" => formatRupiah($this->harga),
            "kategori_id" => $this->kategori->uuid,
            "kategori" => $this->kategori->nama,
        ];

        return $array;
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

}
