@extends('admin::layouts.master')
@section('title', 'Edit Default Banner')

@section('css')
<link rel="stylesheet" href="{{ asset('/css/auto-translate.css') }}">
<link rel="stylesheet" href="{{asset('/css/dropify.min.css')}}">
<style>
    .word-count { font-size: 12px; color: #6c757d; margin-top: 5px; }
    .word-count.error { color: #dc3545; font-weight: bold; }
</style>
@endsection

@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        <nav class="breadcrumbs">
            <a href="{{route('Admin')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a href="{{route('admin.default-banners.index')}}" class="breadcrumbs__item"><i class="fa fa-image"></i> Default Banners</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-pencil"></i> Edit</a>
        </nav>

        <div class="col-lg-12">
            <hr>
            <div class="card">
                <div class="card-body">
                    <h4 class="mt-0 header-title"><i class="fa fa-pencil"></i> Edit Default Banner</h4>
                    <hr>
                    
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <form action="{{ route('admin.default-banners.update', ['id' => $banner->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3 text-right">
                            <button type="button" class="translate-all-btn"><i class="fa fa-language"></i> Translate All to Arabic</button>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Title English <i class="mdi mdi-18px mdi-alert-octagon text-danger"></i> <small>(Max 5 Words)</small></label>
                                    <input type="text" class="form-control" name="title_english" value="{{ old('title_english', $banner->title_english) }}" required maxlength="150" id="title_english">
                                    <div class="word-count" id="title_english_count">0 / 5 words</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Title Arabic <button type="button" class="auto-translate-btn" data-translate-source="title_english" data-translate-target="title_arabic"><i class="fa fa-language"></i> Auto</button> <i class="mdi mdi-18px mdi-alert-octagon text-danger"></i> <small>(Max 5 Words)</small></label>
                                    <input type="text" class="form-control" name="title_arabic" value="{{ old('title_arabic', $banner->title_arabic) }}" required maxlength="150" dir="rtl" id="title_arabic">
                                    <div class="word-count" id="title_arabic_count">0 / 5 words</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Background Image <small>(Will be converted to WebP 1890x492 - Quality 80%)</small></label>
                                    <input accept="image/*" class="form-control dropify" type="file" name="background" data-max-file-size="5M" data-allowed-file-extensions="jpg jpeg png webp" data-default-file="{{ asset('storage' . $banner->background) }}">
                                    <small class="form-text text-muted">Max size: 5MB. Leave empty to keep current image. Will be converted to WebP 1890x492px</small>
                                    @error('background')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Status <i class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                    <select class="form-control" name="status" required>
                                        <option value="0" {{ old('status', $banner->status) == '0' ? 'selected' : '' }}>Active</option>
                                        <option value="1" {{ old('status', $banner->status) == '1' ? 'selected' : '' }}>Not Active</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <hr>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Update Banner</button>
                            <a href="{{ route('admin.default-banners.index') }}" class="btn btn-secondary"><i class="fa fa-times"></i> Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('/js/auto-translate.js') }}"></script>
<script src="{{asset('/js/dropify.min.js')}}"></script>
<script>
    $(document).ready(function() {
        // Initialize Dropify
        $('.dropify').dropify();
        
        function updateWordCount(selector, countSelector, maxWords) {
            const text = $(selector).val().trim();
            const wordCount = text === '' ? 0 : text.split(/\s+/).length;
            $(countSelector).text(wordCount + ' / ' + maxWords + ' words');
            if (wordCount > maxWords) $(countSelector).addClass('error'); else $(countSelector).removeClass('error');
        }
        
        $('#title_english').on('input', function() { updateWordCount('#title_english', '#title_english_count', 5); });
        $('#title_arabic').on('input', function() { updateWordCount('#title_arabic', '#title_arabic_count', 5); });
        
        // Initial counts
        updateWordCount('#title_english', '#title_english_count', 5);
        updateWordCount('#title_arabic', '#title_arabic_count', 5);
    });
</script>
@endsection

