<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $table = 'events'; // Nama tabel

    protected $primaryKey = 'id_event'; // Primary key custom

    protected $fillable = ['judul','tanggal', 'pesan', 'gambar', 'kategori', 'is_sent'];
}
