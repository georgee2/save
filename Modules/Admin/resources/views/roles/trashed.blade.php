@extends('admin::layouts.master')
@section('title', 'Trashed Roles')

@section('css')
<style>
    .trashed-table {
        width: 100%;
    }
    .trashed-table th {
        background: #f8f9fa;
        padding: 15px;
        font-weight: 600;
    }
    .trashed-table td {
        padding: 15px;
        vertical-align: middle;
        border-bottom: 1px solid #e9ecef;
    }
    .role-name {
        font-weight: 600;
        color: #333;
    }
    .deleted-date {
        color: #666;
        font-size: 0.9rem;
    }
</style>
@endsection

@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        <nav class="breadcrumbs">
            <a href="{{ route('Admin') }}" class="breadcrumbs__item">
                <i class="fa fa-home"></i> Dashboard
            </a>
            <a href="{{ route('admin.roles.index') }}" class="breadcrumbs__item">
                <i class="fa fa-shield-alt"></i> Roles
            </a>
            <a href="#" class="breadcrumbs__item is-active" style="pointer-events: none;">
                <i class="fa fa-trash"></i> Trashed Roles
            </a>
        </nav>

        <div class="col-lg-12">
            <hr>
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h4 class="mt-0 header-title">Trashed Roles</h4>
                            <p class="text-muted mb-0">Manage deleted roles - restore or permanently delete</p>
                        </div>
                        <a href="{{ route('admin.roles.index') }}" class="btn btn-primary">
                            <i class="fa fa-angle-left"></i> Back to Roles
                        </a>
                    </div>
                    <hr>

                    @if($roles->count() > 0)
                        <div class="table-responsive">
                            <table class="trashed-table">
                                <thead>
                                    <tr>
                                        <th>Role Name</th>
                                        <th>Description</th>
                                        <th>Deleted At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($roles as $role)
                                        <tr>
                                            <td>
                                                <span class="role-name">{{ $role->name }}</span>
                                                <br>
                                                <small class="text-muted">{{ $role->slug }}</small>
                                            </td>
                                            <td>{{ $role->description ?? '-' }}</td>
                                            <td>
                                                <span class="deleted-date">
                                                    {{ $role->deleted_at->format('M d, Y H:i') }}
                                                    <br>
                                                    <small>{{ $role->deleted_at->diffForHumans() }}</small>
                                                </span>
                                            </td>
                                            <td>
                                                <form action="{{ route('admin.roles.restore', $role->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success btn-sm">
                                                        <i class="fa fa-undo"></i> Restore
                                                    </button>
                                                </form>
                                                
                                                @if(!$role->is_system)
                                                    <form action="{{ route('admin.roles.force-delete', $role->id) }}" method="POST" style="display: inline;"
                                                          onsubmit="return confirm('Are you sure you want to permanently delete this role? This action cannot be undone.');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm">
                                                            <i class="fa fa-times"></i> Delete Permanently
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="fa fa-info-circle"></i> No trashed roles found.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
