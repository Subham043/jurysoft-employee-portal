@extends('layouts.admin.dashboard')



@section('content')

<link rel="stylesheet" href="{{ asset('admin/css/image-previewer.css')}}" type="text/css" />

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Payslip</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Payslip</a></li>
                            <li class="breadcrumb-item active">View</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row g-4 mb-3">
                            <div class="col-sm-auto">
                                <div>
                                    <a href="{{url()->previous()}}" type="button" class="btn btn-dark add-btn" id="create-btn"><i class="ri-arrow-go-back-line align-bottom me-1"></i> Go Back</a>
                                </div>
                            </div>
                            <div class="col-sm">
                                <div class="d-flex justify-content-sm-end">
                                    <a href="{{route(Auth::user() &&  Auth::user()->userType == 1 || Auth::user()->userType == 3 ? 'payslip_pdf' : 'payslip_download_request_user_get', $country->id)}}" type="button" class="btn btn-secondary add-btn me-2" id="create-btn"><i class="ri-download-fill align-bottom me-1"></i> Download</a>
                                    @if(Auth::user() &&  Auth::user()->userType != 2)
                                    <a href="{{route('payslip_edit', $country->id)}}" type="button" class="btn btn-success add-btn me-2" id="create-btn"><i class="ri-edit-line align-bottom me-1"></i> Edit</a>
                                    @endif
                                    @if(Auth::user() &&  Auth::user()->userType == 1)
                                    <button onclick="deleteHandler('{{route('payslip_delete', $country->id)}}')" type="button" class="btn btn-danger add-btn" id="create-btn"><i class="ri-delete-bin-line align-bottom me-1"></i> Delete</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="text-muted">
                            <div class="pt-3 pb-3 mt-4">
                                <div class="row">

                                    <div class="col-lg-12 col-sm-12 text-center">
                                        <hr/>
                                        <h3>Payslip Detail</h3>
                                        <hr/>
                                    </div>
                                </div>
                            </div>
                            <div class="pt-1 pb-3 border-bottom border-bottom-dashed">
                                <div class="row">
                                    
                                    <div class="col-lg-3 col-sm-6">
                                        <div>
                                            <p class="mb-2 text-uppercase fw-medium fs-13">Employee :</p>
                                            <h5 class="fs-15 mb-0">{{$country->user ? $country->user->full_name : ''}}~{{$country->user ? $country->user->jurysoft_id : ''}}</h5>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6">
                                        <div>
                                            <p class="mb-2 text-uppercase fw-medium fs-13">Payslip Month & Year :</p>
                                            <h5 class="fs-15 mb-0">{{$country->month_year_formatted}}</h5>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6">
                                        <div>
                                            <p class="mb-2 text-uppercase fw-medium fs-13">Total Days Of Month :</p>
                                            <h5 class="fs-15 mb-0">{{$country->total_days_of_month}}</h5>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6">
                                        <div>
                                            <p class="mb-2 text-uppercase fw-medium fs-13">Working Days Of Month :</p>
                                            <h5 class="fs-15 mb-0">{{$country->working_days_of_month}}</h5>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="pt-3 pb-3 border-bottom border-bottom-dashed mt-4">
                                <div class="row">
                                    <div class="col-lg-3 col-sm-6">
                                        <div>
                                            <p class="mb-2 text-uppercase fw-medium fs-13">Paid Leave Taken :</p>
                                            <h5 class="fs-15 mb-0">{{$country->paid_leave_taken}}</h5>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6">
                                        <div>
                                            <p class="mb-2 text-uppercase fw-medium fs-13">Unpaid Leave Taken :</p>
                                            <h5 class="fs-15 mb-0">{{$country->unpaid_leave_taken}}</h5>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6">
                                        <div>
                                            <p class="mb-2 text-uppercase fw-medium fs-13">Worked Days :</p>
                                            <h5 class="fs-15 mb-0">{{$country->worked_days}}</h5>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6">
                                        <div>
                                            <p class="mb-2 text-uppercase fw-medium fs-13">Create Date :</p>
                                            <h5 class="fs-15 mb-0">{{$country->created_at}}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if($country->allow_arrears==1)
                            <div class="pt-3 pb-3 mt-4">
                                <div class="row">

                                    <div class="col-lg-12 col-sm-12 text-center">
                                        <hr/>
                                        <h3>Arrears Info</h3>
                                        <hr/>
                                    </div>
                                </div>
                            </div>
                            <div class="pt-1 pb-1">
                                <div class="row">
                                    <div class="col-lg-3 col-sm-6">
                                        <div>
                                            <p class="mb-2 text-uppercase fw-medium fs-13">WORKING DAYS OF MONTH :</p>
                                            <h5 class="fs-15 mb-0">{{$country->working_days_of_month_arrears}}</h5>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6">
                                        <div>
                                            <p class="mb-2 text-uppercase fw-medium fs-13">UNPAID LEAVE TAKEN :</p>
                                            <h5 class="fs-15 mb-0">{{$country->unpaid_leave_taken_arrears}}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            <div class="pt-3 pb-3 mt-4">
                                <div class="row">

                                    <div class="col-lg-12 col-sm-12 text-center">
                                        <hr/>
                                        <h3>Employee CTC Info</h3>
                                        <hr/>
                                    </div>
                                </div>
                            </div>
                            <div class="pt-1 pb-1">
                                <div class="row">
                                    <div class="col-lg-3 col-sm-6">
                                        <div>
                                            <p class="mb-2 text-uppercase fw-medium fs-13">Main Gross Salary :</p>
                                            <h5 class="fs-15 mb-0">Rs. {{$country->main_gross_salary}}</h5>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6">
                                        <div>
                                            <p class="mb-2 text-uppercase fw-medium fs-13">Gross Salary For That Month :</p>
                                            <h5 class="fs-15 mb-0">Rs. <span id="gross_salary_for_month">0</span></h5>
                                        </div>
                                    </div>
                                    <div class="col-xxl-12 col-md-12 pt-3">
                                        <table class="table align-middle table-nowrap" id="ctcTable">
                                            <thead class="table-dark">
                                                <tr>
                                                    <th class="sort" data-sort="customer_name">Fixed Allowance</th>
                                                    <th class="sort" data-sort="customer_name">Type</th>
                                                    <th class="sort" data-sort="customer_name">Percentage</th>
                                                    <th class="sort" data-sort="customer_name">Monthly</th>
                                                    <th class="sort" data-sort="customer_name">Yearly</th>
                                                    </tr>
                                            </thead>
                                            <tbody class="list form-check-all">
                                                <tr>
                                                    <td class="customer_name">Basic Salary</td>
                                                    <td class="customer_name">Fully Taxable</td>
                                                    <td class="customer_name">55%</td>
                                                    <td class="customer_name" id="basic_salary_monthly">0</td>
                                                    <td class="customer_name" id="basic_salary_yearly">0</td>
                                                </tr>
                                                <tr>
                                                    <td class="customer_name">HRA</td>
                                                    <td class="customer_name">Tax Exempt</td>
                                                    <td class="customer_name">20%</td>
                                                    <td class="customer_name" id="hra_monthly">0</td>
                                                    <td class="customer_name" id="hra_yearly">0</td>
                                                </tr>
                                                <tr>
                                                    <td class="customer_name">Medical Allowance</td>
                                                    <td class="customer_name">Fully Taxable</td>
                                                    <td class="customer_name">Fixed</td>
                                                    <td class="customer_name">{{$medical_allowance ? 'Rs. '.$medical_allowance->amount : 0}}</td>
                                                    <td class="customer_name">{{$medical_allowance ? 'Rs. '.$medical_allowance->amount * 12 : 0}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="customer_name">Conveyance Allowance</td>
                                                    <td class="customer_name">Fully Taxable</td>
                                                    <td class="customer_name">Fixed</td>
                                                    <td class="customer_name">{{$conveyance_allowance ? 'Rs. '.$conveyance_allowance->amount : 0}}</td>
                                                    <td class="customer_name">{{$conveyance_allowance ? 'Rs. '.$conveyance_allowance->amount * 12 : 0}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="customer_name">Special Allowance</td>
                                                    <td class="customer_name">Fully Taxable</td>
                                                    <td class="customer_name">Balance Amount</td>
                                                    <td class="customer_name" id="special_allowance_monthly">0</td>
                                                    <td class="customer_name" id="special_allowance_yearly">0</td>
                                                </tr>
                                                <tr class="table-primary">
                                                    <th class="customer_name">Total Gross Salary</th>
                                                    <td class="customer_name"></td>
                                                    <td class="customer_name"></td>
                                                    <td class="customer_name" id="total_gross_monthly">0</td>
                                                    <td class="customer_name" id="total_gross_yearly">0</td>
                                                </tr>
                                                <tr>
                                                    <td class="customer_name">PF Contribution By Employee (on Basic)</td>
                                                    <td class="customer_name"></td>
                                                    <td class="customer_name">12%</td>
                                                    <td class="customer_name" id="pf_employee_monthly">0</td>
                                                    <td class="customer_name" id="pf_employee_yearly">0</td>
                                                </tr>
                                                <tr>
                                                    <td class="customer_name">ESI Contribution By Employee (on Gross)</td>
                                                    <td class="customer_name"></td>
                                                    <td class="customer_name">0.75%</td>
                                                    <td class="customer_name" id="esi_employee_monthly">0</td>
                                                    <td class="customer_name" id="esi_employee_yearly">0</td>
                                                </tr>
                                                <tr>
                                                    <td class="customer_name">Professional Tax (PT) (Diffarent for Each State)</td>
                                                    <td class="customer_name"></td>
                                                    <td class="customer_name"></td>
                                                    <td class="customer_name" id="professional_tax_monthly">0</td>
                                                    <td class="customer_name" id="professional_tax_yearly">0</td>
                                                </tr>
                                                <tr class="table-danger">
                                                    <th class="customer_name">Total Deductions (PF+ESI+PT)</th>
                                                    <td class="customer_name"></td>
                                                    <td class="customer_name"></td>
                                                    <td class="customer_name" id="deduction_monthly">0</td>
                                                    <td class="customer_name" id="deduction_yearly">0</td>
                                                </tr>
                                                <tr class="table-success">
                                                    <th class="customer_name">NET SALARY (Gross-Deductions)</th>
                                                    <td class="customer_name"></td>
                                                    <td class="customer_name"></td>
                                                    <td class="customer_name" id="net_salary_monthly">0</td>
                                                    <td class="customer_name" id="net_salary_yearly">0</td>
                                                </tr>
                                                @if(Auth::user() &&  Auth::user()->userType == 1)
                                                <tr>
                                                    <td class="customer_name">Employer PF Contribution (Without Admin Charges)</td>
                                                    <td class="customer_name"></td>
                                                    <td class="customer_name">12%</td>
                                                    <td class="customer_name" id="pf_employer_monthly">0</td>
                                                    <td class="customer_name" id="pf_employer_yearly">0</td>
                                                </tr>
                                                <tr>
                                                    <td class="customer_name">Employer ESI Contribution</td>
                                                    <td class="customer_name"></td>
                                                    <td class="customer_name">3.25%</td>
                                                    <td class="customer_name" id="esi_employer_monthly">0</td>
                                                    <td class="customer_name" id="esi_employer_yearly">0</td>
                                                </tr>
                                                @endif
                                                <tr class="table-secondary">
                                                    <th class="customer_name">CTC = Gross Salary + (Employer PF+ESI))</th>
                                                    <td class="customer_name"></td>
                                                    <td class="customer_name"></td>
                                                    <td class="customer_name" id="ctc_monthly">0</td>
                                                    <td class="customer_name" id="ctc_yearly">0</td>
                                                </tr>
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            

                            
                        </div>
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->
            </div>
        </div>


    </div> <!-- container-fluid -->
</div><!-- End Page-content -->



@stop          

@section('javascript')
<script>
    function deleteHandler(url){
        iziToast.question({
            timeout: 20000,
            close: false,
            overlay: true,
            displayMode: 'once',
            id: 'question',
            zindex: 999,
            title: 'Hey',
            message: 'Are you sure about that?',
            position: 'center',
            buttons: [
                ['<button><b>YES</b></button>', function (instance, toast) {

                    window.location.replace(url);
                    // instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
        
                }, true],
                ['<button>NO</button>', function (instance, toast) {
        
                    instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
        
                }],
            ],
            onClosing: function(instance, toast, closedBy){
                console.info('Closing | closedBy: ' + closedBy);
            },
            onClosed: function(instance, toast, closedBy){
                console.info('Closed | closedBy: ' + closedBy);
            }
        });
    }
</script>
<script>

  let total_days_of_month = {{$country->total_days_of_month ? $country->total_days_of_month : 0}};
  let worked_days = {{$country->worked_days ? $country->worked_days : 0}};
  let working_days_of_month = {{$country->working_days_of_month ? $country->working_days_of_month : 0}};
  let unpaid_leave_taken = {{$country->unpaid_leave_taken ? $country->unpaid_leave_taken : 0}};
  let paid_leave_taken = {{$country->paid_leave_taken ? $country->paid_leave_taken : 0}};

  let medical_allowance = {{$medical_allowance ? (int)$medical_allowance->amount : 0}};
  let conveyance_allowance = {{$conveyance_allowance ? (int)$conveyance_allowance->amount : 0}};

  let main_gross_salary = {{$country->main_gross_salary ? (int)$country->main_gross_salary : 0}};
  let basic_salary_monthly = 0;
  let basic_salary_yearly = 0;
  let hra_monthly = 0;
  let hra_yearly = 0;
  let special_allowance_monthly = 0;
  let special_allowance_yearly = 0;
  let total_gross_monthly = 0;
  let total_gross_yearly = 0;
  let pf_employee_monthly = 0;
  let pf_employee_yearly = 0;
  let esi_employee_monthly = 0;
  let esi_employee_yearly = 0;
  let professional_tax_monthly = 0;
  let professional_tax_yearly = 0;
  let deduction_monthly = 0;
  let deduction_yearly = 0;
  let net_salary_monthly = 0;
  let net_salary_yearly = 0;
  let pf_employer_monthly = 0;
  let pf_employer_yearly = 0;
  let esi_employer_monthly = 0;
  let esi_employer_yearly = 0;
  let ctc_monthly = 0;
  let ctc_yearly = 0;
  let gross_salary_for_month = 0;

  function main_change(){
    gross_salary_for_month_change()
    basic_salary_change()
    hra_change()
    special_allowance_change()
    total_gross_change()
    pf_employee_change()
    esi_employee_change()
    professional_tax_change()
    deduction_change()
    net_salary_change()
    pf_employer_change()
    esi_employer_change()
    ctc_change()
  }

main_change();

function gross_salary_for_month_change(){
    gross_salary_for_month = Math.round(main_gross_salary - ((main_gross_salary/working_days_of_month)*unpaid_leave_taken));
    document.getElementById('gross_salary_for_month').innerText = gross_salary_for_month;
}

  function basic_salary_change(){
      basic_salary_monthly = Math.round((parseInt(gross_salary_for_month) * (55/100)));
      basic_salary_yearly = basic_salary_monthly * 12;
      document.getElementById('basic_salary_monthly').innerText = 'Rs. ' + parseInt(basic_salary_monthly)
      document.getElementById('basic_salary_yearly').innerText = 'Rs. ' + parseInt(basic_salary_yearly)
  }
  
  function hra_change(){
      hra_monthly = Math.round((parseInt(gross_salary_for_month) * (20/100)));
      hra_yearly = hra_monthly * 12;
      document.getElementById('hra_monthly').innerText = 'Rs. ' + parseInt(hra_monthly)
      document.getElementById('hra_yearly').innerText = 'Rs. ' + parseInt(hra_yearly)
  }
  
  function special_allowance_change(){
      special_allowance_monthly = Math.round(Math.max((parseInt(gross_salary_for_month) - (basic_salary_monthly + hra_monthly + medical_allowance + conveyance_allowance)), 0));
      special_allowance_yearly = special_allowance_monthly * 12;
      document.getElementById('special_allowance_monthly').innerText = 'Rs. ' + parseInt(special_allowance_monthly)
      document.getElementById('special_allowance_yearly').innerText = 'Rs. ' + parseInt(special_allowance_yearly)
  }
  
  function total_gross_change(){
      total_gross_monthly = Math.round(parseInt(gross_salary_for_month));
      total_gross_yearly = total_gross_monthly * 12;
      document.getElementById('total_gross_monthly').innerText = 'Rs. ' + parseInt(total_gross_monthly)
      document.getElementById('total_gross_yearly').innerText = 'Rs. ' + parseInt(total_gross_yearly)
  }
  
  function pf_employee_change(){
      pf_employee_monthly = Math.round(Math.min(basic_salary_monthly, 15000) * (12/100));
      pf_employee_yearly = pf_employee_monthly * 12;
      document.getElementById('pf_employee_monthly').innerText = 'Rs. ' + parseInt(pf_employee_monthly)
      document.getElementById('pf_employee_yearly').innerText = 'Rs. ' + parseInt(pf_employee_yearly)
  }

  function esi_employee_change(){
      esi_employee_monthly = Math.round(parseInt(main_gross_salary) < 21000 ? parseInt(main_gross_salary) * (0.75/100) : 0);
      esi_employee_yearly = esi_employee_monthly * 12;
      document.getElementById('esi_employee_monthly').innerText = 'Rs. ' + parseInt(esi_employee_monthly)
      document.getElementById('esi_employee_yearly').innerText = 'Rs. ' + parseInt(esi_employee_yearly)
  }
  
  function professional_tax_change(){
      professional_tax_monthly = Math.round(parseInt(main_gross_salary) >= 15000 ? {{$professional_tax ? (int)$professional_tax->amount : 0}} : 0);
      professional_tax_yearly = professional_tax_monthly * 12;
      document.getElementById('professional_tax_monthly').innerText = 'Rs. ' + parseInt(professional_tax_monthly)
      document.getElementById('professional_tax_yearly').innerText = 'Rs. ' + parseInt(professional_tax_yearly)
  }
  
  function deduction_change(){
      deduction_monthly = Math.round(pf_employee_monthly + esi_employee_monthly + professional_tax_monthly);
      deduction_yearly = deduction_monthly * 12;
      document.getElementById('deduction_monthly').innerText = 'Rs. ' + parseInt(deduction_monthly)
      document.getElementById('deduction_yearly').innerText = 'Rs. ' + parseInt(deduction_yearly)
  }
  
  function net_salary_change(){
      net_salary_monthly = Math.round(parseInt(gross_salary_for_month) - deduction_monthly);
      net_salary_yearly = net_salary_monthly * 12;
      document.getElementById('net_salary_monthly').innerText = 'Rs. ' + parseInt(net_salary_monthly)
      document.getElementById('net_salary_yearly').innerText = 'Rs. ' + parseInt(net_salary_yearly)
  }

  function pf_employer_change(){
      pf_employer_monthly = Math.round(Math.min(basic_salary_monthly, 15000) * (12/100));
      pf_employer_yearly = pf_employer_monthly * 12;
      @if(Auth::user() &&  Auth::user()->userType == 1)
      document.getElementById('pf_employer_monthly').innerText = 'Rs. ' + parseInt(pf_employer_monthly)
      document.getElementById('pf_employer_yearly').innerText = 'Rs. ' + parseInt(pf_employer_yearly)
      @endif
  }

  function esi_employer_change(){
      esi_employer_monthly = Math.round(parseInt(main_gross_salary) < 21000 ? parseInt(main_gross_salary) * (3.25/100) : 0);
      esi_employer_yearly = esi_employer_monthly * 12;
      @if(Auth::user() &&  Auth::user()->userType == 1)
      document.getElementById('esi_employer_monthly').innerText = 'Rs. ' + parseInt(esi_employer_monthly)
      document.getElementById('esi_employer_yearly').innerText = 'Rs. ' + parseInt(esi_employer_yearly)
      @endif
  }
  
  function ctc_change(){
      ctc_monthly = Math.round(parseInt(gross_salary_for_month) + (pf_employer_monthly + esi_employer_monthly));
      ctc_yearly = ctc_monthly * 12;
      document.getElementById('ctc_monthly').innerText = 'Rs. ' + parseInt(ctc_monthly)
      document.getElementById('ctc_yearly').innerText = 'Rs. ' + parseInt(ctc_yearly)
  }
</script>
@stop