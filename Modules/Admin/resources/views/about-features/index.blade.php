@extends('admin::layouts.master')
@section('title', 'About Features')

@section('css')
<link href="{{ URL::asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<!-- Animate.css -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<style>
    .feature-icon {
        width: 50px;
        height: 45px;
        object-fit: contain;
    }
</style>
@endsection

@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Admin')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-star"></i> About Features</a>
        </nav>

        <div class="col-lg-12">
            <hr>
            
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <h4 class="mt-0 header-title"><i class="fa fa-star"></i> About Features Management</h4>
                        </div>
                        <div class="col-sm-6 text-right">
                            <a href="{{ route('about-feature.create') }}" class="btn btn-success btn-sm">
                                <i class="fa fa-plus"></i> Add New Feature
                            </a>
                            <a href="{{ route('about-feature.trashed') }}" class="btn btn-danger btn-sm">
                                <i class="fa fa-trash"></i> Trashed Features
                            </a>
                        </div>
                    </div>
                    <hr>
                    
                    <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Icon</th>
                                <th>Title (English)</th>
                                <th>Title (Arabic)</th>
                                <th>Status</th>
                                <th>Created Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($features as $feature)
                            <tr>
                                <td>{{ $feature->id }}</td>
                                <td>
                                    @if($feature->icon)
                                        <img src="{{ asset('storage' . $feature->icon) }}" alt="Icon" class="feature-icon">
                                    @else
                                        <span class="text-muted">No Icon</span>
                                    @endif
                                </td>
                                <td><strong>{{ $feature->title_english }}</strong></td>
                                <td dir="rtl"><strong>{{ $feature->title_arabic }}</strong></td>
                                <td>
                                    <form action="{{ route('about-feature.toggle-status', ['id' => $feature->id]) }}" method="POST" style="display:inline;" class="toggle-status-form">
                                        @csrf
                                        @if($feature->status == 0)
                                            <button type="button" class="btn btn-sm btn-success toggle-status-btn" data-feature-id="{{ $feature->id }}" data-current-status="0">
                                                <i class="fa fa-check"></i> Active
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-sm btn-danger toggle-status-btn" data-feature-id="{{ $feature->id }}" data-current-status="1">
                                                <i class="fa fa-times"></i> Not Active
                                            </button>
                                        @endif
                                    </form>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($feature->created_at)->format('Y-m-d') }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('about-feature.edit', ['id' => $feature->id]) }}" class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <form action="{{ route('about-feature.delete', ['id' => $feature->id]) }}" method="POST" style="display:inline;" class="delete-form">
                                            @csrf
                                            <button type="button" class="btn btn-sm btn-danger delete-btn" data-feature-title="{{ $feature->title_english }}">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
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
<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#datatable').DataTable({
            order: [[0, 'desc']],
            pageLength: 25
        });
        
        // Display success/error messages
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                toast: true,
                position: 'top-end',
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                }
            });
        @endif
        
        // Handle Delete Button
        $(document).on('click', '.delete-btn', function(e) {
            e.preventDefault();
            const featureTitle = $(this).data('feature-title');
            const form = $(this).closest('form');
            
            Swal.fire({
                title: 'Delete Feature?',
                html: `Are you sure you want to delete <strong>"${featureTitle}"</strong>?<br><span style="color: #dc3545;">This action cannot be undone!</span>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fa fa-trash"></i> Yes, Delete It',
                cancelButtonText: '<i class="fa fa-times"></i> Cancel',
                reverseButtons: true,
                showClass: {
                    popup: 'animate__animated animate__zoomIn animate__faster'
                },
                hideClass: {
                    popup: 'animate__animated animate__zoomOut animate__faster'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
        
        // Handle Toggle Status
        $(document).on('click', '.toggle-status-btn', function(e) {
            e.preventDefault();
            const currentStatus = $(this).data('current-status');
            const form = $(this).closest('form');
            const action = currentStatus == 0 ? 'deactivate' : 'activate';
            
            Swal.fire({
                title: action == 'activate' ? 'Activate Feature?' : 'Deactivate Feature?',
                text: action == 'activate' ? 'This feature will be visible on the website.' : 'This feature will be hidden from the website.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: action == 'activate' ? '#28a745' : '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: action == 'activate' ? '<i class="fa fa-check"></i> Yes, Activate' : '<i class="fa fa-times"></i> Yes, Deactivate',
                cancelButtonText: '<i class="fa fa-times"></i> Cancel',
                reverseButtons: true,
                showClass: {
                    popup: 'animate__animated animate__zoomIn animate__faster'
                },
                hideClass: {
                    popup: 'animate__animated animate__zoomOut animate__faster'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endsection

