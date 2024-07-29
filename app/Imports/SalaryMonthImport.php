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
        // $getRateSalary = DB::table('salary_months')
        //     ->join('salary_years', 'salary_years.id', '=', 'salary_months.id_salary_year')
        //     ->join('salary_grades', 'salary_years.id_salary_grade', '=', 'salary_grades.id')
        //     ->select('salary_grades.rate_salary', 'salary_years.ability')
        //     ->where('salary_months.id', $row['id'])
        //     ->first();

        // $rateSalary = $getRateSalary->rate_salary;
        // $ability = $getRateSalary->ability;
        // $hourCall = $row['hour_call'];

        // $calculatedValue = (($rateSalary + $ability) / 173) * $hourCall;

        $getRateSalary = DB::table('salary_months')
        ->join('salary_years', 'salary_years.id', '=', 'salary_months.id_salary_year')
        ->join('salary_grades', 'salary_years.id_salary_grade', '=', 'salary_grades.id')
        ->select('salary_grades.rate_salary', 'salary_years.ability', 'salary_years.fungtional_alw', 'salary_years.family_alw',
                'salary_years.transport_alw', 'salary_years.telephone_alw', 'salary_years.skill_alw', 'salary_years.adjustment')
                ->where('salary_years.used', '1')
                ->where('salary_months.id', $row['id'])
        ->first();

        $rateSalary = $getRateSalary->rate_salary;
        $ability = $getRateSalary->ability;
        $fungtional_alw = $getRateSalary->fungtional_alw;
        $family_alw = $getRateSalary->family_alw;
        $transport_alw = $getRateSalary->transport_alw;
        $telephone_alw = $getRateSalary->telephone_alw;
        $skill_alw = $getRateSalary->skill_alw;
        $adjustment = $getRateSalary->adjustment;

        $hourCall = $row['hour_call'];
        $total_overtime = (($rateSalary + $ability) / 173) * $hourCall;

        // Nilai dari inputan row
        $thr = $row['thr'];
        $bonus = $row['bonus'];
        $incentive = $row['incentive'];
        $union = $row['union'];
        $absent = $row['absent'];
        $electricity = $row['electricity'];
        $cooperative = $row['cooperative'];
        $pinjaman = $row['pinjaman'];
        $other = $row['other'];

        // Hitung total gross salary
        $gross_sal = $rateSalary + $ability + $fungtional_alw + $family_alw + $transport_alw + $skill_alw + $telephone_alw +
                    $adjustment + $total_overtime + $thr + $bonus + $incentive;

        // Hitung total BPJS, Jamsostek, dan potongan lainnya
        $bpjs = ($gross_sal > 12000000) ? 12000000 * 0.01 : $gross_sal * 0.01;
        $jamsostek = $gross_sal * 0.02;
        $total_ben = $jamsostek;  // Diasumsikan total benefit sama dengan jamsostek
        $total_ben_ded = $jamsostek;  // Diasumsikan total benefit deduction sama dengan jamsostek

        // Hitung total deduction
        $total_deduction = $bpjs + $jamsostek + $union + $absent + $electricity + $cooperative + $pinjaman + $other;

        // dd($gross_sal, $bpjs, $jamsostek, $total_ben, $total_deduction, $total);

        // Hitung net salary
        $net_salary = ($gross_sal + $total_ben) - ($total_deduction + $total_ben_ded);

        return SalaryMonth::updateOrCreate(
            [
                'id' => $row['id'],
                'date' => $row['date'],
            ],
            [
                'hour_call'       => $row['hour_call'],
                'total_overtime'  => $total_overtime,
                'thr'             => $thr,
                'bonus'           => $bonus,
                'incentive'       => $incentive,
                'union'           => $union,
                'absent'          => $absent,
                'electricity'     => $electricity,
                'cooperative'     => $cooperative,
                'pinjaman'        => $pinjaman,
                'other'           => $other,
                'gross_salary'    => $gross_sal,
                'total_deduction' => $total_deduction,
                'net_salary'      => $net_salary,
                'bpjs'            => $bpjs,
                'jamsostek'       => $jamsostek,
                'total_ben'       => $total_ben,
                'total_ben_ded'   => $total_ben_ded,
            ]
        );
    }
}
