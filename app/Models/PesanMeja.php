<?php

namespace App\Models;

use App\Models\Meja;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesanMeja extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function meja()
    {
        return $this->belongsTo(Meja::class);
    }

}
