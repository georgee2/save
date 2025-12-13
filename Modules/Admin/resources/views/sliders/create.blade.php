@extends('admin::layouts.master')
@section('title', 'Create Slider')

@section('css')
<style>
    .word-count {
        font-size: 12px;
        color: #6c757d;
        margin-top: 5px;
    }
    .word-count.error {
        color: #dc3545;
        font-weight: bold;
    }
</style>
@endsection

@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Admin')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a href="{{route('slider.index')}}" class="breadcrumbs__item"><i class="fa fa-images"></i> Sliders</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-plus"></i> Create Slider</a>
        </nav>

        <div class="col-lg-12">
            <hr>
            
            <div class="card">
                <div class="card-body">
                    <h4 class="mt-0 header-title"><i class="fa fa-plus"></i> Create New Slider</h4>
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
                    
                    <form action="{{ route('slider.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <!-- English Title -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>English Title <i class="mdi mdi-18px mdi-alert-octagon text-danger"></i> <small>(Max 4 Words)</small></label>
                                    <input type="text" class="form-control" name="title_english" value="{{ old('title_english') }}" required maxlength="255" id="title_english">
                                    <div class="word-count" id="title_english_count">0 / 4 words</div>
                                </div>
                            </div>
                            
                            <!-- Arabic Title -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Arabic Title <i class="mdi mdi-18px mdi-alert-octagon text-danger"></i> <small>(Max 4 Words)</small></label>
                                    <input type="text" class="form-control" name="title_arabic" value="{{ old('title_arabic') }}" required maxlength="255" dir="rtl" id="title_arabic">
                                    <div class="word-count" id="title_arabic_count">0 / 4 words</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <!-- English Bio -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>English Bio <i class="mdi mdi-18px mdi-alert-octagon text-danger"></i> <small>(Max 500 characters)</small></label>
                                    <textarea class="form-control" name="bio_english" rows="5" required maxlength="500" id="bio_english">{{ old('bio_english') }}</textarea>
                                    <div class="word-count" id="bio_english_count">0 / 500 characters</div>
                                </div>
                            </div>
                            
                            <!-- Arabic Bio -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Arabic Bio <i class="mdi mdi-18px mdi-alert-octagon text-danger"></i> <small>(Max 500 characters)</small></label>
                                    <textarea class="form-control" name="bio_arabic" rows="5" required maxlength="500" dir="rtl" id="bio_arabic">{{ old('bio_arabic') }}</textarea>
                                    <div class="word-count" id="bio_arabic_count">0 / 500 characters</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <!-- English Button Text -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Button Text (English) <small>(Optional, Max 2 Words)</small></label>
                                    <input type="text" class="form-control" name="button_text_english" value="{{ old('button_text_english') }}" maxlength="50" id="button_text_english">
                                    <div class="word-count" id="button_text_english_count">0 / 2 words</div>
                                </div>
                            </div>
                            
                            <!-- Arabic Button Text -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Button Text (Arabic) <small>(Optional, Max 2 Words)</small></label>
                                    <input type="text" class="form-control" name="button_text_arabic" value="{{ old('button_text_arabic') }}" maxlength="50" dir="rtl" id="button_text_arabic">
                                    <div class="word-count" id="button_text_arabic_count">0 / 2 words</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <!-- English URL -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>URL (English) <small>(Optional)</small></label>
                                    <input type="url" class="form-control" name="url_english" value="{{ old('url_english') }}" maxlength="255" placeholder="https://example.com">
                                </div>
                            </div>
                            
                            <!-- Arabic URL -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>URL (Arabic) <small>(Optional)</small></label>
                                    <input type="url" class="form-control" name="url_arabic" value="{{ old('url_arabic') }}" maxlength="255" placeholder="https://example.com" dir="rtl">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <!-- Image Upload -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Slider Image <i class="mdi mdi-18px mdi-alert-octagon text-danger"></i> <small>(Will be converted to WebP 1890x883 - Quality 80%)</small></label>
                                    <input accept="image/*" class="form-control dropify" type="file" name="image" required>
                                    <small class="form-text text-muted">Max size: 5MB. Will be converted to WebP 1890x883px</small>
                                    @error('image')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            
                            <!-- Ordering -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Ordering <i class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                    <input type="number" class="form-control" name="ordering" value="{{ old('ordering', 0) }}" required min="0">
                                    <small class="form-text text-muted">Lower numbers appear first</small>
                                </div>
                            </div>
                            
                            <!-- Status -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Status <i class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                    <select class="form-control" name="status" required>
                                        <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Published</option>
                                        <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Not Published</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-save"></i> Create Slider
                            </button>
                            <a href="{{ route('slider.index') }}" class="btn btn-secondary">
                                <i class="fa fa-times"></i> Cancel
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
<script src="{{ asset('/js/dropify.min.js') }}"></script>

<script>
    $(document).ready(function() {
        // Initialize Dropify
        $('.dropify').dropify();
        
        // Word count validation for titles and button text
        function countWords(str) {
            return str.trim() === '' ? 0 : str.trim().split(/\s+/).length;
        }
        
        function updateWordCount(inputId, countId, maxWords) {
            const input = document.getElementById(inputId);
            const countDiv = document.getElementById(countId);
            
            if (input && countDiv) {
                input.addEventListener('input', function() {
                    const wordCount = countWords(this.value);
                    countDiv.textContent = `${wordCount} / ${maxWords} words`;
                    
                    if (wordCount > maxWords) {
                        countDiv.classList.add('error');
                    } else {
                        countDiv.classList.remove('error');
                    }
                });
            }
        }
        
        function updateCharCount(inputId, countId, maxChars) {
            const input = document.getElementById(inputId);
            const countDiv = document.getElementById(countId);
            
            if (input && countDiv) {
                input.addEventListener('input', function() {
                    const charCount = this.value.length;
                    countDiv.textContent = `${charCount} / ${maxChars} characters`;
                    
                    if (charCount > maxChars) {
                        countDiv.classList.add('error');
                    } else {
                        countDiv.classList.remove('error');
                    }
                });
            }
        }
        
        // Apply word count validation
        updateWordCount('title_english', 'title_english_count', 4);
        updateWordCount('title_arabic', 'title_arabic_count', 4);
        updateWordCount('button_text_english', 'button_text_english_count', 2);
        updateWordCount('button_text_arabic', 'button_text_arabic_count', 2);
        
        // Apply character count validation
        updateCharCount('bio_english', 'bio_english_count', 500);
        updateCharCount('bio_arabic', 'bio_arabic_count', 500);
    });
</script>
@endsection

