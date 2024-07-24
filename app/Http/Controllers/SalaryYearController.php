<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\SalaryGrade;
use App\Models\Status;
use App\Models\User;
use App\Models\SalaryYear;
use App\Models\SalaryMonth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

class SalaryYearController extends Controller
{
    public function index()
    {
        $title = 'Salary Per Year';

        $years = SalaryYear::distinct('year')->pluck('year')->toArray();
        $statuses = Status::distinct('name_status')->pluck('name_status')->toArray();

        $query = SalaryYear::with('salary_grade');

        $selectedYear = null;
        $selectedStatus = null;

        if (request('filter_status') != null) {
            if (request('filter_status') != 'all') {
                $selectedStatus = request('filter_status');
                $query->whereHas('user.status', function ($subquery) use ($selectedStatus) {
                    $subquery->where('name_status', $selectedStatus);
                });
            }
        }

        if (request('filter_year') != null) {
            if (request('filter_year') != 'all') {
                $selectedYear = request('filter_year');
                $query->where('year', $selectedYear);
            }
        } else {
            $selectedYear = request('filter_year', Carbon::now()->year);
            $query->where('year', $selectedYear);
        }

        $salary_years = $query->get();

        $totalAbility = $salary_years->sum('ability');
        $totalFungtionalAlw = $salary_years->sum('fungtional_alw');
        $totalFamilyAlw = $salary_years->sum('family_alw');
        $totalTransportAlw = $salary_years->sum('transport_alw');
        $totalTelephoneAlw = $salary_years->sum('telephone_alw');
        $totalSkillAlw = $salary_years->sum('skill_alw');
        $totalAdjustment = $salary_years->sum('adjustment');
        $totalBpjs = $salary_years->sum('bpjs');
        $totalJamsostek = $salary_years->sum('jamsostek');

        // Menghitung total rate_salary
        $totalRateSalary = $salary_years->sum(function ($sy) {
            return $sy->salary_grade->rate_salary;
        });

        // dd($totalRateSalary);

        return view('salary_year.index', compact(
            'title', 'salary_years', 'years', 'statuses', 'selectedYear', 'selectedStatus', 'totalFamilyAlw', 'totalAbility', 'totalFungtionalAlw',
            'totalTransportAlw', 'totalTelephoneAlw', 'totalSkillAlw', 'totalAdjustment', 'totalBpjs', 'totalJamsostek', 'totalRateSalary'
        ));
    }

    public function filter(){
        $title = 'Salary Per Year';
        $statuses = Status::all();
        $currentYear = date('Y');
        // $currentYear = '2025';

        $allowedStatusNames = ['Assistant trainee', 'Manager', 'Monthly', 'Staff'];
        $selectedStatus = request()->input('id_status');

        $selectedStatusIds = $selectedStatus
            ? Status::whereIn('name_status', $allowedStatusNames)->where('id', $selectedStatus)->pluck('id')
            : Status::whereIn('name_status', $allowedStatusNames)->pluck('id');

        return view('salary_year.filter', compact('title', 'statuses', 'selectedStatus'));
    }

    public function filter_new() {
        $title = 'Salary Per Year';
        $statuses = Status::all();
        $currentYear = date('Y');
        // $currentYear = '2025';

        $allowedStatusNames = ['Assistant trainee', 'Manager', 'Monthly', 'Staff'];
        $selectedStatus = request()->input('id_status');

        $selectedStatusIds = $selectedStatus
            ? Status::whereIn('name_status', $allowedStatusNames)->where('id', $selectedStatus)->pluck('id')
            : Status::whereIn('name_status', $allowedStatusNames)->pluck('id');

        return view('salary_year.filter_new', compact('title', 'statuses', 'selectedStatus'));
    }

