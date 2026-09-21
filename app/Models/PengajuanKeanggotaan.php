<?php

namespace App\Models;

use Sakuci\Database\Model;

class PengajuanKeanggotaan extends Model
{
    protected static ?string $table = 'pengajuan_keanggotaan';
    protected string $primaryKey = 'id_pengajuan';

    protected array $fillable = [
        'id_user',
        'nama_lengkap',
        'nis',
        'kelas',
        'status',
        'catatan_admin',
        'tanggal_pengajuan',
        'tanggal_verifikasi',
        'diverifikasi_oleh',
    ];
}