<?php

namespace App\Http\Controllers;

use App\Models\SalaryMonth;
use App\Models\Status;
use App\Models\SalaryYear;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use PDF;
use Twilio\Rest\Client;
use WaAPI\WaAPI;

class SalaryController extends Controller
{
    public function index()
    {
        $title = 'Salary';

        $data = DB::table('salary_months')
            ->join('salary_years', 'salary_years.id', '=', 'salary_months.id_salary_year')
            ->join('salary_grades', 'salary_grades.id', '=', 'salary_years.id_salary_grade')
            ->join('users', 'users.id', '=', 'salary_years.id_user')
            ->join('statuses', 'users.id_status', '=', 'statuses.id')
            ->join('depts', 'users.id_dept', '=', 'depts.id')
            ->join('jobs', 'users.id_job', '=', 'jobs.id')
            ->join('grades', 'users.id_grade', '=', 'grades.id')
            ->select('salary_months.*', 'salary_years.*', 'salary_grades.*', 'users.*', 'statuses.*', 'depts.*', 'jobs.*', 'grades.*')
            ->get();

        $salary_months = SalaryMonth::all();

        $years = SalaryMonth::distinct('date')->pluck('date')->map(function ($date) {
            return Carbon::parse($date)->format('Y');
        })->unique()->toArray();
        $months = SalaryMonth::distinct('date')->pluck('date')->map(function ($date) {
            $carbonDate = Carbon::parse($date);
            return [
                'value' => $carbonDate->format('m'),
                'label' => $carbonDate->format('F'),
            ];
        })->unique()->toArray();

        $statuses = Status::distinct('name_status')->pluck('name_status')->toArray();

        $query = SalaryMonth::with('salary_year');

        $selectedYear =  null;
        $selectedMonth = null;
        $selectedStatus = null;

        if (request('filter_status') != null) {
            if (request('filter_status') != 'all') {
                $selectedStatus = request('filter_status');
                $query->whereHas('salary_year.user.status', function ($subquery) use ($selectedStatus) {
                    $subquery->where('name_status', $selectedStatus);
                });
            }
        }

        if (request('filter_year') != null) {
            if (request('filter_year') != 'all') {
                $selectedYear = request('filter_year');
                $query->whereYear('date', $selectedYear);
            }
        } else {
            $selectedYear = request('filter_year', Carbon::now()->year);
            $query->whereYear('date', $selectedYear);
        }

        if (request('filter_month') != null) {
            if (request('filter_month') != 'all') {
                $selectedMonth = request('filter_month');
                $query->wheremonth('date', $selectedMonth);
            }
        } else {
            $selectedMonth = request('filter_month', Carbon::now()->month);
            $query->whereMonth('date', $selectedMonth);
        }

        $salary_months = $query->get();

        return view('salary.index', compact(
            'title', 'statuses', 'years', 'months', 'salary_months', 'selectedStatus', 'selectedYear', 'selectedMonth', 'data'
        ));
    }

    public function print($id)
    {
        $sal = SalaryMonth::find($id);

        $date = date('My', strtotime($sal->date));

        if (!$sal) {
            dd("Salary with ID $id not found.");
        }

        $rate_salary = $sal->salary_year->salary_grade->rate_salary;
        $ability = $sal->salary_year->ability;
        $fungtional_alw = $sal->salary_year->fungtional_alw;
        $family_alw = $sal->salary_year->family_alw;

        $total = $rate_salary + $ability + $fungtional_alw + $family_alw;

        $pdf = PDF::loadView('salary.print', compact('sal', 'total'));
        return $pdf->setPaper('a4', 'landscape')->stream('SAL_' . $date . '_' . $sal->salary_year->user->nik . '_' . $sal->salary_year->user->name . '.pdf');
    }

