<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user',
        'id_salary_grade',
        'ability',
        'fungtional_allowance',
        'family_allowance',
        'adjustment',
        'transport_allowance',
        'hour_ori',
        'hour_call',
        'total_overtime',
        'thr',
        'bonus',
        'incentive',
        'salary_gross',
        'jamsostek_jkk_ben',
        'jamsostek_tk_ben',
        'jamsostek_tht_ben',
        'pph21_ben',
        'total_benenfit',
        'bruto_salary',
        'bpjs',
        'jamsostek',
        'union',
        'absent',
        'electricity',
        'koperasi',
        'sub_deduction',
        'jamsostek_jkk_deb',
        'jamsostek_tk_deb',
        'jamsostek_tht_deb',
        'pph21_deb',
        'total_debenefit',
        'total_deduction',
        'nett_salary',
        'is_checked',
        'is_approved',
        'created_at',
    ];

    // Relasi dengan tabel User
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    // Relasi dengan tabel SalaryGrade
    public function salary_grade()
    {
        return $this->belongsTo(SalaryGrade::class, 'id_salary_grade');
    }
}
