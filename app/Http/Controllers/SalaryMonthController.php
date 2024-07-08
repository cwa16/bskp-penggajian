<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Status;
use App\Models\SalaryYear;
use App\Models\SalaryMonth;
use Carbon\Carbon;
use DB;
use App\Exports\SalaryMonthExport;
use App\Imports\SalaryMonthImport;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Http\Request;

class SalaryMonthController extends Controller
{
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
        $statuses_id = Status::all();

        $selectedYear = trim(request()->input('filter_year', ''));
        $selectedMonth = trim(request()->input('filter_month', ''));
        $selectedStatus = trim(request()->input('filter_status', ''));

        $selectedYear = (int) $selectedYear;
        $selectedMonth = (int) $selectedMonth;

        if ($selectedYear == null && $selectedMonth == null && $selectedStatus == null) {
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
        } else {
            if ($selectedStatus == 'All Status') {
                $data = DB::table('salary_months')
                    ->join('salary_years', 'salary_years.id', '=', 'salary_months.id_salary_year')
                    ->join('salary_grades', 'salary_grades.id', '=', 'salary_years.id_salary_grade')
                    ->join('users', 'users.id', '=', 'salary_years.id_user')
                    ->join('statuses', 'users.id_status', '=', 'statuses.id')
                    ->join('depts', 'users.id_dept', '=', 'depts.id')
                    ->join('jobs', 'users.id_job', '=', 'jobs.id')
                    ->join('grades', 'users.id_grade', '=', 'grades.id')
                    ->select('salary_months.*', 'salary_years.*', 'salary_grades.*', 'users.*', 'statuses.*', 'depts.*', 'jobs.*', 'grades.*', 'salary_months.id as id_salary_month')
                    ->whereYear('salary_months.date', $selectedYear)
                    ->whereMonth('salary_months.date', $selectedMonth)
                    ->get();
            } else {
                $data = DB::table('salary_months')
                    ->join('salary_years', 'salary_years.id', '=', 'salary_months.id_salary_year')
                    ->join('salary_grades', 'salary_grades.id', '=', 'salary_years.id_salary_grade')
                    ->join('users', 'users.id', '=', 'salary_years.id_user')
                    ->join('statuses', 'users.id_status', '=', 'statuses.id')
                    ->join('depts', 'users.id_dept', '=', 'depts.id')
                    ->join('jobs', 'users.id_job', '=', 'jobs.id')
                    ->join('grades', 'users.id_grade', '=', 'grades.id')
                    ->select('salary_months.*', 'salary_years.*', 'salary_grades.*', 'users.*', 'statuses.*', 'depts.*', 'jobs.*', 'grades.*', 'salary_months.id as id_salary_month')
                    ->where('users.id_status', $selectedStatus)
                    ->whereYear('salary_months.date', $selectedYear)
                    ->whereMonth('salary_months.date', $selectedMonth)
                    ->get();
            }
        }

        return view('salary_month.index', compact(
            'title', 'selectedStatus', 'data', 'statuses', 'selectedYear', 'years', 'selectedMonth', 'months', 'statuses_id',
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
                    ->select('salary_months.*', 'salary_years.*', 'salary_grades.*', 'users.*', 'statuses.*', 'depts.*', 'jobs.*', 'grades.*', 'salary_months.id as id_salary_month')
                    ->whereYear('salary_months.date', $yearFilter)
                    ->whereMonth('salary_months.date', $monthFilter)
                    ->where('salary_months.thr', 0)
                    ->get();

            } elseif ($checkYear != null && $checkMonth == null) {
                $data = DB::table('salary_months')
                    ->join('salary_years', 'salary_years.id', '=', 'salary_months.id_salary_year')
                    ->join('salary_grades', 'salary_grades.id', '=', 'salary_years.id_salary_grade')
                    ->join('users', 'users.id', '=', 'salary_years.id_user')
                    ->join('statuses', 'users.id_status', '=', 'statuses.id')
                    ->join('depts', 'users.id_dept', '=', 'depts.id')
                    ->join('jobs', 'users.id_job', '=', 'jobs.id')
                    ->join('grades', 'users.id_grade', '=', 'grades.id')
                    ->where('users.id_status', $statusFilter)
                    ->select('salary_months.*', 'salary_years.*', 'salary_grades.*', 'users.*', 'statuses.*', 'depts.*', 'jobs.*', 'grades.*', 'salary_months.id as id_salary_month')
                    ->get();

            }
        } else {
            $data = DB::table('users')
                ->join('statuses', 'users.id_status', '=', 'statuses.id')
                ->join('depts', 'users.id_dept', '=', 'depts.id')
                ->join('jobs', 'users.id_job', '=', 'jobs.id')
                ->join('grades', 'users.id_grade', '=', 'grades.id')
                ->join('salary_grades', 'grades.id', '=', 'salary_grades.id_grade')
                ->join('salary_years', 'salary_years.id_user', '=', 'users.id')
                ->where('users.id_status', $statusFilter)
                ->select('users.*', 'salary_grades.*', 'grades.*', 'statuses.*', 'depts.*', 'jobs.*', 'salary_grades.id as id_salary_grade', 'users.id as id_user', 'salary_years.id as id_salary_year')
                ->get();
        }

