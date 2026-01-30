@extends('admin::layouts.master')
@section('title', 'Trashed Menus')

@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Admin')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a href="{{route('admin.menu.index')}}" class="breadcrumbs__item"><i class="fa fa-bars"></i> Menus</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-trash"></i> Trashed</a>
        </nav>

        <div class="col-lg-12">
            <hr>
            
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <h4 class="mt-0 header-title"><i class="fa fa-trash"></i> Trashed Menus</h4>
                        </div>
                        <div class="col-sm-6 text-right">
                            <a href="{{ route('admin.menu.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fa fa-arrow-left"></i> Back to Menus
                            </a>
                        </div>
                    </div>
                    <hr>
                    
                    @if($menus->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Title (English)</th>
                                    <th>Title (Arabic)</th>
                                    <th>Location</th>
                                    <th>Deleted At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($menus as $menu)
                                <tr>
                                    <td>{{ $menu->id }}</td>
                                    <td>{{ $menu->title_english }}</td>
                                    <td>{{ $menu->title_arabic }}</td>
                                    <td><span class="badge badge-info">{{ ucfirst($menu->location) }}</span></td>
                                    <td>{{ $menu->deleted_at->format('Y-m-d H:i') }}</td>
                                    <td>
                                        <form action="{{ route('admin.menu.restore', $menu->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Are you sure you want to restore this menu?')">
                                                <i class="fa fa-undo"></i> Restore
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="alert alert-info text-center">
                        <i class="fa fa-info-circle fa-2x mb-2"></i>
                        <p class="mb-0">No trashed menus found.</p>
                    </div>
                    @endif
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
