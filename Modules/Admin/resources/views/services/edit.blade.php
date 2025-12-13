@extends('admin::layouts.master')
@section('title' , 'Update Service')
@section('css')
<link rel="stylesheet" href="{{ asset('/css/tagify.css') }}">
@endsection
@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
                  <a href="{{route('Admin')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
                  <a href="{{route('service.index')}}" class="breadcrumbs__item"><i class="fa fa-list"></i> Services</a>
                  <a style="pointer-events: none;" href="#checkout" class="breadcrumbs__item is-active"><i class="fa fa-check"></i> Update Service</a> 
                </nav>

        <div class="col-12 mx-auto">
            <hr>
            <div class="card m-b-20">
                <div class="card-body">
                    <div class="title d-flex justify-content-between">
                        <h4 class="mt-0 mb-0 header-title align-self-center text-capitalize">Update Service</h4>
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
                    <form enctype="multipart/form-data" action="{{ route('service.update' , ['id' => $Service->id]) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-6">
                            <label class="text-capitalize">English Title <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                            <input class="form-control" value="{{$Service->title_english}}" type="text" name="title_english">
                            @error('title_english')
                            <span class="text-danger mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label class="text-capitalize">Arabic Title <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                            <input class="form-control" value="{{$Service->title_arabic}}" type="text" name="title_arabic">
                            @error('title_arabic')
                            <span class="text-danger mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label class="text-capitalize">Bio English (Max 2000 characters) <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                            <textarea class="form-control" name="bio_english" rows="3" maxlength="2000">{{$Service->bio_english}}</textarea>
                            @error('bio_english')
                            <span class="text-danger mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label class="text-capitalize">Bio Arabic (Max 2000 characters) <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                            <textarea class="form-control" name="bio_arabic" rows="3" maxlength="2000">{{$Service->bio_arabic}}</textarea>
                            @error('bio_arabic')
                            <span class="text-danger mt-1">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="form-group col-md-12">
                            <label class="text-capitalize">English Description <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                           <textarea id="elm1" class="form-control" name="description_english">{!!$Service->description_english!!}</textarea>
                            @error('description_english')
                            <span class="text-danger mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-md-12">
                            <label class="text-capitalize">Arabic Description <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                           <textarea id="elm2" class="form-control" name="description_arabic">{!!$Service->description_arabic!!}</textarea>
                            @error('description_arabic')
                            <span class="text-danger mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>


                         <div class="row">
                                        <div class="form-group col-md-6">
                                            <label class="text-capitalize">Main Image (Width: 870px - Height : 450px)</label>
                                            <input accept="image/*"  class="form-control dropify" type="file" name="main_image">
                                            @error('main_image')
                                            <span class="text-danger mt-1">{{ $message }}</span>
                                            @enderror
                                        </div>

                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                        <label class="mb-3">Current Main Image </label>
                                                        <br>
                                                        @if($Service->main_image != null)
                                                        <img src="{{url('/storage' . $Service->main_image)}}" width="400" height="200">
                                                        @else
                                                        <p class="text-danger">No Image Found</p>
                                                        @endif
                                                    </div> 
                                    </div>

                         <div class="row">
                                        <div class="form-group col-md-6">
                                            <label class="text-capitalize">Service Home Image (Width: 434px - Height : 420px) - For Home Page Display</label>
                                            <input accept="image/*"  class="form-control dropify" type="file" name="service_home_image">
                                            <small class="form-text text-muted">Optional - If not provided, main image will be used and resized for home page</small>
                                            @error('service_home_image')
                                            <span class="text-danger mt-1">{{ $message }}</span>
                                            @enderror
                                        </div>

                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                        <label class="mb-3">Current Service Home Image </label>
                                                        <br>
                                                        @if($Service->service_home_image != null)
                                                        <img src="{{url('/storage' . $Service->service_home_image)}}" width="434" height="420">
                                                        @else
                                                        <p class="text-muted">No Service Home Image - Main Image will be used</p>
                                                        @endif
                                                    </div> 
                                    </div>

                         <div class="row">
                                        <div class="form-group col-md-6">
                                            <label class="text-capitalize">Icon (Width: 100px - Height : 100px)</label>
                                            <input accept="image/*"  class="form-control dropify" type="file" name="icon">
                                            @error('icon')
                                            <span class="text-danger mt-1">{{ $message }}</span>
                                            @enderror
                                        </div>

                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                        <label class="mb-3">Current Icon </label>
                                                        <br>
                                                        @if($Service->icon != null)
                                                        <img src="{{url('/storage' . $Service->icon)}}" width="87" height="87">
                                                        @else
                                                        <p class="text-danger">No Icon Found</p>
                                                        @endif
                                                    </div> 
                                    </div>

                         <div class="row">
                                        <div class="form-group col-md-6">
                                            <label class="text-capitalize">Hero Image (Width: 1890px - Height : 420px)</label>
                                            <input accept="image/*"  class="form-control dropify" type="file" name="hero_image">
                                            @error('hero_image')
                                            <span class="text-danger mt-1">{{ $message }}</span>
                                            @enderror
                                        </div>

                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                        <label class="mb-3">Current Hero Image </label>
                                                        <br>
                                                        @if($Service->hero_image != null)
                                                        <img src="{{url('/storage' . $Service->hero_image)}}" width="400" height="120">
                                                        @else
                                                        <p class="text-danger">No Hero Image Found</p>
                                                        @endif
                                                    </div> 
                                    </div>


                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Parent Service (Optional - for sub-services)</label>
                                <select class="custom-select form-control select2" name="service_id">
                                    <option value="">
                                        @if($Service->parent_title_en)
                                            @if(App::getLocale() == 'en')
                                                {{$Service->parent_title_en}}
                                            @else
                                                {{$Service->parent_title_ar}}
                                            @endif
                                        @else
                                            None (Main Service)
                                        @endif
                                    </option>
                                    @foreach($MainServices as $MainService)
                                        <option value="{{$MainService->id}}">
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
                                        <input type="checkbox" class="custom-control-input" name="is_sub_service" value="1" {{$Service->is_sub_service ? 'checked' : ''}}>
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
                                    <option value="0" {{$Service->publish_status == 0 ? 'selected' : ''}}>Published</option>
                                    <option value="1" {{$Service->publish_status == 1 ? 'selected' : ''}}>Not Published</option>
                                </select>
                                @error('publish_status')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Home Feature Status</label>
                                <select class="custom-select form-control" name="home_feature_status">
                                    <option value="0" {{$Service->home_feature_status == 0 ? 'selected' : ''}}>Shown</option>
                                    <option value="1" {{$Service->home_feature_status == 1 ? 'selected' : ''}}>Not Shown</option>
                                </select>
                                @error('home_feature_status')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>


                                    <div class="row mt-4">

                                            <div class="form-group col-md-12">
                                                <label>SEO Tags <span class="text-danger">Press Enter After You Type</span></label>
                                                <input name="seo_tags"  value="{{$Service->seo_tags}}" class=" tagify form-control" >
                                                @error('seo_tags')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>


                                            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                                <label> SEO Description English</label>
                                                <textarea name="seo_des_en" id="desen" class="form-control" maxlength="1000" rows="3" placeholder="This textarea has a limit of 1000 chars.">{{$Service->seo_des_en}}</textarea>
                                                @error('seo_des_en')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                                <label> SEO Description Arabic</label>
                                                <textarea name="seo_des_ar" id="desar" class="form-control" maxlength="1000" rows="3" placeholder="This textarea has a limit of 1000 chars.">{{$Service->seo_des_ar}}</textarea>
                                                @error('seo_des_ar')
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


