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
    public function index(Request $request)
    {
        $title = 'Salary Per Month';

        $jwt_token = session('jwt_token') ?? $request->jwt_token;
        $role = session('role') ?? $request->role;
        $nik = session('nik') ?? $request->nik;
        $dept = session('dept') ?? $request->dept;
        $jabatan = session('jabatan') ?? $request->jabatan;
        $name = User::where('nik', $nik)->value('name');

        $data = DB::table('salary_months')
            ->join('salary_years', 'salary_years.id', '=', 'salary_months.id_salary_year')
            ->join('users', 'users.nik', '=', 'salary_years.nik')
            ->join('grade', 'users.grade', '=', 'grade.name_grade')
            ->select('salary_months.*', 'salary_years.*', 'users.*', 'grade.name_grade as grades_name', 'salary_months.id as id_salary_month')
            ->select('salary_months.id as id_salary_month', 'salary_years.id as id_salary_year', 'salary_years.nik')
            ->where('users.active', 'yes')
            // ->where('salary_months.id_salary_year', 150)
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
                ->where('users.active', 'yes')
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
                    ->where('users.active', 'yes')
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
                    ->where('users.active', 'yes')
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
        $totalInternet = $data->sum('internet');
        $totalGas = $data->sum('gas');
        $totalWater = $data->sum('water');
        $totalPinjaman = $data->sum('pinjaman');
        $totalOther = $data->sum('other');
        // dd($totalUnion);

        // dd($data);

        return view('salary_month.index', compact(
            'title', 'selectedStatus', 'data', 'statuses', 'selectedYear', 'years', 'selectedMonth', 'months', 'statuses_id',
            'totalHourCall', 'totalTotalOT', 'totalThr', 'totalBonus', 'totalIncentive', 'totalUnion', 'totalAbsent', 'totalElectricity', 'totalCooperative', 'totalPinjaman', 'totalOther',
            'name', 'role', 'nik', 'dept', 'jabatan', 'jwt_token', 'totalInternet', 'totalGas', 'totalWater'
        ));
    }

    public function filter(Request $request)
    {
        $title = 'Filter Salary Per Month';

        $statuses = User::distinct('status')->pluck('status')->toArray();
        $years = SalaryYear::distinct('year')->pluck('year')->toArray();

        $jwt_token = session('jwt_token') ?? $request->jwt_token;
        $role = session('role') ?? $request->role;
        $nik = session('nik') ?? $request->nik;
        $dept = session('dept') ?? $request->dept;
        $jabatan = session('jabatan') ?? $request->jabatan;
        $name = User::where('nik', $nik)->value('name');

        $statusFilter = request()->input('id_status', null);
        $yearFilter = request()->input('year', null);
        $monthFilter = request()->input('month', null);

        return view('salary_month.filter', compact('title', 'statusFilter', 'yearFilter', 'statuses', 'monthFilter', 'years', 'name', 'role', 'nik', 'dept', 'jabatan', 'jwt_token'));
    }

    public function create(Request $request)
    {
        $title = 'Input Salary Per Month';

        $jwt_token = session('jwt_token') ?? $request->jwt_token;
        $role = session('role') ?? $request->role;
        $nik = session('nik') ?? $request->nik;
        $dept = session('dept') ?? $request->dept;
        $jabatan = session('jabatan') ?? $request->jabatan;
        $name = User::where('nik', $nik)->value('name');

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
            ->where('salary_years.year', $yearFilter)
            ->whereMonth('salary_months.date', $monthFilter)
            ->first();

            // dd($checkYear != null && $checkMonth != null);

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
                    ->where('users.status', $statusFilter)
                    ->whereYear('salary_months.date', $yearFilter)
                    ->whereMonth('salary_months.date', $monthFilter)
                    ->where('users.active', 'yes')
                    ->get();

            } elseif ($checkYear != null && $checkMonth == null) {

                $global = DB::table('salary_years')
                    ->join('users', 'salary_years.nik', '=', 'users.nik')
                    ->select('salary_years.id as salary_years_id')
                    ->where('users.status', $statusFilter)
                    ->where('users.active', 'yes')
                    ->get();

                foreach ($global as $g) {
                    SalaryMonth::create([
                        'id_salary_year' =>$g->salary_years_id,
                        'date' => $yearFilter . '-' . $monthFilter . '-13',
                    ]);
                }

                $data = DB::table('users')
                    ->join('grade', 'users.grade', '=', 'grade.name_grade')
                    ->join('salary_years', 'salary_years.nik', '=', 'users.nik')
                    ->join('salary_months', 'salary_months.id_salary_year', '=', 'salary_years.id')
                    ->where('users.active', 'yes')
                    ->where('users.status', $statusFilter)
                    ->whereMonth('salary_months.date', $monthFilter)
                    ->where('users.active', 'yes')
                    ->select('users.*', 'grade.*', 'users.nik as id_user', 'salary_years.id as id_salary_year', 'grade.id as id_grade', 'salary_years.*')
                    ->get();
            }
        // } elseif ($data->isEmpty()) {
        //     $data = DB::table('users')
        //         ->join('grade', 'users.grade', '=', 'grade.name_grade')
        //         ->join('salary_years', 'salary_years.nik', '=', 'users.nik')
        //         ->where('users.active', 'yes')
        //         ->where('users.status', $statusFilter)
        //         ->where('users.active', 'yes')
        //         ->select('users.*', 'grade.*', 'users.nik as id_user', 'salary_years.id as id_salary_year')
        //         ->get();
        } else {
            $data = DB::table('users')
                ->join('grade', 'users.grade', '=', 'grade.name_grade')
                ->join('salary_years', 'salary_years.nik', '=', 'users.nik')
                ->where('users.active', 'yes')
                ->where('users.status', $statusFilter)
                ->where('users.active', 'yes')
                ->select('users.*', 'grade.*', 'users.nik as id_user', 'salary_years.id as id_salary_year')
                ->get();
        }

        // dd($data);

        return view('salary_month.create',[
            'title' => $title,
            'statuses' => $statuses,
            'years' => $years,
            'statusFilter' => $statusFilter,
            'yearFilter' => $yearFilter,
            'monthFilter' => $monthFilter,
            'data' => $data,
            'name' => $name,
            'role' => $role,
            'nik' => $nik,
            'dept' => $dept,
            'jabatan' => $jabatan,
            'jwt_token' => $jwt_token

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
        $internet = $request->input('internet')[$key] ?? 0;
        $gas = $request->input('gas')[$key] ?? 0;
        $water = $request->input('water')[$key] ?? 0;
        $pinjaman = $request->input('pinjaman')[$key] ?? 0;
        $other = $request->input('other')[$key] ?? 0;
        $total_ben_ded = $request->input('total_ben_ded')[$key] ?? 0;

        $gross_sal = $rate_salary + $ability + $fungtional_alw + $family_alw + $transport_alw + $skill_alw + $telephone_alw +
            $adjustment + $total_overtime + $thr + $bonus + $incentive;
        $total_deduction = $bpjs + $jamsostek + $union + $absent + $electricity + $cooperative + $pinjaman + $other + $internet + $gas +$water;
        // $net_salary = ($gross_sal + $total_ben) - ($total_deduction + $total_ben_ded);
        $net_salary = $gross_sal - $total_deduction;

        SalaryMonth::updateOrCreate(
            [
                'id_salary_year' => $request->input('id_salary_year')[$key],
                'date' => $request->input('date_input')[$key],
            ],
            [
                // 'id_salary_year' => $request->input('id_salary_year')[$key],
                'hour_call' => $request->input('hour_call')[$key] ?? 0,
                'total_overtime' => $total_overtime,
                'thr' => $thr,
                'bonus' => $bonus,
                'incentive' => $incentive,
                'union' => $union,
                'absent' => $absent,
                'electricity' => $electricity,
                'cooperative' => $cooperative,
                'internet' => $internet,
                'gas' => $gas,
                'water' => $water,
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
        $selectedIds = $request->input('ids', '');

        $jwt_token = session('jwt_token') ?? $request->jwt_token;
        $role = session('role') ?? $request->role;
        $nik = session('nik') ?? $request->nik;
        $dept = session('dept') ?? $request->dept;
        $jabatan = session('jabatan') ?? $request->jabatan;
        $name = User::where('nik', $nik)->value('name');

        if (is_string($selectedIds)) {
            $selectedIds = explode(',', $selectedIds);
        }

        if (empty($selectedIds)) {
            return redirect()->route('salary-month')->with('error', 'No data selected for editing.');
        }

        $title = 'Salary Per Month';

        $salary_months = DB::table('salary_months')
            ->join('salary_years', 'salary_months.id_salary_year', '=', 'salary_years.id')
            ->join('users', 'salary_years.nik', '=', 'users.nik')
            ->join('grade', 'salary_years.id_salary_grade', '=', 'grade.id')
            ->select(
                'users.nik',
                'users.name',
                'users.status',
                'users.dept',
                'users.jabatan',
                'users.grade',
                'grade.rate_salary',
                'grade.name_grade',
                'salary_years.id_salary_grade',
                'salary_years.ability',
                'salary_years.fungtional_alw',
                'salary_years.family_alw',
                'salary_years.transport_alw',
                'salary_years.telephone_alw',
                'salary_years.skill_alw',
                'salary_years.bpjs',
                'salary_years.jamsostek',
                'salary_years.adjustment',
                'salary_years.year',
                'salary_years.allocation',
                'salary_years.id as salary_years_id',
                'salary_months.id as salary_months_id',
                'salary_months.hour_call',
                'salary_months.thr',
                'salary_months.bonus',
                'salary_months.incentive',
                'salary_months.union',
                'salary_months.absent',
                'salary_months.electricity',
                'salary_months.cooperative',
                'salary_months.internet',
                'salary_months.gas',
                'salary_months.water',
                'salary_months.pinjaman',
                'salary_months.other',
                'salary_months.date',
            )
            ->whereIn('salary_months.id', $selectedIds)
            ->get();

        return view('salary_month.edit', compact('title', 'salary_months', 'name', 'role', 'nik', 'dept', 'jabatan', 'jwt_token'));
    }

    public function update(Request $request)
    {
        foreach ($request->input('ids') as $id) {

            $input = $request->only([
                'rate_salary', 'ability', 'fungtional_alw', 'family_alw',
                'transport_alw', 'telephone_alw', 'skill_alw', 'adjustment',
                'total_overtime', 'thr', 'bonus', 'incentive', 'total_ben',
                'bpjs', 'jamsostek', 'union', 'absent', 'electricity',
                'cooperative', 'total_ben_ded', 'hour_call', 'internet', 'gas', 'water'
            ]);

            $rate_salary = $request->has('rate_salary.' . $id) ? (int) str_replace(',', '', $request->input('rate_salary.' . $id)) : 0;
            $ability = $request->has('ability.' . $id) ? (int) str_replace(',', '', $request->input('ability.' . $id)) : 0;
            $fungtional_alw = $request->has('fungtional_alw.' . $id) ? (int) str_replace(',', '', $request->input('fungtional_alw.' . $id)) : 0;
            $family_alw = $request->has('family_alw.' . $id) ? (int) str_replace(',', '', $request->input('family_alw.' . $id)) : 0;
            $transport_alw = $request->has('transport_alw.' . $id) ? (int) str_replace(',', '', $request->input('transport_alw.' . $id)) : 0;
            $telephone_alw = $request->has('telephone_alw.' . $id) ? (int) str_replace(',', '', $request->input('telephone_alw.' . $id)) : 0;
            $skill_alw = $request->has('skill_alw.' . $id) ? (int) str_replace(',', '', $request->input('skill_alw.' . $id)) : 0;
            $adjustment = $request->has('adjustment.' . $id) ? (int) str_replace(',', '', $request->input('adjustment.' . $id)) : 0;

            $hour_call = $request->has('hour_call.' . $id) ? (int) str_replace(',', '', $request->input('hour_call.' . $id)) : 0;
            $total_overtime = $request->has('total_overtime.' . $id) ? (int) str_replace(',', '', $request->input('total_overtime.' . $id)) : 0;
            $thr = $request->has('thr.' . $id) ? (int) str_replace(',', '', $request->input('thr.' . $id)) : 0;
            $bonus = $request->has('bonus.' . $id) ? (int) str_replace(',', '', $request->input('bonus.' . $id)) : 0;
            $incentive = $request->has('incentive.' . $id) ? (int) str_replace(',', '', $request->input('incentive.' . $id)) : 0;
            $total_ben = $request->has('total_ben.' . $id) ? (int) str_replace(',', '', $request->input('total_ben.' . $id)) : 0;

            $bpjs = $request->has('bpjs.' . $id) ? (int) str_replace(',', '', $request->input('bpjs.' . $id)) : 0;
            $jamsostek = $request->has('jamsostek.' . $id) ? (int) str_replace(',', '', $request->input('jamsostek.' . $id)) : 0;
            $union = $request->has('union.' . $id) ? (int) str_replace(',', '', $request->input('union.' . $id)) : 0;
            $absent = $request->has('absent.' . $id) ? (int) str_replace(',', '', $request->input('absent.' . $id)) : 0;
            $electricity = $request->has('electricity.' . $id) ? (int) str_replace(',', '', $request->input('electricity.' . $id)) : 0;
            $cooperative = $request->has('cooperative.' . $id) ? (int) str_replace(',', '', $request->input('cooperative.' . $id)) : 0;
            $pinjaman = $request->has('pinjaman.' . $id) ? (int) str_replace(',', '', $request->input('pinjaman.' . $id)) : 0;
            $internet = $request->has('internet.' . $id) ? (int) str_replace(',', '', $request->input('internet.' . $id)) : 0;
            $gas = $request->has('gas.' . $id) ? (int) str_replace(',', '', $request->input('gas.' . $id)) : 0;
            $water = $request->has('water.' . $id) ? (int) str_replace(',', '', $request->input('water.' . $id)) : 0;
            $other = $request->has('other.' . $id) ? (int) str_replace(',', '', $request->input('other.' . $id)) : 0;
            $total_ben_ded = $request->has('total_ben_ded.' . $id) ? (int) str_replace(',', '', $request->input('total_ben_ded.' . $id)) : 0;

            $gross_sal = $rate_salary + $ability + $fungtional_alw + $family_alw + $transport_alw + $skill_alw + $telephone_alw + $adjustment + $total_overtime + $thr + $bonus + $incentive;
            $total_deduction = $bpjs + $jamsostek + $union + $absent + $electricity + $cooperative + $pinjaman + $other + $internet + $gas + $water;
            $gaji_bersih = $gross_sal - ($bpjs + $jamsostek + $union + $absent + $electricity + $pinjaman + $other);
            $net_salary = $gaji_bersih - $cooperative;

            // dd($gross_sal, $total_deduction, $gaji_bersih, $net_salary);

            // $allocations = $request->input('allocation.' . $id) ?? NULL;
            // if ($allocations) {
            //     $allocationJson = json_encode($allocations);
            // } else {
            //     $allocationJson = $allocations;
            // }

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
                'internet' => $internet,
                'gas' => $gas,
                'water' => $water,
                'other' => $other,
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
