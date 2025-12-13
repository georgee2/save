@extends('admin::layouts.master')
@section('title', 'Default Banners Management')

@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<style>
    .banner-image-thumb {
        width: 200px;
        height: 52px;
        object-fit: cover;
        border-radius: 4px;
        border: 2px solid #e0e0e0;
    }
</style>
@endsection

@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Admin')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-image"></i> Default Banners</a>
        </nav>

        <div class="col-lg-12">
            <hr>
            
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <h4 class="mt-0 header-title"><i class="fa fa-image"></i> Default Banners Management</h4>
                        </div>
                        <div class="col-sm-6 text-right">
                            <a href="{{ route('admin.default-banners.create') }}" class="btn btn-success btn-sm">
                                <i class="fa fa-plus"></i> Add New Banner
                            </a>
                            <a href="{{ route('admin.default-banners.trashed') }}" class="btn btn-danger btn-sm">
                                <i class="fa fa-trash"></i> Trashed Banners
                            </a>
                        </div>
                    </div>
                    <hr>
                    
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 60px;">ID</th>
                                <th style="width: 220px;">Background</th>
                                <th>Title (English)</th>
                                <th>Title (Arabic)</th>
                                <th style="width: 130px;">Status</th>
                                <th style="width: 110px;">Created Date</th>
                                <th style="width: 100px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($banners as $banner)
                            <tr>
                                <td>{{ $banner->id }}</td>
                                <td>
                                    <img src="{{ asset('storage' . $banner->background) }}" alt="{{ $banner->title_english }}" class="banner-image-thumb">
                                </td>
                                <td><strong>{{ $banner->title_english }}</strong></td>
                                <td dir="rtl"><strong>{{ $banner->title_arabic }}</strong></td>
                                <td>
                                    <form action="{{ route('admin.default-banners.toggle-status', ['id' => $banner->id]) }}" method="POST" style="display:inline;" class="toggle-status-form">
                                        @csrf
                                        @if($banner->status == 0)
                                            <button type="button" class="btn btn-sm btn-success toggle-status-btn" data-id="{{ $banner->id }}" data-current-status="0">
                                                <i class="fa fa-check"></i> Active
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-sm btn-danger toggle-status-btn" data-id="{{ $banner->id }}" data-current-status="1">
                                                <i class="fa fa-times"></i> Not Active
                                            </button>
                                        @endif
                                    </form>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($banner->created_at)->format('Y-m-d') }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.default-banners.edit', ['id' => $banner->id]) }}" class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.default-banners.destroy', ['id' => $banner->id]) }}" method="POST" style="display:inline;" class="delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="{{ $banner->id }}" data-title="{{ $banner->title_english }}">
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 3000,
                toast: true,
                position: 'top-end'
            });
        @endif

        $(document).on('click', '.delete-btn', function(e) {
            e.preventDefault();
            const title = $(this).data('title');
            const form = $(this).closest('form');
            
            Swal.fire({
                title: 'Delete Banner?',
                html: `Are you sure you want to delete <strong>"${title}"</strong>?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                confirmButtonText: '<i class="fa fa-trash"></i> Yes, Delete It'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
        
        $(document).on('click', '.toggle-status-btn', function(e) {
            e.preventDefault();
            const form = $(this).closest('form');
            form.submit();
        });
    });
</script>
@endsection