    public function create()
    {
        $title = 'Salary Per Year';
        $statuses = Status::all();
        $currentYear = date('Y');

        $checkYear = SalaryYear::where('year', $currentYear)->first();
        $allowedStatusNames = ['Assistant trainee', 'Manager', 'Monthly', 'Staff'];
        $selectedStatus = request()->input('id_status');

        $checkStatus = DB::table('salary_years')
            ->join('users', 'users.id', '=', 'salary_years.id_user')
            ->join('statuses', 'users.id_status', '=', 'statuses.id')
            ->where('users.id_status', $selectedStatus)
            ->first();

        if ($checkStatus != null) {
            if ($checkYear) {
                $users = DB::table('users')
                    ->join('statuses', 'users.id_status', '=', 'statuses.id')
                    ->join('depts', 'users.id_dept', '=', 'depts.id')
                    ->join('jobs', 'users.id_job', '=', 'jobs.id')
                    ->join('grades', 'users.id_grade', '=', 'grades.id')
                    ->join('salary_grades', 'grades.id', '=', 'salary_grades.id_grade')
                    ->join('salary_years', 'salary_years.id_user', '=', 'users.id')
                    ->where('users.id_status', $selectedStatus)
                    ->where('salary_years.year', $currentYear)
                    ->where(function ($query) {
                        $query->where('salary_years.ability', 0)
                            ->orWhere('salary_years.fungtional_alw', 0)
                            ->orWhere('salary_years.family_alw', 0)
                            ->orWhere('salary_years.transport_alw', 0)
                            ->orWhere('salary_years.telephone_alw', 0)
                            ->orWhere('salary_years.skill_alw', 0)
                            ->orWhere('salary_years.adjustment', 0)
                            ->orWhere('salary_years.bpjs', 0)
                            ->orWhere('salary_years.jamsostek', 0);
                    })
                    ->select('users.*', 'salary_grades.*', 'salary_years.*', 'grades.*', 'statuses.*', 'depts.*', 'jobs.*', 'salary_grades.id as id_salary_grade', 'users.id as id_user')
                    ->get();

                    // dd($users);
            } else {
                $users = DB::table('users')
                    ->join('statuses', 'users.id_status', '=', 'statuses.id')
                    ->join('depts', 'users.id_dept', '=', 'depts.id')
                    ->join('jobs', 'users.id_job', '=', 'jobs.id')
                    ->join('grades', 'users.id_grade', '=', 'grades.id')
                    ->join('salary_grades', 'grades.id', '=', 'salary_grades.id_grade')
                    ->join('salary_years', 'salary_years.id_user', '=', 'users.id')
                    ->where('users.id_status', $selectedStatus)
                    ->select('users.*', 'salary_grades.*', 'grades.*', 'statuses.*', 'depts.*', 'jobs.*', 'salary_grades.id as id_salary_grade', 'users.id as id_user')
                    ->get();
            }
        } else {
            $users = DB::table('users')
                ->join('statuses', 'users.id_status', '=', 'statuses.id')
                ->join('depts', 'users.id_dept', '=', 'depts.id')
                ->join('jobs', 'users.id_job', '=', 'jobs.id')
                ->join('grades', 'users.id_grade', '=', 'grades.id')
                ->join('salary_grades', 'grades.id', '=', 'salary_grades.id_grade')
                ->where('users.id_status', $selectedStatus)
                ->select('users.*', 'salary_grades.*', 'grades.*', 'statuses.*', 'depts.*', 'jobs.*', 'salary_grades.id as id_salary_grade', 'users.id as id_user')
                ->get();
        }

        return view('salary_year.create', compact('title', 'users', 'statuses', 'selectedStatus', 'currentYear'));
    }

