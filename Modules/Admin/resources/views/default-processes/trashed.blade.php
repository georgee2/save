@extends('admin::layouts.master')
@section('title', 'Trashed Default Processes')

@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endsection

@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Admin')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a href="{{route('admin.default-processes.index')}}" class="breadcrumbs__item"><i class="fa fa-cogs"></i> Default Processes</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-trash"></i> Trashed</a>
        </nav>

        <div class="col-lg-12">
            <hr>
            
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <h4 class="mt-0 header-title"><i class="fa fa-trash"></i> Trashed Default Processes</h4>
                        </div>
                        <div class="col-sm-6 text-right">
                            <a href="{{ route('admin.default-processes.index') }}" class="btn btn-primary btn-sm">
                                <i class="fa fa-arrow-left"></i> Back to Processes
                            </a>
                        </div>
                    </div>
                    <hr>
                    
                    @if($processes->isEmpty())
                        <div class="alert alert-info">
                            <i class="fa fa-info-circle"></i> No trashed processes found.
                        </div>
                    @else
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 60px;">ID</th>
                                    <th>Title (English)</th>
                                    <th>Title (Arabic)</th>
                                    <th style="width: 110px;">Deleted Date</th>
                                    <th style="width: 150px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($processes as $process)
                                <tr>
                                    <td>{{ $process->id }}</td>
                                    <td><strong>{{ $process->title_english }}</strong></td>
                                    <td dir="rtl"><strong>{{ $process->title_arabic }}</strong></td>
                                    <td>{{ \Carbon\Carbon::parse($process->deleted_at)->format('Y-m-d') }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <form action="{{ route('admin.default-processes.restore', ['id' => $process->id]) }}" method="POST" style="display:inline;" class="restore-form">
                                                @csrf
                                                <button type="button" class="btn btn-sm btn-success restore-btn" data-id="{{ $process->id }}" data-title="{{ $process->title_english }}">
                                                    <i class="fa fa-undo"></i> Restore
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.default-processes.force-delete', ['id' => $process->id]) }}" method="POST" style="display:inline;" class="force-delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-sm btn-danger force-delete-btn" data-id="{{ $process->id }}" data-title="{{ $process->title_english }}">
                                                    <i class="fa fa-trash-alt"></i> Delete Forever
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

        $(document).on('click', '.restore-btn', function(e) {
            e.preventDefault();
            const title = $(this).data('title');
            const form = $(this).closest('form');
            
            Swal.fire({
                title: 'Restore Process?',
                html: `Are you sure you want to restore <strong>"${title}"</strong>?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                confirmButtonText: '<i class="fa fa-undo"></i> Yes, Restore It'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
        
        $(document).on('click', '.force-delete-btn', function(e) {
            e.preventDefault();
            const title = $(this).data('title');
            const form = $(this).closest('form');
            
            Swal.fire({
                title: 'Permanently Delete?',
                html: `Are you sure you want to permanently delete <strong>"${title}"</strong>?<br><span style="color: #dc3545;">This action CANNOT be undone!</span>`,
                icon: 'error',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                confirmButtonText: '<i class="fa fa-trash-alt"></i> Yes, Delete Forever'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endsection

