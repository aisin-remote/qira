<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    //table project
    protected $table = 'project';
    protected $fillable = [
        'line',
        'nama',
        'deadline',
    ];
}
