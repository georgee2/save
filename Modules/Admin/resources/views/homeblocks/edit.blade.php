@extends('admin::layouts.master')
@section('title', 'Edit Home Block')
@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Admin')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a href="{{route('homeblock.index')}}" class="breadcrumbs__item"><i class="fa fa-th-large"></i> Home Blocks List</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-pencil"></i> Edit Home Block</a> 
        </nav>

        <div class="col-12 mx-auto">
            <hr>
            
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
            
            <div class="card m-b-20">
                <div class="card-body">
                    <div class="title d-flex justify-content-between">
                        <h4 class="mt-0 mb-0 header-title align-self-center text-capitalize">Edit Home Block</h4>
                        <div class="buttons">
                            <a href="{{ route('homeblock.index') }}" class="mr-2">
                                <button class="btn btn-new"><i class="fa fa-list"></i> Home Blocks List</button>
                            </a>
                            <button class="btn btn-primary" onclick="window.history.back()">
                                <i class="fa fa-angle-left"></i> Back
                            </button>
                        </div>
                    </div>
                    <hr>
                    
                    <form action="{{ route('homeblock.update', ['id' => $homeBlock->id]) }}" method="POST">
                        @csrf
                        
                        <!-- Title Information -->
                        <h5 class="mb-3 text-primary">Title Information</h5>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">English Title <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i> <small class="text-muted">(Max 4 words)</small></label>
                                <input class="form-control" value="{{old('title_english', $homeBlock->title_english)}}" type="text" name="title_english" maxlength="100" required>
                                <small class="text-muted">Character count: <span id="title_en_count">0</span>/100</small>
                                @error('title_english')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Arabic Title <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i> <small class="text-muted">(Max 4 words)</small></label>
                                <input class="form-control" value="{{old('title_arabic', $homeBlock->title_arabic)}}" type="text" name="title_arabic" maxlength="100" required>
                                <small class="text-muted">Character count: <span id="title_ar_count">0</span>/100</small>
                                @error('title_arabic')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <!-- Subtitle Information -->
                        <h5 class="mb-3 mt-4 text-primary">Subtitle Information</h5>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">English Subtitle <small class="text-muted">(Max 3 words - Optional)</small></label>
                                <input class="form-control" value="{{old('subtitle_english', $homeBlock->subtitle_english)}}" type="text" name="subtitle_english" maxlength="75">
                                <small class="text-muted">Character count: <span id="subtitle_en_count">0</span>/75</small>
                                @error('subtitle_english')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Arabic Subtitle <small class="text-muted">(Max 3 words - Optional)</small></label>
                                <input class="form-control" value="{{old('subtitle_arabic', $homeBlock->subtitle_arabic)}}" type="text" name="subtitle_arabic" maxlength="75">
                                <small class="text-muted">Character count: <span id="subtitle_ar_count">0</span>/75</small>
                                @error('subtitle_arabic')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <!-- Button Information -->
                        <h5 class="mb-3 mt-4 text-primary">Button Information</h5>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Button Text (English) <small class="text-muted">(Max 2 words - Optional)</small></label>
                                <input class="form-control" value="{{old('button_text_english', $homeBlock->button_text_english)}}" type="text" name="button_text_english" maxlength="50">
                                <small class="text-muted">Character count: <span id="btn_en_count">0</span>/50</small>
                                @error('button_text_english')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Button Text (Arabic) <small class="text-muted">(Max 2 words - Optional)</small></label>
                                <input class="form-control" value="{{old('button_text_arabic', $homeBlock->button_text_arabic)}}" type="text" name="button_text_arabic" maxlength="50">
                                <small class="text-muted">Character count: <span id="btn_ar_count">0</span>/50</small>
                                @error('button_text_arabic')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <!-- URL Information -->
                        <h5 class="mb-3 mt-4 text-primary">URL Information</h5>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">URL (English) <small class="text-muted">(Optional)</small></label>
                                <input class="form-control" value="{{old('url_english', $homeBlock->url_english)}}" type="text" name="url_english" placeholder="https://example.com">
                                @error('url_english')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">URL (Arabic) <small class="text-muted">(Optional)</small></label>
                                <input class="form-control" value="{{old('url_arabic', $homeBlock->url_arabic)}}" type="text" name="url_arabic" placeholder="https://example.com">
                                @error('url_arabic')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <!-- Location & Status -->
                        <h5 class="mb-3 mt-4 text-primary">Display Settings</h5>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Location <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <select class="form-control" name="location" required>
                                    <option value="">Select Location</option>
                                    <option value="about_section" {{ old('location', $homeBlock->location) == 'about_section' ? 'selected' : '' }}>About Section</option>
                                    <option value="why_choose_us" {{ old('location', $homeBlock->location) == 'why_choose_us' ? 'selected' : '' }}>Why Choose Us</option>
                                </select>
                                @error('location')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Status <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <select class="form-control" name="status" required>
                                    <option value="0" {{ old('status', $homeBlock->status) == '0' ? 'selected' : '' }}>Active</option>
                                    <option value="1" {{ old('status', $homeBlock->status) == '1' ? 'selected' : '' }}>Not Active</option>
                                </select>
                                @error('status')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <hr>
                        <div class="form-group mb-0">
                            <div>
                                <button type="submit" class="btn btn-dark waves-effect waves-light mr-2">
                                    <i class="fa fa-save"></i> Update
                                </button>
                                <button type="reset" class="btn btn-primary waves-effect m-l-5" onclick="window.history.back()">
                                    <i class="fa fa-times"></i> Cancel
                                </button>
                            </div>
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
    // Character counters
    document.addEventListener('DOMContentLoaded', function() {
        const fields = [
            { input: 'input[name="title_english"]', counter: 'title_en_count' },
            { input: 'input[name="title_arabic"]', counter: 'title_ar_count' },
            { input: 'input[name="subtitle_english"]', counter: 'subtitle_en_count' },
            { input: 'input[name="subtitle_arabic"]', counter: 'subtitle_ar_count' },
            { input: 'input[name="button_text_english"]', counter: 'btn_en_count' },
            { input: 'input[name="button_text_arabic"]', counter: 'btn_ar_count' }
        ];

        fields.forEach(field => {
            const inputElement = document.querySelector(field.input);
            const counterElement = document.getElementById(field.counter);
            
            if (inputElement && counterElement) {
                // Initial count
                counterElement.textContent = inputElement.value.length;
                
                // Update on input
                inputElement.addEventListener('input', function() {
                    counterElement.textContent = this.value.length;
                });
            }
        });
    });
</script>
@endsection

