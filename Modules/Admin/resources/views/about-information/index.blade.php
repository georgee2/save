@extends('admin::layouts.master')
@section('title', 'About Information')

@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<link rel="stylesheet" href="{{ asset('/css/tagify.css') }}">
<style>
    :root {
        --main-color: #19868b;
        --secondary-color: #0d6b6f;
        --accent-color: #e1273d;
    }
    .char-count {
        font-size: 12px;
        color: #6c757d;
        margin-top: 5px;
    }
    .char-count.error {
        color: #dc3545;
        font-weight: bold;
    }
    .word-count {
        font-size: 12px;
        color: #6c757d;
        margin-top: 5px;
    }
    .word-count.error {
        color: #dc3545;
        font-weight: bold;
    }
    .section-header {
        background: linear-gradient(135deg, var(--main-color) 0%, var(--secondary-color) 100%);
        color: white;
        padding: 15px 20px;
        border-radius: 8px 8px 0 0;
        margin: -20px -20px 20px -20px;
    }
    .form-section {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 20px;
        border-left: 4px solid var(--main-color);
    }
    .form-section h5 {
        color: var(--main-color);
        border-bottom: 2px solid var(--main-color);
        padding-bottom: 10px;
        margin-bottom: 20px;
    }
    .btn-primary {
        background-color: var(--main-color) !important;
        border-color: var(--main-color) !important;
    }
    .btn-primary:hover {
        background-color: var(--secondary-color) !important;
        border-color: var(--secondary-color) !important;
    }
    .remove-image-btn {
        transition: all 0.2s ease;
    }
    .remove-image-btn:hover {
        transform: scale(1.05);
    }
</style>
@endsection

