<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    protected $table = 'Grade';

    protected $fillable = [
        'name_grade',
        'rate_salary',
        'year',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'grade');
    }
}
