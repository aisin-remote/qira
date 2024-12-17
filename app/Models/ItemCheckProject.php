<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ItemCheckProject extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'tt_item_check_projects';

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public $incrementing = false;
}
