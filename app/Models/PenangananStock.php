<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenangananStock extends Model
{
    use HasFactory;

    protected $fillable = [
        'quality_report_id', 'komponen', 'qty', 'ok', 'ng', 'pic'
    ];

    // Jika ada relasi dengan Pica
    public function qualityreport()
    {
        return $this->belongsTo(QualityReport::class, 'id_quality_report');
    }

}

