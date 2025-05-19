<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alternatif extends Model
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_alternatif';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'kode_alternatif',
        'nama_alternatif',
    ];

    /**
     * Get the nilai alternatif for the alternatif.
     */
    public function nilaiAlternatifs()
    {
        return $this->hasMany(NilaiAlternatif::class, 'id_alternatif', 'id_alternatif');
    }
}
