<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenangananInternals extends Model
{
    use HasFactory;

    protected $fillable = [
        'quality_internal_id', 'komponen', 'qty', 'ok', 'ng', 'pic'
    ];

    // Jika ada relasi dengan Pica
    public function qualityinternal()
    {
        return $this->belongsTo(QualityInternal::class, 'id_quality_internal');
    }

}
