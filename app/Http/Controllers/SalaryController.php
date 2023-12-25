<?php

namespace App\Http\Controllers;

use App\Models\SalaryMonth;

use Illuminate\Http\Request;
use PDF;

class SalaryController extends Controller
{
    /** 
     * Display a listing of the resource. 
     */
    public function index()
    {
        $title = 'Salary';
        $salary_months = SalaryMonth::all();
        return view('salary.index', compact('title', 'salary_months'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Print one salary data employee.
     */
    public function print($id)
    {
        $sal = SalaryMonth::find($id);

        // mengambeil date
        $date = date('My', strtotime($sal->date));

        if (!$sal) {
            // Log or dd() the ID to see which ID is causing the issue.
            dd("Salary with ID $id not found.");
        }

        // hitungan utuk mendapatkan total gaji bersih
        $rate_salary = $sal->salary_year->salary_grade->rate_salary;
        $ability = $sal->salary_year->ability;
        $fungtional_alw = $sal->salary_year->fungtional_alw;
        $family_alw = $sal->salary_year->family_alw;

        $total = $rate_salary + $ability + $fungtional_alw + $family_alw;

        $pdf = PDF::loadView('salary.print', compact('sal', 'total'));
        return $pdf->setPaper('a5', 'landscape')->stream('SAL_' . $date . '_' . $sal->salary_year->user->nik . '_' . $sal->salary_year->user->name . '.pdf');
    }

    /**
     * Download one salary data employee.
     */
    public function download($id)
    {
        $sal = SalaryMonth::find($id);

        // mengambeil date
        $date = date('My', strtotime($sal->date));

        if (!$sal) {
            // Log or dd() the ID to see which ID is causing the issue.
            dd("Salary with ID $id not found.");
        }

        // hitungan utuk mendapatkan total gaji bersih
        $rate_salary = $sal->salary_year->salary_grade->rate_salary;
        $ability = $sal->salary_year->ability;
        $fungtional_alw = $sal->salary_year->fungtional_alw;
        $family_alw = $sal->salary_year->family_alw;

        $total = $rate_salary + $ability + $fungtional_alw + $family_alw;

        $pdf = PDF::loadView('salary.print', compact('sal', 'total'));
        return $pdf->setPaper('a5', 'landscape')->download('SAL_' . $date . '_'  . $sal->salary_year->user->nik . '_' . $sal->salary_year->user->name . '.pdf');
    }

    /**
     * Print all salary data employee.
     */
    public function printall()
    {
        // $salaries = SalaryMonth::all();
        // Mengambil seluruh data salary_months beserta relasi salary_years-user-status
        $salaries = SalaryMonth::with(['salary_year.user.status'])->get();

        // Mengelompokkan salary_months berdasarkan name_status
        $salByStatus = $salaries->groupBy('salary_year.user.status.name_status');

        foreach ($salaries as $sal) {
            $date = date('F Y', strtotime($sal->date));
        }
        
        // dd($salByStatus);
        $pdf = PDF::loadView('salary.printall', compact('salByStatus', 'date'));
        return $pdf->setPaper('a4', 'landscape')->stream('PrintAll.pdf');
    }
}
