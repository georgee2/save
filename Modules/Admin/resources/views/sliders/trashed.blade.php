@extends('admin::layouts.master')
@section('title', 'Trashed Sliders')

@section('css')
<link href="{{ URL::asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<!-- Animate.css for animations -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<style>
    .slider-image-thumb {
        width: 120px;
        height: 60px;
        object-fit: cover;
        border-radius: 4px;
    }
</style>
@endsection

@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Admin')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a href="{{route('slider.index')}}" class="breadcrumbs__item"><i class="fa fa-images"></i> Sliders</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-trash"></i> Trashed Sliders</a>
        </nav>

        <div class="col-lg-12">
            <hr>
            
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <h4 class="mt-0 header-title align-self-center"><i class="fa fa-trash"></i> Trashed Sliders</h4>
                        <div class="buttons">
                            <a href="{{ route('slider.index') }}" class="btn btn-primary">
                                <i class="fa fa-list"></i> Active Sliders
                            </a>
                            <button class="btn btn-secondary" onclick="window.history.back()">
                                <i class="fa fa-angle-left"></i> Back
                            </button>
                        </div>
                    </div>
                    <hr>
                    
                    @if(count($sliders) > 0)
                        <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Image</th>
                                    <th>Title (English)</th>
                                    <th>Title (Arabic)</th>
                                    <th>Ordering</th>
                                    <th>Status</th>
                                    <th>Deleted At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sliders as $slider)
                                <tr>
                                    <td>{{ $slider->id }}</td>
                                    <td>
                                        <img src="{{ asset('storage' . $slider->image) }}" alt="{{ $slider->title_english }}" class="slider-image-thumb">
                                    </td>
                                    <td><strong>{{ $slider->title_english }}</strong></td>
                                    <td dir="rtl"><strong>{{ $slider->title_arabic }}</strong></td>
                                    <td><span class="badge badge-info">{{ $slider->ordering }}</span></td>
                                    <td>
                                        @if($slider->status == 0)
                                            <span class="badge badge-success"><i class="fa fa-check"></i> Published</span>
                                        @else
                                            <span class="badge badge-danger"><i class="fa fa-times"></i> Not Published</span>
                                        @endif
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($slider->deleted_at)->format('M d, Y') }}</td>
                                    <td>
                                        <form action="{{ route('slider.restore', ['id' => $slider->id]) }}" method="POST" style="display:inline;" class="restore-form">
                                            @csrf
                                            <button type="button" class="btn btn-success btn-sm restore-btn" data-slider-id="{{ $slider->id }}" data-slider-title="{{ $slider->title_english }}">
                                                <i class="fa fa-undo"></i> Restore
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="alert alert-info text-center">
                            <i class="fa fa-info-circle"></i> No trashed sliders found.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
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
                position: 'top-end',
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                }
            });
        @endif
        
        // Handle Restore Button Click
        $(document).on('click', '.restore-btn', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const sliderTitle = $(this).data('slider-title');
            const form = $(this).closest('form');
            
            Swal.fire({
                title: 'Restore Slider?',
                html: `Are you sure you want to restore <strong>"${sliderTitle}"</strong>?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fa fa-undo"></i> Yes, Restore It',
                cancelButtonText: '<i class="fa fa-times"></i> Cancel',
                reverseButtons: true,
                focusCancel: true,
                showClass: {
                    popup: 'animate__animated animate__zoomIn animate__faster'
                },
                hideClass: {
                    popup: 'animate__animated animate__zoomOut animate__faster'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Restoring...',
                        text: 'Please wait while we restore the slider',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    form.submit();
                }
            });
        });
    });
</script>
@endsection

