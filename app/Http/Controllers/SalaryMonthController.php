<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Status;
use App\Models\SalaryYear;
use App\Models\SalaryMonth;

use Illuminate\Http\Request;

class SalaryMonthController extends Controller
{
    /** 
     * Display a listing of the resource. 
     */
    public function index()
    {
        $title = 'Salary Per Month';
        $salaries = SalaryMonth::all();
        return view('salary_month.index', compact('title', 'salaries'));
    }

    /**
     * Show the form for creating a new resource.
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

        // Menggunakan eager loading untuk memuat relasi user, grade, dan salary_grades
        $salaries = SalaryYear::with(['user' => function ($query) use ($selectedStatusIds) {
            $query->whereIn('id_status', $selectedStatusIds);
        }, 'user.grade.salary_grades' => function ($query) {
            $query->orderBy('year', 'desc');
        }])->get();

        // Meneruskan data ke tampilan
        return view('salary_month.create', compact('title', 'salaries', 'statuses', 'selectedStatus'));
    }
}
