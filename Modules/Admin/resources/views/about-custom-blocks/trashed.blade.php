@extends('admin::layouts.master')
@section('title', 'Trashed About Custom Blocks')

@section('css')
<link href="{{ URL::asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<!-- Animate.css -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<style>
    .block-image {
        width: 80px;
        height: 61px;
        object-fit: cover;
        border-radius: 4px;
        opacity: 0.5;
    }
</style>
@endsection

@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Admin')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a href="{{route('about-custom-block.index')}}" class="breadcrumbs__item"><i class="fa fa-th-large"></i> About Custom Blocks</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-trash"></i> Trashed Blocks</a>
        </nav>

        <div class="col-lg-12">
            <hr>
            
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <h4 class="mt-0 header-title"><i class="fa fa-trash"></i> Trashed About Custom Blocks</h4>
                        </div>
                        <div class="col-sm-6 text-right">
                            <a href="{{ route('about-custom-block.index') }}" class="btn btn-primary btn-sm">
                                <i class="fa fa-arrow-left"></i> Back to Blocks
                            </a>
                        </div>
                    </div>
                    <hr>
                    
                    @if($blocks->isEmpty())
                        <div class="alert alert-info text-center">
                            <i class="fa fa-info-circle"></i> No trashed blocks found.
                        </div>
                    @else
                        <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Image</th>
                                    <th>Title (English)</th>
                                    <th>Title (Arabic)</th>
                                    <th>Status</th>
                                    <th>Deleted Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($blocks as $block)
                                <tr>
                                    <td>{{ $block->id }}</td>
                                    <td>
                                        @if($block->image)
                                            <img src="{{ asset('storage' . $block->image) }}" alt="Block Image" class="block-image">
                                        @else
                                            <span class="text-muted">No Image</span>
                                        @endif
                                    </td>
                                    <td><strong>{{ $block->title_english }}</strong></td>
                                    <td dir="rtl"><strong>{{ $block->title_arabic }}</strong></td>
                                    <td>
                                        @if($block->status == 0)
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-danger">Not Active</span>
                                        @endif
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($block->deleted_at)->format('Y-m-d H:i') }}</td>
                                    <td>
                                        <form action="{{ route('about-custom-block.restore', ['id' => $block->id]) }}" method="POST" style="display:inline;" class="restore-form">
                                            @csrf
                                            <button type="button" class="btn btn-sm btn-success restore-btn" data-block-title="{{ $block->title_english }}">
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
            const blockTitle = $(this).data('block-title');
            const form = $(this).closest('form');
            
            Swal.fire({
                title: 'Restore Block?',
                html: `Are you sure you want to restore <strong>"${blockTitle}"</strong>?`,
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

