<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentQualityInternal extends Model
{
    use HasFactory;

    // Relasi dengan quality report
    public function qualityInternal()
    {
        return $this->belongsTo(QualityInternal::class, 'id_quality_internal', 'id');
    }
}
