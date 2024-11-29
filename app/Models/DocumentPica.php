<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class DocumentPica extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'tt_pica_document';

    public function pica()
    {
        return $this->belongsTo(Pica::class, 'id_pica');
    }
}
