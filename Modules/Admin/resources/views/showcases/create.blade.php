@extends('admin::layouts.master')
@section('title', 'Add New Showcase')
@section('css')
<link rel="stylesheet" href="{{ asset('/css/auto-translate.css') }}">
<link rel="stylesheet" href="{{ asset('/css/tagify.css') }}">
@endsection
@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Admin')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a href="{{route('showcase.index')}}" class="breadcrumbs__item"><i class="fa fa-star"></i> Showcases List</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-plus"></i> Add New Showcase</a> 
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
                        <h4 class="mt-0 mb-0 header-title align-self-center text-capitalize">Add New Showcase</h4>
                        <div class="buttons">
                            <a href="{{ route('showcase.index') }}" class="mr-2">
                                <button class="btn btn-new"><i class="fa fa-list"></i> Showcases List</button>
                            </a>
                            <button class="btn btn-primary" onclick="window.history.back()">
                                <i class="fa fa-angle-left"></i> Back
                            </button>
                        </div>
                    </div>
                    <hr>
                    
                    <form enctype="multipart/form-data" action="{{ route('showcase.store') }}" method="POST">
                        @csrf
                        <div class="mb-3 text-right">
                            <button type="button" class="translate-all-btn"><i class="fa fa-language"></i> Translate All to Arabic</button>
                        </div>
                        
                        <!-- Basic Information -->
                        <h5 class="mb-3 text-primary">Basic Information</h5>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">English Title <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <input class="form-control" value="{{old('title_english')}}" type="text" name="title_english" required>
                                @error('title_english')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Arabic Title <button type="button" class="auto-translate-btn" data-translate-source="title_english" data-translate-target="title_arabic"><i class="fa fa-language"></i> Auto</button> <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <input class="form-control" value="{{old('title_arabic')}}" type="text" name="title_arabic" required>
                                @error('title_arabic')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <!-- Images -->
                        <h5 class="mb-3 mt-4 text-primary">Images (Will be converted to WebP - Quality 80%)</h5>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label class="text-capitalize">Cover Image</label>
                                <small class="d-block text-muted mb-2">Size: 1890x420px - Will be converted to WebP</small>
                                <input accept="image/*" class="form-control dropify" type="file" name="cover_image">
                                @error('cover_image')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Main Image <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <small class="d-block text-muted mb-2">Size: 292x330px - Will be converted to WebP</small>
                                <input accept="image/*" class="form-control dropify" type="file" name="main_image" required>
                                @error('main_image')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Page Image <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <small class="d-block text-muted mb-2">Size: 870x450px - Will be converted to WebP</small>
                                <input accept="image/*" class="form-control dropify" type="file" name="page_image" required>
                                @error('page_image')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <!-- Descriptions -->
                        <h5 class="mb-3 mt-4 text-primary">Descriptions</h5>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label class="text-capitalize">Description (English) <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <textarea id="elm1" class="form-control" name="description_english">{!!old('description_english')!!}</textarea>
                                @error('description_english')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group col-md-12">
                                <label class="text-capitalize">Description (Arabic) <button type="button" class="auto-translate-btn" data-translate-source="description_english" data-translate-target="description_arabic"><i class="fa fa-language"></i> Auto</button> <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <textarea id="elm2" class="form-control" name="description_arabic">{!!old('description_arabic')!!}</textarea>
                                @error('description_arabic')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <!-- SEO Information -->
                        <h5 class="mb-3 mt-4 text-primary">SEO Information</h5>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label>SEO Tags <span class="text-muted">Press Enter After You Type</span></label>
                                <input name="seo_tags" value="{{old('seo_tags')}}" class="tagify form-control">
                                @error('seo_tags')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label>SEO Description (English)</label>
                                <textarea name="seo_description_english" class="form-control" maxlength="1000" rows="3">{{old('seo_description_english')}}</textarea>
                                @error('seo_description_english')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label>SEO Description (Arabic) <button type="button" class="auto-translate-btn" data-translate-source="seo_description_english" data-translate-target="seo_description_arabic"><i class="fa fa-language"></i> Auto</button></label>
                                <textarea name="seo_description_arabic" class="form-control" maxlength="1000" rows="3">{{old('seo_description_arabic')}}</textarea>
                                @error('seo_description_arabic')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <!-- Status -->
                        <h5 class="mb-3 mt-4 text-primary">Status Settings</h5>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Status <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <select name="status" class="form-control" required>
                                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('status')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Home Status <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <select name="home_status" class="form-control" required>
                                    <option value="shown" {{ old('home_status') == 'shown' ? 'selected' : '' }}>Shown</option>
                                    <option value="not_shown" {{ old('home_status') == 'not_shown' ? 'selected' : '' }}>Not Shown</option>
                                </select>
                                @error('home_status')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <hr>
                        <div class="form-group mb-0">
                            <div>
                                <button type="submit" class="btn btn-dark waves-effect waves-light mr-2">
                                    <i class="fa fa-save"></i> Submit
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
<script src="{{ asset('/js/auto-translate.js') }}"></script>
<script src="{{ asset('/js/tagify.min.js') }}"></script>
<script src="{{ asset('/js/dropify.min.js') }}"></script>

<script>
    $(document).ready(function() {
        // Initialize Dropify
        $('.dropify').dropify();
        
        // Initialize Tagify
        if(document.querySelectorAll('.tagify').length > 0){
            const el = document.querySelector('.tagify');
            new Tagify(el);
        }
        
        // Form submission handler
        $('form').on('submit', function(e) {
            console.log('Form is submitting...');
            
            // Trigger TinyMCE to save content
            if (typeof tinymce !== 'undefined' && tinymce.activeEditor) {
                tinymce.triggerSave();
                console.log('TinyMCE content saved');
            }
            
            // Let the form submit naturally
            return true;
        });
    });
</script>

@endsection

