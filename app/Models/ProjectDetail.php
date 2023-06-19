<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectDetail extends Model
{
    use HasFactory;

    //table project_detail
    protected $table = 'project_detail';
    protected $fillable = [
        'id_project',
        'nama',
        'start',
        'deadline',
        'status'
    ];
}
