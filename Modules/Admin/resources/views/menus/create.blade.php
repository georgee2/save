@extends('admin::layouts.master')
@section('title', 'Create Menu')

@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Admin')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a href="{{route('admin.menu.index')}}" class="breadcrumbs__item"><i class="fa fa-bars"></i> Menus</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-plus"></i> Create Menu</a>
        </nav>

        <div class="col-lg-12">
            <hr>
            
            <div class="card">
                <div class="card-body">
                    <h4 class="mt-0 header-title"><i class="fa fa-plus"></i> Create New Menu</h4>
                    <hr>
                    
                    <form action="{{ route('admin.menu.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Title (English) <i class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <input class="form-control" value="{{ old('title_english') }}" type="text" name="title_english" placeholder="Enter menu title in English" required>
                                @error('title_english')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="form-group col-md-6">
                                <label>Title (Arabic)</label>
                                <input class="form-control" value="{{ old('title_arabic') }}" type="text" name="title_arabic" placeholder="أدخل عنوان القائمة بالعربية" dir="rtl">
                                @error('title_arabic')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Slug <i class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <input class="form-control" value="{{ old('slug') }}" type="text" name="slug" placeholder="menu-slug" required>
                                <small class="text-muted">Unique identifier for this menu (e.g., header-menu, footer-menu)</small>
                                @error('slug')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="form-group col-md-6">
                                <label>Location <i class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <select class="form-control" name="location" required>
                                    <option value="header" {{ old('location') == 'header' ? 'selected' : '' }}>Header</option>
                                    <option value="footer" {{ old('location') == 'footer' ? 'selected' : '' }}>Footer</option>
                                    <option value="sidebar" {{ old('location') == 'sidebar' ? 'selected' : '' }}>Sidebar</option>
                                    <option value="mobile" {{ old('location') == 'mobile' ? 'selected' : '' }}>Mobile</option>
                                    <option value="other" {{ old('location') == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('location')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Description (English)</label>
                                <textarea class="form-control" name="description_english" rows="3" placeholder="Enter menu description">{{ old('description_english') }}</textarea>
                                @error('description_english')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="form-group col-md-6">
                                <label>Description (Arabic)</label>
                                <textarea class="form-control" name="description_arabic" rows="3" placeholder="أدخل وصف القائمة" dir="rtl">{{ old('description_arabic') }}</textarea>
                                @error('description_arabic')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Status <i class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <select class="form-control" name="is_active" required>
                                    <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('is_active')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        
                        <hr>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-save"></i> Create Menu
                            </button>
                            <a href="{{ route('admin.menu.index') }}" class="btn btn-secondary">
                                <i class="fa fa-arrow-left"></i> Cancel
                            </a>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
$(document).ready(function() {
    // Auto-generate slug from title
    $('input[name="title_english"]').on('keyup', function() {
        var slug = $(this).val()
            .toLowerCase()
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-');
        $('input[name="slug"]').val(slug);
    });
});
</script>
@endsection
