<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Project extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'tt_projects';

    public function itemCheckProjects()
    {
        return $this->hasMany(ItemCheckProject::class, 'project_id');
    }

    public $incrementing = false;
}