    public function store(Request $request)
    {
        foreach ($request->input('id_user') as $key => $value) {

            $input = $request->only([
                'id_user', 'id_salary_grade', 'rate_salary',
                'ability', 'fungtional_alw', 'family_alw',
                'transport_alw', 'telephone_alw', 'skill_alw', 'adjustment'
            ]);

            $rate_salary = isset($input['rate_salary'][$key]) ? (int) str_replace(',', '', $input['rate_salary'][$key]) : 0;
            $ability = isset($input['ability'][$key]) ? (int) str_replace(',', '', $input['ability'][$key]) : 0;
            $fungtional_alw = isset($input['fungtional_alw'][$key]) ? (int) str_replace(',', '', $input['fungtional_alw'][$key]) : 0;
            $family_alw = isset($input['family_alw'][$key]) ? (int) str_replace(',', '', $input['family_alw'][$key]) : 0;
            $transport_alw = isset($input['transport_alw'][$key]) ? (int) str_replace(',', '', $input['transport_alw'][$key]) : 0;
            $telephone_alw = isset($input['telephone_alw'][$key]) ? (int) str_replace(',', '', $input['telephone_alw'][$key]) : 0;
            $skill_alw = isset($input['skill_alw'][$key]) ? (int) str_replace(',', '', $input['skill_alw'][$key]) : 0;
            $adjustment = isset($input['adjustment'][$key]) ? (int) str_replace(',', '', $input['adjustment'][$key]) : 0;

            $total = $rate_salary + $ability + $fungtional_alw + $family_alw + $transport_alw + $telephone_alw + $skill_alw;

            if ($total > 12000000) {
                $bpjs = 12000000 * 0.01;
            } else {
                $bpjs = $total * 0.01;
            }
            $jamsostek = $total * 0.02;

            $jamsostek_jkk = $total * 0.0054;
            $jamsostek_tk = $total * 0.003;
            $jamsostek_tht = $total * 0.037;
            $total_jamsostek = $jamsostek_jkk + $jamsostek_tk + $jamsostek_tht;

            $allocations = $request->input('allocation')[$key] ?? NULL;
            if ($allocations) {
                $allocationJson = json_encode($allocations);
            } else {
                $allocationJson = $allocations;
            }

            SalaryYear::updateOrCreate(
                [
                    'id_user' => $input['id_user'][$key],
                    'year' => date('Y'),
                ],
                [
                    'id_salary_grade' => $input['id_salary_grade'][$key],
                    'rate_salary' => $rate_salary,
                    'ability' => $ability,
                    'fungtional_alw' => $fungtional_alw,
                    'family_alw' => $family_alw,
                    'transport_alw' => $transport_alw,
                    'telephone_alw' => $telephone_alw,
                    'skill_alw' => $skill_alw,
                    'adjustment' => $adjustment,
                    'bpjs' => $bpjs,
                    'jamsostek' => $jamsostek,
                    'total_ben' => $total_jamsostek,
                    'total_ben_ded' => $total_jamsostek,
                    'allocation' => $allocationJson,
                ]
            );
        }

        return redirect()->route('salary-year')->with('success', 'Data gaji berhasil disimpan.');
    }

    public function edit(Request $request)
    {
        // $selectedIds = $request->input('ids', []);
        $selectedIds = $request->input('ids', '');

        if (is_string($selectedIds)) {
            $selectedIds = explode(',', $selectedIds);
        }

        if (empty($selectedIds)) {
            return redirect()->route('salary-year')->with('error', 'No data selected for editing.');
        }

        // dd($selectedIds);

        $title = 'Salary Per Grade';
        $salary_years = SalaryYear::whereIn('id', $selectedIds)->get();
        $currentYear = date('Y');

        return view('salary_year.edit', compact('title', 'salary_years'));
    }

