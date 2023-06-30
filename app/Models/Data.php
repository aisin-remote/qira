<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Data extends Model
{
    use HasFactory;
    protected $table = 'tt_data';
    public $timestamps = true;

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product', 'id');
    }
}
