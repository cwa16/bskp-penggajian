<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $roles = $request->get('roles');

        // dd($roles);

        // $roleNames = array_map(function($role) {
        //     return $role['role'];
        // }, $roles);

        // Cek apakah $roles adalah array
        //     if (is_array($roles)) {
        //         $roleNames = array_map(function($role) {
        //             return is_array($role) && isset($role['role']) ? $role['role'] : null;
        //         }, $roles);

        //         $roleNames = array_filter($roleNames);
        //     } else {
        //         $roleNames = [];
        // }

        $request->session()->put('roles', $roles);
        // dd(session('roles'));
        // $request->session()->put('roles', $roleNames);

        // dd($roleNames, session('roles'));
        // $statuses = User::select('status')->where('status', 'Manager')->groupBy('status')->pluck('status')->count();
        $managerCount = User::where('status', 'Manager')->count();
        $staffCount = User::where('status', 'Staff')->count();
        $monthlyCount = User::where('status', 'Monthly')->count();
        $regularCount = User::where('status', 'Regular')->count();
        $contractBskpCount = User::where('status', 'Contract BSKP')->count();
        $contractFlCount = User::where('status', 'Contract FL')->count();

        return view('dashboard.index', [
            'title' => 'Dashboard',
            'managerCount' => $managerCount,
            'staffCount' => $staffCount,
            'monthlyCount' => $monthlyCount,
            'regularCount' => $regularCount,
            'contractBskpCount' => $contractBskpCount,
            'contractFlCount' => $contractFlCount,
            'roles' => $roles
        ]);
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
}
