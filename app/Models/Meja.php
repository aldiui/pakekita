<?php

namespace App\Models;

use App\Models\PesanMeja;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meja extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function pesanMejas()
    {
        return $this->hasMany(PesanMeja::class);
    }

}
