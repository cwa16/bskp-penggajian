<?php

namespace App\Http\Controllers;

use App\Models\OvertimeApproved;
use App\Models\SalaryMonth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use App\Models\User;
use DB;

class OvertimeController extends Controller
{
    // public function index_old()
    // {
    //     $title = 'Individual Overtime Approval';

    //     // $response = Http::get('http://192.168.99.202/absen/public/api/testing-absen');
    //     $response = Http::get('http://attendance_management-22-may-24.test/api/testing-absen');

    //     if ($response->successful()) {
    //         $data = $response->json();
    //         $tanggalHariIni = Carbon::today()->subDay()->format('Y-m-d');

    //         // Filter data yang sesuai dengan tanggal hari ini
    //         $dataHariIni = collect($data)->filter(function ($item) use ($tanggalHariIni) {
    //             return isset($item['date']) && $item['date'] === $tanggalHariIni;
    //         });

    //         if ($dataHariIni->isEmpty()) {
    //             return response()->json(['message' => 'Tidak ada data untuk hari ini'], 404);
    //         } else {
    //             // Ambil data user yang cocok dari database menggunakan Query Builder
    //             $userIds = $dataHariIni->pluck('user_id')->toArray();
    //             $users = DB::table('new_users')
    //                         ->join('users', 'users.nik', '=', 'new_users.nik')
    //                         ->join('salary_years', 'salary_years.id_user', '=', 'users.id')
    //                         ->join('salary_grades', 'salary_grades.id', '=', 'salary_years.id_salary_grade')
    //                         ->join('statuses', 'new_users.id_status', '=', 'statuses.id')
    //                         ->join('depts', 'new_users.id_dept', '=', 'depts.id')
    //                         ->join('jobs', 'new_users.id_job', '=', 'jobs.id')
    //                         ->join('grades', 'new_users.id_grade', '=', 'grades.id')
    //                         ->select('new_users.nik', 'new_users.name', 'statuses.name_status', 'depts.name_dept', 'jobs.name_job', 'salary_years.ability', 'salary_grades.rate_salary')
    //                         ->whereIn('new_users.nik', $userIds)
    //                         ->get();

    //             // Gabungkan data API dengan data dari database
    //             $dataGabungan = $dataHariIni->map(function ($item) use ($users) {
    //                 $user = $users->firstWhere('nik', $item['user_id']);
    //                 if ($user) {
    //                     $item['user_data'] = (array) $user;
    //                     // Pengecekan nilai desc dan operasi pada overtime_hour
    //                     if (isset($item['desc']) && in_array($item['desc'], ['MX'])) {
    //                         // Jika desc bernilai M atau MX, kalikan overtime_hour dengan 2
    //                         $item['overtime_hour'] = $item['overtime_hour'] * 2;
    //                     } else {
    //                         // Jika desc bernilai selain M atau MX, kalikan overtime_hour dengan 2 dan kurangi setengah
    //                         $item['overtime_hour'] = ($item['overtime_hour'] * 2) - 0.5;
    //                     }
    //                 }
    //                 return $item;
    //             });

    //             // dd($dataGabungan);

    //             $dataGabunganGrouped = $dataGabungan->groupBy('user_data.name_status');
    //             // dd($dataGabunganGrouped);

    //             $order = ['Manager', 'Staff', 'Monthly', 'Regular', 'Contract FL', 'Contract BSKP'];
    //             $dataGabunganGrouped = $dataGabunganGrouped->sortBy(function($items, $status) use ($order) {
    //                 return array_search($status, $order);
    //             });

    //             return view('overtime.index', [
    //                 'title' => $title,
    //                 'dataGabunganGrouped' => $dataGabunganGrouped,
    //                 'tanggalHariIni' => $tanggalHariIni
    //             ]);
    //         }
    //     }

    //     // Jika API gagal, tetap kembalikan view dengan judul
    //     return view('overtime.index', [
    //         'title' => $title
    //     ]);
    // }


