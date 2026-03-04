@extends('admin::layouts.master')
@section('title', 'Edit Fact')

@section('css')
<link rel="stylesheet" href="{{ asset('/css/auto-translate.css') }}">
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
    .icon-preview {
        max-width: 100px;
        max-height: 100px;
        margin-top: 10px;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
    }
</style>
@endsection

@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Admin')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a href="{{route('admin.facts.index')}}" class="breadcrumbs__item"><i class="fa fa-chart-line"></i> Facts</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-edit"></i> Edit Fact</a>
        </nav>

        <div class="col-lg-12">
            <hr>
            
            <div class="card">
                <div class="card-body">
                    <h4 class="mt-0 header-title"><i class="fa fa-edit"></i> Edit Fact</h4>
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
                    
                    <form action="{{ route('admin.facts.update', ['id' => $fact->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3 text-right">
                            <button type="button" class="translate-all-btn"><i class="fa fa-language"></i> Translate All to Arabic</button>
                        </div>
                        
                        <div class="row">
                            <!-- English Title -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>English Title <i class="mdi mdi-18px mdi-alert-octagon text-danger"></i> <small>(Max 3 Words)</small></label>
                                    <input type="text" class="form-control" name="title_english" value="{{ old('title_english', $fact->title_english) }}" required maxlength="100" id="title_english">
                                    <div class="word-count" id="title_english_count">0 / 3 words</div>
                                </div>
                            </div>
                            
                            <!-- Arabic Title -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Arabic Title <button type="button" class="auto-translate-btn" data-translate-source="title_english" data-translate-target="title_arabic"><i class="fa fa-language"></i> Auto</button> <i class="mdi mdi-18px mdi-alert-octagon text-danger"></i> <small>(Max 3 Words)</small></label>
                                    <input type="text" class="form-control" name="title_arabic" value="{{ old('title_arabic', $fact->title_arabic) }}" required maxlength="100" dir="rtl" id="title_arabic">
                                    <div class="word-count" id="title_arabic_count">0 / 3 words</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <!-- Fact Number -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Fact Number <i class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                    <input type="text" class="form-control" name="fact_number" value="{{ old('fact_number', $fact->fact_number) }}" required maxlength="50" placeholder="e.g., 500+, 1000+, 99%">
                                    <small class="form-text text-muted">Enter the fact number (e.g., 500+, 1000+, 99%)</small>
                                </div>
                            </div>
                            
                            <!-- Icon Upload -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Icon <small>(Optional - Leave empty to keep current icon)</small></label>
                                    <input accept="image/*" class="form-control" type="file" name="icon" id="icon_input">
                                    <small class="form-text text-muted">Max size: 2MB. Will be converted to WebP 100x100px</small>
                                    
                                    <!-- Current Icon -->
                                    @if($fact->icon)
                                        <div class="mt-2">
                                            <label>Current Icon:</label><br>
                                            <img src="{{ asset('storage' . $fact->icon) }}" class="icon-preview" alt="Current Icon">
                                        </div>
                                    @endif
                                    
                                    <!-- New Icon Preview -->
                                    <img id="icon_preview" class="icon-preview" src="" alt="New Icon Preview" style="display:none;">
                                    @error('icon')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <!-- Ordering -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Ordering <i class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                    <input type="number" class="form-control" name="ordering" value="{{ old('ordering', $fact->ordering) }}" required min="0">
                                    <small class="form-text text-muted">Lower numbers appear first</small>
                                </div>
                            </div>
                            
                            <!-- Status -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Status <i class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                    <select class="form-control" name="status" required>
                                        <option value="0" {{ old('status', $fact->status) == '0' ? 'selected' : '' }}>Active</option>
                                        <option value="1" {{ old('status', $fact->status) == '1' ? 'selected' : '' }}>Not Active</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-save"></i> Update Fact
                            </button>
                            <a href="{{ route('admin.facts.index') }}" class="btn btn-secondary">
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
<script>
    $(document).ready(function() {
        // Initialize word counts
        updateWordCount('#title_english', '#title_english_count', 3);
        updateWordCount('#title_arabic', '#title_arabic_count', 3);
        
        // Word count for English Title (Max 3 words)
        $('#title_english').on('input', function() {
            updateWordCount('#title_english', '#title_english_count', 3);
        });
        
        // Word count for Arabic Title (Max 3 words)
        $('#title_arabic').on('input', function() {
            updateWordCount('#title_arabic', '#title_arabic_count', 3);
        });
        
        function updateWordCount(inputSelector, countSelector, maxWords) {
            const text = $(inputSelector).val().trim();
            const wordCount = text === '' ? 0 : text.split(/\s+/).length;
            const countDisplay = $(countSelector);
            
            countDisplay.text(wordCount + ' / ' + maxWords + ' words');
            
            if (wordCount > maxWords) {
                countDisplay.addClass('error');
            } else {
                countDisplay.removeClass('error');
            }
        }
        
        // Icon preview
        $('#icon_input').on('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#icon_preview').attr('src', e.target.result).show();
                }
                reader.readAsDataURL(file);
            } else {
                $('#icon_preview').hide();
            }
        });
        
        // Form validation before submit
        $('form').on('submit', function(e) {
            const englishTitle = $('#title_english').val().trim();
            const arabicTitle = $('#title_arabic').val().trim();
            
            const englishWordCount = englishTitle === '' ? 0 : englishTitle.split(/\s+/).length;
            const arabicWordCount = arabicTitle === '' ? 0 : arabicTitle.split(/\s+/).length;
            
            if (englishWordCount > 3) {
                e.preventDefault();
                alert('English title must not exceed 3 words!');
                $('#title_english').focus();
                return false;
            }
            
            if (arabicWordCount > 3) {
                e.preventDefault();
                alert('Arabic title must not exceed 3 words!');
                $('#title_arabic').focus();
                return false;
            }
        });
    });
</script>
@endsection

