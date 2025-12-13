@extends('admin::layouts.master')
@section('title', 'Trashed About Features')

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
        opacity: 0.5;
    }
</style>
@endsection

@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Admin')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a href="{{route('about-feature.index')}}" class="breadcrumbs__item"><i class="fa fa-star"></i> About Features</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-trash"></i> Trashed Features</a>
        </nav>

        <div class="col-lg-12">
            <hr>
            
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <h4 class="mt-0 header-title"><i class="fa fa-trash"></i> Trashed About Features</h4>
                        </div>
                        <div class="col-sm-6 text-right">
                            <a href="{{ route('about-feature.index') }}" class="btn btn-primary btn-sm">
                                <i class="fa fa-arrow-left"></i> Back to Features
                            </a>
                        </div>
                    </div>
                    <hr>
                    
                    @if($features->isEmpty())
                        <div class="alert alert-info text-center">
                            <i class="fa fa-info-circle"></i> No trashed features found.
                        </div>
                    @else
                        <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Icon</th>
                                    <th>Title (English)</th>
                                    <th>Title (Arabic)</th>
                                    <th>Status</th>
                                    <th>Deleted Date</th>
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
                                        @if($feature->status == 0)
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-danger">Not Active</span>
                                        @endif
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($feature->deleted_at)->format('Y-m-d H:i') }}</td>
                                    <td>
                                        <form action="{{ route('about-feature.restore', ['id' => $feature->id]) }}" method="POST" style="display:inline;" class="restore-form">
                                            @csrf
                                            <button type="button" class="btn btn-sm btn-success restore-btn" data-feature-title="{{ $feature->title_english }}">
                                                <i class="fa fa-undo"></i> Restore
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
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
            order: [[5, 'desc']],
            pageLength: 25
        });
        
        // Display success messages
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
        
        // Handle Restore Button
        $(document).on('click', '.restore-btn', function(e) {
            e.preventDefault();
            const featureTitle = $(this).data('feature-title');
            const form = $(this).closest('form');
            
            Swal.fire({
                title: 'Restore Feature?',
                html: `Are you sure you want to restore <strong>"${featureTitle}"</strong>?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fa fa-undo"></i> Yes, Restore It',
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

