<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $hidden = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function barangs()
    {
        return $this->hasMany(Barang::class);
    }
}
