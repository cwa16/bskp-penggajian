<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

use App\Models\new_user;
use App\Models\User;
use App\Models\Status;
use App\Models\Dept;
use App\Models\Grade;
use App\Models\Job;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        $title = 'Employees';
        return view('user.index', compact('users', 'title'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

    public function getApiUser()
    {
        $response = Http::get('http://192.168.99.202/absen/public/api/users');
        $employees = $response->json(); // Ambil data JSON

        foreach ($employees as $employee) {
            // Step 2: Filter hanya data yang 'active' = 'yes'
            if ($employee['active'] !== 'yes') {
                continue;
            }

            // Step 3: Cek status
            $status = Status::where('name_status', $employee['status'])->first();
            $grade = Grade::where('name_grade', $employee['grade'])->first();
            $dept = Dept::where('name_dept', $employee['dept'])->first();
            $job = job::where('name_job', $employee['jabatan'])->first();

            // Step 4: Simpan data ke tabel users
            new_user::updateOrCreate(
                ['nik' => $employee['nik']],
                [
                    'nik' => $employee['nik'],
                    'name' => $employee['name'],
                    'id_status' => $status ? $status->id : null,
                    'id_grade' => $grade ? $grade->id : null,
                    'id_dept' => $dept ? $dept->id : null,
                    'id_job' => $job ? $job->id : null,
                    'sex' => $employee['sex'],
                    'ttl' => $employee['ttl'],
                    'start' => $employee['start'],
                    'pendidikan' => $employee['pendidikan'],
                    'agama' => $employee['agama'],
                    'domisili' => $employee['domisili'],
                    'email' => $employee['email'],
                    'no_ktp' => $employee['no_ktp'],
                    'no_telpon' => $employee['no_telpon'],
                    'kis' => $employee['kis'],
                    'kpj' => $employee['kpj'],
                    'suku' => $employee['suku'],
                    'no_sepatu_safety' => $employee['no_sepatu_safety'],
                    'no_baju' => $employee['no_baju'],
                    'gol_darah' => $employee['gol_darah'],
                    'bank' => $employee['bank'],
                    'no_bank' => $employee['no_bank'],
                    'loc_kerja' => $employee['loc_kerja'],
                    'loc' => $employee['loc'],
                    'sistem_absensi' => $employee['sistem_absensi'],
                    'latitude' => $employee['latitude'],
                    'longitude' => $employee['longitude'],
                    'aktual_cuti' => $employee['aktual_cuti'],
                    'status_pernikahan' => $employee['status_pernikahan'],
                    'istri_suami' => $employee['istri_suami'],
                    'anak_1' => $employee['anak_1'],
                    'anak_2' => $employee['anak_2'],
                    'anak_3' => $employee['anak_3'],
                    'access_by' => $employee['access_by'],
                    'image_url' => $employee['image_url'],
                    'role_app' => $employee['role_app'],
                    'active' => $employee['active'],
                    'email_verified_at' => $employee['email_verified_at'],
                    'password' => $employee['password'],
                    'remember_token' => $employee['remember_token'],
                    'created_at' => $employee['created_at'],
                    'updated_at' => $employee['updated_at'],
                ]

            );
        }

    }
}
