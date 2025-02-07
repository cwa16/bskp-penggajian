<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print Allocation</title>
    <style>
        @font-face {
            font-family: 'arial-narrow';
            src: local('arial-narrow'), url('{{ asset('fonts/arial-narrow.tff') }}') format('tff');
            font-weight: normal;
            font-style: normal;
        }

        body {
            font-family: 'arial-narrow', sans-serif;
            /* margin: 20px; */
        }

        h1 {
            font-size: 14px;
            text-align: left;
            margin-bottom: 10px;
            font-family: 'arial-narrow', sans-serif;
        }

        h2 {
            font-size: 12px;
            text-align: left;
            margin-bottom: -5px;
            font-family: 'arial-narrow', sans-serif;
        }

        h3 {
            font-size: 12px;
            text-align: left;
            font-family: 'arial-narrow', sans-serif;
            margin-bottom: 3px;
            text-decoration: underline;
        }

        table {
            font-size: 10px;
            width: 100%;
            border-collapse: collapse;
        }

        th {
            border: 1px solid black;
        }

        table,
        td {
            /* padding-right: 3px; */
            /* padding-left: 3px; */
            border: 1px solid black;
        }

        /* th, td {
            padding: 3px;
            text-align: left;
        }
        th {
            text-align: center;
            background-color: #f2f2f2;
        }
        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tfoot td {
            font-weight: bold;
            background-color: #f2f2f2;
        }
        th:nth-child(2), td:nth-child(2) {
            width: 110px;
        } */
    </style>
</head>

