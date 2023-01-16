@extends('layouts.admin.dashboard')



@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Payslip Download List</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Payslip Download List</a></li>
                            <li class="breadcrumb-item active">Download List</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Payslip Download List</h4>
                    </div><!-- end card header -->

                    <div class="card-body">
                        <div id="customerList">
                            <div class="row g-4 mb-3">
                                <div class="col-sm-auto">
                                    <div>
                                        <a href={{route(Auth::user() &&  Auth::user()->userType == 1 ? 'payslip_excel_download' : 'payslip_excel_download_hr')}} type="button" class="btn btn-info add-btn" id="create-btn"><i class="ri-file-excel-fill align-bottom me-1"></i> Excel</a>
                                    </div>
                                </div>
                                <div class="col-sm d-flex justify-content-sm-end">
                                    <div class="col-sm-3">
                                        <form class="d-flex align-items-center" id="filter_form"  method="get" action="{{route(Auth::user() &&  Auth::user()->userType == 1 ? 'payslip_download_view' : 'payslip_download_view_hr')}}">
                                            <label class="col-sm-3 m-0 p-0">Filter : </label>
                                            <input type="month" class="form-control" name="month_year" id="month_year" onchange="month_year_change()" value="@if(app('request')->has('month_year')){{app('request')->input('month_year')}}@endif">
                                        </form>
                                    </div>
                                    <form  method="get" action="{{route(Auth::user() &&  Auth::user()->userType == 1 ? 'payslip_download_view' : 'payslip_download_view_hr')}}">
                                        <div class="d-flex justify-content-sm-end">
                                            <div class="search-box ms-2">
                                                <input type="text" name="search" class="form-control search" placeholder="Search..." value="@if(app('request')->has('search')){{app('request')->input('search')}}@endif">
                                                <i class="ri-search-line search-icon"></i>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="table-responsive table-card mt-3 mb-1">
                                @if($country->total() > 0)
                                <table class="table align-middle table-nowrap" id="customerTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="sort" data-sort="customer_name">Download ID</th>
                                            <th class="sort" data-sort="customer_name">Employee ID</th>
                                            <th class="sort" data-sort="customer_name">Employee</th>
                                            <th class="sort" data-sort="customer_name">Payslip Month & Year</th>
                                            <th class="sort" data-sort="customer_name">Reason</th>
                                            <th class="sort" data-sort="date">Created Date</th>
                                            <th class="sort" data-sort="action">Action</th>
                                            </tr>
                                    </thead>
                                    <tbody class="list form-check-all">

                                        @foreach ($country->items() as $item)
                                        <tr>
                                            <td class="customer_name">{{$item->id}}</td>
                                            <td class="customer_name">{{$item->user ? $item->user->jurysoft_id : ''}}</td>
                                            <td class="customer_name">{{$item->user ? $item->user->full_name : ''}}</td>
                                            <td class="customer_name">{{$item->payslip ? $item->payslip->month_year_formatted : ''}}</td>
                                            <td class="customer_name">{{$item->PayslipDownloadReason ? $item->PayslipDownloadReason->reason : ''}}</td>
                                            <td class="date">{{$item->created_at}}</td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <div class="edit">
                                                        <a href="{{route(Auth::user() &&  Auth::user()->userType == 1 ? 'payslip_display' : 'payslip_display_hr', $item->payslip->id)}}" class="btn btn-sm btn-info edit-item-btn" target="_blank">View Payslip</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                        
                                    </tbody>
                                </table>
                                @else
                                <div class="noresult">
                                    <div class="text-center">
                                        <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                            colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px">
                                        </lord-icon>
                                        <h5 class="mt-2">Sorry! No Result Found</h5>
                                    </div>
                                </div>
                                @endif
                            </div>
                            
                            @if($country->total() > 0)
                            <div class="d-flex justify-content-center">
                                {{ $country->links('pagination::bootstrap-4') }}
                            </div>
                            @endif
                        </div>
                    </div><!-- end card -->
                </div>
                <!-- end col -->
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->

    </div>
</div>

@stop

@section('javascript')

<script>
    
    function month_year_change(){
        document.getElementById('filter_form').submit();
    }
</script>

@stop