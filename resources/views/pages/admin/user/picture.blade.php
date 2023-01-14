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
                            <li class="breadcrumb-item active">Picture</li>
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
                <form id="countryForm" method="post" action="{{route(Auth::user() &&  Auth::user()->userType == 1 ? 'subadmin_picture_save' : 'subadmin_picture_save_hr', $user->id)}}" enctype="multipart/form-data">
                @csrf
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Employee Picture</h4>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">
                                <div class="row gy-4 align-items-center">
                                    <div class="col-xxl-8 col-md-8">
                                        <div>
                                            <label for="image" class="form-label">Profile Picture</label>
                                            <input class="form-control" type="file" name="image" id="image">
                                            @error('image') 
                                                <div class="invalid-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mt-4">
                                            <button type="submit" class="btn btn-primary waves-effect waves-light">Save</button>
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-md-4">
                                        <div class="text-center">
                                            <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                                                <img src="{{ $employeePicture ? asset('storage/upload/images/'.$employeePicture->images) : asset('admin/images/avatar.png')}}"
                                                    class="rounded-circle avatar-xl img-thumbnail user-profile-image"
                                                    alt="user-profile-image">
                                            </div>
                                            <h5 class="fs-17 mb-1">{{$user->full_name}}</h5>
                                            <p class="text-muted mb-0">{{$user->EmployeeJobDetail->Designation->name}}</p>
                                        </div>
                                    </div>
                                    
                                </div>
                                <!--end row-->
                            </div>
                            
                        </div>
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
const validation = new JustValidate('#countryForm', {
      errorFieldCssClass: 'is-invalid',
});
// apply rules to form fields
validation
    .addField('#image', [
        {
            rule: 'minFilesCount',
            value: 1,
            errorMessage: 'Please select an image',
        },
        {
            rule: 'files',
            value: {
                files: {
                    extensions: ['jpeg', 'png', 'jpg', 'webp']
                },
            },
            errorMessage: 'Please select a valid image',
        },
    ])
  .onSuccess((event) => {
    event.target.submit();
  });
</script>

@stop