    public function send($id)
    {
        // $sal = SalaryMonth::find($id);

        // // mengambeil date
        // $date = date('My', strtotime($sal->date));

        // if (!$sal) {
        //     // Log or dd() the ID to see which ID is causing the issue.
        //     dd("Salary with ID $id not found.");
        // }

        // // hitungan utuk mendapatkan total gaji bersih
        // $rate_salary = $sal->salary_year->salary_grade->rate_salary;
        // $ability = $sal->salary_year->ability;
        // $fungtional_alw = $sal->salary_year->fungtional_alw;
        // $family_alw = $sal->salary_year->family_alw;

        // $total = $rate_salary + $ability + $fungtional_alw + $family_alw;

        // $pdf = PDF::loadView('salary.print', compact('sal', 'total'))->setPaper('a5', 'landscape');

        // $fileName = 'SAL_' . $date . '_' . $sal->salary_year->user->nik . '_' . $sal->salary_year->user->name . '.pdf';

        // $mediaUrl = asset('slip_gaji/SAL_Jun24_199-073_Sulastri.pdf');

        // // dd($mediaUrl);

        // $waAPI = new WaAPI\WaAPI();
        // $waAPI->sendMediaFromUrl('6287878998251@c.us', 'file:///C:/laragon/www/bskp-penggajian/public/slip_gaji/SAL_Jun24_199-073_Sulastri.pdf', 'slip gaji', 'bskp-penggajian.pdf');
        // // $waAPI->fetchMessages('6287878998251@c.us', '25', null, null, null );

        // // return $pdf->setPaper('a5', 'landscape')->stream('SAL_' . $date . '_' . $sal->salary_year->user->nik . '_' . $sal->salary_year->user->name . '.pdf');
        // $product = \App\Product::findOrFail($id);
        // $user = User::find(1); // replace this with the authenticated user

        // $data = [
        //     'product' => $product,
        //     'user' => $user
        // ];

        $invoiceFile = "SAL_Jun24_199-073_Sulastri.pdf";
        $invoicePath = public_path("slip_gaji/".$invoiceFile);

        $phoneNumber = +6287878998251;

        // $sid = env('TWILIO_AUTH_SID');
        // $auth = env('TWILIO_AUTH_TOKEN');

        // dd($sid, $auth);

        // PDF::loadView('invoice', $data)->save($invoicePath);
        $twilio = new Client(env('TWILIO_AUTH_SID'), env('TWILIO_AUTH_TOKEN'));

        $twilio->messages->create(
                "whatsapp:+6287878998251", [
                "from" => "whatsapp:".env('TWILIO_WHATSAPP_FROM'),
                "body" => "Here's your invoice!",
                "mediaUrl" => [env("NGROK_URL")."slip_gaji/".$invoiceFile]
            ]
        );

        return redirect()->back();
    }

    public function download($id)
    {
        $sal = SalaryMonth::find($id);

        $date = date('My', strtotime($sal->date));

        if (!$sal) {
            dd("Salary with ID $id not found.");
        }

        $rate_salary = $sal->salary_year->salary_grade->rate_salary;
        $ability = $sal->salary_year->ability;
        $fungtional_alw = $sal->salary_year->fungtional_alw;
        $family_alw = $sal->salary_year->family_alw;

        $total = $rate_salary + $ability + $fungtional_alw + $family_alw;

        $pdf = PDF::loadView('salary.print', compact('sal', 'total'));
        return $pdf->setPaper('a5', 'landscape')->download('SAL_' . $date . '_'  . $sal->salary_year->user->nik . '_' . $sal->salary_year->user->name . '.pdf');
    }

    public function printall()
    {
        $monthOpts = SalaryMonth::select(DB::raw('MONTH(date) as month'))
            ->distinct()
            ->pluck('month');

        $yearOpts = SalaryMonth::select(DB::raw('YEAR(date) as year'))
            ->distinct()
            ->pluck('year');

        $year = request()->input('year');
        $month = request()->input('month');

        $salaries = SalaryMonth::with(['salary_year.user.status'])
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->get();

        $salByStatus = $salaries->groupBy('salary_year.user.status.name_status');

        $date = null;
        foreach ($salaries as $sal) {
            $date = date('F Y', strtotime($sal->date));
        }

        if ($date) {
            $pdf = PDF::loadView('salary.printall', compact('salByStatus', 'date'));
            return $pdf->setPaper(array(0, 0, 609.4488, 935.433), 'landscape')->stream('PrintAll.pdf');
        } else {
            return redirect()->route('salary.index');
        }
    }

