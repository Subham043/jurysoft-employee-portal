@extends('layouts.admin.dashboard')



@section('content')

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
                            <li class="breadcrumb-item active">Create</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="row g-4 mb-3">
                <div class="col-sm-auto">
                    <div>
                        <a href="{{url()->previous()}}" type="button" class="btn btn-dark add-btn" id="create-btn"><i class="ri-arrow-go-back-line align-bottom me-1"></i> Go Back</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <form id="countryForm" method="post" action="{{route(Auth::user() &&  Auth::user()->userType == 1 ? 'payslip_create' : 'payslip_create_hr')}}" enctype="multipart/form-data">
                @csrf
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Payslip Info</h4>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">
                                <div class="row gy-4">
                                    <div class="col-xxl-4 col-md-4">
                                        <div>
                                            <label for="user_id" class="form-label">Employee</label>
                                            <select id="user_id" name="user_id" onchange="user_id_change()"></select>
                                            @error('user_id') 
                                                <div class="invalid-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-md-4">
                                        <div>
                                            <label for="month_year" class="form-label">Payslip Month & Year</label>
                                            <input type="month" class="form-control" name="month_year" id="month_year" oninput="payslip_month_year_change()" value="{{old('month_year')}}">
                                            @error('month_year') 
                                                <div class="invalid-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-md-4">
                                        <div>
                                            <label for="total_days_of_month" class="form-label">Total Days Of Month</label>
                                            <input type="text" class="form-control" disabled readonly name="total_days_of_month" id="total_days_of_month" oninput="main_change()" value="{{old('total_days_of_month')}}">
                                            @error('total_days_of_month') 
                                                <div class="invalid-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-xxl-3 col-md-3">
                                        <div>
                                            <label for="working_days_of_month" class="form-label">Working Days Of Month</label>
                                            <input type="text" class="form-control" name="working_days_of_month" id="working_days_of_month" oninput="workdays_change()" value="{{old('working_days_of_month')}}">
                                            @error('working_days_of_month') 
                                                <div class="invalid-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-xxl-3 col-md-3">
                                        <div>
                                            <label for="paid_leave_taken" class="form-label">Paid Leave Taken</label>
                                            <input type="text" class="form-control" name="paid_leave_taken" id="paid_leave_taken" oninput="workdays_change()" value="{{old('paid_leave_taken')}}">
                                            @error('paid_leave_taken') 
                                                <div class="invalid-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-xxl-3 col-md-3">
                                        <div>
                                            <label for="unpaid_leave_taken" class="form-label">Unpaid Leave Taken</label>
                                            <input type="text" class="form-control" name="unpaid_leave_taken" id="unpaid_leave_taken" oninput="workdays_change()" value="{{old('unpaid_leave_taken')}}">
                                            @error('unpaid_leave_taken') 
                                                <div class="invalid-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-xxl-3 col-md-3">
                                        <div>
                                            <label for="worked_days" class="form-label">Worked Days</label>
                                            <input type="text" class="form-control" disabled readonly name="worked_days" id="worked_days" value="{{old('worked_days')}}">
                                            @error('worked_days') 
                                                <div class="invalid-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                </div>
                                <!--end row-->
                            </div>
                            
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Employee CTC Info</h4>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">
                                <div class="row gy-4">
                                    <div class="col-xxl-6 col-md-6">
                                        <div>
                                            <label for="main_gross_salary" class="form-label">Main Gross Salary</label>
                                            <input type="text" class="form-control" readonly disabled name="main_gross_salary" id="main_gross_salary" value="{{old('main_gross_salary')}}">
                                            @error('main_gross_salary') 
                                                <div class="invalid-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-xxl-6 col-md-6">
                                        <div>
                                            <label for="gross_salary_for_month" class="form-label">Gross Salary For That Month</label>
                                            <input type="text" class="form-control" readonly disabled name="gross_salary_for_month" id="gross_salary_for_month" value="{{old('gross_salary_for_month')}}">
                                            @error('gross_salary_for_month') 
                                                <div class="invalid-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <!--end col-->

                                    <div class="col-xxl-12 col-md-12">
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
                                <!--end row-->
                            </div>
                            
                        </div>
                    </div>

                    <div class="col-xxl-12 col-md-12 mb-5">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Create</button>
                    </div>

                </form>
            </div>
            <!--end col-->
        </div>
        <!--end row-->

        

    </div> <!-- container-fluid -->
</div><!-- End Page-content -->



@stop          
           

@section('javascript')
<script src="{{ asset('admin/js/pages/choices.min.js') }}"></script>
<script src="{{ asset('admin/js/pages/axios.min.js') }}"></script>

