<?php

namespace App\Imports;

use App\Models\SalaryMonth;
use App\Models\SalaryYear;
use App\Models\SalaryGrade;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use DB;

class SalaryMonthImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function model(array $row)
    {
        $getRateSalary = DB::table('salary_months')
            ->join('salary_years', 'salary_years.id', '=', 'salary_months.id_salary_year')
            ->join('salary_grades', 'salary_years.id_salary_grade', '=', 'salary_grades.id')
            ->select('salary_grades.rate_salary', 'salary_years.ability')
            ->where('salary_months.id', $row['id'])
            ->first();

        $rateSalary = $getRateSalary->rate_salary;
        $ability = $getRateSalary->ability;
        $hourCall = $row['hour_call'];

        $calculatedValue = (($rateSalary + $ability) / 173) * $hourCall;

        return SalaryMonth::updateOrCreate(
            [
                'id' => $row['id'],
                'date' => $row['date'],
            ],
            [
                'hour_call'       => $row['hour_call'],
                'total_overtime'  => $calculatedValue,
                'thr'             => $row['thr'],
                'bonus'           => $row['bonus'],
                'incentive'       => $row['incentive'],
                'union'           => $row['union'],
                'absent'          => $row['absent'],
                'electricity'     => $row['electricity'],
                'cooperative'     => $row['cooperative'],
            ]
        );
    }
}
