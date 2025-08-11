<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemberianObat extends Model
{
    /** @use HasFactory<\Database\Factories\PemberianObatFactory> */
    use HasFactory;

    protected $fillable = ['rekam_medis_id', 'obat_id', 'dosis', 'frekuensi', 'durasi'];

    public function rekamMedis()
    {
        return $this->belongsTo(RekamMedis::class);
    }

    public function obat()
    {
        return $this->belongsTo(Obat::class);
    }
}
