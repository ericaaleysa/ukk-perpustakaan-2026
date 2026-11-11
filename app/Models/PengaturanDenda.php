<?php

namespace App\Models;

use Sakuci\Database\Model;

class PengaturanDenda extends Model
{
    protected static ?string $table = 'pengaturan_denda';

    protected array $fillable = ['kode', 'label', 'nominal'];
}