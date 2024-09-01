<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use App\Models\User;
use DB;

class OvertimeController extends Controller
{
    public function index()
    {
        $title = 'Individual Overtime Approval';

        // $response = Http::get('http://192.168.99.202/absen/public/api/testing-absen');
        $response = Http::get('http://attendance_management-22-may-24.test/api/testing-absen');

        if ($response->successful()) {
            $data = $response->json();
            $tanggalHariIni = Carbon::today()->subDay()->format('Y-m-d');

            // Filter data yang sesuai dengan tanggal hari ini
            $dataHariIni = collect($data)->filter(function ($item) use ($tanggalHariIni) {
                return isset($item['date']) && $item['date'] === $tanggalHariIni;
            });

            if ($dataHariIni->isEmpty()) {
                return response()->json(['message' => 'Tidak ada data untuk hari ini'], 404);
            } else {
                // Ambil data user yang cocok dari database menggunakan Query Builder
                $userIds = $dataHariIni->pluck('user_id')->toArray();
                $users = DB::table('new_users')
                            ->join('users', 'users.nik', '=', 'new_users.nik')
                            ->join('salary_years', 'salary_years.id_user', '=', 'users.id')
                            ->join('salary_grades', 'salary_grades.id', '=', 'salary_years.id_salary_grade')
                            ->join('statuses', 'new_users.id_status', '=', 'statuses.id')
                            ->join('depts', 'new_users.id_dept', '=', 'depts.id')
                            ->join('jobs', 'new_users.id_job', '=', 'jobs.id')
                            ->join('grades', 'new_users.id_grade', '=', 'grades.id')
                            ->select('new_users.nik', 'new_users.name', 'statuses.name_status', 'depts.name_dept', 'jobs.name_job', 'salary_years.ability', 'salary_grades.rate_salary')
                            ->whereIn('new_users.nik', $userIds)
                            ->get();

                // Gabungkan data API dengan data dari database
                $dataGabungan = $dataHariIni->map(function ($item) use ($users) {
                    $user = $users->firstWhere('nik', $item['user_id']);
                    if ($user) {
                        $item['user_data'] = (array) $user;
                        // Pengecekan nilai desc dan operasi pada overtime_hour
                        if (isset($item['desc']) && in_array($item['desc'], ['MX'])) {
                            // Jika desc bernilai M atau MX, kalikan overtime_hour dengan 2
                            $item['overtime_hour'] = $item['overtime_hour'] * 2;
                        } else {
                            // Jika desc bernilai selain M atau MX, kalikan overtime_hour dengan 2 dan kurangi setengah
                            $item['overtime_hour'] = ($item['overtime_hour'] * 2) - 0.5;
                        }
                    }
                    return $item;
                });

                // dd($dataGabungan);

                $dataGabunganGrouped = $dataGabungan->groupBy('user_data.name_status');
                // dd($dataGabunganGrouped);

                $order = ['Manager', 'Staff', 'Monthly', 'Regular', 'Contract FL', 'Contract BSKP'];
                $dataGabunganGrouped = $dataGabunganGrouped->sortBy(function($items, $status) use ($order) {
                    return array_search($status, $order);
                });

                return view('overtime.index', [
                    'title' => $title,
                    'dataGabunganGrouped' => $dataGabunganGrouped,
                    'tanggalHariIni' => $tanggalHariIni
                ]);
            }
        }

        // Jika API gagal, tetap kembalikan view dengan judul
        return view('overtime.index', [
            'title' => $title
        ]);
    }

}
