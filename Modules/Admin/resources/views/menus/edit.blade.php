@extends('admin::layouts.master')
@section('title', 'Edit Menu')

@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Admin')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a href="{{route('admin.menu.index')}}" class="breadcrumbs__item"><i class="fa fa-bars"></i> Menus</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-edit"></i> Edit Menu</a>
        </nav>

        <div class="col-lg-12">
            <hr>
            
            <div class="card">
                <div class="card-body">
                    <h4 class="mt-0 header-title"><i class="fa fa-edit"></i> Edit Menu: {{ $menu->title_english }}</h4>
                    @if($menu->is_primary)
                    <span class="badge badge-info"><i class="fa fa-star"></i> Primary Menu - Cannot be deleted</span>
                    @endif
                    <hr>
                    
                    <form action="{{ route('admin.menu.update', $menu->id) }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Title (English) <i class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <input class="form-control" value="{{ old('title_english', $menu->title_english) }}" type="text" name="title_english" placeholder="Enter menu title in English" required>
                                @error('title_english')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="form-group col-md-6">
                                <label>Title (Arabic)</label>
                                <input class="form-control" value="{{ old('title_arabic', $menu->title_arabic) }}" type="text" name="title_arabic" placeholder="أدخل عنوان القائمة بالعربية" dir="rtl">
                                @error('title_arabic')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Slug <i class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <input class="form-control" value="{{ old('slug', $menu->slug) }}" type="text" name="slug" placeholder="menu-slug" required {{ $menu->is_primary ? 'readonly' : '' }}>
                                <small class="text-muted">Unique identifier for this menu</small>
                                @error('slug')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="form-group col-md-6">
                                <label>Location <i class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <select class="form-control" name="location" required>
                                    <option value="header" {{ old('location', $menu->location) == 'header' ? 'selected' : '' }}>Header</option>
                                    <option value="footer" {{ old('location', $menu->location) == 'footer' ? 'selected' : '' }}>Footer</option>
                                    <option value="sidebar" {{ old('location', $menu->location) == 'sidebar' ? 'selected' : '' }}>Sidebar</option>
                                    <option value="mobile" {{ old('location', $menu->location) == 'mobile' ? 'selected' : '' }}>Mobile</option>
                                    <option value="other" {{ old('location', $menu->location) == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('location')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Description (English)</label>
                                <textarea class="form-control" name="description_english" rows="3" placeholder="Enter menu description">{{ old('description_english', $menu->description_english) }}</textarea>
                                @error('description_english')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="form-group col-md-6">
                                <label>Description (Arabic)</label>
                                <textarea class="form-control" name="description_arabic" rows="3" placeholder="أدخل وصف القائمة" dir="rtl">{{ old('description_arabic', $menu->description_arabic) }}</textarea>
                                @error('description_arabic')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Status <i class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <select class="form-control" name="is_active" required>
                                    <option value="1" {{ old('is_active', $menu->is_active) == '1' ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ old('is_active', $menu->is_active) == '0' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('is_active')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        
                        <hr>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-save"></i> Update Menu
                            </button>
                            <a href="{{ route('admin.menu.items', $menu->id) }}" class="btn btn-primary">
                                <i class="fa fa-list"></i> Manage Items
                            </a>
                            <a href="{{ route('admin.menu.index') }}" class="btn btn-secondary">
                                <i class="fa fa-arrow-left"></i> Back to Menus
                            </a>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
