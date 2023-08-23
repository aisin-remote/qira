<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $table = 'tt_projects';

    public function itemCheckProjects()
    {
        return $this->hasMany(ItemCheckProject::class, 'project_id');
    }
}
