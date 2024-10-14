<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengguna extends Model
{
    use HasFactory;
    protected $table = 'pengguna';
    protected $primarykey = 'id_pengguna';
    protected $fillable = [
        'nama',
        'email',
        'id_telegram'
    ];
}