    public function update(Request $request)
    {
        foreach ($request->input('ids') as $key => $value) {
            $rate_salary = $request->input('rate_salary')[$key];
            $ability =  $request->input('ability')[$key];
            $fungtional_alw =  $request->input('fungtional_alw')[$key];
            $family_alw =  $request->input('family_alw')[$key];
            $transport_alw =  $request->input('transport_alw')[$key];
            $telephone_alw =  $request->input('telephone_alw')[$key];
            $skill_alw =  $request->input('skill_alw')[$key];
            $adjustment =  $request->input('adjustment')[$key];

            $total = $rate_salary + $ability + $family_alw;

            if ($total > 12000000) {
                $bpjs = 12000000 * 0.01;
            } else {
                $bpjs = $total * 0.01;
            }

            // $total = $rate_salary + $ability + $fungtional_alw + $family_alw + $transport_alw + $telephone_alw + $skill_alw;
            // if ($total2 > 12000000) {
            //     $bpjs2 = 12000000 * 0.01;
            // } else {
            //     $bpjs2 = $total2 * 0.01;
            // }

            // dd($total, $total2, $bpjs, $bpjs2);


            $jamsostek = $total * 0.02;

            $jamsostek_jkk = $total * 0.0054;
            $jamsostek_tk = $total * 0.003;
            $jamsostek_tht = $total * 0.037;
            $total_jamsostek = $jamsostek_jkk + $jamsostek_tk + $jamsostek_tht;

            $allocations = $request->input('allocations')[$key] ?? NULL;
            if ($allocations) {
                $allocationJson = json_encode($allocations);
            } else {
                $allocationJson = $allocations;
            }

            SalaryYear::where('id', $request->input('ids'))->update([
                'ability' => $ability,
                'fungtional_alw' => $fungtional_alw,
                'family_alw' => $family_alw,
                'transport_alw' => $transport_alw,
                'telephone_alw' => $telephone_alw,
                'skill_alw' => $skill_alw,
                'adjustment' => $adjustment,
                'bpjs' => $bpjs,
                'jamsostek' => $jamsostek,
                'total_ben' => $total_jamsostek,
                'total_ben_ded' => $total_jamsostek,
                'allocation' => $allocationJson,
            ]);

            $salary_months = SalaryMonth::where('id_salary_year', $request->input('ids'))->get();
            foreach ($salary_months as $salary_month) {
                $thr = $salary_month->thr;
                $bonus = $salary_month->bonus;
                $incentive = $salary_month->incentive;

                $union = $salary_month->union;
                $absent = $salary_month->absent;
                $electricity = $salary_month->electricity;
                $cooperative = $salary_month->cooperative;

                $hour_call = $salary_month->hour_call;
                $total_overtime = (($rate_salary + $ability) / 173) * $hour_call;

                // dd($hour_call, $total_overtime);

                $gross_sal = $rate_salary + $ability + $fungtional_alw + $family_alw + $transport_alw + $telephone_alw + $skill_alw +
                $adjustment + $total_overtime + $thr + $bonus + $incentive;
                $total_deduction = $bpjs + $jamsostek + $union + $absent + $electricity + $cooperative;
                // $net_salary = ($gross_sal + $total_jamsostek) - ($total_deduction + $total_jamsostek);
                $net_salary = $gross_sal - $total_deduction;
                // dd($gross_sal, $total_deduction, $net_salary);

                SalaryMonth::where('id_salary_year', $request->input('ids'))->update([
                    'total_overtime' => $total_overtime,
                    'gross_salary' => $gross_sal,
                    'total_deduction' => $total_deduction,
                    'net_salary' => $net_salary,
                ]);
            }
        }

        return redirect()->route('salary-year')->with('success', 'Data gaji berhasil diperbarui.');
    }

    public function show()
    {

    }

    public function get_emp(Request $request)
    {
        $emp = User::where('id_status', $request->id_status)->select('id', 'nik', 'name')->get();
        return response()->json($emp);
    }

    public function get_rate_salary(Request $request)
    {
        $rate_salary = SalaryGrade::where('id_grade', $request->id_grade)->select('id', 'rate_salary')->get();
        return response()->json($rate_salary);
    }

    public function create_new(Request $request)
    {
        $title = 'Salary Per Year';
        $grade = Grade::all();
        $ids = $request->input('id');

        if (is_array($ids) && !empty($ids)) {

            $salary_years = DB::table('salary_years')
                ->join('salary_grades', 'salary_years.id_salary_grade', '=', 'salary_grades.id')
                ->join('grades', 'salary_grades.id_grade', '=', 'grades.id')
                ->join('users', 'salary_years.id_user', '=', 'users.id')
                ->join('statuses', 'users.id_status', '=', 'statuses.id')
                ->join('jobs', 'users.id_job', '=', 'jobs.id')
                ->join('depts', 'users.id_dept', '=', 'depts.id')
                ->select('salary_years.*', 'salary_grades.*', 'grades.*', 'users.*', 'statuses.*', 'jobs.*', 'depts.*',
                        'users.id as user_id', 'salary_years.id as salary_years_id', 'salary_grades.id as salary_grades_id', 'grades.id as grades_id')
                ->whereIn('salary_years.id_user', $ids)
                ->get();

            return view('salary_year.create_new', [
                'title' => $title,
                'salary_years' => $salary_years,
                'grade' => $grade
            ]);

        } else {
            return redirect()->back()->with('error', 'No users selected.');
        }
    }

