<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengguna extends Model
{
    use HasFactory;
    protected $table = 'penggunas'; // Nama tabel

    protected $primaryKey = 'id_pengguna'; // Primary key custom

    protected $fillable = ['nama', 'email', 'telegram'];
}
