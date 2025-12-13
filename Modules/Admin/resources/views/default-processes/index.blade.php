@extends('admin::layouts.master')
@section('title', 'Default Processes Management')

@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
@endsection

@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Admin')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-cogs"></i> Default Processes</a>
        </nav>

        <div class="col-lg-12">
            <hr>
            
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <h4 class="mt-0 header-title"><i class="fa fa-cogs"></i> Default Processes Management</h4>
                        </div>
                        <div class="col-sm-6 text-right">
                            <a href="{{ route('admin.default-processes.create') }}" class="btn btn-success btn-sm">
                                <i class="fa fa-plus"></i> Add New Process
                            </a>
                            <a href="{{ route('admin.default-processes.trashed') }}" class="btn btn-danger btn-sm">
                                <i class="fa fa-trash"></i> Trashed Processes
                            </a>
                        </div>
                    </div>
                    <hr>
                    
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 60px;">ID</th>
                                <th>Title (English)</th>
                                <th>Title (Arabic)</th>
                                <th>Sub Title (English)</th>
                                <th style="width: 130px;">Status</th>
                                <th style="width: 110px;">Created Date</th>
                                <th style="width: 150px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($processes as $process)
                            <tr>
                                <td>{{ $process->id }}</td>
                                <td><strong>{{ $process->title_english }}</strong></td>
                                <td dir="rtl"><strong>{{ $process->title_arabic }}</strong></td>
                                <td>{{ $process->sub_title_english }}</td>
                                <td>
                                    <form action="{{ route('admin.default-processes.toggle-status', ['id' => $process->id]) }}" method="POST" style="display:inline;" class="toggle-status-form">
                                        @csrf
                                        @if($process->status == 0)
                                            <button type="button" class="btn btn-sm btn-success toggle-status-btn" data-id="{{ $process->id }}" data-current-status="0">
                                                <i class="fa fa-check"></i> Active
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-sm btn-danger toggle-status-btn" data-id="{{ $process->id }}" data-current-status="1">
                                                <i class="fa fa-times"></i> Not Active
                                            </button>
                                        @endif
                                    </form>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($process->created_at)->format('Y-m-d') }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.default-process-cards.index', ['processId' => $process->id]) }}" class="btn btn-sm btn-info" title="Manage Cards">
                                            <i class="fa fa-list"></i>
                                        </a>
                                        <a href="{{ route('admin.default-processes.edit', ['id' => $process->id]) }}" class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.default-processes.destroy', ['id' => $process->id]) }}" method="POST" style="display:inline;" class="delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="{{ $process->id }}" data-title="{{ $process->title_english }}">
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
                title: 'Delete Process?',
                html: `Are you sure you want to delete <strong>"${title}"</strong>?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fa fa-trash"></i> Yes, Delete It',
                cancelButtonText: '<i class="fa fa-times"></i> Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
        
        $(document).on('click', '.toggle-status-btn', function(e) {
            e.preventDefault();
            const currentStatus = $(this).data('current-status');
            const form = $(this).closest('form');
            const action = currentStatus == 0 ? 'deactivate' : 'activate';
            
            Swal.fire({
                title: action == 'activate' ? 'Activate Process?' : 'Deactivate Process?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: action == 'activate' ? '#28a745' : '#dc3545',
                confirmButtonText: action == 'activate' ? '<i class="fa fa-check"></i> Yes, Activate' : '<i class="fa fa-times"></i> Yes, Deactivate'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endsection