@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Admin')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-info-circle"></i> About Information</a>
        </nav>

        <div class="col-lg-12">
            <hr>
            
            <div class="card">
                <div class="card-body">
                    <div class="section-header">
                        <h4 class="mt-0 mb-0"><i class="fa fa-info-circle"></i> About Information Management</h4>
                        <small>Manage your website about page content</small>
                    </div>
                    
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="fa fa-check-circle"></i> {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>
                    @endif
                    
                    <form action="{{ route('about-information.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Page Header Section -->
                        <div class="form-section">
                            <h5><i class="fa fa-header"></i> Page Header</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Title (English) <small>(Max 4 Words)</small></label>
                                        <input type="text" class="form-control word-counter" name="title_english" value="{{ old('title_english', $aboutInfo->title_english) }}" id="title_english" maxlength="255">
                                        <div class="word-count" id="title_english_count">0 / 4 words</div>
                                        @error('title_english')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Title (Arabic) <small>(Max 4 Words)</small></label>
                                        <input type="text" class="form-control word-counter" name="title_arabic" value="{{ old('title_arabic', $aboutInfo->title_arabic) }}" id="title_arabic" maxlength="255" dir="rtl">
                                        <div class="word-count" id="title_arabic_count">0 / 4 words</div>
                                        @error('title_arabic')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Subtitle (English) <small>(Max 8 Words)</small></label>
                                        <input type="text" class="form-control word-counter" name="subtitle_english" value="{{ old('subtitle_english', $aboutInfo->subtitle_english) }}" id="subtitle_english" maxlength="255">
                                        <div class="word-count" id="subtitle_english_count">0 / 8 words</div>
                                        @error('subtitle_english')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Subtitle (Arabic) <small>(Max 8 Words)</small></label>
                                        <input type="text" class="form-control word-counter" name="subtitle_arabic" value="{{ old('subtitle_arabic', $aboutInfo->subtitle_arabic) }}" id="subtitle_arabic" maxlength="255" dir="rtl">
                                        <div class="word-count" id="subtitle_arabic_count">0 / 8 words</div>
                                        @error('subtitle_arabic')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Page Cover Image <small>(1920x450)</small></label>
                                        <input accept="image/*" class="form-control dropify" type="file" name="page_cover_image" id="page_cover_image_input" data-default-file="{{ $aboutInfo->page_cover_image ? asset('storage' . $aboutInfo->page_cover_image) : '' }}">
                                        <small class="form-text text-muted">Will be converted to WebP format</small>
                                        @if($aboutInfo->page_cover_image)
                                        <button type="button" class="btn btn-danger btn-sm mt-2 remove-image-btn" data-field="page_cover_image" data-input-id="page_cover_image_input">
                                            <i class="fa fa-trash"></i> Remove Page Cover Image
                                        </button>
                                        @endif
                                        @error('page_cover_image')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- About Section -->
                        <div class="form-section">
                            <h5><i class="fa fa-file-text-o"></i> About Section</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>About (English) <small>(Max 2500 characters)</small></label>
                                        <textarea class="form-control char-counter" name="about_english" rows="8" maxlength="2500" id="about_english">{{ old('about_english', $aboutInfo->about_english) }}</textarea>
                                        <div class="char-count" id="about_english_count">0 / 2500 characters</div>
                                        @error('about_english')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>About (Arabic) <small>(Max 2500 characters)</small></label>
                                        <textarea class="form-control char-counter" name="about_arabic" rows="8" maxlength="2500" dir="rtl" id="about_arabic">{{ old('about_arabic', $aboutInfo->about_arabic) }}</textarea>
                                        <div class="char-count" id="about_arabic_count">0 / 2500 characters</div>
                                        @error('about_arabic')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>About Image <small>(850x795)</small></label>
                                        <input accept="image/*" class="form-control dropify" type="file" name="about_image" id="about_image_input" data-default-file="{{ $aboutInfo->about_image ? asset('storage' . $aboutInfo->about_image) : '' }}">
                                        <small class="form-text text-muted">Will be converted to WebP format</small>
                                        @if($aboutInfo->about_image)
                                        <button type="button" class="btn btn-danger btn-sm mt-2 remove-image-btn" data-field="about_image" data-input-id="about_image_input">
                                            <i class="fa fa-trash"></i> Remove About Image
                                        </button>
                                        @endif
                                        @error('about_image')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Mission Section -->
                        <div class="form-section">
                            <h5><i class="fa fa-bullseye"></i> Mission Section</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Mission (English) <small>(Max 2000 characters)</small></label>
                                        <textarea class="form-control char-counter" name="mission_english" rows="8" maxlength="2000" id="mission_english">{{ old('mission_english', $aboutInfo->mission_english) }}</textarea>
                                        <div class="char-count" id="mission_english_count">0 / 2000 characters</div>
                                        @error('mission_english')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Mission (Arabic) <small>(Max 2000 characters)</small></label>
                                        <textarea class="form-control char-counter" name="mission_arabic" rows="8" maxlength="2000" dir="rtl" id="mission_arabic">{{ old('mission_arabic', $aboutInfo->mission_arabic) }}</textarea>
                                        <div class="char-count" id="mission_arabic_count">0 / 2000 characters</div>
                                        @error('mission_arabic')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Mission Image <small>(880x900)</small></label>
                                        <input accept="image/*" class="form-control dropify" type="file" name="mission_image" id="mission_image_input" data-default-file="{{ $aboutInfo->mission_image ? asset('storage' . $aboutInfo->mission_image) : '' }}">
                                        <small class="form-text text-muted">Will be converted to WebP format</small>
                                        @if($aboutInfo->mission_image)
                                        <button type="button" class="btn btn-danger btn-sm mt-2 remove-image-btn" data-field="mission_image" data-input-id="mission_image_input">
                                            <i class="fa fa-trash"></i> Remove Mission Image
                                        </button>
                                        @endif
                                        @error('mission_image')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Vision Section -->
                        <div class="form-section">
                            <h5><i class="fa fa-eye"></i> Vision Section</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Vision (English) <small>(Max 2000 characters)</small></label>
                                        <textarea class="form-control char-counter" name="vision_english" rows="8" maxlength="2000" id="vision_english">{{ old('vision_english', $aboutInfo->vision_english) }}</textarea>
                                        <div class="char-count" id="vision_english_count">0 / 2000 characters</div>
                                        @error('vision_english')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Vision (Arabic) <small>(Max 2000 characters)</small></label>
                                        <textarea class="form-control char-counter" name="vision_arabic" rows="8" maxlength="2000" dir="rtl" id="vision_arabic">{{ old('vision_arabic', $aboutInfo->vision_arabic) }}</textarea>
                                        <div class="char-count" id="vision_arabic_count">0 / 2000 characters</div>
                                        @error('vision_arabic')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Vision Image <small>(880x900)</small></label>
                                        <input accept="image/*" class="form-control dropify" type="file" name="vision_image" id="vision_image_input" data-default-file="{{ $aboutInfo->vision_image ? asset('storage' . $aboutInfo->vision_image) : '' }}">
                                        <small class="form-text text-muted">Will be converted to WebP format</small>
                                        @if($aboutInfo->vision_image)
                                        <button type="button" class="btn btn-danger btn-sm mt-2 remove-image-btn" data-field="vision_image" data-input-id="vision_image_input">
                                            <i class="fa fa-trash"></i> Remove Vision Image
                                        </button>
                                        @endif
                                        @error('vision_image')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Values Section -->
                        <div class="form-section">
                            <h5><i class="fa fa-heart"></i> Values Section</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Values (English) <small>(Max 2000 characters)</small></label>
                                        <textarea class="form-control char-counter" name="values_english" rows="8" maxlength="2000" id="values_english">{{ old('values_english', $aboutInfo->values_english) }}</textarea>
                                        <div class="char-count" id="values_english_count">0 / 2000 characters</div>
                                        @error('values_english')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Values (Arabic) <small>(Max 2000 characters)</small></label>
                                        <textarea class="form-control char-counter" name="values_arabic" rows="8" maxlength="2000" dir="rtl" id="values_arabic">{{ old('values_arabic', $aboutInfo->values_arabic) }}</textarea>
                                        <div class="char-count" id="values_arabic_count">0 / 2000 characters</div>
                                        @error('values_arabic')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Values Image <small>(880x900)</small></label>
                                        <input accept="image/*" class="form-control dropify" type="file" name="values_image" id="values_image_input" data-default-file="{{ $aboutInfo->values_image ? asset('storage' . $aboutInfo->values_image) : '' }}">
                                        <small class="form-text text-muted">Will be converted to WebP format</small>
                                        @if($aboutInfo->values_image)
                                        <button type="button" class="btn btn-danger btn-sm mt-2 remove-image-btn" data-field="values_image" data-input-id="values_image_input">
                                            <i class="fa fa-trash"></i> Remove Values Image
                                        </button>
                                        @endif
                                        @error('values_image')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Values Points (English) <small><span class="text-danger">Press Enter after each point</span></small></label>
                                        <input type="text" class="tagify-values-en form-control" name="values_points_english" value="{{ old('values_points_english', $aboutInfo->values_points_english) }}" placeholder="Add value points...">
                                        @error('values_points_english')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Values Points (Arabic) <small><span class="text-danger">Press Enter after each point</span></small></label>
                                        <input type="text" class="tagify-values-ar form-control" name="values_points_arabic" value="{{ old('values_points_arabic', $aboutInfo->values_points_arabic) }}" placeholder="أضف نقاط القيم..." dir="rtl">
                                        @error('values_points_arabic')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Company Profile Section -->
                        <div class="form-section">
                            <h5><i class="fa fa-file-pdf-o"></i> Company Profile</h5>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Company Profile PDF <small>(Max 15 MB)</small></label>
                                        <input accept=".pdf,application/pdf" class="form-control dropify" type="file" name="company_profile" id="company_profile_input" data-allowed-file-extensions="pdf" data-max-file-size="15M">
                                        @if($aboutInfo->company_profile)
                                            <div class="mt-3 p-3 company-profile-preview" style="background: #f8f9fa; border-radius: 8px; border: 1px solid #e9ecef;">
                                                <div class="d-flex align-items-center">
                                                    <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-right: 15px;">
                                                        <i class="fa fa-file-pdf-o text-white" style="font-size: 24px;"></i>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <strong>Current Company Profile</strong>
                                                        <br>
                                                        <small class="text-muted">PDF Document</small>
                                                    </div>
                                                    <div>
                                                        <a href="{{ asset('storage' . $aboutInfo->company_profile) }}" target="_blank" class="btn btn-sm btn-outline-primary mr-2">
                                                            <i class="fa fa-eye"></i> View
                                                        </a>
                                                        <a href="{{ asset('storage' . $aboutInfo->company_profile) }}" download class="btn btn-sm btn-outline-success mr-2">
                                                            <i class="fa fa-download"></i> Download
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-danger remove-image-btn" data-field="company_profile" data-input-id="company_profile_input">
                                                            <i class="fa fa-trash"></i> Remove
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        <small class="form-text text-muted">Upload your company profile in PDF format. Maximum file size: 15 MB</small>
                                        @error('company_profile')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fa fa-save"></i> Save About Information
                            </button>
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
<script src="{{ asset('/js/tagify.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        // Initialize Dropify
        $('.dropify').dropify();
        
        // Word count function
        function countWords(str) {
            return str.trim() === '' ? 0 : str.trim().split(/\s+/).length;
        }
        
        // Word counter
        function updateWordCount(inputId, countId, maxWords) {
            const input = document.getElementById(inputId);
            const countDiv = document.getElementById(countId);
            
            if (input && countDiv) {
                function update() {
                    const wordCount = countWords(input.value);
                    countDiv.textContent = `${wordCount} / ${maxWords} words`;
                    
                    if (wordCount > maxWords) {
                        countDiv.classList.add('error');
                    } else {
                        countDiv.classList.remove('error');
                    }
                }
                
                update();
                input.addEventListener('input', update);
            }
        }
        
        // Character counter
        function updateCharCount(inputId, countId, maxChars) {
            const input = document.getElementById(inputId);
            const countDiv = document.getElementById(countId);
            
            if (input && countDiv) {
                function update() {
                    const charCount = input.value.length;
                    countDiv.textContent = `${charCount} / ${maxChars} characters`;
                    
                    if (charCount > maxChars) {
                        countDiv.classList.add('error');
                    } else {
                        countDiv.classList.remove('error');
                    }
                }
                
                update();
                input.addEventListener('input', update);
            }
        }
        
        // Initialize Tagify for values points
        if (document.querySelector('.tagify-values-en')) {
            new Tagify(document.querySelector('.tagify-values-en'), { delimiters: "\n", maxTags: 30, dropdown: { enabled: 0 } });
        }
        if (document.querySelector('.tagify-values-ar')) {
            new Tagify(document.querySelector('.tagify-values-ar'), { delimiters: "\n", maxTags: 30, dropdown: { enabled: 0 } });
        }
        
        // Apply word counters
        updateWordCount('title_english', 'title_english_count', 4);
        updateWordCount('title_arabic', 'title_arabic_count', 4);
        updateWordCount('subtitle_english', 'subtitle_english_count', 8);
        updateWordCount('subtitle_arabic', 'subtitle_arabic_count', 8);
        
        // Apply character counters
        updateCharCount('about_english', 'about_english_count', 2500);
        updateCharCount('about_arabic', 'about_arabic_count', 2500);
        updateCharCount('mission_english', 'mission_english_count', 2000);
        updateCharCount('mission_arabic', 'mission_arabic_count', 2000);
        updateCharCount('vision_english', 'vision_english_count', 2000);
        updateCharCount('vision_arabic', 'vision_arabic_count', 2000);
        updateCharCount('values_english', 'values_english_count', 2000);
        updateCharCount('values_arabic', 'values_arabic_count', 2000);
        
        // Remove image functionality
        $('.remove-image-btn').on('click', function() {
            const btn = $(this);
            const field = btn.data('field');
            const inputId = btn.data('input-id');
            
            Swal.fire({
                title: 'Are you sure?',
                text: 'This will permanently remove the image/file. This action cannot be undone!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, remove it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading
                    Swal.fire({
                        title: 'Removing...',
                        text: 'Please wait',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    // Send AJAX request
                    $.ajax({
                        url: '{{ route("about-information.remove-image") }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            field: field
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Removed!',
                                    text: response.message,
                                    timer: 1500,
                                    showConfirmButton: false
                                }).then(() => {
                                    // Reset the dropify input
                                    const dropifyInput = $('#' + inputId);
                                    if (dropifyInput.length) {
                                        const dropifyInstance = dropifyInput.data('dropify');
                                        if (dropifyInstance) {
                                            dropifyInstance.resetPreview();
                                            dropifyInstance.clearElement();
                                        }
                                    }
                                    
                                    // Hide the remove button
                                    btn.fadeOut(300, function() {
                                        $(this).remove();
                                    });
                                    
                                    // If it's company profile, also remove the preview box
                                    if (field === 'company_profile') {
                                        btn.closest('.company-profile-preview').fadeOut(300, function() {
                                            $(this).remove();
                                        });
                                    }
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: response.message
                                });
                            }
                        },
                        error: function(xhr) {
                            let errorMessage = 'Failed to remove the file. Please try again.';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            }
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: errorMessage
                            });
                        }
                    });
                }
            });
        });
    });
</script>
@endsection

