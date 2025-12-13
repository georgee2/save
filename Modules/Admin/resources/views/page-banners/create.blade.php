@extends('admin::layouts.master')
@section('title', 'Create Page Banner')
@section('content')

<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav style="margin-left: 1px !important;" class="breadcrumbs">
            <a href="{{ route('Admin') }}" class="breadcrumbs__item">
                <i class="fa fa-home"></i> Dashboard
            </a>
            <a href="{{ route('page-banner.index') }}" class="breadcrumbs__item">
                <i class="fa fa-image"></i> Page Banners
            </a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active">
                <i class="fa fa-plus"></i> Create Banner
            </a>
        </nav>

        <hr>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="mt-0 header-title mb-4">Create New Page Banner</h4>

                        <form action="{{ route('page-banner.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="target">Target Page <span class="text-danger">*</span></label>
                                        <select name="target" id="target" class="form-control select2 @error('target') is-invalid @enderror" required>
                                            <option value="">Select Target Page</option>
                                            @foreach($targetPages as $key => $value)
                                            <option value="{{ $key }}" {{ old('target') == $key ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('target')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">Select the page where this banner will be displayed.</small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cover">Cover Image (1980x420) <span class="text-danger">*</span></label>
                                        <input type="file" name="cover" id="cover" class="dropify @error('cover') is-invalid @enderror" 
                                               data-allowed-file-extensions="jpg jpeg png gif webp" 
                                               data-max-file-size="5M"
                                               required>
                                        @error('cover')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">
                                            Recommended size: 1980x420 pixels. Image will be automatically converted to WebP format.
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> Create Banner
                                </button>
                                <a href="{{ route('page-banner.index') }}" class="btn btn-secondary">
                                    <i class="fa fa-times"></i> Cancel
                                </a>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection

@section('js')
<script src="{{ asset('/js/dropify.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.dropify').dropify();
    });
</script>
@endsection

