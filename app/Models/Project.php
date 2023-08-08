<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    //table project
    protected $table = 'tm_project';
    protected $fillable = [
        'line',
        'nama',
        'deadline',
    ];

    public function details()
    {
        return $this->hasMany(ProjectDetail::class, 'id_project', 'id');
    }
}
