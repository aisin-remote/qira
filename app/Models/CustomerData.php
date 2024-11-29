<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerData extends Model
{
    use HasFactory;

    // Tentukan nama tabel yang digunakan oleh model ini
    protected $table = 'quality_reports';

    // Tentukan kolom-kolom yang bisa diisi
    protected $fillable = [
        'tanggal',
        'section',
        'line',
        'model',
        'part_name',
        'problem',
        'quantity',
        'standard',
        'actual',
        'visual_ok',
        'visual_ng',
        'measurement_photo',
        'qty',
        'ok',
        'ng',
        'pic',
        'problem_analysis',
        'occure',
        'outflow',
        'temporary_actions',
        'corrective_actions',
        'photo_path'
    ];
}
