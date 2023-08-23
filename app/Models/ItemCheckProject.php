<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemCheckProject extends Model
{
    use HasFactory;

    protected $table = 'tt_item_check_projects';

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
