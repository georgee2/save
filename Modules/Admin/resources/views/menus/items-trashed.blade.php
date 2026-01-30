@extends('admin::layouts.master')
@section('title', 'Trashed Menu Items - ' . $menu->title_english)

@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Admin')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a href="{{route('admin.menu.index')}}" class="breadcrumbs__item"><i class="fa fa-bars"></i> Menus</a>
            <a href="{{route('admin.menu.items', $menu->id)}}" class="breadcrumbs__item"><i class="fa fa-list"></i> {{ $menu->title_english }}</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-trash"></i> Trashed Items</a>
        </nav>

        <div class="col-lg-12">
            <hr>
            
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <h4 class="mt-0 header-title"><i class="fa fa-trash"></i> Trashed Items: {{ $menu->title_english }}</h4>
                        </div>
                        <div class="col-sm-6 text-right">
                            <a href="{{ route('admin.menu.items', $menu->id) }}" class="btn btn-secondary btn-sm">
                                <i class="fa fa-arrow-left"></i> Back to Items
                            </a>
                        </div>
                    </div>
                    <hr>
                    
                    @if($items->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Title (English)</th>
                                    <th>Title (Arabic)</th>
                                    <th>Type</th>
                                    <th>Deleted At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($items as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->title_english }}</td>
                                    <td>{{ $item->title_arabic }}</td>
                                    <td><span class="badge badge-secondary">{{ ucfirst(str_replace('_', ' ', $item->item_type)) }}</span></td>
                                    <td>{{ $item->deleted_at->format('Y-m-d H:i') }}</td>
                                    <td>
                                        <form action="{{ route('admin.menu.item.restore', [$menu->id, $item->id]) }}" method="POST" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Are you sure you want to restore this item?')">
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
                        <p class="mb-0">No trashed menu items found.</p>
                    </div>
                    @endif
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
