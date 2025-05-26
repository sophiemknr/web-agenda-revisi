<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgendaAdd extends Model
{
    use HasFactory;

    protected $table = 'agenda';

    protected $fillable = [
        'tanggal',
        'jam',
        'kegiatan',
        'keterangan',
        'tempat',
        'status',
        'disposition',
    ];
}