    public function printallocation()
    {
        // $monthOpts = SalaryMonth::select(DB::raw('MONTH(date) as month'))
        //     ->distinct()
        //     ->pluck('month');

        // $yearOpts = SalaryMonth::select(DB::raw('YEAR(date) as year'))
        //     ->distinct()
        //     ->pluck('year');

        // $year = request()->input('year');
        // $month = request()->input('month');

        // $sal_allocation = SalaryMonth::with('salary_year')
        //     ->whereYear('date', $year)
        //     ->whereMonth('date', $month)
        //     ->get();

        // $data = [];
        // foreach ($sal_allocation as $item) {
        //     $allocations = json_decode($item->allocation);
        //     if ($allocations) {
        //         foreach ($allocations as $div) {
        //             $data[$div]['allocation'][] = $div;
        //             $data[$div]['rate_salary'][] = $item->salary_year->salary_grade->rate_salary;
        //             $data[$div]['ability'][] = $item->salary_year->ability;
        //             $data[$div]['fungtional_alw'][] = $item->salary_year->fungtional_alw;
        //             $data[$div]['family_alw'][] = $item->salary_year->family_alw;
        //             $data[$div]['transport_alw'][] = $item->salary_year->transport_alw;
        //             $data[$div]['adjustment'][] = $item->salary_year->adjustment;
        //             $data[$div]['bpjs'][] = $item->salary_year->bpjs;
        //             $data[$div]['jamsostek'][] = $item->salary_year->jamsostek;
        //             $data[$div]['total_ben'][] = $item->salary_year->total_ben;
        //             $data[$div]['total_ben_ded'][] = $item->salary_year->total_ben_ded;
        //             $data[$div]['total_overtime'][] = $item->total_overtime;
        //             $data[$div]['thr'][] = $item->thr;
        //             $data[$div]['bonus'][] = $item->bonus;
        //             $data[$div]['incentive'][] = $item->incentive;
        //             $data[$div]['union'][] = $item->union;
        //             $data[$div]['absent'][] = $item->absent;
        //             $data[$div]['electricity'][] = $item->electricity;
        //             $data[$div]['cooperative'][] = $item->cooperative;
        //             $data[$div]['gross_salary'][] = $item->gross_salary;
        //             $data[$div]['total_deduction'][] = $item->total_deduction;
        //             $data[$div]['net_salary'][] = $item->net_salary;
        //         }
        //     } else {
        //         return redirect()->route('salary.index');
        //     }
        // }

        // $finalResult = [];

        // foreach ($data as $div => $values) {
        //     $finalResult[] = [
        //         'allocation' => $div,
        //         'rate_salary' => array_sum($values['rate_salary']),
        //         'ability' => array_sum($values['ability']),
        //         'fungtional_alw' => array_sum($values['fungtional_alw']),
        //         'family_alw' => array_sum($values['family_alw']),
        //         'transport_alw' => array_sum($values['transport_alw']),
        //         'adjustment' => array_sum($values['adjustment']),
        //         'bpjs' => array_sum($values['bpjs']),
        //         'jamsostek' => array_sum($values['jamsostek']),
        //         'total_ben' => array_sum($values['total_ben']),
        //         'total_ben_ded' => array_sum($values['total_ben_ded']),
        //         'total_overtime' => array_sum($values['total_overtime']),
        //         'thr' => array_sum($values['thr']),
        //         'bonus' => array_sum($values['bonus']),
        //         'incentive' => array_sum($values['incentive']),
        //         'union' => array_sum($values['union']),
        //         'absent' => array_sum($values['absent']),
        //         'electricity' => array_sum($values['electricity']),
        //         'cooperative' => array_sum($values['cooperative']),
        //         'gross_salary' => array_sum($values['gross_salary']),
        //         'total_deduction' => array_sum($values['total_deduction']),
        //         'net_salary' => array_sum($values['net_salary']),
        //     ];
        // }

        // // At the end of the displayTable method
        // $grandTotal = [
        //     'rate_salary' => 0,
        //     'ability' => 0,
        //     'fungtional_alw' => 0,
        //     'family_alw' => 0,
        //     'transport_alw' => 0,
        //     'adjustment' => 0,
        //     'bpjs' => 0,
        //     'jamsostek' => 0,
        //     'total_ben' => 0,
        //     'total_ben_ded' => 0,
        //     'total_overtime' => 0,
        //     'thr' => 0,
        //     'bonus' => 0,
        //     'incentive' => 0,
        //     'union' => 0,
        //     'absent' => 0,
        //     'electricity' => 0,
        //     'cooperative' => 0,
        //     'gross_salary' => 0,
        //     'total_deduction' => 0,
        //     'net_salary' => 0,
        // ];

        // if (!empty($finalResult)) {
        //     $grandTotal = [
        //         'rate_salary' =>  array_sum(array_column($finalResult, 'rate_salary')),
        //         'ability' => array_sum(array_column($finalResult, 'ability')),
        //         'fungtional_alw' => array_sum(array_column($finalResult, 'fungtional_alw')),
        //         'family_alw' => array_sum(array_column($finalResult, 'family_alw')),
        //         'transport_alw' => array_sum(array_column($finalResult, 'transport_alw')),
        //         'adjustment' => array_sum(array_column($finalResult, 'adjustment')),
        //         'bpjs' => array_sum(array_column($finalResult, 'bpjs')),
        //         'jamsostek' => array_sum(array_column($finalResult, 'jamsostek')),
        //         'total_ben' => array_sum(array_column($finalResult, 'total_ben')),
        //         'total_ben_ded' => array_sum(array_column($finalResult, 'total_ben_ded')),
        //         'total_overtime' => array_sum(array_column($finalResult, 'total_overtime')),
        //         'thr' => array_sum(array_column($finalResult, 'thr')),
        //         'bonus' => array_sum(array_column($finalResult, 'bonus')),
        //         'incentive' => array_sum(array_column($finalResult, 'incentive')),
        //         'union' => array_sum(array_column($finalResult, 'union')),
        //         'absent' => array_sum(array_column($finalResult, 'absent')),
        //         'electricity' => array_sum(array_column($finalResult, 'electricity')),
        //         'cooperative' => array_sum(array_column($finalResult, 'cooperative')),
        //         'gross_salary' => array_sum(array_column($finalResult, 'gross_salary')),
        //         'total_deduction' => array_sum(array_column($finalResult, 'total_deduction')),
        //         'net_salary' => array_sum(array_column($finalResult, 'net_salary')),
        //     ];
        // }

        // $date = null;
        // foreach ($sal_allocation as $sal) {
        //     $date = date('F Y', strtotime($sal->date));
        // }

        // if ($date) {
        //     $pdf = PDF::loadView('salary.printallocation', compact('sal_allocation', 'date', 'finalResult', 'grandTotal'));
        //     return $pdf->setPaper('a4', 'landscape')->stream('PrintAllocation' . $date . '.pdf');
        // } else {
        //     return redirect()->route('salary.index');
        // }

        $pdf = PDF::loadView('salary.printallocation_new');
        return $pdf->setPaper(array(0, 0, 609.4488, 935.433), 'landscape')->stream('PrintAllocation.pdf');
    }

