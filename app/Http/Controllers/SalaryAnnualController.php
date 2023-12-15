<?php

namespace App\Http\Controllers;

use App\Models\Status;
use App\Models\User;
use App\Models\Salary;
use Illuminate\Http\Request;

class SalaryAnnualController extends Controller
{
    /** 
     * Display a listing of the resource. 
     */
    public function index()
    {
        $title = 'Salary Per Year';
        $salaries = Salary::all();
        return view('salary_annual.index', compact('title', 'salaries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Salary Per Year';
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

        // Filter users yang telah memiliki data gaji untuk tahun ini
        $users = $users->filter(function ($user) {
            return !$user->hasSalaryForYear(date('Y'));
        });

        // Meneruskan data ke tampilan
        return view('salary_annual.create', compact('title', 'users', 'statuses', 'selectedStatus'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Lakukan iterasi pada data yang dikirimkan melalui form
        foreach ($request->input('id_user') as $key => $value) {
            $rate_salary = $request->input('rate_salary')[$key];
            $ability = $request->input('ability')[$key] ?? 0;
            $fungtional_allowance = $request->input('fungtional_allowance')[$key] ?? 0;
            $family_allowance = $request->input('family_allowance')[$key] ?? 0;
            $total = $rate_salary + $ability + $fungtional_allowance + $family_allowance ?? 0;

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

            // Simpan data ke dalam database
            Salary::create([
                'id_user' => $request->input('id_user')[$key], // Pastikan Anda memiliki input user_id pada form
                'id_salary_grade' => $request->input('id_salary_grade')[$key], // Pastikan Anda memiliki input salary_grade_id pada form
                'ability' => $ability,
                'fungtional_allowance' => $fungtional_allowance,
                'family_allowance' => $family_allowance,
                'adjustment' => $request->input('adjustment')[$key] ?? 0,
                'transport_allowance' => $request->input('transport_allowance')[$key] ?? 0,
                'bpjs' => $bpjs,
                'jamsostek' => $jamsostek,
                'jamsostek_jkk_ben' => $jamsostek_jkk,
                'jamsostek_tk_ben' => $jamsostek_tk,
                'jamsostek_tht_ben' => $jamsostek_tht,
                'total_benefit' => $total_jamsostek,
                'jamsostek_jkk_deb' => $jamsostek_jkk,
                'jamsostek_tk_deb' => $jamsostek_tk,
                'jamsostek_tht_deb' => $jamsostek_tht,
                'total_debenefit' => $total_jamsostek,
            ]);
        }

        // Redirect atau lakukan sesuatu setelah penyimpanan berhasil
        return redirect()->route('salaryannual.index')->with('success', 'Data gaji berhasil disimpan.');
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
}
