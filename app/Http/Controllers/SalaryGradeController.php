<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\SalaryGrade;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SalaryGradeController extends Controller
{
    /** 
     * Display a listing of the resource. 
     */
    public function index()
    {
        $title = 'Salary Per Grade';
        // $salary_grades = SalaryGrade::all();
        $query = SalaryGrade::with('grade');

        // Check if the "Show All" option is selected
        if (request('filter_year') === 'all') {
            // Do not filter by year
        } else {
            // Filter by the selected year
            $filterYear = request('filter_year', Carbon::now()->year);
            $query->where('year', $filterYear);
        }
        $selectedYear = $filterYear ?? null;
        $salary_grades = $query->get();
        $years = SalaryGrade::distinct('year')->pluck('year')->toArray();
        return view('salary_grade.index', compact('title', 'salary_grades', 'years', 'selectedYear'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Salary Per Grade';
        $grades = Grade::all();
        $currentYear = date('Y'); //menetapkan tahun sekarang
        // $currentYear = 2021;
        $existingData = SalaryGrade::where('year', $currentYear)->count();
        return view('salary_grade.create', compact('title', 'grades', 'currentYear', 'existingData'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $currentYear = date('Y'); //menetapkan tahun sekarang
        // $currentYear = 2021;

        // Loop melalui data yang dikirim dari form
        foreach ($request->input('rate_salary') as $gradeId => $rate) {
            // Cek apakah data untuk tahun ini dan grade tersebut sudah ada atau belum
            $existingData = SalaryGrade::where('year', $currentYear)
                ->where('id_grade', $gradeId)
                ->count();

            // Jika belum ada, simpan data
            if ($existingData == 0) {
                SalaryGrade::create([
                    'id_grade' => $gradeId,
                    'rate_salary' => $rate,
                    'year' => $currentYear,
                ]);
            }
        }

        // Redirect atau lakukan aksi lainnya setelah penyimpanan selesai
        return redirect()->route('salarygrade.index')->with('success', 'Data gaji berhasil disimpan.');
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
    public function edit(Request $request)
    {
        $selectedIds = $request->input('ids', []);

        // Konversi string parameter ke dalam bentuk array
        if (is_string($selectedIds)) {
            $selectedIds = explode(',', $selectedIds);
        }

        // Jika tidak ada id yang dipilih, redirect kembali atau tampilkan pesan sesuai kebutuhan
        if (empty($selectedIds)) {
            return redirect()->route('salarygrade.index')->with('error', 'No data selected for editing.');
        }

        $title = 'Salary Per Grade';
        $grades = Grade::all();
        $salary_grades = SalaryGrade::whereIn('id', $selectedIds)->get();
        $currentYear = date('Y');

        return view('salary_grade.edit', compact('title', 'grades', 'salary_grades', 'currentYear'));
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
}