<body>
    @php
        // Sub Div A
        $totalPersonA =
            1 / $getAllocationDir->allocation_count +
            1 / $getAllocationMngDiv1->allocation_count +
            1 / $getAllocationAsstMngA->allocation_count +
            1 / $getAllocationAsstUtilityA->allocation_count;
        $gradeA =
            $getAllocationDir->rate_salary / $getAllocationDir->allocation_count +
            $getAllocationMngDiv1->rate_salary / $getAllocationMngDiv1->allocation_count +
            $getAllocationAsstMngA->rate_salary / $getAllocationAsstMngA->allocation_count +
            $getAllocationAsstUtilityA->rate_salary / $getAllocationAsstUtilityA->allocation_count;
        $abilityA =
            $getAllocationDir->ability / $getAllocationDir->allocation_count +
            $getAllocationMngDiv1->ability / $getAllocationMngDiv1->allocation_count +
            $getAllocationAsstMngA->ability / $getAllocationAsstMngA->allocation_count +
            $getAllocationAsstUtilityA->ability / $getAllocationAsstUtilityA->allocation_count;
        $fungtionalAlwA =
            $getAllocationDir->fungtional_alw / $getAllocationDir->allocation_count +
            $getAllocationMngDiv1->fungtional_alw / $getAllocationMngDiv1->allocation_count +
            $getAllocationAsstMngA->fungtional_alw / $getAllocationAsstMngA->allocation_count +
            $getAllocationAsstUtilityA->fungtional_alw / $getAllocationAsstUtilityA->allocation_count;
        $familyAlwA =
            $getAllocationDir->family_alw / $getAllocationDir->allocation_count +
            $getAllocationMngDiv1->family_alw / $getAllocationMngDiv1->allocation_count +
            $getAllocationAsstMngA->family_alw / $getAllocationAsstMngA->allocation_count +
            $getAllocationAsstUtilityA->family_alw / $getAllocationAsstUtilityA->allocation_count;
        $telpAwlA =
            $getAllocationDir->telephone_alw / $getAllocationDir->allocation_count +
            $getAllocationMngDiv1->telephone_alw / $getAllocationMngDiv1->allocation_count +
            $getAllocationAsstMngA->telephone_alw / $getAllocationAsstMngA->allocation_count +
            $getAllocationAsstUtilityA->telephone_alw / $getAllocationAsstUtilityA->allocation_count;
        $vehicleAlwA =
            $getAllocationDir->transport_alw / $getAllocationDir->allocation_count +
            $getAllocationMngDiv1->transport_alw / $getAllocationMngDiv1->allocation_count +
            $getAllocationAsstMngA->transport_alw / $getAllocationAsstMngA->allocation_count +
            $getAllocationAsstUtilityA->transport_alw / $getAllocationAsstUtilityA->allocation_count;
        $otA =
            $getAllocationDir->total_overtime / $getAllocationDir->allocation_count +
            $getAllocationMngDiv1->total_overtime / $getAllocationMngDiv1->allocation_count +
            $getAllocationAsstMngA->total_overtime / $getAllocationAsstMngA->allocation_count +
            $getAllocationAsstUtilityA->total_overtime / $getAllocationAsstUtilityA->allocation_count;
        $loanA =
            $getAllocationDir->pinjaman / $getAllocationDir->allocation_count +
            $getAllocationMngDiv1->pinjaman / $getAllocationMngDiv1->allocation_count +
            $getAllocationAsstMngA->pinjaman / $getAllocationAsstMngA->allocation_count +
            $getAllocationAsstUtilityA->pinjaman / $getAllocationAsstUtilityA->allocation_count;
        $astekA =
            $getAllocationDir->jamsostek / $getAllocationDir->allocation_count +
            $getAllocationMngDiv1->jamsostek / $getAllocationMngDiv1->allocation_count +
            $getAllocationAsstMngA->jamsostek / $getAllocationAsstMngA->allocation_count +
            $getAllocationAsstUtilityA->jamsostek / $getAllocationAsstUtilityA->allocation_count;
        $bpjsA =
            $getAllocationDir->bpjs / $getAllocationDir->allocation_count +
            $getAllocationMngDiv1->bpjs / $getAllocationMngDiv1->allocation_count +
            $getAllocationAsstMngA->bpjs / $getAllocationAsstMngA->allocation_count +
            $getAllocationAsstUtilityA->bpjs / $getAllocationAsstUtilityA->allocation_count;
        $electricityA =
            $getAllocationDir->electricity / $getAllocationDir->allocation_count +
            $getAllocationMngDiv1->electricity / $getAllocationMngDiv1->allocation_count +
            $getAllocationAsstMngA->electricity / $getAllocationAsstMngA->allocation_count +
            $getAllocationAsstUtilityA->electricity / $getAllocationAsstUtilityA->allocation_count;
        $totalBrutoSalaryA = $gradeA + $abilityA + $fungtionalAlwA + $familyAlwA + $telpAwlA + $vehicleAlwA + $otA;
        $totalDeductionA = $loanA + $astekA + $bpjsA + $electricityA;
        $totalSalaryNettoA = $totalBrutoSalaryA - $totalDeductionA;

        // Sub Div B
        $totalPersonB =
            1 / $getAllocationDir->allocation_count +
            1 / $getAllocationMngDiv1->allocation_count +
            1 / $getAllocationAsstMngB->allocation_count +
            1 / $getAllocationAsstUtilityB->allocation_count;
        $gradeB =
            $getAllocationDir->rate_salary / $getAllocationDir->allocation_count +
            $getAllocationMngDiv1->rate_salary / $getAllocationMngDiv1->allocation_count +
            $getAllocationAsstMngB->rate_salary / $getAllocationAsstMngB->allocation_count +
            $getAllocationAsstUtilityB->rate_salary / $getAllocationAsstUtilityB->allocation_count;
        $abilityB =
            $getAllocationDir->ability / $getAllocationDir->allocation_count +
            $getAllocationMngDiv1->ability / $getAllocationMngDiv1->allocation_count +
            $getAllocationAsstMngB->ability / $getAllocationAsstMngB->allocation_count +
            $getAllocationAsstUtilityB->ability / $getAllocationAsstUtilityB->allocation_count;
        $fungtionalAlwB =
            $getAllocationDir->fungtional_alw / $getAllocationDir->allocation_count +
            $getAllocationMngDiv1->fungtional_alw / $getAllocationMngDiv1->allocation_count +
            $getAllocationAsstMngB->fungtional_alw / $getAllocationAsstMngB->allocation_count +
            $getAllocationAsstUtilityB->fungtional_alw / $getAllocationAsstUtilityB->allocation_count;
        $familyAlwB =
            $getAllocationDir->family_alw / $getAllocationDir->allocation_count +
            $getAllocationMngDiv1->family_alw / $getAllocationMngDiv1->allocation_count +
            $getAllocationAsstMngB->family_alw / $getAllocationAsstMngB->allocation_count +
            $getAllocationAsstUtilityB->family_alw / $getAllocationAsstUtilityB->allocation_count;
        $telpAwlB =
            $getAllocationDir->telephone_alw / $getAllocationDir->allocation_count +
            $getAllocationMngDiv1->telephone_alw / $getAllocationMngDiv1->allocation_count +
            $getAllocationAsstMngB->telephone_alw / $getAllocationAsstMngB->allocation_count +
            $getAllocationAsstUtilityB->telephone_alw / $getAllocationAsstUtilityB->allocation_count;
        $vehicleAlwB =
            $getAllocationDir->transport_alw / $getAllocationDir->allocation_count +
            $getAllocationMngDiv1->transport_alw / $getAllocationMngDiv1->allocation_count +
            $getAllocationAsstMngB->transport_alw / $getAllocationAsstMngB->allocation_count +
            $getAllocationAsstUtilityB->transport_alw / $getAllocationAsstUtilityB->allocation_count;
        $otB =
            $getAllocationDir->total_overtime / $getAllocationDir->allocation_count +
            $getAllocationMngDiv1->total_overtime / $getAllocationMngDiv1->allocation_count +
            $getAllocationAsstMngB->total_overtime / $getAllocationAsstMngB->allocation_count +
            $getAllocationAsstUtilityB->total_overtime / $getAllocationAsstUtilityB->allocation_count;
        $loanB =
            $getAllocationDir->pinjaman / $getAllocationDir->allocation_count +
            $getAllocationMngDiv1->pinjaman / $getAllocationMngDiv1->allocation_count +
            $getAllocationAsstMngB->pinjaman / $getAllocationAsstMngB->allocation_count +
            $getAllocationAsstUtilityB->pinjaman / $getAllocationAsstUtilityB->allocation_count;
        $astekB =
            $getAllocationDir->jamsostek / $getAllocationDir->allocation_count +
            $getAllocationMngDiv1->jamsostek / $getAllocationMngDiv1->allocation_count +
            $getAllocationAsstMngB->jamsostek / $getAllocationAsstMngB->allocation_count +
            $getAllocationAsstUtilityB->jamsostek / $getAllocationAsstUtilityB->allocation_count;
        $bpjsB =
            $getAllocationDir->bpjs / $getAllocationDir->allocation_count +
            $getAllocationMngDiv1->bpjs / $getAllocationMngDiv1->allocation_count +
            $getAllocationAsstMngB->bpjs / $getAllocationAsstMngB->allocation_count +
            $getAllocationAsstUtilityB->bpjs / $getAllocationAsstUtilityB->allocation_count;
        $electricityB =
            $getAllocationDir->electricity / $getAllocationDir->allocation_count +
            $getAllocationMngDiv1->electricity / $getAllocationMngDiv1->allocation_count +
            $getAllocationAsstMngB->electricity / $getAllocationAsstMngB->allocation_count +
            $getAllocationAsstUtilityB->electricity / $getAllocationAsstUtilityB->allocation_count;
        $totalBrutoSalaryB = $gradeB + $abilityB + $fungtionalAlwB + $familyAlwB + $telpAwlB + $vehicleAlwB + $otB;
        $totalDeductionB = $loanB + $astekB + $bpjsB + $electricityB;
        $totalSalaryNettoB = $totalBrutoSalaryB - $totalDeductionB;

        // Sub Div C
        $totalPersonC =
            1 / $getAllocationDir->allocation_count +
            1 / $getAllocationMngDiv1->allocation_count +
            1 / $getAllocationAsstMngC->allocation_count;
        $gradeC =
            $getAllocationDir->rate_salary / $getAllocationDir->allocation_count +
            $getAllocationMngDiv1->rate_salary / $getAllocationMngDiv1->allocation_count +
            $getAllocationAsstMngC->rate_salary / $getAllocationAsstMngC->allocation_count;
        $abilityC =
            $getAllocationDir->ability / $getAllocationDir->allocation_count +
            $getAllocationMngDiv1->ability / $getAllocationMngDiv1->allocation_count +
            $getAllocationAsstMngC->ability / $getAllocationAsstMngC->allocation_count;
        $fungtionalAlwC =
            $getAllocationDir->fungtional_alw / $getAllocationDir->allocation_count +
            $getAllocationMngDiv1->fungtional_alw / $getAllocationMngDiv1->allocation_count +
            $getAllocationAsstMngC->fungtional_alw / $getAllocationAsstMngC->allocation_count;
        $familyAlwC =
            $getAllocationDir->family_alw / $getAllocationDir->allocation_count +
            $getAllocationMngDiv1->family_alw / $getAllocationMngDiv1->allocation_count +
            $getAllocationAsstMngC->family_alw / $getAllocationAsstMngC->allocation_count;
        $telpAwlC =
            $getAllocationDir->telephone_alw / $getAllocationDir->allocation_count +
            $getAllocationMngDiv1->telephone_alw / $getAllocationMngDiv1->allocation_count +
            $getAllocationAsstMngC->telephone_alw / $getAllocationAsstMngC->allocation_count;
        $vehicleAlwC =
            $getAllocationDir->transport_alw / $getAllocationDir->allocation_count +
            $getAllocationMngDiv1->transport_alw / $getAllocationMngDiv1->allocation_count +
            $getAllocationAsstMngC->transport_alw / $getAllocationAsstMngC->allocation_count;
        $otC =
            $getAllocationDir->total_overtime / $getAllocationDir->allocation_count +
            $getAllocationMngDiv1->total_overtime / $getAllocationMngDiv1->allocation_count +
            $getAllocationAsstMngC->total_overtime / $getAllocationAsstMngC->allocation_count;
        $loanC =
            $getAllocationDir->pinjaman / $getAllocationDir->allocation_count +
            $getAllocationMngDiv1->pinjaman / $getAllocationMngDiv1->allocation_count +
            $getAllocationAsstMngC->pinjaman / $getAllocationAsstMngC->allocation_count;
        $astekC =
            $getAllocationDir->jamsostek / $getAllocationDir->allocation_count +
            $getAllocationMngDiv1->jamsostek / $getAllocationMngDiv1->allocation_count +
            $getAllocationAsstMngC->jamsostek / $getAllocationAsstMngC->allocation_count;
        $bpjsC =
            $getAllocationDir->bpjs / $getAllocationDir->allocation_count +
            $getAllocationMngDiv1->bpjs / $getAllocationMngDiv1->allocation_count +
            $getAllocationAsstMngC->bpjs / $getAllocationAsstMngC->allocation_count;
        $electricityC =
            $getAllocationDir->electricity / $getAllocationDir->allocation_count +
            $getAllocationMngDiv1->electricity / $getAllocationMngDiv1->allocation_count +
            $getAllocationAsstMngC->electricity / $getAllocationAsstMngC->allocation_count;
        $totalBrutoSalaryC = $gradeC + $abilityC + $fungtionalAlwC + $familyAlwC + $telpAwlC + $vehicleAlwC + $otC;
        $totalDeductionC = $loanC + $astekC + $bpjsC + $electricityC;
        $totalSalaryNettoC = $totalBrutoSalaryC - $totalDeductionC;

        // Sub Div D
        $totalPersonD =
            1 / $getAllocationDir->allocation_count +
            1 / $getAllocationMngDiv2->allocation_count +
            1 / $getAllocationAsstMngD->allocation_count +
            1 / $getAllocationAsstUtilityD->allocation_count;
        $gradeD =
            $getAllocationDir->rate_salary / $getAllocationDir->allocation_count +
            $getAllocationMngDiv2->rate_salary / $getAllocationMngDiv2->allocation_count +
            $getAllocationAsstMngD->rate_salary / $getAllocationAsstMngD->allocation_count +
            $getAllocationAsstUtilityD->rate_salary / $getAllocationAsstUtilityD->allocation_count;
        $abilityD =
            $getAllocationDir->ability / $getAllocationDir->allocation_count +
            $getAllocationMngDiv2->ability / $getAllocationMngDiv2->allocation_count +
            $getAllocationAsstMngD->ability / $getAllocationAsstMngD->allocation_count +
            $getAllocationAsstUtilityD->ability / $getAllocationAsstUtilityD->allocation_count;
        $fungtionalAlwD =
            $getAllocationDir->fungtional_alw / $getAllocationDir->allocation_count +
            $getAllocationMngDiv2->fungtional_alw / $getAllocationMngDiv2->allocation_count +
            $getAllocationAsstMngD->fungtional_alw / $getAllocationAsstMngD->allocation_count +
            $getAllocationAsstUtilityD->fungtional_alw / $getAllocationAsstUtilityD->allocation_count;
        $familyAlwD =
            $getAllocationDir->family_alw / $getAllocationDir->allocation_count +
            $getAllocationMngDiv2->family_alw / $getAllocationMngDiv2->allocation_count +
            $getAllocationAsstMngD->family_alw / $getAllocationAsstMngD->allocation_count +
            $getAllocationAsstUtilityD->family_alw / $getAllocationAsstUtilityD->allocation_count;
        $telpAwlD =
            $getAllocationDir->telephone_alw / $getAllocationDir->allocation_count +
            $getAllocationMngDiv2->telephone_alw / $getAllocationMngDiv2->allocation_count +
            $getAllocationAsstMngD->telephone_alw / $getAllocationAsstMngD->allocation_count +
            $getAllocationAsstUtilityD->telephone_alw / $getAllocationAsstUtilityD->allocation_count;
        $vehicleAlwD =
            $getAllocationDir->transport_alw / $getAllocationDir->allocation_count +
            $getAllocationMngDiv2->transport_alw / $getAllocationMngDiv2->allocation_count +
            $getAllocationAsstMngD->transport_alw / $getAllocationAsstMngD->allocation_count +
            $getAllocationAsstUtilityD->transport_alw / $getAllocationAsstUtilityD->allocation_count;
        $otD =
            $getAllocationDir->total_overtime / $getAllocationDir->allocation_count +
            $getAllocationMngDiv2->total_overtime / $getAllocationMngDiv2->allocation_count +
            $getAllocationAsstMngD->total_overtime / $getAllocationAsstMngD->allocation_count +
            $getAllocationAsstUtilityD->total_overtime / $getAllocationAsstUtilityD->allocation_count;
        $loanD =
            $getAllocationDir->pinjaman / $getAllocationDir->allocation_count +
            $getAllocationMngDiv2->pinjaman / $getAllocationMngDiv2->allocation_count +
            $getAllocationAsstMngD->pinjaman / $getAllocationAsstMngD->allocation_count +
            $getAllocationAsstUtilityD->pinjaman / $getAllocationAsstUtilityD->allocation_count;
        $astekD =
            $getAllocationDir->jamsostek / $getAllocationDir->allocation_count +
            $getAllocationMngDiv2->jamsostek / $getAllocationMngDiv2->allocation_count +
            $getAllocationAsstMngD->jamsostek / $getAllocationAsstMngD->allocation_count +
            $getAllocationAsstUtilityD->jamsostek / $getAllocationAsstUtilityD->allocation_count;
        $bpjsD =
            $getAllocationDir->bpjs / $getAllocationDir->allocation_count +
            $getAllocationMngDiv2->bpjs / $getAllocationMngDiv2->allocation_count +
            $getAllocationAsstMngD->bpjs / $getAllocationAsstMngD->allocation_count +
            $getAllocationAsstUtilityD->bpjs / $getAllocationAsstUtilityD->allocation_count;
        $electricityD =
            $getAllocationDir->electricity / $getAllocationDir->allocation_count +
            $getAllocationMngDiv2->electricity / $getAllocationMngDiv2->allocation_count +
            $getAllocationAsstMngD->electricity / $getAllocationAsstMngD->allocation_count +
            $getAllocationAsstUtilityD->electricity / $getAllocationAsstUtilityD->allocation_count;
        $totalBrutoSalaryD = $gradeD + $abilityD + $fungtionalAlwD + $familyAlwD + $telpAwlD + $vehicleAlwD + $otD;
        $totalDeductionD = $loanD + $astekD + $bpjsD + $electricityD;
        $totalSalaryNettoD = $totalBrutoSalaryD - $totalDeductionD;

        // Sub Div E
        $totalPersonE =
            1 / $getAllocationDir->allocation_count +
            1 / $getAllocationMngDiv2->allocation_count +
            1 / $getAllocationAsstMngE->allocation_count;
        $gradeE =
            $getAllocationDir->rate_salary / $getAllocationDir->allocation_count +
            $getAllocationMngDiv2->rate_salary / $getAllocationMngDiv2->allocation_count +
            $getAllocationAsstMngE->rate_salary / $getAllocationAsstMngE->allocation_count;
        $abilityE =
            $getAllocationDir->ability / $getAllocationDir->allocation_count +
            $getAllocationMngDiv2->ability / $getAllocationMngDiv2->allocation_count +
            $getAllocationAsstMngE->ability / $getAllocationAsstMngE->allocation_count;
        $fungtionalAlwE =
            $getAllocationDir->fungtional_alw / $getAllocationDir->allocation_count +
            $getAllocationMngDiv2->fungtional_alw / $getAllocationMngDiv2->allocation_count +
            $getAllocationAsstMngE->fungtional_alw / $getAllocationAsstMngE->allocation_count;
        $familyAlwE =
            $getAllocationDir->family_alw / $getAllocationDir->allocation_count +
            $getAllocationMngDiv2->family_alw / $getAllocationMngDiv2->allocation_count +
            $getAllocationAsstMngE->family_alw / $getAllocationAsstMngE->allocation_count;
        $telpAwlE =
            $getAllocationDir->telephone_alw / $getAllocationDir->allocation_count +
            $getAllocationMngDiv2->telephone_alw / $getAllocationMngDiv2->allocation_count +
            $getAllocationAsstMngE->telephone_alw / $getAllocationAsstMngE->allocation_count;
        $vehicleAlwE =
            $getAllocationDir->transport_alw / $getAllocationDir->allocation_count +
            $getAllocationMngDiv2->transport_alw / $getAllocationMngDiv2->allocation_count +
            $getAllocationAsstMngE->transport_alw / $getAllocationAsstMngE->allocation_count;
        $otE =
            $getAllocationDir->total_overtime / $getAllocationDir->allocation_count +
            $getAllocationMngDiv2->total_overtime / $getAllocationMngDiv2->allocation_count +
            $getAllocationAsstMngE->total_overtime / $getAllocationAsstMngE->allocation_count;
        $loanE =
            $getAllocationDir->pinjaman / $getAllocationDir->allocation_count +
            $getAllocationMngDiv2->pinjaman / $getAllocationMngDiv2->allocation_count +
            $getAllocationAsstMngE->pinjaman / $getAllocationAsstMngE->allocation_count;
        $astekE =
            $getAllocationDir->jamsostek / $getAllocationDir->allocation_count +
            $getAllocationMngDiv2->jamsostek / $getAllocationMngDiv2->allocation_count +
            $getAllocationAsstMngE->jamsostek / $getAllocationAsstMngE->allocation_count;
        $bpjsE =
            $getAllocationDir->bpjs / $getAllocationDir->allocation_count +
            $getAllocationMngDiv2->bpjs / $getAllocationMngDiv2->allocation_count +
            $getAllocationAsstMngE->bpjs / $getAllocationAsstMngE->allocation_count;
        $electricityE =
            $getAllocationDir->electricity / $getAllocationDir->allocation_count +
            $getAllocationMngDiv2->electricity / $getAllocationMngDiv2->allocation_count +
            $getAllocationAsstMngE->electricity / $getAllocationAsstMngE->allocation_count;
        $totalBrutoSalaryE = $gradeE + $abilityE + $fungtionalAlwE + $familyAlwE + $telpAwlE + $vehicleAlwE + $otE;
        $totalDeductionE = $loanE + $astekE + $bpjsE + $electricityE;
        $totalSalaryNettoE = $totalBrutoSalaryE - $totalDeductionE;

        // Sub Div F
        $totalPersonF =
            1 / $getAllocationDir->allocation_count +
            1 / $getAllocationMngDiv2->allocation_count +
            1 / $getAllocationAsstMngF->allocation_count;
        $gradeF =
            $getAllocationDir->rate_salary / $getAllocationDir->allocation_count +
            $getAllocationMngDiv2->rate_salary / $getAllocationMngDiv2->allocation_count +
            $getAllocationAsstMngF->rate_salary / $getAllocationAsstMngF->allocation_count;
        $abilityF =
            $getAllocationDir->ability / $getAllocationDir->allocation_count +
            $getAllocationMngDiv2->ability / $getAllocationMngDiv2->allocation_count +
            $getAllocationAsstMngF->ability / $getAllocationAsstMngF->allocation_count;
        $fungtionalAlwF =
            $getAllocationDir->fungtional_alw / $getAllocationDir->allocation_count +
            $getAllocationMngDiv2->fungtional_alw / $getAllocationMngDiv2->allocation_count +
            $getAllocationAsstMngF->fungtional_alw / $getAllocationAsstMngF->allocation_count;
        $familyAlwF =
            $getAllocationDir->family_alw / $getAllocationDir->allocation_count +
            $getAllocationMngDiv2->family_alw / $getAllocationMngDiv2->allocation_count +
            $getAllocationAsstMngF->family_alw / $getAllocationAsstMngF->allocation_count;
        $telpAwlF =
            $getAllocationDir->telephone_alw / $getAllocationDir->allocation_count +
            $getAllocationMngDiv2->telephone_alw / $getAllocationMngDiv2->allocation_count +
            $getAllocationAsstMngF->telephone_alw / $getAllocationAsstMngF->allocation_count;
        $vehicleAlwF =
            $getAllocationDir->transport_alw / $getAllocationDir->allocation_count +
            $getAllocationMngDiv2->transport_alw / $getAllocationMngDiv2->allocation_count +
            $getAllocationAsstMngF->transport_alw / $getAllocationAsstMngF->allocation_count;
        $otF =
            $getAllocationDir->total_overtime / $getAllocationDir->allocation_count +
            $getAllocationMngDiv2->total_overtime / $getAllocationMngDiv2->allocation_count +
            $getAllocationAsstMngF->total_overtime / $getAllocationAsstMngF->allocation_count;
        $loanF =
            $getAllocationDir->pinjaman / $getAllocationDir->allocation_count +
            $getAllocationMngDiv2->pinjaman / $getAllocationMngDiv2->allocation_count +
            $getAllocationAsstMngF->pinjaman / $getAllocationAsstMngF->allocation_count;
        $astekF =
            $getAllocationDir->jamsostek / $getAllocationDir->allocation_count +
            $getAllocationMngDiv2->jamsostek / $getAllocationMngDiv2->allocation_count +
            $getAllocationAsstMngF->jamsostek / $getAllocationAsstMngF->allocation_count;
        $bpjsF =
            $getAllocationDir->bpjs / $getAllocationDir->allocation_count +
            $getAllocationMngDiv2->bpjs / $getAllocationMngDiv2->allocation_count +
            $getAllocationAsstMngF->bpjs / $getAllocationAsstMngF->allocation_count;
        $electricityF =
            $getAllocationDir->electricity / $getAllocationDir->allocation_count +
            $getAllocationMngDiv2->electricity / $getAllocationMngDiv2->allocation_count +
            $getAllocationAsstMngF->electricity / $getAllocationAsstMngF->allocation_count;
        $totalBrutoSalaryF = $gradeF + $abilityF + $fungtionalAlwF + $familyAlwF + $telpAwlF + $vehicleAlwF + $otF;
        $totalDeductionF = $loanF + $astekF + $bpjsF + $electricityF;
        $totalSalaryNettoF = $totalBrutoSalaryF - $totalDeductionF;

        // Factory
        $totalPersonFac = 1 / $getAllocationAsstMngFac->allocation_count;
        $gradeFac = $getAllocationAsstMngFac->rate_salary / $getAllocationAsstMngFac->allocation_count;
        $abilityFac = $getAllocationAsstMngFac->ability / $getAllocationAsstMngFac->allocation_count;
        $fungtionalAlwFac = $getAllocationAsstMngFac->fungtional_alw / $getAllocationAsstMngFac->allocation_count;
        $familyAlwFac = $getAllocationAsstMngFac->family_alw / $getAllocationAsstMngFac->allocation_count;
        $telpAwlFac = $getAllocationAsstMngFac->telephone_alw / $getAllocationAsstMngFac->allocation_count;
        $vehicleAlwFac = $getAllocationAsstMngFac->transport_alw / $getAllocationAsstMngFac->allocation_count;
        $otFac = $getAllocationAsstMngFac->total_overtime / $getAllocationAsstMngFac->allocation_count;
        $loanFac = $getAllocationAsstMngFac->pinjaman / $getAllocationAsstMngFac->allocation_count;
        $astekFac = $getAllocationAsstMngFac->jamsostek / $getAllocationAsstMngFac->allocation_count;
        $bpjsFac = $getAllocationAsstMngFac->bpjs / $getAllocationAsstMngFac->allocation_count;
        $electricityFac = $getAllocationAsstMngFac->electricity / $getAllocationAsstMngFac->allocation_count;
        $totalBrutoSalaryFac =
            $gradeFac + $abilityFac + $fungtionalAlwFac + $familyAlwFac + $telpAwlFac + $vehicleAlwFac + $otFac;
        $totalDeductionFac = $loanFac + $astekFac + $bpjsFac + $electricityFac;
        $totalSalaryNettoFac = $totalBrutoSalaryFac - $totalDeductionFac;

        // GAE
        $totalBrutoSalaryGae =
            $totalRateSalaryGae +
            $totalAbilityGae +
            $totalFungtionalAlwGae +
            $totalFamilyAlwGae +
            $totalTelephoneAlwGae +
            $totalTransportAlwGae +
            $totalTotalOvertimeGae;
        $totalDeductionGae = $totalPinjamanGae + $totalJamsostekGae + $totalBpjsGae + $totalElectricityGae;
        $totalSalaryNettoGae = $totalBrutoSalaryGae - $totalDeductionGae;

        // Workshop
        $totalPersonWorkshop = $getAllocationAsstMngWorkshop->allocation_count;
        $gradeWorkshop = $getAllocationAsstMngWorkshop->rate_salary / $getAllocationAsstMngWorkshop->allocation_count;
        $abilityWorkshop = $getAllocationAsstMngWorkshop->ability / $getAllocationAsstMngWorkshop->allocation_count;
        $fungtionalAlwWorkshop =
            $getAllocationAsstMngWorkshop->fungtional_alw / $getAllocationAsstMngWorkshop->allocation_count;
        $familyAlwWorkshop =
            $getAllocationAsstMngWorkshop->family_alw / $getAllocationAsstMngWorkshop->allocation_count;
        $telpAwlWorkshop =
            $getAllocationAsstMngWorkshop->telephone_alw / $getAllocationAsstMngWorkshop->allocation_count;
        $vehicleAlwWorkshop =
            $getAllocationAsstMngWorkshop->transport_alw / $getAllocationAsstMngWorkshop->allocation_count;
        $otWorkshop = $getAllocationAsstMngWorkshop->total_overtime / $getAllocationAsstMngWorkshop->allocation_count;
        $loanWorkshop = $getAllocationAsstMngWorkshop->pinjaman / $getAllocationAsstMngWorkshop->allocation_count;
        $astekWorkshop = $getAllocationAsstMngWorkshop->jamsostek / $getAllocationAsstMngWorkshop->allocation_count;
        $bpjsWorkshop = $getAllocationAsstMngWorkshop->bpjs / $getAllocationAsstMngWorkshop->allocation_count;
        $electricityWorkshop =
            $getAllocationAsstMngWorkshop->electricity / $getAllocationAsstMngWorkshop->allocation_count;
        $totalBrutoSalaryWorkshop =
            $gradeWorkshop +
            $abilityWorkshop +
            $fungtionalAlwWorkshop +
            $familyAlwWorkshop +
            $telpAwlWorkshop +
            $vehicleAlwWorkshop +
            $otWorkshop;
        $totalDeductionWorkshop = $loanWorkshop + $astekWorkshop + $bpjsWorkshop + $electricityWorkshop;
        $totalSalaryNettoWorkshop = $totalBrutoSalaryWorkshop - $totalDeductionWorkshop;

        // ISO
        $totalPersonIso = $getAllocationAsstMngIso->allocation_count;
        $gradeIso = $getAllocationAsstMngIso->rate_salary / $getAllocationAsstMngIso->allocation_count;
        $abilityIso = $getAllocationAsstMngIso->ability / $getAllocationAsstMngIso->allocation_count;
        $fungtionalAlwIso = $getAllocationAsstMngIso->fungtional_alw / $getAllocationAsstMngIso->allocation_count;
        $familyAlwIso = $getAllocationAsstMngIso->family_alw / $getAllocationAsstMngIso->allocation_count;
        $telpAwlIso = $getAllocationAsstMngIso->telephone_alw / $getAllocationAsstMngIso->allocation_count;
        $vehicleAlwIso = $getAllocationAsstMngIso->transport_alw / $getAllocationAsstMngIso->allocation_count;
        $otIso = $getAllocationAsstMngIso->total_overtime / $getAllocationAsstMngIso->allocation_count;
        $loanIso = $getAllocationAsstMngIso->pinjaman / $getAllocationAsstMngIso->allocation_count;
        $astekIso = $getAllocationAsstMngIso->jamsostek / $getAllocationAsstMngIso->allocation_count;
        $bpjsIso = $getAllocationAsstMngIso->bpjs / $getAllocationAsstMngIso->allocation_count;
        $electricityIso = $getAllocationAsstMngIso->electricity / $getAllocationAsstMngIso->allocation_count;
        $totalBrutoSalaryIso =
            $gradeIso + $abilityIso + $fungtionalAlwIso + $familyAlwIso + $telpAwlIso + $vehicleAlwIso + $otIso;
        $totalDeductionIso = $loanIso + $astekIso + $bpjsIso + $electricityIso;
        $totalSalaryNettoIso = $totalBrutoSalaryIso - $totalDeductionIso;

        // Sales
        $totalPersonSales = $getAllocationAsstMngSales->allocation_count;
        $gradeSales = $getAllocationAsstMngSales->rate_salary / $getAllocationAsstMngSales->allocation_count;
        $abilitySales = $getAllocationAsstMngSales->ability / $getAllocationAsstMngSales->allocation_count;
        $fungtionalAlwSales = $getAllocationAsstMngSales->fungtional_alw / $getAllocationAsstMngSales->allocation_count;
        $familyAlwSales = $getAllocationAsstMngSales->family_alw / $getAllocationAsstMngSales->allocation_count;
        $telpAwlSales = $getAllocationAsstMngSales->telephone_alw / $getAllocationAsstMngSales->allocation_count;
        $vehicleAlwSales = $getAllocationAsstMngSales->transport_alw / $getAllocationAsstMngSales->allocation_count;
        $otSales = $getAllocationAsstMngSales->total_overtime / $getAllocationAsstMngSales->allocation_count;
        $loanSales = $getAllocationAsstMngSales->pinjaman / $getAllocationAsstMngSales->allocation_count;
        $astekSales = $getAllocationAsstMngSales->jamsostek / $getAllocationAsstMngSales->allocation_count;
        $bpjsSales = $getAllocationAsstMngSales->bpjs / $getAllocationAsstMngSales->allocation_count;
        $electricitySales = $getAllocationAsstMngSales->electricity / $getAllocationAsstMngSales->allocation_count;
        $totalBrutoSalarySales =
            $gradeSales +
            $abilitySales +
            $fungtionalAlwSales +
            $familyAlwSales +
            $telpAwlSales +
            $vehicleAlwSales +
            $otSales;
        $totalDeductionSales = $loanSales + $astekSales + $bpjsSales + $electricitySales;
        $totalSalaryNettoSales = $totalBrutoSalarySales - $totalDeductionSales;

        $grandTotalPerson =
            $totalPersonA +
            $totalPersonB +
            $totalPersonC +
            $totalPersonD +
            $totalPersonE +
            $totalPersonF +
            $totalPersonFac +
            $totalPersonWorkshop +
            $totalPersonIso +
            $totalPersonSales +
            $totalAllocationCountGae;

        $grandTotalGrade =
            $gradeA +
            $gradeB +
            $gradeC +
            $gradeD +
            $gradeE +
            $gradeF +
            $gradeFac +
            $gradeWorkshop +
            $gradeIso +
            $gradeSales +
            $totalRateSalaryGae;

        $grandTotalAbility =
            $abilityA +
            $abilityB +
            $abilityC +
            $abilityD +
            $abilityE +
            $abilityF +
            $abilityFac +
            $abilityWorkshop +
            $abilityIso +
            $abilitySales +
            $totalAbilityGae;

        $grandTotalFungtionalAlw =
            $fungtionalAlwA +
            $fungtionalAlwB +
            $fungtionalAlwC +
            $fungtionalAlwD +
            $fungtionalAlwE +
            $fungtionalAlwF +
            $fungtionalAlwFac +
            $fungtionalAlwWorkshop +
            $fungtionalAlwIso +
            $fungtionalAlwSales +
            $totalFungtionalAlwGae;

        $grandTotalFamilyAlw =
            $familyAlwA +
            $familyAlwB +
            $familyAlwC +
            $familyAlwD +
            $familyAlwE +
            $familyAlwF +
            $familyAlwFac +
            $familyAlwWorkshop +
            $familyAlwIso +
            $familyAlwSales +
            $totalFamilyAlwGae;

        $grandTotalTelpAwl =
            $telpAwlA +
            $telpAwlB +
            $telpAwlC +
            $telpAwlD +
            $telpAwlE +
            $telpAwlF +
            $telpAwlFac +
            $telpAwlWorkshop +
            $telpAwlIso +
            $telpAwlSales +
            $totalTelephoneAlwGae;

        $grandTotalVehicleAlw =
            $vehicleAlwA +
            $vehicleAlwB +
            $vehicleAlwC +
            $vehicleAlwD +
            $vehicleAlwE +
            $vehicleAlwF +
            $vehicleAlwFac +
            $vehicleAlwWorkshop +
            $vehicleAlwIso +
            $vehicleAlwSales +
            $totalTransportAlwGae;

        $grandTotalOT =
            $otA + $otB + $otC + $otD + $otE + $otF + $otFac + $otWorkshop + $otIso + $otSales + $totalTotalOvertimeGae;

        $grandTotalBrutoSalary =
            $totalBrutoSalaryA +
            $totalBrutoSalaryB +
            $totalBrutoSalaryC +
            $totalBrutoSalaryD +
            $totalBrutoSalaryE +
            $totalBrutoSalaryF +
            $totalBrutoSalaryFac +
            $totalBrutoSalaryWorkshop +
            $totalBrutoSalaryIso +
            $totalBrutoSalarySales +
            $totalBrutoSalaryGae;

        $grandTotalLoan =
            $loanA +
            $loanB +
            $loanC +
            $loanD +
            $loanE +
            $loanF +
            $loanFac +
            $loanWorkshop +
            $loanIso +
            $loanSales +
            $totalPinjamanGae;

        $grandTotalBpjs =
            $bpjsA +
            $bpjsB +
            $bpjsC +
            $bpjsD +
            $bpjsE +
            $bpjsF +
            $bpjsFac +
            $bpjsWorkshop +
            $bpjsIso +
            $bpjsSales +
            $totalBpjsGae;

        $grandTotalAstek =
            $astekA +
            $astekB +
            $astekC +
            $astekD +
            $astekE +
            $astekF +
            $astekFac +
            $astekWorkshop +
            $astekIso +
            $astekSales +
            $totalJamsostekGae;

        $grandTotalElectricity =
            $electricityA +
            $electricityB +
            $electricityC +
            $electricityD +
            $electricityE +
            $electricityF +
            $electricityFac +
            $electricityWorkshop +
            $electricityIso +
            $electricitySales +
            $totalElectricityGae;

        $grandTotalDeduction =
            $totalDeductionA +
            $totalDeductionB +
            $totalDeductionC +
            $totalDeductionD +
            $totalDeductionE +
            $totalDeductionF +
            $totalDeductionFac +
            $totalDeductionWorkshop +
            $totalDeductionIso +
            $totalDeductionSales +
            $totalDeductionGae;

        $grandTotalSalaryNett =
            $totalSalaryNettoA +
            $totalSalaryNettoB +
            $totalSalaryNettoC +
            $totalSalaryNettoD +
            $totalSalaryNettoE +
            $totalSalaryNettoF +
            $totalSalaryNettoFac +
            $totalSalaryNettoWorkshop +
            $totalSalaryNettoIso +
            $totalSalaryNettoSales +
            $totalSalaryNettoGae;
    @endphp

    <h1>PT BRIDGESTONE KALIMANTAN PLANTATION</h1>
    <h2>SUMMARY OF SALARY MANAGER STAFF</h2>
    <h3>{{ date('F', strtotime($month)) }} {{ $year }}</h3>
    <table>
        <thead>
            <tr>
                <th rowspan="2">NO.</th>
                <th rowspan="2">NAME</th>
                <th rowspan="2">Total<br>Person</th>
                <th colspan="7">SALARY</th>
                <th rowspan="2">TOTAL SALARY<br>BRUTO</th>
                <th colspan="7">DEDUCTION</th>
                <th rowspan="2">TOTAL<br>DEDUCTION</th>
                <th rowspan="2">TOTAL SALARY<br>NETTO</th>
            </tr>
            <tr>
                <th style="padding: 8px;">Grade</th>
                <th style="padding: 8px;">Ability</th>
                <th style="padding: 6px;">Position<br>All</th>
                <th style="padding: 6px;">Family<br>All</th>
                <th>Telphone<br>All</th>
                <th style="padding: 8px;">Vehicle<br>All</th>
                <th style="padding: 9px;">Over<br>Time</th>
                <th style="padding: 9px;">Loan</th>
                <th style="padding: 7px;">ASTEK</th>
                <th style="padding: 9px;">BPJS</th>
                <th style="padding: 6px;">Internet</th>
                <th style="padding: 11px;">Gas</th>
                <th style="padding: 9px;">Water</th>
                <th>Electricity</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td rowspan="7" style="vertical-align: text-top;text-align: center;">1</td>
                <td>MATURE-TAPPING</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>- Sub Div. A</td>
                <td style="text-align: center">{{ $totalPersonA == 0 ? '-' : number_format($totalPersonA, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">{{ $gradeA == 0 ? '-' : number_format($gradeA, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $abilityA == 0 ? '-' : number_format($abilityA, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $fungtionalAlwA == 0 ? '-' : number_format($fungtionalAlwA, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $familyAlwA == 0 ? '-' : number_format($familyAlwA, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $telpAwlA == 0 ? '-' : number_format($telpAwlA, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $vehicleAlwA == 0 ? '-' : number_format($vehicleAlwA, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">{{ $otA == 0 ? '-' : number_format($otA, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalBrutoSalaryA == 0 ? '-' : number_format($totalBrutoSalaryA, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">{{ $loanA == 0 ? '-' : number_format($loanA, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">{{ $astekA == 0 ? '-' : number_format($astekA, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">{{ $bpjsA == 0 ? '-' : number_format($bpjsA, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $electricityA == 0 ? '-' : number_format($electricityA, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalDeductionA == 0 ? '-' : number_format($totalDeductionA, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalSalaryNettoA == 0 ? '-' : number_format($totalSalaryNettoA, 0) }}</td>
            </tr>
            <tr>
                <td>- Sub Div. B</td>
                <td style="text-align: center">{{ $totalPersonB == 0 ? '-' : number_format($totalPersonB, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">{{ $gradeB == 0 ? '-' : number_format($gradeB, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $abilityB == 0 ? '-' : number_format($abilityB, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $fungtionalAlwB == 0 ? '-' : number_format($fungtionalAlwB, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $familyAlwB == 0 ? '-' : number_format($familyAlwB, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $telpAwlB == 0 ? '-' : number_format($telpAwlB, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $vehicleAlwB == 0 ? '-' : number_format($vehicleAlwB, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">{{ $otB == 0 ? '-' : number_format($otB, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalBrutoSalaryB == 0 ? '-' : number_format($totalBrutoSalaryB, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">{{ $loanB == 0 ? '-' : number_format($loanB, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">{{ $astekB == 0 ? '-' : number_format($astekB, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">{{ $bpjsB == 0 ? '-' : number_format($bpjsB, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $electricityB == 0 ? '-' : number_format($electricityB, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalDeductionB == 0 ? '-' : number_format($totalDeductionB, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalSalaryNettoB == 0 ? '-' : number_format($totalSalaryNettoB, 0) }}</td>
            </tr>
            <tr>
                <td>- Sub Div. C</td>
                <td style="text-align: center">{{ $totalPersonC == 0 ? '-' : number_format($totalPersonC, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">{{ $gradeC == 0 ? '-' : number_format($gradeC, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $abilityC == 0 ? '-' : number_format($abilityC, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $fungtionalAlwC == 0 ? '-' : number_format($fungtionalAlwC, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $familyAlwC == 0 ? '-' : number_format($familyAlwC, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $telpAwlC == 0 ? '-' : number_format($telpAwlC, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $vehicleAlwC == 0 ? '-' : number_format($vehicleAlwC, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">{{ $otC == 0 ? '-' : number_format($otC, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalBrutoSalaryC == 0 ? '-' : number_format($totalBrutoSalaryC, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">{{ $loanC == 0 ? '-' : number_format($loanC, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">{{ $astekC == 0 ? '-' : number_format($astekC, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">{{ $bpjsC == 0 ? '-' : number_format($bpjsC, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $electricityC == 0 ? '-' : number_format($electricityC, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalDeductionC == 0 ? '-' : number_format($totalDeductionC, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalSalaryNettoC == 0 ? '-' : number_format($totalSalaryNettoC, 0) }}</td>
            </tr>
            <tr>
                <td>- Sub Div. D</td>
                <td style="text-align: center">{{ $totalPersonD == 0 ? '-' : number_format($totalPersonD, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">{{ $gradeD == 0 ? '-' : number_format($gradeD, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $abilityD == 0 ? '-' : number_format($abilityD, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $fungtionalAlwD == 0 ? '-' : number_format($fungtionalAlwD, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $familyAlwD == 0 ? '-' : number_format($familyAlwD, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $telpAwlD == 0 ? '-' : number_format($telpAwlD, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $vehicleAlwD == 0 ? '-' : number_format($vehicleAlwD, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">{{ $otD == 0 ? '-' : number_format($otD, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalBrutoSalaryD == 0 ? '-' : number_format($totalBrutoSalaryD, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">{{ $loanD == 0 ? '-' : number_format($loanD, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">{{ $astekD == 0 ? '-' : number_format($astekD, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">{{ $bpjsD == 0 ? '-' : number_format($bpjsD, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $electricityD == 0 ? '-' : number_format($electricityD, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalDeductionD == 0 ? '-' : number_format($totalDeductionD, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalSalaryNettoD == 0 ? '-' : number_format($totalSalaryNettoD, 0) }}</td>
            </tr>
            <tr>
                <td>- Sub Div. E</td>
                <td style="text-align: center">{{ $totalPersonE == 0 ? '-' : number_format($totalPersonE, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $gradeE == 0 ? '-' : number_format($gradeE, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $abilityE == 0 ? '-' : number_format($abilityE, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $fungtionalAlwE == 0 ? '-' : number_format($fungtionalAlwE, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $familyAlwE == 0 ? '-' : number_format($familyAlwE, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $telpAwlE == 0 ? '-' : number_format($telpAwlE, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $vehicleAlwE == 0 ? '-' : number_format($vehicleAlwE, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">{{ $otE == 0 ? '-' : number_format($otE, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalBrutoSalaryE == 0 ? '-' : number_format($totalBrutoSalaryE, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">{{ $loanE == 0 ? '-' : number_format($loanE, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $astekE == 0 ? '-' : number_format($astekE, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">{{ $bpjsE == 0 ? '-' : number_format($bpjsE, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $electricityE == 0 ? '-' : number_format($electricityE, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalDeductionE == 0 ? '-' : number_format($totalDeductionE, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalSalaryNettoE == 0 ? '-' : number_format($totalSalaryNettoE, 0) }}</td>
            </tr>
            <tr>
                <td>- Sub Div. F</td>
                <td style="text-align: center">{{ $totalPersonF == 0 ? '-' : number_format($totalPersonF, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $gradeF == 0 ? '-' : number_format($gradeF, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $abilityF == 0 ? '-' : number_format($abilityF, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $fungtionalAlwF == 0 ? '-' : number_format($fungtionalAlwF, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $familyAlwF == 0 ? '-' : number_format($familyAlwF, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $telpAwlF == 0 ? '-' : number_format($telpAwlF, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $vehicleAlwF == 0 ? '-' : number_format($vehicleAlwF, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">{{ $otF == 0 ? '-' : number_format($otF, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalBrutoSalaryF == 0 ? '-' : number_format($totalBrutoSalaryF, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">{{ $loanF == 0 ? '-' : number_format($loanF, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $astekF == 0 ? '-' : number_format($astekF, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">{{ $bpjsF == 0 ? '-' : number_format($bpjsF, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $electricityF == 0 ? '-' : number_format($electricityF, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalDeductionF == 0 ? '-' : number_format($totalDeductionF, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalSalaryNettoF == 0 ? '-' : number_format($totalSalaryNettoF, 0) }}</td>
            </tr>

            <tr>
                <td rowspan="10" style="vertical-align: text-top;text-align: center;">2</td>
                <td>IMMATURE-MAINT</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>- Sub Div. A</td>
                <td style="text-align: center">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
            </tr>
            <tr>
                <td>- Sub Div. B</td>
                <td style="text-align: center">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
            </tr>
            <tr>
                <td>- Sub Div. C</td>
                <td style="text-align: center">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
            </tr>
            <tr>
                <td>- Sub Div. D</td>
                <td style="text-align: center">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
            </tr>
            <tr>
                <td>- Sub Div. E</td>
                <td style="text-align: center">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
            </tr>
            <tr>
                <td>- Sub Div. F</td>
                <td style="text-align: center">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
            </tr>

            <tr>
                <td>- FSD</td>
                <td style="text-align: center">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
            </tr>
            <tr>
                <td>- Nursery</td>
                <td style="text-align: center">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
            </tr>
            <tr>
                <td>- RSS Factory</td>
                <td style="text-align: center; padding-right: 3px;">
                    {{ $totalPersonFac == 0 ? '-' : number_format($totalPersonFac, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $gradeFac == 0 ? '-' : number_format($gradeFac, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $abilityFac == 0 ? '-' : number_format($abilityFac, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $fungtionalAlwFac == 0 ? '-' : number_format($fungtionalAlwFac, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $familyAlwFac == 0 ? '-' : number_format($familyAlwFac, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $telpAwlFac == 0 ? '-' : number_format($telpAwlFac, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $vehicleAlwFac == 0 ? '-' : number_format($vehicleAlwFac, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">{{ $otFac == 0 ? '-' : number_format($otFac, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalBrutoSalaryFac == 0 ? '-' : number_format($totalBrutoSalaryFac, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $loanFac == 0 ? '-' : number_format($loanFac, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $astekFac == 0 ? '-' : number_format($astekFac, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $bpjsFac == 0 ? '-' : number_format($bpjsFac, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $electricityFac == 0 ? '-' : number_format($electricityFac, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalDeductionFac == 0 ? '-' : number_format($totalDeductionFac, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalSalaryNettoFac == 0 ? '-' : number_format($totalSalaryNettoFac, 0) }}</td>
            </tr>
            <tr>
                <td rowspan="6" style="vertical-align: text-top;text-align: center;">3</td>
                <td>General & Adm</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>- Office</td>
                <td style="text-align: center; padding-right: 3px;">
                    {{ $totalAllocationCountGae == 0 ? '-' : number_format($totalAllocationCountGae) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalRateSalaryGae == 0 ? '-' : number_format($totalRateSalaryGae, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalAbilityGae == 0 ? '-' : number_format($totalAbilityGae, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalFungtionalAlwGae == 0 ? '-' : number_format($totalFungtionalAlwGae, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalFamilyAlwGae == 0 ? '-' : number_format($totalFamilyAlwGae, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalTelephoneAlwGae == 0 ? '-' : number_format($totalTelephoneAlwGae, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalTransportAlwGae == 0 ? '-' : number_format($totalTransportAlwGae, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalTotalOvertimeGae == 0 ? '-' : number_format($totalTotalOvertimeGae, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalBrutoSalaryGae == 0 ? '-' : number_format($totalBrutoSalaryGae, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalPinjamanGae == 0 ? '-' : number_format($totalPinjamanGae, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalJamsostekGae == 0 ? '-' : number_format($totalJamsostekGae, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalBpjsGae == 0 ? '-' : number_format($totalBpjsGae, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalInternetGae == 0 ? '-' : number_format($totalInternetGae, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalGasGae == 0 ? '-' : number_format($totalGasGae, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalWaterGae == 0 ? '-' : number_format($totalWaterGae, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalElectricityGae == 0 ? '-' : number_format($totalElectricityGae, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalDeductionGae == 0 ? '-' : number_format($totalDeductionGae, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalSalaryNettoGae == 0 ? '-' : number_format($totalSalaryNettoGae, 0) }}</td>
            </tr>
            <tr>
                <td>- Security</td>
                <td style="text-align: center; padding-right: 3px;">0</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;"></td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;"></td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
            </tr>
            <tr>
                <td>- Workshop</td>
                <td style="text-align: center">
                    {{ $totalPersonWorkshop == 0 ? '-' : number_format($totalPersonWorkshop, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $gradeWorkshop == 0 ? '-' : number_format($gradeWorkshop, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $abilityWorkshop == 0 ? '-' : number_format($abilityWorkshop, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $fungtionalAlwWorkshop == 0 ? '-' : number_format($fungtionalAlwWorkshop, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $familyAlwWorkshop == 0 ? '-' : number_format($familyAlwWorkshop, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $telpAwlWorkshop == 0 ? '-' : number_format($telpAwlWorkshop, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $vehicleAlwWorkshop == 0 ? '-' : number_format($vehicleAlwWorkshop, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $otWorkshop == 0 ? '-' : number_format($otWorkshop, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalBrutoSalaryWorkshop == 0 ? '-' : number_format($totalBrutoSalaryWorkshop, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $loanWorkshop == 0 ? '-' : number_format($loanWorkshop, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $astekWorkshop == 0 ? '-' : number_format($astekWorkshop, 0) }}
                <td style="text-align: right; padding-right: 3px;">
                    {{ $bpjsWorkshop == 0 ? '-' : number_format($bpjsWorkshop, 0) }}</td>
                </td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $electricityWorkshop == 0 ? '-' : number_format($electricityWorkshop, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalDeductionWorkshop == 0 ? '-' : number_format($totalDeductionWorkshop, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalSalaryNettoWorkshop == 0 ? '-' : number_format($totalSalaryNettoWorkshop, 0) }}</td>
            </tr>
            <tr>
                <td>- ISO</td>
                <td style="text-align: center">
                    {{ $totalPersonIso == 0 ? '-' : number_format($totalPersonIso, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $gradeIso == 0 ? '-' : number_format($gradeIso, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $abilityIso == 0 ? '-' : number_format($abilityIso, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $fungtionalAlwIso == 0 ? '-' : number_format($fungtionalAlwIso, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $familyAlwIso == 0 ? '-' : number_format($familyAlwIso, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $telpAwlIso == 0 ? '-' : number_format($telpAwlIso, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $vehicleAlwIso == 0 ? '-' : number_format($vehicleAlwIso, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">{{ $otIso == 0 ? '-' : number_format($otIso, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalBrutoSalaryIso == 0 ? '-' : number_format($totalBrutoSalaryIso, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $loanIso == 0 ? '-' : number_format($loanIso, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $astekIso == 0 ? '-' : number_format($astekIso, 0) }}
                <td style="text-align: right; padding-right: 3px;">
                    {{ $bpjsIso == 0 ? '-' : number_format($bpjsIso, 0) }}</td>
                </td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $electricityIso == 0 ? '-' : number_format($electricityIso, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalDeductionIso == 0 ? '-' : number_format($totalDeductionIso, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalSalaryNettoIso == 0 ? '-' : number_format($totalSalaryNettoIso, 0) }}</td>
            </tr>
            <tr>
                <td>- Sales</td>
                <td style="text-align: center">
                    {{ $totalPersonSales == 0 ? '-' : number_format($totalPersonSales, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $gradeSales == 0 ? '-' : number_format($gradeSales, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $abilitySales == 0 ? '-' : number_format($abilitySales, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $fungtionalAlwSales == 0 ? '-' : number_format($fungtionalAlwSales, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $familyAlwSales == 0 ? '-' : number_format($familyAlwSales, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $telpAwlSales == 0 ? '-' : number_format($telpAwlSales, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $vehicleAlwSales == 0 ? '-' : number_format($vehicleAlwSales, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $otSales == 0 ? '-' : number_format($otSales, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalBrutoSalarySales == 0 ? '-' : number_format($totalBrutoSalarySales, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $loanSales == 0 ? '-' : number_format($loanSales, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $astekSales == 0 ? '-' : number_format($astekSales, 0) }}
                <td style="text-align: right; padding-right: 3px;">
                    {{ $bpjsSales == 0 ? '-' : number_format($bpjsSales, 0) }}</td>
                </td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">-</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $electricitySales == 0 ? '-' : number_format($electricitySales, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalDeductionSales == 0 ? '-' : number_format($totalDeductionSales, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalSalaryNettoSales == 0 ? '-' : number_format($totalSalaryNettoSales, 0) }}</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2" style="text-align: center">Total</td>
                <td style="text-align: center">
                    {{ $grandTotalPerson == 0 ? '-' : number_format($grandTotalPerson, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $grandTotalGrade == 0 ? '-' : number_format($grandTotalGrade, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $grandTotalAbility == 0 ? '-' : number_format($grandTotalAbility, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $grandTotalFungtionalAlw == 0 ? '-' : number_format($grandTotalFungtionalAlw, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $grandTotalFamilyAlw == 0 ? '-' : number_format($grandTotalFamilyAlw, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $grandTotalTelpAwl == 0 ? '-' : number_format($grandTotalTelpAwl, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $grandTotalVehicleAlw == 0 ? '-' : number_format($grandTotalVehicleAlw, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $grandTotalOT == 0 ? '-' : number_format($grandTotalOT, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $grandTotalBrutoSalary == 0 ? '-' : number_format($grandTotalBrutoSalary, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $grandTotalLoan == 0 ? '-' : number_format($grandTotalLoan, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $grandTotalAstek == 0 ? '-' : number_format($grandTotalAstek, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $grandTotalBpjs == 0 ? '-' : number_format($grandTotalBpjs, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalInternetGae == 0 ? '-' : number_format($totalInternetGae, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalGasGae == 0 ? '-' : number_format($totalGasGae, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalWaterGae == 0 ? '-' : number_format($totalWaterGae, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $grandTotalElectricity == 0 ? '-' : number_format($grandTotalElectricity, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $grandTotalDeduction == 0 ? '-' : number_format($grandTotalDeduction, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $grandTotalSalaryNett == 0 ? '-' : number_format($grandTotalSalaryNett, 0) }}</td>
            </tr>
        </tfoot>
    </table>

    <table
        style="width: 79%; margin: 0 auto; text-align: center; border: none; border-collapse: collapse; padding-top: 30px">
        <thead>
            <tr style="text-align: center; border: none;">
                <th colspan="7" style="border: none; padding-bottom: 50px;">Checked by</th>
                <th style="border: none; padding-bottom: 50px;">Approved by</th>
            </tr>
        </thead>
        <tbody>
            <tr style="border: none;">
                <td style="border: none;">
                    <u>WIDYA CITRA MUSTIKASARI</u>
                    <br> HR Asst
                </td>
                <td style="border: none;">
                    <u>EMAN ISTANTO</u>
                    <br> ACC FIN Asst
                </td>
                <td style="border: none;">
                    <u>JOHARI</u>
                    <br> HR GA Mng
                </td>
                <td style="border: none;">
                    <u>HENDY PRASSONANTIO</u>
                    <br> ACC FIN Mng
                </td>
                <td style="border: none;">
                    <u>SURYANI</u>
                    <br> Director
                </td>
                <td style="border: none"></td>
                <td style="border: none"></td>
                <td style="border: none;">
                    <u>TSUNEHISA SAKODA</u>
                    <br> President Director
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>