<script type="text/javascript">
const errorToast = (message) =>{
    iziToast.error({
        title: 'Error',
        message: message,
        position: 'bottomCenter',
        timeout:7000
    });
}
const successToast = (message) =>{
    iziToast.success({
        title: 'Success',
        message: message,
        position: 'bottomCenter',
        timeout:6000
    });
}

const choicesUser = new Choices('#user_id', {
    silent: false,
    items: [],
    choices: [
            {
                value: 'Select an employee',
                label: 'Select an employee',
                selected: {{empty(old('user_id')) ? 'true' : 'false'}},
                disabled: true,
            },
        @foreach($user as $key => $val)
            {
                value: '{{$val->id}}',
                label: '{{$val->full_name}} ~ {{$val->jurysoft_id}}',
                selected: {{!empty(old('user_id')) && old('user_id')==$val->id ? 'true' : 'false'}},
            },
        @endforeach
    ],
    renderChoiceLimit: -1,
    maxItemCount: -1,
    addItems: true,
    addItemFilter: null,
    removeItems: true,
    removeItemButton: false,
    editItems: false,
    allowHTML: true,
    duplicateItemsAllowed: true,
    delimiter: ',',
    paste: true,
    searchEnabled: true,
    searchChoices: true,
    searchFloor: 1,
    searchResultLimit: 4,
    searchFields: ['label', 'value'],
    position: 'auto',
    resetScrollPosition: true,
    shouldSort: true,
    shouldSortItems: false,
    // sorter: () => {...},
    placeholder: true,
    placeholderValue: 'Select an employee',
    searchPlaceholderValue: null,
    prependValue: null,
    appendValue: null,
    renderSelectedChoices: 'auto',
    loadingText: 'Loading...',
    noResultsText: 'No results found',
    noChoicesText: 'No choices to choose from',
    itemSelectText: 'Press to select',
    addItemText: (value) => {
      return `Press Enter to add <b>"${value}"</b>`;
    },
    maxItemText: (maxItemCount) => {
      return `Only ${maxItemCount} values can be added`;
    },
    valueComparer: (value1, value2) => {
      return value1 === value2;
    },
    classNames: {
      containerOuter: 'choices',
      containerInner: 'choices__inner',
      input: 'choices__input',
      inputCloned: 'choices__input--cloned',
      list: 'choices__list',
      listItems: 'choices__list--multiple',
      listSingle: 'choices__list--single',
      listDropdown: 'choices__list--dropdown',
      item: 'choices__item',
      itemSelectable: 'choices__item--selectable',
      itemDisabled: 'choices__item--disabled',
      itemChoice: 'choices__item--choice',
      placeholder: 'choices__placeholder',
      group: 'choices__group',
      groupHeading: 'choices__heading',
      button: 'choices__button',
      activeState: 'is-active',
      focusState: 'is-focused',
      openState: 'is-open',
      disabledState: 'is-disabled',
      highlightedState: 'is-highlighted',
      selectedState: 'is-selected',
      flippedState: 'is-flipped',
      loadingState: 'is-loading',
      noResults: 'has-no-results',
      noChoices: 'has-no-choices'
    },
    // Choices uses the great Fuse library for searching. You
    // can find more options here: https://fusejs.io/api/options.html
    fuseOptions: {
      includeScore: true
    },
    labelId: '',
    callbackOnInit: null,
    callbackOnCreateTemplates: null
});

</script>

<script type="text/javascript">

