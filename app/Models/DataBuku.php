<?php

namespace App\Models;

use Sakuci\Database\Model;

class DataBuku extends Model
{
    protected static ?string $table = 'data_buku';
    protected string $primaryKey = 'id_buku';

    protected array $fillable = ['judul_buku', 'pengarang', 'penerbit', 'tahun_terbit', 'id_kategori', 'thumbnail'];
}
