<?php

namespace App\Http\Controllers;

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

        // dd($salary_years);

        return view('salary_year.index', compact('title', 'salary_years', 'years', 'statuses', 'selectedYear', 'selectedStatus'));
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
                    ->where('salary_years.ability', 0)
                    ->select('users.*', 'salary_grades.*', 'grades.*', 'statuses.*', 'depts.*', 'jobs.*', 'salary_grades.id as id_salary_grade', 'users.id as id_user')
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

            $ability = $input['ability'][$key] ?? 0;
            $fungtional_alw = $input['fungtional_alw'][$key]  ?? 0;
            $family_alw = $input['family_alw'][$key]  ?? 0;
            $transport_alw = $input['transport_alw'][$key]  ?? 0;
            $telephone_alw = $input['telephone_alw'][$key]  ?? 0;
            $skill_alw = $input['skill_alw'][$key]  ?? 0;
            $adjustment = $input['adjustment'][$key]  ?? 0;

            $total = $input['rate_salary'][$key] +  $ability + $fungtional_alw + $family_alw + $transport_alw + $telephone_alw + $skill_alw;

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
        foreach ($request->input('ids') as $id) {
            $rate_salary = $request->input('rate_salary.' . $id);
            $ability =  $request->input('ability.' . $id);
            $fungtional_alw =  $request->input('fungtional_alw.' . $id);
            $family_alw =  $request->input('family_alw.' . $id);
            $transport_alw =  $request->input('transport_alw.' . $id);
            $telephone_alw =  $request->input('telephone_alw.' . $id);
            $skill_alw =  $request->input('skill_alw.' . $id);
            $adjustment =  $request->input('adjustment.' . $id);

            $total = $rate_salary +  $ability + $fungtional_alw + $family_alw + $transport_alw + $telephone_alw + $skill_alw;

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

            $allocations = $request->input('allocation.' . $id) ?? NULL;
            if ($allocations) {
                $allocationJson = json_encode($allocations);
            } else {
                $allocationJson = $allocations;
            }

            SalaryYear::where('id', $id)->update([
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

            $salary_months = SalaryMonth::where('id_salary_year', $id)->get();
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

                $gross_sal = $rate_salary + $ability + $fungtional_alw + $family_alw + $transport_alw + $telephone_alw + $skill_alw +
                    $adjustment + $total_overtime + $thr + $bonus + $incentive;
                $total_deduction = $bpjs + $jamsostek + $union + $absent + $electricity + $cooperative;
                $net_salary = ($gross_sal + $total_jamsostek) - ($total_deduction + $total_jamsostek);

                SalaryMonth::where('id_salary_year', $id)->update([
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
}
