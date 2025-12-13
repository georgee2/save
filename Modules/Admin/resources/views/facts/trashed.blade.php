@extends('admin::layouts.master')
@section('title', 'Trashed Facts')

@section('css')
<!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<!-- Animate.css for animations -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<style>
    .fact-icon-thumb {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 8px;
        border: 2px solid #e0e0e0;
    }
</style>
@endsection

@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Admin')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a href="{{route('admin.facts.index')}}" class="breadcrumbs__item"><i class="fa fa-chart-line"></i> Facts</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-trash"></i> Trashed Facts</a>
        </nav>

        <div class="col-lg-12">
            <hr>
            
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <h4 class="mt-0 header-title"><i class="fa fa-trash"></i> Trashed Facts</h4>
                        </div>
                        <div class="col-sm-6 text-right">
                            <a href="{{ route('admin.facts.index') }}" class="btn btn-primary btn-sm">
                                <i class="fa fa-arrow-left"></i> Back to Facts
                            </a>
                        </div>
                    </div>
                    <hr>
                    
                    @if($facts->isEmpty())
                        <div class="alert alert-info">
                            <i class="fa fa-info-circle"></i> No trashed facts found.
                        </div>
                    @else
                        <table class="table table-striped table-bordered" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th style="width: 60px;">ID</th>
                                    <th style="width: 120px;">Icon</th>
                                    <th>Title (English)</th>
                                    <th>Title (Arabic)</th>
                                    <th style="width: 120px;">Fact Number</th>
                                    <th style="width: 110px;">Deleted Date</th>
                                    <th style="width: 150px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($facts as $fact)
                                <tr>
                                    <td>{{ $fact->id }}</td>
                                    <td>
                                        <img src="{{ asset('storage' . $fact->icon) }}" alt="{{ $fact->title_english }}" class="fact-icon-thumb">
                                    </td>
                                    <td><strong>{{ $fact->title_english }}</strong></td>
                                    <td dir="rtl"><strong>{{ $fact->title_arabic }}</strong></td>
                                    <td style="text-align: center;"><span class="badge badge-primary" style="font-size: 16px;">{{ $fact->fact_number }}</span></td>
                                    <td>{{ \Carbon\Carbon::parse($fact->deleted_at)->format('Y-m-d') }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <form action="{{ route('admin.facts.restore', ['id' => $fact->id]) }}" method="POST" style="display:inline;" class="restore-form">
                                                @csrf
                                                <button type="button" class="btn btn-sm btn-success restore-btn" data-fact-id="{{ $fact->id }}" data-fact-title="{{ $fact->title_english }}">
                                                    <i class="fa fa-undo"></i> Restore
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.facts.force-delete', ['id' => $fact->id]) }}" method="POST" style="display:inline;" class="force-delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-sm btn-danger force-delete-btn" data-fact-id="{{ $fact->id }}" data-fact-title="{{ $fact->title_english }}">
                                                    <i class="fa fa-trash-alt"></i> Delete Permanently
                                                </button>
                                            </form>
                                        </div>
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
<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
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
        
        // Handle Restore Button Click
        $(document).on('click', '.restore-btn', function(e) {
            e.preventDefault();
            
            const factTitle = $(this).data('fact-title');
            const form = $(this).closest('form');
            
            Swal.fire({
                title: 'Restore Fact?',
                html: `Are you sure you want to restore <strong>"${factTitle}"</strong>?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fa fa-undo"></i> Yes, Restore It',
                cancelButtonText: '<i class="fa fa-times"></i> Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
        
        // Handle Force Delete Button Click
        $(document).on('click', '.force-delete-btn', function(e) {
            e.preventDefault();
            
            const factTitle = $(this).data('fact-title');
            const form = $(this).closest('form');
            
            Swal.fire({
                title: 'Permanently Delete?',
                html: `Are you sure you want to permanently delete <strong>"${factTitle}"</strong>?<br><span style="color: #dc3545; font-size: 14px;">This action CANNOT be undone!</span>`,
                icon: 'error',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fa fa-trash-alt"></i> Yes, Delete Forever',
                cancelButtonText: '<i class="fa fa-times"></i> Cancel',
                reverseButtons: true,
                focusCancel: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endsection

