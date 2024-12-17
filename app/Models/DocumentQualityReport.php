<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentQualityReport extends Model
{
    use HasFactory;

    // Relasi dengan quality report
    public function qualityReport()
    {
        return $this->belongsTo(QualityReport::class, 'id_quality_report', 'id');
    }
}