    public function index()
    {
        $title = 'Individual Overtime Approval';

        $dateInput = request()->input('date', '');

        if ($dateInput == '') {
            $dateYesterday = Carbon::today()->subDay()->format('Y-m-d');
            $users = DB::table('test_absen_regs')
                ->join('users', 'users.nik', '=', 'test_absen_regs.user_id')
                ->join('salary_years', 'salary_years.nik', '=', 'test_absen_regs.user_id')
                ->join('grade', 'grade.id', '=', 'salary_years.id_salary_grade')
                ->leftJoin('overtime_approveds', function($join) use ($dateYesterday) {
                    $join->on('overtime_approveds.nik', '=', 'test_absen_regs.user_id')
                        ->where('overtime_approveds.overtime_date', '=', $dateYesterday);
                })
                ->select(
                    'users.name',
                    'users.status',
                    'users.dept',
                    'users.jabatan',
                    'salary_years.ability',
                    'grade.rate_salary',
                    'test_absen_regs.user_id',
                    'test_absen_regs.date',
                    'test_absen_regs.overtime_hour',
                    'test_absen_regs.overtime_minute',
                    'test_absen_regs.desc',
                    'test_absen_regs.hadir',
                    'salary_years.id as salary_years_id',
                    DB::raw('IF(overtime_approveds.id IS NOT NULL, 1, 0) as is_approved')
                )
                ->whereNotNull('test_absen_regs.overtime_minute')
                ->where('test_absen_regs.overtime_hour', '!=', 0)
                ->where('test_absen_regs.overtime_minute', '!=', 0)
                ->where('test_absen_regs.date', $dateYesterday)
                ->get();
        } else {
            $dateYesterday = request()->input('date', '');
            $users = DB::table('test_absen_regs')
                ->join('users', 'users.nik', '=', 'test_absen_regs.user_id')
                ->join('salary_years', 'salary_years.nik', '=', 'test_absen_regs.user_id')
                ->join('grade', 'grade.id', '=', 'salary_years.id_salary_grade')
                ->leftJoin('overtime_approveds', function($join) use ($dateYesterday) {
                    $join->on('overtime_approveds.nik', '=', 'test_absen_regs.user_id')
                        ->where('overtime_approveds.overtime_date', '=', $dateYesterday);
                })
                ->select(
                    'users.name',
                    'users.status',
                    'users.dept',
                    'users.jabatan',
                    'salary_years.ability',
                    'grade.rate_salary',
                    'test_absen_regs.user_id',
                    'test_absen_regs.date',
                    'test_absen_regs.overtime_hour',
                    'test_absen_regs.overtime_minute',
                    'test_absen_regs.desc',
                    'test_absen_regs.hadir',
                    'salary_years.id as salary_years_id',
                    DB::raw('IF(overtime_approveds.id IS NOT NULL, 1, 0) as is_approved')
                )
                ->whereNotNull('test_absen_regs.overtime_minute')
                ->where('test_absen_regs.overtime_hour', '!=', 0)
                ->where('test_absen_regs.overtime_minute', '!=', 0)
                ->where('test_absen_regs.date', $dateYesterday)
                ->get();
        }

        $dataGabungan = $users->map(function ($item) {
            $item = (array) $item;

            if (isset($item['desc']) && in_array($item['desc'], ['MX'])) {
                $item['overtime_hour'] = $item['overtime_hour'] * 2;
            } else {
                $item['overtime_hour'] = ($item['overtime_hour'] * 2) - 0.5;
            }

            return $item;
        });

        $dataGabunganGrouped = $dataGabungan->groupBy('status');

        $order = ['Manager', 'Staff', 'Monthly', 'Regular', 'Contract FL', 'Contract BSKP'];

        $dataGabunganGrouped = $dataGabunganGrouped->sortBy(function($items, $status) use ($order) {
            return array_search($status, $order);
        });

        return view('overtime.index', [
            'title' => $title,
            'dataGabunganGrouped' => $dataGabunganGrouped,
            'dateYesterday' => $dateYesterday,
        ]);
    }

    public function index_summary()
    {
        $title = 'Summary Overtime';

        $dateInput = request()->input('month');

        if ($dateInput == null) {
            $month = Carbon::now()->month;
            $year = Carbon::now()->year;
        } else {
            list($year, $month) = explode('-', $dateInput);
        }

        $data = DB::table('overtime_approveds')
            ->join('users', 'users.nik', '=', 'overtime_approveds.nik')
            ->join('salary_years', 'salary_years.nik', '=', 'overtime_approveds.nik')
            ->join('grade', 'grade.id', '=', 'salary_years.id_salary_grade')
            ->select(
                'users.nik',
                'users.name',
                'users.dept',
                'users.status',
                'users.jabatan',
                'overtime_approveds.overtime_date',
                'overtime_approveds.hour_call',
                'salary_years.ability',
                'grade.rate_salary',
                'salary_years.id as salary_years_id'
            )
            ->whereMonth('overtime_approveds.overtime_date', $month)
            ->whereYear('overtime_approveds.overtime_date', $year)
            ->get()
            ->groupBy('nik');

        $dataByStatus = $data->groupBy('status');

        $dates = [];
        $startOfMonth = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $endOfMonth = Carbon::createFromDate($year, $month, 1)->endOfMonth();
        for ($date = $startOfMonth; $date <= $endOfMonth; $date->addDay()) {
            $dates[] = $date->format('Y-m-d');
        }

        return view('overtime.summary-new', [
            'title' => $title,
            'month' => $month,
            'year' => $year,
            'dates' => $dates,
            'data' => $data,
            'dateInput' => $dateInput,
            'dataByStatus' => $dataByStatus
        ]);
    }

    public function store(Request $request)
    {
        if ($request->has('user_id')) {
            $userIds = $request->input('user_id');
            $overtimeHours = $request->input('overtime_hour');
            $totalOvertimes = $request->input('totalOvertime');
            $dates = $request->input('tanggal');

            foreach ($userIds as $index => $userId) {
                $overtimeHour = $overtimeHours[$index];
                $totalOvertime = $totalOvertimes[$index];

                OvertimeApproved::updateOrCreate(
                    [
                        'nik' => $userId,
                        'overtime_date' => $dates,
                    ],
                    [
                        'hour_call' => $overtimeHour,
                        'overtime_call' => $totalOvertime,
                    ]
                );
            }

            return redirect()->route('overtime-approval-index')->with('success', 'Data berhasil disimpan.');
        } else {
            return redirect()->route('overtime-approval-index')->with('error', 'Tidak ada data yang dipilih.');
        }
    }

    public function store_summary(Request $request)
    {
        $dates = $request->input('dates', []);
        $selectedItems = $request->input('selected_items', []);

        foreach ($selectedItems as $item) {
            list($salaryYearId, $adjustedOvertime, $nominalUang) = explode('|', $item);
            $cleanValue = (int) round(str_replace(',', '', $nominalUang));
            // dd($salaryYearId, $adjustedOvertime, $cleanValue, $dates[0]);


            // Update or create logic here
            SalaryMonth::updateOrCreate(
                [
                    'id_salary_year' => $salaryYearId,
                    'date' => $dates[0] ?? null
                ],
                [
                    'hour_call' => $adjustedOvertime,
                    'total_overtime' => $cleanValue,
                ]
            );
        }

        return redirect()->back()->with('success', 'Data updated successfully!');
    }

}
