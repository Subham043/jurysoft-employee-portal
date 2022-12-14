@extends('layouts.admin.dashboard')



@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Employee</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Employee</a></li>
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
                <form id="countryForm" method="post" action="{{route('subadmin_store')}}" enctype="multipart/form-data">
                @csrf
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Employee Info</h4>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">
                                <div class="row gy-4">
                                    <div class="col-xxl-4 col-md-4">
                                        <div>
                                            <label for="first_name" class="form-label">First Name</label>
                                            <input type="text" class="form-control" name="first_name" id="first_name" oninput="nameChangeHandler()" value="{{old('first_name')}}">
                                            @error('first_name') 
                                                <div class="invalid-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-md-4">
                                        <div>
                                            <label for="last_name" class="form-label">Last Name</label>
                                            <input type="text" class="form-control" name="last_name" id="last_name" oninput="nameChangeHandler()" value="{{old('last_name')}}">
                                            @error('last_name') 
                                                <div class="invalid-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-md-4">
                                        <div>
                                            <label for="full_name" class="form-label">Full Name</label>
                                            <input type="text" class="form-control" name="full_name" id="full_name" readonly disabled value="{{old('full_name')}}">
                                            @error('full_name') 
                                                <div class="invalid-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-md-4">
                                        <div>
                                            <label for="email" class="form-label">Company Email</label>
                                            <input type="email" class="form-control" name="email" id="email" value="{{old('email')}}">
                                            @error('email') 
                                                <div class="invalid-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-md-4">
                                        <div>
                                            <label for="phone" class="form-label">Personal Phone</label>
                                            <input type="text" class="form-control" name="phone" id="phone" value="{{old('phone')}}">
                                            @error('phone') 
                                                <div class="invalid-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-md-4">
                                        <div>
                                            <label for="userType" class="form-label">User Type</label>
                                            <select id="userType" name="userType"></select>
                                            @error('userType') 
                                                <div class="invalid-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-12 col-md-12">
                                        <div class="mt-4 mt-md-0">
                                            <div>
                                                <div class="form-check form-switch form-check-right mb-2">
                                                    <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckRightDisabled" name="status" {{old('status')==1 ? 'checked' : ''}}>
                                                    <label class="form-check-label" for="flexSwitchCheckRightDisabled">Status</label>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div><!--end col-->
                                    
                                </div>
                                <!--end row-->
                            </div>
                            
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Employee Security</h4>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">
                                <div class="row gy-4">
                                    <div class="col-xxl-6 col-md-12">
                                        <div>
                                            <label for="password" class="form-label">Password</label>
                                            <input type="password" class="form-control" name="password" id="password" value="">
                                            @error('password') 
                                                <div class="invalid-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-xxl-6 col-md-12">
                                        <div>
                                            <label for="cpassword" class="form-label">Confirm Password</label>
                                            <input type="password" class="form-control" name="cpassword" id="cpassword" value="">
                                            @error('cpassword') 
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
                            <h4 class="card-title mb-0 flex-grow-1">Employee Personal Info</h4>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">
                                <div class="row gy-4">
                                    <div class="col-xxl-4 col-md-4">
                                        <div>
                                            <label for="gender" class="form-label">Gender</label>
                                            <select id="gender" name="gender"></select>
                                            @error('gender') 
                                                <div class="invalid-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-md-4">
                                        <div>
                                            <label for="dob" class="form-label">Date Of Birth</label>
                                            <input type="date" class="form-control" name="dob" id="dob" value="{{old('dob')}}">
                                            @error('dob') 
                                                <div class="invalid-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-md-4">
                                        <div>
                                            <label for="email_personal" class="form-label">Personal Email</label>
                                            <input type="text" class="form-control" name="email_personal" id="email_personal" value="{{old('email_personal')}}">
                                            @error('email_personal') 
                                                <div class="invalid-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-md-4">
                                        <div>
                                            <label for="aadhar" class="form-label">Aadhar No.</label>
                                            <input type="text" class="form-control" name="aadhar" id="aadhar" value="{{old('aadhar')}}">
                                            @error('aadhar') 
                                                <div class="invalid-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-md-4">
                                        <div>
                                            <label for="pan" class="form-label">Pan No.</label>
                                            <input type="text" class="form-control" name="pan" id="pan" value="{{old('pan')}}">
                                            @error('pan') 
                                                <div class="invalid-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-md-4">
                                        <div>
                                            <label for="blood_group" class="form-label">Blood Group</label>
                                            <select id="blood_group" name="blood_group"></select>
                                            @error('blood_group') 
                                                <div class="invalid-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-xxl-6 col-md-6">
                                        <div>
                                            <label for="current_address" class="form-label">Current Address</label>
                                            <textarea name="current_address" id="current_address" class="form-control">{{old('current_address')}}</textarea>
                                            @error('current_address') 
                                                <div class="invalid-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-xxl-6 col-md-6">
                                        <div>
                                            <label for="permanent_address" class="form-label">Permanent Address</label>
                                            <textarea name="permanent_address" id="permanent_address" class="form-control">{{old('permanent_address')}}</textarea>
                                            @error('permanent_address') 
                                                <div class="invalid-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <!--end col-->
                                    
                                </div>
                                <!--end row-->
                            </div>
                            
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Employee Job Info</h4>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">
                                <div class="row gy-4">
                                    <div class="col-xxl-3 col-md-3">
                                        <div>
                                            <label for="department_id" class="form-label">Department</label>
                                            <select id="department_id" name="department_id"></select>
                                            @error('department_id') 
                                                <div class="invalid-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-xxl-3 col-md-3">
                                        <div>
                                            <label for="division_id" class="form-label">Division</label>
                                            <select id="division_id" name="division_id"></select>
                                            @error('division_id') 
                                                <div class="invalid-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-xxl-3 col-md-3">
                                        <div>
                                            <label for="employee_type_id" class="form-label">Employee Type</label>
                                            <select id="employee_type_id" name="employee_type_id"></select>
                                            @error('employee_type_id') 
                                                <div class="invalid-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-xxl-3 col-md-3">
                                        <div>
                                            <label for="designation_id" class="form-label">Designation</label>
                                            <select id="designation_id" name="designation_id"></select>
                                            @error('designation_id') 
                                                <div class="invalid-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-md-4">
                                        <div>
                                            <label for="date_of_join" class="form-label">Date Of Join</label>
                                            <input type="date" class="form-control" name="date_of_join" id="date_of_join" value="{{old('date_of_join')}}" oninput="trainingEndDateHandler()">
                                            @error('date_of_join') 
                                                <div class="invalid-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-md-4">
                                        <div>
                                            <label for="no_of_training_days" class="form-label">No. Of Training Days</label>
                                            <div class="d-flex align-items-center" style="gap:10px">
                                                <div>
                                                    <select name="no_of_training_days_d" id="no_of_training_days_d" class="form-control" oninput="trainingEndDateHandler()">
                                                        <option value="">Days</option>
                                                        @foreach (range(1,31) as $item)
                                                            <option value="{{$item}}" {{old('no_of_training_days_d')==$item?'selected':''}}>{{$item}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div>
                                                    <select name="no_of_training_days_m" id="no_of_training_days_m" class="form-control" oninput="trainingEndDateHandler()">
                                                        <option value="">Months</option>
                                                        @foreach (range(1,12) as $item)
                                                            <option value="{{$item}}" {{old('no_of_training_days_m')==$item?'selected':''}}>{{$item}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div>
                                                    <select name="no_of_training_days_y" id="no_of_training_days_y" class="form-control" oninput="trainingEndDateHandler()">
                                                        <option value="">Years</option>
                                                        @foreach (range(1,10) as $item)
                                                            <option value="{{$item}}" {{old('no_of_training_days_y')==$item?'selected':''}}>{{$item}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            @error('no_of_training_days') 
                                                <div class="invalid-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-md-4">
                                        <div>
                                            <label for="mou_duration" class="form-label">MOU Duration</label>
                                            <div class="d-flex align-items-center" style="gap:10px">
                                                <div>
                                                    <select name="mou_duration_d" id="mou_duration_d" class="form-control">
                                                        <option value="">Days</option>
                                                        @foreach (range(1,31) as $item)
                                                            <option value="{{$item}}" {{old('mou_duration_d')==$item?'selected':''}}>{{$item}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div>
                                                    <select name="mou_duration_m" id="mou_duration_m" class="form-control">
                                                        <option value="">Months</option>
                                                        @foreach (range(1,12) as $item)
                                                            <option value="{{$item}}" {{old('mou_duration_m')==$item?'selected':''}}>{{$item}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div>
                                                    <select name="mou_duration_y" id="mou_duration_y" class="form-control">
                                                        <option value="">Years</option>
                                                        @foreach (range(1,10) as $item)
                                                            <option value="{{$item}}" {{old('mou_duration_y')==$item?'selected':''}}>{{$item}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            @error('mou_duration') 
                                                <div class="invalid-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-xxl-6 col-md-6">
                                        <div>
                                            <label for="training_end_date" class="form-label">Training End Date</label>
                                            <input type="date" class="form-control" name="training_end_date" id="training_end_date" readonly disabled value="{{old('training_end_date')}}">
                                            @error('training_end_date') 
                                                <div class="invalid-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-xxl-6 col-md-6">
                                        <div>
                                            <label for="date_of_regular" class="form-label">Date Of Regular</label>
                                            <input type="date" class="form-control" name="date_of_regular" id="date_of_regular" disabled readonly value="{{old('date_of_regular')}}">
                                            @error('date_of_regular') 
                                                <div class="invalid-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <!--end col-->
                                    
                                </div>
                                <!--end row-->
                            </div>
                            
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Employee Banking Info</h4>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">
                                <div class="row gy-4">
                                    <div class="col-xxl-3 col-md-3">
                                        <div>
                                            <label for="bank_name" class="form-label">Bank Name</label>
                                            <input type="text" class="form-control" name="bank_name" id="bank_name" value="{{old('bank_name')}}">
                                            @error('bank_name') 
                                                <div class="invalid-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-xxl-3 col-md-3">
                                        <div>
                                            <label for="account_no" class="form-label">Bank Account No.</label>
                                            <input type="text" class="form-control" name="account_no" id="account_no" value="{{old('account_no')}}">
                                            @error('account_no') 
                                                <div class="invalid-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-xxl-3 col-md-3">
                                        <div>
                                            <label for="ifsc" class="form-label">IFSC Code</label>
                                            <input type="text" class="form-control" name="ifsc" id="ifsc" value="{{old('ifsc')}}">
                                            @error('ifsc') 
                                                <div class="invalid-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-xxl-3 col-md-3">
                                        <div>
                                            <label for="account_type" class="form-label">Account Type</label>
                                            <select id="account_type" name="account_type"></select>
                                            @error('account_type') 
                                                <div class="invalid-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <!--end col-->
                                    
                                </div>
                                <!--end row-->
                            </div>
                            
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Emergency Contact Info</h4>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">
                                <div class="row gy-4">
                                    <div class="col-xxl-4 col-md-4">
                                        <div>
                                            <label for="name" class="form-label">Name.</label>
                                            <input type="text" class="form-control" name="name" id="name" value="{{old('name')}}">
                                            @error('name') 
                                                <div class="invalid-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-md-4">
                                        <div>
                                            <label for="phone_emergency" class="form-label">Phone</label>
                                            <input type="text" class="form-control" name="phone_emergency" id="phone_emergency" value="{{old('phone_emergency')}}">
                                            @error('phone_emergency') 
                                                <div class="invalid-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-md-4">
                                        <div>
                                            <label for="relationship" class="form-label">Relationship</label>
                                            <select id="relationship" name="relationship"></select>
                                            @error('relationship') 
                                                <div class="invalid-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <!--end col-->
                                    
                                </div>
                                <!--end row-->
                            </div>
                            
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Employment Status Info</h4>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">
                                <div class="row gy-4">
                                    <div class="col-xxl-4 col-md-4">
                                        <div>
                                            <label for="work_status" class="form-label">Work Status</label>
                                            <select id="work_status" name="work_status" onchange="toggleWorkStatus()"></select>
                                            @error('work_status') 
                                                <div class="invalid-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-md-4 d-none" id="exitModeDiv">
                                        <div>
                                            <label for="exit_mode_id" class="form-label">Mode Of Exit</label>
                                            <select id="exit_mode_id" name="exit_mode_id"></select>
                                            @error('exit_mode_id') 
                                                <div class="invalid-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-md-4 d-none" id="exitDateDiv">
                                        <div>
                                            <label for="exit_date" class="form-label">Exit Date</label>
                                            <input type="date" class="form-control" name="exit_date" id="exit_date" value="{{old('exit_date')}}">
                                            @error('exit_date') 
                                                <div class="invalid-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <!--end col-->
                                    
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

function toggleWorkStatus(){
    if(this.event.target.value==2){
        document.getElementById('exitModeDiv').classList.remove('d-none');
        document.getElementById('exitDateDiv').classList.remove('d-none');
    }else{
        document.getElementById('exitModeDiv').classList.add('d-none');
        document.getElementById('exitDateDiv').classList.add('d-none');
    }
}

Date.prototype.addDays = function(days) {
    var date = new Date(this.valueOf());
    date.setDate(date.getDate() + days);
    return date;
}

function getDateFormat(value){
    return new Date(value).toISOString().slice(0, 10);
}

function trainingEndDateHandler(){
    var totalDays = 0;
    var selectedDate = document.getElementById('date_of_join').value
    if(selectedDate){
        var selectedDays = document.getElementById('no_of_training_days_d').value
        if(selectedDays){
            totalDays += Number(selectedDays);
        }
        var selectedMonths = document.getElementById('no_of_training_days_m').value
        if(selectedMonths){
            totalDays += (Number(selectedMonths)*30);
        }
        var selectedYears = document.getElementById('no_of_training_days_y').value
        if(selectedYears){
            totalDays += (Number(selectedYears)*365);
        }
        var date = new Date(selectedDate);
        
        document.getElementById('training_end_date').value = getDateFormat(date.addDays(Number(totalDays)));
        document.getElementById('date_of_regular').value = getDateFormat(date.addDays(Number(totalDays+1)));
    }else{
        errorToast("Please select date of join")
    }
}

function nameChangeHandler(){
    document.getElementById('full_name').value = document.getElementById('first_name').value + ' ' + document.getElementById('last_name').value 
}

const choices = new Choices('#userType', {
    silent: false,
    items: [],
    choices: [
            {
                value: 'Select the user type',
                label: 'Select the user type',
                selected: {{empty(old('userType')) ? 'true' : 'false'}},
                disabled: true,
            },
        @foreach($common['user_type'] as $key => $val)
            {
                value: '{{$key}}',
                label: '{{$val}}',
                selected: {{!empty(old('userType')) && old('userType')==$key ? 'true' : 'false'}},
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
    placeholderValue: 'Select the user type',
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

const choicesBloodType = new Choices('#blood_group', {
    silent: false,
    items: [],
    choices: [
            {
                value: 'Select a blood group',
                label: 'Select a blood group',
                selected: {{empty(old('blood_group')) ? 'true' : 'false'}},
                disabled: true,
            },
        @foreach($bloodType as $key => $val)
            {
                value: '{{$key}}',
                label: '{{$val}}',
                selected: {{!empty(old('blood_group')) && old('blood_group')==$key ? 'true' : 'false'}},
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
    placeholderValue: 'Select a blood group',
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

const choicesAccountType = new Choices('#account_type', {
    silent: false,
    items: [],
    choices: [
            {
                value: 'Select a account type',
                label: 'Select a account type',
                selected: {{empty(old('account_type')) ? 'true' : 'false'}},
                disabled: true,
            },
        @foreach($accountType as $key => $val)
            {
                value: '{{$key}}',
                label: '{{$val}}',
                selected: {{!empty(old('account_type')) && old('account_type')==$key ? 'true' : 'false'}},
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
    placeholderValue: 'Select a account type',
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

const choicesGenderType = new Choices('#gender', {
    silent: false,
    items: [],
    choices: [
            {
                value: 'Select a gender',
                label: 'Select a gender',
                selected: {{empty(old('gender')) ? 'true' : 'false'}},
                disabled: true,
            },
        @foreach($genderType as $key => $val)
            {
                value: '{{$key}}',
                label: '{{$val}}',
                selected: {{!empty(old('gender')) && old('gender')==$key ? 'true' : 'false'}},
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
    placeholderValue: 'Select a gender',
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

const choicesWorkStatusType = new Choices('#work_status', {
    silent: false,
    items: [],
    choices: [
            {
                value: 'Select a work status type',
                label: 'Select a work status type',
                selected: {{empty(old('work_status')) ? 'true' : 'false'}},
                disabled: true,
            },
        @foreach($workStatusType as $key => $val)
            {
                value: '{{$key}}',
                label: '{{$val}}',
                selected: {{!empty(old('work_status')) && old('work_status')==$key ? 'true' : 'false'}},
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
    placeholderValue: 'Select a work status type',
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

const choicesRelationshipType = new Choices('#relationship', {
    silent: false,
    items: [],
    choices: [
            {
                value: 'Select a relationship',
                label: 'Select a relationship',
                selected: {{empty(old('relationship')) ? 'true' : 'false'}},
                disabled: true,
            },
        @foreach($relationshipType as $key => $val)
            {
                value: '{{$key}}',
                label: '{{$val}}',
                selected: {{!empty(old('relationship')) && old('relationship')==$key ? 'true' : 'false'}},
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
    placeholderValue: 'Select a relationship',
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

const choicesDepartment = new Choices('#department_id', {
    silent: false,
    items: [],
    choices: [
            {
                value: 'Select a department',
                label: 'Select a department',
                selected: {{empty(old('department_id')) ? 'true' : 'false'}},
                disabled: true,
            },
        @foreach($department as $key => $val)
            {
                value: '{{$val->id}}',
                label: '{{$val->name}}',
                selected: {{!empty(old('department_id')) && old('department_id')==$val->id ? 'true' : 'false'}},
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
    placeholderValue: 'Select a department',
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

const choicesDivision = new Choices('#division_id', {
    silent: false,
    items: [],
    choices: [
            {
                value: 'Select a division',
                label: 'Select a division',
                selected: {{empty(old('division_id')) ? 'true' : 'false'}},
                disabled: true,
            },
        @foreach($division as $key => $val)
            {
                value: '{{$val->id}}',
                label: '{{$val->name}}',
                selected: {{!empty(old('division_id')) && old('division_id')==$val->id ? 'true' : 'false'}},
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
    placeholderValue: 'Select a division',
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

const choicesDesignation = new Choices('#designation_id', {
    silent: false,
    items: [],
    choices: [
            {
                value: 'Select a designation',
                label: 'Select a designation',
                selected: {{empty(old('designation_id')) ? 'true' : 'false'}},
                disabled: true,
            },
        @foreach($designation as $key => $val)
            {
                value: '{{$val->id}}',
                label: '{{$val->name}}',
                selected: {{!empty(old('designation_id')) && old('designation_id')==$val->id ? 'true' : 'false'}},
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
    placeholderValue: 'Select a designation',
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

const choicesEmployeeType = new Choices('#employee_type_id', {
    silent: false,
    items: [],
    choices: [
            {
                value: 'Select a employee type',
                label: 'Select a employee type',
                selected: {{empty(old('employee_type_id')) ? 'true' : 'false'}},
                disabled: true,
            },
        @foreach($employeeType as $key => $val)
            {
                value: '{{$val->id}}',
                label: '{{$val->name}}',
                selected: {{!empty(old('employee_type_id')) && old('employee_type_id')==$val->id ? 'true' : 'false'}},
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
    placeholderValue: 'Select a employee type',
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

const choicesExitMode = new Choices('#exit_mode_id', {
    silent: false,
    items: [],
    choices: [
            {
                value: 'Select a mode of exit',
                label: 'Select a mode of exit',
                selected: {{empty(old('exit_mode_id')) ? 'true' : 'false'}},
                disabled: true,
            },
        @foreach($exitMode as $key => $val)
            {
                value: '{{$val->id}}',
                label: '{{$val->name}}',
                selected: {{!empty(old('exit_mode_id')) && old('exit_mode_id')==$val->id ? 'true' : 'false'}},
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
    placeholderValue: 'Select a mode of exit',
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
  .addField('#first_name', [
    {
      rule: 'required',
      errorMessage: 'First Name is required',
    },
    {
        rule: 'customRegexp',
        value: /^[a-zA-Z\s]*$/,
        errorMessage: 'First Name is invalid',
    },
  ])
  .addField('#last_name', [
    {
      rule: 'required',
      errorMessage: 'Last Name is required',
    },
    {
        rule: 'customRegexp',
        value: /^[a-zA-Z\s]*$/,
        errorMessage: 'Last Name is invalid',
    },
  ])
  .addField('#email', [
    {
      rule: 'required',
      errorMessage: 'Company Email is required',
    },
    {
      rule: 'email',
      errorMessage: 'Company Email is invalid!',
    },
  ])
  .addField('#phone', [
    {
      rule: 'required',
      errorMessage: 'Personal Phone is required',
    },
    {
        rule: 'customRegexp',
        value: /^[0-9]*$/,
        errorMessage: 'Personal Phone is invalid',
    },
  ])
  .addField('#password', [
    {
      rule: 'required',
      errorMessage: 'Password is required',
    },
    {
        rule: 'customRegexp',
        value: /^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i,
        errorMessage: 'Password is invalid',
    },
  ])
  .addField('#cpassword', [
    {
      rule: 'required',
      errorMessage: 'Confirm Password is required',
    },
    {
        validator: (value, fields) => {
        if (fields['#password'] && fields['#password'].elem) {
            const repeatPasswordValue = fields['#password'].elem.value;

            return value === repeatPasswordValue;
        }

        return true;
        },
        errorMessage: 'Password and Confirm Password must be same',
    },
  ])
  .addField('#userType', [
    {
      rule: 'required',
      errorMessage: 'Please select the user type',
    },
    {
        validator: (value, fields) => {
        if (value === 'Select the user type') {
            return false;
        }
        return true;
        },
        errorMessage: 'Please select the user type',
    },
  ])
  .addField('#gender', [
    {
      rule: 'required',
      errorMessage: 'Please select a gender',
    },
    {
        validator: (value, fields) => {
        if (value === 'Select a gender') {
            return false;
        }
        return true;
        },
        errorMessage: 'Please select a gender',
    },
  ])
  .addField('#dob', [
    {
      rule: 'required',
      errorMessage: 'Please select date of birth',
    },
  ])
  .addField('#email_personal', [
    {
      rule: 'required',
      errorMessage: 'Personal Email is required',
    },
    {
      rule: 'email',
      errorMessage: 'Personal Email is invalid!',
    },
  ])
  .addField('#aadhar', [
    {
      rule: 'required',
      errorMessage: 'Aadhar is required',
    },
    {
        rule: 'customRegexp',
        value: /^[0-9]*$/,
        errorMessage: 'Aadhar is invalid',
    },
  ])
  .addField('#pan', [
    {
      rule: 'required',
      errorMessage: 'Pan is required',
    },
    {
        rule: 'customRegexp',
        value: /^[A-Z0-9]*$/,
        errorMessage: 'Pan is invalid',
    },
  ])
  .addField('#blood_group', [
    {
      rule: 'required',
      errorMessage: 'Please select a blood group',
    },
    {
        validator: (value, fields) => {
        if (value === 'Select a blood group') {
            return false;
        }
        return true;
        },
        errorMessage: 'Please select a blood group',
    },
  ])
  .addField('#current_address', [
    {
      rule: 'required',
      errorMessage: 'Current Address is required',
    },
  ])
  .addField('#permanent_address', [
    {
      rule: 'required',
      errorMessage: 'Permanent Address is required',
    },
  ])
  .addField('#department_id', [
    {
      rule: 'required',
      errorMessage: 'Please select a department',
    },
    {
        validator: (value, fields) => {
        if (value === 'Select a department') {
            return false;
        }
        return true;
        },
        errorMessage: 'Please select a department',
    },
  ])
  .addField('#division_id', [
    {
      rule: 'required',
      errorMessage: 'Please select a division',
    },
    {
        validator: (value, fields) => {
        if (value === 'Select a division') {
            return false;
        }
        return true;
        },
        errorMessage: 'Please select a division',
    },
  ])
  .addField('#designation_id', [
    {
      rule: 'required',
      errorMessage: 'Please select a designation',
    },
    {
        validator: (value, fields) => {
        if (value === 'Select a designation') {
            return false;
        }
        return true;
        },
        errorMessage: 'Please select a designation',
    },
  ])
  .addField('#employee_type_id', [
    {
      rule: 'required',
      errorMessage: 'Please select a employee type',
    },
    {
        validator: (value, fields) => {
        if (value === 'Select a employee type') {
            return false;
        }
        return true;
        },
        errorMessage: 'Please select a employee type',
    },
  ])
  .addField('#date_of_join', [
    {
      rule: 'required',
      errorMessage: 'Date of Join is required',
    },
  ])
  .addField('#no_of_training_days_d', [
    {
        rule: 'customRegexp',
        value: /^[0-9]*$/,
        errorMessage: 'No. Of Training Days is invalid',
    },
    {
        validator: (value, fields) => {
        if (value === '' && document.getElementById('no_of_training_days_m').value==='' && document.getElementById('no_of_training_days_y').value==='') {
            return false;
        }
        return true;
        },
        errorMessage: 'No. Of Training Days is required',
    },
  ])
  .addField('#no_of_training_days_m', [
    {
        rule: 'customRegexp',
        value: /^[0-9]*$/,
        errorMessage: 'No. Of Training Months is invalid',
    },
  ])
  .addField('#no_of_training_days_y', [
    {
        rule: 'customRegexp',
        value: /^[0-9]*$/,
        errorMessage: 'No. Of Training Years is invalid',
    },
  ])
  .addField('#mou_duration_d', [
    {
        rule: 'customRegexp',
        value: /^[0-9]*$/,
        errorMessage: 'MOU Duration in Days is invalid',
    },
    {
        validator: (value, fields) => {
        if (value === '' && document.getElementById('mou_duration_m').value==='' && document.getElementById('mou_duration_y').value==='') {
            return false;
        }
        return true;
        },
        errorMessage: 'MOU Duration in Days is required',
    },
  ])
  .addField('#mou_duration_m', [
    {
        rule: 'customRegexp',
        value: /^[0-9]*$/,
        errorMessage: 'MOU Duration in Months is invalid',
    },
  ])
  .addField('#mou_duration_y', [
    {
        rule: 'customRegexp',
        value: /^[0-9]*$/,
        errorMessage: 'MOU Duration in Years is invalid',
    },
  ])
  .addField('#bank_name', [
    {
      rule: 'required',
      errorMessage: 'Bank Name is required',
    },
    {
        rule: 'customRegexp',
        value: /^[a-zA-Z0-9\s]*$/,
        errorMessage: 'Bank Name is invalid',
    },
  ])
  .addField('#account_no', [
    {
      rule: 'required',
      errorMessage: 'Bank Account No. is required',
    },
    {
        rule: 'customRegexp',
        value: /^[0-9]*$/,
        errorMessage: 'Bank Account No. is invalid',
    },
  ])
  .addField('#ifsc', [
    {
      rule: 'required',
      errorMessage: 'IFSC Code is required',
    },
    {
        rule: 'customRegexp',
        value: /^[A-Z0-9\s]*$/,
        errorMessage: 'IFSC Code is invalid',
    },
  ])
  .addField('#account_type', [
    {
      rule: 'required',
      errorMessage: 'Please select a account type',
    },
    {
        validator: (value, fields) => {
        if (value === 'Select a account type') {
            return false;
        }
        return true;
        },
        errorMessage: 'Please select a account type',
    },
  ])
  .addField('#name', [
    {
      rule: 'required',
      errorMessage: 'Name is required',
    },
    {
        rule: 'customRegexp',
        value: /^[a-zA-Z0-9\s]*$/,
        errorMessage: 'Name is invalid',
    },
  ])
  .addField('#phone_emergency', [
    {
      rule: 'required',
      errorMessage: 'Phone is required',
    },
    {
        rule: 'customRegexp',
        value: /^[0-9]*$/,
        errorMessage: 'Phone is invalid',
    },
  ])
  .addField('#relationship', [
    {
      rule: 'required',
      errorMessage: 'Please select a relationship',
    },
    {
        validator: (value, fields) => {
        if (value === 'Select a relationship') {
            return false;
        }
        return true;
        },
        errorMessage: 'Please select a relationship',
    },
  ])
  .addField('#work_status', [
    {
      rule: 'required',
      errorMessage: 'Please select a work status type',
    },
    {
        validator: (value, fields) => {
        if (value === 'Select a work status type') {
            return false;
        }
        return true;
        },
        errorMessage: 'Please select a work status type',
    },
  ])
  .addField('#exit_mode_id', [
    {
        validator: (value, fields) => {
        if (document.getElementById('work_status').value=='2' && value==='') {
            return false;
        }
        return true;
        },
        errorMessage: 'Please select a mode of exit',
    },
  ])
  .addField('#exit_date', [
    {
        validator: (value, fields) => {
        if (document.getElementById('work_status').value=='2' && value==='') {
            return false;
        }
        return true;
        },
        errorMessage: 'Exit Date is required',
    },
  ])
  .onSuccess((event) => {
    event.target.submit();
  });
</script>

@stop