<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    use HasFactory;

    protected $table = 'all_salary_data';
    protected $fillable = [
        'nik',
        'salary_grade',
        'date',
        'ability',
        'fungtional_alw',
        'family_alw',
        'transport_alw',
        'skill_alw',
        'telephone_alw',
        'adjustment',
        'bpjs',
        'jamsostek',
        'total_overtime',
        'thr',
        'bonus',
        'incentive',
        'union',
        'absent',
        'electricity',
        'cooperative',
        'pinjaman',
        'other',
        'gross_salary',
        'total_deduction',
        'net_salary',
        'allocation',
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
