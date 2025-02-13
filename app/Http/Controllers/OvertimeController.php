<?php

namespace App\Http\Controllers;


use App\Models\SalaryYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use Carbon\Carbon;
use DB;

use App\Models\OvertimeApproved;
use App\Models\SalaryMonth;
use App\Models\User;
use App\Models\OvertimeMaster;
use App\Models\Holiday;

class OvertimeController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Individual Overtime Approval';

        $dateInput = request()->input('date', '');

        $jwt_token = session('jwt_token') ?? $request->jwt_token;
        $role = session('role') ?? $request->role;
        $nik = session('nik') ?? $request->nik;
        $dept = session('dept') ?? $request->dept;
        $jabatan = session('jabatan') ?? $request->jabatan;
        $name = User::where('nik', $nik)->value('name');

        if ($dateInput == '') {
            $dateYesterday = Carbon::today()->subDay()->format('Y-m-d');
            $users = DB::table('test_absen_regs')
                ->join('users', 'users.nik', '=', 'test_absen_regs.user_id')
                ->join('salary_years', 'salary_years.nik', '=', 'test_absen_regs.user_id')
                ->join('grade', 'grade.id', '=', 'salary_years.id_salary_grade')
                ->leftJoin('overtime_approveds', function ($join) use ($dateYesterday) {
                    $join->on('overtime_approveds.nik', '=', 'test_absen_regs.user_id')
                        ->where('overtime_approveds.overtime_date', '=', $dateYesterday);
                })
                ->select(
                    'users.name',
                    'users.status',
                    'users.dept',
                    'users.jabatan',
                    'salary_years.ability',
                    'grade.rate_salary',
                    'test_absen_regs.user_id',
                    'test_absen_regs.date',
                    'test_absen_regs.overtime_hour',
                    'test_absen_regs.overtime_minute',
                    'test_absen_regs.desc',
                    'test_absen_regs.hadir',
                    'salary_years.id as salary_years_id',
                    DB::raw('IF(overtime_approveds.id IS NOT NULL, 1, 0) as is_approved')
                )
                ->whereNotNull('test_absen_regs.overtime_minute')
                ->where('test_absen_regs.overtime_minute', '!=', 0)
                ->where('test_absen_regs.date', $dateYesterday)
                ->get();
        } else {
            $dateYesterday = request()->input('date', '');
            $users = DB::table('test_absen_regs')
                ->join('users', 'users.nik', '=', 'test_absen_regs.user_id')
                ->join('salary_years', 'salary_years.nik', '=', 'test_absen_regs.user_id')
                ->join('grade', 'grade.id', '=', 'salary_years.id_salary_grade')
                ->leftJoin('overtime_approveds', function ($join) use ($dateYesterday) {
                    $join->on('overtime_approveds.nik', '=', 'test_absen_regs.user_id')
                        ->where('overtime_approveds.overtime_date', '=', $dateYesterday);
                })
                ->select(
                    'users.name',
                    'users.status',
                    'users.dept',
                    'users.jabatan',
                    'salary_years.ability',
                    'grade.rate_salary',
                    'test_absen_regs.user_id',
                    'test_absen_regs.date',
                    'test_absen_regs.overtime_hour',
                    'test_absen_regs.overtime_minute',
                    'test_absen_regs.desc',
                    'test_absen_regs.hadir',
                    'salary_years.id as salary_years_id',
                    DB::raw('IF(overtime_approveds.id IS NOT NULL, 1, 0) as is_approved')
                )
                ->whereNotNull('test_absen_regs.overtime_minute')
                ->where('test_absen_regs.overtime_minute', '!=', 0)
                ->where('test_absen_regs.date', $dateYesterday)
                ->get();
        }

        $dataGabungan = $users->map(function ($item) {
            $item = (array) $item;

            $totalMinutes = ($item['overtime_hour'] * 60) + $item['overtime_minute'];

            $totalMinutesInDecimal = ($totalMinutes / 60);
            $item['total_minutes_in_decimal'] = $totalMinutesInDecimal;

            if ($totalMinutes <= 30) {
                $overtimeHourInDecimal = 0;
            } elseif ($totalMinutes <= 60 && $totalMinutes >= 30) {
                $overtimeHourInDecimal = 1;
            } elseif ($totalMinutes <= 90) {
                $overtimeHourInDecimal = 1.5;
            } elseif ($totalMinutes <= 120) {
                $overtimeHourInDecimal = 2;
            } else {
                $overtimeHourInDecimal = floor($totalMinutes / 60) + ($totalMinutes % 60 > 30 ? 0.5 : 0);
            }

            if ($overtimeHourInDecimal == 0) {
                return null;
            }

            if (isset($item['desc']) && in_array($item['desc'], ['MX'])) {
                $item['overtime_hour_after_cal'] = $overtimeHourInDecimal * 2;
            } else {
                $item['overtime_hour_after_cal'] = ($overtimeHourInDecimal * 2) - 0.5;
            }

            if ($item['overtime_hour_after_cal'] <= 0) {
                unset($item['overtime_hour_after_cal']);
            }

            return $item;
        })->filter();

        $dataGabunganGrouped = $dataGabungan->groupBy('status');

        $order = ['Manager', 'Staff', 'Monthly', 'Regular', 'Contract FL', 'Contract BSKP'];

        $dataGabunganGrouped = $dataGabunganGrouped->sortBy(function ($items, $status) use ($order) {
            return array_search($status, $order);
        });

        return view('overtime.index', [
            'title' => $title,
            'dataGabunganGrouped' => $dataGabunganGrouped,
            'dateYesterday' => $dateYesterday,
            'name' => $name,
            'jwt_token' => $jwt_token,
            'dept' => $dept,
            'jabatan' => $jabatan,
            'role' => $role,
            'nik' => $nik
        ]);
    }

    public function index_summary(Request $request)
    {
        $title = 'Summary Overtime';

        $getEmployeesDept = User::pluck('dept')->unique()->sort();

        $jwt_token = session('token') ?? $request->token;
        $role = session('role') ?? $request->role;
        $nik = session('nik') ?? $request->nik;
        $dept = session('dept') ?? $request->dept;
        $jabatan = session('jabatan') ?? $request->jabatan;
        $name = User::where('nik', $nik)->value('name');

        $request->validate([
            'month' => 'nullable|date_format:Y-m',
        ]);

        $deptInput = $request->input('deptInput');
        $statusInput = $request->input('status');
        $dateInput = $request->input('month');

        if ($dateInput == null && $deptInput == null && $statusInput == null && $jwt_token != null && $nik != null && $role != null && $dept != null && $jabatan != null) {
            $month = Carbon::now()->month;
            $year = Carbon::now()->year;
            $formattedMonth = Carbon::now()->format('F');
        } else {
            list($year, $month) = explode('-', $dateInput);
            $formattedMonth = Carbon::parse($dateInput)->format('F');
        }

        if ($deptInput == 'All') {
            if ($statusInput == 'All') {
                $data = DB::table('overtime_approveds')
                    ->join('users', 'users.nik', '=', 'overtime_approveds.nik')
                    ->join('salary_years', 'salary_years.nik', '=', 'overtime_approveds.nik')
                    ->join('grade', 'grade.id', '=', 'salary_years.id_salary_grade')
                    ->select(
                        'users.nik',
                        'users.name',
                        'users.dept',
                        'users.status',
                        'users.jabatan',
                        'users.overtime_limit',
                        'overtime_approveds.overtime_date',
                        'overtime_approveds.overtime_adj',
                        'overtime_approveds.overtime_ori',
                        'overtime_approveds.hour_call',
                        'salary_years.ability',
                        'grade.rate_salary',
                        'salary_years.id as salary_years_id'
                    )
                    ->whereMonth('overtime_approveds.overtime_date', $month)
                    ->whereYear('overtime_approveds.overtime_date', $year)
                    ->get()
                    ->groupBy('nik');

                $holidays = Holiday::whereYear('date', $year)
                    ->whereMonth('date', $month)
                    ->pluck('date')
                    ->toArray();

                $dates = collect();
                $startOfMonth = Carbon::createFromDate($year, $month, 1)->startOfMonth();
                $endOfMonth = Carbon::createFromDate($year, $month, 1)->endOfMonth();

                for ($date = $startOfMonth->copy(); $date <= $endOfMonth; $date->addDay()) {
                    $isHoliday = in_array($date->format('Y-m-d'), $holidays);
                    $dates->push([
                        'date' => $date->format('Y-m-d'),
                        'day' => $date->locale('id')->isoFormat('dddd'), // Nama hari dalam Bahasa Indonesia
                        'isHoliday' => $isHoliday,
                        'holidayName' => $isHoliday ? Holiday::where('date', $date->format('Y-m-d'))->first()->name : null,
                    ]);
                }
            } else {
                $data = DB::table('overtime_approveds')
                    ->join('users', 'users.nik', '=', 'overtime_approveds.nik')
                    ->join('salary_years', 'salary_years.nik', '=', 'overtime_approveds.nik')
                    ->join('grade', 'grade.id', '=', 'salary_years.id_salary_grade')
                    ->select(
                        'users.nik',
                        'users.name',
                        'users.dept',
                        'users.status',
                        'users.jabatan',
                        'users.overtime_limit',
                        'overtime_approveds.overtime_date',
                        'overtime_approveds.overtime_adj',
                        'overtime_approveds.overtime_ori',
                        'overtime_approveds.hour_call',
                        'salary_years.ability',
                        'grade.rate_salary',
                        'salary_years.id as salary_years_id'
                    )
                    ->where('users.status', $statusInput)
                    ->whereMonth('overtime_approveds.overtime_date', $month)
                    ->whereYear('overtime_approveds.overtime_date', $year)
                    ->get()
                    ->groupBy('nik');

                $holidays = Holiday::whereYear('date', $year)
                    ->whereMonth('date', $month)
                    ->pluck('date')
                    ->toArray();

                $dates = collect();
                $startOfMonth = Carbon::createFromDate($year, $month, 1)->startOfMonth();
                $endOfMonth = Carbon::createFromDate($year, $month, 1)->endOfMonth();

                for ($date = $startOfMonth->copy(); $date <= $endOfMonth; $date->addDay()) {
                    $isHoliday = in_array($date->format('Y-m-d'), $holidays);
                    $dates->push([
                        'date' => $date->format('Y-m-d'),
                        'day' => $date->locale('id')->isoFormat('dddd'), // Nama hari dalam Bahasa Indonesia
                        'isHoliday' => $isHoliday,
                        'holidayName' => $isHoliday ? Holiday::where('date', $date->format('Y-m-d'))->first()->name : null,
                    ]);
                }
            }

        } else {
            if ($statusInput == 'All') {
                $data = DB::table('overtime_approveds')
                ->join('users', 'users.nik', '=', 'overtime_approveds.nik')
                ->join('salary_years', 'salary_years.nik', '=', 'overtime_approveds.nik')
                ->join('grade', 'grade.id', '=', 'salary_years.id_salary_grade')
                ->select(
                    'users.nik',
                    'users.name',
                    'users.dept',
                    'users.status',
                    'users.jabatan',
                    'users.overtime_limit',
                    'overtime_approveds.overtime_date',
                    'overtime_approveds.overtime_adj',
                    'overtime_approveds.overtime_ori',
                    'overtime_approveds.hour_call',
                    'salary_years.ability',
                    'grade.rate_salary',
                    'salary_years.id as salary_years_id'
                )
                ->where('users.dept', $deptInput)
                ->whereMonth('overtime_approveds.overtime_date', $month)
                ->whereYear('overtime_approveds.overtime_date', $year)
                ->get()
                ->groupBy('nik');

            $holidays = Holiday::whereYear('date', $year)
                ->whereMonth('date', $month)
                ->pluck('date')
                ->toArray();

            $dates = collect();
            $startOfMonth = Carbon::createFromDate($year, $month, 1)->startOfMonth();
            $endOfMonth = Carbon::createFromDate($year, $month, 1)->endOfMonth();

            for ($date = $startOfMonth->copy(); $date <= $endOfMonth; $date->addDay()) {
                $isHoliday = in_array($date->format('Y-m-d'), $holidays);
                $dates->push([
                    'date' => $date->format('Y-m-d'),
                    'day' => $date->locale('id')->isoFormat('dddd'), // Nama hari dalam Bahasa Indonesia
                    'isHoliday' => $isHoliday,
                    'holidayName' => $isHoliday ? Holiday::where('date', $date->format('Y-m-d'))->first()->name : null,
                ]);
            }
            } else {
                $data = DB::table('overtime_approveds')
                ->join('users', 'users.nik', '=', 'overtime_approveds.nik')
                ->join('salary_years', 'salary_years.nik', '=', 'overtime_approveds.nik')
                ->join('grade', 'grade.id', '=', 'salary_years.id_salary_grade')
                ->select(
                    'users.nik',
                    'users.name',
                    'users.dept',
                    'users.status',
                    'users.jabatan',
                    'users.overtime_limit',
                    'overtime_approveds.overtime_date',
                    'overtime_approveds.overtime_adj',
                    'overtime_approveds.overtime_ori',
                    'overtime_approveds.hour_call',
                    'salary_years.ability',
                    'grade.rate_salary',
                    'salary_years.id as salary_years_id'
                )
                ->where('users.dept', $deptInput)
                ->where('users.status', $statusInput)
                ->whereMonth('overtime_approveds.overtime_date', $month)
                ->whereYear('overtime_approveds.overtime_date', $year)
                ->get()
                ->groupBy('nik');

            $holidays = Holiday::whereYear('date', $year)
                ->whereMonth('date', $month)
                ->pluck('date')
                ->toArray();

            $dates = collect();
            $startOfMonth = Carbon::createFromDate($year, $month, 1)->startOfMonth();
            $endOfMonth = Carbon::createFromDate($year, $month, 1)->endOfMonth();

            for ($date = $startOfMonth->copy(); $date <= $endOfMonth; $date->addDay()) {
                $isHoliday = in_array($date->format('Y-m-d'), $holidays);
                $dates->push([
                    'date' => $date->format('Y-m-d'),
                    'day' => $date->locale('id')->isoFormat('dddd'), // Nama hari dalam Bahasa Indonesia
                    'isHoliday' => $isHoliday,
                    'holidayName' => $isHoliday ? Holiday::where('date', $date->format('Y-m-d'))->first()->name : null,
                ]);
            }
            }
        }

        return view('overtime.summary-new', [
            'title' => $title,
            'month' => $month,
            'year' => $year,
            'formattedMonth' => $formattedMonth,
            'dates' => $dates,
            'data' => $data,
            'dateInput' => $dateInput,
            'getEmployeesDept' => $getEmployeesDept,
            'deptInput' => $deptInput,
            'statusInput' => $statusInput,
            'name' => $name,
            'jwt_token' => $jwt_token,
            'dept' => $dept,
            'jabatan' => $jabatan,
            'role' => $role,
            'nik' => $nik
        ]);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        if ($request->has('select_item')) {
            $userIds = $request->input('select_item');
            $originalOvertime = $request->input('original_overtime');
            $adjustOtCall = $request->input('adjust_ot_call');
            $overtimeHours = $request->input('overtime_cal');
            // $totalOvertimes = $request->input('totalOvertime');
            $dates = $request->input('tanggal');

            foreach ($userIds as $userId) {
                $overtimeHour = $overtimeHours[$userId] ?? null;
                // $totalOvertime = $totalOvertimes[$userId] ?? null;
                $originalOvertimeValue = $originalOvertime[$userId] ?? null;
                $adjustOtCallValue = $adjustOtCall[$userId] ?? null;

                // dd($userIds);

                // Pastikan nilai tidak null
                if ($overtimeHour !== null && $originalOvertimeValue !== null && $adjustOtCallValue !== null) {
                    OvertimeApproved::updateOrCreate(
                        [
                            'nik' => $userId,
                            'overtime_date' => $dates,
                        ],
                        [
                            'overtime_ori' => $originalOvertimeValue,
                            'overtime_adj' => $adjustOtCallValue,
                            'hour_call' => $overtimeHour,
                            // 'total_overtime' => $totalOvertime
                        ]
                    );
                }
            }

            return redirect()->route('overtime-approval-index')->with('success', 'Data berhasil disimpan.');
        } else {
            return redirect()->route('overtime-approval-index')->with('error', 'Tidak ada data yang dipilih.');
        }
    }

    public function store_summary(Request $request)
    {
        $dates = $request->input('dates', []);
        $selectedItems = $request->input('selected_items', []);

        foreach ($selectedItems as $item) {
            list($salaryYearId, $adjustedOvertime, $nominalUang) = explode('|', $item);
            $cleanValue = (int) round(str_replace(',', '', $nominalUang));
            // dd($salaryYearId, $adjustedOvertime, $cleanValue, $dates[0]);


            // Update or create logic here
            SalaryMonth::updateOrCreate(
                [
                    'id_salary_year' => $salaryYearId,
                    'date' => $dates[0] ?? null
                ],
                [
                    'hour_call' => $adjustedOvertime,
                    'total_overtime' => $cleanValue,
                ]
            );
        }

        return redirect()->back()->with('success', 'Data updated successfully!');
    }

    public function overtime_master_index(Request $request)
    {
        $title = "Overtime Matrix Data";
        $data = OvertimeMaster::all();

        $jwt_token = session('jwt_token') ?? $request->jwt_token;
        $role = session('role') ?? $request->role;
        $nik = session('nik') ?? $request->nik;
        $dept = session('dept') ?? $request->dept;
        $jabatan = session('jabatan') ?? $request->jabatan;
        $name = User::where('nik', $nik)->value('name');

        return view('overtime.index-master', compact('data', 'title', 'jwt_token', 'role', 'nik', 'dept', 'jabatan', 'name'));
    }

    public function overtime_master_store(Request $request)
    {
        $OvertimeMin = $request->overtime_min;
        $OvertimeMax = $request->overtime_max;
        $OvertimeValue = $request->overtime_value;

        OvertimeMaster::create([
            'overtime_min' => $OvertimeMin,
            'overtime_max' => $OvertimeMax,
            'overtime_value' => $OvertimeValue,
        ]);

        return redirect()->route('overtime-master-index');
    }

    public function overtime_master_update($id)
    {
        $overtimeMatrix = OvertimeMaster::find($id);
        $overtimeMatrix->update([
            'overtime_min' => request()->overtime_min,
            'overtime_max' => request()->overtime_max,
            'overtime_value' => request()->overtime_value,
        ]);

        return redirect()->route('overtime-master-index');
    }

    public function overtime_master_destory($id)
    {
        $overtimeMatrix = OvertimeMaster::find($id);

        $overtimeMatrix->delete();

        return redirect()->route('overtime-master-index');
    }

    public function overtime_limit_index(Request $request)
    {
        $title = "Overtime Limits";

        $statuses = User::distinct('status')->pluck('status')->toArray();
        $selectedStatus = trim(request()->input('filter_status', ''));

        $jwt_token = session('jwt_token') ?? $request->jwt_token;
        $role = session('role') ?? $request->role;
        $nik = session('nik') ?? $request->nik;
        $dept = session('dept') ?? $request->dept;
        $jabatan = session('jabatan') ?? $request->jabatan;
        $name = User::where('nik', $nik)->value('name');

        if ($selectedStatus == null) {
            $data = User::where('active', 'yes')->get();
        } else {
            $data = User::where('active', 'yes')->where('status', $selectedStatus)->get();
        }

        return view('overtime.index-limit', compact('statuses', 'data', 'title', 'jwt_token', 'role', 'nik', 'dept', 'jabatan', 'name'));
    }

    public function overtime_limit_store(Request $request)
    {
        $request->validate([
            'nik' => 'required|array',
            'overtime_limit' => 'required|array',
            'overtime_limit.*' => 'nullable|numeric|min:0',
        ]);

        foreach ($request->nik as $index => $nik) {
            $employee = User::where('nik', $nik)->first();

            if ($employee) {
                User::updateOrCreate(
                    ['nik' => $employee->nik],
                    ['overtime_limit' => $request->overtime_limit[$index]]
                );
            }
        }

        return redirect()->route('overtime-limit-index')->with('success', 'Overtime limits updated successfully!');
    }

    public function summary_overtime_index(Request $request)
    {
        $title = "Summary Overtime";
        $getEmployeesDept = User::pluck('dept')->unique()->sort();
        $getEmployeesStatus = User::pluck('status')->unique()->sort();

        $jwt_token = session('jwt_token') ?? $request->jwt_token;
        $role = session('role') ?? $request->role;
        $nik_session = session('nik') ?? $request->nik;
        $dept_session = session('dept') ?? $request->dept;
        $jabatan = session('jabatan') ?? $request->jabatan;
        $name = User::where('nik', $nik_session)->value('name');

        $dept = $request->deptInput;
        $status = $request->status;


        if ($request->token != null && $request->nik != null && $request->role != null && $request->dept != null && $request->jabatan != null && $nik_session != null && $dept_session != null) {
            $nik = SalaryYear::select('nik')->get();
            $overtime_records = [];

            foreach ($nik as $n) {
                $overtimeData = DB::table('salary_months')
                    ->join('salary_years', 'salary_years.id', '=', 'salary_months.id_salary_year')
                    ->join('users', 'users.nik', '=', 'salary_years.nik')
                    ->leftJoin('test_absen_regs', 'test_absen_regs.user_id', '=', 'users.nik')
                    ->select(
                        'users.nik',
                        'users.name',
                        'users.jabatan',
                        'users.status',
                        'users.dept',
                        'users.overtime_limit',
                        'salary_months.hour_call',
                        'test_absen_regs.desc',
                        DB::raw("SUM(test_absen_regs.overtime_hour) as toth"),
                        DB::raw("SUM(test_absen_regs.overtime_minute) as totm"),
                        DB::raw("(SUM(test_absen_regs.overtime_hour) + (SUM(test_absen_regs.overtime_minute) / 60)) as total_overtime_hour")
                    )
                    ->where('users.nik', $n->nik)
                    ->where('users.active', 'yes')
                    ->whereMonth('salary_months.date', Carbon::now()->month)
                    ->whereYear('salary_months.date', Carbon::now()->year)
                    ->whereMonth('test_absen_regs.date', Carbon::now()->month)
                    ->whereYear('test_absen_regs.date', Carbon::now()->year)
                    ->groupBy(
                        'users.nik',
                        'users.name',
                        'users.jabatan',
                        'users.status',
                        'users.dept',
                        'users.overtime_limit',
                        'salary_months.hour_call',
                        'test_absen_regs.desc'
                    )
                    ->first();
                if ($overtimeData) {
                    $totalMinutes = ($overtimeData->toth * 60) + $overtimeData->totm;

                    if ($totalMinutes <= 30) {
                        $overtimeHourInDecimal = 0;
                    } elseif ($totalMinutes <= 60 && $totalMinutes >= 30) {
                        $overtimeHourInDecimal = 1;
                    } elseif ($totalMinutes <= 90) {
                        $overtimeHourInDecimal = 1.5;
                    } elseif ($totalMinutes <= 120) {
                        $overtimeHourInDecimal = 2;
                    } else {
                        $overtimeHourInDecimal = floor($totalMinutes / 60) + ($totalMinutes % 60 > 30 ? 0.5 : 0);
                    }

                    if (isset($overtimeData->desc) && in_array($overtimeData->desc, ['MX'])) {
                        $overtime_hour_after_cal = $overtimeHourInDecimal * 2;
                    } else {
                        $overtime_hour_after_cal = ($overtimeHourInDecimal * 2) - 0.5;
                    }

                    if ($overtime_hour_after_cal > 0) {
                        $overtimeData->overtimeHourInDecimal = $overtimeHourInDecimal;
                        $overtimeData->overtime_hour_after_cal = $overtime_hour_after_cal;
                        $overtime_records[] = $overtimeData;
                    }

                }
            }
        } else {
            $month = $request->month;
            $date = Carbon::createFromFormat('Y-m', $month);
            $getYear = $date->year;
            $getMonth = $date->month;
            if ($dept == 'All Dept') {
                if ($status == 'All Status') {
                    $nik = SalaryYear::select('nik')->get();
                    $overtime_records = [];

                        foreach ($nik as $n) {
                            $overtimeData = DB::table('salary_months')
                                ->join('salary_years', 'salary_years.id', '=', 'salary_months.id_salary_year')
                                ->join('users', 'users.nik', '=', 'salary_years.nik')
                                ->leftJoin('test_absen_regs', 'test_absen_regs.user_id', '=', 'users.nik')
                                ->select(
                                    'users.nik',
                                    'users.name',
                                    'users.jabatan',
                                    'users.status',
                                    'users.dept',
                                    'users.overtime_limit',
                                    'salary_months.hour_call',
                                    'test_absen_regs.desc',
                                    DB::raw("SUM(test_absen_regs.overtime_hour) as toth"),
                                    DB::raw("SUM(test_absen_regs.overtime_minute) as totm"),
                                    DB::raw("(SUM(test_absen_regs.overtime_hour) + (SUM(test_absen_regs.overtime_minute) / 60)) as total_overtime_hour")
                                )
                                ->where('users.nik', $n->nik)
                                ->where('users.active', 'yes')
                                ->whereMonth('salary_months.date', $getMonth)
                                ->whereYear('salary_months.date', $getYear)
                                ->whereMonth('test_absen_regs.date', $getMonth)
                                ->whereYear('test_absen_regs.date', $getYear)
                                ->groupBy(
                                    'users.nik',
                                    'users.name',
                                    'users.jabatan',
                                    'users.status',
                                    'users.dept',
                                    'users.overtime_limit',
                                    'salary_months.hour_call',
                                    'test_absen_regs.desc',
                                )
                                ->first();

                            // dd($dept, $status, $getYear, $getMonth, $nik, $overtimeData);

                            if ($overtimeData) {
                                $totalMinutes = ($overtimeData->toth * 60) + $overtimeData->totm;

                                if ($totalMinutes <= 30) {
                                    $overtimeHourInDecimal = 0;
                                } elseif ($totalMinutes <= 60 && $totalMinutes >= 30) {
                                    $overtimeHourInDecimal = 1;
                                } elseif ($totalMinutes <= 90) {
                                    $overtimeHourInDecimal = 1.5;
                                } elseif ($totalMinutes <= 120) {
                                    $overtimeHourInDecimal = 2;
                                } else {
                                    $overtimeHourInDecimal = floor($totalMinutes / 60) + ($totalMinutes % 60 > 30 ? 0.5 : 0);
                                }

                                if (isset($overtimeData->desc) && in_array($overtimeData->desc, ['MX'])) {
                                    $overtime_hour_after_cal = $overtimeHourInDecimal * 2;
                                } else {
                                    $overtime_hour_after_cal = ($overtimeHourInDecimal * 2) - 0.5;
                                }

                                if ($overtime_hour_after_cal > 0) {
                                    $overtimeData->overtimeHourInDecimal = $overtimeHourInDecimal;
                                    $overtimeData->overtime_hour_after_cal = $overtime_hour_after_cal;
                                    $overtime_records[] = $overtimeData;
                                }
                            }
                        }

                } else {
                    $nik = SalaryYear::select('nik')->get();
                    $overtime_records = [];

                        foreach ($nik as $n) {
                            $overtimeData = DB::table('salary_months')
                                ->join('salary_years', 'salary_years.id', '=', 'salary_months.id_salary_year')
                                ->join('users', 'users.nik', '=', 'salary_years.nik')
                                ->leftJoin('test_absen_regs', 'test_absen_regs.user_id', '=', 'users.nik')
                                ->select(
                                    'users.nik',
                                    'users.name',
                                    'users.jabatan',
                                    'users.status',
                                    'users.dept',
                                    'users.overtime_limit',
                                    'salary_months.hour_call',
                                    'test_absen_regs.desc',
                                    DB::raw("SUM(test_absen_regs.overtime_hour) as toth"),
                                    DB::raw("SUM(test_absen_regs.overtime_minute) as totm"),
                                    DB::raw("(SUM(test_absen_regs.overtime_hour) + (SUM(test_absen_regs.overtime_minute) / 60)) as total_overtime_hour")
                                )
                                ->where('users.nik', $n->nik)
                                ->where('users.active', 'yes')
                                ->where('users.status', $status)
                                ->whereMonth('salary_months.date', $getMonth)
                                ->whereYear('salary_months.date', $getYear)
                                ->whereMonth('test_absen_regs.date', $getMonth)
                                ->whereYear('test_absen_regs.date', $getYear)
                                ->groupBy(
                                    'users.nik',
                                    'users.name',
                                    'users.jabatan',
                                    'users.status',
                                    'users.dept',
                                    'users.overtime_limit',
                                    'salary_months.hour_call',
                                    'test_absen_regs.desc',
                                )
                                ->first();

                            if ($overtimeData) {
                                $totalMinutes = ($overtimeData->toth * 60) + $overtimeData->totm;

                                if ($totalMinutes <= 30) {
                                    $overtimeHourInDecimal = 0;
                                } elseif ($totalMinutes <= 60 && $totalMinutes >= 30) {
                                    $overtimeHourInDecimal = 1;
                                } elseif ($totalMinutes <= 90) {
                                    $overtimeHourInDecimal = 1.5;
                                } elseif ($totalMinutes <= 120) {
                                    $overtimeHourInDecimal = 2;
                                } else {
                                    $overtimeHourInDecimal = floor($totalMinutes / 60) + ($totalMinutes % 60 > 30 ? 0.5 : 0);
                                }

                                if (isset($overtimeData->desc) && in_array($overtimeData->desc, ['MX'])) {
                                    $overtime_hour_after_cal = $overtimeHourInDecimal * 2;
                                } else {
                                    $overtime_hour_after_cal = ($overtimeHourInDecimal * 2) - 0.5;
                                }

                                if ($overtime_hour_after_cal > 0) {
                                    $overtimeData->overtimeHourInDecimal = $overtimeHourInDecimal;
                                    $overtimeData->overtime_hour_after_cal = $overtime_hour_after_cal;
                                    $overtime_records[] = $overtimeData;
                                }
                            }
                        }
                }
            } else {
                if ($status == 'All Status') {
                    $nik = SalaryYear::select('nik')->get();
                    $overtime_records = [];

                    foreach ($nik as $n) {
                        $overtimeData = DB::table('salary_months')
                            ->join('salary_years', 'salary_years.id', '=', 'salary_months.id_salary_year')
                            ->join('users', 'users.nik', '=', 'salary_years.nik')
                            ->leftJoin('test_absen_regs', 'test_absen_regs.user_id', '=', 'users.nik')
                            ->select(
                                'users.nik',
                                'users.name',
                                'users.jabatan',
                                'users.status',
                                'users.dept',
                                'users.overtime_limit',
                                'salary_months.hour_call',
                                'test_absen_regs.desc',
                                DB::raw("SUM(test_absen_regs.overtime_hour) as toth"),
                                DB::raw("SUM(test_absen_regs.overtime_minute) as totm"),
                                DB::raw("(SUM(test_absen_regs.overtime_hour) + (SUM(test_absen_regs.overtime_minute) / 60)) as total_overtime_hour")
                            )
                            ->where('users.nik', $n->nik)
                            ->where('users.active', 'yes')
                            ->where('users.dept', $dept)
                            ->whereMonth('salary_months.date', $getMonth)
                                ->whereYear('salary_months.date', $getYear)
                                ->whereMonth('test_absen_regs.date', $getMonth)
                                ->whereYear('test_absen_regs.date', $getYear)
                            ->groupBy(
                                'users.nik',
                                'users.name',
                                'users.jabatan',
                                'users.status',
                                'users.dept',
                                'users.overtime_limit',
                                'salary_months.hour_call',
                                'test_absen_regs.desc',
                            )
                            ->first();

                        if ($overtimeData) {
                            $totalMinutes = ($overtimeData->toth * 60) + $overtimeData->totm;

                            if ($totalMinutes <= 30) {
                                $overtimeHourInDecimal = 0;
                            } elseif ($totalMinutes <= 60 && $totalMinutes >= 30) {
                                $overtimeHourInDecimal = 1;
                            } elseif ($totalMinutes <= 90) {
                                $overtimeHourInDecimal = 1.5;
                            } elseif ($totalMinutes <= 120) {
                                $overtimeHourInDecimal = 2;
                            } else {
                                $overtimeHourInDecimal = floor($totalMinutes / 60) + ($totalMinutes % 60 > 30 ? 0.5 : 0);
                            }

                            if (isset($overtimeData->desc) && in_array($overtimeData->desc, ['MX'])) {
                                $overtime_hour_after_cal = $overtimeHourInDecimal * 2;
                            } else {
                                $overtime_hour_after_cal = ($overtimeHourInDecimal * 2) - 0.5;
                            }

                            if ($overtime_hour_after_cal > 0) {
                                $overtimeData->overtimeHourInDecimal = $overtimeHourInDecimal;
                                $overtimeData->overtime_hour_after_cal = $overtime_hour_after_cal;
                                $overtime_records[] = $overtimeData;
                            }
                        }
                    }
                } else {
                    if ($status == 'All Status') {
                        $nik = SalaryYear::select('nik')->get();
                        $overtime_records = [];

                        foreach ($nik as $n) {
                            $overtimeData = DB::table('salary_months')
                                ->join('salary_years', 'salary_years.id', '=', 'salary_months.id_salary_year')
                                ->join('users', 'users.nik', '=', 'salary_years.nik')
                                ->leftJoin('test_absen_regs', 'test_absen_regs.user_id', '=', 'users.nik')
                                ->select(
                                    'users.nik',
                                    'users.name',
                                    'users.jabatan',
                                    'users.status',
                                    'users.dept',
                                    'users.overtime_limit',
                                    'salary_months.hour_call',
                                    'test_absen_regs.desc',
                                    DB::raw("SUM(test_absen_regs.overtime_hour) as toth"),
                                    DB::raw("SUM(test_absen_regs.overtime_minute) as totm"),
                                    DB::raw("(SUM(test_absen_regs.overtime_hour) + (SUM(test_absen_regs.overtime_minute) / 60)) as total_overtime_hour")
                                )
                                ->where('users.nik', $n->nik)
                                ->where('users.active', 'yes')
                                ->where('users.status', $status)
                                ->where('users.dept', $dept)
                                ->where('users.dept', $dept)
                                ->whereMonth('salary_months.date', $getMonth)
                                ->whereYear('salary_months.date', $getYear)
                                ->whereMonth('test_absen_regs.date', $getMonth)
                                ->whereYear('test_absen_regs.date', $getYear)
                                ->groupBy(
                                    'users.nik',
                                    'users.name',
                                    'users.jabatan',
                                    'users.status',
                                    'users.dept',
                                    'users.overtime_limit',
                                    'salary_months.hour_call',
                                    'test_absen_regs.desc',
                                )
                                ->first();

                            if ($overtimeData) {
                                $totalMinutes = ($overtimeData->toth * 60) + $overtimeData->totm;

                                if ($totalMinutes <= 30) {
                                    $overtimeHourInDecimal = 0;
                                } elseif ($totalMinutes <= 60 && $totalMinutes >= 30) {
                                    $overtimeHourInDecimal = 1;
                                } elseif ($totalMinutes <= 90) {
                                    $overtimeHourInDecimal = 1.5;
                                } elseif ($totalMinutes <= 120) {
                                    $overtimeHourInDecimal = 2;
                                } else {
                                    $overtimeHourInDecimal = floor($totalMinutes / 60) + ($totalMinutes % 60 > 30 ? 0.5 : 0);
                                }

                                if (isset($overtimeData->desc) && in_array($overtimeData->desc, ['MX'])) {
                                    $overtime_hour_after_cal = $overtimeHourInDecimal * 2;
                                } else {
                                    $overtime_hour_after_cal = ($overtimeHourInDecimal * 2) - 0.5;
                                }

                                if ($overtime_hour_after_cal > 0) {
                                    $overtimeData->overtimeHourInDecimal = $overtimeHourInDecimal;
                                    $overtimeData->overtime_hour_after_cal = $overtime_hour_after_cal;
                                    $overtime_records[] = $overtimeData;
                                }
                            }
                        }
                }
            }
        }
    }

    return view('overtime.summary-overtime', [
        'title' => $title,
        'overtime_records' => $overtime_records,
        'getEmployeesDept' => $getEmployeesDept,
        'getEmployeesStatus' => $getEmployeesStatus,
        'jwt_token' => $jwt_token,
        'role' => $role,
        'nik_session' => $nik_session,
        'dept_session' => $dept_session,
        'jabatan' => $jabatan,
        'name' => $name
    ]);
    }

    public function summary_overtime_detail(Request $request)
    {
        $title = "Summary Overtime Individual";

        $nik =  $request->nik;

        $name = User::where('nik', $nik)->value('name');

        $jwt_token = session('jwt_token') ?? $request->jwt_token;
        $role = session('role') ?? $request->role;
        $nik_session = session('nik') ?? $request->nik;
        $dept = session('dept');
        $jabatan = session('jabatan') ?? $request->jabatan;

        $salaryData = DB::table('salary_months')
            ->join('salary_years', 'salary_years.id', '=', 'salary_months.id_salary_year')
            ->select(
                'salary_months.date'
            )
            ->where('salary_years.nik', $nik)
            ->get();
        $overtime_records = [];

        foreach ($salaryData as $date) {
            $month = Carbon::parse($date->date)->format('m');
            $yearNow = Carbon::parse($date->date)->format('Y');
            $overtimeData = DB::table('salary_months')
                ->join('salary_years', 'salary_years.id', '=', 'salary_months.id_salary_year')
                ->join('users', 'users.nik', '=', 'salary_years.nik')
                ->leftJoin('test_absen_regs', 'test_absen_regs.user_id', '=', 'users.nik')
                ->select(
                    'users.nik',
                    'users.name',
                    'users.jabatan',
                    'users.status',
                    'users.dept',
                    'users.overtime_limit',
                    'salary_months.hour_call',
                    'salary_months.date',
                    DB::raw("SUM(test_absen_regs.overtime_hour) as toth"),
                    DB::raw("SUM(test_absen_regs.overtime_minute) as totm"),
                    DB::raw("(SUM(test_absen_regs.overtime_hour) + (SUM(test_absen_regs.overtime_minute) / 60)) as total_overtime_hour")
                )
                ->where('users.nik', $nik)
                ->where('salary_months.date', $date->date)
                ->whereMonth('test_absen_regs.date', $month)
                ->whereYear('test_absen_regs.date', $yearNow)
                ->groupBy(
                    'users.nik',
                    'users.name',
                    'users.jabatan',
                    'users.status',
                    'users.dept',
                    'users.overtime_limit',
                    'salary_months.hour_call',
                    'salary_months.date'
                )
                ->first();

            if ($overtimeData) {
                $totalMinutes = ($overtimeData->toth * 60) + $overtimeData->totm;

                if ($totalMinutes <= 30) {
                    $overtimeHourInDecimal = 0;
                } elseif ($totalMinutes <= 60 && $totalMinutes >= 30) {
                    $overtimeHourInDecimal = 1;
                } elseif ($totalMinutes <= 90) {
                    $overtimeHourInDecimal = 1.5;
                } elseif ($totalMinutes <= 120) {
                    $overtimeHourInDecimal = 2;
                } else {
                    $overtimeHourInDecimal = floor($totalMinutes / 60) + ($totalMinutes % 60 > 30 ? 0.5 : 0);
                }

                // $overtimeData->overtimeHourInDecimal = $overtimeHourInDecimal;

                // $overtime_records[] = $overtimeData;

                if (isset($overtimeData->desc) && in_array($overtimeData->desc, ['MX'])) {
                    $overtime_hour_after_cal = $overtimeHourInDecimal * 2;
                } else {
                    $overtime_hour_after_cal = ($overtimeHourInDecimal * 2) - 0.5;
                }

                // Hanya tambahkan jika overtime_hour_after_cal > 0
                if ($overtime_hour_after_cal > 0) {
                    $overtimeData->overtimeHourInDecimal = $overtimeHourInDecimal;
                    $overtimeData->overtime_hour_after_cal = $overtime_hour_after_cal;
                    $overtime_records[] = $overtimeData;
                }
            }
        }

        return view('overtime.summary-overtime-detail', [
            'title' => $title,
            'overtime_records' => $overtime_records,
            'nik' => $nik,
            'name' => $name,
            'jwt_token' => $jwt_token,
            'role' => $role,
            'nik_session' => $nik_session,
            'dept' => $dept,
            'jabatan' => $jabatan,
        ]);
    }

}
