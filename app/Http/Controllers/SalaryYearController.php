<?php

namespace App\Http\Controllers;

use App\Models\Status;
use App\Models\User;
use App\Models\SalaryYear;
use Illuminate\Http\Request;

class SalaryYearController extends Controller
{
    /** 
     * Display a listing of the resource. 
     */
    public function index()
    {
        $title = 'Salary Per Year';
        $salary_years = SalaryYear::all();
        return view('salary_year.index', compact('title', 'salary_years'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Salary Per Year';
        $statuses = Status::all();
        $currentYear = date('Y'); //menetapkan tahun sekarang

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

        // Filter users yang telah memiliki data gaji untuk tahun ini
        $users = $users->filter(function ($user) {
            return !$user->hasSalaryForYear(date('Y'));
        });

        // Meneruskan data ke tampilan
        return view('salary_year.create', compact('title', 'users', 'statuses', 'selectedStatus'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Lakukan iterasi pada data yang dikirimkan melalui form
        foreach ($request->input('id_user') as $key => $value) {

            // Simpan nilai input dalam variabel
            $input = $request->only([
                'id_user', 'id_salary_grade', 'rate_salary',
                'ability', 'fungtional_alw', 'family_alw',
                'transport_alw', 'adjustment'
            ]);

            $ability = $input['ability'][$key] ?? 0;
            $fungtional_alw = $input['fungtional_alw'][$key]  ?? 0;
            $family_alw = $input['family_alw'][$key]  ?? 0;
            $transport_alw = $input['transport_alw'][$key]  ?? 0;
            $adjustment = $input['adjustment'][$key]  ?? 0;

            $total = $input['rate_salary'][$key] +  $ability + $fungtional_alw + $family_alw;

            // untuk kolom deduction
            if ($total > 12000000) {
                $bpjs = 12000000 * 0.01;
            } else {
                $bpjs = $total * 0.01;
            }
            $jamsostek = $total * 0.02;

            // untuk menghitung data benefit
            $jamsostek_jkk = $total * 0.0054;
            $jamsostek_tk = $total * 0.003;
            $jamsostek_tht = $total * 0.037;
            $total_jamsostek = $jamsostek_jkk + $jamsostek_tk + $jamsostek_tht;

            // Simpan data ke dalam database
            SalaryYear::create([
                'id_user' => $input['id_user'][$key], // Pastikan Anda memiliki input user_id pada form
                'id_salary_grade' => $input['id_salary_grade'][$key], // Pastikan Anda memiliki input salary_grade_id pada form
                'year' => date('Y'),
                'ability' => $ability,
                'fungtional_alw' => $fungtional_alw,
                'family_alw' => $family_alw,
                'transport_alw' => $transport_alw,
                'adjustment' => $adjustment,
                'bpjs' => $bpjs,
                'jamsostek' => $jamsostek,
                'total_ben' => $total_jamsostek,
                'total_ben_ded' => $total_jamsostek,
            ]);
        }

        // Redirect atau lakukan sesuatu setelah penyimpanan berhasil
        return redirect()->route('salary-year.index')->with('success', 'Data gaji berhasil disimpan.');
    }
}
