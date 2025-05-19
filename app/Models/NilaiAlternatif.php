<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NilaiAlternatif extends Model
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_nilai';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_alternatif',
        'id_kriteria',
        'nilai_subkriteria',
        'bobot_subkriteria',
    ];

    /**
     * Get the alternatif that owns the nilai alternatif.
     */
    public function alternatif()
    {
        return $this->belongsTo(Alternatif::class, 'id_alternatif', 'id_alternatif');
    }

    /**
     * Get the kriteria that owns the nilai alternatif.
     */
    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class, 'id_kriteria', 'id_kriteria');
    }
}
