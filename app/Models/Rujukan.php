<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rujukan extends Model
{
    /** @use HasFactory<\Database\Factories\RujukanFactory> */
    use HasFactory;

    protected $fillable = [
        'rekam_medis_id',
        'dari_faskes',
        'ke_faskes',
        'alasan_rujukan',
        'tanggal_rujukan'
    ];

    public function rekamMedis()
    {
        return $this->belongsTo(RekamMedis::class);
    }
}
