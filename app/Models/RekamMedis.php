<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekamMedis extends Model
{
    /** @use HasFactory<\Database\Factories\RekamMedisFactory> */
    use HasFactory;

    protected $fillable = [
        'pasien_id',
        'petugas_id',
        'tanggal_periksa',
        'keluhan',
        'diagnosa',
        'catatan_tambahan',
        'lokasi',
        'detak_jantung',
        'denyut_nadi',
        'tekanan_darah',
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }

    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }

    public function obat()
    {
        return $this->hasMany(PemberianObat::class, 'rekam_medis_id');
    }

    public function rujukan()
    {
        return $this->hasOne(Rujukan::class, 'rekam_medis_id');
    }
}
