<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $nim
 * @property string $nama
 * @property string $fakultas
 * @property string $prodi
 * @property string $angkatan
 * @property string $email
 * @property string $no_telp
 */
class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'nim',
        'nama',
        'fakultas',
        'prodi',
        'angkatan',
        'email',
        'no_telp',
    ];
}
