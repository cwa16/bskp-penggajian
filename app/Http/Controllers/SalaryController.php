<?php

namespace App\Http\Controllers;

use App\Models\SalaryMonth;
use App\Models\Status;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
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

        // $monthOpts = SalaryMonth::select(DB::raw('MONTH(date) as month'))
        //     ->distinct()
        //     ->pluck('month');

        // $yearOpts = SalaryMonth::select(DB::raw('YEAR(date) as year'))
        //     ->distinct()
        //     ->pluck('year');
        // Get the range of years and months from the salary_months table
        $years = SalaryMonth::distinct('date')->pluck('date')->map(function ($date) {
            return Carbon::parse($date)->format('Y');
        })->unique()->toArray();
        $months = SalaryMonth::distinct('date')->pluck('date')->map(function ($date) {
            $carbonDate = Carbon::parse($date);
            // format keluaran yang berbeda menggunakan array
            return [
                'value' => $carbonDate->format('m'), // Nilai bulan dalam format numerik
                'label' => $carbonDate->format('F'), // Nama bulan dalam format teks
            ];
        })->unique()->toArray();

        // Get distinct status names through the relationships
        $statuses = Status::distinct('name_status')->pluck('name_status')->toArray();

        // Menyimpan query builder dalam variabel query
        $query = SalaryMonth::with('salary_year');

        // Set the default selected year to the current year
        $selectedYear =  null;
        $selectedMonth = null;
        // $selectedMonth = Carbon::now()->format('F');
        $selectedStatus = null;

        // percabangan untuk filter status
        if (request('filter_status') != null) {
            if (request('filter_status') != 'all') {
                // Filter by the selected status
                $selectedStatus = request('filter_status');
                $query->whereHas('salary_year.user.status', function ($subquery) use ($selectedStatus) {
                    $subquery->where('name_status', $selectedStatus);
                });
            }
        }

        // percabangan untuk filter tahun
        if (request('filter_year') != null) {
            if (request('filter_year') != 'all') {
                // Filter by the selected year
                $selectedYear = request('filter_year');
                $query->whereYear('date', $selectedYear);
            }
        } else {
            // untuk menetapkan tahun sekarang saat membuka halaman
            $selectedYear = request('filter_year', Carbon::now()->year);
            $query->whereYear('date', $selectedYear);
        }

        // percabangan untuk filter bulan
        if (request('filter_month') != null) {
            if (request('filter_month') != 'all') {
                // Filter by the selected month
                $selectedMonth = request('filter_month');
                $query->wheremonth('date', $selectedMonth);
            }
        } else {
            // untuk menetapkan bulan sekarang saat membuka halaman
            $selectedMonth = request('filter_month', Carbon::now()->month);
            $query->whereMonth('date', $selectedMonth);
        }

        // Query the salary_months based on the selected year, month, and status
        $salary_months = $query->get();

        return view('salary.index', compact('title', 'statuses', 'years', 'months', 'salary_months', 'selectedStatus', 'selectedYear', 'selectedMonth'));
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
        $monthOpts = SalaryMonth::select(DB::raw('MONTH(date) as month'))
            ->distinct()
            ->pluck('month');

        $yearOpts = SalaryMonth::select(DB::raw('YEAR(date) as year'))
            ->distinct()
            ->pluck('year');

        $year = request()->input('year');
        $month = request()->input('month');

        // $salaries = SalaryMonth::all();
        // Mengambil seluruh data salary_months beserta relasi salary_years-user-status
        // $salaries = SalaryMonth::with(['salary_year.user.status'])->get();
        $salaries = SalaryMonth::with(['salary_year.user.status'])
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->get();

        // Mengelompokkan salary_months berdasarkan name_status
        $salByStatus = $salaries->groupBy('salary_year.user.status.name_status');

        $date = null;
        foreach ($salaries as $sal) {
            $date = date('F Y', strtotime($sal->date));
        }

        // dd($salByStatus);
        if ($date) {
            $pdf = PDF::loadView('salary.printall', compact('salByStatus', 'date'));
            return $pdf->setPaper('a4', 'landscape')->stream('PrintAll.pdf');
        } else {
            return redirect()->route('salary.index');
        }
    }
}
