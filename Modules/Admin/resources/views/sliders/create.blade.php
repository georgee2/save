@extends('admin::layouts.master')
@section('title', 'Create Slider')

@section('css')
<link rel="stylesheet" href="{{ asset('/css/auto-translate.css') }}">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
    .slider-type-section {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
    }
    .slider-type-btn {
        padding: 15px 25px;
        border: 2px solid #dee2e6;
        border-radius: 8px;
        background: #fff;
        cursor: pointer;
        transition: all 0.3s ease;
        text-align: center;
        margin: 5px;
        flex: 1;
    }
    .slider-type-btn:hover {
        border-color: #007bff;
    }
    .slider-type-btn.active {
        border-color: #007bff;
        background: #e7f1ff;
    }
    .slider-type-btn i {
        font-size: 24px;
        display: block;
        margin-bottom: 8px;
    }
    .slider-type-btn.type-default i { color: #007bff; }
    .slider-type-btn.type-project i { color: #28a745; }
    .slider-type-btn.type-offer i { color: #ffc107; }
    .type-section {
        display: none;
    }
    .type-section.active {
        display: block;
    }
    .select2-container--default .select2-selection--single {
        height: 38px;
        padding: 5px;
        border: 1px solid #ced4da;
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
                        
                        <div class="mb-3 text-right">
                            <button type="button" class="translate-all-btn"><i class="fa fa-language"></i> Translate All to Arabic</button>
                        </div>
                        
                        {{-- Slider Type Selection --}}
                        <div class="slider-type-section">
                            <label class="mb-3"><strong>Slider Type</strong> <i class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                            <div class="d-flex flex-wrap">
                                <div class="slider-type-btn type-default active" data-type="default">
                                    <i class="fa fa-image"></i>
                                    <strong>Default</strong>
                                    <small class="d-block text-muted">Custom content with image</small>
                                </div>
                                <div class="slider-type-btn type-project" data-type="project">
                                    <i class="fa fa-building"></i>
                                    <strong>Project</strong>
                                    <small class="d-block text-muted">Display project with card</small>
                                </div>
                                <div class="slider-type-btn type-offer" data-type="offer">
                                    <i class="fa fa-tags"></i>
                                    <strong>Offer</strong>
                                    <small class="d-block text-muted">Display offer with card</small>
                                </div>
                            </div>
                            <input type="hidden" name="slider_type" id="slider_type" value="default">
                        </div>
                        
                        {{-- Project Selection (for project type) --}}
                        <div class="type-section project-section" id="project-section">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Select Project <i class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                        <select class="form-control select2" name="project_id" id="project_id">
                                            <option value="">-- Select Project --</option>
                                            @foreach($projects as $project)
                                            <option value="{{ $project->id }}" 
                                                    data-image="{{ asset('storage' . $project->main_image) }}"
                                                    {{ old('project_id') == $project->id ? 'selected' : '' }}>
                                                {{ $project->title_english }} - {{ $project->title_arabic }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <small class="form-text text-muted">The project's cover image will be used as slider background. Project details will be shown in a card overlay.</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        {{-- Offer Selection (for offer type) --}}
                        <div class="type-section offer-section" id="offer-section">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Select Offer <i class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                        <select class="form-control select2" name="offer_id" id="offer_id">
                                            <option value="">-- Select Offer --</option>
                                            @foreach($offers as $offer)
                                            <option value="{{ $offer->id }}" 
                                                    data-image="{{ asset('storage' . $offer->main_image) }}"
                                                    {{ old('offer_id') == $offer->id ? 'selected' : '' }}>
                                                {{ $offer->title_english }} - {{ $offer->title_arabic }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <small class="form-text text-muted">The offer's cover image will be used as slider background. Offer details will be shown in a card overlay.</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        {{-- Default Content Section --}}
                        <div class="type-section default-section active" id="default-section">
                            <div class="row">
                                <!-- English Title -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>English Title <i class="mdi mdi-18px mdi-alert-octagon text-danger"></i> <small>(Max 4 Words)</small></label>
                                        <input type="text" class="form-control" name="title_english" value="{{ old('title_english') }}" maxlength="255" id="title_english">
                                        <div class="word-count" id="title_english_count">0 / 4 words</div>
                                    </div>
                                </div>
                                
                                <!-- Arabic Title -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Arabic Title <button type="button" class="auto-translate-btn" data-translate-source="title_english" data-translate-target="title_arabic"><i class="fa fa-language"></i> Auto</button> <i class="mdi mdi-18px mdi-alert-octagon text-danger"></i> <small>(Max 4 Words)</small></label>
                                        <input type="text" class="form-control" name="title_arabic" value="{{ old('title_arabic') }}" maxlength="255" dir="rtl" id="title_arabic">
                                        <div class="word-count" id="title_arabic_count">0 / 4 words</div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <!-- English Bio -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>English Bio <i class="mdi mdi-18px mdi-alert-octagon text-danger"></i> <small>(Max 500 characters)</small></label>
                                        <textarea class="form-control" name="bio_english" rows="5" maxlength="500" id="bio_english">{{ old('bio_english') }}</textarea>
                                        <div class="word-count" id="bio_english_count">0 / 500 characters</div>
                                    </div>
                                </div>
                                
                                <!-- Arabic Bio -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Arabic Bio <button type="button" class="auto-translate-btn" data-translate-source="bio_english" data-translate-target="bio_arabic"><i class="fa fa-language"></i> Auto</button> <i class="mdi mdi-18px mdi-alert-octagon text-danger"></i> <small>(Max 500 characters)</small></label>
                                        <textarea class="form-control" name="bio_arabic" rows="5" maxlength="500" dir="rtl" id="bio_arabic">{{ old('bio_arabic') }}</textarea>
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
                                        <label>Button Text (Arabic) <button type="button" class="auto-translate-btn" data-translate-source="button_text_english" data-translate-target="button_text_arabic"><i class="fa fa-language"></i> Auto</button> <small>(Optional, Max 2 Words)</small></label>
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
                        </div>
                        
                        {{-- Common Fields --}}
                        <div class="row">
                            <!-- Image Upload -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Slider Image <span id="image-required"><i class="mdi mdi-18px mdi-alert-octagon text-danger"></i></span> <small>(Will be converted to WebP 1890x883 - Quality 80%)</small></label>
                                    <input accept="image/*" class="form-control dropify" type="file" name="image" id="slider_image">
                                    <small class="form-text text-muted" id="image-help">Max size: 5MB. Will be converted to WebP 1890x883px</small>
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
<script src="{{ asset('/js/auto-translate.js') }}"></script>
<script src="{{ asset('/js/dropify.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        // Initialize Dropify
        var drEvent = $('.dropify').dropify();
        
        // Initialize Select2
        $('.select2').select2({
            placeholder: 'Select an option',
            allowClear: true
        });
        
        // Slider Type Selection
        $('.slider-type-btn').on('click', function() {
            var type = $(this).data('type');
            
            // Update active state
            $('.slider-type-btn').removeClass('active');
            $(this).addClass('active');
            
            // Update hidden input
            $('#slider_type').val(type);
            
            // Show/hide sections
            $('.type-section').removeClass('active');
            $('#' + type + '-section').addClass('active');
            
            // Update image field requirements
            if (type === 'default') {
                $('#image-required').html('<i class="mdi mdi-18px mdi-alert-octagon text-danger"></i>');
                $('#image-help').text('Max size: 5MB. Will be converted to WebP 1890x883px');
            } else {
                $('#image-required').html('<small class="text-muted">(Optional - uses cover image if empty)</small>');
                $('#image-help').text('Leave empty to use the ' + type + ' cover image automatically. Or upload a custom image.');
            }
        });
        
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
