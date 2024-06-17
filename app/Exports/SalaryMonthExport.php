<?php

namespace App\Exports;

use App\Models\SalaryMonth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SalaryMonthExport implements FromCollection, WithHeadings
{
    use Exportable;

    public function __construct(string $date)
    {
        $this->date = $date;
    }

    public function collection()
    {
        $query = SalaryMonth::select([
                'id', 'hour_call', 'total_overtime', 'thr', 'bonus', 'incentive', 'union', 'absent', 'electricity', 'cooperative'
            ])
            ->whereDate('date', $this->date);

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'id',
            'hour_call',
            'total_overtime',
            'thr',
            'bonus',
            'incentive',
            'union',
            'absent',
            'electricity',
            'cooperative',
        ];
    }

    // public function query()
    // {
    //     return SalaryMonth::query()->whereDate('date', $this->date);
    // }
}
