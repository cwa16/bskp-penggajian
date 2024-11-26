<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 5px;
            background-color: #f9f9f9;
        }

        table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        th,
        td {
            padding: 5px;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f4f4f4;
            font-weight: bold;
        }

        .employee-details table,
        .employee-details th,
        .employee-details td {
            text-align: left;
            /* Teks rata kiri untuk tabel Employee Details */
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tbody tr:hover {
            background-color: #f1f1f1;
        }

        tfoot td {
            font-weight: bold;
            background-color: #f4f4f4;
        }

        h1,
        h2 {
            text-align: center;
            color: #333;
        }

        @media (max-width: 768px) {
            table {
                font-size: 12px;
            }

            th,
            td {
                padding: 5px;
            }
        }
    </style>
</head>

<body>
    <h1>Employee Details</h1>
    <table class="employee-details">
        <tr>
            <th>NIK</th>
            <th style="text-align: center">:</th>
            <td>{{ $sal->nik }}</td>
            <th>Name</th>
            <th style="text-align: center">:</th>
            <td>{{ $sal->name }}</td>
        </tr>
        <tr>
            <th>Grade</th>
            <th style="text-align: center">:</th>
            <td>{{ $sal->grade }}</td>
            <th>Department</th>
            <th style="text-align: center">:</th>
            <td>{{ $sal->dept }}</td>
        </tr>
        <tr>
            <th>Job</th>
            <th style="text-align: center">:</th>
            <td>{{ $sal->jabatan }}</td>
            <th>Status</th>
            <th style="text-align: center">:</th>
            <td>{{ $sal->status }}</td>
        </tr>
    </table>

    <h2>Overtime Details</h2>
    <table>
        <thead>
            <tr>
                <th rowspan="2">No</th>
                <th colspan="2">Date</th>
                <th colspan="3">Overtime</th>
            </tr>
            <tr>
                <th>Day</th>
                <th>Date</th>
                <th>Original</th>
                <th>Adjustment</th>
                <th>Call</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $days = [
                'Sunday' => 'Minggu',
                'Monday' => 'Senin',
                'Tuesday' => 'Selasa',
                'Wednesday' => 'Rabu',
                'Thursday' => 'Kamis',
                'Friday' => 'Jumat',
                'Saturday' => 'Sabtu',
            ];
            ?>
            @foreach ($data as $index => $ot)
                <tr>
                    <td style="text-align: center">{{ $index + 1 }}</td>
                    {{-- <td>{{ date('l', strtotime($ot->overtime_date)) }}</td> --}}
                    <td>{{ $days[date('l', strtotime($ot->overtime_date))] }}</td>
                    <td>{{ date('d-m-Y', strtotime($ot->overtime_date)) }}</td>
                    <td style="text-align: center">{{ $ot->overtime_ori }} h</td>
                    <td style="text-align: center">{{ $ot->overtime_adj }} h</td>
                    <td style="text-align: center">{{ $ot->hour_call }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" style="text-align: center">Total</td>
                <td style="text-align: center">{{ $totalOverimeOri }} h</td>
                <td style="text-align: center">{{ $totalOverimeAdj }} h</td>
                <td style="text-align: center">{{ $totalHourCall }}</td>
            </tr>
        </tfoot>
    </table>

    <script type="text/php">
        if ( isset($pdf) ) {
            $x = 300;
            $y = 820;
            $text = "{PAGE_NUM} of {PAGE_COUNT}";
            $font = $fontMetrics->get_font("helvetica");
            $size = 10;
            $color = array(0,0,0);
            $word_space = 0.0;  //  default
            $char_space = 0.0;  //  default
            $angle = 0.0;   //  default
            $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
        }
    </script>
</body>

</html>
