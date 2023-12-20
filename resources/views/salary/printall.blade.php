<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print All</title>


    <!-- CSS Files -->
    {{-- <link id="pagestyle" href="{{ public_path ('assets/libs/bootstrap5/css/bootstrap.min.css') }}" rel="stylesheet" /> --}}
    <style>
        * {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 9pt;
        }

        .tb-style th, td{
            border: 1px solid #000;
            border-collapse: collapse;
            width: 100%;
            font-size: 5pt;
        }

        .tb-detail {
            border-collapse: collapse;
            width: 100%;
            font-size: 9pt;
        }

        .tb-detail th,
        .tb-detail td {
            border: none;
            width: auto;
        }

        .right-border {
            border-top: 1px solid #000;
        }

        .left-border {
            border-top: 1px solid #000;
        }

        .buttom-border {
            border-top: 1px solid #000;
        }

        .top-border {
            border-top: 1px solid #000;
        }

        .dash-line {
            border: none;
            border-top: 2px dashed #888;
        }

        .table-collapse table,
        th,
        td {
            width: 100%;
            border: 1px none #000;
            border-collapse: collapse;
        }

        .outline-border {
            border: 1px solid black;
            padding: 8px;
        }

        .uppercase {
            text-transform: uppercase;
        }

        .text-end {
            text-align: right;
        }
    </style>
</head>

<body>
    <div class="table-collapse">
        <table>
            <tr>
                <td>PT BRIDGESTONE KALIMANTAN PLANTATION</td>
                <td></td>
            </tr>
            <tr>
                <td>Bentok Darat, Bati-Bati, Kab.Tanah Laut</td>
                <td align="right" class="uppercase">SALARY PAYMENT</td>
            </tr>
            <tr>
                <td> <u>Kalimantan Selatan - 70852</u></td>
                <td></td>
            </tr>
        </table>
    </div>

    <hr class="dash-line">
    <table class="tb-style">
    
            <tr>
                <th>NIK</th>
                <th>Name</th>
                <th>Dept</th>
                <th>Status</th>
                <th>Grade</th>
                <th>Job</th>
                <th>No Account</th>
                <th>Salary Grade</th>
                <th>Ability</th>
                <th>Fungtional Allowance</th>
                <th>Family Allowance</th>
                <th>Adjustment</th>
                <th>Transport Allowance</th>
                <th>Total Overtime</th>
                <th>THR</th>
                <th>Bonus</th>
                <th>Incentive</th>
                <th>Salary Gross</th>
                <th>BPJS Kesehatan</th>
                <th>Jamsostek</th>
                <th>Union</th>
                <th>Absent</th>
                <th>Electricity</th>
                <th>Koperasi</th>
                <th>Sub Total Deduction</th>
            </tr>   
        
    </table>
</body>

</html>
