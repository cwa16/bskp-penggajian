<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Status;
use App\Models\Dept;
use App\Models\Job;
use App\Models\Grade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        $statuses = Status::all();
        $depts = Dept::all();
        $jobs = Job::all();
        $grades = Grade::all();
        $title = 'Users';
        return view('user.index', compact('title', 'users', 'statuses', 'depts', 'jobs', 'grades'));
    }

    public function checkEmpCode(Request $request)
    {
        $nik = $request->input('nik');
        $user = User::where('nik', $nik)->get();
        if ($user->count() > 0) {
            echo json_encode(FALSE);
        } else {
            echo json_encode(TRUE);
        }
    }

    public function checkEmail(Request $request)
    {
        $email = $request->input('email');

        // Lakukan validasi sesuai kebutuhan Anda
        $isUnique = !User::where('email', $email)->exists();

        return response()->json(['valid' => $isUnique]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        User::create([
            'nik' => $nik,
            'name' => $request->name,
            'id_status' => $request->id_status,
            'id_dept' => $request->id_dept,
            'id_job' => $request->id_job,
            'id_grade' => $request->id_grade,
            'sex' => $request->sex,
            'ttl' => $request->ttl,
            'start' => $request->start,
            'education' => $request->education,
            'religion' => $request->religion,
            'domisili' => $request->domisili,
            'email' => $request->email,
            'no_ktp' => $request->no_ktp,
            'no_telpon' => $request->no_telpon,
            'status_pernikahan' => $request->status_pernikahan,
            'role_app' => $request->role_app,
            'active' => $request->active,
            'password' => Hash::make($request->email),
        ]);

        return redirect()->route('user.index');
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
