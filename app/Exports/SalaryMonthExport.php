<?php

namespace App\Exports;

use App\Models\SalaryMonth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class SalaryMonthExport implements FromCollection, WithHeadings
{
    use Exportable;

    public function __construct(string $date, $status)
    {
        $this->date = $date;
        $this->status = $status;
    }

    public function collection()
    {
        $query = DB::table('salary_months')
            ->join('salary_years', 'salary_years.id', '=', 'salary_months.id_salary_year')
            ->join('salary_grades', 'salary_grades.id', '=', 'salary_years.id_salary_grade')
            ->join('users', 'users.id', '=', 'salary_years.id_user')
            ->select('salary_months.*', 'users.name', 'users.nik', 'users.id as id_users')
            ->select('salary_months.id', 'users.nik', 'users.name', 'salary_months.hour_call', 'salary_months.thr', 'salary_months.bonus', 'salary_months.incentive', 'salary_months.union', 'salary_months.absent', 'salary_months.electricity', 'salary_months.cooperative', 'salary_months.date')
            ->whereDate('salary_months.date', $this->date)
            ->where('users.id_status', $this->status);

        // $query = SalaryMonth::select([
        //         'id', 'hour_call', 'total_overtime', 'thr', 'bonus', 'incentive', 'union', 'absent', 'electricity', 'cooperative'
        //     ])
        //     ->whereDate('date', $this->date);

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'id',
            'nik',
            'name',
            'hour_call',
            'thr',
            'bonus',
            'incentive',
            'union',
            'absent',
            'electricity',
            'cooperative',
            'date'
        ];
    }

    // public function query()
    // {
    //     return SalaryMonth::query()->whereDate('date', $this->date);
    // }
}
