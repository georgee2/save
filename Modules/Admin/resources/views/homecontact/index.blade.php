@extends('admin::layouts.master')
@section('title', 'Home Contact Section')
@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Admin')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-phone"></i> Home Contact Section</a> 
        </nav>

        <div class="col-12 mx-auto">
            <hr>
            
            <!-- Success/Error Messages -->
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
            
            <div class="card m-b-20">
                <div class="card-body">
                    <div class="title d-flex justify-content-between">
                        <h4 class="mt-0 mb-0 header-title align-self-center text-capitalize">Home Contact Section</h4>
                        <div class="buttons">
                            <button class="btn btn-primary" onclick="window.history.back()">
                                <i class="fa fa-angle-left"></i> Back
                            </button>
                        </div>
                    </div>
                    <hr>
                    
                    <form enctype="multipart/form-data" action="{{ route('homecontact.update') }}" method="POST">
                        @csrf
                        
                        <!-- Title Information -->
                        <h5 class="mb-3 text-primary">Title Information</h5>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">English Title <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i> <small class="text-muted">(Max 5 words)</small></label>
                                <input class="form-control" value="{{old('title_english', $homeContact->title_english ?? '')}}" type="text" name="title_english" maxlength="125" required>
                                <small class="text-muted">Character count: <span id="title_en_count">0</span>/125</small>
                                @error('title_english')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Arabic Title <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i> <small class="text-muted">(Max 5 words)</small></label>
                                <input class="form-control" value="{{old('title_arabic', $homeContact->title_arabic ?? '')}}" type="text" name="title_arabic" maxlength="125" required>
                                <small class="text-muted">Character count: <span id="title_ar_count">0</span>/125</small>
                                @error('title_arabic')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <!-- Subtitle Information -->
                        <h5 class="mb-3 mt-4 text-primary">Subtitle Information</h5>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">English Subtitle <small class="text-muted">(Max 2 words - Optional)</small></label>
                                <input class="form-control" value="{{old('subtitle_english', $homeContact->subtitle_english ?? '')}}" type="text" name="subtitle_english" maxlength="50">
                                <small class="text-muted">Character count: <span id="subtitle_en_count">0</span>/50</small>
                                @error('subtitle_english')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Arabic Subtitle <small class="text-muted">(Max 2 words - Optional)</small></label>
                                <input class="form-control" value="{{old('subtitle_arabic', $homeContact->subtitle_arabic ?? '')}}" type="text" name="subtitle_arabic" maxlength="50">
                                <small class="text-muted">Character count: <span id="subtitle_ar_count">0</span>/50</small>
                                @error('subtitle_arabic')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <!-- Current Background -->
                        @if($homeContact && $homeContact->background)
                        <h5 class="mb-3 mt-4 text-primary">Current Background</h5>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <a data-lightbox="{{url('/storage'.$homeContact->background)}}" href="{{url('/storage'.$homeContact->background)}}">
                                    <img style="width:100%; max-width: 500px; height: auto; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);" src="{{url('/storage'.$homeContact->background)}}" alt="Background">
                                </a>
                            </div>
                        </div>
                        @endif

                        <!-- Background Upload -->
                        <h5 class="mb-3 mt-4 text-primary">Background Image</h5>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label class="text-capitalize">Background (585x629) @if(!$homeContact || !$homeContact->background)<i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i>@endif</label>
                                <p class="text-muted small">
                                    @if($homeContact && $homeContact->background)
                                        Upload a new image to replace the current background. Leave empty to keep current image.
                                    @else
                                        Upload background image. Will be converted to 585x629 webp.
                                    @endif
                                </p>
                                <input accept="image/*" class="form-control dropify" type="file" name="background" @if(!$homeContact || !$homeContact->background) required @endif>
                                @error('background')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <hr>
                        <div class="form-group mb-0">
                            <div>
                                <button type="submit" class="btn btn-dark waves-effect waves-light mr-2">
                                    <i class="fa fa-save"></i> {{ $homeContact ? 'Update' : 'Save' }}
                                </button>
                                <button type="reset" class="btn btn-primary waves-effect m-l-5">
                                    <i class="fa fa-refresh"></i> Reset
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
<script src="{{ asset('/js/dropify.min.js') }}"></script>

<script>
    $('.dropify').dropify();
</script>

<script>
    // Character counters
    document.addEventListener('DOMContentLoaded', function() {
        const fields = [
            { input: 'input[name="title_english"]', counter: 'title_en_count' },
            { input: 'input[name="title_arabic"]', counter: 'title_ar_count' },
            { input: 'input[name="subtitle_english"]', counter: 'subtitle_en_count' },
            { input: 'input[name="subtitle_arabic"]', counter: 'subtitle_ar_count' }
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

