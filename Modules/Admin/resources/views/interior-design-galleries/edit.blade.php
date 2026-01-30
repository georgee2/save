@extends('admin::layouts.master')
@section('title', 'Edit Interior Design Gallery')
@section('css')
<link rel="stylesheet" href="{{ asset('/css/tagify.css') }}">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-container--default .select2-selection--single {
        height: 38px;
        padding: 5px;
        border: 1px solid #ced4da;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 36px;
    }
</style>
@endsection
@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Admin')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a href="{{route('interior-design-gallery.index')}}" class="breadcrumbs__item"><i class="fa fa-list"></i> Interior Design Gallery List</a>
            <a style="pointer-events: none;" href="#checkout" class="breadcrumbs__item is-active"><i class="fa fa-check"></i> Edit Gallery</a> 
        </nav>

        <div class="col-12 mx-auto">
            <hr>
            <div class="card m-b-20">
                <div class="card-body">
                    <div class="title d-flex justify-content-between">
                        <h4 class="mt-0 mb-0 header-title align-self-center text-capitalize">Edit Interior Design Gallery</h4>
                        <div class="buttons">
                            <a href="{{ route('interior-design-gallery.index') }}" class="mr-2">
                                <button class="btn btn-new"><i class="fa fa-list"></i>
                                    Gallery List</button>
                            </a>
                            <button class="btn btn-primary" onclick="window.history.back()">
                                <i class="fa fa-angle-left"></i>
                                Back
                            </button>
                        </div>
                    </div>
                    <hr>
                    <form enctype="multipart/form-data" action="{{ route('interior-design-gallery.update', ['id' => $gallery->id]) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">English Title <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <input class="form-control" value="{{old('title_english', $gallery->title_english)}}" type="text" name="title_english" required>
                                @error('title_english')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Arabic Title <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <input class="form-control" value="{{old('title_arabic', $gallery->title_arabic)}}" type="text" name="title_arabic" required>
                                @error('title_arabic')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Bio English (Max 150 characters)</label>
                                <textarea class="form-control" id="bio_english" name="bio_english" rows="2" maxlength="150">{{old('bio_english', $gallery->bio_english)}}</textarea>
                                <small class="form-text text-muted">
                                    <span id="bio_english_count">0</span> / 150 characters
                                </small>
                                @error('bio_english')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Bio Arabic (Max 150 characters)</label>
                                <textarea class="form-control" id="bio_arabic" name="bio_arabic" rows="2" maxlength="150">{{old('bio_arabic', $gallery->bio_arabic)}}</textarea>
                                <small class="form-text text-muted">
                                    <span id="bio_arabic_count">0</span> / 150 characters
                                </small>
                                @error('bio_arabic')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Category</label>
                                <select class="form-control select2" name="category_id">
                                    <option value="">Select Category (Optional)</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $gallery->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->title_english }} {{ $category->title_arabic ? '(' . $category->title_arabic . ')' : '' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Project Type <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <select class="form-control select2" name="project_type_id" required>
                                    <option value="">Select Project Type</option>
                                    @foreach($projectTypes as $type)
                                        <option value="{{ $type->id }}" {{ old('project_type_id', $gallery->project_type_id) == $type->id ? 'selected' : '' }}>
                                            {{ $type->name_english }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('project_type_id')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Project Style</label>
                                <select class="form-control select2" name="project_style_id">
                                    <option value="">Select Project Style (Optional)</option>
                                    @foreach($projectStyles as $style)
                                        <option value="{{ $style->id }}" {{ old('project_style_id', $gallery->project_style_id) == $style->id ? 'selected' : '' }}>
                                            {{ $style->title_english }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('project_style_id')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Project</label>
                                <select class="form-control select2" name="project_id">
                                    <option value="">Select Project (Optional)</option>
                                    @foreach($projects as $project)
                                        <option value="{{ $project->id }}" {{ old('project_id', $gallery->project_id) == $project->id ? 'selected' : '' }}>
                                            {{ $project->title_english }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('project_id')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Emirate</label>
                                <select class="form-control select2" name="emirate_id">
                                    <option value="">Select Emirate (Optional)</option>
                                    @foreach($emirates as $emirate)
                                        <option value="{{ $emirate->id }}" {{ old('emirate_id', $gallery->emirate_id) == $emirate->id ? 'selected' : '' }}>
                                            {{ $emirate->title_english }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('emirate_id')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label class="text-capitalize">Publish Status <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <select class="form-control" name="publish_status" required>
                                    <option value="0" {{ old('publish_status', $gallery->publish_status) == '0' ? 'selected' : '' }}>Published</option>
                                    <option value="1" {{ old('publish_status', $gallery->publish_status) == '1' ? 'selected' : '' }}>Not Published</option>
                                </select>
                                @error('publish_status')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label class="text-capitalize">Home Status <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <select class="form-control" name="home_status" required>
                                    <option value="0" {{ old('home_status', $gallery->home_status) == '0' ? 'selected' : '' }}>Shown on Home</option>
                                    <option value="1" {{ old('home_status', $gallery->home_status) == '1' ? 'selected' : '' }}>Not Shown on Home</option>
                                </select>
                                @error('home_status')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label class="text-capitalize">Display Order <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <input class="form-control" value="{{old('ordering', $gallery->ordering)}}" type="number" name="ordering" min="0" required>
                                <small class="form-text text-muted">Lower numbers appear first</small>
                                @error('ordering')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label class="text-capitalize">Image</label>
                                <input accept="image/*" class="form-control dropify" type="file" name="image" 
                                    @if($gallery->image) data-default-file="{{url('/storage'.$gallery->image)}}" @endif>
                                <small class="form-text text-muted">
                                    <i class="fa fa-info-circle"></i> Recommended size: <strong>765px x 432px</strong>. Image will be automatically resized and converted to WebP format.
                                </small>
                                @error('image')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="form-group col-md-12">
                                <label>SEO Tags <span class="text-danger">Press Enter After You Type</span></label>
                                <input name="seo_tags" value="{{$gallery->seo_tags}}" class="tagify form-control">
                                @error('seo_tags')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                <label>SEO Description English</label>
                                <textarea name="seo_description_english" class="form-control" maxlength="1000" rows="3" placeholder="This textarea has a limit of 1000 chars.">{{$gallery->seo_description_english}}</textarea>
                                @error('seo_description_english')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                <label>SEO Description Arabic</label>
                                <textarea name="seo_description_arabic" class="form-control" maxlength="1000" rows="3" placeholder="This textarea has a limit of 1000 chars.">{{$gallery->seo_description_arabic}}</textarea>
                                @error('seo_description_arabic')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <hr>
                        <div class="form-group mb-0">
                            <div>
                                <button type="submit" class="btn btn-dark waves-effect waves-light mr-2">
                                    Update
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        // Initialize Dropify
        $('.dropify').dropify();
        
        // Initialize Select2
        $('.select2').select2({
            placeholder: 'Select an option',
            allowClear: true
        });
        
        // Initialize Tagify
        if(document.querySelectorAll('.tagify').length > 0){
            var input = document.querySelector('.tagify');
            new Tagify(input);
        }
        
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
    });
</script>
@endsection