    public function store_new(Request $request)
    {
        foreach ($request->input('id_user') as $key => $value) {

            $input = $request->only([
                'id_user', 'id_salary_grade', 'rate_salary',
                'ability', 'fungtional_alw', 'family_alw',
                'transport_alw', 'telephone_alw', 'skill_alw',
                'adjustment', 'date'
            ]);

            $rate_salary = isset($input['rate_salary'][$key]) ? (int) str_replace(',', '', $input['rate_salary'][$key]) : 0;
            $ability = isset($input['ability'][$key]) ? (int) str_replace(',', '', $input['ability'][$key]) : 0;
            $fungtional_alw = isset($input['fungtional_alw'][$key]) ? (int) str_replace(',', '', $input['fungtional_alw'][$key]) : 0;
            $family_alw = isset($input['family_alw'][$key]) ? (int) str_replace(',', '', $input['family_alw'][$key]) : 0;
            $transport_alw = isset($input['transport_alw'][$key]) ? (int) str_replace(',', '', $input['transport_alw'][$key]) : 0;
            $telephone_alw = isset($input['telephone_alw'][$key]) ? (int) str_replace(',', '', $input['telephone_alw'][$key]) : 0;
            $skill_alw = isset($input['skill_alw'][$key]) ? (int) str_replace(',', '', $input['skill_alw'][$key]) : 0;
            $adjustment = isset($input['adjustment'][$key]) ? (int) str_replace(',', '', $input['adjustment'][$key]) : 0;

            $total = $rate_salary + $ability + $family_alw;

            if ($total > 12000000) {
                $bpjs = 12000000 * 0.01;
            } else {
                $bpjs = $total * 0.01;
            }
            $jamsostek = $total * 0.02;

            $jamsostek_jkk = $total * 0.0054;
            $jamsostek_tk = $total * 0.003;
            $jamsostek_tht = $total * 0.037;
            $total_jamsostek = $jamsostek_jkk + $jamsostek_tk + $jamsostek_tht;

            $allocations = $request->input('allocation')[$key] ?? NULL;
            if ($allocations) {
                $allocationJson = json_encode($allocations);
            } else {
                $allocationJson = $allocations;
            }

            $addNew = SalaryYear::where('id', $request->input('ids')[$key])
                    ->update([
                        'used' => '0'
                    ]);

            if ($addNew) {
                SalaryYear::create([
                    'id_user' => $input['id_user'][$key],
                    'id_salary_grade' => $input['id_salary_grade'][$key],
                    'date' => $request->input('date'),
                    'year' => date('Y'),
                    'ability' => $ability,
                    'fungtional_alw' => $fungtional_alw,
                    'family_alw' => $family_alw,
                    'transport_alw' => $transport_alw,
                    'telephone_alw' => $telephone_alw,
                    'skill_alw' => $skill_alw,
                    'adjustment' => $adjustment,
                    'bpjs' => $bpjs,
                    'jamsostek' => $jamsostek,
                    'total_ben' => $total_jamsostek,
                    'total_ben_ded' => $total_jamsostek,
                    'allocation' => $allocationJson,
                ]);
            }

            // SalaryYear::updateOrCreate(
            //     [
            //         'id_user' => $input['id_user'][$key],
            //         'year' => date('Y'),
            //     ],
            //     [
            //         'id_salary_grade' => $input['id_salary_grade'][$key],
            //         'rate_salary' => $rate_salary,
            //         'ability' => $ability,
            //         'fungtional_alw' => $fungtional_alw,
            //         'family_alw' => $family_alw,
            //         'transport_alw' => $transport_alw,
            //         'telephone_alw' => $telephone_alw,
            //         'skill_alw' => $skill_alw,
            //         'adjustment' => $adjustment,
            //         'bpjs' => $bpjs,
            //         'jamsostek' => $jamsostek,
            //         'total_ben' => $total_jamsostek,
            //         'total_ben_ded' => $total_jamsostek,
            //         'allocation' => $allocationJson,
            //     ]
            // );
        }

        return redirect()->route('salary-year')->with('success', 'Data gaji berhasil disimpan.');
    }
}
