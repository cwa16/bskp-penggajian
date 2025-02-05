<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\SalaryGrade;
use App\Models\SalaryYear;
use App\Models\SalaryMonth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;

class SalaryGradeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = 'Salary Per Grade';
        $query = SalaryGrade::with('grade');

        $jwt_token = session('jwt_token') ?? $request->jwt_token;
        $role = session('role') ?? $request->role;
        $nik = session('nik') ?? $request->nik;
        $dept = session('dept') ?? $request->dept;
        $jabatan = session('jabatan') ?? $request->jabatan;
        $name = User::where('nik', $nik)->value('name');

        if (request('filter_year') === 'all') {
        } else {
            $filterYear = request('filter_year', Carbon::now()->year);
            $query->where('year', $filterYear);
        }
        $selectedYear = $filterYear ?? null;
        $salary_grades = $query->get();
        $years = SalaryGrade::distinct('year')->pluck('year')->toArray();

        return view('salary_grade.index', compact(
            'title',
            'salary_grades',
            'years',
            'selectedYear',
            'nik',
            'name',
            'jwt_token',
            'dept',
            'jabatan',
            'roles'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $title = 'Salary Per Grade';
        $grades = Grade::all();
        $currentYear = date('Y');

        $jwt_token = session('jwt_token') ?? $request->jwt_token;
        $role = session('role') ?? $request->role;
        $nik = session('nik') ?? $request->nik;
        $dept = session('dept') ?? $request->dept;
        $jabatan = session('jabatan') ?? $request->jabatan;
        $name = User::where('nik', $nik)->value('name');

        $existingData = SalaryGrade::where('year', $currentYear)->count();
        return view('salary_grade.create', compact(
            'title',
            'grades',
            'currentYear',
            'existingData',
            'nik',
            'name',
            'jwt_token',
            'dept',
            'jabatan',
            'roles'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $currentYear = date('Y');

        foreach ($request->input('rate_salary') as $gradeId => $rate) {
            $existingData = SalaryGrade::where('year', $currentYear)
                ->where('id_grade', $gradeId)
                ->count();

            if ($existingData == 0) {
                $salaryGrade = SalaryGrade::create([
                    'id_grade' => $gradeId,
                    'rate_salary' => $rate,
                    'year' => $currentYear,
                ]);
            }
        }

        if ($salaryGrade) {
            toastr()->closeOnHover(true)->closeDuration(10)->success('Your Post as been edited!');
            return redirect()->back();
        } else {
            toastr()->closeOnHover(true)->closeDuration(10)->error('Failed to edit your Post');
            return redirect()->back();
        }

        return redirect()->route('salarygrade')->with('success', 'Data gaji berhasil disimpan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $selectedIds = $request->input('ids', '');

        if (is_string($selectedIds)) {
            $selectedIds = explode(',', $selectedIds);
        }

        if (empty($selectedIds)) {
            return redirect()->route('salarygrade')->with('error', 'No data selected for editing.');
        }

        $title = 'Salary Per Grade';
        $grades = Grade::all();
        $salary_grades = SalaryGrade::whereIn('id', $selectedIds)->get();
        $currentYear = date('Y');

        $jwt_token = session('jwt_token') ?? $request->jwt_token;
        $role = session('role') ?? $request->role;
        $nik = session('nik') ?? $request->nik;
        $dept = session('dept') ?? $request->dept;
        $jabatan = session('jabatan') ?? $request->jabatan;
        $name = User::where('nik', $nik)->value('name');

        return view('salary_grade.edit', compact(
            'title',
            'grades',
            'salary_grades',
            'currentYear',
            'nik',
            'name',
            'jwt_token',
            'dept',
            'jabatan',
            'roles'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        foreach ($request->input('ids') as $id) {
            $gradeId = $request->input('grade_ids.' . $id);
            $rate = $request->input('rate_salary.' . $id);

            SalaryGrade::where('id', $id)->update([
                'id_grade' => $gradeId,
                'rate_salary' => $rate,
            ]);

            $salary_years = SalaryYear::where('id_salary_grade', $id)->get();
            foreach ($salary_years as $salary_year) {
                $ability = $salary_year->ability;
                $fungtional_alw = $salary_year->fungtional_alw;
                $family_alw = $salary_year->family_alw;
                $transport_alw = $salary_year->transport_alw;
                $adjustment = $salary_year->adjustment;

                $total = $rate +  $ability + $fungtional_alw + $family_alw;

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

                SalaryYear::where('id_salary_grade', $id)->update([
                    'bpjs' => $bpjs,
                    'jamsostek' => $jamsostek,
                    'total_ben' => $total_jamsostek,
                    'total_ben_ded' => $total_jamsostek,
                ]);

                $id_salary_year = $salary_year->id;
                $salary_months = SalaryMonth::where('id_salary_year', $id_salary_year)->get();
                foreach ($salary_months as $salary_month) {
                    $thr = $salary_month->thr;
                    $bonus = $salary_month->bonus;
                    $incentive = $salary_month->incentive;

                    $union = $salary_month->union;
                    $absent = $salary_month->absent;
                    $electricity = $salary_month->electricity;
                    $cooperative = $salary_month->cooperative;

                    $hour_call = $salary_month->hour_call;
                    $total_overtime = (($rate + $ability) / 173) * $hour_call;

                    $gross_sal = $rate + $ability + $fungtional_alw + $family_alw + $transport_alw +
                        $adjustment + $total_overtime + $thr + $bonus + $incentive;
                    $total_deduction = $bpjs + $jamsostek + $union + $absent + $electricity + $cooperative;
                    $net_salary = ($gross_sal + $total_jamsostek) - ($total_deduction + $total_jamsostek);

                    SalaryMonth::where('id_salary_year', $id_salary_year)->update([
                        'total_overtime' => $total_overtime,
                        'gross_salary' => $gross_sal,
                        'total_deduction' => $total_deduction,
                        'net_salary' => $net_salary,
                    ]);
                }
            }
        }

        return redirect()->route('salarygrade')->with('success', 'Data gaji berhasil diperbarui.');
    }

    public function show()
    {

    }
}
