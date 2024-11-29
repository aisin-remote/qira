<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ProjectBody extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'tt_projects_body';


    public function itemCheckProjectSBody()
    {
        return $this->hasMany(ItemCheckProjectBody::class, 'project_id');
    }

    public $incrementing = false;
}
