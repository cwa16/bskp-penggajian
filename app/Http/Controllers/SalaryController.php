<?php

namespace App\Http\Controllers;

use App\Models\SalaryMonth;
use App\Models\Status;
use App\Models\SalaryYear;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;
use PDF;
use Twilio\Rest\Client;
use WaAPI\WaAPI;
use Illuminate\Support\Str;
use App\Jobs\SendCheckedSalaryJob;

class SalaryController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Salary';

        $jwt_token = session('jwt_token') ?? $request->jwt_token;
        $role = session('role') ?? $request->role;
        $nik = session('nik') ?? $request->nik;
        $dept = session('dept') ?? $request->dept;
        $jabatan = session('jabatan') ?? $request->jabatan;

        $name = User::where('nik', $nik)->value('name');

        // $data = DB::table('salary_months')
        //         ->join('salary_years', 'salary_years.id', '=', 'salary_months.id_salary_year')
        //         ->join('users', 'users.nik', '=', 'salary_years.nik')
        //         ->join('grade', 'users.grade', '=', 'grade.name_grade')
        //         ->select('salary_months.*', 'salary_years.*', 'users.*', 'grade.*', 'salary_months.date as salary_month_date','salary_months.id as salary_month_id')
        //         ->get();


        $salary_months = SalaryMonth::all();

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

        $query = SalaryMonth::with('salary_year');

        $selectedYear = trim(request()->input('filter_year', ''));
        $selectedMonth = trim(request()->input('filter_month', ''));
        $selectedStatus = trim(request()->input('filter_status', ''));
        $selectedApprove = trim(request()->input('filter_approval', ''));


        $selectedYear = (int) $selectedYear;
        $selectedMonth = (int) $selectedMonth;

        $subMonth = Carbon::now()->subMonth()->format('m');
        $subMonthNd = Carbon::now()->subMonth(2)->format('m');

        if ($selectedYear == null && $selectedMonth == null && $selectedStatus == null && $selectedApprove == null) {
            $data = DB::table('salary_months')
                ->join('salary_years', 'salary_months.id_salary_year', '=', 'salary_years.id')
                ->join('users', 'users.nik', '=', 'salary_years.nik')
                ->join('grade', 'users.grade', '=', 'grade.name_grade')
                ->select('salary_months.*', 'salary_years.*', 'users.*', 'grade.*', 'salary_months.date as salary_month_date', 'salary_months.id as salary_month_id')
                ->whereIn('users.status', ['Manager', 'Staff', 'Monthly', 'Contract BSKP'])
                ->where('users.active', 'yes')
                ->whereMonth('salary_months.date', $subMonth)
                ->get();
        } else {
            if ($selectedStatus == 'All Status') {
                if ($selectedApprove == 1) {
                    $data = DB::table('salary_months')
                        ->join('salary_years', 'salary_years.id', '=', 'salary_months.id_salary_year')
                        ->join('grade', 'grade.id', '=', 'salary_years.id_salary_grade')
                        ->join('users', 'users.nik', '=', 'salary_years.nik')
                        ->select('salary_months.*', 'salary_years.*', 'users.*', 'grade.*', 'salary_months.date as salary_month_date', 'salary_months.id as salary_month_id')
                        ->whereYear('salary_months.date', $selectedYear)
                        ->whereMonth('salary_months.date', $selectedMonth)
                        ->where('salary_months.is_approved', 1)
                        ->where('users.active', 'yes')
                        ->get();
                } else {
                    $data = DB::table('salary_months')
                        ->join('salary_years', 'salary_years.id', '=', 'salary_months.id_salary_year')
                        ->join('grade', 'grade.id', '=', 'salary_years.id_salary_grade')
                        ->join('users', 'users.nik', '=', 'salary_years.nik')
                        ->select('salary_months.*', 'salary_years.*', 'users.*', 'grade.*', 'salary_months.date as salary_month_date', 'salary_months.id as salary_month_id')
                        ->whereYear('salary_months.date', $selectedYear)
                        ->whereMonth('salary_months.date', $selectedMonth)
                        // ->where('salary_months.is_approved', 0)
                        ->where('users.active', 'yes')
                        ->get();
                }
            } else {
                if ($selectedApprove == 1) {
                    $data = DB::table('salary_months')
                        ->join('salary_years', 'salary_years.id', '=', 'salary_months.id_salary_year')
                        ->join('grade', 'grade.id', '=', 'salary_years.id_salary_grade')
                        ->join('users', 'users.nik', '=', 'salary_years.nik')
                        ->select('salary_months.*', 'salary_years.*', 'users.*', 'grade.*', 'salary_months.date as salary_month_date', 'salary_months.id as salary_month_id')
                        ->where('users.status', $selectedStatus)
                        ->whereYear('salary_months.date', $selectedYear)
                        ->whereMonth('salary_months.date', $selectedMonth)
                        ->where('salary_months.is_approved', 1)
                        ->where('users.active', 'yes')
                        ->get();
                } else {
                    $data = DB::table('salary_months')
                        ->join('salary_years', 'salary_years.id', '=', 'salary_months.id_salary_year')
                        ->join('grade', 'grade.id', '=', 'salary_years.id_salary_grade')
                        ->join('users', 'users.nik', '=', 'salary_years.nik')
                        ->select('salary_months.*', 'salary_years.*', 'users.*', 'grade.*', 'salary_months.date as salary_month_date', 'salary_months.id as salary_month_id')
                        ->where('users.status', $selectedStatus)
                        ->whereYear('salary_months.date', $selectedYear)
                        ->whereMonth('salary_months.date', $selectedMonth)
                        // ->where('salary_months.is_approved', 0)
                        ->where('users.active', 'yes')
                        ->get();
                }
            }
        }

        $totalAbility = $data->sum('ability');
        $totalFungtionalAlw = $data->sum('fungtional_alw');
        $totalFamilyAlw = $data->sum('family_alw');
        $totalTransportAlw = $data->sum('transport_alw');
        $totalTelephoneAlw = $data->sum('telephone_alw');
        $totalSkillAlw = $data->sum('skill_alw');
        $totalAdjustment = $data->sum('adjustment');
        $totalBpjs = $data->sum('bpjs');
        $totalJamsostek = $data->sum('jamsostek');

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
        $totalTotalded = $data->sum('total_deduction');
        $totalNetsalary = $data->sum('net_salary');

        $totalRateSalary = $data->sum(function ($data) {
            return $data->rate_salary;
        });

        return view('salary.index', compact(
            'title',
            'statuses',
            'years',
            'months',
            'salary_months',
            'selectedStatus',
            'selectedYear',
            'selectedMonth',
            'data',
            'totalFamilyAlw',
            'totalAbility',
            'totalFungtionalAlw',
            'totalTransportAlw',
            'totalTelephoneAlw',
            'totalSkillAlw',
            'totalAdjustment',
            'totalBpjs',
            'totalJamsostek',
            'totalRateSalary',
            'totalHourCall',
            'totalTotalOT',
            'totalThr',
            'totalBonus',
            'totalIncentive',
            'totalUnion',
            'totalAbsent',
            'totalElectricity',
            'totalCooperative',
            'totalInternet',
            'totalWater',
            'totalGas',
            'totalPinjaman',
            'totalOther',
            'totalTotalded',
            'totalNetsalary',
            'selectedApprove',
            'jwt_token',
            'role',
            'nik',
            'dept',
            'jabatan',
            'name',
        ));
    }

    public function salary_check(Request $request)
    {
        $selectedIds = $request->input('salary_ids');

        if ($selectedIds) {
            foreach ($selectedIds as $id) {
                DB::table('salary_months')
                    ->where('id', $id)
                    ->update([
                        'is_checked' => 1,
                    ]);
            }

            return redirect()->back()->with('success', 'Data berhasil diperbarui.');
        } else {
            return redirect()->back()->with('error', 'Tidak ada data yang dipilih.');
        }
    }

    public function salary_approved(Request $request)
    {
        $selectedIds = $request->input('salary_ids');

        $data = DB::table('salary_months')
            ->join('salary_years', 'salary_years.id', '=', 'salary_months.id_salary_year')
            ->join('grade', 'salary_years.id_salary_grade', '=', 'grade.id')
            ->select(
                'salary_months.*',
                'grade.name_grade',
                'grade.rate_salary',
                'salary_years.nik',
                'salary_years.year',
                'salary_years.ability',
                'salary_years.fungtional_alw',
                'salary_years.family_alw',
                'salary_years.transport_alw',
                'salary_years.skill_alw',
                'salary_years.telephone_alw',
                'salary_years.adjustment',
                'salary_years.bpjs',
                'salary_years.jamsostek',
                'salary_years.total_ben',
                'salary_years.total_ben_ded'
            )
            ->whereIn('salary_months.id', $selectedIds)
            ->get();

        if ($data != null) {
            $approve = DB::table('salary_months')
                ->whereIn('id', $selectedIds)
                ->update([
                    'is_checked' => 1,
                    'is_approved' => 1
                ]);
        }

        if ($approve) {
            $created_at = Carbon::now();
            foreach ($data as $emp) {
                DB::table('all_salary_data')->insert([
                    'nik' => $emp->nik,
                    'salary_grade' => $emp->name_grade,
                    'rate_salary' => $emp->rate_salary,
                    'date' => $emp->date,
                    'year' => $emp->year,
                    'ability' => $emp->ability,
                    'fungtional_alw' => $emp->fungtional_alw,
                    'family_alw' => $emp->family_alw,
                    'transport_alw' => $emp->transport_alw,
                    'skill_alw' => $emp->skill_alw,
                    'telephone_alw' => $emp->telephone_alw,
                    'adjustment' => $emp->adjustment,
                    'bpjs' => $emp->bpjs,
                    'jamsostek' => $emp->jamsostek,
                    'total_ben' => $emp->total_ben,
                    'total_ben_ded' => $emp->total_ben_ded,
                    'total_overtime' => $emp->total_overtime,
                    'thr' => $emp->thr,
                    'bonus' => $emp->bonus,
                    'incentive' => $emp->incentive,
                    'union' => $emp->union,
                    'absent' => $emp->absent,
                    'electricity' => $emp->electricity,
                    'cooperative' => $emp->cooperative,
                    'pinjaman' => $emp->pinjaman,
                    'other' => $emp->other,
                    'gross_salary' => $emp->gross_salary,
                    'total_deduction' => $emp->total_deduction,
                    'net_salary' => $emp->net_salary,
                    'created_at' => $created_at,
                ]);
            }
            return redirect()->back()->with('success', 'Data berhasil disimpan ke database.');
        } else {
            return redirect()->back()->with('error', 'Data tidak berhasil disimpan ke database.');
        }
    }

    public function salary_print(Request $request)
    {
        $title = 'Salary';

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
            ->select('salary_months.*', 'salary_years.*', 'users.*', 'grade.*', 'salary_months.date as salary_month_date', 'salary_months.id as salary_month_id')
            ->get();

        $salary_months = SalaryMonth::all();

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

        $query = SalaryMonth::with('salary_year');

        $selectedYear = trim(request()->input('filter_year', ''));
        $selectedMonth = trim(request()->input('filter_month', ''));
        $selectedStatus = trim(request()->input('filter_status', ''));

        $selectedYear = (int) $selectedYear;
        $selectedMonth = (int) $selectedMonth;

        $subMonth = Carbon::now()->subMonth()->format('m');
        $subMonthNd = Carbon::now()->subMonth(2)->format('m');

        if ($selectedYear == null && $selectedMonth == null && $selectedStatus == null) {
            $data = DB::table('salary_months')
                ->join('salary_years', 'salary_years.id', '=', 'salary_months.id_salary_year')
                ->join('users', 'users.nik', '=', 'salary_years.nik')
                ->join('grade', 'users.grade', '=', 'grade.name_grade')
                ->select('salary_months.*', 'salary_years.*', 'users.*', 'grade.*', 'salary_months.date as salary_month_date', 'salary_months.id as salary_month_id')
                ->whereIn('users.status', ['Manager', 'Staff', 'Monthly', 'Contract BSKP'])
                ->where('users.active', 'yes')
                ->where(function($query) use ($subMonth, $subMonthNd) {
                    $query->whereMonth('salary_months.date', $subMonth)
                    ->orWhereMonth('salary_months.date', $subMonthNd);
                })
                ->get();
        } else {
            if ($selectedStatus == 'All Status') {
                $data = DB::table('salary_months')
                    ->join('salary_years', 'salary_years.id', '=', 'salary_months.id_salary_year')
                    ->join('grade', 'grade.id', '=', 'salary_years.id_salary_grade')
                    ->join('users', 'users.nik', '=', 'salary_years.nik')
                    ->select('salary_months.*', 'salary_years.*', 'users.*', 'grade.*', 'salary_months.date as salary_month_date', 'salary_months.id as salary_month_id')
                    ->whereYear('salary_months.date', $selectedYear)
                    ->whereMonth('salary_months.date', $selectedMonth)
                    ->get();
            } else {
                $data = DB::table('salary_months')
                    ->join('salary_years', 'salary_years.id', '=', 'salary_months.id_salary_year')
                    ->join('grade', 'grade.id', '=', 'salary_years.id_salary_grade')
                    ->join('users', 'users.nik', '=', 'salary_years.nik')
                    ->select('salary_months.*', 'salary_years.*', 'users.*', 'grade.*', 'salary_months.date as salary_month_date', 'salary_months.id as salary_month_id')
                    ->where('users.status', $selectedStatus)
                    ->whereYear('salary_months.date', $selectedYear)
                    ->whereMonth('salary_months.date', $selectedMonth)
                    ->get();
            }
        }

        $totalAbility = $data->sum('ability');
        $totalFungtionalAlw = $data->sum('fungtional_alw');
        $totalFamilyAlw = $data->sum('family_alw');
        $totalTransportAlw = $data->sum('transport_alw');
        $totalTelephoneAlw = $data->sum('telephone_alw');
        $totalSkillAlw = $data->sum('skill_alw');
        $totalAdjustment = $data->sum('adjustment');
        $totalBpjs = $data->sum('bpjs');
        $totalJamsostek = $data->sum('jamsostek');

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
        $totalTotalded = $data->sum('total_deduction');
        $totalNetsalary = $data->sum('net_salary');

        $totalRateSalary = $data->sum(function ($data) {
            return $data->rate_salary;
        });

        return view('salary.print_index', compact(
            'title',
            'statuses',
            'years',
            'months',
            'salary_months',
            'selectedStatus',
            'selectedYear',
            'selectedMonth',
            'data',
            'totalFamilyAlw',
            'totalAbility',
            'totalFungtionalAlw',
            'totalTransportAlw',
            'totalTelephoneAlw',
            'totalSkillAlw',
            'totalAdjustment',
            'totalBpjs',
            'totalJamsostek',
            'totalRateSalary',
            'totalHourCall',
            'totalTotalOT',
            'totalThr',
            'totalBonus',
            'totalIncentive',
            'totalUnion',
            'totalAbsent',
            'totalElectricity',
            'totalCooperative',
            'totalInternet',
            'totalGas',
            'totalWater',
            'totalPinjaman',
            'totalOther',
            'totalTotalded',
            'totalNetsalary',
            'jwt_token',
            'role',
            'nik',
            'dept',
            'jabatan',
            'name',
        ));
    }

    public function print($id)
    {
        $sal = DB::table('salary_months')
            ->join('salary_years', 'salary_years.id', '=', 'salary_months.id_salary_year')
            ->join('grade', 'salary_years.id_salary_grade', '=', 'grade.id')
            ->join('users', 'users.nik', '=', 'salary_years.nik')
            ->select(
                'users.nik as Emp_Code',
                'users.name as Nama',
                'users.status as Status',
                'users.dept as Dept',
                'users.jabatan as Jabatan',
                'users.start_work_user',
                'grade.name_grade as Grade',
                'grade.rate_salary',
                'salary_years.*',
                'salary_months.*',
                'salary_months.absent',
                'salary_months.electricity',
                'salary_months.cooperative',
                'salary_months.pinjaman',
                'salary_months.other',
                'salary_months.date as salary_months_date',
                'salary_months.total_deduction',
                'salary_months.net_salary'
            )
            ->where('salary_months.id', $id)
            ->first();

            // dd($sal->hour_call);

            $date = date('My', strtotime($sal->salary_months_date));

        if (!$sal) {
            dd("Salary with ID $id not found.");
        }

        $rate_salary = $sal->rate_salary;
        $ability = $sal->ability;
        $fungtional_alw = $sal->fungtional_alw;
        $family_alw = $sal->family_alw;

        $total = $rate_salary + $ability + $fungtional_alw + $family_alw;

        $pdf = PDF::loadView('salary.print', compact('sal', 'total'));
        return $pdf->setPaper('a5', 'landscape')->stream('SAL_' . $date . '_' . $sal->Emp_Code . '_' . $sal->Nama . '.pdf');
    }

    public function printMultiple(Request $request)
    {
        $salaryIds = $request->input('salary_ids');

        if (empty($salaryIds)) {
            return back()->with('error', 'Please select at least one salary to print.');
        }

        // $salaries = SalaryMonth::whereIn('id', $salaryIds)->get();

        $salaries = DB::table('salary_months')
            ->join('salary_years', 'salary_years.id', '=', 'salary_months.id_salary_year')
            ->join('grade', 'salary_years.id_salary_grade', '=', 'grade.id')
            ->join('users', 'users.nik', '=', 'salary_years.nik')
            ->select(
                'users.nik as Emp_Code',
                'users.name as Nama',
                'users.status as Status',
                'users.dept as Dept',
                'users.jabatan as Jabatan',
                'users.start_work_user',
                'grade.name_grade as Grade',
                'grade.rate_salary',
                'salary_years.*',
                'salary_months.*',
                'salary_months.absent',
                'salary_months.electricity',
                'salary_months.cooperative',
                'salary_months.pinjaman',
                'salary_months.other',
                'salary_months.date as salary_months_date',
                'salary_months.total_deduction',
                'salary_months.net_salary'
            )
            ->whereIn('salary_months.id', $salaryIds)
            ->get();

        // dd($salaries);

        $pdfData = [];

        foreach ($salaries as $sal) {
            $date = date('My', strtotime($sal->date));

            $rate_salary = $sal->rate_salary;
            $ability = $sal->ability;
            $fungtional_alw = $sal->fungtional_alw;
            $family_alw = $sal->family_alw;

            $total = $rate_salary + $ability + $fungtional_alw + $family_alw;

            $pdfData[] = [
                'sal' => $sal,
                'total' => $total
            ];
        }

        $pdf = PDF::loadView('salary.print_multiple', compact('pdfData', 'salaries'));
        return $pdf->setPaper('a4', 'potrait')->stream('Salaries_' . date('Ymd') . '.pdf');
    }

    public function download($id)
    {
        $sal = SalaryMonth::find($id);

        $date = date('My', strtotime($sal->date));

        if (!$sal) {
            dd("Salary with ID $id not found.");
        }

        $rate_salary = $sal->salary_year->salary_grade->rate_salary;
        $ability = $sal->salary_year->ability;
        $fungtional_alw = $sal->salary_year->fungtional_alw;
        $family_alw = $sal->salary_year->family_alw;

        $total = $rate_salary + $ability + $fungtional_alw + $family_alw;

        $pdf = PDF::loadView('salary.print', compact('sal', 'total'));
        return $pdf->setPaper('a5', 'landscape')->download('SAL_' . $date . '_' . $sal->salary_year->user->nik . '_' . $sal->salary_year->user->name . '.pdf');
    }

    public function printall(Request $request)
    {
        $jwt_token = session('jwt_token') ?? $request->jwt_token;
        $role = session('role') ?? $request->role;
        $nik = session('nik') ?? $request->nik;
        $dept = session('dept') ?? $request->dept;
        $jabatan = session('jabatan') ?? $request->jabatan;
        $name = User::where('nik', $nik)->value('name');

        $monthOpts = SalaryMonth::select(DB::raw('MONTH(date) as month'))
            ->distinct()
            ->pluck('month');

        $yearOpts = SalaryMonth::select(DB::raw('YEAR(date) as year'))
            ->distinct()
            ->pluck('year');

        $monthYear = request()->input('month');
        $status = request()->input('status');

        $date = Carbon::createFromFormat('Y-m', $monthYear);
        $year = $date->year;
        $month = $date->month;

        if ($status == 'Monthly') {
            $salaries = DB::table('salary_months')
                ->join('salary_years', 'salary_years.id', '=', 'salary_months.id_salary_year')
                ->join('grade', 'salary_years.id_salary_grade', '=', 'grade.id')
                ->join('users', 'users.nik', '=', 'salary_years.nik')
                ->select(
                    'users.nik as Emp Code',
                    'users.name as Nama',
                    'grade.name_grade as Grade',
                    'grade.rate_salary',
                    'salary_years.ability',
                    'salary_years.fungtional_alw',
                    'salary_years.family_alw',
                    'salary_years.transport_alw',
                    'salary_years.skill_alw',
                    'salary_years.telephone_alw',
                    'salary_years.bpjs',
                    'salary_years.jamsostek',
                    'salary_years.adjustment',
                    'salary_years.total_ben',
                    'salary_months.total_overtime',
                    'salary_months.thr',
                    'salary_months.bonus',
                    'salary_months.incentive',
                    'salary_months.gross_salary',
                    'salary_months.union',
                    'salary_months.absent',
                    'salary_months.electricity',
                    'salary_months.cooperative',
                    'salary_months.pinjaman',
                    'salary_months.other',
                    'salary_months.date as salary_months_date',
                    'salary_months.total_deduction',
                    'salary_months.net_salary',
                    DB::raw('(total_ben + gross_salary) as bruto_salary')
                )
                ->whereYear('salary_months.date', $year)
                ->whereMonth('salary_months.date', $month)
                ->where('users.status', $status)
                ->orderBy('users.grade', 'DESC')
                ->orderBy('users.name')
                ->get();

            $totalRateSalary = $salaries->sum('rate_salary');
            $totalAbility = $salaries->sum('ability');
            $totalFungtionalAlw = $salaries->sum('fungtional_alw');
            $totalSkillAlw = $salaries->sum('skill_alw');
            $totalFamilyAlw = $salaries->sum('family_alw');
            $totalTelephoneAlw = $salaries->sum('telephone_alw');
            $totalTransportAlw = $salaries->sum('transport_alw');
            $totalTotalOT = $salaries->sum('total_overtime');
            $totalIncentive = $salaries->sum('incentive');
            $totalAdjustment = $salaries->sum('adjustment');
            $totalGrossSalary = $salaries->sum('gross_salary');
            $totalThr = $salaries->sum('thr');
            $totalBonus = $salaries->sum('bonus');
            $totalPinjaman = $salaries->sum('pinjaman');
            $totalBpjs = $salaries->sum('bpjs');
            $totalJamsostek = $salaries->sum('jamsostek');
            $totalUnion = $salaries->sum('union');
            $totalOther = $salaries->sum('other');
            $totalAbsent = $salaries->sum('absent');
            $totalElectricity = $salaries->sum('electricity');
            $totalCooperative = $salaries->sum('cooperative');
            $totalTotalDed = $salaries->sum('total_deduction');
            $totalNetSalary = $salaries->sum('net_salary');
            $totalTotalBen = $salaries->sum('total_ben');
            $totalBrutoSalary = $salaries->sum('bruto_salary');

            $columns = [
                'Emp Code',
                'Nama',
                'Grade',
                'rate_salary',
                'ability',
                'fungtional_alw',
                'skill_alw',
                'family_alw',
                'telephone_alw',
                'transport_alw',
                'total_overtime',
                'incentive',
                'adjustment',
                'gross_salary',
                'bruto_salary',
                'thr',
                'bonus',
                'pinjaman',
                'bpjs',
                'jamsostek',
                'union',
                'other',
                'absent',
                'electricity',
                'cooperative',
                'total_deduction',
                'net_salary',
            ];

            $displayColumns = [];
            foreach ($columns as $column) {
                if ($salaries->pluck($column)->filter()->isNotEmpty()) {
                    $displayColumns[] = $column;
                }
            }

            $employeeIdentityColumns = ['Emp Code', 'Nama', 'Grade'];
            $salaryComponentColumns = ['rate_salary', 'ability', 'fungtional_alw', 'skill_alw', 'family_alw', 'telephone_alw', 'transport_alw', 'total_overtime', 'incentive', 'thr', 'bonus', 'adjustment', 'gross_salary'];
            $deductionColumns = ['pinjaman', 'bpjs', 'jamsostek', 'union', 'other', 'absent', 'electricity', 'cooperative', 'total_deduction'];

            $employeeIdentityCols = count(array_intersect($displayColumns, $employeeIdentityColumns));
            $salaryComponentCols = count(array_intersect($displayColumns, $salaryComponentColumns));
            $deductionCols = count(array_intersect($displayColumns, $deductionColumns));

            $date = null;
            foreach ($salaries as $sal) {
                $date = date('F Y', strtotime($sal->salary_months_date));
            }

            if ($date) {
                $pdf = PDF::loadView('salary.printall_new_nd', compact(
                    'salaries',
                    'date',
                    'displayColumns',
                    'employeeIdentityCols'
                    ,
                    'salaryComponentCols',
                    'deductionCols',
                    'totalRateSalary',
                    'totalAbility',
                    'totalFungtionalAlw',
                    'totalSkillAlw'
                    ,
                    'totalFamilyAlw',
                    'totalTelephoneAlw',
                    'totalTransportAlw',
                    'totalTotalOT',
                    'totalIncentive',
                    'totalAdjustment',
                    'totalGrossSalary',
                    'totalBrutoSalary',
                    'totalThr'
                    ,
                    'totalBonus',
                    'totalPinjaman',
                    'totalBpjs',
                    'totalJamsostek',
                    'totalUnion',
                    'totalOther'
                    ,
                    'totalAbsent',
                    'totalElectricity',
                    'totalCooperative',
                    'totalTotalDed',
                    'totalNetSalary'
                ));
                return $pdf->setPaper(array(0, 0, 609.4488, 935.433), 'landscape')->stream('PrintAll.pdf');
            } else {
                return redirect()->route('salary.index');
            }
        } else {
            $salariesMng = DB::table('salary_months')
                ->join('salary_years', 'salary_years.id', '=', 'salary_months.id_salary_year')
                ->join('grade', 'salary_years.id_salary_grade', '=', 'grade.id')
                ->join('users', 'users.nik', '=', 'salary_years.nik')
                ->select(
                    'users.nik as Emp Code',
                    'users.name as Nama',
                    'grade.name_grade as Grade',
                    'grade.rate_salary',
                    'salary_years.ability',
                    'salary_years.fungtional_alw',
                    'salary_years.family_alw',
                    'salary_years.transport_alw',
                    'salary_years.skill_alw',
                    'salary_years.telephone_alw',
                    'salary_years.bpjs',
                    'salary_years.jamsostek',
                    'salary_years.adjustment',
                    'salary_years.total_ben',
                    'salary_months.total_overtime',
                    'salary_months.thr',
                    'salary_months.bonus',
                    'salary_months.incentive',
                    'salary_months.gross_salary',
                    'salary_months.union',
                    'salary_months.absent',
                    'salary_months.electricity',
                    'salary_months.cooperative',
                    'salary_months.pinjaman',
                    'salary_months.other',
                    'salary_months.date as salary_months_date',
                    'salary_months.total_deduction',
                    'salary_months.net_salary',
                    DB::raw('(total_ben + gross_salary) as bruto_salary')
                )
                ->whereYear('salary_months.date', $year)
                ->whereMonth('salary_months.date', $month)
                ->whereIn('users.status', ['Manager', 'Staff'])
                ->whereIn('users.jabatan', ['Dir', 'Mng', 'Dep. Mng'])
                ->orderBy('users.grade', 'DESC')
                ->orderBy('users.name')
                ->get();

            $salariesStaff = DB::table('salary_months')
                ->join('salary_years', 'salary_years.id', '=', 'salary_months.id_salary_year')
                ->join('grade', 'salary_years.id_salary_grade', '=', 'grade.id')
                ->join('users', 'users.nik', '=', 'salary_years.nik')
                ->select(
                    'users.nik as Emp Code',
                    'users.name as Nama',
                    'grade.name_grade as Grade',
                    'grade.rate_salary',
                    'salary_years.ability',
                    'salary_years.fungtional_alw',
                    'salary_years.family_alw',
                    'salary_years.transport_alw',
                    'salary_years.skill_alw',
                    'salary_years.telephone_alw',
                    'salary_years.bpjs',
                    'salary_years.jamsostek',
                    'salary_years.adjustment',
                    'salary_years.total_ben',
                    'salary_months.total_overtime',
                    'salary_months.thr',
                    'salary_months.bonus',
                    'salary_months.incentive',
                    'salary_months.gross_salary',
                    'salary_months.union',
                    'salary_months.absent',
                    'salary_months.electricity',
                    'salary_months.cooperative',
                    'salary_months.pinjaman',
                    'salary_months.other',
                    'salary_months.date as salary_months_date',
                    'salary_months.total_deduction',
                    'salary_months.net_salary',
                    DB::raw('(total_ben + gross_salary) as bruto_salary')
                )
                ->whereYear('salary_months.date', $year)
                ->whereMonth('salary_months.date', $month)
                ->where('users.status', 'Staff')
                ->whereIn('users.jabatan', ['Asst Mng', 'Asst Mng Trainee'])
                ->orderBy('users.grade', 'DESC')
                ->orderBy('users.name')
                ->get();

            $totalRateSalaryMng = $salariesMng->sum('rate_salary');
            $totalAbilityMng = $salariesMng->sum('ability');
            $totalFungtionalAlwMng = $salariesMng->sum('fungtional_alw');
            $totalSkillAlwMng = $salariesMng->sum('skill_alw');
            $totalFamilyAlwMng = $salariesMng->sum('family_alw');
            $totalTelephoneAlwMng = $salariesMng->sum('telephone_alw');
            $totalTransportAlwMng = $salariesMng->sum('transport_alw');
            $totalTotalOTMng = $salariesMng->sum('total_overtime');
            $totalIncentiveMng = $salariesMng->sum('incentive');
            $totalAdjustmentMng = $salariesMng->sum('adjustment');
            $totalGrossSalaryMng = $salariesMng->sum('gross_salary');
            $totalThrMng = $salariesMng->sum('thr');
            $totalBonusMng = $salariesMng->sum('bonus');
            $totalPinjamanMng = $salariesMng->sum('pinjaman');
            $totalBpjsMng = $salariesMng->sum('bpjs');
            $totalJamsostekMng = $salariesMng->sum('jamsostek');
            $totalUnionMng = $salariesMng->sum('union');
            $totalOtherMng = $salariesMng->sum('other');
            $totalAbsentMng = $salariesMng->sum('absent');
            $totalElectricityMng = $salariesMng->sum('electricity');
            $totalCooperativeMng = $salariesMng->sum('cooperative');
            $totalTotalDedMng = $salariesMng->sum('total_deduction');
            $totalNetSalaryMng = $salariesMng->sum('net_salary');
            $totalTotalBenMng = $salariesMng->sum('total_ben');
            $totalBrutoSalaryMng = $salariesMng->sum('bruto_salary');

            $totalRateSalaryStaff = $salariesStaff->sum('rate_salary');
            $totalAbilityStaff = $salariesStaff->sum('ability');
            $totalFungtionalAlwStaff = $salariesStaff->sum('fungtional_alw');
            $totalSkillAlwStaff = $salariesStaff->sum('skill_alw');
            $totalFamilyAlwStaff = $salariesStaff->sum('family_alw');
            $totalTelephoneAlwStaff = $salariesStaff->sum('telephone_alw');
            $totalTransportAlwStaff = $salariesStaff->sum('transport_alw');
            $totalTotalOTStaff = $salariesStaff->sum('total_overtime');
            $totalIncentiveStaff = $salariesStaff->sum('incentive');
            $totalAdjustmentStaff = $salariesStaff->sum('adjustment');
            $totalGrossSalaryStaff = $salariesStaff->sum('gross_salary');
            $totalThrStaff = $salariesStaff->sum('thr');
            $totalBonusStaff = $salariesStaff->sum('bonus');
            $totalPinjamanStaff = $salariesStaff->sum('pinjaman');
            $totalBpjsStaff = $salariesStaff->sum('bpjs');
            $totalJamsostekStaff = $salariesStaff->sum('jamsostek');
            $totalUnionStaff = $salariesStaff->sum('union');
            $totalOtherStaff = $salariesStaff->sum('other');
            $totalAbsentStaff = $salariesStaff->sum('absent');
            $totalElectricityStaff = $salariesStaff->sum('electricity');
            $totalCooperativeStaff = $salariesStaff->sum('cooperative');
            $totalTotalDedStaff = $salariesStaff->sum('total_deduction');
            $totalNetSalaryStaff = $salariesStaff->sum('net_salary');
            $totalTotalBenStaff = $salariesStaff->sum('total_ben');
            $totalBrutoSalaryStaff = $salariesStaff->sum('bruto_salary');

            $columnsMng = [
                'Emp Code',
                'Nama',
                'Grade',
                'rate_salary',
                'ability',
                'fungtional_alw',
                'skill_alw',
                'family_alw',
                'telephone_alw',
                'transport_alw',
                'total_overtime',
                'incentive',
                'adjustment',
                'gross_salary',
                'bruto_salary',
                'thr',
                'bonus',
                'pinjaman',
                'bpjs',
                'jamsostek',
                'union',
                'other',
                'absent',
                'electricity',
                'cooperative',
                'total_deduction',
                'net_salary',
            ];

            $columnsStaff = [
                'Emp Code',
                'Nama',
                'Grade',
                'rate_salary',
                'ability',
                'fungtional_alw',
                'skill_alw',
                'family_alw',
                'telephone_alw',
                'transport_alw',
                'total_overtime',
                'incentive',
                'adjustment',
                'gross_salary',
                'bruto_salary',
                'thr',
                'bonus',
                'pinjaman',
                'bpjs',
                'jamsostek',
                'union',
                'other',
                'absent',
                'electricity',
                'cooperative',
                'total_deduction',
                'net_salary',
            ];

            $displayColumnsMng = [];
            foreach ($columnsMng as $column) {
                if ($salariesMng->pluck($column)->filter()->isNotEmpty()) {
                    $displayColumnsMng[] = $column;
                }
            }

            $displayColumnsStaff = [];
            foreach ($columnsStaff as $column) {
                if ($salariesStaff->pluck($column)->filter()->isNotEmpty()) {
                    $displayColumnsStaff[] = $column;
                }
            }

            $employeeIdentityColumnsMng = ['Emp Code', 'Nama', 'Grade'];
            $salaryComponentColumnsMng = ['rate_salary', 'ability', 'fungtional_alw', 'skill_alw', 'family_alw', 'telephone_alw', 'transport_alw', 'total_overtime', 'incentive', 'thr', 'bonus', 'adjustment', 'gross_salary'];
            $deductionColumnsMng = ['pinjaman', 'bpjs', 'jamsostek', 'union', 'other', 'absent', 'electricity', 'cooperative', 'total_deduction'];

            $employeeIdentityColumnsStaff = ['Emp Code', 'Nama', 'Grade'];
            $salaryComponentColumnsStaff = ['rate_salary', 'ability', 'fungtional_alw', 'skill_alw', 'family_alw', 'telephone_alw', 'transport_alw', 'total_overtime', 'incentive', 'thr', 'bonus', 'adjustment', 'gross_salary'];
            $deductionColumnsStaff = ['pinjaman', 'bpjs', 'jamsostek', 'union', 'other', 'absent', 'electricity', 'cooperative', 'total_deduction'];

            $employeeIdentityColsMng = count(array_intersect($displayColumnsMng, $employeeIdentityColumnsMng));
            $salaryComponentColsMng = count(array_intersect($displayColumnsMng, $salaryComponentColumnsMng));
            $deductionColsMng = count(array_intersect($displayColumnsMng, $deductionColumnsMng));

            $employeeIdentityColsStaff = count(array_intersect($displayColumnsStaff, $employeeIdentityColumnsStaff));
            $salaryComponentColsStaff = count(array_intersect($displayColumnsStaff, $salaryComponentColumnsStaff));
            $deductionColsStaff = count(array_intersect($displayColumnsStaff, $deductionColumnsStaff));

            $dateMng = null;
            foreach ($salariesMng as $salMng) {
                $dateMng = date('F Y', strtotime($salMng->salary_months_date));
            }

            $dateStaff = null;
            foreach ($salariesStaff as $salStaff) {
                $dateStaff = date('F Y', strtotime($salStaff->salary_months_date));
            }

            if ($dateMng && $dateStaff) {
                $pdf = PDF::loadView('salary.print_mng_staff', compact(
                    'salariesMng',
                    'dateMng',
                    'displayColumnsMng',
                    'employeeIdentityColsMng',
                    'salaryComponentColsMng',
                    'deductionColsMng',
                    'totalRateSalaryMng',
                    'totalAbilityMng',
                    'totalFungtionalAlwMng',
                    'totalSkillAlwMng' ,
                    'totalFamilyAlwMng',
                    'totalTelephoneAlwMng',
                    'totalTransportAlwMng',
                    'totalTotalOTMng',
                    'totalIncentiveMng',
                    'totalAdjustmentMng',
                    'totalGrossSalaryMng',
                    'totalBrutoSalaryMng',
                    'totalThrMng',
                    'totalBonusMng',
                    'totalPinjamanMng',
                    'totalBpjsMng',
                    'totalJamsostekMng',
                    'totalUnionMng',
                    'totalOtherMng',
                    'totalAbsentMng',
                    'totalElectricityMng',
                    'totalCooperativeMng',
                    'totalTotalDedMng',
                    'totalNetSalaryMng',
                    'salariesStaff',
                    'dateStaff',
                    'displayColumnsStaff',
                    'employeeIdentityColsStaff',
                    'salaryComponentColsStaff',
                    'deductionColsStaff',
                    'totalRateSalaryStaff',
                    'totalAbilityStaff',
                    'totalFungtionalAlwStaff',
                    'totalSkillAlwStaff' ,
                    'totalFamilyAlwStaff',
                    'totalTelephoneAlwStaff',
                    'totalTransportAlwStaff',
                    'totalTotalOTStaff',
                    'totalIncentiveStaff',
                    'totalAdjustmentStaff',
                    'totalGrossSalaryStaff',
                    'totalBrutoSalaryStaff',
                    'totalThrStaff',
                    'totalBonusStaff',
                    'totalPinjamanStaff',
                    'totalBpjsStaff',
                    'totalJamsostekStaff',
                    'totalUnionStaff',
                    'totalOtherStaff',
                    'totalAbsentStaff',
                    'totalElectricityStaff',
                    'totalCooperativeStaff',
                    'totalTotalDedStaff',
                    'totalNetSalaryStaff'
                ));
                return $pdf->setPaper(array(0, 0, 609.4488, 935.433), 'landscape')->stream('PrintAll.pdf');
            } else {
                return redirect()->route('salary.index');
            }
        }
    }

    public function printallocation()
    {
        $monthOpts = SalaryMonth::select(DB::raw('MONTH(date) as month'))
            ->distinct()
            ->pluck('month');

        $yearOpts = SalaryMonth::select(DB::raw('YEAR(date) as year'))
            ->distinct()
            ->pluck('year');

        $monthYear = request()->input('month');
        $status = request()->input('status');

        $date = Carbon::createFromFormat('Y-m', $monthYear);
        $year = $date->year;
        $month = $date->month;

        if ($status == 'Manager Staff') {
            $getAllocationDir = DB::table('salary_months')
                ->join('salary_years', 'salary_years.id', '=', 'salary_months.id_salary_year')
                ->join('users', 'users.nik', '=', 'salary_years.nik')
                ->join('grade', 'grade.id', '=', 'salary_years.id_salary_grade')
                ->select(
                    'grade.rate_salary',
                    'salary_years.ability',
                    'salary_years.fungtional_alw',
                    'salary_years.family_alw',
                    'salary_years.telephone_alw',
                    'salary_years.transport_alw',
                    'salary_years.bpjs',
                    'salary_years.jamsostek',
                    'salary_months.total_overtime',
                    'salary_months.pinjaman',
                    'salary_months.electricity',
                )
                ->selectRaw('JSON_LENGTH(salary_years.allocation) as allocation_count')
                ->where('users.jabatan', 'Dir')
                ->whereYear('salary_months.date', $year)
                ->whereMonth('salary_months.date', $month)
                ->first();

            $getAllocationMngDiv1 = DB::table('salary_months')
                ->join('salary_years', 'salary_years.id', '=', 'salary_months.id_salary_year')
                ->join('users', 'users.nik', '=', 'salary_years.nik')
                ->join('grade', 'grade.id', '=', 'salary_years.id_salary_grade')
                ->select(
                    'grade.rate_salary',
                    'salary_years.ability',
                    'salary_years.fungtional_alw',
                    'salary_years.family_alw',
                    'salary_years.telephone_alw',
                    'salary_years.transport_alw',
                    'salary_years.bpjs',
                    'salary_years.jamsostek',
                    'salary_months.total_overtime',
                    'salary_months.pinjaman',
                    'salary_months.electricity',
                )
                ->selectRaw('JSON_LENGTH(salary_years.allocation) as allocation_count')
                ->where('users.jabatan', 'Mng')
                ->where('salary_years.allocation', '["A","B","C"]')
                ->whereYear('salary_months.date', $year)
                ->whereMonth('salary_months.date', $month)
                ->first();

            $getAllocationMngDiv2 = DB::table('salary_months')
                ->join('salary_years', 'salary_years.id', '=', 'salary_months.id_salary_year')
                ->join('users', 'users.nik', '=', 'salary_years.nik')
                ->join('grade', 'grade.id', '=', 'salary_years.id_salary_grade')
                ->select(
                    'grade.rate_salary',
                    'salary_years.ability',
                    'salary_years.fungtional_alw',
                    'salary_years.family_alw',
                    'salary_years.telephone_alw',
                    'salary_years.transport_alw',
                    'salary_years.bpjs',
                    'salary_years.jamsostek',
                    'salary_months.total_overtime',
                    'salary_months.pinjaman',
                    'salary_months.electricity',
                )
                ->selectRaw('JSON_LENGTH(salary_years.allocation) as allocation_count')
                ->where('users.jabatan', 'Mng')
                ->where('salary_years.allocation', '["D","E","F"]')
                ->whereYear('salary_months.date', $year)
                ->whereMonth('salary_months.date', $month)
                ->first();

            $getAllocationAsstMngA = DB::table('salary_months')
                ->join('salary_years', 'salary_years.id', '=', 'salary_months.id_salary_year')
                ->join('users', 'users.nik', '=', 'salary_years.nik')
                ->join('grade', 'grade.id', '=', 'salary_years.id_salary_grade')
                ->select(
                    'grade.rate_salary',
                    'salary_years.ability',
                    'salary_years.fungtional_alw',
                    'salary_years.family_alw',
                    'salary_years.telephone_alw',
                    'salary_years.transport_alw',
                    'salary_years.bpjs',
                    'salary_years.jamsostek',
                    'salary_months.total_overtime',
                    'salary_months.pinjaman',
                    'salary_months.electricity',
                )
                ->selectRaw('JSON_LENGTH(salary_years.allocation) as allocation_count')
                ->where('users.jabatan', 'Asst Mng')
                ->where('salary_years.allocation', '["A"]')
                ->whereYear('salary_months.date', $year)
                ->whereMonth('salary_months.date', $month)
                ->first();

            $getAllocationAsstUtilityA = DB::table('salary_months')
                ->join('salary_years', 'salary_years.id', '=', 'salary_months.id_salary_year')
                ->join('users', 'users.nik', '=', 'salary_years.nik')
                ->join('grade', 'grade.id', '=', 'salary_years.id_salary_grade')
                ->select(
                    'grade.rate_salary',
                    'salary_years.ability',
                    'salary_years.fungtional_alw',
                    'salary_years.family_alw',
                    'salary_years.telephone_alw',
                    'salary_years.transport_alw',
                    'salary_years.bpjs',
                    'salary_years.jamsostek',
                    'salary_months.total_overtime',
                    'salary_months.pinjaman',
                    'salary_months.electricity',
                )
                ->selectRaw('JSON_LENGTH(salary_years.allocation) as allocation_count')
                ->where('users.jabatan', 'Asst Mng Trainee')
                ->where('salary_years.allocation', '["A"]')
                ->whereYear('salary_months.date', $year)
                ->whereMonth('salary_months.date', $month)
                ->first();

            $getAllocationAsstMngB = DB::table('salary_months')
                ->join('salary_years', 'salary_years.id', '=', 'salary_months.id_salary_year')
                ->join('users', 'users.nik', '=', 'salary_years.nik')
                ->join('grade', 'grade.id', '=', 'salary_years.id_salary_grade')
                ->select(
                    'grade.rate_salary',
                    'salary_years.ability',
                    'salary_years.fungtional_alw',
                    'salary_years.family_alw',
                    'salary_years.telephone_alw',
                    'salary_years.transport_alw',
                    'salary_years.bpjs',
                    'salary_years.jamsostek',
                    'salary_months.total_overtime',
                    'salary_months.pinjaman',
                    'salary_months.electricity',
                )
                ->selectRaw('JSON_LENGTH(salary_years.allocation) as allocation_count')
                ->where('users.jabatan', 'Asst Mng')
                ->where('salary_years.allocation', '["B"]')
                ->whereYear('salary_months.date', $year)
                ->whereMonth('salary_months.date', $month)
                ->first();

            $getAllocationAsstUtilityB = DB::table('salary_months')
                ->join('salary_years', 'salary_years.id', '=', 'salary_months.id_salary_year')
                ->join('users', 'users.nik', '=', 'salary_years.nik')
                ->join('grade', 'grade.id', '=', 'salary_years.id_salary_grade')
                ->select(
                    'grade.rate_salary',
                    'salary_years.ability',
                    'salary_years.fungtional_alw',
                    'salary_years.family_alw',
                    'salary_years.telephone_alw',
                    'salary_years.transport_alw',
                    'salary_years.bpjs',
                    'salary_years.jamsostek',
                    'salary_months.total_overtime',
                    'salary_months.pinjaman',
                    'salary_months.electricity',
                    'users.name',
                    'users.dept'
                )
                ->selectRaw('JSON_LENGTH(salary_years.allocation) as allocation_count')
                ->where('users.jabatan', 'Asst Mng Trainee')
                ->where('salary_years.allocation', '["B"]')
                ->whereYear('salary_months.date', $year)
                ->whereMonth('salary_months.date', $month)
                ->first();

            // dd($getAllocationAsstUtilityB->allocation_count, $getAllocationAsstMngB->allocation_count, $getAllocationMngDiv1->allocation_count, $getAllocationDir->allocation_count);

            $getAllocationAsstMngC = DB::table('salary_months')
                ->join('salary_years', 'salary_years.id', '=', 'salary_months.id_salary_year')
                ->join('users', 'users.nik', '=', 'salary_years.nik')
                ->join('grade', 'grade.id', '=', 'salary_years.id_salary_grade')
                ->select(
                    'grade.rate_salary',
                    'salary_years.ability',
                    'salary_years.fungtional_alw',
                    'salary_years.family_alw',
                    'salary_years.telephone_alw',
                    'salary_years.transport_alw',
                    'salary_years.bpjs',
                    'salary_years.jamsostek',
                    'salary_months.total_overtime',
                    'salary_months.pinjaman',
                    'salary_months.electricity',
                )
                ->selectRaw('JSON_LENGTH(salary_years.allocation) as allocation_count')
                ->where('users.jabatan', 'Asst Mng')
                ->where('salary_years.allocation', '["C"]')
                ->whereYear('salary_months.date', $year)
                ->whereMonth('salary_months.date', $month)
                ->first();

            $getAllocationAsstMngD = DB::table('salary_months')
                ->join('salary_years', 'salary_years.id', '=', 'salary_months.id_salary_year')
                ->join('users', 'users.nik', '=', 'salary_years.nik')
                ->join('grade', 'grade.id', '=', 'salary_years.id_salary_grade')
                ->select(
                    'grade.rate_salary',
                    'salary_years.ability',
                    'salary_years.fungtional_alw',
                    'salary_years.family_alw',
                    'salary_years.telephone_alw',
                    'salary_years.transport_alw',
                    'salary_years.bpjs',
                    'salary_years.jamsostek',
                    'salary_months.total_overtime',
                    'salary_months.pinjaman',
                    'salary_months.electricity',
                    'users.name'
                )
                ->selectRaw('JSON_LENGTH(salary_years.allocation) as allocation_count')
                ->where('users.jabatan', 'Asst Mng')
                ->where('users.dept', 'II/D')
                ->where('salary_years.allocation', '["D"]')
                ->whereYear('salary_months.date', $year)
                ->whereMonth('salary_months.date', $month)
                ->first();

            $getAllocationAsstUtilityD = DB::table('salary_months')
                ->join('salary_years', 'salary_years.id', '=', 'salary_months.id_salary_year')
                ->join('users', 'users.nik', '=', 'salary_years.nik')
                ->join('grade', 'grade.id', '=', 'salary_years.id_salary_grade')
                ->select(
                    'grade.rate_salary',
                    'salary_years.ability',
                    'salary_years.fungtional_alw',
                    'salary_years.family_alw',
                    'salary_years.telephone_alw',
                    'salary_years.transport_alw',
                    'salary_years.bpjs',
                    'salary_years.jamsostek',
                    'salary_months.total_overtime',
                    'salary_months.pinjaman',
                    'salary_months.electricity',
                    'users.name',
                )
                ->selectRaw('JSON_LENGTH(salary_years.allocation) as allocation_count')
                ->where('users.jabatan', 'Asst Mng')
                ->where('users.dept', 'DIv II')
                ->where('salary_years.allocation', '["D"]')
                ->whereYear('salary_months.date', $year)
                ->whereMonth('salary_months.date', $month)
                ->first();

            $getAllocationAsstMngE = DB::table('salary_months')
                ->join('salary_years', 'salary_years.id', '=', 'salary_months.id_salary_year')
                ->join('users', 'users.nik', '=', 'salary_years.nik')
                ->join('grade', 'grade.id', '=', 'salary_years.id_salary_grade')
                ->select(
                    'grade.rate_salary',
                    'salary_years.ability',
                    'salary_years.fungtional_alw',
                    'salary_years.family_alw',
                    'salary_years.telephone_alw',
                    'salary_years.transport_alw',
                    'salary_years.bpjs',
                    'salary_years.jamsostek',
                    'salary_months.total_overtime',
                    'salary_months.pinjaman',
                    'salary_months.electricity',
                )
                ->selectRaw('JSON_LENGTH(salary_years.allocation) as allocation_count')
                ->where('users.jabatan', 'Asst Mng')
                ->where('salary_years.allocation', '["E"]')
                ->whereYear('salary_months.date', $year)
                ->whereMonth('salary_months.date', $month)
                ->first();

            $getAllocationAsstMngF = DB::table('salary_months')
                ->join('salary_years', 'salary_years.id', '=', 'salary_months.id_salary_year')
                ->join('users', 'users.nik', '=', 'salary_years.nik')
                ->join('grade', 'grade.id', '=', 'salary_years.id_salary_grade')
                ->select(
                    'grade.rate_salary',
                    'salary_years.ability',
                    'salary_years.fungtional_alw',
                    'salary_years.family_alw',
                    'salary_years.telephone_alw',
                    'salary_years.transport_alw',
                    'salary_years.bpjs',
                    'salary_years.jamsostek',
                    'salary_months.total_overtime',
                    'salary_months.pinjaman',
                    'salary_months.electricity',
                )
                ->selectRaw('JSON_LENGTH(salary_years.allocation) as allocation_count')
                ->where('users.jabatan', 'Asst Mng')
                ->where('salary_years.allocation', '["F"]')
                ->whereYear('salary_months.date', $year)
                ->whereMonth('salary_months.date', $month)
                ->first();

            $getAllocationAsstMngFac = DB::table('salary_months')
                ->join('salary_years', 'salary_years.id', '=', 'salary_months.id_salary_year')
                ->join('users', 'users.nik', '=', 'salary_years.nik')
                ->join('grade', 'grade.id', '=', 'salary_years.id_salary_grade')
                ->select(
                    'grade.rate_salary',
                    'salary_years.ability',
                    'salary_years.fungtional_alw',
                    'salary_years.family_alw',
                    'salary_years.telephone_alw',
                    'salary_years.transport_alw',
                    'salary_years.bpjs',
                    'salary_years.jamsostek',
                    'salary_months.total_overtime',
                    'salary_months.pinjaman',
                    'salary_months.electricity',
                )
                ->selectRaw('JSON_LENGTH(salary_years.allocation) as allocation_count')
                ->where('users.jabatan', 'Asst Mng')
                ->where('salary_years.allocation', '["Factory"]')
                ->whereYear('salary_months.date', $year)
                ->whereMonth('salary_months.date', $month)
                ->first();

            $getAllocationAsstMngGae = DB::table('salary_months')
                ->join('salary_years', 'salary_years.id', '=', 'salary_months.id_salary_year')
                ->join('users', 'users.nik', '=', 'salary_years.nik')
                ->join('grade', 'grade.id', '=', 'salary_years.id_salary_grade')
                ->select(
                    'grade.rate_salary',
                    'salary_years.ability',
                    'salary_years.fungtional_alw',
                    'salary_years.family_alw',
                    'salary_years.telephone_alw',
                    'salary_years.transport_alw',
                    'salary_years.bpjs',
                    'salary_years.jamsostek',
                    'salary_months.total_overtime',
                    'salary_months.pinjaman',
                    'salary_months.electricity',
                    'users.name',
                    'users.jabatan'
                )
                ->selectRaw('JSON_LENGTH(salary_years.allocation) as allocation_count')
                ->whereIn('users.jabatan', ['Asst Mng', 'Mng', 'Asst Mng Trainee', 'Dep. Mng'])
                ->where('salary_years.allocation', '["GAE"]')
                // ->where('salary_years.nik', '223-002')
                ->whereYear('salary_months.date', $year)
                ->whereMonth('salary_months.date', $month)
                ->get();

            $getAllocationPDGae = DB::table('salary_months')
                ->join('salary_years', 'salary_years.id', '=', 'salary_months.id_salary_year')
                ->join('users', 'users.nik', '=', 'salary_years.nik')
                ->join('grade', 'grade.id', '=', 'salary_years.id_salary_grade')
                ->select(
                    'grade.rate_salary',
                    'salary_years.ability',
                    'salary_years.fungtional_alw',
                    'salary_years.family_alw',
                    'salary_years.telephone_alw',
                    'salary_years.transport_alw',
                    'salary_years.bpjs',
                    'salary_years.jamsostek',
                    'salary_months.total_overtime',
                    'salary_months.pinjaman',
                    'salary_months.electricity',
                    'salary_months.internet',
                    'salary_months.gas',
                    'salary_months.water',
                    'users.name',
                    'users.jabatan'
                )
                ->selectRaw('JSON_LENGTH(salary_years.allocation) as allocation_count')
                ->where('salary_years.allocation', '["GAE"]')
                ->where('users.jabatan', 'PD')
                ->whereYear('salary_months.date', $year)
                ->whereMonth('salary_months.date', $month)
                ->first();

                // dd($getAllocationAsstMngGae, $getAllocationPDGae);

            $subTotalRateSalaryGae = $getAllocationAsstMngGae->sum('rate_salary');
            $totalRateSalaryGae = $subTotalRateSalaryGae + $getAllocationPDGae->ability;
            $totalAbilityGae = $getAllocationAsstMngGae->sum('ability');
            $totalFungtionalAlwGae = $getAllocationAsstMngGae->sum('fungtional_alw');
            $totalFamilyAlwGae = $getAllocationAsstMngGae->sum('family_alw');
            $totalTelephoneAlwGae = $getAllocationAsstMngGae->sum('telephone_alw');
            $totalTransportAlwGae = $getAllocationAsstMngGae->sum('transport_alw');
            $totalBpjsGae = $getAllocationAsstMngGae->sum('bpjs');
            $totalJamsostekGae = $getAllocationAsstMngGae->sum('jamsostek');
            $totalTotalOvertimeGae = $getAllocationAsstMngGae->sum('total_overtime');
            $totalPinjamanGae = $getAllocationAsstMngGae->sum('pinjaman');
            $subTotalElectricityGae = $getAllocationAsstMngGae->sum('electricity');
            $totalElectricityGae = $subTotalElectricityGae + $getAllocationPDGae->electricity;
            $totalAllocationCountGae = $getAllocationAsstMngGae->sum('allocation_count');
            $totalInternetGae = $getAllocationPDGae->internet;
            $totalGasGae = $getAllocationPDGae->gas;
            $totalWaterGae = $getAllocationPDGae->water;

            // dd($totalRateSalaryGae, $totalAllocationCountGae);

            $getAllocationAsstMngWorkshop = DB::table('salary_months')
                ->join('salary_years', 'salary_years.id', '=', 'salary_months.id_salary_year')
                ->join('users', 'users.nik', '=', 'salary_years.nik')
                ->join('grade', 'grade.id', '=', 'salary_years.id_salary_grade')
                ->select(
                    'grade.rate_salary',
                    'salary_years.ability',
                    'salary_years.fungtional_alw',
                    'salary_years.family_alw',
                    'salary_years.telephone_alw',
                    'salary_years.transport_alw',
                    'salary_years.bpjs',
                    'salary_years.jamsostek',
                    'salary_months.total_overtime',
                    'salary_months.pinjaman',
                    'salary_months.electricity',
                )
                ->selectRaw('JSON_LENGTH(salary_years.allocation) as allocation_count')
                ->where('users.jabatan', 'Asst Mng')
                ->where('salary_years.allocation', '["Workshop"]')
                ->whereYear('salary_months.date', $year)
                ->whereMonth('salary_months.date', $month)
                ->first();

            $getAllocationAsstMngIso = DB::table('salary_months')
                ->join('salary_years', 'salary_years.id', '=', 'salary_months.id_salary_year')
                ->join('users', 'users.nik', '=', 'salary_years.nik')
                ->join('grade', 'grade.id', '=', 'salary_years.id_salary_grade')
                ->select(
                    'grade.rate_salary',
                    'salary_years.ability',
                    'salary_years.fungtional_alw',
                    'salary_years.family_alw',
                    'salary_years.telephone_alw',
                    'salary_years.transport_alw',
                    'salary_years.bpjs',
                    'salary_years.jamsostek',
                    'salary_months.total_overtime',
                    'salary_months.pinjaman',
                    'salary_months.electricity',
                )
                ->selectRaw('JSON_LENGTH(salary_years.allocation) as allocation_count')
                ->where('users.jabatan', 'Mng')
                ->where('salary_years.allocation', '["ISO"]')
                ->whereYear('salary_months.date', $year)
                ->whereMonth('salary_months.date', $month)
                ->first();

            $getAllocationAsstMngSales = DB::table('salary_months')
                ->join('salary_years', 'salary_years.id', '=', 'salary_months.id_salary_year')
                ->join('users', 'users.nik', '=', 'salary_years.nik')
                ->join('grade', 'grade.id', '=', 'salary_years.id_salary_grade')
                ->select(
                    'grade.rate_salary',
                    'salary_years.ability',
                    'salary_years.fungtional_alw',
                    'salary_years.family_alw',
                    'salary_years.telephone_alw',
                    'salary_years.transport_alw',
                    'salary_years.bpjs',
                    'salary_years.jamsostek',
                    'salary_months.total_overtime',
                    'salary_months.pinjaman',
                    'salary_months.electricity',
                )
                ->selectRaw('JSON_LENGTH(salary_years.allocation) as allocation_count')
                ->where('users.jabatan', 'Asst Mng')
                ->where('salary_years.allocation', '["Sales"]')
                ->whereYear('salary_months.date', $year)
                ->whereMonth('salary_months.date', $month)
                ->first();

            $sal_allocation = SalaryMonth::with('salary_year')
                ->whereYear('date', $year)
                ->whereMonth('date', $month)
                ->get();

            // SPSI
            // $totalSpsiA = DB::table('users')
            //     ->join('salary_years', 'salary_years.nik', '=', 'users.nik')
            //     ->join('salary_months', 'salary_months.id_salary_year', '=', 'salary_years.id')
            //     ->where('users.dept', 'I/A')
            //     ->where('users.status', 'Monthly')
            //     ->whereMonth('salary_months.date', $month)
            //     ->whereYear('salary_months.date', $year)
            //     // ->sum('salary_months.union');
            //     ->get();

            // $totalSpsiB = DB::table('users')
            //     ->join('salary_years', 'salary_years.nik', '=', 'users.nik')
            //     ->join('salary_months', 'salary_months.id_salary_year', '=', 'salary_years.id')
            //     ->where('users.dept', 'I/B')
            //     ->where('users.status', 'Monthly')
            //     ->sum('salary_months.union');

            // $totalSpsiC = DB::table('users')
            //     ->join('salary_years', 'salary_years.nik', '=', 'users.nik')
            //     ->join('salary_months', 'salary_months.id_salary_year', '=', 'salary_years.id')
            //     ->where('users.dept', 'I/C')
            //     ->where('users.status', 'Monthly')
            //     ->sum('salary_months.union');

            // $totalSpsiD = DB::table('users')
            //     ->join('salary_years', 'salary_years.nik', '=', 'users.nik')
            //     ->join('salary_months', 'salary_months.id_salary_year', '=', 'salary_years.id')
            //     ->where('users.dept', 'II/D')
            //     ->where('users.status', 'Monthly')
            //     ->sum('salary_months.union');

            // $totalSpsiE = DB::table('users')
            //     ->join('salary_years', 'salary_years.nik', '=', 'users.nik')
            //     ->join('salary_months', 'salary_months.id_salary_year', '=', 'salary_years.id')
            //     ->where('users.dept', 'II/E')
            //     ->where('users.status', 'Monthly')
            //     ->sum('salary_months.union');

            // $totalSpsiF = DB::table('users')
            //     ->join('salary_years', 'salary_years.nik', '=', 'users.nik')
            //     ->join('salary_months', 'salary_months.id_salary_year', '=', 'salary_years.id')
            //     ->where('users.dept', 'II/F')
            //     ->where('users.status', 'Monthly')
            //     ->sum('salary_months.union');

            // $totalSpsiFSD = DB::table('users')
            //     ->join('salary_years', 'salary_years.nik', '=', 'users.nik')
            //     ->join('salary_months', 'salary_months.id_salary_year', '=', 'salary_years.id')
            //     ->where('users.dept', 'FSD')
            //     ->where('users.status', 'Monthly')
            //     ->sum('salary_months.union');

            // $totalSpsiFAC = DB::table('users')
            //     ->join('salary_years', 'salary_years.nik', '=', 'users.nik')
            //     ->join('salary_months', 'salary_months.id_salary_year', '=', 'salary_years.id')
            //     ->where('users.dept', 'FAC')
            //     ->where('users.status', 'Monthly')
            //     ->sum('salary_months.union');

            // $totalSpsiHO = DB::table('users')
            //     ->join('salary_years', 'salary_years.nik', '=', 'users.nik')
            //     ->join('salary_months', 'salary_months.id_salary_year', '=', 'salary_years.id')
            //     ->where('users.loc_kerja', 'Head Office')
            //     ->where('users.status', 'Monthly')
            //     ->sum('salary_months.union');

            // $totalSpsiSEC = DB::table('users')
            //     ->join('salary_years', 'salary_years.nik', '=', 'users.nik')
            //     ->join('salary_months', 'salary_months.id_salary_year', '=', 'salary_years.id')
            //     ->where('users.dept', 'Security')
            //     ->where('users.status', 'Monthly')
            //     ->sum('salary_months.union');

            // $totalSpsiWS = DB::table('users')
            //     ->join('salary_years', 'salary_years.nik', '=', 'users.nik')
            //     ->join('salary_months', 'salary_months.id_salary_year', '=', 'salary_years.id')
            //     ->where('users.dept', 'Workshop')
            //     ->where('users.status', 'Monthly')
            //     ->sum('salary_months.union');

            // $totalSpsiWSOPR = DB::table('users')
            //     ->join('salary_years', 'salary_years.nik', '=', 'users.nik')
            //     ->join('salary_months', 'salary_months.id_salary_year', '=', 'salary_years.id')
            //     ->where('users.dept', 'Workshop')
            //     ->where('users.jabatan', 'Opr')
            //     ->where('users.status', 'Monthly')
            //     ->sum('salary_months.union');

            // $totalAllSpsi = $totalSpsiA + $totalSpsiB + $totalSpsiC + $totalSpsiD + $totalSpsiE + $totalSpsiF + $totalSpsiFSD + $totalSpsiFAC + $totalSpsiHO + $totalSpsiSEC + $totalSpsiWS + $totalSpsiWSOPR;

            // Pinjaman
            // $totalPinjamanA = DB::table('users')
            //     ->join('salary_years', 'salary_years.nik', '=', 'users.nik')
            //     ->join('salary_months', 'salary_months.id_salary_year', '=', 'salary_years.id')
            //     ->where('users.dept', 'I/A')
            //     ->where('users.status', 'Monthly')
            //     ->sum('salary_months.pinjaman');

            // $totalPinjamanB = DB::table('users')
            //     ->join('salary_years', 'salary_years.nik', '=', 'users.nik')
            //     ->join('salary_months', 'salary_months.id_salary_year', '=', 'salary_years.id')
            //     ->where('users.dept', 'I/B')
            //     ->where('users.status', 'Monthly')
            //     ->sum('salary_months.pinjaman');

            // $totalPinjamanC = DB::table('users')
            //     ->join('salary_years', 'salary_years.nik', '=', 'users.nik')
            //     ->join('salary_months', 'salary_months.id_salary_year', '=', 'salary_years.id')
            //     ->where('users.dept', 'I/C')
            //     ->where('users.status', 'Monthly')
            //     ->sum('salary_months.pinjaman');

            // $totalPinjamanD = DB::table('users')
            //     ->join('salary_years', 'salary_years.nik', '=', 'users.nik')
            //     ->join('salary_months', 'salary_months.id_salary_year', '=', 'salary_years.id')
            //     ->where('users.dept', 'II/D')
            //     ->where('users.status', 'Monthly')
            //     ->sum('salary_months.pinjaman');

            // $totalPinjamanE = DB::table('users')
            //     ->join('salary_years', 'salary_years.nik', '=', 'users.nik')
            //     ->join('salary_months', 'salary_months.id_salary_year', '=', 'salary_years.id')
            //     ->where('users.dept', 'II/E')
            //     ->where('users.status', 'Monthly')
            //     ->sum('salary_months.pinjaman');

            // $totalPinjamanF = DB::table('users')
            //     ->join('salary_years', 'salary_years.nik', '=', 'users.nik')
            //     ->join('salary_months', 'salary_months.id_salary_year', '=', 'salary_years.id')
            //     ->where('users.dept', 'II/F')
            //     ->where('users.status', 'Monthly')
            //     ->sum('salary_months.pinjaman');

            // $totalPinjamanFSD = DB::table('users')
            //     ->join('salary_years', 'salary_years.nik', '=', 'users.nik')
            //     ->join('salary_months', 'salary_months.id_salary_year', '=', 'salary_years.id')
            //     ->where('users.dept', 'FSD')
            //     ->where('users.status', 'Monthly')
            //     ->sum('salary_months.pinjaman');

            // $totalPinjamanFAC = DB::table('users')
            //     ->join('salary_years', 'salary_years.nik', '=', 'users.nik')
            //     ->join('salary_months', 'salary_months.id_salary_year', '=', 'salary_years.id')
            //     ->where('users.dept', 'FAC')
            //     ->where('users.status', 'Monthly')
            //     ->sum('salary_months.pinjaman');

            // $totalPinjamanHO = DB::table('users')
            //     ->join('salary_years', 'salary_years.nik', '=', 'users.nik')
            //     ->join('salary_months', 'salary_months.id_salary_year', '=', 'salary_years.id')
            //     ->where('users.loc_kerja', 'Head Office')
            //     ->where('users.status', 'Monthly')
            //     ->sum('salary_months.pinjaman');

            // $totalPinjamanSEC = DB::table('users')
            //     ->join('salary_years', 'salary_years.nik', '=', 'users.nik')
            //     ->join('salary_months', 'salary_months.id_salary_year', '=', 'salary_years.id')
            //     ->where('users.dept', 'Security')
            //     ->where('users.status', 'Monthly')
            //     ->sum('salary_months.pinjaman');

            // $totalPinjamanWS = DB::table('users')
            //     ->join('salary_years', 'salary_years.nik', '=', 'users.nik')
            //     ->join('salary_months', 'salary_months.id_salary_year', '=', 'salary_years.id')
            //     ->where('users.dept', 'Workshop')
            //     ->where('users.status', 'Monthly')
            //     ->sum('salary_months.pinjaman');

            // $totalPinjamanWSOPR = DB::table('users')
            //     ->join('salary_years', 'salary_years.nik', '=', 'users.nik')
            //     ->join('salary_months', 'salary_months.id_salary_year', '=', 'salary_years.id')
            //     ->where('users.dept', 'Workshop')
            //     ->where('users.jabatan', 'Opr')
            //     ->where('users.status', 'Monthly')
            //     ->sum('salary_months.pinjaman');

            // $totalPinjamanAll = $totalPinjamanA + $totalPinjamanB + $totalPinjamanC + $totalPinjamanD + $totalPinjamanE + $totalPinjamanF + $totalPinjamanFSD + $totalPinjamanFAC + $totalPinjamanHO + $totalPinjamanSEC + $totalPinjamanWS + $totalPinjamanWSOPR;

            $totalMonthlyA = User::where('dept', 'I/A')->where('status', 'Monthly')->count();
            $totalMonthlyB = User::where('dept', 'I/B')->where('status', 'Monthly')->count();
            $totalMonthlyC = User::where('dept', 'I/C')->where('status', 'Monthly')->count();
            $totalMonthlyD = User::where('dept', 'II/D')->where('status', 'Monthly')->count();
            $totalMonthlyE = User::where('dept', 'II/E')->where('status', 'Monthly')->count();
            $totalMonthlyF = User::where('dept', 'II/F')->where('status', 'Monthly')->count();

            $totalMonthlyFSD = User::where('dept', 'FSD')->where('status', 'Monthly')->count();
            $totalMonthlyFAC = User::where('dept', 'Factory')->where('status', 'Monthly')->count();

            $totalMonthlyHO = User::where('loc_kerja', 'Head Office')->where('status', 'Monthly')->count();
            $totalMonthlySEC = User::where('dept', 'Security')->where('status', 'Monthly')->count();
            $totalMonthlyWS = User::where('dept', 'Workshop')->where('status', 'Monthly')->count();
            $totalMonthlyWSOPR = User::where('dept', 'Workshop')->where('jabatan', 'Opr')->where('status', 'Monthly')->count();

            $totalAll = $totalMonthlyA + $totalMonthlyB + $totalMonthlyC + $totalMonthlyD + $totalMonthlyE + $totalMonthlyF + $totalMonthlyFSD + $totalMonthlyFAC + $totalMonthlyHO + $totalMonthlySEC + $totalMonthlyWS + $totalMonthlyWSOPR;

            // dd($totalMonthlyFSD, $totalMonthlyFAC, $totalMonthlyHO, $totalMonthlySEC, $totalMonthlyWS, $totalMonthlyWSOPR);

            // $data = [];
            // foreach ($sal_allocation as $item) {
            //     $allocations = json_decode($item->allocation);
            //     if ($allocations) {
            //         foreach ($allocations as $div) {
            //             $data[$div]['allocation'][] = $div;
            //             $data[$div]['rate_salary'][] = $item->salary_year->salary_grade->rate_salary;
            //             $data[$div]['ability'][] = $item->salary_year->ability;
            //             $data[$div]['fungtional_alw'][] = $item->salary_year->fungtional_alw;
            //             $data[$div]['family_alw'][] = $item->salary_year->family_alw;
            //             $data[$div]['transport_alw'][] = $item->salary_year->transport_alw;
            //             $data[$div]['adjustment'][] = $item->salary_year->adjustment;
            //             $data[$div]['bpjs'][] = $item->salary_year->bpjs;
            //             $data[$div]['jamsostek'][] = $item->salary_year->jamsostek;
            //             $data[$div]['total_ben'][] = $item->salary_year->total_ben;
            //             $data[$div]['total_ben_ded'][] = $item->salary_year->total_ben_ded;
            //             $data[$div]['total_overtime'][] = $item->total_overtime;
            //             $data[$div]['thr'][] = $item->thr;
            //             $data[$div]['bonus'][] = $item->bonus;
            //             $data[$div]['incentive'][] = $item->incentive;
            //             $data[$div]['union'][] = $item->union;
            //             $data[$div]['absent'][] = $item->absent;
            //             $data[$div]['electricity'][] = $item->electricity;
            //             $data[$div]['cooperative'][] = $item->cooperative;
            //             $data[$div]['gross_salary'][] = $item->gross_salary;
            //             $data[$div]['total_deduction'][] = $item->total_deduction;
            //             $data[$div]['net_salary'][] = $item->net_salary;
            //         }
            //     } else {
            //         return redirect()->route('salary.index');
            //     }
            // }

            // $finalResult = [];

            // foreach ($data as $div => $values) {
            //     $finalResult[] = [
            //         'allocation' => $div,
            //         'rate_salary' => array_sum($values['rate_salary']),
            //         'ability' => array_sum($values['ability']),
            //         'fungtional_alw' => array_sum($values['fungtional_alw']),
            //         'family_alw' => array_sum($values['family_alw']),
            //         'transport_alw' => array_sum($values['transport_alw']),
            //         'adjustment' => array_sum($values['adjustment']),
            //         'bpjs' => array_sum($values['bpjs']),
            //         'jamsostek' => array_sum($values['jamsostek']),
            //         'total_ben' => array_sum($values['total_ben']),
            //         'total_ben_ded' => array_sum($values['total_ben_ded']),
            //         'total_overtime' => array_sum($values['total_overtime']),
            //         'thr' => array_sum($values['thr']),
            //         'bonus' => array_sum($values['bonus']),
            //         'incentive' => array_sum($values['incentive']),
            //         'union' => array_sum($values['union']),
            //         'absent' => array_sum($values['absent']),
            //         'electricity' => array_sum($values['electricity']),
            //         'cooperative' => array_sum($values['cooperative']),
            //         'gross_salary' => array_sum($values['gross_salary']),
            //         'total_deduction' => array_sum($values['total_deduction']),
            //         'net_salary' => array_sum($values['net_salary']),
            //     ];
            // }

            // // At the end of the displayTable method
            // $grandTotal = [
            //     'rate_salary' => 0,
            //     'ability' => 0,
            //     'fungtional_alw' => 0,
            //     'family_alw' => 0,
            //     'transport_alw' => 0,
            //     'adjustment' => 0,
            //     'bpjs' => 0,
            //     'jamsostek' => 0,
            //     'total_ben' => 0,
            //     'total_ben_ded' => 0,
            //     'total_overtime' => 0,
            //     'thr' => 0,
            //     'bonus' => 0,
            //     'incentive' => 0,
            //     'union' => 0,
            //     'absent' => 0,
            //     'electricity' => 0,
            //     'cooperative' => 0,
            //     'gross_salary' => 0,
            //     'total_deduction' => 0,
            //     'net_salary' => 0,
            // ];

            // if (!empty($finalResult)) {
            //     $grandTotal = [
            //         'rate_salary' =>  array_sum(array_column($finalResult, 'rate_salary')),
            //         'ability' => array_sum(array_column($finalResult, 'ability')),
            //         'fungtional_alw' => array_sum(array_column($finalResult, 'fungtional_alw')),
            //         'family_alw' => array_sum(array_column($finalResult, 'family_alw')),
            //         'transport_alw' => array_sum(array_column($finalResult, 'transport_alw')),
            //         'adjustment' => array_sum(array_column($finalResult, 'adjustment')),
            //         'bpjs' => array_sum(array_column($finalResult, 'bpjs')),
            //         'jamsostek' => array_sum(array_column($finalResult, 'jamsostek')),
            //         'total_ben' => array_sum(array_column($finalResult, 'total_ben')),
            //         'total_ben_ded' => array_sum(array_column($finalResult, 'total_ben_ded')),
            //         'total_overtime' => array_sum(array_column($finalResult, 'total_overtime')),
            //         'thr' => array_sum(array_column($finalResult, 'thr')),
            //         'bonus' => array_sum(array_column($finalResult, 'bonus')),
            //         'incentive' => array_sum(array_column($finalResult, 'incentive')),
            //         'union' => array_sum(array_column($finalResult, 'union')),
            //         'absent' => array_sum(array_column($finalResult, 'absent')),
            //         'electricity' => array_sum(array_column($finalResult, 'electricity')),
            //         'cooperative' => array_sum(array_column($finalResult, 'cooperative')),
            //         'gross_salary' => array_sum(array_column($finalResult, 'gross_salary')),
            //         'total_deduction' => array_sum(array_column($finalResult, 'total_deduction')),
            //         'net_salary' => array_sum(array_column($finalResult, 'net_salary')),
            //     ];
            // }

            $result = [
                'totalMonthlyA' => $totalMonthlyA,
                'totalMonthlyB' => $totalMonthlyB,
                'totalMonthlyC' => $totalMonthlyC,
                'totalMonthlyD' => $totalMonthlyD,
                'totalMonthlyE' => $totalMonthlyE,
                'totalMonthlyF' => $totalMonthlyF,
                'totalMonthlyFSD' => $totalMonthlyFSD,
                'totalMonthlyFAC' => $totalMonthlyFAC,
                'totalMonthlyHO' => $totalMonthlyHO,
                'totalMonthlySEC' => $totalMonthlySEC,
                'totalMonthlyWS' => $totalMonthlyWS,
                'totalMonthlyWSOPR' => $totalMonthlyWSOPR,
                'totalAll' => $totalAll,
                'getAllocationDir' => $getAllocationDir,
                'getAllocationMngDiv1' => $getAllocationMngDiv1,
                'getAllocationMngDiv2' => $getAllocationMngDiv2,
                'getAllocationAsstMngA' => $getAllocationAsstMngA,
                'getAllocationAsstUtilityA' => $getAllocationAsstUtilityA,
                'getAllocationAsstMngB' => $getAllocationAsstMngB,
                'getAllocationAsstUtilityB' => $getAllocationAsstUtilityB,
                'getAllocationAsstMngC' => $getAllocationAsstMngC,
                'getAllocationAsstMngD' => $getAllocationAsstMngD,
                'getAllocationAsstUtilityD' => $getAllocationAsstUtilityD,
                'getAllocationAsstMngE' => $getAllocationAsstMngE,
                'getAllocationAsstMngF' => $getAllocationAsstMngF,
                'getAllocationAsstMngFac' => $getAllocationAsstMngFac,
                'getAllocationAsstMngGae' => $getAllocationAsstMngGae,
                'getAllocationAsstMngWorkshop' => $getAllocationAsstMngWorkshop,
                'getAllocationAsstMngIso' => $getAllocationAsstMngIso,
                'getAllocationAsstMngSales' => $getAllocationAsstMngSales,
                'totalRateSalaryGae' => $totalRateSalaryGae,
                'totalAbilityGae' => $totalAbilityGae,
                'totalFungtionalAlwGae' => $totalFungtionalAlwGae,
                'totalFamilyAlwGae' => $totalFamilyAlwGae,
                'totalTelephoneAlwGae' => $totalTelephoneAlwGae,
                'totalTransportAlwGae' => $totalTransportAlwGae,
                'totalBpjsGae' => $totalBpjsGae,
                'totalJamsostekGae' => $totalJamsostekGae,
                'totalTotalOvertimeGae' => $totalTotalOvertimeGae,
                'totalPinjamanGae' => $totalPinjamanGae,
                'totalElectricityGae' => $totalElectricityGae,
                'totalAllocationCountGae' => $totalAllocationCountGae,
                'totalInternetGae' => $totalInternetGae,
                'totalGasGae' => $totalGasGae,
                'totalWaterGae' => $totalWaterGae,
                'year' => $year,
                'month' => $month
            ];

            $pdf = PDF::loadView('salary.printallocation_new', $result);
            return $pdf->setPaper(array(0, 0, 609.4488, 935.433), 'landscape')->stream('PrintAllocation.pdf');
        } else {
            $getAllocationSubDivA = DB::table('salary_months')
                ->join('salary_years', 'salary_years.id', '=', 'salary_months.id_salary_year')
                ->join('users', 'users.nik', '=', 'salary_years.nik')
                ->join('grade', 'grade.id', '=', 'salary_years.id_salary_grade')
                ->select(
                    'grade.rate_salary',
                    'salary_years.ability',
                    'salary_years.skill_alw',
                    'salary_years.family_alw',
                    'salary_years.telephone_alw',
                    'salary_years.transport_alw',
                    'salary_years.bpjs',
                    'salary_years.jamsostek',
                    'salary_months.incentive',
                    'salary_months.pinjaman',
                    'salary_months.total_overtime',
                    'salary_months.electricity',
                    'salary_months.union',
                    'salary_months.other',
                )
                ->selectRaw('JSON_LENGTH(salary_years.allocation) as allocation_count')
                ->where('users.status', 'Monthly')
                ->where('salary_years.allocation', '["A"]')
                ->whereYear('salary_months.date', $year)
                ->whereMonth('salary_months.date', $month)
                ->get();

                $subTotalRateSalaryA = $getAllocationSubDivA->sum('rate_salary');
                $totalAbilityA = $getAllocationSubDivA->sum('ability');
                $totalSkillAlwA = $getAllocationSubDivA->sum('skill_alw');
                $totalFamilyAlwA = $getAllocationSubDivA->sum('family_alw');
                $totalTelephoneAlwA = $getAllocationSubDivA->sum('telephone_alw');
                $totalTransportAlwA = $getAllocationSubDivA->sum('transport_alw');
                $totalTotalOvertimeA = $getAllocationSubDivA->sum('total_overtime');
                $totalTotalIncentiveA = $getAllocationSubDivA->sum('incentive');
                $totalPinjamanA = $getAllocationSubDivA->sum('pinjaman');
                $totalBpjsA = $getAllocationSubDivA->sum('bpjs');
                $totalJamsostekA = $getAllocationSubDivA->sum('jamsostek');
                $totalSPSIA = $getAllocationSubDivA->sum('union');
                $totalOtherA = $getAllocationSubDivA->sum('other');
                $subTotalElectricityA = $getAllocationSubDivA->sum('electricity');
                $totalAllocationCountA = $getAllocationSubDivA->sum('allocation_count');

            $getAllocationSubDivB = DB::table('salary_months')
                ->join('salary_years', 'salary_years.id', '=', 'salary_months.id_salary_year')
                ->join('users', 'users.nik', '=', 'salary_years.nik')
                ->join('grade', 'grade.id', '=', 'salary_years.id_salary_grade')
                ->select(
                    'grade.rate_salary',
                    'salary_years.ability',
                    'salary_years.skill_alw',
                    'salary_years.family_alw',
                    'salary_years.telephone_alw',
                    'salary_years.transport_alw',
                    'salary_years.bpjs',
                    'salary_years.jamsostek',
                    'salary_months.incentive',
                    'salary_months.pinjaman',
                    'salary_months.total_overtime',
                    'salary_months.electricity',
                    'salary_months.union',
                    'salary_months.other',
                )
                ->selectRaw('JSON_LENGTH(salary_years.allocation) as allocation_count')
                ->where('users.status', 'Monthly')
                ->where('salary_years.allocation', '["B"]')
                ->whereYear('salary_months.date', $year)
                ->whereMonth('salary_months.date', $month)
                ->get();

                $subTotalRateSalaryB = $getAllocationSubDivB->sum('rate_salary');
                $totalAbilityB = $getAllocationSubDivB->sum('ability');
                $totalSkillAlwB = $getAllocationSubDivB->sum('skill_alw');
                $totalFamilyAlwB = $getAllocationSubDivB->sum('family_alw');
                $totalTelephoneAlwB = $getAllocationSubDivB->sum('telephone_alw');
                $totalTransportAlwB = $getAllocationSubDivB->sum('transport_alw');
                $totalTotalOvertimeB = $getAllocationSubDivB->sum('total_overtime');
                $totalTotalIncentiveB = $getAllocationSubDivB->sum('incentive');
                $totalPinjamanB = $getAllocationSubDivB->sum('pinjaman');
                $totalBpjsB = $getAllocationSubDivB->sum('bpjs');
                $totalJamsostekB = $getAllocationSubDivB->sum('jamsostek');
                $totalSPSIB = $getAllocationSubDivB->sum('union');
                $totalOtherB = $getAllocationSubDivB->sum('other');
                $subTotalElectricityB = $getAllocationSubDivB->sum('electricity');
                $totalAllocationCountB = $getAllocationSubDivB->sum('allocation_count');

            $getAllocationSubDivC = DB::table('salary_months')
                ->join('salary_years', 'salary_years.id', '=', 'salary_months.id_salary_year')
                ->join('users', 'users.nik', '=', 'salary_years.nik')
                ->join('grade', 'grade.id', '=', 'salary_years.id_salary_grade')
                ->select(
                    'grade.rate_salary',
                    'salary_years.ability',
                    'salary_years.skill_alw',
                    'salary_years.family_alw',
                    'salary_years.telephone_alw',
                    'salary_years.transport_alw',
                    'salary_years.bpjs',
                    'salary_years.jamsostek',
                    'salary_months.incentive',
                    'salary_months.pinjaman',
                    'salary_months.total_overtime',
                    'salary_months.electricity',
                    'salary_months.union',
                    'salary_months.other',
                )
                ->selectRaw('JSON_LENGTH(salary_years.allocation) as allocation_count')
                ->where('users.status', 'Monthly')
                ->where('salary_years.allocation', '["C"]')
                ->whereYear('salary_months.date', $year)
                ->whereMonth('salary_months.date', $month)
                ->get();

                $subTotalRateSalaryC = $getAllocationSubDivC->sum('rate_salary');
                $totalAbilityC = $getAllocationSubDivC->sum('ability');
                $totalSkillAlwC = $getAllocationSubDivC->sum('skill_alw');
                $totalFamilyAlwC = $getAllocationSubDivC->sum('family_alw');
                $totalTelephoneAlwC = $getAllocationSubDivC->sum('telephone_alw');
                $totalTransportAlwC = $getAllocationSubDivC->sum('transport_alw');
                $totalTotalOvertimeC = $getAllocationSubDivC->sum('total_overtime');
                $totalTotalIncentiveC = $getAllocationSubDivC->sum('incentive');
                $totalPinjamanC = $getAllocationSubDivC->sum('pinjaman');
                $totalBpjsC = $getAllocationSubDivC->sum('bpjs');
                $totalJamsostekC = $getAllocationSubDivC->sum('jamsostek');
                $totalSPSIC = $getAllocationSubDivC->sum('union');
                $totalOtherC = $getAllocationSubDivC->sum('other');
                $subTotalElectricityC = $getAllocationSubDivC->sum('electricity');
                $totalAllocationCountC = $getAllocationSubDivC->sum('allocation_count');

            $getAllocationSubDivD = DB::table('salary_months')
                ->join('salary_years', 'salary_years.id', '=', 'salary_months.id_salary_year')
                ->join('users', 'users.nik', '=', 'salary_years.nik')
                ->join('grade', 'grade.id', '=', 'salary_years.id_salary_grade')
                ->select(
                    'grade.rate_salary',
                    'salary_years.ability',
                    'salary_years.skill_alw',
                    'salary_years.family_alw',
                    'salary_years.telephone_alw',
                    'salary_years.transport_alw',
                    'salary_years.bpjs',
                    'salary_years.jamsostek',
                    'salary_months.incentive',
                    'salary_months.pinjaman',
                    'salary_months.total_overtime',
                    'salary_months.electricity',
                    'salary_months.union',
                    'salary_months.other',
                )
                ->selectRaw('JSON_LENGTH(salary_years.allocation) as allocation_count')
                ->where('users.status', 'Monthly')
                ->where('salary_years.allocation', '["D"]')
                ->whereYear('salary_months.date', $year)
                ->whereMonth('salary_months.date', $month)
                ->get();

                $subTotalRateSalaryD = $getAllocationSubDivD->sum('rate_salary');
                $totalAbilityD = $getAllocationSubDivD->sum('ability');
                $totalSkillAlwD = $getAllocationSubDivD->sum('skill_alw');
                $totalFamilyAlwD = $getAllocationSubDivD->sum('family_alw');
                $totalTelephoneAlwD = $getAllocationSubDivD->sum('telephone_alw');
                $totalTransportAlwD = $getAllocationSubDivD->sum('transport_alw');
                $totalTotalOvertimeD = $getAllocationSubDivD->sum('total_overtime');
                $totalTotalIncentiveD = $getAllocationSubDivD->sum('incentive');
                $totalPinjamanD = $getAllocationSubDivD->sum('pinjaman');
                $totalBpjsD = $getAllocationSubDivD->sum('bpjs');
                $totalJamsostekD = $getAllocationSubDivD->sum('jamsostek');
                $totalSPSID = $getAllocationSubDivD->sum('union');
                $totalOtherD = $getAllocationSubDivD->sum('other');
                $subTotalElectricityD = $getAllocationSubDivD->sum('electricity');
                $totalAllocationCountD = $getAllocationSubDivD->sum('allocation_count');

            $getAllocationSubDivE = DB::table('salary_months')
                ->join('salary_years', 'salary_years.id', '=', 'salary_months.id_salary_year')
                ->join('users', 'users.nik', '=', 'salary_years.nik')
                ->join('grade', 'grade.id', '=', 'salary_years.id_salary_grade')
                ->select(
                    'grade.rate_salary',
                    'salary_years.ability',
                    'salary_years.skill_alw',
                    'salary_years.family_alw',
                    'salary_years.telephone_alw',
                    'salary_years.transport_alw',
                    'salary_years.bpjs',
                    'salary_years.jamsostek',
                    'salary_months.incentive',
                    'salary_months.pinjaman',
                    'salary_months.total_overtime',
                    'salary_months.electricity',
                    'salary_months.union',
                    'salary_months.other',
                )
                ->selectRaw('JSON_LENGTH(salary_years.allocation) as allocation_count')
                ->where('users.status', 'Monthly')
                ->where('salary_years.allocation', '["E"]')
                ->whereYear('salary_months.date', $year)
                ->whereMonth('salary_months.date', $month)
                ->get();

                $subTotalRateSalaryE = $getAllocationSubDivE->sum('rate_salary');
                $totalAbilityE = $getAllocationSubDivE->sum('ability');
                $totalSkillAlwE = $getAllocationSubDivE->sum('skill_alw');
                $totalFamilyAlwE = $getAllocationSubDivE->sum('family_alw');
                $totalTelephoneAlwE = $getAllocationSubDivE->sum('telephone_alw');
                $totalTransportAlwE = $getAllocationSubDivE->sum('transport_alw');
                $totalTotalOvertimeE = $getAllocationSubDivE->sum('total_overtime');
                $totalTotalIncentiveE = $getAllocationSubDivE->sum('incentive');
                $totalPinjamanE = $getAllocationSubDivE->sum('pinjaman');
                $totalBpjsE = $getAllocationSubDivE->sum('bpjs');
                $totalJamsostekE = $getAllocationSubDivE->sum('jamsostek');
                $totalSPSIE = $getAllocationSubDivE->sum('union');
                $totalOtherE = $getAllocationSubDivE->sum('other');
                $subTotalElectricityE = $getAllocationSubDivE->sum('electricity');
                $totalAllocationCountE = $getAllocationSubDivE->sum('allocation_count');

            $getAllocationSubDivF = DB::table('salary_months')
                ->join('salary_years', 'salary_years.id', '=', 'salary_months.id_salary_year')
                ->join('users', 'users.nik', '=', 'salary_years.nik')
                ->join('grade', 'grade.id', '=', 'salary_years.id_salary_grade')
                ->select(
                    'grade.rate_salary',
                    'salary_years.ability',
                    'salary_years.skill_alw',
                    'salary_years.family_alw',
                    'salary_years.telephone_alw',
                    'salary_years.transport_alw',
                    'salary_years.bpjs',
                    'salary_years.jamsostek',
                    'salary_months.incentive',
                    'salary_months.pinjaman',
                    'salary_months.total_overtime',
                    'salary_months.electricity',
                    'salary_months.union',
                    'salary_months.other',
                )
                ->selectRaw('JSON_LENGTH(salary_years.allocation) as allocation_count')
                ->where('users.status', 'Monthly')
                ->where('salary_years.allocation', '["F"]')
                ->whereYear('salary_months.date', $year)
                ->whereMonth('salary_months.date', $month)
                ->get();

                $subTotalRateSalaryF = $getAllocationSubDivF->sum('rate_salary');
                $totalAbilityF = $getAllocationSubDivF->sum('ability');
                $totalSkillAlwF = $getAllocationSubDivF->sum('skill_alw');
                $totalFamilyAlwF = $getAllocationSubDivF->sum('family_alw');
                $totalTelephoneAlwF = $getAllocationSubDivF->sum('telephone_alw');
                $totalTransportAlwF = $getAllocationSubDivF->sum('transport_alw');
                $totalTotalOvertimeF = $getAllocationSubDivF->sum('total_overtime');
                $totalTotalIncentiveF = $getAllocationSubDivF->sum('incentive');
                $totalPinjamanF = $getAllocationSubDivF->sum('pinjaman');
                $totalBpjsF = $getAllocationSubDivF->sum('bpjs');
                $totalJamsostekF = $getAllocationSubDivF->sum('jamsostek');
                $totalSPSIF = $getAllocationSubDivF->sum('union');
                $totalOtherF = $getAllocationSubDivF->sum('other');
                $subTotalElectricityF = $getAllocationSubDivF->sum('electricity');
                $totalAllocationCountF = $getAllocationSubDivF->sum('allocation_count');

            $getAllocationFSD = DB::table('salary_months')
                ->join('salary_years', 'salary_years.id', '=', 'salary_months.id_salary_year')
                ->join('users', 'users.nik', '=', 'salary_years.nik')
                ->join('grade', 'grade.id', '=', 'salary_years.id_salary_grade')
                ->select(
                    'grade.rate_salary',
                    'salary_years.ability',
                    'salary_years.skill_alw',
                    'salary_years.family_alw',
                    'salary_years.telephone_alw',
                    'salary_years.transport_alw',
                    'salary_years.bpjs',
                    'salary_years.jamsostek',
                    'salary_months.incentive',
                    'salary_months.pinjaman',
                    'salary_months.total_overtime',
                    'salary_months.electricity',
                    'salary_months.union',
                    'salary_months.other',
                )
                ->selectRaw('JSON_LENGTH(salary_years.allocation) as allocation_count')
                ->where('users.status', 'Monthly')
                ->where('salary_years.allocation', '["FSD"]')
                ->whereYear('salary_months.date', $year)
                ->whereMonth('salary_months.date', $month)
                ->get();

                $subTotalRateSalaryFSD = $getAllocationFSD->sum('rate_salary');
                $totalAbilityFSD = $getAllocationFSD->sum('ability');
                $totalSkillAlwFSD = $getAllocationFSD->sum('skill_alw');
                $totalFamilyAlwFSD = $getAllocationFSD->sum('family_alw');
                $totalTelephoneAlwFSD = $getAllocationFSD->sum('telephone_alw');
                $totalTransportAlwFSD = $getAllocationFSD->sum('transport_alw');
                $totalTotalOvertimeFSD = $getAllocationFSD->sum('total_overtime');
                $totalTotalIncentiveFSD = $getAllocationFSD->sum('incentive');
                $totalPinjamanFSD = $getAllocationFSD->sum('pinjaman');
                $totalBpjsFSD = $getAllocationFSD->sum('bpjs');
                $totalJamsostekFSD = $getAllocationFSD->sum('jamsostek');
                $totalSPSIFSD = $getAllocationFSD->sum('union');
                $totalOtherFSD = $getAllocationFSD->sum('other');
                $subTotalElectricityFSD = $getAllocationFSD->sum('electricity');
                $totalAllocationCountFSD = $getAllocationFSD->sum('allocation_count');

            $getAllocationNursery = DB::table('salary_months')
                ->join('salary_years', 'salary_years.id', '=', 'salary_months.id_salary_year')
                ->join('users', 'users.nik', '=', 'salary_years.nik')
                ->join('grade', 'grade.id', '=', 'salary_years.id_salary_grade')
                ->select(
                    'grade.rate_salary',
                    'salary_years.ability',
                    'salary_years.skill_alw',
                    'salary_years.family_alw',
                    'salary_years.telephone_alw',
                    'salary_years.transport_alw',
                    'salary_years.bpjs',
                    'salary_years.jamsostek',
                    'salary_months.incentive',
                    'salary_months.pinjaman',
                    'salary_months.total_overtime',
                    'salary_months.electricity',
                    'salary_months.union',
                    'salary_months.other',
                )
                ->selectRaw('JSON_LENGTH(salary_years.allocation) as allocation_count')
                ->where('users.status', 'Monthly')
                ->where('salary_years.allocation', '["Nursery"]')
                ->whereYear('salary_months.date', $year)
                ->whereMonth('salary_months.date', $month)
                ->get();

                $subTotalRateSalaryNursery = $getAllocationNursery->sum('rate_salary');
                $totalAbilityNursery = $getAllocationNursery->sum('ability');
                $totalSkillAlwNursery = $getAllocationNursery->sum('skill_alw');
                $totalFamilyAlwNursery = $getAllocationNursery->sum('family_alw');
                $totalTelephoneAlwNursery = $getAllocationNursery->sum('telephone_alw');
                $totalTransportAlwNursery = $getAllocationNursery->sum('transport_alw');
                $totalTotalOvertimeNursery = $getAllocationNursery->sum('total_overtime');
                $totalTotalIncentiveNursery = $getAllocationNursery->sum('incentive');
                $totalPinjamanNursery = $getAllocationNursery->sum('pinjaman');
                $totalBpjsNursery = $getAllocationNursery->sum('bpjs');
                $totalJamsostekNursery = $getAllocationNursery->sum('jamsostek');
                $totalSPSINursery = $getAllocationNursery->sum('union');
                $totalOtherNursery = $getAllocationNursery->sum('other');
                $subTotalElectricityNursery = $getAllocationNursery->sum('electricity');
                $totalAllocationCountNursery = $getAllocationNursery->sum('allocation_count');

            $getAllocationRSSFactory = DB::table('salary_months')
                ->join('salary_years', 'salary_years.id', '=', 'salary_months.id_salary_year')
                ->join('users', 'users.nik', '=', 'salary_years.nik')
                ->join('grade', 'grade.id', '=', 'salary_years.id_salary_grade')
                ->select(
                    'grade.rate_salary',
                    'salary_years.ability',
                    'salary_years.skill_alw',
                    'salary_years.family_alw',
                    'salary_years.telephone_alw',
                    'salary_years.transport_alw',
                    'salary_years.bpjs',
                    'salary_years.jamsostek',
                    'salary_months.incentive',
                    'salary_months.pinjaman',
                    'salary_months.total_overtime',
                    'salary_months.electricity',
                    'salary_months.union',
                    'salary_months.other',
                )
                ->selectRaw('JSON_LENGTH(salary_years.allocation) as allocation_count')
                ->where('users.status', 'Monthly')
                ->where('salary_years.allocation', '["RSS Factory"]')
                ->whereYear('salary_months.date', $year)
                ->whereMonth('salary_months.date', $month)
                ->get();

                $subTotalRateSalaryRSSFactory = $getAllocationRSSFactory->sum('rate_salary');
                $totalAbilityRSSFactory = $getAllocationRSSFactory->sum('ability');
                $totalSkillAlwRSSFactory = $getAllocationRSSFactory->sum('skill_alw');
                $totalFamilyAlwRSSFactory = $getAllocationRSSFactory->sum('family_alw');
                $totalTelephoneAlwRSSFactory = $getAllocationRSSFactory->sum('telephone_alw');
                $totalTransportAlwRSSFactory = $getAllocationRSSFactory->sum('transport_alw');
                $totalTotalOvertimeRSSFactory = $getAllocationRSSFactory->sum('total_overtime');
                $totalTotalIncentiveRSSFactory = $getAllocationRSSFactory->sum('incentive');
                $totalPinjamanRSSFactory = $getAllocationRSSFactory->sum('pinjaman');
                $totalBpjsRSSFactory = $getAllocationRSSFactory->sum('bpjs');
                $totalJamsostekRSSFactory = $getAllocationRSSFactory->sum('jamsostek');
                $totalSPSIRSSFactory = $getAllocationRSSFactory->sum('union');
                $totalOtherRSSFactory = $getAllocationRSSFactory->sum('other');
                $subTotalElectricityRSSFactory = $getAllocationRSSFactory->sum('electricity');
                $totalAllocationCountRSSFactory = $getAllocationRSSFactory->sum('allocation_count');

            $getAllocationRSSFactoryGradingProces = DB::table('salary_months')
                ->join('salary_years', 'salary_years.id', '=', 'salary_months.id_salary_year')
                ->join('users', 'users.nik', '=', 'salary_years.nik')
                ->join('grade', 'grade.id', '=', 'salary_years.id_salary_grade')
                ->select(
                    'grade.rate_salary',
                    'salary_years.ability',
                    'salary_years.skill_alw',
                    'salary_years.family_alw',
                    'salary_years.telephone_alw',
                    'salary_years.transport_alw',
                    'salary_years.bpjs',
                    'salary_years.jamsostek',
                    'salary_months.incentive',
                    'salary_months.pinjaman',
                    'salary_months.total_overtime',
                    'salary_months.electricity',
                    'salary_months.union',
                    'salary_months.other',
                )
                ->selectRaw('JSON_LENGTH(salary_years.allocation) as allocation_count')
                ->where('users.status', 'Monthly')
                ->where('salary_years.allocation', '["RSS Factory Grading & Proces"]')
                ->whereYear('salary_months.date', $year)
                ->whereMonth('salary_months.date', $month)
                ->get();

                $subTotalRateSalaryRSSFactoryGradingProces = $getAllocationRSSFactoryGradingProces->sum('rate_salary');
                $totalAbilityRSSFactoryGradingProces = $getAllocationRSSFactoryGradingProces->sum('ability');
                $totalSkillAlwRSSFactoryGradingProces = $getAllocationRSSFactoryGradingProces->sum('skill_alw');
                $totalFamilyAlwRSSFactoryGradingProces = $getAllocationRSSFactoryGradingProces->sum('family_alw');
                $totalTelephoneAlwRSSFactoryGradingProces = $getAllocationRSSFactoryGradingProces->sum('telephone_alw');
                $totalTransportAlwRSSFactoryGradingProces = $getAllocationRSSFactoryGradingProces->sum('transport_alw');
                $totalTotalOvertimeRSSFactoryGradingProces = $getAllocationRSSFactoryGradingProces->sum('total_overtime');
                $totalTotalIncentiveRSSFactoryGradingProces = $getAllocationRSSFactoryGradingProces->sum('incentive');
                $totalPinjamanRSSFactoryGradingProces = $getAllocationRSSFactoryGradingProces->sum('pinjaman');
                $totalBpjsRSSFactoryGradingProces = $getAllocationRSSFactoryGradingProces->sum('bpjs');
                $totalJamsostekRSSFactoryGradingProces = $getAllocationRSSFactoryGradingProces->sum('jamsostek');
                $totalSPSIRSSFactoryGradingProces = $getAllocationRSSFactoryGradingProces->sum('union');
                $totalOtherRSSFactoryGradingProces = $getAllocationRSSFactoryGradingProces->sum('other');
                $subTotalElectricityRSSFactoryGradingProces = $getAllocationRSSFactoryGradingProces->sum('electricity');
                $totalAllocationCountRSSFactoryGradingProces = $getAllocationRSSFactoryGradingProces->sum('allocation_count');

            $getAllocationOffice = DB::table('salary_months')
                ->join('salary_years', 'salary_years.id', '=', 'salary_months.id_salary_year')
                ->join('users', 'users.nik', '=', 'salary_years.nik')
                ->join('grade', 'grade.id', '=', 'salary_years.id_salary_grade')
                ->select(
                    'grade.rate_salary',
                    'salary_years.ability',
                    'salary_years.skill_alw',
                    'salary_years.family_alw',
                    'salary_years.telephone_alw',
                    'salary_years.transport_alw',
                    'salary_years.bpjs',
                    'salary_years.jamsostek',
                    'salary_months.incentive',
                    'salary_months.pinjaman',
                    'salary_months.total_overtime',
                    'salary_months.electricity',
                    'salary_months.union',
                    'salary_months.other',
                )
                ->selectRaw('JSON_LENGTH(salary_years.allocation) as allocation_count')
                ->where('users.status', 'Monthly')
                ->where('salary_years.allocation', '["GAE"]')
                ->whereYear('salary_months.date', $year)
                ->whereMonth('salary_months.date', $month)
                ->get();

                $subTotalRateSalaryOffice = $getAllocationOffice->sum('rate_salary');
                $totalAbilityOffice = $getAllocationOffice->sum('ability');
                $totalSkillAlwOffice = $getAllocationOffice->sum('skill_alw');
                $totalFamilyAlwOffice = $getAllocationOffice->sum('family_alw');
                $totalTelephoneAlwOffice = $getAllocationOffice->sum('telephone_alw');
                $totalTransportAlwOffice = $getAllocationOffice->sum('transport_alw');
                $totalTotalOvertimeOffice = $getAllocationOffice->sum('total_overtime');
                $totalTotalIncentiveOffice = $getAllocationOffice->sum('incentive');
                $totalPinjamanOffice = $getAllocationOffice->sum('pinjaman');
                $totalBpjsOffice = $getAllocationOffice->sum('bpjs');
                $totalJamsostekOffice = $getAllocationOffice->sum('jamsostek');
                $totalSPSIOffice = $getAllocationOffice->sum('union');
                $totalOtherOffice = $getAllocationOffice->sum('other');
                $subTotalElectricityOffice = $getAllocationOffice->sum('electricity');
                $totalAllocationCountOffice = $getAllocationOffice->sum('allocation_count');

            $getAllocationSecurity = DB::table('salary_months')
                ->join('salary_years', 'salary_years.id', '=', 'salary_months.id_salary_year')
                ->join('users', 'users.nik', '=', 'salary_years.nik')
                ->join('grade', 'grade.id', '=', 'salary_years.id_salary_grade')
                ->select(
                    'grade.rate_salary',
                    'salary_years.ability',
                    'salary_years.skill_alw',
                    'salary_years.family_alw',
                    'salary_years.telephone_alw',
                    'salary_years.transport_alw',
                    'salary_years.bpjs',
                    'salary_years.jamsostek',
                    'salary_months.incentive',
                    'salary_months.pinjaman',
                    'salary_months.total_overtime',
                    'salary_months.electricity',
                    'salary_months.union',
                    'salary_months.other',
                )
                ->selectRaw('JSON_LENGTH(salary_years.allocation) as allocation_count')
                ->where('users.status', 'Monthly')
                ->where('salary_years.allocation', '["Security"]')
                ->whereYear('salary_months.date', $year)
                ->whereMonth('salary_months.date', $month)
                ->get();

                $subTotalRateSalarySecurity = $getAllocationSecurity->sum('rate_salary');
                $totalAbilitySecurity = $getAllocationSecurity->sum('ability');
                $totalSkillAlwSecurity = $getAllocationSecurity->sum('skill_alw');
                $totalFamilyAlwSecurity = $getAllocationSecurity->sum('family_alw');
                $totalTelephoneAlwSecurity = $getAllocationSecurity->sum('telephone_alw');
                $totalTransportAlwSecurity = $getAllocationSecurity->sum('transport_alw');
                $totalTotalOvertimeSecurity = $getAllocationSecurity->sum('total_overtime');
                $totalTotalIncentiveSecurity = $getAllocationSecurity->sum('incentive');
                $totalPinjamanSecurity = $getAllocationSecurity->sum('pinjaman');
                $totalBpjsSecurity = $getAllocationSecurity->sum('bpjs');
                $totalJamsostekSecurity = $getAllocationSecurity->sum('jamsostek');
                $totalSPSISecurity = $getAllocationSecurity->sum('union');
                $totalOtherSecurity = $getAllocationSecurity->sum('other');
                $subTotalElectricitySecurity = $getAllocationSecurity->sum('electricity');
                $totalAllocationCountSecurity = $getAllocationSecurity->sum('allocation_count');

            $getAllocationWorkshop = DB::table('salary_months')
                ->join('salary_years', 'salary_years.id', '=', 'salary_months.id_salary_year')
                ->join('users', 'users.nik', '=', 'salary_years.nik')
                ->join('grade', 'grade.id', '=', 'salary_years.id_salary_grade')
                ->select(
                    'grade.rate_salary',
                    'salary_years.ability',
                    'salary_years.skill_alw',
                    'salary_years.family_alw',
                    'salary_years.telephone_alw',
                    'salary_years.transport_alw',
                    'salary_years.bpjs',
                    'salary_years.jamsostek',
                    'salary_months.incentive',
                    'salary_months.pinjaman',
                    'salary_months.total_overtime',
                    'salary_months.electricity',
                    'salary_months.union',
                    'salary_months.other',
                )
                ->selectRaw('JSON_LENGTH(salary_years.allocation) as allocation_count')
                ->where('users.status', 'Monthly')
                ->where('salary_years.allocation', '["Workshop"]')
                ->whereYear('salary_months.date', $year)
                ->whereMonth('salary_months.date', $month)
                ->get();

                $subTotalRateSalaryWorkshop = $getAllocationWorkshop->sum('rate_salary');
                $totalAbilityWorkshop = $getAllocationWorkshop->sum('ability');
                $totalSkillAlwWorkshop = $getAllocationWorkshop->sum('skill_alw');
                $totalFamilyAlwWorkshop = $getAllocationWorkshop->sum('family_alw');
                $totalTelephoneAlwWorkshop = $getAllocationWorkshop->sum('telephone_alw');
                $totalTransportAlwWorkshop = $getAllocationWorkshop->sum('transport_alw');
                $totalTotalOvertimeWorkshop = $getAllocationWorkshop->sum('total_overtime');
                $totalTotalIncentiveWorkshop = $getAllocationWorkshop->sum('incentive');
                $totalPinjamanWorkshop = $getAllocationWorkshop->sum('pinjaman');
                $totalBpjsWorkshop = $getAllocationWorkshop->sum('bpjs');
                $totalJamsostekWorkshop = $getAllocationWorkshop->sum('jamsostek');
                $totalSPSIWorkshop = $getAllocationWorkshop->sum('union');
                $totalOtherWorkshop = $getAllocationWorkshop->sum('other');
                $subTotalElectricityWorkshop = $getAllocationWorkshop->sum('electricity');
                $totalAllocationCountWorkshop = $getAllocationWorkshop->sum('allocation_count');

            $getAllocationOperator = DB::table('salary_months')
                ->join('salary_years', 'salary_years.id', '=', 'salary_months.id_salary_year')
                ->join('users', 'users.nik', '=', 'salary_years.nik')
                ->join('grade', 'grade.id', '=', 'salary_years.id_salary_grade')
                ->select(
                    'grade.rate_salary',
                    'salary_years.ability',
                    'salary_years.skill_alw',
                    'salary_years.family_alw',
                    'salary_years.telephone_alw',
                    'salary_years.transport_alw',
                    'salary_years.bpjs',
                    'salary_years.jamsostek',
                    'salary_months.incentive',
                    'salary_months.pinjaman',
                    'salary_months.total_overtime',
                    'salary_months.electricity',
                    'salary_months.union',
                    'salary_months.other',
                )
                ->selectRaw('JSON_LENGTH(salary_years.allocation) as allocation_count')
                ->where('users.status', 'Monthly')
                ->where('salary_years.allocation', '["Operator"]')
                ->whereYear('salary_months.date', $year)
                ->whereMonth('salary_months.date', $month)
                ->get();

                $subTotalRateSalaryOperator = $getAllocationOperator->sum('rate_salary');
                $totalAbilityOperator = $getAllocationOperator->sum('ability');
                $totalSkillAlwOperator = $getAllocationOperator->sum('skill_alw');
                $totalFamilyAlwOperator = $getAllocationOperator->sum('family_alw');
                $totalTelephoneAlwOperator = $getAllocationOperator->sum('telephone_alw');
                $totalTransportAlwOperator = $getAllocationOperator->sum('transport_alw');
                $totalTotalOvertimeOperator = $getAllocationOperator->sum('total_overtime');
                $totalTotalIncentiveOperator = $getAllocationOperator->sum('incentive');
                $totalPinjamanOperator = $getAllocationOperator->sum('pinjaman');
                $totalBpjsOperator = $getAllocationOperator->sum('bpjs');
                $totalJamsostekOperator = $getAllocationOperator->sum('jamsostek');
                $totalSPSIOperator = $getAllocationOperator->sum('union');
                $totalOtherOperator = $getAllocationOperator->sum('other');
                $subTotalElectricityOperator = $getAllocationOperator->sum('electricity');
                $totalAllocationCountOperator = $getAllocationOperator->sum('allocation_count');

            $getAllocationContractBSKPOffice = DB::table('salary_months')
                ->join('salary_years', 'salary_years.id', '=', 'salary_months.id_salary_year')
                ->join('users', 'users.nik', '=', 'salary_years.nik')
                ->join('grade', 'grade.id', '=', 'salary_years.id_salary_grade')
                ->select(
                    'grade.rate_salary',
                    'salary_years.ability',
                    'salary_years.skill_alw',
                    'salary_years.family_alw',
                    'salary_years.telephone_alw',
                    'salary_years.transport_alw',
                    'salary_years.bpjs',
                    'salary_years.jamsostek',
                    'salary_months.incentive',
                    'salary_months.pinjaman',
                    'salary_months.total_overtime',
                    'salary_months.electricity',
                    'salary_months.union',
                    'salary_months.other',
                )
                ->selectRaw('JSON_LENGTH(salary_years.allocation) as allocation_count')
                ->where('users.status', 'Contract BSKP')
                ->where('salary_years.allocation', '["Contract BSKP Office"]')
                ->whereYear('salary_months.date', $year)
                ->whereMonth('salary_months.date', $month)
                ->get();

                $subTotalRateSalaryContractBSKPOffice = $getAllocationContractBSKPOffice->sum('rate_salary');
                $totalAbilityContractBSKPOffice = $getAllocationContractBSKPOffice->sum('ability');
                $totalSkillAlwContractBSKPOffice = $getAllocationContractBSKPOffice->sum('skill_alw');
                $totalFamilyAlwContractBSKPOffice = $getAllocationContractBSKPOffice->sum('family_alw');
                $totalTelephoneAlwContractBSKPOffice = $getAllocationContractBSKPOffice->sum('telephone_alw');
                $totalTransportAlwContractBSKPOffice = $getAllocationContractBSKPOffice->sum('transport_alw');
                $totalTotalOvertimeContractBSKPOffice = $getAllocationContractBSKPOffice->sum('total_overtime');
                $totalTotalIncentiveContractBSKPOffice = $getAllocationContractBSKPOffice->sum('incentive');
                $totalPinjamanContractBSKPOffice = $getAllocationContractBSKPOffice->sum('pinjaman');
                $totalBpjsContractBSKPOffice = $getAllocationContractBSKPOffice->sum('bpjs');
                $totalJamsostekContractBSKPOffice = $getAllocationContractBSKPOffice->sum('jamsostek');
                $totalSPSIContractBSKPOffice = $getAllocationContractBSKPOffice->sum('union');
                $totalOtherContractBSKPOffice = $getAllocationContractBSKPOffice->sum('other');
                $subTotalElectricityContractBSKPOffice = $getAllocationContractBSKPOffice->sum('electricity');
                $totalAllocationCountContractBSKPOffice = $getAllocationContractBSKPOffice->sum('allocation_count');

            $getAllocationContractBSKPWorkshop = DB::table('salary_months')
                ->join('salary_years', 'salary_years.id', '=', 'salary_months.id_salary_year')
                ->join('users', 'users.nik', '=', 'salary_years.nik')
                ->join('grade', 'grade.id', '=', 'salary_years.id_salary_grade')
                ->select(
                    'grade.rate_salary',
                    'salary_years.ability',
                    'salary_years.skill_alw',
                    'salary_years.family_alw',
                    'salary_years.telephone_alw',
                    'salary_years.transport_alw',
                    'salary_years.bpjs',
                    'salary_years.jamsostek',
                    'salary_months.incentive',
                    'salary_months.pinjaman',
                    'salary_months.total_overtime',
                    'salary_months.electricity',
                    'salary_months.union',
                    'salary_months.other',
                )
                ->selectRaw('JSON_LENGTH(salary_years.allocation) as allocation_count')
                ->where('users.status', 'Contract BSKP')
                ->where('salary_years.allocation', '["Contract BSKP Workshop"]')
                ->whereYear('salary_months.date', $year)
                ->whereMonth('salary_months.date', $month)
                ->get();

                $subTotalRateSalaryContractBSKPWorkshop = $getAllocationContractBSKPWorkshop->sum('rate_salary');
                $totalAbilityContractBSKPWorkshop = $getAllocationContractBSKPWorkshop->sum('ability');
                $totalSkillAlwContractBSKPWorkshop = $getAllocationContractBSKPWorkshop->sum('skill_alw');
                $totalFamilyAlwContractBSKPWorkshop = $getAllocationContractBSKPWorkshop->sum('family_alw');
                $totalTelephoneAlwContractBSKPWorkshop = $getAllocationContractBSKPWorkshop->sum('telephone_alw');
                $totalTransportAlwContractBSKPWorkshop = $getAllocationContractBSKPWorkshop->sum('transport_alw');
                $totalTotalOvertimeContractBSKPWorkshop = $getAllocationContractBSKPWorkshop->sum('total_overtime');
                $totalTotalIncentiveContractBSKPWorkshop = $getAllocationContractBSKPWorkshop->sum('incentive');
                $totalPinjamanContractBSKPWorkshop = $getAllocationContractBSKPWorkshop->sum('pinjaman');
                $totalBpjsContractBSKPWorkshop = $getAllocationContractBSKPWorkshop->sum('bpjs');
                $totalJamsostekContractBSKPWorkshop = $getAllocationContractBSKPWorkshop->sum('jamsostek');
                $totalSPSIContractBSKPWorkshop = $getAllocationContractBSKPWorkshop->sum('union');
                $totalOtherContractBSKPWorkshop = $getAllocationContractBSKPWorkshop->sum('other');
                $subTotalElectricityContractBSKPWorkshop = $getAllocationContractBSKPWorkshop->sum('electricity');
                $totalAllocationCountContractBSKPWorkshop = $getAllocationContractBSKPWorkshop->sum('allocation_count');

                $totalAllocationA = SalaryYear::where('allocation', '["A"]')->count();
                $totalAllocationB = SalaryYear::where('allocation', '["B"]')->count();
                $totalAllocationC = SalaryYear::where('allocation', '["C"]')->count();
                $totalAllocationD = SalaryYear::where('allocation', '["D"]')->count();
                $totalAllocationE = SalaryYear::where('allocation', '["E"]')->count();
                $totalAllocationF = SalaryYear::where('allocation', '["F"]')->count();

                $totalAllocationFSD = SalaryYear::where('allocation', '["FSD"]')->count();
                $totalAllocationNursery = SalaryYear::where('allocation', '["Nursery"]')->count();
                $totalAllocationRSSFactory = SalaryYear::where('allocation', '["RSS Factory"]')->count();
                $totalAllocationRSSFactoryGradingProces = SalaryYear::where('allocation', '["RSS Factory Grading & Proces"]')->count();

                $totalAllocationOffice = SalaryYear::where('allocation', '["GAE"]')->count();
                $totalAllocationSecurity = SalaryYear::where('allocation', '["Security"]')->count();
                $totalAllocationWorkshop = SalaryYear::where('allocation', '["Workshop"]')->count();
                $totalAllocationOperator = SalaryYear::where('allocation', '["Operator"]')->count();

                $totalAllocationContractBSKPOffice = SalaryYear::where('allocation', '["Contract BSKP Office"]')->count();
                $totalAllocationContractBSKPWorkshop = SalaryYear::where('allocation', '["Contract BSKP Workshop"]')->count();

                $totalAll = $totalAllocationA + $totalAllocationB + $totalAllocationC + $totalAllocationD + $totalAllocationE +
                $totalAllocationF + $totalAllocationFSD + $totalAllocationNursery + $totalAllocationRSSFactory + $totalAllocationRSSFactoryGradingProces +
                $totalAllocationOffice + $totalAllocationSecurity + $totalAllocationWorkshop + $totalAllocationOperator + $totalAllocationContractBSKPOffice +
                $totalAllocationContractBSKPWorkshop;

                // dd($totalAllocationA);

                $result = [
                    'totalAllocationA' => $totalAllocationA,
                    'totalAllocationB' => $totalAllocationB,
                    'totalAllocationC' => $totalAllocationC,
                    'totalAllocationD' => $totalAllocationD,
                    'totalAllocationE' => $totalAllocationE,
                    'totalAllocationF' => $totalAllocationF,
                    'totalAllocationFSD' => $totalAllocationFSD,
                    'totalAllocationNursery' => $totalAllocationNursery,
                    'totalAllocationRSSFactory' => $totalAllocationRSSFactory,
                    'totalAllocationRSSFactoryGradingProces' => $totalAllocationRSSFactoryGradingProces,
                    'totalAllocationOffice' => $totalAllocationOffice,
                    'totalAllocationSecurity' => $totalAllocationSecurity,
                    'totalAllocationWorkshop' => $totalAllocationWorkshop,
                    'totalAllocationOperator' => $totalAllocationOperator,
                    'totalAllocationContractBSKPOffice' => $totalAllocationContractBSKPOffice,
                    'totalAllocationContractBSKPWorkshop' => $totalAllocationContractBSKPWorkshop,
                    'totalAll' => $totalAll,
                    'getAllocationSubDivA' => $getAllocationSubDivA,
                    'subTotalRateSalaryA' => $subTotalRateSalaryA,
                    'totalAbilityA' => $totalAbilityA,
                    'totalSkillAlwA' => $totalSkillAlwA,
                    'totalFamilyAlwA' => $totalFamilyAlwA,
                    'totalTelephoneAlwA' => $totalTelephoneAlwA,
                    'totalTransportAlwA' => $totalTransportAlwA,
                    'totalTotalOvertimeA' => $totalTotalOvertimeA,
                    'totalTotalIncentiveA' => $totalTotalIncentiveA,
                    'totalPinjamanA' => $totalPinjamanA,
                    'totalBpjsA' => $totalBpjsA,
                    'totalJamsostekA' => $totalJamsostekA,
                    'totalSPSIA' => $totalSPSIA,
                    'totalOtherA' => $totalOtherA,
                    'subTotalElectricityA' => $subTotalElectricityA,
                    'totalAllocationCountA' => $totalAllocationCountA,
                    'getAllocationSubDivB' => $getAllocationSubDivB,
                    'subTotalRateSalaryB' => $subTotalRateSalaryB,
                    'totalAbilityB' => $totalAbilityB,
                    'totalSkillAlwB' => $totalSkillAlwB,
                    'totalFamilyAlwB' => $totalFamilyAlwB,
                    'totalTelephoneAlwB' => $totalTelephoneAlwB,
                    'totalTransportAlwB' => $totalTransportAlwB,
                    'totalTotalOvertimeB' => $totalTotalOvertimeB,
                    'totalTotalIncentiveB' => $totalTotalIncentiveB,
                    'totalPinjamanB' => $totalPinjamanB,
                    'totalBpjsB' => $totalBpjsB,
                    'totalJamsostekB' => $totalJamsostekB,
                    'totalSPSIB' => $totalSPSIB,
                    'totalOtherB' => $totalOtherB,
                    'subTotalElectricityB' => $subTotalElectricityB,
                    'totalAllocationCountB' => $totalAllocationCountB,
                    'getAllocationSubDivC' => $getAllocationSubDivC,
                    'subTotalRateSalaryC' => $subTotalRateSalaryC,
                    'totalAbilityC' => $totalAbilityC,
                    'totalSkillAlwC' => $totalSkillAlwC,
                    'totalFamilyAlwC' => $totalFamilyAlwC,
                    'totalTelephoneAlwC' => $totalTelephoneAlwC,
                    'totalTransportAlwC' => $totalTransportAlwC,
                    'totalTotalOvertimeC' => $totalTotalOvertimeC,
                    'totalTotalIncentiveC' => $totalTotalIncentiveC,
                    'totalPinjamanC' => $totalPinjamanC,
                    'totalBpjsC' => $totalBpjsC,
                    'totalJamsostekC' => $totalJamsostekC,
                    'totalSPSIC' => $totalSPSIC,
                    'totalOtherC' => $totalOtherC,
                    'subTotalElectricityC' => $subTotalElectricityC,
                    'totalAllocationCountC' => $totalAllocationCountC,
                    'getAllocationSubDivD' => $getAllocationSubDivD,
                    'subTotalRateSalaryD' => $subTotalRateSalaryD,
                    'totalAbilityD' => $totalAbilityD,
                    'totalSkillAlwD' => $totalSkillAlwD,
                    'totalFamilyAlwD' => $totalFamilyAlwD,
                    'totalTelephoneAlwD' => $totalTelephoneAlwD,
                    'totalTransportAlwD' => $totalTransportAlwD,
                    'totalTotalOvertimeD' => $totalTotalOvertimeD,
                    'totalTotalIncentiveD' => $totalTotalIncentiveD,
                    'totalPinjamanD' => $totalPinjamanD,
                    'totalBpjsD' => $totalBpjsD,
                    'totalJamsostekD' => $totalJamsostekD,
                    'totalSPSID' => $totalSPSID,
                    'totalOtherD' => $totalOtherD,
                    'subTotalElectricityD' => $subTotalElectricityD,
                    'totalAllocationCountD' => $totalAllocationCountD,
                    'getAllocationSubDivE' => $getAllocationSubDivE,
                    'subTotalRateSalaryE' => $subTotalRateSalaryE,
                    'totalAbilityE' => $totalAbilityE,
                    'totalSkillAlwE' => $totalSkillAlwE,
                    'totalFamilyAlwE' => $totalFamilyAlwE,
                    'totalTelephoneAlwE' => $totalTelephoneAlwE,
                    'totalTransportAlwE' => $totalTransportAlwE,
                    'totalTotalOvertimeE' => $totalTotalOvertimeE,
                    'totalTotalIncentiveE' => $totalTotalIncentiveE,
                    'totalPinjamanE' => $totalPinjamanE,
                    'totalBpjsE' => $totalBpjsE,
                    'totalJamsostekE' => $totalJamsostekE,
                    'totalSPSIE' => $totalSPSIE,
                    'totalOtherE' => $totalOtherE,
                    'subTotalElectricityE' => $subTotalElectricityE,
                    'totalAllocationCountE' => $totalAllocationCountE,
                    'getAllocationSubDivF' => $getAllocationSubDivF,
                    'subTotalRateSalaryF' => $subTotalRateSalaryF,
                    'totalAbilityF' => $totalAbilityF,
                    'totalSkillAlwF' => $totalSkillAlwF,
                    'totalFamilyAlwF' => $totalFamilyAlwF,
                    'totalTelephoneAlwF' => $totalTelephoneAlwF,
                    'totalTransportAlwF' => $totalTransportAlwF,
                    'totalTotalOvertimeF' => $totalTotalOvertimeF,
                    'totalTotalIncentiveF' => $totalTotalIncentiveF,
                    'totalPinjamanF' => $totalPinjamanF,
                    'totalBpjsF' => $totalBpjsF,
                    'totalJamsostekF' => $totalJamsostekF,
                    'totalSPSIF' => $totalSPSIF,
                    'totalOtherF' => $totalOtherF,
                    'subTotalElectricityF' => $subTotalElectricityF,
                    'totalAllocationCountF' => $totalAllocationCountF,
                    'getAllocationFSD' => $getAllocationFSD,
                    'subTotalRateSalaryFSD' => $subTotalRateSalaryFSD,
                    'totalAbilityFSD' => $totalAbilityFSD,
                    'totalSkillAlwFSD' => $totalSkillAlwFSD,
                    'totalFamilyAlwFSD' => $totalFamilyAlwFSD,
                    'totalTelephoneAlwFSD' => $totalTelephoneAlwFSD,
                    'totalTransportAlwFSD' => $totalTransportAlwFSD,
                    'totalTotalOvertimeFSD' => $totalTotalOvertimeFSD,
                    'totalTotalIncentiveFSD' => $totalTotalIncentiveFSD,
                    'totalPinjamanFSD' => $totalPinjamanFSD,
                    'totalBpjsFSD' => $totalBpjsFSD,
                    'totalJamsostekFSD' => $totalJamsostekFSD,
                    'totalSPSIFSD' => $totalSPSIFSD,
                    'totalOtherFSD' => $totalOtherFSD,
                    'subTotalElectricityFSD' => $subTotalElectricityFSD,
                    'totalAllocationCountFSD' => $totalAllocationCountFSD,
                    'getAllocationNursery' => $getAllocationNursery,
                    'subTotalRateSalaryNursery' => $subTotalRateSalaryNursery,
                    'totalAbilityNursery' => $totalAbilityNursery,
                    'totalSkillAlwNursery' => $totalSkillAlwNursery,
                    'totalFamilyAlwNursery' => $totalFamilyAlwNursery,
                    'totalTelephoneAlwNursery' => $totalTelephoneAlwNursery,
                    'totalTransportAlwNursery' => $totalTransportAlwNursery,
                    'totalTotalOvertimeNursery' => $totalTotalOvertimeNursery,
                    'totalTotalIncentiveNursery' => $totalTotalIncentiveNursery,
                    'totalPinjamanNursery' => $totalPinjamanNursery,
                    'totalBpjsNursery' => $totalBpjsNursery,
                    'totalJamsostekNursery' => $totalJamsostekNursery,
                    'totalSPSINursery' => $totalSPSINursery,
                    'totalOtherNursery' => $totalOtherNursery,
                    'subTotalElectricityNursery' => $subTotalElectricityNursery,
                    'totalAllocationCountNursery' => $totalAllocationCountNursery,
                    'getAllocationRSSFactory' => $getAllocationRSSFactory,
                    'subTotalRateSalaryRSSFactory' => $subTotalRateSalaryRSSFactory,
                    'totalAbilityRSSFactory' => $totalAbilityRSSFactory,
                    'totalSkillAlwRSSFactory' => $totalSkillAlwRSSFactory,
                    'totalFamilyAlwRSSFactory' => $totalFamilyAlwRSSFactory,
                    'totalTelephoneAlwRSSFactory' => $totalTelephoneAlwRSSFactory,
                    'totalTransportAlwRSSFactory' => $totalTransportAlwRSSFactory,
                    'totalTotalOvertimeRSSFactory' => $totalTotalOvertimeRSSFactory,
                    'totalTotalIncentiveRSSFactory' => $totalTotalIncentiveRSSFactory,
                    'totalPinjamanRSSFactory' => $totalPinjamanRSSFactory,
                    'totalBpjsRSSFactory' => $totalBpjsRSSFactory,
                    'totalJamsostekRSSFactory' => $totalJamsostekRSSFactory,
                    'totalSPSIRSSFactory' => $totalSPSIRSSFactory,
                    'totalOtherRSSFactory' => $totalOtherRSSFactory,
                    'subTotalElectricityRSSFactory' => $subTotalElectricityRSSFactory,
                    'totalAllocationCountRSSFactory' => $totalAllocationCountRSSFactory,
                    'getAllocationRSSFactoryGradingProces' => $getAllocationRSSFactoryGradingProces,
                    'subTotalRateSalaryRSSFactoryGradingProces' => $subTotalRateSalaryRSSFactoryGradingProces,
                    'totalAbilityRSSFactoryGradingProces' => $totalAbilityRSSFactoryGradingProces,
                    'totalSkillAlwRSSFactoryGradingProces' => $totalSkillAlwRSSFactoryGradingProces,
                    'totalFamilyAlwRSSFactoryGradingProces' => $totalFamilyAlwRSSFactoryGradingProces,
                    'totalTelephoneAlwRSSFactoryGradingProces' => $totalTelephoneAlwRSSFactoryGradingProces,
                    'totalTransportAlwRSSFactoryGradingProces' => $totalTransportAlwRSSFactoryGradingProces,
                    'totalTotalOvertimeRSSFactoryGradingProces' => $totalTotalOvertimeRSSFactoryGradingProces,
                    'totalTotalIncentiveRSSFactoryGradingProces' => $totalTotalIncentiveRSSFactoryGradingProces,
                    'totalPinjamanRSSFactoryGradingProces' => $totalPinjamanRSSFactoryGradingProces,
                    'totalBpjsRSSFactoryGradingProces' => $totalBpjsRSSFactoryGradingProces,
                    'totalJamsostekRSSFactoryGradingProces' => $totalJamsostekRSSFactoryGradingProces,
                    'totalSPSIRSSFactoryGradingProces' => $totalSPSIRSSFactoryGradingProces,
                    'totalOtherRSSFactoryGradingProces' => $totalOtherRSSFactoryGradingProces,
                    'subTotalElectricityRSSFactoryGradingProces' => $subTotalElectricityRSSFactoryGradingProces,
                    'totalAllocationCountRSSFactoryGradingProces' => $totalAllocationCountRSSFactoryGradingProces,
                    'getAllocationOffice' => $getAllocationOffice,
                    'subTotalRateSalaryOffice' => $subTotalRateSalaryOffice,
                    'totalAbilityOffice' => $totalAbilityOffice,
                    'totalSkillAlwOffice' => $totalSkillAlwOffice,
                    'totalFamilyAlwOffice' => $totalFamilyAlwOffice,
                    'totalTelephoneAlwOffice' => $totalTelephoneAlwOffice,
                    'totalTransportAlwOffice' => $totalTransportAlwOffice,
                    'totalTotalOvertimeOffice' => $totalTotalOvertimeOffice,
                    'totalTotalIncentiveOffice' => $totalTotalIncentiveOffice,
                    'totalPinjamanOffice' => $totalPinjamanOffice,
                    'totalBpjsOffice' => $totalBpjsOffice,
                    'totalJamsostekOffice' => $totalJamsostekOffice,
                    'totalSPSIOffice' => $totalSPSIOffice,
                    'totalOtherOffice' => $totalOtherOffice,
                    'subTotalElectricityOffice' => $subTotalElectricityOffice,
                    'totalAllocationCountOffice' => $totalAllocationCountOffice,
                    'getAllocationSecurity' => $getAllocationSecurity,
                    'subTotalRateSalarySecurity' => $subTotalRateSalarySecurity,
                    'totalAbilitySecurity' => $totalAbilitySecurity,
                    'totalSkillAlwSecurity' => $totalSkillAlwSecurity,
                    'totalFamilyAlwSecurity' => $totalFamilyAlwSecurity,
                    'totalTelephoneAlwSecurity' => $totalTelephoneAlwSecurity,
                    'totalTransportAlwSecurity' => $totalTransportAlwSecurity,
                    'totalTotalOvertimeSecurity' => $totalTotalOvertimeSecurity,
                    'totalTotalIncentiveSecurity' => $totalTotalIncentiveSecurity,
                    'totalPinjamanSecurity' => $totalPinjamanSecurity,
                    'totalBpjsSecurity' => $totalBpjsSecurity,
                    'totalJamsostekSecurity' => $totalJamsostekSecurity,
                    'totalSPSISecurity' => $totalSPSISecurity,
                    'totalOtherSecurity' => $totalOtherSecurity,
                    'subTotalElectricitySecurity' => $subTotalElectricitySecurity,
                    'totalAllocationCountSecurity' => $totalAllocationCountSecurity,

                    'getAllocationWorkshop' => $getAllocationWorkshop,
                    'subTotalRateSalaryWorkshop' => $subTotalRateSalaryWorkshop,
                    'totalAbilityWorkshop' => $totalAbilityWorkshop,
                    'totalSkillAlwWorkshop' => $totalSkillAlwWorkshop,
                    'totalFamilyAlwWorkshop' => $totalFamilyAlwWorkshop,
                    'totalTelephoneAlwWorkshop' => $totalTelephoneAlwWorkshop,
                    'totalTransportAlwWorkshop' => $totalTransportAlwWorkshop,
                    'totalTotalOvertimeWorkshop' => $totalTotalOvertimeWorkshop,
                    'totalTotalIncentiveWorkshop' => $totalTotalIncentiveWorkshop,
                    'totalPinjamanWorkshop' => $totalPinjamanWorkshop,
                    'totalBpjsWorkshop' => $totalBpjsWorkshop,
                    'totalJamsostekWorkshop' => $totalJamsostekWorkshop,
                    'totalSPSIWorkshop' => $totalSPSIWorkshop,
                    'totalOtherWorkshop' => $totalOtherWorkshop,
                    'subTotalElectricityWorkshop' => $subTotalElectricityWorkshop,
                    'totalAllocationCountWorkshop' => $totalAllocationCountWorkshop,
                    'getAllocationOperator' => $getAllocationOperator,
                    'subTotalRateSalaryOperator' => $subTotalRateSalaryOperator,
                    'totalAbilityOperator' => $totalAbilityOperator,
                    'totalSkillAlwOperator' => $totalSkillAlwOperator,
                    'totalFamilyAlwOperator' => $totalFamilyAlwOperator,
                    'totalTelephoneAlwOperator' => $totalTelephoneAlwOperator,
                    'totalTransportAlwOperator' => $totalTransportAlwOperator,
                    'totalTotalOvertimeOperator' => $totalTotalOvertimeOperator,
                    'totalTotalIncentiveOperator' => $totalTotalIncentiveOperator,
                    'totalPinjamanOperator' => $totalPinjamanOperator,
                    'totalBpjsOperator' => $totalBpjsOperator,
                    'totalJamsostekOperator' => $totalJamsostekOperator,
                    'totalSPSIOperator' => $totalSPSIOperator,
                    'totalOtherOperator' => $totalOtherOperator,
                    'subTotalElectricityOperator' => $subTotalElectricityOperator,
                    'totalAllocationCountOperator' => $totalAllocationCountOperator,
                    'getAllocationContractBSKPOffice' => $getAllocationContractBSKPOffice,
                    'subTotalRateSalaryContractBSKPOffice' => $subTotalRateSalaryContractBSKPOffice,
                    'totalAbilityContractBSKPOffice' => $totalAbilityContractBSKPOffice,
                    'totalSkillAlwContractBSKPOffice' => $totalSkillAlwContractBSKPOffice,
                    'totalFamilyAlwContractBSKPOffice' => $totalFamilyAlwContractBSKPOffice,
                    'totalTelephoneAlwContractBSKPOffice' => $totalTelephoneAlwContractBSKPOffice,
                    'totalTransportAlwContractBSKPOffice' => $totalTransportAlwContractBSKPOffice,
                    'totalTotalOvertimeContractBSKPOffice' => $totalTotalOvertimeContractBSKPOffice,
                    'totalTotalIncentiveContractBSKPOffice' => $totalTotalIncentiveContractBSKPOffice,
                    'totalPinjamanContractBSKPOffice' => $totalPinjamanContractBSKPOffice,
                    'totalBpjsContractBSKPOffice' => $totalBpjsContractBSKPOffice,
                    'totalJamsostekContractBSKPOffice' => $totalJamsostekContractBSKPOffice,
                    'totalSPSIContractBSKPOffice' => $totalSPSIContractBSKPOffice,
                    'totalOtherContractBSKPOffice' => $totalOtherContractBSKPOffice,
                    'subTotalElectricityContractBSKPOffice' => $subTotalElectricityContractBSKPOffice,
                    'totalAllocationCountContractBSKPOffice' => $totalAllocationCountContractBSKPOffice,
                    'getAllocationContractBSKPWorkshop' => $getAllocationContractBSKPWorkshop,
                    'subTotalRateSalaryContractBSKPWorkshop' => $subTotalRateSalaryContractBSKPWorkshop,
                    'totalAbilityContractBSKPWorkshop' => $totalAbilityContractBSKPWorkshop,
                    'totalSkillAlwContractBSKPWorkshop' => $totalSkillAlwContractBSKPWorkshop,
                    'totalFamilyAlwContractBSKPWorkshop' => $totalFamilyAlwContractBSKPWorkshop,
                    'totalTelephoneAlwContractBSKPWorkshop' => $totalTelephoneAlwContractBSKPWorkshop,
                    'totalTransportAlwContractBSKPWorkshop' => $totalTransportAlwContractBSKPWorkshop,
                    'totalTotalOvertimeContractBSKPWorkshop' => $totalTotalOvertimeContractBSKPWorkshop,
                    'totalTotalIncentiveContractBSKPWorkshop' => $totalTotalIncentiveContractBSKPWorkshop,
                    'totalPinjamanContractBSKPWorkshop' => $totalPinjamanContractBSKPWorkshop,
                    'totalBpjsContractBSKPWorkshop' => $totalBpjsContractBSKPWorkshop,
                    'totalJamsostekContractBSKPWorkshop' => $totalJamsostekContractBSKPWorkshop,
                    'totalSPSIContractBSKPWorkshop' => $totalSPSIContractBSKPWorkshop,
                    'totalOtherContractBSKPWorkshop' => $totalOtherContractBSKPWorkshop,
                    'subTotalElectricityContractBSKPWorkshop' => $subTotalElectricityContractBSKPWorkshop,
                    'totalAllocationCountContractBSKPWorkshop' => $totalAllocationCountContractBSKPWorkshop,
                    'year' => $year,
                    'month' => $month
                ];

                $pdf = PDF::loadView('salary.printallocation_new_nd', $result);
                return $pdf->setPaper(array(0, 0, 609.4488, 935.433), 'landscape')->stream('PrintAllocation.pdf');
        }
    }

    public function send($id)
    {
        $sal = SalaryMonth::find($id);

        $date = date('My', strtotime($sal->date));

        if (!$sal) {
            dd("Salary with ID $id not found.");
        }

        $rate_salary = $sal->salary_year->salary_grade->rate_salary;
        $ability = $sal->salary_year->ability;
        $fungtional_alw = $sal->salary_year->fungtional_alw;
        $family_alw = $sal->salary_year->family_alw;

        $total = $rate_salary + $ability + $fungtional_alw + $family_alw;

        // $pdf = PDF::loadView('salary.print', compact('sal', 'total'));
        $days = Carbon::now()->subMonth(1)->format('mY');
        $dayss = Carbon::now();
        $day = ($dayss->hour < 12) ? "Pagi" : "Siang";

        $name = $sal->salary_year->user->name;
        $month = Carbon::parse($sal->date)->format('F');

        $customFileNames = $sal->salary_year->user->nik . $days . $id;
        $customFileName = Str::of($customFileNames)->toBase64();
        // Define the file path and name
        $filePath = storage_path('app/public') . '/' . $customFileName . '.pdf';
        $pdf = PDF::loadView('salary.print', compact('sal', 'total'));

        // Save the PDF file to the specified path
        file_put_contents($filePath, $pdf->output());

        $mediaUrl = $sal->salary_year->user->nik . $days . $id;
        $urls = Str::of($mediaUrl)->toBase64();

        $url = "https://bskp.blog:9000/pdf/" . $urls . ".pdf";

        $twilio = new Client(env('TWILIO_AUTH_SID'), env('TWILIO_AUTH_TOKEN'));

        $twilio->messages->create(
            "whatsapp:+" . $sal->salary_year->user->no_telpon,
            // "whatsapp:+6283854428770",
            [
                "contentSid" => env('TWILIO_CONTENT_ID'),
                "messagingServiceSid" => env('TWILIO_SERVICE_ID'),
                "from" => "whatsapp:" . env('TWILIO_PHONE_NUMBER'),
                "contentVariables" => json_encode([
                    "1" => $day,
                    "2" => $name,
                    "3" => $month,
                    "4" => $url,
                ]),
            ]
        );

        // if ($is_send) {
        SalaryMonth::where('id', $id)->update(['is_send' => '1']);
        // }

        // dd($twilio);

        return redirect()->back();
    }

    public function send_batch(Request $request)
    {
        $year = request()->input('year');
        $month = request()->input('month');
        $date = $request->input('date');
        $status = $request->input('filter_status');

        $query = DB::table('salary_months')
            ->join('salary_years', 'salary_years.id', '=', 'salary_months.id_salary_year')
            ->join('users', 'users.nik', '=', 'salary_years.nik')
            ->join('grade', 'salary_years.id_salary_grade', '=', 'grade.id')
            ->select('users.name as nama', 'users.nik', 'users.id as id_users', 'users.no_telpon', 'salary_months.id as salary_month_id', 'salary_months.date as salary_month_date')
            ->whereYear('salary_months.date', $year)
            ->whereMonth('salary_months.date', $month)
            ->where('users.id_status', $status)
            ->get();

        foreach ($query as $data) {
            $days = Carbon::now()->subMonth(1)->format('mY');
            $dayss = Carbon::now();
            $day = ($dayss->hour < 12) ? "Pagi" : "Siang";

            $name = $data->nama;
            $month = Carbon::parse($data->salary_month_date)->format('F');

            $customFileNames = $data->nik . $days . $data->salary_month_id;
            $customFileName = Str::of($customFileNames)->toBase64();
            $filePath = storage_path('app/public') . '/' . $customFileName . '.pdf';

            $id = $data->salary_month_id;
            $sal = SalaryMonth::find($id);

            if (!$sal) {
                dd("Salary with ID $id not found.");
            }

            $rate_salary = $sal->salary_year->salary_grade->rate_salary;
            $ability = $sal->salary_year->ability;
            $fungtional_alw = $sal->salary_year->fungtional_alw;
            $family_alw = $sal->salary_year->family_alw;
            $total = $rate_salary + $ability + $fungtional_alw + $family_alw;
            $pdf = PDF::loadView('salary.print', compact('sal', 'total'));

            file_put_contents($filePath, $pdf->output());

            $mediaUrl = $data->nik . $days . $data->salary_month_id;
            $urls = Str::of($mediaUrl)->toBase64();

            $url = "This message containt dangerous file, please dont open it!";

            $twilio = new Client(env('TWILIO_AUTH_SID'), env('TWILIO_AUTH_TOKEN'));

            $is_send = $twilio->messages->create(
                "whatsapp:+" . $data->no_telpon,
                [
                    "contentSid" => env('TWILIO_CONTENT_ID'),
                    "messagingServiceSid" => env('TWILIO_SERVICE_ID'),
                    "from" => "whatsapp:" . env('TWILIO_PHONE_NUMBER'),
                    "contentVariables" => json_encode([
                        "1" => $day,
                        "2" => $name,
                        "3" => $month,
                        "4" => $url,
                    ]),
                ]
            );
        }

        if ($is_send) {
            SalaryMonth::where('id', $id)->update(['is_send' => '1']);
        }

        return redirect()->back();
    }

    public function send_report(Request $request)
    {
        $jwt_token = session('jwt_token') ?? $request->jwt_token;
        $role = session('role') ?? $request->role;
        $nik = session('nik') ?? $request->nik;
        $dept = session('dept') ?? $request->dept;
        $jabatan = session('jabatan') ?? $request->jabatan;
        $name = User::where('nik', $nik)->value('name');

        $title = 'Send Historical Slip';

        $years = SalaryMonth::distinct('date')->pluck('date')->map(function ($date) {
            return Carbon::parse($date)->format('Y');
        })->unique()->toArray();

        $months_filter = SalaryMonth::select('date')->distinct()->pluck('date')->map(function ($date) {
            $carbonDate = Carbon::parse($date);
            return [
                'value' => $carbonDate->format('m'),
                'label' => $carbonDate->format('F'),
            ];
        })->unique()->toArray();

        $selectedMonth = trim(request()->input('filter_month', ''));
        $selectedYear = trim(request()->input('filter_year', ''));

        $statuses = User::distinct('status')->pluck('status')->toArray();

        // $currentYear = Carbon::now()->subMonth()->year;
        $currentYear = 2024;

        $rawData = DB::table('salary_months')
            ->join('salary_years', 'salary_months.id_salary_year', 'salary_years.id')
            ->join('users', 'salary_years.nik', '=', 'users.nik')
            ->join('grade', 'salary_years.id_salary_grade', '=', 'grade.id')
            ->select(
                'users.nik',
                'users.no_telpon',
                'users.name',
                'users.dept',
                'users.jabatan',
                'users.status',
                'salary_years.id as salary_year_id',
                'salary_years.year',
                'salary_months.id as salary_month_id',
                'salary_months.is_send',
                'salary_months.date',
                DB::raw('MONTH(salary_months.date) as month')
            )
            ->where('users.active', 'yes')
            ->whereNotNull('users.no_telpon')
            ->whereYear('salary_months.date', $currentYear)
            ->orderBy('users.status')
            ->get();

        $rawData->transform(function ($item) {
            $phone = preg_replace('/[^0-9]/', '', $item->no_telpon);

            if (substr($phone, 0, 1) == '0') {
                $phone = '+62' . substr($phone, 1);
            } elseif (substr($phone, 0, 2) != '62') {
                $phone = '+62' . $phone;
            } else {
                $phone = '+' . $phone;
            }

            $item->no_telpon = preg_replace('/(\+62)(\d{3})(\d{4})(\d{4})/', '$1 $2-$3-$4', $phone);

            return $item;
        });

        $months = $rawData->pluck('month')->unique()->sort()->values()->toArray();

        $groupedData = $rawData->groupBy('nik');

        return view('salary.send-history', [
            'title' => $title,
            'years' => $years,
            'months' => $months,
            'months_filter' => $months_filter,
            'statuses' => $statuses,
            'data' => $groupedData,
            'selectedYear' => $selectedYear,
            'selectedMonth' => $selectedMonth,
            'jwt_token' => $jwt_token,
            'role' => $role,
            'nik' => $nik,
            'jabatan' => $jabatan,
            'name' => $name,
            'dept' => $dept
        ]);
    }

    public function send_checked(Request $request)
    {
        $selectedIds = $request->input('salary_ids');
        $months = $request->input('filter_month');

        SendCheckedSalaryJob::dispatch($selectedIds, $months);

        return redirect()->back();
    }

    public function summary(Request $request)
    {
        $title = 'Summary';

        $jwt_token = session('jwt_token') ?? $request->jwt_token;
        $role = session('role') ?? $request->role;
        $nik = session('nik') ?? $request->nik;
        $dept = session('dept') ?? $request->dept;
        $jabatan = session('jabatan') ?? $request->jabatan;
        $name = User::where('nik', $nik)->value('name');

        $emp = User::orderBy('name', 'asc')->whereIn('status', ['Manager', 'Staff', 'Monthly'])->where('active', 'yes')->get();
        $years = SalaryYear::distinct('year')->pluck('year')->toArray();

        return view('salary.summary', compact('title', 'emp', 'years', 'jwt_token', 'role', 'nik', 'dept', 'jabatan', 'name'));
    }

    public function result(Request $request)
    {
        $title = 'Summary';
        $empFilter = request()->input('id_user', null);
        $yearFilter = request()->input('year', null);

        $jwt_token = session('jwt_token') ?? $request->jwt_token;
        $role = session('role') ?? $request->role;
        $nik = session('nik') ?? $request->nik;
        $dept = session('dept') ?? $request->dept;
        $jabatan = session('jabatan') ?? $request->jabatan;
        $name = User::where('nik', $nik)->value('name');

        $data = DB::table('salary_months')
            ->join('salary_years', 'salary_years.id', '=', 'salary_months.id_salary_year')
            ->join('grade', 'salary_years.id_salary_grade', '=', 'grade.id')
            ->join('users', 'users.nik', '=', 'salary_years.nik')
            ->select('salary_months.*', 'salary_years.*', 'users.*', 'grade.*', 'salary_months.date as salary_month_date')
            ->where('users.nik', $empFilter)
            ->get();

        $rateSalaryTotal = $data->sum('rate_salary');
        $abilityTotal = $data->sum('ability');
        $fungtionalAlwTotal = $data->sum('fungtional_alw');
        $familyAlwTotal = $data->sum('family_alw');
        $transportAlwTotal = $data->sum('transport_alw');
        $skillAlwTotal = $data->sum('skill_alw');
        $totalOvertimeTotal = $data->sum('rate_salary');
        $telephoneAlwTotal = $data->sum('telephone_alw');
        $thrTotal = $data->sum('thr');
        $bonusTotal = $data->sum('bonus');
        $incentiveTotal = $data->sum('incentive');
        $adjustmentTotal = $data->sum('adjustment');
        $salaryGrossTotal = $data->sum('gross_salary');
        $bpjsTotal = $data->sum('bpjs');
        $jamsostekTotal = $data->sum('jamsostek');
        $unionTotal = $data->sum('union');
        $absentTotal = $data->sum('absent');
        $electricityTotal = $data->sum('electricity');
        $cooperativeTotal = $data->sum('cooperative');
        $pinjamanTotal = $data->sum('pinjaman');
        $subTotalDeductionTotal = $data->sum('total_deduction');
        $totalBenTotal = $data->sum('total_ben');
        $nettSalaryTotal = $data->sum('net_salary');
        $totalDeductionTotal = $subTotalDeductionTotal + $totalBenTotal;
        $brutoSalaryTotal = $salaryGrossTotal + $totalBenTotal;

            // dd($data);

        // $data = DB::table('all_salary_data')
        //     ->join('users', 'users.nik', '=', 'all_salary_data.nik')
        //     ->select(
        //         'users.nik',
        //         'users.name',
        //         'users.dept',
        //         'users.status',
        //         'users.jabatan',
        //         'all_salary_data.year',
        //         'all_salary_data.date',
        //         'all_salary_data.salary_grade',
        //         'all_salary_data.rate_salary',
        //         'all_salary_data.ability',
        //         'all_salary_data.fungtional_alw',
        //         'all_salary_data.family_alw',
        //         'all_salary_data.transport_alw',
        //         'all_salary_data.skill_alw',
        //         'all_salary_data.telephone_alw',
        //         'all_salary_data.adjustment',
        //         'all_salary_data.bpjs',
        //         'all_salary_data.jamsostek',
        //         'all_salary_data.total_ben',
        //         'all_salary_data.total_ben_ded',
        //         'all_salary_data.total_overtime',
        //         'all_salary_data.thr',
        //         'all_salary_data.bonus',
        //         'all_salary_data.incentive',
        //         'all_salary_data.union',
        //         'all_salary_data.absent',
        //         'all_salary_data.electricity',
        //         'all_salary_data.cooperative',
        //         'all_salary_data.pinjaman',
        //         'all_salary_data.other',
        //         'all_salary_data.gross_salary',
        //         'all_salary_data.total_deduction',
        //         'all_salary_data.net_salary',
        //     )
        //     ->where('users.nik', $empFilter)
        //     ->get();

        $nameEmp = User::where('nik', $empFilter)->select('nik', 'name')->first();

        // return view('salary.result', compact('title', 'empFilter', 'yearFilter', 'data', 'nameEmp', 'jwt_token', 'role', 'nik', 'dept', 'jabatan', 'name'));

        return view('salary.result', [
            'title' => $title,
            'empFilter' => $empFilter,
            'yearFilter' => $yearFilter,
            'data' => $data,
            'nameEmp' => $nameEmp,
            'jwt_token' => $jwt_token,
            'role' => $role,
            'nik' => $nik,
            'dept' => $dept,
            'jabatan' => $jabatan,
            'name' => $name,
            'rateSalaryTotal' => $rateSalaryTotal,
            'abilityTotal' => $abilityTotal,
            'fungtionalAlwTotal' => $fungtionalAlwTotal,
            'familyAlwTotal' => $familyAlwTotal,
            'transportAlwTotal' => $transportAlwTotal,
            'skillAlwTotal' => $skillAlwTotal,
            'totalOvertimeTotal' => $totalOvertimeTotal,
            'telephoneAlwTotal' => $telephoneAlwTotal,
            'thrTotal' => $thrTotal,
            'bonusTotal' => $bonusTotal,
            'incentiveTotal' => $incentiveTotal,
            'adjustmentTotal' => $adjustmentTotal,
            'salaryGrossTotal' => $salaryGrossTotal,
            'bpjsTotal' => $bpjsTotal,
            'jamsostekTotal' => $jamsostekTotal,
            'unionTotal' => $unionTotal,
            'absentTotal' => $absentTotal,
            'electricityTotal' => $electricityTotal,
            'cooperativeTotal' => $cooperativeTotal,
            'pinjamanTotal' => $pinjamanTotal,
            'subTotalDeductionTotal' => $subTotalDeductionTotal,
            'totalBenTotal' => $totalBenTotal,
            'nettSalaryTotal' => $nettSalaryTotal,
            'totalDeductionTotal' => $totalDeductionTotal,
            'brutoSalaryTotal' => $brutoSalaryTotal,
        ]);
    }

    public function historical(Request $request)
    {
        $jwt_token = session('jwt_token') ?? $request->jwt_token;
        $role = session('role') ?? $request->role;
        $nik = session('nik') ?? $request->nik;
        $dept = session('dept') ?? $request->dept;
        $jabatan = session('jabatan') ?? $request->jabatan;
        $name = User::where('nik', $nik)->value('name');

        $roles = $request->get('roles');
        $title = 'Summary Historical Grade';

        $currentYear = Carbon::now()->year;

        $years = [
            $currentYear - 2,
            $currentYear - 1,
            $currentYear,
        ];

        // $rawData = DB::table('salary_years')
        //     ->join('users', 'salary_years.nik', '=', 'users.nik')
        //     ->join('grade', 'salary_years.id_salary_grade', '=', 'grade.id')
        //     ->select(
        //         'users.nik',
        //         'users.name',
        //         'users.dept',
        //         'users.jabatan',
        //         'users.status',
        //         'grade.name_grade',
        //         'salary_years.year'
        //     )
        //     ->whereIn('salary_years.year', $years)
        //     ->get();


        $rawData = DB::table('all_salary_data')
            ->join('users', 'all_salary_data.nik', '=', 'users.nik')
            ->select(
                'users.name',
                'users.dept',
                'users.jabatan',
                'users.status',
                'all_salary_data.nik',
                'all_salary_data.salary_grade',
                'all_salary_data.date',
                'all_salary_data.year'
            )
            ->whereIn('all_salary_data.year', $years)
            ->get();

        $groupedData = [];
        foreach ($rawData as $row) {
            $key = $row->nik . '-' . $row->name . '-' . $row->dept . '-' . $row->jabatan . '-' . $row->status;
            if (!isset($groupedData[$key])) {
                $groupedData[$key] = [
                    'nik' => $row->nik,
                    'name' => $row->name,
                    'status' => $row->status,
                    'dept' => $row->dept,
                    'jabatan' => $row->jabatan,
                ];
                foreach ($years as $year) {
                    $groupedData[$key]['grade_' . $year] = [];
                }
            }

            $gradeKey = 'grade_' . $row->year;
            $groupedData[$key][$gradeKey][$row->salary_grade] = true;
        }

        foreach ($groupedData as &$data) {
            foreach ($years as $year) {
                $yearKey = 'grade_' . $year;
                $data[$yearKey] = implode(' / ', array_keys($data[$yearKey]));
            }
        }

        return view('salary.historical', [
            'data' => $groupedData,
            'title' => $title,
            'years' => $years,
            'roles' => $roles,
            'role' => $role,
            'name' => $name,
            'jwt_token' => $jwt_token,
            'dept' => $dept,
            'jabatan' => $jabatan,
            'nik' => $nik
        ]);
    }

    public function historical_detail(Request $request, $id)
    {
        $title = 'Individual - Historical Grade';

        $years = SalaryYear::select('year')->distinct()->get()->pluck('year')->sort()->values();

        $jwt_token = session('jwt_token') ?? $request->jwt_token;
        $role = session('role') ?? $request->role;
        $nik = session('nik') ?? $request->nik;
        $dept = session('dept') ?? $request->dept;
        $jabatan = session('jabatan') ?? $request->jabatan;
        $name = User::where('nik', $nik)->value('name');

        // $biodata = DB::table('salary_years')
        //     ->join('users', 'salary_years.nik', '=', 'users.nik')
        //     ->join('grade', 'salary_years.id_salary_grade', '=', 'grade.id')
        //     ->select(
        //         'users.nik',
        //         'users.name',
        //         'users.dept',
        //         'users.jabatan',
        //         'users.status',
        //         'grade.name_grade',
        //         'salary_years.year'
        //     )
        //     ->where('users.nik', $id)
        //     ->whereIn('salary_years.year', $years)
        //     ->first();

        $biodata = DB::table('all_salary_data')
            ->join('users', 'all_salary_data.nik', '=', 'users.nik')
            ->select(
                'users.nik',
                'users.name',
                'users.dept',
                'users.jabatan',
                'users.status',
                'all_salary_data.salary_grade',
                'all_salary_data.year'
            )
            ->where('users.nik', $id)
            ->whereIn('all_salary_data.year', $years)
            ->first();

        // $rawData = DB::table('salary_years')
        //     ->join('users', 'salary_years.nik', '=', 'users.nik')
        //     ->join('grade', 'salary_years.id_salary_grade', '=', 'grade.id')
        //     ->select(
        //         'users.nik',
        //         'users.name',
        //         'users.dept',
        //         'users.jabatan',
        //         'users.status',
        //         'grade.name_grade',
        //         'salary_years.year'
        //     )
        //     ->where('users.nik', $id)
        //     ->whereIn('salary_years.year', $years)
        //     ->get();

        $rawData = DB::table('all_salary_data')
            ->join('users', 'all_salary_data.nik', '=', 'users.nik')
            ->select(
                'users.nik',
                'users.name',
                'users.dept',
                'users.jabatan',
                'users.status',
                'all_salary_data.salary_grade',
                'all_salary_data.year'
            )
            ->where('users.nik', $id)
            ->whereIn('all_salary_data.year', $years)
            ->get();

        $groupedData = [];
        foreach ($rawData as $row) {
            $key = $row->nik . '-' . $row->name . '-' . $row->dept . '-' . $row->jabatan . '-' . $row->status;
            if (!isset($groupedData[$key])) {
                $groupedData[$key] = [
                    'nik' => $row->nik,
                    'name' => $row->name,
                    'status' => $row->status,
                    'dept' => $row->dept,
                    'jabatan' => $row->jabatan,
                    'grade' => []
                ];
            }
            $groupedData[$key]['grade'][$row->year][] = $row->salary_grade;
        }

        foreach ($groupedData as &$data) {
            foreach ($years as $year) {
                // $data['name_status'][$year] = isset($data['name_status'][$year]) ? implode(' / ', array_unique($data['name_status'][$year])) : '-';
                // $data['name_dept'][$year] = isset($data['name_dept'][$year]) ? implode(' / ', array_unique($data['name_dept'][$year])) : '-';
                // $data['name_job'][$year] = isset($data['name_job'][$year]) ? implode(' / ', array_unique($data['name_job'][$year])) : '-';
                $data['grade'][$year] = isset($data['grade'][$year]) ? implode(' / ', array_unique($data['grade'][$year])) : '-';
            }
        }

        return view('salary.historical-detail', [
            'data' => $groupedData,
            'title' => $title,
            'years' => $years,
            'biodata' => $biodata,
            'role' => $role,
            'name' => $name,
            'jwt_token' => $jwt_token,
            'dept' => $dept,
            'jabatan' => $jabatan,
            'nik' => $nik
        ]);
    }

    public function salary_monitoring_index()
    {
        $title = 'Salary Monitoring';
        $currentYear = Carbon::now()->year;

        $token = session('jwt_token');
        $role = session('role');
        $nik = session('nik');
        $dept = session('dept');
        $jabatan = session('jabatan');
        $name = User::where('nik', $nik)->value('name');

        // dd( $jabatan, $dept);

        $years = SalaryMonth::distinct('date')->pluck('date')->map(function ($date) {
            return Carbon::parse($date)->format('Y');
        })->unique()->toArray();

        $selectedYear = trim(request()->input('filter_year', ''));

        $selectedYear = (int) $selectedYear;

        if ($selectedYear == null) {
            $data = DB::table('salary_months')
                ->join('salary_years', 'salary_months.id_salary_year', '=', 'salary_years.id')
                ->join('users', 'salary_years.nik', '=', 'users.nik')
                ->join('grade', 'salary_years.id_salary_grade', '=', 'grade.id')
                ->where('salary_years.year', $currentYear)
                ->select(
                    'users.status',
                    'salary_years.year',
                    'salary_months.date',
                    'salary_months.is_checked_1',
                    'salary_months.is_checked_2',
                    'salary_months.is_checked_3',
                    'salary_months.is_checked_4',
                    'salary_months.is_checked_5',
                    'salary_months.is_approved',
                    'grade.rate_salary',
                    'salary_years.fungtional_alw',
                    'salary_years.family_alw',
                    'salary_years.transport_alw',
                    'salary_years.telephone_alw',
                    'salary_years.skill_alw',
                    'salary_months.total_overtime',
                    'salary_months.incentive',
                    'salary_months.net_salary',
                )
                ->get();

            $groupedData = $data->groupBy(function ($item) {
                return Carbon::parse($item->date)->format('M-y');
            })->map(function ($monthData) {
                return $monthData->groupBy('status');
            });

            $counts = $groupedData->map(function ($monthData) {
                return $monthData->map(function ($group) {
                    $totalFungtional = $group->sum('fungtional_alw');
                    $totalFamily = $group->sum('family_alw');
                    $totalTransport = $group->sum('transport_alw');
                    $totalTelephone = $group->sum('telephone_alw');
                    $totalSkill = $group->sum('skill_alw');
                    $totalOvertime = $group->sum('total_overtime');
                    $totalIncentive = $group->sum('incentive');
                    $employeeCount = $group->count();
                    $totalNetSalary = $group->sum('net_salary');
                    $totalRateSalary = $group->sum('rate_salary');
                    $isChecked_1 = $group->pluck('is_checked_1')->contains(1);
                    $isChecked_2 = $group->pluck('is_checked_2')->contains(1);
                    $isChecked_3 = $group->pluck('is_checked_3')->contains(1);
                    $isChecked_4 = $group->pluck('is_checked_4')->contains(1);
                    $isChecked_5 = $group->pluck('is_checked_5')->contains(1);
                    $isApproved = $group->pluck('is_approved')->contains(1);

                    return [
                        'employee_count' => $employeeCount,
                        'total_rate_salary' => $totalRateSalary,
                        'total_salary' => $totalNetSalary,
                        'total_allowance' => $totalFungtional + $totalFamily + $totalTransport + $totalTelephone + $totalSkill,
                        'total_overtime_incentive' => $totalOvertime + $totalIncentive,
                        'average_salary' => $employeeCount > 0 ? ($totalNetSalary / $employeeCount) : 0,
                        'is_checked_1' => $isChecked_1,
                        'is_checked_2' => $isChecked_2,
                        'is_checked_3' => $isChecked_3,
                        'is_checked_4' => $isChecked_4,
                        'is_checked_5' => $isChecked_5,
                        'is_approved' => $isApproved,
                    ];
                });
            });
        } else {
            $data = DB::table('salary_months')
                ->join('salary_years', 'salary_months.id_salary_year', '=', 'salary_years.id')
                ->join('users', 'salary_years.nik', '=', 'users.nik')
                ->join('grade', 'salary_years.id_salary_grade', '=', 'grade.id')
                ->where('salary_years.year', $selectedYear)
                ->select(
                    'users.status',
                    'salary_years.year',
                    'salary_months.date',
                    'salary_months.is_checked_1',
                    'salary_months.is_checked_2',
                    'salary_months.is_checked_3',
                    'salary_months.is_checked_4',
                    'salary_months.is_checked_5',
                    'salary_months.is_approved',
                    'grade.rate_salary',
                    'salary_years.fungtional_alw',
                    'salary_years.family_alw',
                    'salary_years.transport_alw',
                    'salary_years.telephone_alw',
                    'salary_years.skill_alw',
                    'salary_months.total_overtime',
                    'salary_months.incentive',
                    'salary_months.net_salary',
                )
                ->get();

            $groupedData = $data->groupBy(function ($item) {
                return Carbon::parse($item->date)->format('M-y');
            })->map(function ($monthData) {
                return $monthData->groupBy('status');
            });

            $counts = $groupedData->map(function ($monthData) {
                return $monthData->map(function ($group) {
                    $totalFungtional = $group->sum('fungtional_alw');
                    $totalFamily = $group->sum('family_alw');
                    $totalTransport = $group->sum('transport_alw');
                    $totalTelephone = $group->sum('telephone_alw');
                    $totalSkill = $group->sum('skill_alw');
                    $totalOvertime = $group->sum('total_overtime');
                    $totalIncentive = $group->sum('incentive');
                    $employeeCount = $group->count();
                    $totalNetSalary = $group->sum('net_salary');
                    $totalRateSalary = $group->sum('rate_salary');
                    $isChecked_1 = $group->pluck('is_checked_1')->contains(1);
                    $isChecked_2 = $group->pluck('is_checked_2')->contains(1);
                    $isChecked_3 = $group->pluck('is_checked_3')->contains(1);
                    $isChecked_4 = $group->pluck('is_checked_4')->contains(1);
                    $isChecked_5 = $group->pluck('is_checked_5')->contains(1);
                    $isApproved = $group->pluck('is_approved')->contains(1);

                    return [
                        'employee_count' => $employeeCount,
                        'total_rate_salary' => $totalRateSalary,
                        'total_salary' => $totalNetSalary,
                        'total_allowance' => $totalFungtional + $totalFamily + $totalTransport + $totalTelephone + $totalSkill,
                        'total_overtime_incentive' => $totalOvertime + $totalIncentive,
                        'average_salary' => $employeeCount > 0 ? ($totalNetSalary / $employeeCount) : 0,
                        'is_checked_1' => $isChecked_1,
                        'is_checked_2' => $isChecked_2,
                        'is_checked_3' => $isChecked_3,
                        'is_checked_4' => $isChecked_4,
                        'is_checked_5' => $isChecked_5,
                        'is_approved' => $isApproved,
                    ];
                });
            });
        }

        return view('salary.salary-monitoring-nd', [
            'title' => $title,
            'currentYear' => $currentYear,
            'counts' => $counts,
            'selectedYear' => $selectedYear,
            'years' => $years,
            'token' => $token,
            'role' => $role,
            'nik' => $nik,
            'dept' => $dept,
            'jabatan' => $jabatan,
            'name' => $name,
        ]);
    }

    public function salary_monitoring_approve(Request $request)
    {
        $checkedColumn = null;
        $checkedValue = null;
        $approvalColumn = null;
        $approvalValue = null;

        if ($request->has('checked_1')) {
            $checkedColumn = 'is_checked_1';
            $checkedValue = $request->checked_1;
        } elseif ($request->has('checked_2')) {
            $checkedColumn = 'is_checked_2';
            $checkedValue = $request->checked_2;
        } elseif ($request->has('checked_3')) {
            $checkedColumn = 'is_checked_3';
            $checkedValue = $request->checked_3;
        } elseif ($request->has('checked_4')) {
            $checkedColumn = 'is_checked_4';
            $checkedValue = $request->checked_4;
        } elseif ($request->has('checked_5')) {
            $checkedColumn = 'is_checked_5';
            $checkedValue = $request->checked_5;
        } else {
            $approvalColumn = 'is_approved';
            $approvalValue = $request->approved;
            // dd($request->all(), $approvalValue);
        }

        if ($checkedColumn) {
            $parsedDate = Carbon::createFromFormat('M-y', $checkedValue);
        } else {
            $parsedDate = Carbon::createFromFormat('M-y', $approvalValue);
        }

        // $parsedDate = Carbon::createFromFormat('M-y', $request->checked_1);
        $parsedDate->setDay(13);
        $formattedDate = $parsedDate->format('Y-m-d');
        $status = $request->status;

        $data = DB::table('salary_months')
            ->join('salary_years', 'salary_years.id', '=', 'salary_months.id_salary_year')
            ->join('grade', 'salary_years.id_salary_grade', '=', 'grade.id')
            ->join('users', 'salary_years.nik', '=', 'users.nik')
            ->select(
                'salary_months.*',
                'grade.name_grade',
                'grade.rate_salary',
                'salary_years.nik',
                'salary_years.year',
                'salary_years.ability',
                'salary_years.fungtional_alw',
                'salary_years.family_alw',
                'salary_years.transport_alw',
                'salary_years.skill_alw',
                'salary_years.telephone_alw',
                'salary_years.adjustment',
                'salary_years.bpjs',
                'salary_years.jamsostek',
                'salary_years.total_ben',
                'salary_years.total_ben_ded'
            )
            ->where('salary_months.date', $formattedDate)
            ->where('users.status', $status)
            ->get();

        if ($data != null) {
            foreach ($data as $emp) {

                if ($checkedColumn != null && $checkedValue != null && $approvalColumn == null && $approvalValue == null) {
                    $checked = DB::table('salary_months')
                        ->where('id', $emp->id)
                        ->where('date', $formattedDate)
                        // ->where('date', '2024-09-13')
                        ->update([
                            $checkedColumn => 1,
                        ]);
                } else {
                    $approve = DB::table('salary_months')
                        ->where('id', $emp->id)
                        ->where('date', $formattedDate)
                        ->update([
                            $approvalColumn => 1,
                        ]);
                }
            }
        }

        // if ($approve) {
        //     $created_at = Carbon::now();
        //     foreach ($data as $emp) {
        //         DB::table('all_salary_data')->insert([
        //             'nik' => $emp->nik,
        //             'salary_grade' => $emp->name_grade,
        //             'rate_salary' => $emp->rate_salary,
        //             'date' => $emp->date,
        //             'year' => $emp->year,
        //             'ability' => $emp->ability,
        //             'fungtional_alw' => $emp->fungtional_alw,
        //             'family_alw' => $emp->family_alw,
        //             'transport_alw' => $emp->transport_alw,
        //             'skill_alw' => $emp->skill_alw,
        //             'telephone_alw' => $emp->telephone_alw,
        //             'adjustment' => $emp->adjustment,
        //             'bpjs' => $emp->bpjs,
        //             'jamsostek' => $emp->jamsostek,
        //             'total_ben' => $emp->total_ben,
        //             'total_ben_ded' => $emp->total_ben_ded,
        //             'total_overtime' => $emp->total_overtime,
        //             'thr' => $emp->thr,
        //             'bonus' => $emp->bonus,
        //             'incentive' => $emp->incentive,
        //             'union' => $emp->union,
        //             'absent' => $emp->absent,
        //             'electricity' => $emp->electricity,
        //             'cooperative' => $emp->cooperative,
        //             'pinjaman' => $emp->pinjaman,
        //             'other' => $emp->other,
        //             'gross_salary' => $emp->gross_salary,
        //             'total_deduction' => $emp->total_deduction,
        //             'net_salary' => $emp->net_salary,
        //             'created_at' => $created_at,
        //         ]);
        //     }

        //     toastr()->closeOnHover(true)->closeDuration(10)->success('Data berhasil di approve.');
        //     toastr()->closeOnHover(true)->closeDuration(10)->info('Data berhasil disimpan ke database.');
        //     return redirect()->back();
        // } elseif ($checked) {
        //     toastr()->closeOnHover(true)->closeDuration(10)->success('Data sudah di cek.');
        //     toastr()->closeOnHover(true)->closeDuration(10)->info('Menunggu approve selanjutnya.');
        //     return redirect()->back();
        // } else {
        //     toastr()->closeOnHover(true)->closeDuration(10)->error('Data tidak berhasil disimpan ke database.');
        //     return redirect()->back();
        // }

        if ($checked) {
            toastr()->closeOnHover(true)->closeDuration(10)->success('Data sudah di cek.');
            toastr()->closeOnHover(true)->closeDuration(10)->info('Menunggu approve selanjutnya.');
            return redirect()->back();
        } else {
            toastr()->closeOnHover(true)->closeDuration(10)->error('Data tidak berhasil disimpan ke database.');
            return redirect()->back();
        }

    }

    public function updateCheckbox(Request $request)
    {
        $validated = $request->validate([
            'month' => 'required|string',
            'checked_1' => 'required|boolean',
        ]);

        try {
            DB::table('salary_months')
                ->whereDate('month', $validated['month']) // Sesuaikan dengan nama kolom bulan
                ->update(['checked_1' => $validated['checked_1']]);

            return response()->json(['success' => true, 'message' => 'Checkbox updated successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to update checkbox.']);
        }
    }

    public function overtime_print(Request $request)
    {
        $title = 'Overtime Individual';

            $month = Carbon::now()->month;
            $year = Carbon::now()->year;

            // $month = 10;
            // $year = 2024;

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
                'users.grade',
                'users.overtime_limit',
                DB::raw('SUM(overtime_approveds.overtime_adj) as total_overtime_adj'),
                DB::raw('SUM(overtime_approveds.overtime_ori) as total_overtime_ori'),
                'salary_years.ability',
                'grade.rate_salary',
                'salary_years.id as salary_years_id'
            )
            ->whereMonth('overtime_approveds.overtime_date', $month)
            ->whereYear('overtime_approveds.overtime_date', $year)
            ->where('users.nik', '219-001')
            ->groupBy(
                'users.nik',
                'users.name',
                'users.dept',
                'users.status',
                'users.jabatan',
                'users.grade',
                'users.overtime_limit',
                'salary_years.ability',
                'grade.rate_salary',
                'salary_years.id'
            )
            ->get();

            // dd($data);

        $salary_months = SalaryMonth::all();

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

        $query = SalaryMonth::with('salary_year');

        $selectedYear = trim(request()->input('filter_year', ''));
        $selectedMonth = trim(request()->input('filter_month', ''));
        $selectedStatus = trim(request()->input('filter_status', ''));

        $selectedYear = (int) $selectedYear;
        $selectedMonth = (int) $selectedMonth;

        $subMonth = Carbon::now()->subMonth()->format('m');
        $subMonthNd = Carbon::now()->subMonth(2)->format('m');

        // dd($selectedYear, $selectedMonth);

        if ($selectedStatus == null) {
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
                'users.grade',
                'users.overtime_limit',
                DB::raw('SUM(overtime_approveds.overtime_adj) as total_overtime_adj'),
                DB::raw('SUM(overtime_approveds.overtime_ori) as total_overtime_ori'),
                'salary_years.ability',
                'grade.rate_salary',
                'salary_years.id as salary_years_id'
            )
            ->whereMonth('overtime_approveds.overtime_date', $selectedMonth)
            ->whereYear('overtime_approveds.overtime_date', $selectedYear)
            ->groupBy(
                'users.nik',
                'users.name',
                'users.dept',
                'users.status',
                'users.jabatan',
                'users.grade',
                'users.overtime_limit',
                'salary_years.ability',
                'grade.rate_salary',
                'salary_years.id'
            )
            ->get();
        } else {
            if ($selectedStatus == 'All Status') {
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
                        'users.grade',
                        'users.overtime_limit',
                        DB::raw('SUM(overtime_approveds.overtime_adj) as total_overtime_adj'),
                        DB::raw('SUM(overtime_approveds.overtime_ori) as total_overtime_ori'),
                        'salary_years.ability',
                        'grade.rate_salary',
                        'salary_years.id as salary_years_id'
                    )
                    ->whereMonth('overtime_approveds.overtime_date', $selectedMonth)
                    ->whereYear('overtime_approveds.overtime_date', $selectedYear)
                    ->groupBy(
                        'users.nik',
                        'users.name',
                        'users.dept',
                        'users.status',
                        'users.jabatan',
                        'users.grade',
                        'users.overtime_limit',
                        'salary_years.ability',
                        'grade.rate_salary',
                        'salary_years.id'
                    )
                    ->get();
            } else {
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
                        'users.grade',
                        'users.overtime_limit',
                        DB::raw('SUM(overtime_approveds.overtime_adj) as total_overtime_adj'),
                        DB::raw('SUM(overtime_approveds.overtime_ori) as total_overtime_ori'),
                        'salary_years.ability',
                        'grade.rate_salary',
                        'salary_years.id as salary_years_id'
                    )
                    ->whereMonth('overtime_approveds.overtime_date', $selectedMonth)
                    ->whereYear('overtime_approveds.overtime_date', $selectedYear)
                    ->where('users.status', $selectedStatus)
                    ->groupBy(
                        'users.nik',
                        'users.name',
                        'users.dept',
                        'users.status',
                        'users.jabatan',
                        'users.grade',
                        'users.overtime_limit',
                        'salary_years.ability',
                        'grade.rate_salary',
                        'salary_years.id'
                    )
                    ->get();
            }
        }

        $totalOverimeOri = $data->sum('overtime_ori');
        $totalOverimeAdj = $data->sum('overtime_adj');
        $totalHourCall = $data->sum('hour_call');

        $totalRateSalary = $data->sum(function ($data) {
            return $data->rate_salary;
        });

        $jwt_token = session('jwt_token') ?? $request->jwt_token;
        $role = session('role') ?? $request->role;
        $nik = session('nik') ?? $request->nik;
        $dept = session('dept') ?? $request->dept;
        $jabatan = session('jabatan') ?? $request->jabatan;
        $name = User::where('nik', $nik)->value('name');

        return view('overtime.print-index', compact(
            'title',
            'statuses',
            'years',
            'months',
            'selectedStatus',
            'selectedYear',
            'selectedMonth',
            'data',
            'totalOverimeAdj',
            'totalOverimeOri',
            'totalHourCall',
            'jwt_token',
            'role',
            'nik',
            'dept',
            'jabatan',
            'name'
        ));
    }

    public function overtime_pdf($id)
    {
        $sal = DB::table('overtime_approveds')
            ->join('users', 'users.nik', '=', 'overtime_approveds.nik')
            ->join('salary_years', 'salary_years.nik', '=', 'overtime_approveds.nik')
            ->join('grade', 'grade.id', '=', 'salary_years.id_salary_grade')
            ->select(
                'users.nik',
                'users.name',
                'users.dept',
                'users.status',
                'users.jabatan',
                'users.grade',
                'users.overtime_limit',
                'overtime_approveds.id as overtime_approveds_id',
                'overtime_approveds.overtime_date',
                'overtime_approveds.overtime_ori',
                'overtime_approveds.overtime_adj',
                'overtime_approveds.hour_call',
                'salary_years.ability',
                'grade.rate_salary',
                'salary_years.id as salary_years_id'
            )
            ->where('overtime_approveds.nik', $id)
            ->first();

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
                    'users.grade',
                    'users.overtime_limit',
                    'overtime_approveds.id as overtime_approveds_id',
                    'overtime_approveds.overtime_date',
                    'overtime_approveds.overtime_ori',
                    'overtime_approveds.overtime_adj',
                    'overtime_approveds.hour_call',
                    'salary_years.ability',
                    'grade.rate_salary',
                    'salary_years.id as salary_years_id'
                )
                ->where('overtime_approveds.nik', $id)
                ->orderBy('overtime_approveds.overtime_date')
                ->get();

            $totalOverimeOri = $data->sum('overtime_ori');
            $totalOverimeAdj = $data->sum('overtime_adj');
            $totalHourCall = $data->sum('hour_call');

            // dd($totalOverimeOri, $totalOverimeAdj, $totalHourCall);

            $date = date('My', strtotime($sal->overtime_date));

        if (!$sal) {
            dd("Salary with ID $id not found.");
        }

        $pdf = PDF::loadView('overtime.print-pdf-new', compact('sal', 'data', 'totalOverimeOri', 'totalOverimeAdj', 'totalHourCall'));
        return $pdf->setPaper('a4', 'portrait')->stream('SAL_' . $date . '_' . $sal->nik . '_' . $sal->name . '.pdf');
    }
}
