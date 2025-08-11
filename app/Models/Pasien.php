<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    /** @use HasFactory<\Database\Factories\PasienFactory> */
    use HasFactory;

    protected $fillable = ['user_id', 'nik', 'tanggal_lahir', 'alamat', 'jenis_kelamin'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rekamMedis()
    {
        return $this->hasMany(RekamMedis::class);
    }
}
