<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ItemCheckProjectBody extends Model
{
    use HasFactory;
    use HasUuids;

    // Menentukan nama tabel yang digunakan untuk model ini

    protected $table = 'tt_item_check_projects_body';

    // Menentukan relasi dengan model Project
    public function projectBody()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    // Untuk memastikan ID tidak auto-increment
    public $incrementing = false;
}