// initialize the validation library
const validation = new JustValidate('#countryForm', {
      errorFieldCssClass: 'is-invalid',
});
// apply rules to form fields
validation
  .addField('#month_year', [
    {
      rule: 'required',
      errorMessage: 'Month & Year is required',
    },
    {
        rule: 'customRegexp',
        value: /^[0-9\-]*$/,
        errorMessage: 'Month & Year is invalid',
    },
  ])
  .addField('#total_days_of_month', [
    {
      rule: 'required',
      errorMessage: 'Total days of month is required',
    },
    {
        rule: 'customRegexp',
        value: /^[0-9]*$/,
        errorMessage: 'Total days of month is invalid',
    },
  ])
  .addField('#working_days_of_month', [
    {
      rule: 'required',
      errorMessage: 'Working days of month is required',
    },
    {
        rule: 'customRegexp',
        value: /^[0-9]*$/,
        errorMessage: 'Working days of month is invalid',
    },
  ])
  .addField('#paid_leave_taken', [
    {
      rule: 'required',
      errorMessage: 'Paid leave taken is required',
    },
    {
        rule: 'customRegexp',
        value: /^[0-9]*$/,
        errorMessage: 'Paid leave taken is invalid',
    },
  ])
  .addField('#unpaid_leave_taken', [
    {
      rule: 'required',
      errorMessage: 'Unpaid leave taken is required',
    },
    {
        rule: 'customRegexp',
        value: /^[0-9]*$/,
        errorMessage: 'Unpaid leave taken is invalid',
    },
  ])
  .addField('#worked_days', [
    {
      rule: 'required',
      errorMessage: 'Worked days is required',
    },
    {
        rule: 'customRegexp',
        value: /^[0-9]*$/,
        errorMessage: 'Worked days is invalid',
    },
  ])
  .addField('#user_id', [
    {
      rule: 'required',
      errorMessage: 'Please select an employee',
    },
    {
        validator: (value, fields) => {
        if (value === 'Select an employee') {
            return false;
        }
        return true;
        },
        errorMessage: 'Please select an employee',
    },
  ])
  .onSuccess((event) => {
    event.target.submit();
  });


  let total_days_of_month = {{old('total_days_of_month') ? old('total_days_of_month') : 0}};
  let worked_days = {{old('worked_days') ? old('worked_days') : 0}};
  let working_days_of_month = {{old('working_days_of_month') ? old('working_days_of_month') : 0}};
  let unpaid_leave_taken = {{old('unpaid_leave_taken') ? old('unpaid_leave_taken') : 0}};
  let paid_leave_taken = {{old('paid_leave_taken') ? old('paid_leave_taken') : 0}};
  function payslip_month_year_change(){
    let data = document.getElementById('month_year').value;
    const myArray = data.split("-");
    const days = new Date(myArray[0], myArray[1], 0).getDate();
    total_days_of_month = days;
    document.getElementById('total_days_of_month').value = days;
    main_change()
  }

  function workdays_change(){
    working_days_of_month = parseInt(document.getElementById('working_days_of_month').value) ? parseInt(document.getElementById('working_days_of_month').value) : 0
    unpaid_leave_taken = parseInt(document.getElementById('unpaid_leave_taken').value) ? parseInt(document.getElementById('unpaid_leave_taken').value) : 0
    paid_leave_taken = parseInt(document.getElementById('paid_leave_taken').value) ? parseInt(document.getElementById('paid_leave_taken').value) : 0
    worked_days = working_days_of_month - (paid_leave_taken + unpaid_leave_taken);
    document.getElementById('worked_days').value = worked_days;
    main_change()
  }

  let medical_allowance = {{$medical_allowance ? (int)$medical_allowance->amount : 0}};
  let conveyance_allowance = {{$conveyance_allowance ? (int)$conveyance_allowance->amount : 0}};

  let main_gross_salary = 0;
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

@if(old('total_days_of_month') || old('worked_days') || old('working_days_of_month') || old('unpaid_leave_taken') || old('paid_leave_taken'))
  user_id_change()
@endif

async function user_id_change(){
    try {
        var formData = new FormData();
        formData.append('user_id',document.getElementById('user_id').value)
        const response = await axios.post('{{route(Auth::user() &&  Auth::user()->userType == 1 ? 'subadmin_json' : 'subadmin_json_hr')}}', formData)
        document.getElementById('main_gross_salary').value = response.data.employee_main_gross_salary
        main_gross_salary = response.data.employee_main_gross_salary
        main_change()
    }catch (error){
        if(error?.response?.data?.form_error?.user_id){
            errorToast(error?.response?.data?.form_error?.user_id[0])
        }
        if(error?.response?.data?.message){
            errorToast(error?.response?.data?.message)
        }
    }
}

function gross_salary_for_month_change(){
    gross_salary_for_month = Math.round(main_gross_salary - ((main_gross_salary/working_days_of_month)*unpaid_leave_taken));
    document.getElementById('gross_salary_for_month').value = gross_salary_for_month;
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
      document.getElementById('pf_employer_monthly').innerText = 'Rs. ' + parseInt(pf_employer_monthly)
      document.getElementById('pf_employer_yearly').innerText = 'Rs. ' + parseInt(pf_employer_yearly)
  }

  function esi_employer_change(){
      esi_employer_monthly = Math.round(parseInt(main_gross_salary) < 21000 ? parseInt(main_gross_salary) * (3.25/100) : 0);
      esi_employer_yearly = esi_employer_monthly * 12;
      document.getElementById('esi_employer_monthly').innerText = 'Rs. ' + parseInt(esi_employer_monthly)
      document.getElementById('esi_employer_yearly').innerText = 'Rs. ' + parseInt(esi_employer_yearly)
  }
  
  function ctc_change(){
      ctc_monthly = Math.round(parseInt(gross_salary_for_month) + (pf_employer_monthly + esi_employer_monthly));
      ctc_yearly = ctc_monthly * 12;
      document.getElementById('ctc_monthly').innerText = 'Rs. ' + parseInt(ctc_monthly)
      document.getElementById('ctc_yearly').innerText = 'Rs. ' + parseInt(ctc_yearly)
  }

</script>

@stop