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
        // A
        $totalBrutoSalaryA =
            $totalAbilityA +
            $subTotalRateSalaryA +
            $totalSkillAlwA +
            $totalFamilyAlwA +
            $totalTelephoneAlwA +
            $totalTransportAlwA +
            $totalTotalOvertimeA +
            $totalTotalIncentiveA;

        $totalDeductionA =
            $totalPinjamanA + $totalBpjsA + $totalJamsostekA + $totalSPSIA + $totalOtherA + $subTotalElectricityA;

        $totalSalaryNettoA = $totalBrutoSalaryA - $totalDeductionA;

        // B
        $totalBrutoSalaryB =
            $totalAbilityB +
            $subTotalRateSalaryB +
            $totalSkillAlwB +
            $totalFamilyAlwB +
            $totalTelephoneAlwB +
            $totalTransportAlwB +
            $totalTotalOvertimeB +
            $totalTotalIncentiveB;

        $totalDeductionB =
            $totalPinjamanB + $totalBpjsB + $totalJamsostekB + $totalSPSIB + $totalOtherB + $subTotalElectricityB;

        $totalSalaryNettoB = $totalBrutoSalaryB - $totalDeductionB;

        // C
        $totalBrutoSalaryC =
            $totalAbilityC +
            $subTotalRateSalaryC +
            $totalSkillAlwC +
            $totalFamilyAlwC +
            $totalTelephoneAlwC +
            $totalTransportAlwC +
            $totalTotalOvertimeC +
            $totalTotalIncentiveC;

        $totalDeductionC =
            $totalPinjamanC + $totalBpjsC + $totalJamsostekC + $totalSPSIC + $totalOtherC + $subTotalElectricityC;

        $totalSalaryNettoC = $totalBrutoSalaryC - $totalDeductionC;

        // D
        $totalBrutoSalaryD =
            $totalAbilityD +
            $subTotalRateSalaryD +
            $totalSkillAlwD +
            $totalFamilyAlwD +
            $totalTelephoneAlwD +
            $totalTransportAlwD +
            $totalTotalOvertimeD +
            $totalTotalIncentiveD;

        $totalDeductionD =
            $totalPinjamanD + $totalBpjsD + $totalJamsostekD + $totalSPSID + $totalOtherD + $subTotalElectricityD;

        $totalSalaryNettoD = $totalBrutoSalaryD - $totalDeductionD;

        // E
        $totalBrutoSalaryE =
            $totalAbilityE +
            $subTotalRateSalaryE +
            $totalSkillAlwE +
            $totalFamilyAlwE +
            $totalTelephoneAlwE +
            $totalTransportAlwE +
            $totalTotalOvertimeE +
            $totalTotalIncentiveE;

        $totalDeductionE =
            $totalPinjamanE + $totalBpjsE + $totalJamsostekE + $totalSPSIE + $totalOtherE + $subTotalElectricityE;

        $totalSalaryNettoE = $totalBrutoSalaryE - $totalDeductionE;

        // F
        $totalBrutoSalaryF =
            $totalAbilityF +
            $subTotalRateSalaryF +
            $totalSkillAlwF +
            $totalFamilyAlwF +
            $totalTelephoneAlwF +
            $totalTransportAlwF +
            $totalTotalOvertimeF +
            $totalTotalIncentiveF;

        $totalDeductionF =
            $totalPinjamanF + $totalBpjsF + $totalJamsostekF + $totalSPSIF + $totalOtherF + $subTotalElectricityF;

        $totalSalaryNettoF = $totalBrutoSalaryF - $totalDeductionF;

        // FSD
        $totalBrutoSalaryFSD =
            $totalAbilityFSD +
            $subTotalRateSalaryFSD +
            $totalSkillAlwFSD +
            $totalFamilyAlwFSD +
            $totalTelephoneAlwFSD +
            $totalTransportAlwFSD +
            $totalTotalOvertimeFSD +
            $totalTotalIncentiveFSD;

        $totalDeductionFSD =
            $totalPinjamanFSD +
            $totalBpjsFSD +
            $totalJamsostekFSD +
            $totalSPSIFSD +
            $totalOtherFSD +
            $subTotalElectricityFSD;

        $totalSalaryNettoFSD = $totalBrutoSalaryFSD - $totalDeductionFSD;

        // Nursery
        $totalBrutoSalaryNursery =
            $totalAbilityNursery +
            $subTotalRateSalaryNursery +
            $totalSkillAlwNursery +
            $totalFamilyAlwNursery +
            $totalTelephoneAlwNursery +
            $totalTransportAlwNursery +
            $totalTotalOvertimeNursery +
            $totalTotalIncentiveNursery;

        $totalDeductionNursery =
            $totalPinjamanNursery +
            $totalBpjsNursery +
            $totalJamsostekNursery +
            $totalSPSINursery +
            $totalOtherNursery +
            $subTotalElectricityNursery;

        $totalSalaryNettoNursery = $totalBrutoSalaryNursery - $totalDeductionNursery;

        // RSS Factory
        $totalBrutoSalaryRSSFactory =
            $totalAbilityRSSFactory +
            $subTotalRateSalaryRSSFactory +
            $totalSkillAlwRSSFactory +
            $totalFamilyAlwRSSFactory +
            $totalTelephoneAlwRSSFactory +
            $totalTransportAlwRSSFactory +
            $totalTotalOvertimeRSSFactory +
            $totalTotalIncentiveRSSFactory;

        $totalDeductionRSSFactory =
            $totalPinjamanRSSFactory +
            $totalBpjsRSSFactory +
            $totalJamsostekRSSFactory +
            $totalSPSIRSSFactory +
            $totalOtherRSSFactory +
            $subTotalElectricityRSSFactory;

        $totalSalaryNettoRSSFactory = $totalBrutoSalaryRSSFactory - $totalDeductionRSSFactory;

        // RSS Factory Grading & Proces
        $totalBrutoSalaryRSSFactoryGradingProces =
            $totalAbilityRSSFactoryGradingProces +
            $subTotalRateSalaryRSSFactoryGradingProces +
            $totalSkillAlwRSSFactoryGradingProces +
            $totalFamilyAlwRSSFactoryGradingProces +
            $totalTelephoneAlwRSSFactoryGradingProces +
            $totalTransportAlwRSSFactoryGradingProces +
            $totalTotalOvertimeRSSFactoryGradingProces +
            $totalTotalIncentiveRSSFactoryGradingProces;

        $totalDeductionRSSFactoryGradingProces =
            $totalPinjamanRSSFactoryGradingProces +
            $totalBpjsRSSFactoryGradingProces +
            $totalJamsostekRSSFactoryGradingProces +
            $totalSPSIRSSFactoryGradingProces +
            $totalOtherRSSFactoryGradingProces +
            $subTotalElectricityRSSFactoryGradingProces;

        $totalSalaryNettoRSSFactoryGradingProces =
            $totalBrutoSalaryRSSFactoryGradingProces - $totalDeductionRSSFactoryGradingProces;

        // Office
        $totalBrutoSalaryOffice =
            $totalAbilityOffice +
            $subTotalRateSalaryOffice +
            $totalSkillAlwOffice +
            $totalFamilyAlwOffice +
            $totalTelephoneAlwOffice +
            $totalTransportAlwOffice +
            $totalTotalOvertimeOffice +
            $totalTotalIncentiveOffice;

        $totalDeductionOffice =
            $totalPinjamanOffice +
            $totalBpjsOffice +
            $totalJamsostekOffice +
            $totalSPSIOffice +
            $totalOtherOffice +
            $subTotalElectricityOffice;

        $totalSalaryNettoOffice = $totalBrutoSalaryOffice - $totalDeductionOffice;

        // Security
        $totalBrutoSalarySecurity =
            $totalAbilitySecurity +
            $subTotalRateSalarySecurity +
            $totalSkillAlwSecurity +
            $totalFamilyAlwSecurity +
            $totalTelephoneAlwSecurity +
            $totalTransportAlwSecurity +
            $totalTotalOvertimeSecurity +
            $totalTotalIncentiveSecurity;

        $totalDeductionSecurity =
            $totalPinjamanSecurity +
            $totalBpjsSecurity +
            $totalJamsostekSecurity +
            $totalSPSISecurity +
            $totalOtherSecurity +
            $subTotalElectricitySecurity;

        $totalSalaryNettoSecurity = $totalBrutoSalarySecurity - $totalDeductionSecurity;

        // Workshop
        $totalBrutoSalaryWorkshop =
            $totalAbilityWorkshop +
            $subTotalRateSalaryWorkshop +
            $totalSkillAlwWorkshop +
            $totalFamilyAlwWorkshop +
            $totalTelephoneAlwWorkshop +
            $totalTransportAlwWorkshop +
            $totalTotalOvertimeWorkshop +
            $totalTotalIncentiveWorkshop;

        $totalDeductionWorkshop =
            $totalPinjamanWorkshop +
            $totalBpjsWorkshop +
            $totalJamsostekWorkshop +
            $totalSPSIWorkshop +
            $totalOtherWorkshop +
            $subTotalElectricityWorkshop;

        $totalSalaryNettoWorkshop = $totalBrutoSalaryWorkshop - $totalDeductionWorkshop;

        // Operator
        $totalBrutoSalaryOperator =
            $totalAbilityOperator +
            $subTotalRateSalaryOperator +
            $totalSkillAlwOperator +
            $totalFamilyAlwOperator +
            $totalTelephoneAlwOperator +
            $totalTransportAlwOperator +
            $totalTotalOvertimeOperator +
            $totalTotalIncentiveOperator;

        $totalDeductionOperator =
            $totalPinjamanOperator +
            $totalBpjsOperator +
            $totalJamsostekOperator +
            $totalSPSIOperator +
            $totalOtherOperator +
            $subTotalElectricityOperator;

        $totalSalaryNettoOperator = $totalBrutoSalaryOperator - $totalDeductionOperator;

        // Contract BSKP Office
        $totalBrutoSalaryContractBSKPOffice =
            $totalAbilityContractBSKPOffice +
            $subTotalRateSalaryContractBSKPOffice +
            $totalSkillAlwContractBSKPOffice +
            $totalFamilyAlwContractBSKPOffice +
            $totalTelephoneAlwContractBSKPOffice +
            $totalTransportAlwContractBSKPOffice +
            $totalTotalOvertimeContractBSKPOffice +
            $totalTotalIncentiveContractBSKPOffice;

        $totalDeductionContractBSKPOffice =
            $totalPinjamanContractBSKPOffice +
            $totalBpjsContractBSKPOffice +
            $totalJamsostekContractBSKPOffice +
            $totalSPSIContractBSKPOffice +
            $totalOtherContractBSKPOffice +
            $subTotalElectricityContractBSKPOffice;

        $totalSalaryNettoContractBSKPOffice = $totalBrutoSalaryContractBSKPOffice - $totalDeductionContractBSKPOffice;

        // Contract BSKP Workshop
        $totalBrutoSalaryContractBSKPWorkshop =
            $totalAbilityContractBSKPWorkshop +
            $subTotalRateSalaryContractBSKPWorkshop +
            $totalSkillAlwContractBSKPWorkshop +
            $totalFamilyAlwContractBSKPWorkshop +
            $totalTelephoneAlwContractBSKPWorkshop +
            $totalTransportAlwContractBSKPWorkshop +
            $totalTotalOvertimeContractBSKPWorkshop +
            $totalTotalIncentiveContractBSKPWorkshop;

        $totalDeductionContractBSKPWorkshop =
            $totalPinjamanContractBSKPWorkshop +
            $totalBpjsContractBSKPWorkshop +
            $totalJamsostekContractBSKPWorkshop +
            $totalSPSIContractBSKPWorkshop +
            $totalOtherContractBSKPWorkshop +
            $subTotalElectricityContractBSKPWorkshop;

        $totalSalaryNettoContractBSKPWorkshop =
            $totalBrutoSalaryContractBSKPWorkshop - $totalDeductionContractBSKPWorkshop;

        $grandTotalPerson =
            $totalAllocationA +
            $totalAllocationB +
            $totalAllocationC +
            $totalAllocationD +
            $totalAllocationE +
            $totalAllocationF +
            $totalAllocationFSD +
            $totalAllocationNursery +
            $totalAllocationRSSFactory +
            $totalAllocationRSSFactoryGradingProces +
            $totalAllocationOffice +
            $totalAllocationSecurity +
            $totalAllocationWorkshop +
            $totalAllocationOperator;

        $grandTotalGrade =
            $subTotalRateSalaryA +
            $subTotalRateSalaryB +
            $subTotalRateSalaryC +
            $subTotalRateSalaryD +
            $subTotalRateSalaryE +
            $subTotalRateSalaryF +
            $subTotalRateSalaryFSD +
            $subTotalRateSalaryNursery +
            $subTotalRateSalaryRSSFactory +
            $subTotalRateSalaryRSSFactoryGradingProces +
            $subTotalRateSalaryOffice +
            $subTotalRateSalarySecurity +
            $subTotalRateSalaryWorkshop +
            $subTotalRateSalaryOperator;

        $grandTotalAbility =
            $totalAbilityA +
            $totalAbilityB +
            $totalAbilityC +
            $totalAbilityD +
            $totalAbilityE +
            $totalAbilityF +
            $totalAbilityFSD +
            $totalAbilityNursery +
            $totalAbilityRSSFactory +
            $totalAbilityRSSFactoryGradingProces +
            $totalAbilityOffice +
            $totalAbilitySecurity +
            $totalAbilityWorkshop +
            $totalAbilityOperator;

        $grandTotalFungtionalAlw =
            $totalSkillAlwA +
            $totalSkillAlwB +
            $totalSkillAlwC +
            $totalSkillAlwD +
            $totalSkillAlwE +
            $totalSkillAlwF +
            $totalSkillAlwFSD +
            $totalSkillAlwNursery +
            $totalSkillAlwRSSFactory +
            $totalSkillAlwRSSFactoryGradingProces +
            $totalSkillAlwOffice +
            $totalSkillAlwSecurity +
            $totalSkillAlwWorkshop +
            $totalSkillAlwOperator;

        $grandTotalFamilyAlw =
            $totalFamilyAlwA +
            $totalFamilyAlwB +
            $totalFamilyAlwC +
            $totalFamilyAlwD +
            $totalFamilyAlwE +
            $totalFamilyAlwF +
            $totalFamilyAlwFSD +
            $totalFamilyAlwNursery +
            $totalFamilyAlwRSSFactory +
            $totalFamilyAlwRSSFactoryGradingProces +
            $totalFamilyAlwOffice +
            $totalFamilyAlwSecurity +
            $totalFamilyAlwWorkshop +
            $totalFamilyAlwOperator;

        $grandTotalTelpAwl =
            $totalTelephoneAlwA +
            $totalTelephoneAlwB +
            $totalTelephoneAlwC +
            $totalTelephoneAlwD +
            $totalTelephoneAlwE +
            $totalTelephoneAlwF +
            $totalTelephoneAlwFSD +
            $totalTelephoneAlwNursery +
            $totalTelephoneAlwRSSFactory +
            $totalTelephoneAlwRSSFactoryGradingProces +
            $totalTelephoneAlwOffice +
            $totalTelephoneAlwSecurity +
            $totalTelephoneAlwWorkshop +
            $totalTelephoneAlwOperator;

        $grandTotalVehicleAlw =
            $totalTransportAlwA +
            $totalTransportAlwB +
            $totalTransportAlwC +
            $totalTransportAlwD +
            $totalTransportAlwE +
            $totalTransportAlwF +
            $totalTransportAlwFSD +
            $totalTransportAlwNursery +
            $totalTransportAlwRSSFactory +
            $totalTransportAlwRSSFactoryGradingProces +
            $totalTransportAlwOffice +
            $totalTransportAlwSecurity +
            $totalTransportAlwWorkshop +
            $totalTransportAlwOperator;

        $grandTotalOT =
            $totalTotalOvertimeA +
            $totalTotalOvertimeB +
            $totalTotalOvertimeC +
            $totalTotalOvertimeD +
            $totalTotalOvertimeE +
            $totalTotalOvertimeF +
            $totalTotalOvertimeFSD +
            $totalTotalOvertimeNursery +
            $totalTotalOvertimeRSSFactory +
            $totalTotalOvertimeRSSFactoryGradingProces +
            $totalTotalOvertimeOffice +
            $totalTotalOvertimeSecurity +
            $totalTotalOvertimeWorkshop +
            $totalTotalOvertimeOperator;

        $grandTotalBrutoSalary =
            $totalBrutoSalaryA +
            $totalBrutoSalaryB +
            $totalBrutoSalaryC +
            $totalBrutoSalaryD +
            $totalBrutoSalaryE +
            $totalBrutoSalaryF +
            $totalBrutoSalaryFSD +
            $totalBrutoSalaryWorkshop +
            $totalBrutoSalaryNursery +
            $totalBrutoSalaryRSSFactory +
            $totalBrutoSalaryRSSFactoryGradingProces +
            $totalBrutoSalaryOffice +
            $totalBrutoSalarySecurity +
            $totalBrutoSalaryOperator;

        $grandTotalIncentive =
            $totalTotalIncentiveA +
            $totalTotalIncentiveB +
            $totalTotalIncentiveC +
            $totalTotalIncentiveD +
            $totalTotalIncentiveE +
            $totalTotalIncentiveF +
            $totalTotalIncentiveFSD +
            $totalTotalIncentiveNursery +
            $totalTotalIncentiveRSSFactory +
            $totalTotalIncentiveRSSFactoryGradingProces +
            $totalTotalIncentiveOffice +
            $totalTotalIncentiveSecurity +
            $totalTotalIncentiveWorkshop +
            $totalTotalIncentiveOperator;

        $grandTotalLoan =
            $totalPinjamanA +
            $totalPinjamanB +
            $totalPinjamanC +
            $totalPinjamanD +
            $totalPinjamanE +
            $totalPinjamanF +
            $totalPinjamanFSD +
            $totalPinjamanNursery +
            $totalPinjamanRSSFactory +
            $totalPinjamanRSSFactoryGradingProces +
            $totalPinjamanOffice +
            $totalPinjamanSecurity +
            $totalPinjamanWorkshop +
            $totalPinjamanOperator;

        $grandTotalBpjs =
            $totalBpjsA +
            $totalBpjsB +
            $totalBpjsC +
            $totalBpjsD +
            $totalBpjsE +
            $totalBpjsF +
            $totalBpjsFSD +
            $totalBpjsNursery +
            $totalBpjsRSSFactory +
            $totalBpjsRSSFactoryGradingProces +
            $totalBpjsOffice +
            $totalBpjsSecurity +
            $totalBpjsWorkshop +
            $totalBpjsOperator;

        $grandTotalAstek =
            $totalJamsostekA +
            $totalJamsostekB +
            $totalJamsostekC +
            $totalJamsostekD +
            $totalJamsostekE +
            $totalJamsostekF +
            $totalJamsostekFSD +
            $totalJamsostekNursery +
            $totalJamsostekRSSFactory +
            $totalJamsostekRSSFactoryGradingProces +
            $totalJamsostekOffice +
            $totalJamsostekSecurity +
            $totalJamsostekWorkshop +
            $totalJamsostekOperator;

        $grandTotalUnion =
            $totalSPSIA +
            $totalSPSIB +
            $totalSPSIC +
            $totalSPSID +
            $totalSPSIE +
            $totalSPSIF +
            $totalSPSIFSD +
            $totalSPSINursery +
            $totalSPSIRSSFactory +
            $totalSPSIRSSFactoryGradingProces +
            $totalSPSIOffice +
            $totalSPSISecurity +
            $totalSPSIWorkshop +
            $totalSPSIOperator;

        $grandTotalOther =
            $totalOtherA +
            $totalOtherB +
            $totalOtherC +
            $totalOtherD +
            $totalOtherE +
            $totalOtherF +
            $totalOtherFSD +
            $totalOtherNursery +
            $totalOtherRSSFactory +
            $totalOtherRSSFactoryGradingProces +
            $totalOtherOffice +
            $totalOtherSecurity +
            $totalOtherWorkshop +
            $totalOtherOperator;

        $grandTotalElectricity =
            $subTotalElectricityA +
            $subTotalElectricityB +
            $subTotalElectricityC +
            $subTotalElectricityD +
            $subTotalElectricityE +
            $subTotalElectricityF +
            $subTotalElectricityFSD +
            $subTotalElectricityNursery +
            $subTotalElectricityRSSFactory +
            $subTotalElectricityRSSFactoryGradingProces +
            $subTotalElectricityOffice +
            $subTotalElectricitySecurity +
            $subTotalElectricityWorkshop +
            $subTotalElectricityOperator;

        $grandTotalDeduction =
            $totalDeductionA +
            $totalDeductionB +
            $totalDeductionC +
            $totalDeductionD +
            $totalDeductionE +
            $totalDeductionF +
            $totalDeductionFSD +
            $totalDeductionWorkshop +
            $totalDeductionNursery +
            $totalDeductionRSSFactory +
            $totalDeductionRSSFactoryGradingProces +
            $totalDeductionOffice +
            $totalDeductionSecurity +
            $totalDeductionOperator;

        $grandTotalSalaryNett =
            $totalSalaryNettoA +
            $totalSalaryNettoB +
            $totalSalaryNettoC +
            $totalSalaryNettoD +
            $totalSalaryNettoE +
            $totalSalaryNettoF +
            $totalSalaryNettoFSD +
            $totalSalaryNettoWorkshop +
            $totalSalaryNettoNursery +
            $totalSalaryNettoRSSFactory +
            $totalSalaryNettoRSSFactoryGradingProces +
            $totalSalaryNettoOffice +
            $totalSalaryNettoSecurity +
            $totalSalaryNettoOperator;

        $grandTotalPersonKontrak = $totalAllocationContractBSKPOffice + $totalAllocationContractBSKPWorkshop;

        $grandTotalGradeKontrak = $subTotalRateSalaryContractBSKPOffice + $subTotalRateSalaryContractBSKPWorkshop;

        $grandTotalAbilityKontrak = $totalAbilityContractBSKPOffice + $totalAbilityContractBSKPWorkshop;

        $grandTotalFungtionalAlwKontrak = $totalSkillAlwContractBSKPOffice + $totalSkillAlwContractBSKPWorkshop;

        $grandTotalFamilyAlwKontrak = $totalFamilyAlwContractBSKPOffice + $totalFamilyAlwContractBSKPWorkshop;

        $grandTotalTelpAwlKontrak = $totalTelephoneAlwContractBSKPOffice + $totalTelephoneAlwContractBSKPWorkshop;

        $grandTotalVehicleAlwKontrak = $totalTransportAlwContractBSKPOffice + $totalTransportAlwContractBSKPWorkshop;

        $grandTotalOTKontrak = $totalTotalOvertimeContractBSKPOffice + $totalTotalOvertimeContractBSKPWorkshop;

        $grandTotalBrutoSalaryKontrak = $totalBrutoSalaryContractBSKPOffice + $totalBrutoSalaryContractBSKPWorkshop;

        $grandTotalIncentiveKontrak = $totalTotalIncentiveContractBSKPOffice + $totalTotalIncentiveContractBSKPWorkshop;

        $grandTotalLoanKontrak = $totalPinjamanContractBSKPOffice + $totalPinjamanContractBSKPWorkshop;

        $grandTotalBpjsKontrak = $totalBpjsContractBSKPOffice + $totalBpjsContractBSKPWorkshop;

        $grandTotalAstekKontrak = $totalJamsostekContractBSKPOffice + $totalJamsostekContractBSKPWorkshop;

        $grandTotalUnionKontrak = $totalSPSIContractBSKPOffice + $totalSPSIContractBSKPWorkshop;

        $grandTotalOtherKontrak = $totalOtherContractBSKPOffice + $totalOtherContractBSKPWorkshop;

        $grandTotalElectricityKontrak =
            $subTotalElectricityContractBSKPOffice + $subTotalElectricityContractBSKPWorkshop;

        $grandTotalDeductionKontrak = $totalDeductionContractBSKPOffice + $totalDeductionContractBSKPWorkshop;

        $grandTotalSalaryNettKontrak = $totalSalaryNettoContractBSKPOffice + $totalSalaryNettoContractBSKPWorkshop;

    @endphp
    <h1>PT BRIDGESTONE KALIMANTAN PLANTATION</h1>
    <h2>SUMMARY OF SALARY MONTHLY & KONTRAK</h2>
    <h3>NOV 2024</h3>
    <table>
        <thead>
            <tr>
                <th rowspan="2">NO.</th>
                <th rowspan="2">NAME</th>
                <th rowspan="2">Total<br>Person</th>
                <th colspan="8">SALARY</th>
                <th rowspan="2">TOTAL SALARY<br>BRUTO</th>
                <th colspan="6">DEDUCTION</th>
                <th rowspan="2">TOTAL<br>DEDUCTION</th>
                <th rowspan="2">TOTAL SALARY<br>NETTO</th>
            </tr>
            <tr>
                <th style="padding: 8px;">Grade</th>
                <th style="padding: 8px;">Ability</th>
                <th style="padding: 6px;">Skill<br>All</th>
                <th style="padding: 6px;">Family<br>All</th>
                <th>Telphone<br>All</th>
                <th style="padding: 8px;">Vehicle<br>All</th>
                <th style="padding: 9px;">Over<br>Time</th>
                <th style="padding: 9px;">Incentive</th>
                <th style="padding: 9px;">Loan</th>
                <th style="padding: 9px;">BPJS</th>
                <th style="padding: 7px;">ASTEK</th>
                <th style="padding: 6px;">SPSI</th>
                <th style="padding: 11px;">Kelebihan<br>Gaji</th>
                <th style="padding: 9px;">Electricity</th>
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
                <td style="text-align: center">{{ $totalAllocationA == 0 ? '-' : number_format($totalAllocationA, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $subTotalRateSalaryA == 0 ? '-' : number_format($subTotalRateSalaryA, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalAbilityA == 0 ? '-' : number_format($totalAbilityA, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalSkillAlwA == 0 ? '-' : number_format($totalSkillAlwA, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalFamilyAlwA == 0 ? '-' : number_format($totalFamilyAlwA, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalTelephoneAlwA == 0 ? '-' : number_format($totalTelephoneAlwA, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalTransportAlwA == 0 ? '-' : number_format($totalTransportAlwA, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalTotalOvertimeA == 0 ? '-' : number_format($totalTotalOvertimeA, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalTotalIncentiveA == 0 ? '-' : number_format($totalTotalIncentiveA, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalBrutoSalaryA == 0 ? '-' : number_format($totalBrutoSalaryA, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalPinjamanA == 0 ? '-' : number_format($totalPinjamanA, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalBpjsA == 0 ? '-' : number_format($totalBpjsA, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalJamsostekA == 0 ? '-' : number_format($totalJamsostekA, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalSPSIA == 0 ? '-' : number_format($totalSPSIA, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalOtherA == 0 ? '-' : number_format($totalOtherA, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $subTotalElectricityA == 0 ? '-' : number_format($subTotalElectricityA, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalDeductionA == 0 ? '-' : number_format($totalDeductionA, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalSalaryNettoA == 0 ? '-' : number_format($totalSalaryNettoA, 0) }}</td>
            </tr>

            <tr>
                <td>- Sub Div. B</td>
                <td style="text-align: center">{{ $totalAllocationB == 0 ? '-' : number_format($totalAllocationB, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $subTotalRateSalaryB == 0 ? '-' : number_format($subTotalRateSalaryB, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalAbilityB == 0 ? '-' : number_format($totalAbilityB, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalSkillAlwB == 0 ? '-' : number_format($totalSkillAlwB, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalFamilyAlwB == 0 ? '-' : number_format($totalFamilyAlwB, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalTelephoneAlwB == 0 ? '-' : number_format($totalTelephoneAlwB, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalTransportAlwB == 0 ? '-' : number_format($totalTransportAlwB, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalTotalOvertimeB == 0 ? '-' : number_format($totalTotalOvertimeB, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalTotalIncentiveB == 0 ? '-' : number_format($totalTotalIncentiveB, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalBrutoSalaryB == 0 ? '-' : number_format($totalBrutoSalaryB, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalPinjamanB == 0 ? '-' : number_format($totalPinjamanB, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalBpjsB == 0 ? '-' : number_format($totalBpjsB, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalJamsostekB == 0 ? '-' : number_format($totalJamsostekB, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalSPSIB == 0 ? '-' : number_format($totalSPSIB, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalOtherB == 0 ? '-' : number_format($totalOtherB, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $subTotalElectricityB == 0 ? '-' : number_format($subTotalElectricityB, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalDeductionB == 0 ? '-' : number_format($totalDeductionB, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalSalaryNettoB == 0 ? '-' : number_format($totalSalaryNettoB, 0) }}</td>
            </tr>

            <tr>
                <td>- Sub Div. C</td>
                <td style="text-align: center">{{ $totalAllocationC == 0 ? '-' : number_format($totalAllocationC, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $subTotalRateSalaryC == 0 ? '-' : number_format($subTotalRateSalaryC, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalAbilityC == 0 ? '-' : number_format($totalAbilityC, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalSkillAlwC == 0 ? '-' : number_format($totalSkillAlwC, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalFamilyAlwC == 0 ? '-' : number_format($totalFamilyAlwC, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalTelephoneAlwC == 0 ? '-' : number_format($totalTelephoneAlwC, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalTransportAlwC == 0 ? '-' : number_format($totalTransportAlwC, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalTotalOvertimeC == 0 ? '-' : number_format($totalTotalOvertimeC, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalTotalIncentiveC == 0 ? '-' : number_format($totalTotalIncentiveC, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalBrutoSalaryC == 0 ? '-' : number_format($totalBrutoSalaryC, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalPinjamanC == 0 ? '-' : number_format($totalPinjamanC, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalBpjsC == 0 ? '-' : number_format($totalBpjsC, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalJamsostekC == 0 ? '-' : number_format($totalJamsostekC, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalSPSIC == 0 ? '-' : number_format($totalSPSIC, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalOtherC == 0 ? '-' : number_format($totalOtherC, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $subTotalElectricityC == 0 ? '-' : number_format($subTotalElectricityC, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalDeductionC == 0 ? '-' : number_format($totalDeductionC, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalSalaryNettoC == 0 ? '-' : number_format($totalSalaryNettoC, 0) }}</td>
            </tr>

            <tr>
                <td>- Sub Div. D</td>
                <td style="text-align: center">{{ $totalAllocationD == 0 ? '-' : number_format($totalAllocationD, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $subTotalRateSalaryD == 0 ? '-' : number_format($subTotalRateSalaryD, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalAbilityD == 0 ? '-' : number_format($totalAbilityD, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalSkillAlwD == 0 ? '-' : number_format($totalSkillAlwD, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalFamilyAlwD == 0 ? '-' : number_format($totalFamilyAlwD, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalTelephoneAlwD == 0 ? '-' : number_format($totalTelephoneAlwD, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalTransportAlwD == 0 ? '-' : number_format($totalTransportAlwD, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalTotalOvertimeD == 0 ? '-' : number_format($totalTotalOvertimeD, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalTotalIncentiveD == 0 ? '-' : number_format($totalTotalIncentiveD, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalBrutoSalaryD == 0 ? '-' : number_format($totalBrutoSalaryD, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalPinjamanD == 0 ? '-' : number_format($totalPinjamanD, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalBpjsD == 0 ? '-' : number_format($totalBpjsD, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalJamsostekD == 0 ? '-' : number_format($totalJamsostekD, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalSPSID == 0 ? '-' : number_format($totalSPSID, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalOtherD == 0 ? '-' : number_format($totalOtherD, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $subTotalElectricityD == 0 ? '-' : number_format($subTotalElectricityD, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalDeductionD == 0 ? '-' : number_format($totalDeductionD, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalSalaryNettoD == 0 ? '-' : number_format($totalSalaryNettoD, 0) }}</td>
            </tr>

            <tr>
                <td>- Sub Div. E</td>
                <td style="text-align: center">
                    {{ $totalAllocationE == 0 ? '-' : number_format($totalAllocationE, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $subTotalRateSalaryE == 0 ? '-' : number_format($subTotalRateSalaryE, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalAbilityE == 0 ? '-' : number_format($totalAbilityE, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalSkillAlwE == 0 ? '-' : number_format($totalSkillAlwE, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalFamilyAlwE == 0 ? '-' : number_format($totalFamilyAlwE, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalTelephoneAlwE == 0 ? '-' : number_format($totalTelephoneAlwE, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalTransportAlwE == 0 ? '-' : number_format($totalTransportAlwE, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalTotalOvertimeE == 0 ? '-' : number_format($totalTotalOvertimeE, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalTotalIncentiveE == 0 ? '-' : number_format($totalTotalIncentiveE, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalBrutoSalaryE == 0 ? '-' : number_format($totalBrutoSalaryE, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalPinjamanE == 0 ? '-' : number_format($totalPinjamanE, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalBpjsE == 0 ? '-' : number_format($totalBpjsE, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalJamsostekE == 0 ? '-' : number_format($totalJamsostekE, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalSPSIE == 0 ? '-' : number_format($totalSPSIE, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalOtherE == 0 ? '-' : number_format($totalOtherE, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $subTotalElectricityE == 0 ? '-' : number_format($subTotalElectricityE, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalDeductionE == 0 ? '-' : number_format($totalDeductionE, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalSalaryNettoE == 0 ? '-' : number_format($totalSalaryNettoE, 0) }}</td>
            </tr>

            <tr>
                <td>- Sub Div. F</td>
                <td style="text-align: center">
                    {{ $totalAllocationF == 0 ? '-' : number_format($totalAllocationF, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $subTotalRateSalaryF == 0 ? '-' : number_format($subTotalRateSalaryF, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalAbilityF == 0 ? '-' : number_format($totalAbilityF, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalSkillAlwF == 0 ? '-' : number_format($totalSkillAlwF, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalFamilyAlwF == 0 ? '-' : number_format($totalFamilyAlwF, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalTelephoneAlwF == 0 ? '-' : number_format($totalTelephoneAlwF, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalTransportAlwF == 0 ? '-' : number_format($totalTransportAlwF, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalTotalOvertimeF == 0 ? '-' : number_format($totalTotalOvertimeF, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalTotalIncentiveF == 0 ? '-' : number_format($totalTotalIncentiveF, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalBrutoSalaryF == 0 ? '-' : number_format($totalBrutoSalaryF, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalPinjamanF == 0 ? '-' : number_format($totalPinjamanF, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalBpjsF == 0 ? '-' : number_format($totalBpjsF, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalJamsostekF == 0 ? '-' : number_format($totalJamsostekF, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalSPSIF == 0 ? '-' : number_format($totalSPSIF, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalOtherF == 0 ? '-' : number_format($totalOtherF, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $subTotalElectricityF == 0 ? '-' : number_format($subTotalElectricityF, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalDeductionF == 0 ? '-' : number_format($totalDeductionF, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalSalaryNettoF == 0 ? '-' : number_format($totalSalaryNettoF, 0) }}</td>
            </tr>

            <tr>
                <td style="vertical-align: text-top;text-align: center;">2</td>
                <td>- FSD</td>
                <td style="text-align: center">
                    {{ $totalAllocationFSD == 0 ? '-' : number_format($totalAllocationFSD, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $subTotalRateSalaryFSD == 0 ? '-' : number_format($subTotalRateSalaryFSD, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalAbilityFSD == 0 ? '-' : number_format($totalAbilityFSD, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalSkillAlwFSD == 0 ? '-' : number_format($totalSkillAlwFSD, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalFamilyAlwFSD == 0 ? '-' : number_format($totalFamilyAlwFSD, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalTelephoneAlwFSD == 0 ? '-' : number_format($totalTelephoneAlwFSD, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalTransportAlwFSD == 0 ? '-' : number_format($totalTransportAlwFSD, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalTotalOvertimeFSD == 0 ? '-' : number_format($totalTotalOvertimeFSD, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalTotalIncentiveFSD == 0 ? '-' : number_format($totalTotalIncentiveFSD, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalBrutoSalaryFSD == 0 ? '-' : number_format($totalBrutoSalaryFSD, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalPinjamanFSD == 0 ? '-' : number_format($totalPinjamanFSD, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalBpjsFSD == 0 ? '-' : number_format($totalBpjsFSD, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalJamsostekFSD == 0 ? '-' : number_format($totalJamsostekFSD, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalSPSIFSD == 0 ? '-' : number_format($totalSPSIFSD, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalOtherFSD == 0 ? '-' : number_format($totalOtherFSD, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $subTotalElectricityFSD == 0 ? '-' : number_format($subTotalElectricityFSD, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalDeductionFSD == 0 ? '-' : number_format($totalDeductionFSD, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalSalaryNettoFSD == 0 ? '-' : number_format($totalSalaryNettoFSD, 0) }}</td>
            </tr>

            <tr>
                <td style="vertical-align: text-top;text-align: center;">3</td>
                <td>- Nursery</td>
                <td style="text-align: center">
                    {{ $totalAllocationNursery == 0 ? '-' : number_format($totalAllocationNursery, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $subTotalRateSalaryNursery == 0 ? '-' : number_format($subTotalRateSalaryNursery, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalAbilityNursery == 0 ? '-' : number_format($totalAbilityNursery, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalSkillAlwNursery == 0 ? '-' : number_format($totalSkillAlwNursery, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalFamilyAlwNursery == 0 ? '-' : number_format($totalFamilyAlwNursery, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalTelephoneAlwNursery == 0 ? '-' : number_format($totalTelephoneAlwNursery, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalTransportAlwNursery == 0 ? '-' : number_format($totalTransportAlwNursery, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalTotalOvertimeNursery == 0 ? '-' : number_format($totalTotalOvertimeNursery, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalTotalIncentiveNursery == 0 ? '-' : number_format($totalTotalIncentiveNursery, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalBrutoSalaryNursery == 0 ? '-' : number_format($totalBrutoSalaryNursery, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalPinjamanNursery == 0 ? '-' : number_format($totalPinjamanNursery, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalBpjsNursery == 0 ? '-' : number_format($totalBpjsNursery, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalJamsostekNursery == 0 ? '-' : number_format($totalJamsostekNursery, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalSPSINursery == 0 ? '-' : number_format($totalSPSINursery, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalOtherNursery == 0 ? '-' : number_format($totalOtherNursery, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $subTotalElectricityNursery == 0 ? '-' : number_format($subTotalElectricityNursery, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalDeductionNursery == 0 ? '-' : number_format($totalDeductionNursery, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalSalaryNettoNursery == 0 ? '-' : number_format($totalSalaryNettoNursery, 0) }}</td>
            </tr>

            <tr>
                <td style="vertical-align: text-top;text-align: center;">4</td>
                <td>- RSS Factory</td>
                <td style="text-align: center">
                    {{ $totalAllocationRSSFactory == 0 ? '-' : number_format($totalAllocationRSSFactory, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $subTotalRateSalaryRSSFactory == 0 ? '-' : number_format($subTotalRateSalaryRSSFactory, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalAbilityRSSFactory == 0 ? '-' : number_format($totalAbilityRSSFactory, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalSkillAlwRSSFactory == 0 ? '-' : number_format($totalSkillAlwRSSFactory, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalFamilyAlwRSSFactory == 0 ? '-' : number_format($totalFamilyAlwRSSFactory, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalTelephoneAlwRSSFactory == 0 ? '-' : number_format($totalTelephoneAlwRSSFactory, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalTransportAlwRSSFactory == 0 ? '-' : number_format($totalTransportAlwRSSFactory, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalTotalOvertimeRSSFactory == 0 ? '-' : number_format($totalTotalOvertimeRSSFactory, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalTotalIncentiveRSSFactory == 0 ? '-' : number_format($totalTotalIncentiveRSSFactory, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalBrutoSalaryRSSFactory == 0 ? '-' : number_format($totalBrutoSalaryRSSFactory, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalPinjamanRSSFactory == 0 ? '-' : number_format($totalPinjamanRSSFactory, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalBpjsRSSFactory == 0 ? '-' : number_format($totalBpjsRSSFactory, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalJamsostekRSSFactory == 0 ? '-' : number_format($totalJamsostekRSSFactory, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalSPSIRSSFactory == 0 ? '-' : number_format($totalSPSIRSSFactory, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalOtherRSSFactory == 0 ? '-' : number_format($totalOtherRSSFactory, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $subTotalElectricityRSSFactory == 0 ? '-' : number_format($subTotalElectricityRSSFactory, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalDeductionRSSFactory == 0 ? '-' : number_format($totalDeductionRSSFactory, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalSalaryNettoRSSFactory == 0 ? '-' : number_format($totalSalaryNettoRSSFactory, 0) }}</td>
            </tr>

            <tr>
                <td style="vertical-align: text-top;text-align: center;">5</td>
                <td>- RSS Factory Grading & Proces</td>
                <td style="text-align: center">
                    {{ $totalAllocationRSSFactoryGradingProces == 0 ? '-' : number_format($totalAllocationRSSFactoryGradingProces, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $subTotalRateSalaryRSSFactoryGradingProces == 0 ? '-' : number_format($subTotalRateSalaryRSSFactoryGradingProces, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalAbilityRSSFactoryGradingProces == 0 ? '-' : number_format($totalAbilityRSSFactoryGradingProces, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalSkillAlwRSSFactoryGradingProces == 0 ? '-' : number_format($totalSkillAlwRSSFactoryGradingProces, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalFamilyAlwRSSFactoryGradingProces == 0 ? '-' : number_format($totalFamilyAlwRSSFactoryGradingProces, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalTelephoneAlwRSSFactoryGradingProces == 0 ? '-' : number_format($totalTelephoneAlwRSSFactoryGradingProces, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalTransportAlwRSSFactoryGradingProces == 0 ? '-' : number_format($totalTransportAlwRSSFactoryGradingProces, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalTotalOvertimeRSSFactoryGradingProces == 0 ? '-' : number_format($totalTotalOvertimeRSSFactoryGradingProces, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalTotalIncentiveRSSFactoryGradingProces == 0 ? '-' : number_format($totalTotalIncentiveRSSFactoryGradingProces, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalBrutoSalaryRSSFactoryGradingProces == 0 ? '-' : number_format($totalBrutoSalaryRSSFactoryGradingProces, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalPinjamanRSSFactoryGradingProces == 0 ? '-' : number_format($totalPinjamanRSSFactoryGradingProces, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalBpjsRSSFactoryGradingProces == 0 ? '-' : number_format($totalBpjsRSSFactoryGradingProces, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalJamsostekRSSFactoryGradingProces == 0 ? '-' : number_format($totalJamsostekRSSFactoryGradingProces, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalSPSIRSSFactoryGradingProces == 0 ? '-' : number_format($totalSPSIRSSFactoryGradingProces, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalOtherRSSFactoryGradingProces == 0 ? '-' : number_format($totalOtherRSSFactoryGradingProces, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $subTotalElectricityRSSFactoryGradingProces == 0 ? '-' : number_format($subTotalElectricityRSSFactoryGradingProces, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalDeductionRSSFactoryGradingProces == 0 ? '-' : number_format($totalDeductionRSSFactoryGradingProces, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalSalaryNettoRSSFactoryGradingProces == 0 ? '-' : number_format($totalSalaryNettoRSSFactoryGradingProces, 0) }}
                </td>
            </tr>

            <tr>
                <td rowspan="5" style="vertical-align: text-top;text-align: center;">6</td>
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
                <td style="text-align: center">
                    {{ $totalAllocationOffice == 0 ? '-' : number_format($totalAllocationOffice, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $subTotalRateSalaryOffice == 0 ? '-' : number_format($subTotalRateSalaryOffice, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalAbilityOffice == 0 ? '-' : number_format($totalAbilityOffice, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalSkillAlwOffice == 0 ? '-' : number_format($totalSkillAlwOffice, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalFamilyAlwOffice == 0 ? '-' : number_format($totalFamilyAlwOffice, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalTelephoneAlwOffice == 0 ? '-' : number_format($totalTelephoneAlwOffice, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalTransportAlwOffice == 0 ? '-' : number_format($totalTransportAlwOffice, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalTotalOvertimeOffice == 0 ? '-' : number_format($totalTotalOvertimeOffice, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalTotalIncentiveOffice == 0 ? '-' : number_format($totalTotalIncentiveOffice, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalBrutoSalaryOffice == 0 ? '-' : number_format($totalBrutoSalaryOffice, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalPinjamanOffice == 0 ? '-' : number_format($totalPinjamanOffice, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalBpjsOffice == 0 ? '-' : number_format($totalBpjsOffice, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalJamsostekOffice == 0 ? '-' : number_format($totalJamsostekOffice, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalSPSIOffice == 0 ? '-' : number_format($totalSPSIOffice, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalOtherOffice == 0 ? '-' : number_format($totalOtherOffice, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $subTotalElectricityOffice == 0 ? '-' : number_format($subTotalElectricityOffice, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalDeductionOffice == 0 ? '-' : number_format($totalDeductionOffice, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalSalaryNettoOffice == 0 ? '-' : number_format($totalSalaryNettoOffice, 0) }}</td>
            </tr>

            <tr>
                <td>- Security</td>
                <td style="text-align: center">
                    {{ $totalAllocationSecurity == 0 ? '-' : number_format($totalAllocationSecurity, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $subTotalRateSalarySecurity == 0 ? '-' : number_format($subTotalRateSalarySecurity, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalAbilitySecurity == 0 ? '-' : number_format($totalAbilitySecurity, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalSkillAlwSecurity == 0 ? '-' : number_format($totalSkillAlwSecurity, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalFamilyAlwSecurity == 0 ? '-' : number_format($totalFamilyAlwSecurity, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalTelephoneAlwSecurity == 0 ? '-' : number_format($totalTelephoneAlwSecurity, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalTransportAlwSecurity == 0 ? '-' : number_format($totalTransportAlwSecurity, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalTotalOvertimeSecurity == 0 ? '-' : number_format($totalTotalOvertimeSecurity, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalTotalIncentiveSecurity == 0 ? '-' : number_format($totalTotalIncentiveSecurity, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalBrutoSalarySecurity == 0 ? '-' : number_format($totalBrutoSalarySecurity, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalPinjamanSecurity == 0 ? '-' : number_format($totalPinjamanSecurity, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalBpjsSecurity == 0 ? '-' : number_format($totalBpjsSecurity, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalJamsostekSecurity == 0 ? '-' : number_format($totalJamsostekSecurity, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalSPSISecurity == 0 ? '-' : number_format($totalSPSISecurity, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalOtherSecurity == 0 ? '-' : number_format($totalOtherSecurity, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $subTotalElectricitySecurity == 0 ? '-' : number_format($subTotalElectricitySecurity, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalDeductionSecurity == 0 ? '-' : number_format($totalDeductionSecurity, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalSalaryNettoSecurity == 0 ? '-' : number_format($totalSalaryNettoSecurity, 0) }}</td>
            </tr>

            <tr>
                <td>- Workshop</td>
                <td style="text-align: center">
                    {{ $totalAllocationWorkshop == 0 ? '-' : number_format($totalAllocationWorkshop, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $subTotalRateSalaryWorkshop == 0 ? '-' : number_format($subTotalRateSalaryWorkshop, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalAbilityWorkshop == 0 ? '-' : number_format($totalAbilityWorkshop, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalSkillAlwWorkshop == 0 ? '-' : number_format($totalSkillAlwWorkshop, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalFamilyAlwWorkshop == 0 ? '-' : number_format($totalFamilyAlwWorkshop, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalTelephoneAlwWorkshop == 0 ? '-' : number_format($totalTelephoneAlwWorkshop, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalTransportAlwWorkshop == 0 ? '-' : number_format($totalTransportAlwWorkshop, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalTotalOvertimeWorkshop == 0 ? '-' : number_format($totalTotalOvertimeWorkshop, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalTotalIncentiveWorkshop == 0 ? '-' : number_format($totalTotalIncentiveWorkshop, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalBrutoSalaryWorkshop == 0 ? '-' : number_format($totalBrutoSalaryWorkshop, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalPinjamanWorkshop == 0 ? '-' : number_format($totalPinjamanWorkshop, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalBpjsWorkshop == 0 ? '-' : number_format($totalBpjsWorkshop, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalJamsostekWorkshop == 0 ? '-' : number_format($totalJamsostekWorkshop, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalSPSIWorkshop == 0 ? '-' : number_format($totalSPSIWorkshop, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalOtherWorkshop == 0 ? '-' : number_format($totalOtherWorkshop, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $subTotalElectricityWorkshop == 0 ? '-' : number_format($subTotalElectricityWorkshop, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalDeductionWorkshop == 0 ? '-' : number_format($totalDeductionWorkshop, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalSalaryNettoWorkshop == 0 ? '-' : number_format($totalSalaryNettoWorkshop, 0) }}</td>
            </tr>

            <tr>
                <td>- Operator</td>
                <td style="text-align: center">
                    {{ $totalAllocationOperator == 0 ? '-' : number_format($totalAllocationOperator, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $subTotalRateSalaryOperator == 0 ? '-' : number_format($subTotalRateSalaryOperator, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalAbilityOperator == 0 ? '-' : number_format($totalAbilityOperator, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalSkillAlwOperator == 0 ? '-' : number_format($totalSkillAlwOperator, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalFamilyAlwOperator == 0 ? '-' : number_format($totalFamilyAlwOperator, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalTelephoneAlwOperator == 0 ? '-' : number_format($totalTelephoneAlwOperator, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalTransportAlwOperator == 0 ? '-' : number_format($totalTransportAlwOperator, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalTotalOvertimeOperator == 0 ? '-' : number_format($totalTotalOvertimeOperator, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalTotalIncentiveOperator == 0 ? '-' : number_format($totalTotalIncentiveOperator, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalBrutoSalaryOperator == 0 ? '-' : number_format($totalBrutoSalaryOperator, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalPinjamanOperator == 0 ? '-' : number_format($totalPinjamanOperator, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalBpjsOperator == 0 ? '-' : number_format($totalBpjsOperator, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalJamsostekOperator == 0 ? '-' : number_format($totalJamsostekOperator, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalSPSIOperator == 0 ? '-' : number_format($totalSPSIOperator, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalOtherOperator == 0 ? '-' : number_format($totalOtherOperator, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $subTotalElectricityOperator == 0 ? '-' : number_format($subTotalElectricityOperator, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalDeductionOperator == 0 ? '-' : number_format($totalDeductionOperator, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalSalaryNettoOperator == 0 ? '-' : number_format($totalSalaryNettoOperator, 0) }}</td>
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
                    {{ $grandTotalIncentive == 0 ? '-' : number_format($grandTotalIncentive, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $grandTotalBrutoSalary == 0 ? '-' : number_format($grandTotalBrutoSalary, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $grandTotalLoan == 0 ? '-' : number_format($grandTotalLoan, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $grandTotalBpjs == 0 ? '-' : number_format($grandTotalBpjs, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $grandTotalAstek == 0 ? '-' : number_format($grandTotalAstek, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $grandTotalUnion == 0 ? '-' : number_format($grandTotalUnion, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $grandTotalOther == 0 ? '-' : number_format($grandTotalOther, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $grandTotalElectricity == 0 ? '-' : number_format($grandTotalElectricity, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $grandTotalDeduction == 0 ? '-' : number_format($grandTotalDeduction, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $grandTotalSalaryNett == 0 ? '-' : number_format($grandTotalSalaryNett, 0) }}</td>
            </tr>
        </tfoot>
    </table>

    <br>

    <table>
        <thead>
            <tr>
                <th rowspan="2">NO.</th>
                <th rowspan="2">NAME</th>
                <th rowspan="2">Total<br>Person</th>
                <th colspan="8">SALARY</th>
                <th rowspan="2">TOTAL SALARY<br>BRUTO</th>
                <th colspan="6">DEDUCTION</th>
                <th rowspan="2">TOTAL<br>DEDUCTION</th>
                <th rowspan="2">TOTAL SALARY<br>NETTO</th>
            </tr>
            <tr>
                <th style="padding: 8px;">Grade</th>
                <th style="padding: 8px;">Ability</th>
                <th style="padding: 6px;">Skill<br>All</th>
                <th style="padding: 6px;">Family<br>All</th>
                <th>Telphone<br>All</th>
                <th style="padding: 8px;">Vehicle<br>All</th>
                <th style="padding: 9px;">Over<br>Time</th>
                <th style="padding: 9px;">Incentive</th>
                <th style="padding: 9px;">Loan</th>
                <th style="padding: 9px;">BPJS</th>
                <th style="padding: 7px;">ASTEK</th>
                <th style="padding: 6px;">SPSI</th>
                <th style="padding: 11px;">Kelebihan<br>Gaji</th>
                <th style="padding: 9px;">Electricity</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td rowspan="3" style="vertical-align: text-top;text-align: center;">1</td>
                <td>Kontrak</td>
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
                <td style="text-align: center">
                    {{ $totalAllocationContractBSKPOffice == 0 ? '-' : number_format($totalAllocationContractBSKPOffice, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $subTotalRateSalaryContractBSKPOffice == 0 ? '-' : number_format($subTotalRateSalaryContractBSKPOffice, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalAbilityContractBSKPOffice == 0 ? '-' : number_format($totalAbilityContractBSKPOffice, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalSkillAlwContractBSKPOffice == 0 ? '-' : number_format($totalSkillAlwContractBSKPOffice, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalFamilyAlwContractBSKPOffice == 0 ? '-' : number_format($totalFamilyAlwContractBSKPOffice, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalTelephoneAlwContractBSKPOffice == 0 ? '-' : number_format($totalTelephoneAlwContractBSKPOffice, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalTransportAlwContractBSKPOffice == 0 ? '-' : number_format($totalTransportAlwContractBSKPOffice, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalTotalOvertimeContractBSKPOffice == 0 ? '-' : number_format($totalTotalOvertimeContractBSKPOffice, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalTotalIncentiveContractBSKPOffice == 0 ? '-' : number_format($totalTotalIncentiveContractBSKPOffice, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalBrutoSalaryContractBSKPOffice == 0 ? '-' : number_format($totalBrutoSalaryContractBSKPOffice, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalPinjamanContractBSKPOffice == 0 ? '-' : number_format($totalPinjamanContractBSKPOffice, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalBpjsContractBSKPOffice == 0 ? '-' : number_format($totalBpjsContractBSKPOffice, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalJamsostekContractBSKPOffice == 0 ? '-' : number_format($totalJamsostekContractBSKPOffice, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalSPSIContractBSKPOffice == 0 ? '-' : number_format($totalSPSIContractBSKPOffice, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalOtherContractBSKPOffice == 0 ? '-' : number_format($totalOtherContractBSKPOffice, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $subTotalElectricityContractBSKPOffice == 0 ? '-' : number_format($subTotalElectricityContractBSKPOffice, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalDeductionContractBSKPOffice == 0 ? '-' : number_format($totalDeductionContractBSKPOffice, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalSalaryNettoContractBSKPOffice == 0 ? '-' : number_format($totalSalaryNettoContractBSKPOffice, 0) }}
                </td>
            </tr>
            <tr>
                <td>- Workshop</td>
                <td style="text-align: center">
                    {{ $totalAllocationContractBSKPWorkshop == 0 ? '-' : number_format($totalAllocationContractBSKPWorkshop, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $subTotalRateSalaryContractBSKPWorkshop == 0 ? '-' : number_format($subTotalRateSalaryContractBSKPWorkshop, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalAbilityContractBSKPWorkshop == 0 ? '-' : number_format($totalAbilityContractBSKPWorkshop, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalSkillAlwContractBSKPWorkshop == 0 ? '-' : number_format($totalSkillAlwContractBSKPWorkshop, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalFamilyAlwContractBSKPWorkshop == 0 ? '-' : number_format($totalFamilyAlwContractBSKPWorkshop, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalTelephoneAlwContractBSKPWorkshop == 0 ? '-' : number_format($totalTelephoneAlwContractBSKPWorkshop, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalTransportAlwContractBSKPWorkshop == 0 ? '-' : number_format($totalTransportAlwContractBSKPWorkshop, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalTotalOvertimeContractBSKPWorkshop == 0 ? '-' : number_format($totalTotalOvertimeContractBSKPWorkshop, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalTotalIncentiveContractBSKPWorkshop == 0 ? '-' : number_format($totalTotalIncentiveContractBSKPWorkshop, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalBrutoSalaryContractBSKPWorkshop == 0 ? '-' : number_format($totalBrutoSalaryContractBSKPWorkshop, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalPinjamanContractBSKPWorkshop == 0 ? '-' : number_format($totalPinjamanContractBSKPWorkshop, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalBpjsContractBSKPWorkshop == 0 ? '-' : number_format($totalBpjsContractBSKPWorkshop, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalJamsostekContractBSKPWorkshop == 0 ? '-' : number_format($totalJamsostekContractBSKPWorkshop, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalSPSIContractBSKPWorkshop == 0 ? '-' : number_format($totalSPSIContractBSKPWorkshop, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalOtherContractBSKPWorkshop == 0 ? '-' : number_format($totalOtherContractBSKPWorkshop, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $subTotalElectricityContractBSKPWorkshop == 0 ? '-' : number_format($subTotalElectricityContractBSKPWorkshop, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalDeductionContractBSKPWorkshop == 0 ? '-' : number_format($totalDeductionContractBSKPWorkshop, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $totalSalaryNettoContractBSKPWorkshop == 0 ? '-' : number_format($totalSalaryNettoContractBSKPWorkshop, 0) }}
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2" style="text-align: center">Total</td>
                <td style="text-align: center">
                    {{ $grandTotalPersonKontrak == 0 ? '-' : number_format($grandTotalPersonKontrak, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $grandTotalGradeKontrak == 0 ? '-' : number_format($grandTotalGradeKontrak, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $grandTotalAbilityKontrak == 0 ? '-' : number_format($grandTotalAbilityKontrak, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $grandTotalFungtionalAlwKontrak == 0 ? '-' : number_format($grandTotalFungtionalAlwKontrak, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $grandTotalFamilyAlwKontrak == 0 ? '-' : number_format($grandTotalFamilyAlwKontrak, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $grandTotalTelpAwlKontrak == 0 ? '-' : number_format($grandTotalTelpAwlKontrak, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $grandTotalVehicleAlwKontrak == 0 ? '-' : number_format($grandTotalVehicleAlwKontrak, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $grandTotalOTKontrak == 0 ? '-' : number_format($grandTotalOTKontrak, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $grandTotalIncentiveKontrak == 0 ? '-' : number_format($grandTotalIncentiveKontrak, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $grandTotalBrutoSalaryKontrak == 0 ? '-' : number_format($grandTotalBrutoSalaryKontrak, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $grandTotalLoanKontrak == 0 ? '-' : number_format($grandTotalLoanKontrak, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $grandTotalBpjsKontrak == 0 ? '-' : number_format($grandTotalBpjsKontrak, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $grandTotalAstekKontrak == 0 ? '-' : number_format($grandTotalAstekKontrak, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $grandTotalUnionKontrak == 0 ? '-' : number_format($grandTotalUnionKontrak, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $grandTotalOtherKontrak == 0 ? '-' : number_format($grandTotalOtherKontrak, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $grandTotalElectricityKontrak == 0 ? '-' : number_format($grandTotalElectricityKontrak, 0) }}
                </td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $grandTotalDeductionKontrak == 0 ? '-' : number_format($grandTotalDeductionKontrak, 0) }}</td>
                <td style="text-align: right; padding-right: 3px;">
                    {{ $grandTotalSalaryNettKontrak == 0 ? '-' : number_format($grandTotalSalaryNettKontrak, 0) }}
                </td>
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
