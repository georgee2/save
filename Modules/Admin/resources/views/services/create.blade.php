@extends('admin::layouts.master')
@section('title' , 'Add New Service')
@section('css')
<link rel="stylesheet" href="{{ asset('/css/tagify.css') }}">
@endsection
@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
                  <a href="{{route('Admin')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
                  <a href="{{route('service.index')}}" class="breadcrumbs__item"><i class="fa fa-list"></i> Services</a>
                  <a style="pointer-events: none;" href="#checkout" class="breadcrumbs__item is-active"><i class="fa fa-check"></i> Add New Service</a> 
                </nav>

        <div class="col-12 mx-auto">
            <hr>
            <div class="card m-b-20">
                <div class="card-body">
                    <div class="title d-flex justify-content-between">
                        <h4 class="mt-0 mb-0 header-title align-self-center text-capitalize">Add New Service</h4>
                        <div class="buttons">
                            <a href="{{ route('service.index') }}" class="mr-2">
                                <button class="btn btn-new"><i class="fa fa-list"></i>
                                    Services List</button>
                            </a>
                            <button class="btn btn-primary" onclick="window.history.back()">
                                <i class="fa fa-angle-left"></i>
                                Back
                            </button>
                        </div>
                    </div>
                    <hr>
                    <form enctype="multipart/form-data" action="{{ route('service.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-6">
                            <label class="text-capitalize">English Title <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                            <input class="form-control" value="{{old('title_english')}}" type="text" name="title_english">
                            @error('title_english')
                            <span class="text-danger mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label class="text-capitalize">Arabic Title <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                            <input class="form-control" value="{{old('title_arabic')}}" type="text" name="title_arabic">
                            @error('title_arabic')
                            <span class="text-danger mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label class="text-capitalize">Bio English (Max 2000 characters) <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                            <textarea class="form-control" name="bio_english" rows="3" maxlength="2000">{{old('bio_english')}}</textarea>
                            @error('bio_english')
                            <span class="text-danger mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label class="text-capitalize">Bio Arabic (Max 2000 characters) <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                            <textarea class="form-control" name="bio_arabic" rows="3" maxlength="2000">{{old('bio_arabic')}}</textarea>
                            @error('bio_arabic')
                            <span class="text-danger mt-1">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="form-group col-md-12">
                            <label class="text-capitalize">English Description <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                           <textarea id="elm1" class="form-control" name="description_english">{!!old('description_english')!!}</textarea>
                            @error('description_english')
                            <span class="text-danger mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-md-12">
                            <label class="text-capitalize">Arabic Description <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                           <textarea id="elm2" class="form-control" name="description_arabic">{!!old('description_arabic')!!}</textarea>
                            @error('description_arabic')
                            <span class="text-danger mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>


                        <div class="row">
                            <div class="form-group col-md-12">
                                <label class="text-capitalize">Main Image <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i> (Width: 870px - Height : 450px)</label>
                                <input accept="image/*"  class="form-control dropify" type="file" name="main_image">
                                @error('main_image')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Service Home Image - Hidden (using main image only)
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label class="text-capitalize">Service Home Image (Width: 870px - Height : 450px) - For Home Page Display</label>
                                <input accept="image/*"  class="form-control dropify" type="file" name="service_home_image">
                                <small class="form-text text-muted">Optional - If not provided, main image will be used and resized for home page</small>
                                @error('service_home_image')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        --}}

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label class="text-capitalize">Icon (Width: 100px - Height : 100px)</label>
                                <input accept="image/*"  class="form-control dropify" type="file" name="icon">
                                @error('icon')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>


                        <div class="row">
                            <div class="form-group col-md-12">
                                <label class="text-capitalize">Hero Image (Width: 1890px - Height : 420px)</label>
                                <input accept="image/*"  class="form-control dropify" type="file" name="hero_image">
                                @error('hero_image')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>


                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Parent Service (Optional - for sub-services)</label>
                                <select class="custom-select form-control select2" name="service_id">
                                    <option value="">None (Main Service)</option>
                                    @foreach($MainServices as $MainService)
                                        <option value="{{$MainService->id}}" {{old('service_id') == $MainService->id ? 'selected' : ''}}>
                                            @if(App::getLocale() == 'en')
                                                {{$MainService->title_english}}
                                            @else
                                                {{$MainService->title_arabic}}
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                @error('service_id')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Is Sub Service?</label>
                                <div class="mt-2">
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="is_sub_service" value="1" {{old('is_sub_service') ? 'checked' : ''}}>
                                        <span class="custom-control-label">Yes, this is a sub-service</span>
                                    </label>
                                </div>
                                @error('is_sub_service')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Publish Status</label>
                                <select class="custom-select form-control" name="publish_status">
                                    <option value="0" {{old('publish_status') == '0' ? 'selected' : ''}}>Published</option>
                                    <option value="1" {{old('publish_status') == '1' ? 'selected' : ''}}>Not Published</option>
                                </select>
                                @error('publish_status')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Home Feature Status</label>
                                <select class="custom-select form-control" name="home_feature_status">
                                    <option value="0" {{old('home_feature_status') == '0' ? 'selected' : ''}}>Shown</option>
                                    <option value="1" {{old('home_feature_status') == '1' ? 'selected' : ''}}>Not Shown</option>
                                </select>
                                @error('home_feature_status')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>


                                    <div class="row mt-4">

                                            <div class="form-group col-md-12">
                                                <label>SEO Tags <span class="text-danger">Press Enter After You Type</span></label>
                                                <input name="seo_tags"  value="{{old('seo_tags')}}" class=" tagify form-control" >
                                                @error('seo_tags')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>


                                            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                                <label> SEO Description English</label>
                                                <textarea name="seo_des_en" id="desen" class="form-control" maxlength="1000" rows="3" placeholder="This textarea has a limit of 1000 chars.">{{old('seo_des_en')}}</textarea>
                                                @error('seo_des_en')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                                <label> SEO Description Arabic</label>
                                                <textarea name="seo_des_ar" id="desar" class="form-control" maxlength="1000" rows="3" placeholder="This textarea has a limit of 1000 chars.">{{old('seo_des_ar')}}</textarea>
                                                @error('seo_des_ar')
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
            const el = document.querySelector('.tagify');
            new Tagify(el);
        }
</script>

@endsection


