<?php

namespace App\Models;

use App\Models\Jenis;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    protected $table = 'tm_product';
    public $timestamps = true;

    public function jenis()
    {
        return $this->belongsTo(Jenis::class, 'id_jenis', 'id');
    }


}
