@extends('layouts.admin.dashboard')



@section('content')

<div class="page-content">
    <div class="container-fluid">

        <div class="position-relative mx-n4 mt-n4">
            <div class="profile-wid-bg profile-setting-img">
                <img src="{{ asset('admin/images/logo.png') }}" class="profile-wid-img" alt="">
            </div>
        </div>

        <div class="row mt-5">
            
            <!--end col-->
            <div class="col-xxl-12 mt-5">
                <div class="card mt-xxl-n5">
                    <div class="card-header">
                        <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#personalDetails" role="tab">
                                    <i class="fas fa-home"></i>
                                    Personal Details
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#changePassword" role="tab">
                                    <i class="far fa-user"></i>
                                    Change Password
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body p-4">
                        <div class="tab-content">
                            <div class="tab-pane active" id="personalDetails" role="tabpanel">
                                <form action="javascript:void(0);" id="profileForm">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <label for="first_name" class="form-label">First Name</label>
                                                <input type="text" class="form-control" id="first_name"
                                                    placeholder="Enter your first name" value="{{Auth::user()->first_name}}">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <label for="last_name" class="form-label">Name</label>
                                                <input type="text" class="form-control" id="last_name"
                                                    placeholder="Enter your firstname" value="{{Auth::user()->last_name}}">
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <label for="phone" class="form-label">Phone
                                                    Number</label>
                                                <input type="text" class="form-control" id="phone"
                                                    placeholder="Enter your phone number" readonly value="{{Auth::user()->phone}}">
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email
                                                    Address</label>
                                                <input type="email" class="form-control" id="email"
                                                    placeholder="Enter your email" readonly value="{{Auth::user()->email}}">
                                            </div>
                                        </div>
                                        <!--end col-->
                                        
                                        <div class="col-lg-12">
                                            <div class="hstack gap-2 justify-content-end">
                                                <button type="submit" class="btn btn-primary" id="submitBtn">Update</button>
                                            </div>
                                        </div>
                                        <!--end col-->
                                    </div>
                                    <!--end row-->
                                </form>
                            </div>
                            <!--end tab-pane-->
                            <div class="tab-pane" id="changePassword" role="tabpanel">
                                <form action="javascript:void(0);" id="passwordForm">
                                    <div class="row g-2">
                                        <div class="col-lg-4">
                                            <div>
                                                <label for="opassword" class="form-label">Old
                                                    Password*</label>
                                                <input type="password" class="form-control" id="opassword"
                                                    placeholder="Enter current password">
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-4">
                                            <div>
                                                <label for="password" class="form-label">New
                                                    Password*</label>
                                                <input type="password" class="form-control" id="password"
                                                    placeholder="Enter new password">
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-4">
                                            <div>
                                                <label for="cpassword" class="form-label">Confirm
                                                    Password*</label>
                                                <input type="password" class="form-control" id="cpassword"
                                                    placeholder="Confirm password">
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-12 mt-3">
                                            <div class="text-end">
                                                <button type="submit" class="btn btn-success" id="submitBtn2">Change
                                                    Password</button>
                                            </div>
                                        </div>
                                        <!--end col-->
                                    </div>
                                    <!--end row-->
                                </form>
                                
                            </div>
                            <!--end tab-pane-->
                            
                        </div>
                    </div>
                </div>
            </div>
            <!--end col-->
        </div>
        <!--end row-->

    </div>
    <!-- container-fluid -->
</div><!-- End Page-content -->

@stop


@section('javascript')
<script src="{{ asset('admin/js/pages/axios.min.js') }}"></script>
<script src="{{ asset('admin/js/pages/just-validate-plugin-date.production.min.js') }}"></script>
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

</script>

<script type="text/javascript">

// initialize the validation library
const validation = new JustValidate('#profileForm', {
    errorFieldCssClass: 'is-invalid',
    focusInvalidField: true,
    lockForm: true,
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
  .onSuccess(async (event) => {
    var submitBtn = document.getElementById('submitBtn')
    submitBtn.innerHTML = `
        <span class="d-flex align-items-center">
            <span class="spinner-border flex-shrink-0" role="status">
                <span class="visually-hidden">Loading...</span>
            </span>
            <span class="flex-grow-1 ms-2">
                Loading...
            </span>
        </span>
        `
    submitBtn.disabled = true;
    try {
        var formData = new FormData();
        formData.append('first_name',document.getElementById('first_name').value)
        formData.append('last_name',document.getElementById('last_name').value)
        formData.append('refreshUrl','{{URL::current()}}')
        const response = await axios.post('{{route('profile_update')}}', formData)
        successToast(response.data.message)
        setTimeout(function(){
            window.location.replace(response.data.url);
        }, 1000);
    }catch (error){
        if(error?.response?.data?.form_error?.first_name){
            errorToast(error?.response?.data?.form_error?.first_name[0])
        }
        if(error?.response?.data?.form_error?.last_name){
            errorToast(error?.response?.data?.form_error?.last_name[0])
        }
    }finally{
        submitBtn.innerHTML =  `
            Update
            `
        submitBtn.disabled = false;
    }
  })

  // initialize the validation library
const validationPassword = new JustValidate('#passwordForm', {
    errorFieldCssClass: 'is-invalid',
    focusInvalidField: true,
    lockForm: true,
});
// apply rules to form fields
validationPassword
.addField('#password', [
    {
      rule: 'required',
      errorMessage: 'Password is required',
    }
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
  .addField('#opassword', [
    {
      rule: 'required',
      errorMessage: 'Old Password is required',
    }
  ])
  .onSuccess(async (event) => {
    var submitBtn = document.getElementById('submitBtn2')
    submitBtn.innerHTML = `
        <span class="d-flex align-items-center">
            <span class="spinner-border flex-shrink-0" role="status">
                <span class="visually-hidden">Loading...</span>
            </span>
            <span class="flex-grow-1 ms-2">
                Loading...
            </span>
        </span>
        `
    submitBtn.disabled = true;
    try {
        var formData = new FormData();
        formData.append('opassword',document.getElementById('opassword').value)
        formData.append('password',document.getElementById('password').value)
        formData.append('cpassword',document.getElementById('cpassword').value)
        formData.append('refreshUrl','{{URL::current()}}')
        const response = await axios.post('{{route('profile_password_update')}}', formData)
        successToast(response.data.message)
        setTimeout(function(){
            window.location.replace(response.data.url);
        }, 1000);
    }catch (error){
        if(error?.response?.data?.form_error?.opassword){
            errorToast(error?.response?.data?.form_error?.opassword[0])
        }
        if(error?.response?.data?.form_error?.password){
            errorToast(error?.response?.data?.form_error?.password[0])
        }
        if(error?.response?.data?.form_error?.cpassword){
            errorToast(error?.response?.data?.form_error?.cpassword[0])
        }
        if(error?.response?.data?.message){
            errorToast(error?.response?.data?.message)
        }
    }finally{
        submitBtn.innerHTML =  `
            Change Password
            `
        submitBtn.disabled = false;
    }
  })

</script>
@stop