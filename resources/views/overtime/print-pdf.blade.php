<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>OT_{{ date('My', strtotime($sal->overtime_date)) }}_{{ $sal->nik }}_{{ $sal->name }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f8f9fa;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        table:first-of-type {
            margin-bottom: 10px;
        }

        table th,
        table td {
            padding: 12px 15px;
        }

        table th {
            background-color: #007bff;
            color: white;
            font-size: 14px;
            text-align: center;
        }

        table td {
            font-size: 13px;
            text-align: center;
        }

        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        table tr:hover {
            background-color: #e9ecef;
        }

        table tr td:first-child {
            font-weight: bold;
        }

        caption {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 8px;
        }
    </style>
</head>

<body>
    <table>
        <caption>Employee Details</caption>
        <tr>
            <td style="text-align: left">Employee Code</td>
            <td style="text-align: left">: {{ $sal->nik }}</td>
        </tr>
        <tr>
            <td style="text-align: left">Employee Name</td>
            <td style="text-align: left">: {{ $sal->name }}</td>
        </tr>
        <tr>
            <td style="text-align: left">Grade</td>
            <td style="text-align: left">: {{ $sal->grade }}</td>
        </tr>
        <tr>
            <td style="text-align: left">Department</td>
            <td style="text-align: left">: {{ $sal->dept }}</td>
        </tr>
        <tr>
            <td style="text-align: left">Job</td>
            <td style="text-align: left">: {{ $sal->jabatan }}</td>
        </tr>
        <tr>
            <td style="text-align: left">Status</td>
            <td style="text-align: left">: {{ $sal->status }}</td>
        </tr>
    </table>

    <table>
        <caption>Overtime Details</caption>
        <tr>
            <th>No</th>
            <th>Date</th>
            <th>Overtime (Original)</th>
            <th>Overtime (Adjustment)</th>
        </tr>
        @foreach ($data as $index => $ot)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ date('d-m-Y', strtotime($ot->overtime_date)) }}</td>
                <td>{{ $ot->overtime_ori }} h</td>
                <td>{{ $ot->overtime_adj }} h</td>
            </tr>
        @endforeach
    </table>
</body>

</html>
