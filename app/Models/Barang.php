<?php

namespace App\Models;

use App\Models\Kategori;
use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $hidden = [
        'id',
        'kategori_id',
        'unit_id',
        'created_at',
        'updated_at',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
