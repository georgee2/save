@extends('admin::layouts.master')
@section('title', 'Edit About Custom Block')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('/css/dropify.min.css') }}">
<style>
    .char-count {
        font-size: 12px;
        color: #6c757d;
        margin-top: 5px;
    }
    .char-count.error {
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
            <a href="{{route('about-custom-block.index')}}" class="breadcrumbs__item"><i class="fa fa-th-large"></i> About Custom Blocks</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-pencil"></i> Edit Block</a>
        </nav>

        <div class="col-lg-12">
            <hr>
            
            <div class="card">
                <div class="card-body">
                    <h4 class="mt-0 header-title"><i class="fa fa-pencil"></i> Edit About Custom Block</h4>
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
                    
                    <form action="{{ route('about-custom-block.update', ['id' => $block->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Title (English) <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="title_english" value="{{ old('title_english', $block->title_english) }}" required maxlength="255">
                                    @error('title_english')<span class="text-danger">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Title (Arabic) <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="title_arabic" value="{{ old('title_arabic', $block->title_arabic) }}" required maxlength="255" dir="rtl">
                                    @error('title_arabic')<span class="text-danger">{{ $message }}</span>@enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Description (English) <span class="text-danger">*</span> <small>(Max 2000 characters)</small></label>
                                    <textarea class="form-control" name="description_english" rows="8" required maxlength="2000" id="description_english">{{ old('description_english', $block->description_english) }}</textarea>
                                    <div class="char-count" id="description_english_count">0 / 2000 characters</div>
                                    @error('description_english')<span class="text-danger">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Description (Arabic) <span class="text-danger">*</span> <small>(Max 2000 characters)</small></label>
                                    <textarea class="form-control" name="description_arabic" rows="8" required maxlength="2000" dir="rtl" id="description_arabic">{{ old('description_arabic', $block->description_arabic) }}</textarea>
                                    <div class="char-count" id="description_arabic_count">0 / 2000 characters</div>
                                    @error('description_arabic')<span class="text-danger">{{ $message }}</span>@enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Image <small>(960x733 - Leave empty to keep current)</small></label>
                                    <input accept="image/*" class="form-control dropify" type="file" name="image" data-default-file="{{ $block->image ? asset('storage' . $block->image) : '' }}">
                                    <small class="form-text text-muted">Will be converted to WebP format (960x733)</small>
                                    @error('image')<span class="text-danger">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Status <span class="text-danger">*</span></label>
                                    <select class="form-control" name="status" required>
                                        <option value="0" {{ old('status', $block->status) == '0' ? 'selected' : '' }}>Active</option>
                                        <option value="1" {{ old('status', $block->status) == '1' ? 'selected' : '' }}>Not Active</option>
                                    </select>
                                    @error('status')<span class="text-danger">{{ $message }}</span>@enderror
                                </div>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <div class="form-group text-center">
                            <a href="{{ route('about-custom-block.index') }}" class="btn btn-secondary">
                                <i class="fa fa-times"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-warning">
                                <i class="fa fa-save"></i> Update Block
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

<script>
    $(document).ready(function() {
        // Initialize Dropify
        $('.dropify').dropify();
        
        // Character counter function
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
        
        // Apply character counters
        updateCharCount('description_english', 'description_english_count', 2000);
        updateCharCount('description_arabic', 'description_arabic_count', 2000);
    });
</script>
@endsection

