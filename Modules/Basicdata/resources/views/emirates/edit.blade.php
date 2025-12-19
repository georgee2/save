@extends('admin::layouts.master')
@section('title', 'Edit Emirate')
@section('css')
<link rel="stylesheet" href="{{ asset('/css/tagify.css') }}">
@endsection
@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Basicdata')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a href="{{route('emirate.index')}}" class="breadcrumbs__item"><i class="fa fa-list"></i> Emirates List</a>
            <a style="pointer-events: none;" href="#checkout" class="breadcrumbs__item is-active"><i class="fa fa-check"></i> Edit Emirate</a> 
        </nav>

        <div class="col-12 mx-auto">
            <hr>
            <div class="card m-b-20">
                <div class="card-body">
                    <div class="title d-flex justify-content-between">
                        <h4 class="mt-0 mb-0 header-title align-self-center text-capitalize">Edit Emirate</h4>
                        <div class="buttons">
                            <a href="{{ route('emirate.index') }}" class="mr-2">
                                <button class="btn btn-new"><i class="fa fa-list"></i>
                                    Emirates List</button>
                            </a>
                            <button class="btn btn-primary" onclick="window.history.back()">
                                <i class="fa fa-angle-left"></i>
                                Back
                            </button>
                        </div>
                    </div>
                    <hr>
                    <form enctype="multipart/form-data" action="{{ route('emirate.update', ['id' => $emirate->id]) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">English Title <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <input class="form-control" value="{{old('title_english', $emirate->title_english)}}" type="text" name="title_english">
                                @error('title_english')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Arabic Title <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <input class="form-control" value="{{old('title_arabic', $emirate->title_arabic)}}" type="text" name="title_arabic">
                                @error('title_arabic')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Bio English (Max 500 characters)</label>
                                <textarea class="form-control" id="bio_english" name="bio_english" rows="3" maxlength="500">{{old('bio_english', $emirate->bio_english)}}</textarea>
                                <small class="form-text text-muted">
                                    <span id="bio_english_count">0</span> / 500 characters
                                </small>
                                @error('bio_english')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Bio Arabic (Max 500 characters)</label>
                                <textarea class="form-control" id="bio_arabic" name="bio_arabic" rows="3" maxlength="500">{{old('bio_arabic', $emirate->bio_arabic)}}</textarea>
                                <small class="form-text text-muted">
                                    <span id="bio_arabic_count">0</span> / 500 characters
                                </small>
                                @error('bio_arabic')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label class="text-capitalize">English Description (Max 1500 characters)</label>
                                <textarea class="form-control" id="description_english" name="description_english" rows="5" maxlength="1500">{{old('description_english', $emirate->description_english)}}</textarea>
                                <small class="form-text text-muted">
                                    <span id="description_english_count">0</span> / 1500 characters
                                </small>
                                @error('description_english')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Arabic Description (Max 1500 characters)</label>
                                <textarea class="form-control" id="description_arabic" name="description_arabic" rows="5" maxlength="1500">{{old('description_arabic', $emirate->description_arabic)}}</textarea>
                                <small class="form-text text-muted">
                                    <span id="description_arabic_count">0</span> / 1500 characters
                                </small>
                                @error('description_arabic')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label class="text-capitalize">Icon</label>
                                <input accept="image/*" class="form-control dropify" type="file" name="icon" 
                                    @if($emirate->icon) data-default-file="{{url('/storage'.$emirate->icon)}}" @endif>
                                <small class="form-text text-muted">
                                    <i class="fa fa-info-circle"></i> Recommended size: <strong>150px x 150px</strong>. Image will be automatically resized and converted to WebP format.
                                </small>
                                @error('icon')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label class="text-capitalize">Image</label>
                                <input accept="image/*" class="form-control dropify" type="file" name="image"
                                    @if($emirate->image) data-default-file="{{url('/storage'.$emirate->image)}}" @endif>
                                <small class="form-text text-muted">
                                    <i class="fa fa-info-circle"></i> Recommended size: <strong>540px x 675px</strong>. Image will be automatically resized and converted to WebP format.
                                </small>
                                @error('image')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label class="text-capitalize">Cover</label>
                                <input accept="image/*" class="form-control dropify" type="file" name="cover"
                                    @if($emirate->cover) data-default-file="{{url('/storage'.$emirate->cover)}}" @endif>
                                @error('cover')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="form-group col-md-12">
                                <label>SEO Tags <span class="text-danger">Press Enter After You Type</span></label>
                                <input name="seo_tags" value="{{$emirate->seo_tags}}" class="tagify form-control">
                                @error('seo_tags')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                <label>SEO Description English</label>
                                <textarea name="seo_description_english" class="form-control" maxlength="1000" rows="3" placeholder="This textarea has a limit of 1000 chars.">{{$emirate->seo_description_english}}</textarea>
                                @error('seo_description_english')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                <label>SEO Description Arabic</label>
                                <textarea name="seo_description_arabic" class="form-control" maxlength="1000" rows="3" placeholder="This textarea has a limit of 1000 chars.">{{$emirate->seo_description_arabic}}</textarea>
                                @error('seo_description_arabic')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <hr>
                        <div class="form-group mb-0">
                            <div>
                                <button type="submit" class="btn btn-dark waves-effect waves-light mr-2">
                                    Submit
                                </button>
                                <button type="reset" class="btn btn-primary waves-effect m-l-5"
                                    onclick="window.history.back()">
                                    Cancel
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
<script src="{{ asset('/js/tagify.min.js') }}"></script>
<script src="{{ asset('/js/dropify.min.js') }}"></script>
<script>
    $('.dropify').dropify();
</script>
<script>
    if(document.querySelectorAll('.tagify').length > 0){
        var input = document.querySelector('.tagify');
        new Tagify(input);
    }
</script>
<script>
    // Character counters
    function updateCharCount(textareaId, counterId) {
        const textarea = document.getElementById(textareaId);
        const counter = document.getElementById(counterId);
        
        if (textarea && counter) {
            // Update on page load
            counter.textContent = textarea.value.length;
            
            // Update on input
            textarea.addEventListener('input', function() {
                counter.textContent = this.value.length;
            });
        }
    }
    
    // Initialize character counters
    updateCharCount('bio_english', 'bio_english_count');
    updateCharCount('bio_arabic', 'bio_arabic_count');
    updateCharCount('description_english', 'description_english_count');
    updateCharCount('description_arabic', 'description_arabic_count');
</script>
@endsection

