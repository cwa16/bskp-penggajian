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
            ->join('users', 'users.nik', '=', 'salary_years.nik')
            ->join('grade', 'users.grade', '=', 'grade.name_grade')
            ->select('salary_months.*', 'salary_years.*', 'users.*', 'grade.name_grade as grades_name', 'salary_months.id as id_salary_month')
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
        $statuses = User::distinct('status')->pluck('status')->toArray();
        $statuses_id = User::all();

        $selectedYear = trim(request()->input('filter_year', ''));
        $selectedMonth = trim(request()->input('filter_month', ''));
        $selectedStatus = trim(request()->input('filter_status', ''));

        $selectedYear = (int) $selectedYear;
        $selectedMonth = (int) $selectedMonth;

        if ($selectedYear == null && $selectedMonth == null && $selectedStatus == null) {
            $data = DB::table('salary_months')
                ->join('salary_years', 'salary_years.id', '=', 'salary_months.id_salary_year')
                ->join('users', 'users.nik', '=', 'salary_years.nik')
                ->join('grade', 'users.grade', '=', 'grade.name_grade')
                ->select('salary_months.*', 'salary_years.*', 'users.*', 'grade.*', 'salary_months.id as id_salary_month', 'salary_months.date as salary_month_date', 'grade.name_grade as grades_name',)
                ->get();
        } else {
            if ($selectedStatus == 'All Status') {
                $data = DB::table('salary_months')
                    ->join('salary_years', 'salary_years.id', '=', 'salary_months.id_salary_year')
                    ->join('users', 'users.nik', '=', 'salary_years.nik')
                    ->join('grade', 'users.grade', '=', 'grade.name_grade')
                    ->select('salary_months.*', 'salary_years.*', 'users.*', 'grade.*', 'salary_months.id as id_salary_month', 'salary_months.date as salary_month_date', 'grade.name_grade as grades_name',)
                    ->whereYear('salary_months.date', $selectedYear)
                    ->whereMonth('salary_months.date', $selectedMonth)
                    ->get();
            } else {
                $data = DB::table('salary_months')
                    ->join('salary_years', 'salary_years.id', '=', 'salary_months.id_salary_year')
                    ->join('users', 'users.nik', '=', 'salary_years.nik')
                    ->join('grade', 'users.grade', '=', 'grade.name_grade')
                    ->select('salary_months.*', 'salary_years.*', 'users.*', 'grade.*', 'salary_months.id as id_salary_month', 'salary_months.date as salary_month_date', 'grade.name_grade as grades_name',)
                    ->where('users.status', $selectedStatus)
                    ->whereYear('salary_months.date', $selectedYear)
                    ->whereMonth('salary_months.date', $selectedMonth)
                    ->get();
            }
        }

        $totalHourCall = $data->sum('hour_call');
        $totalTotalOT = $data->sum('total_overtime');
        $totalThr = $data->sum('thr');
        $totalBonus = $data->sum('bonus');
        $totalIncentive = $data->sum('incentive');
        $totalUnion = $data->sum('union');
        $totalAbsent = $data->sum('absent');
        $totalElectricity = $data->sum('electricity');
        $totalCooperative = $data->sum('cooperative');
        $totalPinjaman = $data->sum('pinjaman');
        $totalOther = $data->sum('other');
        // dd($totalUnion);

        return view('salary_month.index', compact(
            'title', 'selectedStatus', 'data', 'statuses', 'selectedYear', 'years', 'selectedMonth', 'months', 'statuses_id',
            'totalHourCall', 'totalTotalOT', 'totalThr', 'totalBonus', 'totalIncentive', 'totalUnion', 'totalAbsent', 'totalElectricity', 'totalCooperative', 'totalPinjaman', 'totalOther',
        ));
    }

    public function filter()
    {
        $title = 'Filter Salary Per Month';

        $statuses = User::distinct('status')->pluck('status')->toArray();
        $years = SalaryYear::distinct('year')->pluck('year')->toArray();

        $statusFilter = request()->input('id_status', null);
        $yearFilter = request()->input('year', null);
        $monthFilter = request()->input('month', null);

        return view('salary_month.filter', compact('title', 'statusFilter', 'yearFilter', 'statuses', 'monthFilter', 'years',));
    }

    public function create()
    {
        $title = 'Input Salary Per Month';

        $statuses = User::distinct('status')->pluck('status')->toArray();
        $years = SalaryYear::distinct('year')->pluck('year')->toArray();

        $statusFilter = request()->input('id_status');
        $yearFilter = request()->input('year');
        $monthFilter = request()->input('month');

        $checkYear = SalaryMonth::whereYear('date', $yearFilter)->first();
        $checkMonth = SalaryMonth::whereMonth('date', $monthFilter)->first();
        $checkStatus = DB::table('salary_months')
            ->join('salary_years', 'salary_years.id', '=', 'salary_months.id_salary_year')
            ->join('users', 'users.nik', '=', 'salary_years.nik')
            ->where('users.status', $statusFilter)
            ->first();

        //     dd($checkYear, $checkMonth, $checkStatus);

        // $global = DB::table('salary_years')
        //     ->join('users', 'salary_years.nik', '=', 'users.nik')
        //     ->select('salary_years.id as salary_years_id')
        //     ->where('users.status', $statusFilter)
        //     ->get();

        // foreach ($global as $g) {
        //     SalaryMonth::create([
        //         'id_salary_year' =>$g->salary_years_id,
        //         'date' => $yearFilter . '-' . $monthFilter . '-13',
        //     ]);
        // }

        // $data = DB::table('users')
        //     ->join('grade', 'users.grade', '=', 'grade.name_grade')
        //     ->join('salary_years', 'salary_years.nik', '=', 'users.nik')
        //     ->join('salary_months', 'salary_months.id_salary_year', '=', 'salary_years.id')
        //     ->where('users.active', 'yes')
        //     ->where('users.status', $statusFilter)
        //     ->whereMonth('salary_months.date', $monthFilter)
        //     ->select('users.*', 'grade.*', 'users.nik as id_user', 'salary_years.id as id_salary_year', 'grade.id as id_grade', 'salary_years.*')
        //     ->get();

        if ($checkStatus != null) {
            if ($checkYear != null && $checkMonth != null) {

                $data = DB::table('salary_months')
                    ->join('salary_years', 'salary_years.id', '=', 'salary_months.id_salary_year')
                    ->join('users', 'users.nik', '=', 'salary_years.nik')
                    ->join('grade', 'users.grade', '=', 'grade.name_grade')
                    ->select('salary_months.*', 'salary_years.*', 'users.*', 'grade.*', 'salary_months.id as id_salary_month')
                    ->whereYear('salary_months.date', $yearFilter)
                    ->whereMonth('salary_months.date', $monthFilter)
                    ->get();

            } elseif ($checkYear != null && $checkMonth == null) {

                $global = DB::table('salary_years')
                    ->join('users', 'salary_years.id_user', '=', 'users.id')
                    ->join('statuses', 'users.id_status', '=', 'statuses.id')
                    ->select('salary_years.id as salary_years_id')
                    ->where('salary_years.used', 1)
                    ->where('users.id_status', $statusFilter)
                    ->get();

                foreach ($global as $g) {
                    SalaryMonth::create([
                        'id_salary_year' =>$g->salary_years_id,
                        'date' => $yearFilter . '-' . $monthFilter . '-13',
                    ]);
                }

                $data = DB::table('salary_months')
                    ->join('salary_years', 'salary_years.id', '=', 'salary_months.id_salary_year')
                    ->join('salary_grades', 'salary_grades.id', '=', 'salary_years.id_salary_grade')
                    ->join('users', 'users.id', '=', 'salary_years.id_user')
                    ->join('statuses', 'users.id_status', '=', 'statuses.id')
                    ->join('depts', 'users.id_dept', '=', 'depts.id')
                    ->join('jobs', 'users.id_job', '=', 'jobs.id')
                    ->join('grades', 'users.id_grade', '=', 'grades.id')
                    ->where('users.id_status', $statusFilter)
                    ->whereMonth('salary_months.date', $monthFilter)
                    ->select('salary_months.*', 'salary_years.*', 'salary_grades.*', 'users.*', 'statuses.*', 'depts.*', 'jobs.*', 'grades.*', 'salary_months.id as id_salary_month')
                    ->get();
            }
        } else {
            $data = DB::table('users')
                ->join('grade', 'users.grade', '=', 'grade.name_grade')
                ->join('salary_years', 'salary_years.nik', '=', 'users.nik')
                ->where('users.active', 'yes')
                ->where('users.status', $statusFilter)
                ->select('users.*', 'grade.*', 'users.nik as id_user', 'salary_years.id as id_salary_year')
                ->get();
        }

        return view('salary_month.create',[
            'title' => $title,
            'statuses' => $statuses,
            'years' => $years,
            'statusFilter' => $statusFilter,
            'yearFilter' => $yearFilter,
            'monthFilter' => $monthFilter,
            'data' => $data,

        ]);
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
        $pinjaman = $request->input('pinjaman')[$key] ?? 0;
        $other = $request->input('other')[$key] ?? 0;
        $total_ben_ded = $request->input('total_ben_ded')[$key] ?? 0;

        $gross_sal = $rate_salary + $ability + $fungtional_alw + $family_alw + $transport_alw + $skill_alw + $telephone_alw +
            $adjustment + $total_overtime + $thr + $bonus + $incentive;
        $total_deduction = $bpjs + $jamsostek + $union + $absent + $electricity + $cooperative + $pinjaman + $other;
        $net_salary = ($gross_sal + $total_ben) - ($total_deduction + $total_ben_ded);

        SalaryMonth::updateOrCreate(
            [
                'id' => $request->input('id_salary_month')[$key],
                'date' => $request->input('date_input')[$key],
            ],
            [
                'id_salary_year' => $request->input('id_salary_year')[$key],
                'hour_call' => $request->input('hour_call')[$key] ?? 0,
                'total_overtime' => $total_overtime,
                'thr' => $thr,
                'bonus' => $bonus,
                'incentive' => $incentive,
                'union' => $union,
                'absent' => $absent,
                'electricity' => $electricity,
                'cooperative' => $cooperative,
                'pinjaman' => $pinjaman,
                'other' => $other,
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
        $monthYear = $request->input('date');
        $date = $monthYear . '-13';
        $status = $request->input('filter_status');
        return (new SalaryMonthExport($date, $status))->download($date . '_salary_month_' . $status .'.xlsx');
    }

    public function import()
    {
        Excel::import(new SalaryMonthImport,request()->file('file'));

        return back();
    }
}
