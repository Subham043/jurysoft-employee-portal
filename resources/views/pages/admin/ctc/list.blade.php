@extends('layouts.admin.dashboard')



@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">CTC</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">CTC</a></li>
                            <li class="breadcrumb-item active">List</li>
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
                        <h4 class="card-title mb-0">CTC For {{$user->full_name}}~{{$user->jurysoft_id}}</h4>
                    </div><!-- end card header -->

                    <div class="card-body">
                        <div id="customerList">
                            <div class="row g-4 mb-3">
                                <div class="col-sm-auto">
                                    <div>
                                        <a href={{route('ctc_create', $user->id)}} type="button" class="btn btn-success add-btn" style="background:green;border-color:green;" id="create-btn"><i class="ri-add-line align-bottom me-1"></i> Create</a>
                                        <a href={{route('ctc_excel', $user->id)}} type="button" class="btn btn-info add-btn" id="create-btn"><i class="ri-file-excel-fill align-bottom me-1"></i> Excel</a>
                                    </div>
                                </div>
                                <div class="col-sm d-flex justify-content-sm-end">
                                    <div class="col-sm-3">
                                        <form class="d-flex align-items-center" id="filter_form"  method="get" action="{{route('ctc_view', $user->id)}}">
                                            <label class="col-sm-3 m-0 p-0">Filter : </label>
                                            <input type="month" class="form-control" name="month_year" id="month_year" onchange="month_year_change()" value="@if(app('request')->has('month_year')){{app('request')->input('month_year')}}@endif">
                                        </form>
                                    </div>
                                    <form  method="get" action="{{route('ctc_view', $user->id)}}">
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
                                            <th class="sort" data-sort="customer_name">ID</th>
                                            <th class="sort" data-sort="customer_name">Main Gross Salary</th>
                                            <th class="sort" data-sort="customer_name">CTC Termination Month & Year</th>
                                            <th class="sort" data-sort="date">Created Date</th>
                                            <th class="sort" data-sort="action">Action</th>
                                            </tr>
                                    </thead>
                                    <tbody class="list form-check-all">

                                        @foreach ($country->items() as $k => $v)
                                        <tr>
                                            <td class="customer_name">{{$v->id}}</td>
                                            <td class="customer_name">{{$v->ctc}}</td>
                                            <td class="customer_name">@if($country->total()==1) <span class="badge badge-soft-success text-uppercase">Active</span> @elseif(($country->total()-1)>=$k &&  $v->month_year){{$v->month_year_formatted}}@else <span class="badge badge-soft-success text-uppercase">Active</span> @endif</td>
                                            <td class="date">{{$v->created_at}}</td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <div class="edit">
                                                        <a href="{{route('ctc_display', [$user->id, $v->id])}}" class="btn btn-sm btn-info edit-item-btn">View</a>
                                                    </div>
                                                    <div class="edit">
                                                        <a href="{{route('ctc_edit', [$user->id, $v->id])}}" style="background:yellow;color:black;border-color:yellow;" class="btn btn-sm btn-success edit-item-btn">Edit</a>
                                                    </div>
                                                    @if(Auth::user() &&  Auth::user()->userType == 1)
                                                    <div class="remove">
                                                        <button class="btn btn-sm btn-danger remove-item-btn" style="background:red" onclick="deleteHandler('{{route('ctc_delete', [$user->id, $v->id])}}')">Delete</button>
                                                    </div>
                                                    @endif
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

{{-- <script src="{ asset('admin/libs/list.js/list.min.js') }}"></script> --}}
{{-- <script src="{ asset('admin/libs/list.pagination.js/list.pagination.min.js') }}"></script> --}}

<!-- listjs init -->
{{-- <script src="{ asset('admin/js/pages/listjs.init.js') }}"></script> --}}

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

    function month_year_change(){
        document.getElementById('filter_form').submit();
    }
</script>

@stop