    public function summary()
    {
        $title = 'Summary';
        $emp = User::orderBy('name', 'asc')->get();
        $years = SalaryYear::distinct('year')->pluck('year')->toArray();

        return view ('salary.summary', compact('title', 'emp', 'years'));
    }

    public function result()
    {
        $title = 'Summary';
        $empFilter = request()->input('id_user', null);
        $yearFilter = request()->input('year', null);

        $data = DB::table('salary_months')
            ->join('salary_years', 'salary_years.id', '=', 'salary_months.id_salary_year')
            ->join('salary_grades', 'salary_grades.id', '=', 'salary_years.id_salary_grade')
            ->join('users', 'users.id', '=', 'salary_years.id_user')
            ->join('statuses', 'users.id_status', '=', 'statuses.id')
            ->join('depts', 'users.id_dept', '=', 'depts.id')
            ->join('jobs', 'users.id_job', '=', 'jobs.id')
            ->join('grades', 'users.id_grade', '=', 'grades.id')
            ->select('salary_months.*', 'salary_years.*', 'salary_grades.*', 'users.*', 'statuses.*', 'depts.*', 'jobs.*', 'grades.*')
            ->where('users.id', $empFilter)
            ->get();

        $name = User::where('id', $empFilter)->select('nik','name')->first();

        return view('salary.result', compact('title', 'empFilter', 'yearFilter', 'data', 'name'));
    }
}
