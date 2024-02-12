<?php

namespace App\Models;

use App\Models\Barang;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
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
