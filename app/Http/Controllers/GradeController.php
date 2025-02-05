<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\User;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    /** Display a listing of the resource. */
    public function index(Request $request)
    {
        $jwt_token = session('jwt_token') ?? $request->jwt_token;
        $role = session('role') ?? $request->role;
        $nik = session('nik') ?? $request->nik;
        $dept = session('dept') ?? $request->dept;
        $jabatan = session('jabatan') ?? $request->jabatan;

        $name = User::where('nik', $nik)->value('name');

        $grades = Grade::all();
        $title = 'Grade Data';

        return view('grade.index', [
            'title' => $title,
            'roles' => $role,
            'name' => $name,
            'grades' => $grades,
            'jwt_token' => $jwt_token,
            'dept' => $dept,
            'jabatan' => $jabatan,

        ]);
    }

    /** Show the form for creating a new resource. */
    public function create()
    {
        //
    }

    /** Store a newly created resource in storage.*/
    public function store(Request $request)
    {
        $grade = Grade::create([
            'name_grade' => $request->name_grade,
            'rate_salary' => $request->rate_salary,
            'year' => $request->year,
        ]);

        if ($grade) {
            toastr()->closeOnHover(true)->closeDuration(10)->success('Your Post as been edited!');
            return redirect()->back();
        } else {
            toastr()->closeOnHover(true)->closeDuration(10)->error('Failed to edit your Post');
            return redirect()->back();
        }
    }

    /**  Display the specified resource.*/
    public function show($id)
    {
        //
    }

    /** Show the form for editing the specified resource. */
    public function edit($id)
    {
        //
    }

    /** Update the specified resource in storage. */
    public function update(Request $request, $id)
    {
        $grade = Grade::find($id);
        $grade->update([
            'name_grade' => $request->name_grade,
            'rate_salary' => $request->rate_salary,
            'year' => $request->year,
        ]);

        if ($grade) {
            toastr()->closeOnHover(true)->closeDuration(10)->success('Your Post as been edited!');
            return redirect()->back();
        } else {
            toastr()->closeOnHover(true)->closeDuration(10)->error('Failed to edit your Post');
            return redirect()->back();
        }

    }

    /** Remove the specified resource from storage. */
    public function destroy($id)
    {
        $grade = Grade::find($id);

        $grade->delete();

        if ($grade) {
            toastr()->closeOnHover(true)->closeDuration(10)->success('Your Post as been edited!');
            return redirect()->back();
        } else {
            toastr()->closeOnHover(true)->closeDuration(10)->error('Failed to edit your Post');
            return redirect()->back();
        }

    }
}
