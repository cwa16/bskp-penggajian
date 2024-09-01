<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class new_user extends Model
{
    use HasFactory;

    protected $table = 'new_users';

    protected $fillable = [
        'nik',
        'name',
        'id_status',
        'id_grade',
        'id_dept',
        'id_job',
        'sex',
        'ttl',
        'start',
        'pendidikan',
        'agama',
        'domisili',
        'email',
        'no_ktp',
        'no_telpon',
        'kis',
        'kpj',
        'suku',
        'no_sepatu_safety',
        'start_work_user',
        'end_work_user',
        'loc_kerja',
        'loc',
        'sistem_absensi',
        'latitude',
        'longitude',
        'aktual_cuti',
        'status_pernikahan',
        'istri_suami',
        'anak_1',
        'anak_2',
        'anak_3',
        'access_by',
        'image_url',
        'role_app',
        'active',
        'email_verified_at',
        'password',
    ];
}
