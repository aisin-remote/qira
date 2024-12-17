<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QualityReport extends Model
{
    use HasFactory;

    // Tentukan nama tabel (jika berbeda dari nama model dalam bentuk jamak)
    protected $table = 'quality_reports';

    // Tentukan kolom-kolom yang dapat diisi (mass assignable)
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
        'qty',  // Kolom qty disimpan sebagai JSON
        'ok',   // Kolom ok disimpan sebagai JSON
        'ng',   // Kolom ng disimpan sebagai JSON
        'pic',  // Kolom pic disimpan sebagai JSON
        'problem_analysis',
        'occure',  // Kolom occure disimpan sebagai JSON
        'outflow',  // Kolom outflow disimpan sebagai JSON
        'temporary_actions',  // Kolom temporary_actions disimpan sebagai JSON
        'corrective_actions',  // Kolom corrective_actions disimpan sebagai JSON
        'photo_path',  // Kolom untuk path foto
    ];

    protected $casts = [
        'qty' => 'array',
        'ok' => 'array',
        'ng' => 'array',
        'pic' => 'array',
        'occure' => 'array',
        'outflow' => 'array',
        'temporary_actions' => 'array',
        'corrective_actions' => 'array',
    ];


    // Tentukan kolom-kolom yang harus diformat, seperti tanggal
    protected $dates = ['tanggal'];

    /**
     * Jika perlu menambahkan relasi, misalnya:
     * public function customerProblems()
     * {
     *     return $this->hasMany(CustomerProblem::class);
     * }
     */

    /**
     * Misalkan jika Anda ingin menggunakan accessor atau mutator:
     * - Accessor untuk mendapatkan data yang sudah diformat (misal, tanggal dalam format tertentu).
     */

     public function penangananstock()
    {
        return $this->hasMany(PenangananStock::class, 'id_quality_report');
    }


    public function documentQualityReport()
    {
    return $this->hasMany(DocumentQualityReport::class, 'id_quality_report', 'id');
    }

    public function getFormattedTanggalAttribute()
    {
        return $this->tanggal->format('d-m-Y');
    }
}
