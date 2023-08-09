<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectDetail extends Model
{
    use HasFactory;

    //table project_detail
    protected $table = 'tt_project_detail';
    protected $fillable = [
        'id_project',
        'itemCheck',
        'start',
        'deadline',
        'status'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'id_project', 'id');
    }
}
