<?php

namespace App\Imports;

use App\Models\SalaryMonth;
use App\Models\SalaryYear;
use App\Models\SalaryGrade;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use DB;

class SalaryMonthTHRImport implements ToModel, WithHeadingRow
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
            ->join('grade', 'salary_years.id_salary_grade', '=', 'grade.id')
            ->select('grade.rate_salary', 'salary_years.ability', 'salary_years.fungtional_alw', 'salary_years.family_alw',
                    'salary_years.transport_alw', 'salary_years.telephone_alw', 'salary_years.skill_alw', 'salary_years.adjustment',
                    'salary_years.bpjs', 'salary_years.jamsostek', 'salary_years.total_ben', 'salary_years.total_ben_ded')
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

        $thr = $row['thr'];
        $bonus = $row['bonus'];
        $incentive = $row['incentive'];
        $salary_backpay = $row['salary_backpay'];
        $union = $row['union'];
        $absent = $row['absent'];
        $electricity = $row['electricity'];
        $cooperative = $row['cooperative'];
        $pinjaman = $row['pinjaman'];
        $other = $row['other'];

        $gross_sal = $rateSalary + $ability + $fungtional_alw + $family_alw +$telephone_alw + $skill_alw;

        $total = $rateSalary + $ability + $family_alw;

        // $bpjs = ($total > 12000000) ? 12000000 * 0.01 : $total * 0.01;
        $bpjs = $getRateSalary->bpjs;
        // $jamsostek = $total * 0.02;
        $jamsostek = $getRateSalary->jamsostek;
        // $total_ben = $jamsostek;
        $total_ben = $getRateSalary->total_ben;
        // $total_ben_ded = $jamsostek;
        $total_ben_ded = $getRateSalary->total_ben_ded;

        // Hitung total deduction
        $total_deduction = $bpjs + $jamsostek + $union + $absent + $electricity + $cooperative + $pinjaman + $other;
        // dd($total_deduction);

        $gaji_bersih = $gross_sal - ($bpjs + $jamsostek + $union + $absent + $salary_backpay + $electricity + $pinjaman + $other);

        $net_salary = $gaji_bersih - $cooperative + $salary_backpay;

        return SalaryMonth::updateOrCreate(
            [
                'id' => $row['id'],
                'date' => $row['date'],
            ],
            [
                'hour_call'       => '0',
                'total_overtime'  => '0',
                'thr'             => $thr,
                'bonus'           => '0',
                'incentive'       => '0',
                'salary_backpay'  => '0',
                'union'           => '0',
                'absent'          => '0',
                'electricity'     => '0',
                'cooperative'     => '0',
                'pinjaman'        => '0',
                'other'           => '0',
                'gross_salary'    => $thr,
                'total_deduction' => '0',
                'net_salary'      => $thr,
                'bpjs'            => '0',
                'jamsostek'       => '0',
                'total_ben'       => '0',
                'total_ben_ded'   => '0',
                'is_thr'          => '1',
            ]
        );
    }
}
