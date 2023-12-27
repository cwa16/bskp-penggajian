<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Status;
use App\Models\SalaryYear;
use App\Models\SalaryMonth;
use Carbon\Carbon;

use Illuminate\Http\Request;

class SalaryMonthController extends Controller
{
    /** 
     * Display a listing of the resource. 
     */
    public function index()
    {
        $title = 'Salary Per Month';

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

        return view('salary_month.index', compact('title', 'statuses', 'years', 'months', 'salary_months', 'selectedStatus', 'selectedYear', 'selectedMonth'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Input Salary Per Month';
        $statuses = Status::all();
        $year = date('Y');

        // Apply status filter if selected
        $statusFilter = request()->input('id_status');
        $salary_years = [];

        // if ($statusFilter) {
        // Fetch data based on the filter
        $salary_years = SalaryYear::whereYear('year', $year)
            ->whereHas('user', function ($query) use ($statusFilter) {
                $query->where('id_status', $statusFilter);
            })
            ->with('user')
            ->get();
        // }
        // Filter users yang telah memiliki data gaji untuk tahun ini
        $salary_years = $salary_years->filter(function ($salary_year) {
            return !$salary_year->hasSalaryForMonth(date('Y'), date('m'));
        });


        return view('salary_month.create', compact('title', 'statuses', 'salary_years'));
    }

    public function store(Request $request)
    {
        foreach ($request->input('id_user') as $key => $id_user) {
            $rate_salary = $request->input('rate_salary')[$key];
            $ability = $request->input('ability')[$key];
            $fungtional_alw = $request->input('fungtional_alw')[$key];
            $family_alw = $request->input('family_alw')[$key];
            $transport_alw = $request->input('transport_alw')[$key];
            $adjustment = $request->input('adjustment')[$key];
            $total_overtime = $request->input('total_overtime')[$key];
            $thr = $request->input('thr')[$key];
            $bonus = $request->input('bonus')[$key];
            $incentive = $request->input('incentive')[$key];
            $total_ben = $request->input('total_ben')[$key];

            $bpjs = $request->input('bpjs')[$key];
            $jamsostek = $request->input('jamsostek')[$key];
            $union = $request->input('union')[$key];
            $absent = $request->input('absent')[$key];
            $electricity = $request->input('electricity')[$key];
            $cooperative = $request->input('cooperative')[$key];
            $total_ben_ded = $request->input('total_ben_ded')[$key];

            // Hitungan untuk mencari totalan
            $gross_sal = $rate_salary + $ability + $fungtional_alw + $family_alw + $transport_alw +
                $adjustment + $total_overtime + $thr + $bonus + $incentive;
            $total_deduction = $bpjs + $jamsostek + $union + $absent + $electricity + $cooperative;
            $net_salary = ($gross_sal + $total_ben) - ($total_deduction + $total_ben_ded);

            SalaryMonth::create([
                'id_salary_year' => $request->input('id_salary_year')[$key],
                'date' => now(),
                'hour_call' => $request->input('hour_call')[$key],
                'total_overtime' => $total_overtime,
                'thr' => $thr,
                'bonus' => $bonus,
                'incentive' => $incentive,
                'union' => $union,
                'absent' => $absent,
                'electricity' => $electricity,
                'cooperative' => $cooperative,
                'incentive' => $incentive,
                'gross_salary' => $gross_sal,
                'total_deduction' => $total_deduction,
                'net_salary' => $net_salary,
            ]);
        }

        // Redirect or return response as needed
        return redirect()->route('salary-month.index')->with('success', 'Salary data stored successfully');
    }
}