        // dd($data);

        return view('salary_month.create', compact('title', 'statuses', 'years', 'statusFilter', 'yearFilter', 'monthFilter', 'data'));
    }

    public function store(Request $request)
    {
    $idFilter = $request->input('id_salary_month');
    $yearFilter = $request->input('year');
    $monthFilter = $request->input('month');

    foreach ($request->input('id_user') as $key => $id_user) {
        $date = $yearFilter . '-' . $monthFilter . '-13';

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

        $gross_sal = $rate_salary + $ability + $fungtional_alw + $family_alw + $transport_alw + $skill_alw + $telephone_alw +
            $adjustment + $total_overtime + $thr + $bonus + $incentive;
        $total_deduction = $bpjs + $jamsostek + $union + $absent + $electricity + $cooperative;
        $net_salary = ($gross_sal + $total_ben) - ($total_deduction + $total_ben_ded);

        SalaryMonth::updateOrCreate(
            [
                'id' => $request->input('id_salary_month')[$key],
                'date' => $request->input('date_input')[$key],
            ],
            [
                'id_salary_year' => $request->input('id_salary_year')[$key] ?? null,
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

        return redirect()->route('salary-month')->with('success', 'Salary data stored successfully');
    }

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
        // $salary_months = DB::table('salary_months')
        //     ->join('salary_years', 'salary_years.id', '=', 'salary_months.id_salary_year')
        //     ->join('salary_grades', 'salary_grades.id', '=', 'salary_years.id_salary_grade')
        //     ->join('users', 'users.id', '=', 'salary_years.id_user')
        //     ->join('statuses', 'users.id_status', '=', 'statuses.id')
        //     ->join('depts', 'users.id_dept', '=', 'depts.id')
        //     ->join('jobs', 'users.id_job', '=', 'jobs.id')
        //     ->join('grades', 'users.id_grade', '=', 'grades.id')
        //     ->select('salary_months.*', 'salary_years.*', 'salary_grades.*', 'users.*', 'statuses.*', 'depts.*', 'jobs.*', 'grades.*', 'salary_months.id as id_salary_month')
        //     ->whereIn('salary_months.id', $selectedIds)
        //     ->get();

        $salary_months = SalaryMonth::whereIn('id', $selectedIds)->get();

        // dd($salary_months);

        return view('salary_month.edit', compact('title', 'salary_months'));
    }

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

            // dd($gross_sal, $total_deduction, $net_salary);

            $update = SalaryMonth::where('id', $id)->update([
                'hour_call' => $request->input('hour_call.' . $id),
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
            ]);
        }

        if ($update) {
            return redirect()->route('salary-month')->with('success', 'Data gaji berhasil diperbarui.');
        } else {
            return redirect()->back();
        }

        // Redirect atau lakukan aksi lainnya setelah pembaruan selesai
        // return redirect()->route('salary-month')->with('success', 'Data gaji berhasil diperbarui.');
    }

    public function export(Request $request)
    {
        $date = $request->input('date');
        $status = $request->input('filter_status');
        return (new SalaryMonthExport($date, $status))->download($date . '_salary_month_' . $status .'.xlsx');
    }

    public function import()
    {
        Excel::import(new SalaryMonthImport,request()->file('file'));

        return back();
    }
}
