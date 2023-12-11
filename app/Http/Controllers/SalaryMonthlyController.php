<?php

namespace App\Http\Controllers;

use App\Models\Status;
use App\Models\User;
use App\Models\Salary;

use Illuminate\Http\Request;

class SalaryMonthlyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Salary Per Month';
        $salaries = Salary::all();
        return view('salary_monthly.index', compact('title', 'salaries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Salary Per Month';
        $statuses = Status::all();

        // Mendapatkan ID status yang diizinkan
        $allowedStatusNames = ['Assistant trainee', 'Manager', 'Monthly', 'Staff'];
        $selectedStatus = request()->input('id_status');

        // Jika filter status dipilih, ambil ID status yang dipilih
        $selectedStatusIds = $selectedStatus
            ? Status::whereIn('name_status', $allowedStatusNames)->where('id', $selectedStatus)->pluck('id')
            : Status::whereIn('name_status', $allowedStatusNames)->pluck('id');

        // Menggunakan eager loading untuk memuat relasi grade dan salary_grades
        $users = User::with(['grade.salary_grades' => function ($query) {
            $query->orderBy('year', 'desc'); // Jika Anda ingin mengurutkan berdasarkan tahun.
        }])->whereIn('id_status', $selectedStatusIds)->get();


        // Meneruskan data ke tampilan
        return view('salary_monthly.create', compact('title', 'users', 'statuses', 'selectedStatus'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
