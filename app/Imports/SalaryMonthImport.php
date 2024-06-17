<?php

namespace App\Imports;

use App\Models\SalaryMonth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SalaryMonthImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function model(array $row)
    {
        return SalaryMonth::updateOrCreate(
            [
                'id' => $row['id'],
            ],
            [
                'hour_call'       => $row['hour_call'],
                'total_overtime'  => $row['total_overtime'],
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

    // public function model(array $row)
    // {
    //     return new SalaryMonth([
    //         'id_salary_year'    => $row['id_salary_year'],
    //         'date'              => $row['date'],
    //         'hour_call'         => $row['hour_call'],
    //         'total_overtime'    => $row['total_overtime'],
    //         'thr'               => $row['thr'],
    //         'bonus'             => $row['bonus'],
    //         'incentive'         => $row['incentive'],
    //         'union'             => $row['union'],
    //         'absent'            => $row['absent'],
    //         'electricity'       => $row['electricity'],
    //         'cooperative'       => $row['cooperative'],
    //         'gross_salary'      => $row['gross_salary'],
    //         'total_deduction'   => $row['total_deduction'],
    //         'net_salary'        => $row['net_salary'],
    //     ]);
    // }
}
