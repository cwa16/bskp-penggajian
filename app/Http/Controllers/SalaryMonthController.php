<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Status;
use App\Models\SalaryYear;
use App\Models\SalaryMonth;
use Carbon\Carbon;
use DB;

use Illuminate\Http\Request;

class SalaryMonthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Salary Per Month';

        $data = DB::table('salary_months')
            ->join('salary_years', 'salary_years.id', '=', 'salary_months.id_salary_year')
            ->join('salary_grades', 'salary_grades.id', '=', 'salary_years.id_salary_grade')
            ->join('users', 'users.id', '=', 'salary_years.id_user')
            ->join('statuses', 'users.id_status', '=', 'statuses.id')
            ->join('depts', 'users.id_dept', '=', 'depts.id')
            ->join('jobs', 'users.id_job', '=', 'jobs.id')
            ->join('grades', 'users.id_grade', '=', 'grades.id')
            ->select('salary_months.*', 'salary_years.*', 'salary_grades.*', 'users.*', 'statuses.*', 'depts.*', 'jobs.*', 'grades.*', 'salary_months.id as id_salary_month')
            ->get();

        // dd($data);

        $years = SalaryMonth::distinct('date')->pluck('date')->map(function ($date) {
            return Carbon::parse($date)->format('Y');
        })->unique()->toArray();
        $months = SalaryMonth::distinct('date')->pluck('date')->map(function ($date) {
            $carbonDate = Carbon::parse($date);
            return [
                'value' => $carbonDate->format('m'),
                'label' => $carbonDate->format('F'),
            ];
        })->unique()->toArray();
        $statuses = Status::distinct('name_status')->pluck('name_status')->toArray();
        // $query = SalaryMonth::with('salary_year');

        $selectedYear =  null;
        $selectedMonth = null;
        $selectedStatus = null;

        // // percabangan untuk filter status
        // if (request('filter_status') != null) {
        //     if (request('filter_status') != 'all') {
        //         // Filter by the selected status
        //         $selectedStatus = request('filter_status');
        //         $query->whereHas('salary_year.user.status', function ($subquery) use ($selectedStatus) {
        //             $subquery->where('name_status', $selectedStatus);
        //         });
        //     }
        // }

        // // percabangan untuk filter tahun
        // if (request('filter_year') != null) {
        //     if (request('filter_year') != 'all') {
        //         // Filter by the selected year
        //         $selectedYear = request('filter_year');
        //         $query->whereYear('date', $selectedYear);
        //     }
        // } else {
        //     // untuk menetapkan tahun sekarang saat membuka halaman
        //     $selectedYear = request('filter_year', Carbon::now()->year);
        //     $query->whereYear('date', $selectedYear);
        // }

        // // percabangan untuk filter bulan
        // if (request('filter_month') != null) {
        //     if (request('filter_month') != 'all') {
        //         // Filter by the selected month
        //         $selectedMonth = request('filter_month');
        //         $query->wheremonth('date', $selectedMonth);
        //     }
        // } else {
        //     // untuk menetapkan bulan sekarang saat membuka halaman
        //     $selectedMonth = request('filter_month', Carbon::now()->month);
        //     $query->whereMonth('date', $selectedMonth);
        // }

        // // Query the salary_months based on the selected year, month, and status
        // $salary_months = $query->get();

        // return view('salary_month.index', compact(
        //     'title', 'statuses', 'years', 'months', 'salary_months', 'selectedStatus', 'selectedYear', 'selectedMonth', 'data'
        // ));


        return view('salary_month.index', compact(
            'title', 'selectedStatus', 'data', 'statuses', 'selectedYear', 'years', 'selectedMonth', 'months',
        ));
    }

    public function filter()
    {
        $title = 'Filter Salary Per Month';

        $statuses = Status::all();
        $years = SalaryYear::distinct('year')->pluck('year')->toArray();

        $statusFilter = request()->input('id_status', null);
        $yearFilter = request()->input('year', null);
        $monthFilter = request()->input('month', null);

        return view('salary_month.filter', compact('title', 'statusFilter', 'yearFilter', 'statuses', 'monthFilter', 'years',));
    }

    public function create()
    {
        $title = 'Input Salary Per Month';

        $statuses = Status::all();
        $years = SalaryYear::distinct('year')->pluck('year')->toArray();

        $statusFilter = request()->input('id_status');
        $yearFilter = request()->input('year');
        $monthFilter = request()->input('month');

        $checkYear = SalaryMonth::whereYear('date', $yearFilter)->first();
        $checkMonth = SalaryMonth::whereMonth('date', $monthFilter)->first();
        $checkStatus = DB::table('salary_months')
            ->join('salary_years', 'salary_years.id', '=', 'salary_months.id_salary_year')
            ->join('users', 'users.id', '=', 'salary_years.id_user')
            ->join('statuses', 'users.id_status', '=', 'statuses.id')
            ->where('users.id_status', $statusFilter)
            ->first();

        if ($checkStatus != null) {
            if ($checkYear != null && $checkMonth != null) {
                $data = DB::table('salary_months')
                    ->join('salary_years', 'salary_years.id', '=', 'salary_months.id_salary_year')
                    ->join('salary_grades', 'salary_grades.id', '=', 'salary_years.id_salary_grade')
                    ->join('users', 'users.id', '=', 'salary_years.id_user')
                    ->join('statuses', 'users.id_status', '=', 'statuses.id')
                    ->join('depts', 'users.id_dept', '=', 'depts.id')
                    ->join('jobs', 'users.id_job', '=', 'jobs.id')
                    ->join('grades', 'users.id_grade', '=', 'grades.id')
                    ->select('salary_months.*', 'salary_years.*', 'salary_grades.*', 'users.*', 'statuses.*', 'depts.*', 'jobs.*', 'grades.*')
                    ->whereYear('salary_months.date', $yearFilter)
                    ->whereMonth('salary_months.date', $monthFilter)
                    ->where('salary_months.thr', 0)
                    ->get();

                echo 'update data kosong';

            } elseif ($checkYear != null && $checkMonth == null) {
                $data = DB::table('salary_months')
                    ->join('salary_years', 'salary_years.id', '=', 'salary_months.id_salary_year')
                    ->join('salary_grades', 'salary_grades.id', '=', 'salary_years.id_salary_grade')
                    ->join('users', 'users.id', '=', 'salary_years.id_user')
                    ->join('statuses', 'users.id_status', '=', 'statuses.id')
                    ->join('depts', 'users.id_dept', '=', 'depts.id')
                    ->join('jobs', 'users.id_job', '=', 'jobs.id')
                    ->join('grades', 'users.id_grade', '=', 'grades.id')
                    ->select('salary_months.*', 'salary_years.*', 'salary_grades.*', 'users.*', 'statuses.*', 'depts.*', 'jobs.*', 'grades.*')
                    ->get();

                echo 'isi data baru';

            } else {
                echo 'isi data tahun dulu';
            }
        } else {
            echo 'Data tahun belum diinput';
        }

        // dd($data);

        // // Check if all filters are provided, then fetch data
        // $salary_years = [];
        // if ($statusFilter !== null && $yearFilter !== null && $monthFilter !== null) {
        //     $salary_years = SalaryYear::when($statusFilter, function ($query) use ($statusFilter) {
        //         $query->whereHas('user', function ($subquery) use ($statusFilter) {
        //             $subquery->where('id_status', $statusFilter);
        //         });
        //     })
        //         ->when($yearFilter, function ($query) use ($yearFilter) {
        //             $query->where('year', $yearFilter);
        //         })
        //         ->with('user')
        //         ->get();

        //     // Filter out the years that already have data for the selected month
        //     $salary_years = $salary_years->filter(function ($salary_year) use ($monthFilter) {
        //         return !$salary_year->hasSalaryForMonth($salary_year->year, $monthFilter);
        //     });
        // }


        return view('salary_month.create', compact('title', 'statuses', 'years', 'statusFilter', 'yearFilter', 'monthFilter', 'data'));
    }

    public function store(Request $request)
    {
        // Mengambil tahun dan bulan dari filter
    $yearFilter = $request->input('year');
    $monthFilter = $request->input('month');

    foreach ($request->input('id_user') as $key => $id_user) {
        // Menggabungkan tahun, bulan, dan tanggal tertentu (misalnya, tanggal 13)
        $date = $yearFilter . '-' . $monthFilter . '-13';

        // Menggunakan null coalescing operator (??) untuk memastikan nilai default jika tidak ada
        $rate_salary = $request->input('rate_salary')[$key] ?? 0;
        $ability = $request->input('ability')[$key] ?? 0;
        $fungtional_alw = $request->input('fungtional_alw')[$key] ?? 0;
        $family_alw = $request->input('family_alw')[$key] ?? 0;
        $transport_alw = $request->input('transport_alw')[$key] ?? 0;
        $skill_alw = $request->input('skill_alw')[$key] ?? 0;
        $telephone_alw = $request->input('telephone_alw')[$key] ?? 0;
        $adjustment = $request->input('adjustment')[$key] ?? 0;
        $total_overtime = $request->input('total_overtime')[$key] ?? 0;
        $thr = $request->input('thr')[$key] ?? 0;
        $bonus = $request->input('bonus')[$key] ?? 0;
        $incentive = $request->input('incentive')[$key] ?? 0;
        $total_ben = $request->input('total_ben')[$key] ?? 0;

        $bpjs = $request->input('bpjs')[$key] ?? 0;
        $jamsostek = $request->input('jamsostek')[$key] ?? 0;
        $union = $request->input('union')[$key] ?? 0;
        $absent = $request->input('absent')[$key] ?? 0;
        $electricity = $request->input('electricity')[$key] ?? 0;
        $cooperative = $request->input('cooperative')[$key] ?? 0;
        $total_ben_ded = $request->input('total_ben_ded')[$key] ?? 0;

        // Hitungan untuk mencari totalan
        $gross_sal = $rate_salary + $ability + $fungtional_alw + $family_alw + $transport_alw + $skill_alw + $telephone_alw +
            $adjustment + $total_overtime + $thr + $bonus + $incentive;
        $total_deduction = $bpjs + $jamsostek + $union + $absent + $electricity + $cooperative;
        $net_salary = ($gross_sal + $total_ben) - ($total_deduction + $total_ben_ded);

        // SalaryMonth::create([
        //     'id_salary_year' => $request->input('id_salary_year')[$key] ?? null,
        //     'date' => $date,
        //     'hour_call' => $request->input('hour_call')[$key] ?? 0,
        //     'total_overtime' => $total_overtime,
        //     'thr' => $thr,
        //     'bonus' => $bonus,
        //     'incentive' => $incentive,
        //     'union' => $union,
        //     'absent' => $absent,
        //     'electricity' => $electricity,
        //     'cooperative' => $cooperative,
        //     'gross_salary' => $gross_sal,
        //     'total_deduction' => $total_deduction,
        //     'net_salary' => $net_salary,
        // ]);

        SalaryMonth::updateOrCreate(
            [
                'id_salary_year' => $request->input('id_salary_year')[$key] ?? null,
            ],
            [
                'date' => $date,
                'hour_call' => $request->input('hour_call')[$key] ?? 0,
                'total_overtime' => $total_overtime,
                'thr' => $thr,
                'bonus' => $bonus,
                'incentive' => $incentive,
                'union' => $union,
                'absent' => $absent,
                'electricity' => $electricity,
                'cooperative' => $cooperative,
                'gross_salary' => $gross_sal,
                'total_deduction' => $total_deduction,
                'net_salary' => $net_salary,
            ]
        );
    }

        // Redirect or return response as needed
        return redirect()->route('salary-month')->with('success', 'Salary data stored successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        // $selectedIds = $request->input('ids', []);
        $selectedIds = $request->input('ids', '');

        // Konversi string parameter ke dalam bentuk array
        if (is_string($selectedIds)) {
            $selectedIds = explode(',', $selectedIds);
        }

        // Jika tidak ada id yang dipilih, redirect kembali atau tampilkan pesan sesuai kebutuhan
        if (empty($selectedIds)) {
            return redirect()->route('salary-month')->with('error', 'No data selected for editing.');
        }

        $title = 'Salary Per Month';
        $salary_months = SalaryMonth::whereIn('id', $selectedIds)->get();

        return view('salary_month.edit', compact('title', 'salary_months'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        foreach ($request->input('ids') as $id) {

            $rate_salary = $request->input('rate_salary.' . $id);
            $ability = $request->input('ability.' . $id);
            $fungtional_alw = $request->input('fungtional_alw.' . $id);
            $family_alw = $request->input('family_alw.' . $id);
            $transport_alw = $request->input('transport_alw.' . $id);
            $skill_alw = $request->input('skill_alw.' . $id);
            $telephone_alw = $request->input('telephone_alw.' . $id);
            $adjustment = $request->input('adjustment.' . $id);
            $total_overtime = $request->input('total_overtime.' . $id);
            $thr = $request->input('thr.' . $id);
            $bonus = $request->input('bonus.' . $id);
            $incentive = $request->input('incentive.' . $id);
            $total_ben = $request->input('total_ben.' . $id);

            $bpjs = $request->input('bpjs.' . $id);
            $jamsostek = $request->input('jamsostek.' . $id);
            $union = $request->input('union.' . $id);
            $absent = $request->input('absent.' . $id);
            $electricity = $request->input('electricity.' . $id);
            $cooperative = $request->input('cooperative.' . $id);
            $total_ben_ded = $request->input('total_ben_ded.' . $id);

            // Hitungan untuk mencari totalan
            $gross_sal = $rate_salary + $ability + $fungtional_alw + $family_alw + $transport_alw + $skill_alw + $telephone_alw +
                $adjustment + $total_overtime + $thr + $bonus + $incentive;
            $total_deduction = $bpjs + $jamsostek + $union + $absent + $electricity + $cooperative;
            $net_salary = ($gross_sal + $total_ben) - ($total_deduction + $total_ben_ded);

            // $allocations = $request->input('allocation.' . $id) ?? NULL;
            // if ($allocations) {
            //     $allocationJson = json_encode($allocations);
            // } else {
            //     $allocationJson = $allocations;
            // }

            SalaryMonth::where('id', $id)->update([
                'hour_call' => $request->input('hour_call.' . $id),
                'total_overtime' => $total_overtime,
                'thr' => $thr,
                'bonus' => $bonus,
                'incentive' => $incentive,
                'union' => $union,
                'absent' => $absent,
                'electricity' => $electricity,
                'cooperative' => $cooperative,
                'incentive' => $incentive,
                'gross_salary' => $gross_sal,
                'total_deduction' => $total_deduction,
                // 'allocation' => $allocationJson,
                'net_salary' => $net_salary,
            ]);
        }

        // Redirect atau lakukan aksi lainnya setelah pembaruan selesai
        return redirect()->route('salary-month')->with('success', 'Data gaji berhasil diperbarui.');
    }
}
