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
        $salary = Salary::find($id);

        // mengambeil date
        $date = date('My', strtotime($salary->created_at));

        if (!$salary) {
            // Log or dd() the ID to see which ID is causing the issue.
            dd("Salary with ID $id not found.");
        }

        $pdf = PDF::loadView('salary.print', compact('salary'));
        return $pdf->setPaper('a5', 'landscape')->stream('SAL_' . $date . '_' . $salary->user->nik . '_' . $salary->user->name . '.pdf');
    }

    /**
     * Download one salary data employee.
     */
    public function download($id)
    {
        $salary = Salary::find($id);

        // mengambeil date
        $date = date('My', strtotime($salary->created_at));

        if (!$salary) {
            // Log or dd() the ID to see which ID is causing the issue.
            dd("Salary with ID $id not found.");
        }

        $pdf = PDF::loadView('salary.print', compact('salary'));
        return $pdf->setPaper('a5', 'landscape')->download('SAL_' . $date . '_'  . $salary->user->nik . '_' . $salary->user->name . '.pdf');
    }

    /**
     * Print all salary data employee.
     */
    public function printall()
    {
        $salaries = Salary::all();

        if (!$salaries) {
            // Log or dd() the ID to see which ID is causing the issue.
            dd("Salary not found.");
        }

        $pdf = PDF::loadView('salary.printall', compact('salaries'));
        return $pdf->setPaper('a4')->stream('PrintAll.pdf');
    }
}
