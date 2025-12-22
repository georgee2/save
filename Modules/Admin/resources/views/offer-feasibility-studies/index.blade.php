@extends('admin::layouts.master')
@section('title', 'Offer Feasibility Studies')

@section('css')
<link href="{{ URL::asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<!-- Animate.css for animations -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<style>
    .badge-master {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        font-weight: 600;
    }
    .badge-custom {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
        font-weight: 600;
    }
</style>
@endsection

@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Admin')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-chart-line"></i> Offer Feasibility Studies</a>
        </nav>

        <div class="col-lg-12">
            <hr>
            
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <h4 class="mt-0 header-title"><i class="fa fa-chart-line"></i> Offer Feasibility Studies Management</h4>
                        </div>
                    </div>
                    <hr>
                    
                    
                    <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Study Name</th>
                                <th>Offer</th>
                                <th>Emirate</th>
                                <th>Price</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Created By</th>
                                <th>Created Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($studies as $study)
                            <tr>
                                <td>{{ $study->id }}</td>
                                <td><strong>{{ $study->study_name }}</strong></td>
                                <td>
                                    <a href="{{ route('offer.show', ['id' => $study->offer_id]) }}" class="text-primary">
                                        {{ $study->offer_name }}
                                    </a>
                                </td>
                                <td>
                                    <span class="badge badge-info">{{ $study->emirate_name_en ?? 'N/A' }}</span>
                                </td>
                                <td>
                                    <strong class="text-success">{{ number_format($study->emirate_price ?? 0, 2) }}</strong>
                                </td>
                                <td>
                                    @if($study->study_type == 'Master')
                                        <span class="badge badge-master"><i class="fa fa-star"></i> Master</span>
                                    @else
                                        <span class="badge badge-custom"><i class="fa fa-edit"></i> Custom</span>
                                    @endif
                                </td>
                                <td>
                                    @if($study->status == 'Active')
                                        <span class="badge badge-success"><i class="fa fa-check"></i> Active</span>
                                    @elseif($study->status == 'Draft')
                                        <span class="badge badge-warning"><i class="fa fa-file"></i> Draft</span>
                                    @else
                                        <span class="badge badge-secondary"><i class="fa fa-archive"></i> Archived</span>
                                    @endif
                                </td>
                                <td>{{ $study->creator_name ?? 'N/A' }}</td>
                                <td>{{ \Carbon\Carbon::parse($study->created_at)->format('Y-m-d') }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('offer-feasibility-study.show', ['id' => $study->id]) }}" class="btn btn-sm btn-info" title="View Study">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="{{ route('offer-feasibility-study.edit', ['id' => $study->id]) }}" class="btn btn-sm btn-warning" title="Edit Study">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <form action="{{ route('offer-feasibility-study.duplicate', ['id' => $study->id]) }}" method="POST" style="display:inline;" class="duplicate-form" data-study-name="{{ $study->study_name }}">
                                            @csrf
                                            <button type="button" class="btn btn-sm btn-secondary duplicate-btn" title="Duplicate Study" data-study-id="{{ $study->id }}" data-study-name="{{ $study->study_name }}">
                                                <i class="fa fa-copy"></i>
                                            </button>
                                        </form>
                                        @if($study->study_type != 'Master')
                                        <form action="{{ route('offer-feasibility-study.delete', ['id' => $study->id]) }}" method="POST" style="display:inline;" class="delete-form" data-study-name="{{ $study->study_name }}">
                                            @csrf
                                            <button type="button" class="btn btn-sm btn-danger delete-btn" title="Delete Study" data-study-id="{{ $study->id }}" data-study-name="{{ $study->study_name }}">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ URL::asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        // Initialize DataTable
        var table = $('#datatable').DataTable({
            order: [[0, 'desc']],
            pageLength: 25
        });
        
        // Display success/error messages with SweetAlert2
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                toast: true,
                position: 'top-end'
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: '{{ session('error') }}',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                toast: true,
                position: 'top-end'
            });
        @endif
    });
    
    // Handle Delete Button Click
    $(document).on('click', '.delete-btn', function(e) {
        e.preventDefault();
        const studyName = $(this).data('study-name');
        const form = $(this).closest('form');
        
        Swal.fire({
            title: 'Delete Feasibility Study?',
            html: `Are you sure you want to delete <strong>"${studyName}"</strong>?<br><span style="color: #dc3545; font-size: 14px;">This action cannot be undone!</span>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="fa fa-trash"></i> Yes, Delete It',
            cancelButtonText: '<i class="fa fa-times"></i> Cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
    
    // Handle Duplicate Button Click
    $(document).on('click', '.duplicate-btn', function(e) {
        e.preventDefault();
        const studyName = $(this).data('study-name');
        const form = $(this).closest('form');
        
        Swal.fire({
            title: 'Duplicate Feasibility Study?',
            html: `Create a copy of <strong>"${studyName}"</strong>?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#17a2b8',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="fa fa-copy"></i> Yes, Duplicate It',
            cancelButtonText: '<i class="fa fa-times"></i> Cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
</script>
@endsection

