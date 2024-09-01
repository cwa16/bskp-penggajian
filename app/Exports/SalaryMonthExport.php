<?php

namespace App\Exports;

use App\Models\SalaryMonth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use DB;

class SalaryMonthExport implements FromCollection, WithHeadings, WithStyles, WithEvents
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
            ->join('users', 'users.nik', '=', 'salary_years.nik')
            ->join('grade', 'grade.name_grade', '=', 'users.grade')
            ->select('salary_months.*', 'users.name', 'users.nik', 'users.id as id_users')
            ->select('salary_months.id', 'users.nik', 'users.name', 'grade.name_grade', 'salary_months.hour_call', 'salary_months.thr', 'salary_months.bonus', 'salary_months.incentive', 'salary_months.union', 'salary_months.absent', 'salary_months.electricity', 'salary_months.cooperative', 'salary_months.pinjaman', 'salary_months.other', 'salary_months.date')
            ->whereDate('salary_months.date', $this->date)
            ->where('users.status', $this->status)
            ->orderBy('users.name', 'asc');

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'id',
            'nik',
            'name',
            'grade',
            'hour_call',
            'thr',
            'bonus',
            'incentive',
            'union',
            'absent',
            'electricity',
            'cooperative',
            'pinjaman',
            'other',
            'date'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->freezePane('A2');

        return [];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getDelegate()->getColumnDimension('A')->setVisible(false);
            },
        ];
    }

}
