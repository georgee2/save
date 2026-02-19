@extends('admin::layouts.master')
@section('title', 'Menus Management')

@section('css')
<style>
    .menu-card {
        border-radius: 10px;
        transition: all 0.3s ease;
        border: 1px solid #e9ecef;
    }
    
    .menu-card:hover {
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        transform: translateY(-2px);
    }
    
    .menu-card.primary-menu {
        border-left: 4px solid #19868b;
    }
    
    .menu-icon {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        background: linear-gradient(135deg, #19868b 0%, #25a5aa 100%);
        color: #fff;
        font-size: 20px;
    }
    
    .menu-stats {
        display: flex;
        gap: 15px;
    }
    
    .menu-stat {
        text-align: center;
        padding: 8px 15px;
        background: #f8f9fa;
        border-radius: 8px;
    }
    
    .menu-stat-number {
        font-size: 18px;
        font-weight: 700;
        color: #333;
    }
    
    .menu-stat-label {
        font-size: 11px;
        color: #6c757d;
        text-transform: uppercase;
    }
    
    .badge-primary-menu {
        background: linear-gradient(135deg, #19868b 0%, #25a5aa 100%);
        color: #fff;
    }
    
    .badge-location {
        background: #e3f2fd;
        color: #1565c0;
    }
    
    .action-btn {
        width: 36px;
        height: 36px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        margin: 0 3px;
        transition: all 0.2s ease;
    }
    
    .action-btn:hover {
        transform: scale(1.1);
    }
</style>
@endsection

@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Admin')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-bars"></i> Menus</a>
        </nav>

        <div class="col-lg-12">
            <hr>
            
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <h4 class="mt-0 header-title"><i class="fa fa-bars"></i> Menus Management</h4>
                        </div>
                        <div class="col-sm-6 text-right">
                            <a href="{{ route('admin.menu.guide') }}" class="btn btn-secondary btn-sm mr-2">
                                <i class="fa fa-book"></i> User Guide
                            </a>
                            <a href="{{ route('admin.menu.settings') }}" class="btn btn-info btn-sm mr-2">
                                <i class="fa fa-cog"></i> Settings
                            </a>
                            <a href="{{ route('admin.menu.trashed') }}" class="btn btn-danger btn-sm mr-2">
                                <i class="fa fa-trash"></i> Trashed
                            </a>
                            <a href="{{ route('admin.menu.create') }}" class="btn btn-success btn-sm">
                                <i class="fa fa-plus"></i> Add New Menu
                            </a>
                        </div>
                    </div>
                    <hr>
                    
                    <div class="alert alert-info" style="background: #e3f2fd; border-left: 4px solid #2196f3; color: #1565c0;">
                        <i class="fa fa-info-circle"></i> <strong>Tip:</strong> Primary menus cannot be deleted, only hidden. Click on a menu to manage its items.
                    </div>
                    
                    @if($menus->count() > 0)
                    <div class="row">
                        @foreach($menus as $menu)
                        <div class="col-lg-6 col-xl-4 mb-4">
                            <div class="card menu-card {{ $menu->is_primary ? 'primary-menu' : '' }}">
                                <div class="card-body">
                                    <div class="d-flex align-items-start mb-3">
                                        <div class="menu-icon mr-3">
                                            <i class="fa fa-bars"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h5 class="mb-1">{{ $menu->title_english }}</h5>
                                            <p class="text-muted small mb-2">{{ $menu->title_arabic }}</p>
                                            <div class="d-flex gap-2 flex-wrap">
                                                @if($menu->is_primary)
                                                <span class="badge badge-primary-menu"><i class="fa fa-star"></i> Primary</span>
                                                @endif
                                                @php
                                                    $locationLabels = [
                                                        'header' => 'Header',
                                                        'footer_quick_links' => 'Footer - Quick Links',
                                                        'footer_company' => 'Footer - Company',
                                                        'footer' => 'Footer',
                                                        'sidebar' => 'Sidebar',
                                                        'mobile' => 'Mobile',
                                                        'other' => 'Other',
                                                    ];
                                                    $locationLabel = $locationLabels[$menu->location] ?? ucfirst($menu->location);
                                                @endphp
                                                <span class="badge badge-location"><i class="fa fa-map-marker"></i> {{ $locationLabel }}</span>
                                                @if($menu->is_active)
                                                <span class="badge badge-success"><i class="fa fa-check"></i> Active</span>
                                                @else
                                                <span class="badge badge-secondary"><i class="fa fa-times"></i> Inactive</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="menu-stats mb-3">
                                        <div class="menu-stat">
                                            <div class="menu-stat-number">{{ $menu->items_count }}</div>
                                            <div class="menu-stat-label">Items</div>
                                        </div>
                                    </div>
                                    
                                    @if($menu->description_english)
                                    <p class="text-muted small mb-3">{{ Str::limit($menu->description_english, 80) }}</p>
                                    @endif
                                    
                                    <div class="d-flex justify-content-between align-items-center">
                                        <a href="{{ route('admin.menu.items', $menu->id) }}" class="btn btn-primary btn-sm">
                                            <i class="fa fa-list"></i> Manage Items
                                        </a>
                                        <div>
                                            <form action="{{ route('admin.menu.toggle-status', $menu->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                <button type="submit" class="action-btn btn btn-sm {{ $menu->is_active ? 'btn-outline-success' : 'btn-outline-secondary' }}" title="{{ $menu->is_active ? 'Deactivate' : 'Activate' }}">
                                                    <i class="fa {{ $menu->is_active ? 'fa-eye' : 'fa-eye-slash' }}"></i>
                                                </button>
                                            </form>
                                            <a href="{{ route('admin.menu.edit', $menu->id) }}" class="action-btn btn btn-outline-info btn-sm" title="Edit">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            @if($menu->canBeDeleted())
                                            <form action="{{ route('admin.menu.delete', $menu->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this menu?')">
                                                @csrf
                                                <button type="submit" class="action-btn btn btn-outline-danger btn-sm" title="Delete">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                            @else
                                            <button type="button" class="action-btn btn btn-outline-secondary btn-sm" disabled title="Cannot delete primary menu">
                                                <i class="fa fa-lock"></i>
                                            </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="alert alert-warning text-center">
                        <i class="fa fa-exclamation-triangle fa-2x mb-2"></i>
                        <p class="mb-0">No menus found. <a href="{{ route('admin.menu.create') }}">Create your first menu</a>.</p>
                    </div>
                    @endif
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
