<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>pdf</title>
    <style>
    @page { margin: 0px; }
    body {
        padding: 0px;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 100%;
        margin:0;
    }

    .container {
        padding:30px 20px;
    }
    
    .container-secondary {
        padding:0px 20px;
    }

    .page-break {
        page-break-after:avoid;
    }
    table, tbody, tr, td{
        padding: 0;
        margin: 0;
    }
    .mt-2{
        margin-top: 1rem;
    }

    .demo-wrap {
    position: relative;
    }

    .demo-wrap:before {
    content: ' ';
    display: block;
    position: absolute;
    left: 0;
    /* top: -70px; */
    top: 0px;
    width: 100%;
    height: 100%;
    opacity: 0.2;
    background-image: url('{{ public_path('storage/water-mark.png') }}');
    background-size: auto;
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-position: center;
    /* background-size: 700px 950px; */
    }
    </style>
</head>

<body>
    <div class="page-break">
        <div class="">
            <table style="width: 100%;border-spacing: 0;">
                <tbody style="width:100%">
                    <tr>
                        <td style="background: #031e55; color:white;width:5%;text-align:center;padding:0px 5px;"></td>
                        <td style="width:32%;text-align:center;padding:0px 5px;"><img src="{{ public_path('storage/jurysoft-black.png') }}" style="width:100%;object-fit:contain;margin:auto;" /></td>
                        <td style="background: #eb4f57; color:white;width:21%;text-align:center;font-weight:bold;font-size:14px;padding:0px 5px;">JURYSOFT GLOBAL<br/>PRIVATE LIMITED</td>
                        <td style="background: #47a8d3; color:white;width:21%;text-align:center;padding:0px 5px;font-size:14px;">#477, Jawaharlal Nehru<br/>Road, RR Nagar, B'lore</td>
                        <td style="background: #69a919; color:white;width:21%;text-align:center;font-weight:bold;padding:0px 5px;font-size:14px;">E : info@jurysoft.com<br/>W : www.jurysoft.com</td>
                    </tr>
                </tbody>
            </table>
        </div>
        {{-- <div style="width:100%;background-image:url('{{ public_path('storage/water-mark.png') }}');background-repeat: no-repeat;background-attachment: fixed;background-position: center;background-size: auto;"> --}}
        <div class="demo-wrap">
            <div class="container">
                <table style="width: 100%;border-spacing: 0;border-top:2px solid black;border-bottom:2px solid black;">
                    <tbody style="width:100%">
                        <tr>
                            <td style="text-align:center;font-weight:bold;width:25%;padding:8px 0;">Pay Slip for the Month of</td>
                            <td style="text-align:center;width:25%;padding:8px 0;">{{$payslip->month_year_formatted}}</td>
                            <td style="text-align:center;font-weight:bold;width:25%;padding:8px 0;">EMP No</td>
                            <td style="text-align:center;width:25%;padding:8px 0;">{{$payslip->user->jurysoft_id}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="container-secondary">
                <table style="width: 100%;border-spacing: 0;margin-top:5px;border-bottom:2px solid black;">
                    <tbody style="width:100%">
                        <tr>
                            <td style="width:33.3%;">
                                <table style="width: 100%;border-spacing: 0;">
                                    <tbody style="width:100%">
                                        <tr>
                                            <td style="width:40%;font-weight:bold;padding:8px 0;">Name</td>
                                            <td style="width:60%;padding:8px 0;">{{$payslip->user->full_name}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                            <td style="width:33.3%;">
                                <table style="width: 100%;border-spacing: 0;">
                                    <tbody style="width:100%">
                                        <tr>
                                            <td style="width:40%;font-weight:bold;padding:8px 0;">Designation</td>
                                            <td style="width:60%;padding:8px 0;">{{$payslip->user->EmployeeJobDetail->Designation->name}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                            <td style="width:33.3%;">
                                <table style="width: 100%;border-spacing: 0;">
                                    <tbody style="width:100%">
                                        <tr>
                                            <td style="width:40%;font-weight:bold;padding:8px 0;">Department</td>
                                            <td style="width:60%;padding:8px 0;">{{$payslip->user->EmployeeJobDetail->Department->name}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:33.3%;">
                                <table style="width: 100%;border-spacing: 0;">
                                    <tbody style="width:100%">
                                        <tr>
                                            <td style="width:40%;font-weight:bold;padding:8px 0;">Bank</td>
                                            <td style="width:60%;padding:8px 0;">{{$payslip->user->EmployeeBankDetail->bank_name}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                            <td style="width:33.3%;">
                                <table style="width: 100%;border-spacing: 0;">
                                    <tbody style="width:100%">
                                        <tr>
                                            <td style="width:40%;font-weight:bold;padding:8px 0;">Bank A/c No</td>
                                            <td style="width:60%;padding:8px 0;">{{$payslip->user->EmployeeBankDetail->account_no}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                            <td style="width:33.3%;">
                                <table style="width: 100%;border-spacing: 0;">
                                    <tbody style="width:100%">
                                        <tr>
                                            <td style="width:40%;font-weight:bold;padding:8px 0;">PAN No</td>
                                            <td style="width:60%;padding:8px 0;">{{$payslip->user->EmployeePersonalDetail->pan}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="container-secondary">
                <table style="width: 100%;border-spacing: 0;margin-top:25px;border-bottom:2px solid black;">
                    <tbody style="width:100%">
                        <tr>
                            <td style="width:33.3%;">
                                <table style="width: 100%;border-spacing: 0;">
                                    <tbody style="width:100%">
                                        <tr>
                                            <td style="width:60%;font-weight:bold;padding:8px 0;">Working Days</td>
                                            <td style="width:40%;padding:8px 0;">{{$payslip->working_days_of_month}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                            <td style="width:33.3%;">
                                <table style="width: 100%;border-spacing: 0;">
                                    <tbody style="width:100%">
                                        <tr>
                                            <td style="width:60%;font-weight:bold;padding:8px 0;">Days Worked</td>
                                            <td style="width:40%;padding:8px 0;">{{$payslip->worked_days}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                            <td style="width:33.3%;">
                                <table style="width: 100%;border-spacing: 0;">
                                    <tbody style="width:100%">
                                        <tr>
                                            <td style="width:60%;font-weight:bold;padding:8px 0;">Arrear Days</td>
                                            <td style="width:40%;padding:8px 0;">{{$payslip->arrears_days}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:33.3%;">
                                <table style="width: 100%;border-spacing: 0;">
                                    <tbody style="width:100%">
                                        <tr>
                                            <td style="width:60%;font-weight:bold;padding:8px 0;">Paid Leave Taken</td>
                                            <td style="width:40%;padding:8px 0;">{{$payslip->paid_leave_taken}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                            <td style="width:33.3%;">
                                <table style="width: 100%;border-spacing: 0;">
                                    <tbody style="width:100%">
                                        <tr>
                                            <td style="width:60%;font-weight:bold;padding:8px 0;">Unpaid Leave Taken</td>
                                            <td style="width:40%;padding:8px 0;">{{$payslip->unpaid_leave_taken}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                            <td style="width:33.3%;"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="container-secondary">
                <table style="width: 100%;border-spacing: 0;margin-top:25px;border:2px solid black;">
                    <thead style="width:100%;background:#ff9a01;">
                        <tr>
                            <th style="text-align:center;font-weight:bold;padding:8px 0px;border-right:2px solid black;">Salary Components</th>
                            <th style="text-align:center;font-weight:bold;padding:8px 0px;border-right:2px solid black;">Actual (A)</th>
                            <th style="text-align:center;font-weight:bold;padding:8px 0px;border-right:2px solid black;">Arrears (B)</th>
                            <th style="text-align:center;font-weight:bold;padding:8px 0px;border-right:2px solid black;">Amount (A+B)</th>
                            <th style="text-align:center;font-weight:bold;padding:8px 0px;border-right:2px solid black;">Deductions</th>
                            <th style="text-align:center;font-weight:bold;padding:8px 0px;">Amount</th>
                        </tr>
                    </thead>
                    <tbody style="width:100%">
                        <tr>
                            <td style="font-weight:bold;padding:10px 5px;border-right:2px solid black;background:#a4c2f4;">Fixed</td>
                            <td style="padding:10px 5px;border-right:2px solid black;"></td>
                            <td style="padding:10px 5px;border-right:2px solid black;"></td>
                            <td style="padding:10px 5px;border-right:2px solid black;"></td>
                            <td style="font-weight:bold;padding:10px 5px;border-right:2px solid black;">Provident Fund</td>
                            <td style="padding:10px 5px;">Rs. {{$payslip->pf_employee}}.0</td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold;padding:10px 5px;border-right:2px solid black;">Basic</td>
                            <td style="padding:10px 5px;border-right:2px solid black;">Rs. {{$payslip->basic_salary}}.0</td>
                            <td style="padding:10px 5px;border-right:2px solid black;">Rs. {{$payslip->basic_salary_arrears}}.0</td>
                            <td style="padding:10px 5px;border-right:2px solid black;">Rs. {{$payslip->basic_salary + $payslip->basic_salary_arrears}}.0</td>
                            <td style="font-weight:bold;padding:10px 5px;border-right:2px solid black;">ESIC</td>
                            <td style="padding:10px 5px;">Rs. {{$payslip->esi_employee}}.0</td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold;padding:10px 5px;border-right:2px solid black;">House Rent Allowance.</td>
                            <td style="padding:10px 5px;border-right:2px solid black;">Rs. {{$payslip->hra_amount}}.0</td>
                            <td style="padding:10px 5px;border-right:2px solid black;">Rs. {{$payslip->hra_amount_arrears}}.0</td>
                            <td style="padding:10px 5px;border-right:2px solid black;">Rs. {{$payslip->hra_amount + $payslip->hra_amount_arrears}}.0</td>
                            <td style="font-weight:bold;padding:10px 5px;border-right:2px solid black;">Group Insurance</td>
                            <td style="padding:10px 5px;">Rs. 0.0</td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold;padding:10px 5px;border-right:2px solid black;">Conveyance Allowance</td>
                            <td style="padding:10px 5px;border-right:2px solid black;">Rs. {{$payslip->conveyance_allowance}}.0</td>
                            <td style="padding:10px 5px;border-right:2px solid black;">Rs. {{$payslip->allow_arrears==1 ? $payslip->conveyance_allowance : 0}}.0</td>
                            <td style="padding:10px 5px;border-right:2px solid black;">Rs. {{$payslip->conveyance_allowance * ($payslip->allow_arrears==1 ? 2 : 1)}}.0</td>
                            <td style="font-weight:bold;padding:10px 5px;border-right:2px solid black;">Profession Tax</td>
                            <td style="padding:10px 5px;">Rs. {{$payslip->professional_tax}}.0</td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold;padding:10px 5px;border-right:2px solid black;">Medical Allowance</td>
                            <td style="padding:10px 5px;border-right:2px solid black;">Rs. {{$payslip->medical_allowance}}.0</td>
                            <td style="padding:10px 5px;border-right:2px solid black;">Rs. {{$payslip->allow_arrears==1 ? $payslip->medical_allowance : 0}}.0</td>
                            <td style="padding:10px 5px;border-right:2px solid black;">Rs. {{$payslip->medical_allowance * ($payslip->allow_arrears==1 ? 2 : 1)}}.0</td>
                            <td style="font-weight:bold;padding:10px 5px;border-right:2px solid black;">Income Tax</td>
                            <td style="padding:10px 5px;">Rs. 0.0</td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold;padding:10px 5px;border-right:2px solid black;">Special Allowance</td>
                            <td style="padding:10px 5px;border-right:2px solid black;">Rs. {{$payslip->special_allowance}}.0</td>
                            <td style="padding:10px 5px;border-right:2px solid black;">Rs. {{$payslip->special_allowance_arrears}}.0</td>
                            <td style="padding:10px 5px;border-right:2px solid black;">Rs. {{$payslip->special_allowance + $payslip->special_allowance_arrears}}.0</td>
                            <td style="font-weight:bold;padding:10px 5px;border-right:2px solid black;"></td>
                            <td style="padding:10px 5px;"></td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold;padding:10px 5px;border-right:2px solid black;background:#a4c2f4;">Variable</td>
                            <td style="padding:10px 5px;border-right:2px solid black;"></td>
                            <td style="padding:10px 5px;border-right:2px solid black;"></td>
                            <td style="padding:10px 5px;border-right:2px solid black;"></td>
                            <td style="font-weight:bold;padding:10px 5px;border-right:2px solid black;"></td>
                            <td style="padding:10px 5px;"></td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold;padding:10px 5px;border-right:2px solid black;">Incentive</td>
                            <td style="padding:10px 5px;border-right:2px solid black;">Rs. 0.0</td>
                            <td style="padding:10px 5px;border-right:2px solid black;">Rs. 0.0</td>
                            <td style="padding:10px 5px;border-right:2px solid black;">Rs. 0.0</td>
                            <td style="font-weight:bold;padding:10px 5px;border-right:2px solid black;"></td>
                            <td style="padding:10px 5px;"></td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold;padding:10px 5px;border-right:2px solid black;">Overtime</td>
                            <td style="padding:10px 5px;border-right:2px solid black;">Rs. 0.0</td>
                            <td style="padding:10px 5px;border-right:2px solid black;">Rs. 0.0</td>
                            <td style="padding:10px 5px;border-right:2px solid black;">Rs. 0.0</td>
                            <td style="font-weight:bold;padding:10px 5px;border-right:2px solid black;"></td>
                            <td style="padding:10px 5px;"></td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold;padding:10px 5px;border-right:2px solid black;">Bonus</td>
                            <td style="padding:10px 5px;border-right:2px solid black;">Rs. 0.0</td>
                            <td style="padding:10px 5px;border-right:2px solid black;">Rs. 0.0</td>
                            <td style="padding:10px 5px;border-right:2px solid black;">Rs. 0.0</td>
                            <td style="font-weight:bold;padding:10px 5px;border-right:2px solid black;"></td>
                            <td style="padding:10px 5px;"></td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold;padding:10px 5px;border-right:2px solid black;border-top:2px solid black;text-align:center;">Total</td>
                            <td style="font-weight:bold;padding:10px 5px;border-right:2px solid black;border-top:2px solid black;">Rs. {{$payslip->total_gross}}.0</td>
                            <td style="font-weight:bold;padding:10px 5px;border-right:2px solid black;border-top:2px solid black;">Rs. {{$payslip->total_gross_arrears}}.0</td>
                            <td style="font-weight:bold;padding:10px 5px;border-right:2px solid black;border-top:2px solid black;">Rs. {{$payslip->total_gross + $payslip->total_gross_arrears}}.0</td>
                            <td style="font-weight:bold;padding:10px 5px;border-right:2px solid black;"></td>
                            <td style="padding:10px 5px;"></td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold;padding:10px 5px;border-right:2px solid black;border-top:2px solid black;text-align:center;" colspan="3">Gross Salary (C)</td>
                            <td style="font-weight:bold;padding:10px 5px;border-right:2px solid black;border-top:2px solid black;">Rs. {{$payslip->total_gross + $payslip->total_gross_arrears}}.0</td>
                            <td style="font-weight:bold;padding:10px 5px;border-right:2px solid black;border-top:2px solid black;">Total Deductions (D)</td>
                            <td style="font-weight:bold;padding:10px 5px;border-top:2px solid black;">Rs. {{$payslip->deduction_amount}}.0</td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold;padding:10px 5px;border-right:2px solid black;border-top:2px solid black;text-align:center;" colspan="4">Net Pay (C-D)</td>
                            <td style="font-weight:bold;padding:10px 5px;border-top:2px solid black;text-align:center;" colspan="2">Rs. {{$payslip->net_salary + $payslip->net_salary_arrears}}.0</td>
                        </tr>
                        <tr>
                            <td style="padding:10px 5px;border-top:2px solid black;text-align:center;" colspan="6">
                                <table style="width: 100%;border-spacing: 0;">
                                    <tbody style="width: 100%;">
                                        <tr>
                                            <td style="width: 80%;text-align:center;">
                                            <span style="font-weight: bold;font-size:16px">
                                                (Rupees Fifteen Thousand Seven Hundred Fifteen Only)
                                            </span>
                                            <br/><br/>
                                            <span style="font-size: 13px;">
                                                Note: This is a system generated statement, hence need not be signed.
                                            </span>
                                            </td>
                                            <td style="width: 20%;">
                                                <img src="{{ public_path('storage/stamp.png') }}" style="height:70px;object-fit:contain;margin:auto;" />
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div style="margin-top:35.5px">
            <table style="width: 100%;border-spacing: 0;">
                <tbody style="width:100%">
                    <tr>
                        <td style="background: #eb4f57; color:white;width:21%;text-align:center;font-weight:bold;font-size:14px;padding:0px 5px;"></td>
                        <td style="background: #47a8d3; color:white;width:21%;text-align:center;padding:0px 5px;font-size:14px;"></td>
                        <td style="background: #69a919; color:white;width:21%;text-align:center;font-weight:bold;padding:0px 5px;font-size:14px;"></td>
                        <td style="width:32%;text-align:center;padding:0px 5px;"><img src="{{ public_path('storage/jurysoft-black.png') }}" style="height:55px;object-fit:contain;margin:auto;" /></td>
                        <td style="background: #031e55; color:white;width:5%;text-align:center;padding:0px 5px;"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>