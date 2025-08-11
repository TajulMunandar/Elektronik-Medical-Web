<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    /** @use HasFactory<\Database\Factories\ObatFactory> */
    use HasFactory;
    protected $fillable = ['nama_obat', 'keterangan'];

    public function pemberian()
    {
        return $this->hasMany(PemberianObat::class);
    }
}
