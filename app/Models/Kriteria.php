<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_kriteria';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'kode',
        'nama',
        'bobot',
        'jenis',
    ];

    /**
     * Get the subkriteria for the kriteria.
     */
    public function subkriterias()
    {
        return $this->hasMany(SubKriteria::class, 'id_kriteria', 'id_kriteria');
    }

    /**
     * Get the nilai alternatif for the kriteria.
     */
    public function nilaiAlternatifs()
    {
        return $this->hasMany(NilaiAlternatif::class, 'id_kriteria', 'id_kriteria');
    }
}
