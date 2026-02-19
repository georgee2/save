@extends('admin::layouts.master')
@section('title', 'Edit Certificate')
@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Admin')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a href="{{route('certificate.index')}}" class="breadcrumbs__item"><i class="fa fa-certificate"></i> Certificates List</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-pencil"></i> Edit Certificate</a> 
        </nav>

        <div class="col-lg-12">
            <hr>
            
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert" style="border-left: 4px solid #28a745; font-size: 16px; padding: 15px 20px;">
                    <i class="fa fa-check-circle" style="font-size: 20px;"></i> <strong>Success!</strong> {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert" style="border-left: 4px solid #dc3545; font-size: 16px; padding: 15px 20px;">
                    <i class="fa fa-exclamation-circle" style="font-size: 20px;"></i> <strong>Error!</strong>
                    <ul class="mb-0" style="margin-top: 10px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="mt-0 header-title align-self-center">Edit Certificate: {{ $certificate->name_english }}</h4>
                        <div class="buttons">
                            <a href="{{ route('certificate.index') }}">
                                <button class="btn btn-primary"><i class="fa fa-angle-left"></i> Back to List</button>
                            </a>
                        </div>
                    </div>
                    <hr>
                    
                    <form action="{{ route('certificate.update', ['id' => $certificate->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <!-- Name English -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name_english">Name (English) <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name_english') is-invalid @enderror" 
                                           id="name_english" name="name_english" 
                                           value="{{ old('name_english', $certificate->name_english) }}" 
                                           placeholder="Enter certificate name in English" required>
                                    @error('name_english')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- Name Arabic -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name_arabic">Name (Arabic) <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name_arabic') is-invalid @enderror" 
                                           id="name_arabic" name="name_arabic" 
                                           value="{{ old('name_arabic', $certificate->name_arabic) }}" 
                                           placeholder="أدخل اسم الشهادة بالعربية" dir="rtl" required>
                                    @error('name_arabic')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <!-- Bio English -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="bio_english">Bio (English) <small class="text-muted">(Max 300 characters)</small></label>
                                    <textarea class="form-control @error('bio_english') is-invalid @enderror" 
                                              id="bio_english" name="bio_english" rows="3" 
                                              placeholder="Enter a short description in English" maxlength="300">{{ old('bio_english', $certificate->bio_english) }}</textarea>
                                    <small class="text-muted"><span id="bio_english_count">0</span>/300 characters</small>
                                    @error('bio_english')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- Bio Arabic -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="bio_arabic">Bio (Arabic) <small class="text-muted">(Max 300 characters)</small></label>
                                    <textarea class="form-control @error('bio_arabic') is-invalid @enderror" 
                                              id="bio_arabic" name="bio_arabic" rows="3" 
                                              placeholder="أدخل وصفًا قصيرًا بالعربية" dir="rtl" maxlength="300">{{ old('bio_arabic', $certificate->bio_arabic) }}</textarea>
                                    <small class="text-muted"><span id="bio_arabic_count">0</span>/300 characters</small>
                                    @error('bio_arabic')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <!-- Image -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="image">Certificate Image</label>
                                    <div class="alert alert-info py-2 mb-2">
                                        <i class="fa fa-info-circle mr-1"></i>
                                        <strong>Recommended:</strong> Square image (1:1 ratio) - Image will be resized to 400x400px
                                    </div>
                                    <input type="file" class="dropify @error('image') is-invalid @enderror" 
                                           id="image" name="image" accept="image/*"
                                           data-default-file="{{ $certificate->image ? url('/storage'.$certificate->image) : '' }}"
                                           data-max-file-size="5M"
                                           data-allowed-file-extensions="jpg jpeg png gif webp"
                                           data-show-remove="true"
                                           data-height="250">
                                    <small class="text-muted d-block mt-1">Leave empty to keep current image.</small>
                                    @error('image')
                                        <span class="text-danger d-block mt-1"><small>{{ $message }}</small></span>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- Ordering -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="ordering">Display Order</label>
                                    <input type="number" class="form-control @error('ordering') is-invalid @enderror" 
                                           id="ordering" name="ordering" 
                                           value="{{ old('ordering', $certificate->ordering) }}" min="0">
                                    @error('ordering')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- Publish Status -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="publish_status">Publish Status <span class="text-danger">*</span></label>
                                    <select class="form-control @error('publish_status') is-invalid @enderror" 
                                            id="publish_status" name="publish_status" required>
                                        <option value="0" {{ old('publish_status', $certificate->publish_status) == '0' ? 'selected' : '' }}>Not Published</option>
                                        <option value="1" {{ old('publish_status', $certificate->publish_status) == '1' ? 'selected' : '' }}>Published</option>
                                    </select>
                                    @error('publish_status')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-save"></i> Update Certificate
                            </button>
                            <a href="{{ route('certificate.index') }}" class="btn btn-secondary ml-2">
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

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css">
<style>
    .dropify-wrapper {
        border: 2px dashed #e0e0e0;
        border-radius: 12px;
        background: #fafafa;
    }
    .dropify-wrapper:hover {
        border-color: #19868b;
        background: #f5fafa;
    }
    .dropify-wrapper .dropify-message span.file-icon {
        font-size: 50px;
        color: #19868b;
    }
    .dropify-wrapper .dropify-message p {
        font-size: 14px;
        color: #666;
    }
    .dropify-wrapper .dropify-preview .dropify-render img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }
</style>
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>
<script>
$(document).ready(function() {
    // Initialize Dropify
    $('.dropify').dropify({
        messages: {
            'default': 'Drag and drop a file here or click<br><small>Image will be resized to 400x400px</small>',
            'replace': 'Drag and drop or click to replace',
            'remove':  'Remove',
            'error':   'Oops, something went wrong.'
        },
        error: {
            'fileSize': 'The file size is too big (max 5MB).',
            'minWidth': 'The image width is too small.',
            'maxWidth': 'The image width is too big.',
            'minHeight': 'The image height is too small.',
            'maxHeight': 'The image height is too big.',
            'imageFormat': 'The image format is not allowed (only jpg, jpeg, png, gif, webp).',
            'fileExtension': 'The file extension is not allowed (only jpg, jpeg, png, gif, webp).'
        }
    });
    
    // Character count for bio fields
    $('#bio_english').on('input', function() {
        $('#bio_english_count').text($(this).val().length);
    });
    
    $('#bio_arabic').on('input', function() {
        $('#bio_arabic_count').text($(this).val().length);
    });
    
    // Initialize counts
    $('#bio_english_count').text($('#bio_english').val().length);
    $('#bio_arabic_count').text($('#bio_arabic').val().length);
});
</script>
@endsection
