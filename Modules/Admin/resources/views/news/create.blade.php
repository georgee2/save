@extends('admin::layouts.master')
@section('title' , 'Add New Blog')
@section('css')
<link rel="stylesheet" href="{{ asset('/css/tagify.css') }}">
@endsection
@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
                  <a href="{{route('Admin')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
                  <a href="{{route('news-back.index')}}" class="breadcrumbs__item"><i class="fa fa-list"></i> News</a>
                  <a style="pointer-events: none;" href="#checkout" class="breadcrumbs__item is-active"><i class="fa fa-check"></i> Add New Blog</a> 
                </nav>

        <div class="col-12 mx-auto">
            <hr>
            <div class="card m-b-20">
                <div class="card-body">
                    <div class="title d-flex justify-content-between">
                        <h4 class="mt-0 mb-0 header-title align-self-center text-capitalize">Add New Blog</h4>
                        <div class="buttons">
                            <a href="{{ route('news-back.index') }}" class="mr-2">
                                <button class="btn btn-new"><i class="fa fa-list"></i>
                                    News List</button>
                            </a>
                            <button class="btn btn-primary" onclick="window.history.back()">
                                <i class="fa fa-angle-left"></i>
                                Back
                            </button>
                        </div>
                    </div>
                    <hr>
                    <form enctype="multipart/form-data" action="{{ route('news-back.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-4">
                            <label class="text-capitalize">English Title <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                            <input class="form-control" value="{{old('title_english')}}" type="text" name="title_english">
                            @error('title_english')
                            <span class="text-danger mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label class="text-capitalize">Arabic Title <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                            <input class="form-control" value="{{old('title_arabic')}}" type="text" name="title_arabic">
                            @error('title_arabic')
                            <span class="text-danger mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-md-4">
                            <label class="text-capitalize">Category <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                            <select class="custom-select form-control" name="category_code">
                                <option selected disabled value="">Choose One</option>
                                @foreach($Category as $Category)
                                    <option value="{{$Category->id}}">
                                        @if(App::getLocale() == 'en')
                                            {{$Category->name_english}}
                                        @else
                                            {{$Category->name_arabic}}
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            @error('category_code')
                            <span class="text-danger mt-1">{{ $message }}</span>
                            @enderror
                        </div>


                        <!-- Hidden Fields - Set to 'none' by default -->
                        {{-- 
                        <div class="form-group col-md-6">
                            <label class="text-capitalize">Bio English</label>
                            <textarea class="form-control" name="bio_english" rows="3" maxlength="1000">{{old('bio_english')}}</textarea>
                            @error('bio_english')
                            <span class="text-danger mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label class="text-capitalize">Bio Arabic</label>
                            <textarea class="form-control" name="bio_arabic" rows="3" maxlength="1000">{{old('bio_arabic')}}</textarea>
                            @error('bio_arabic')
                            <span class="text-danger mt-1">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="form-group col-md-6">
                            <label class="text-capitalize">Button Text English</label>
                            <input class="form-control" value="{{old('button_text')}}" type="text" name="button_text">
                            @error('button_text')
                            <span class="text-danger mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label class="text-capitalize">Button Text Arabic</label>
                            <input class="form-control" value="{{old('button_text_arabic')}}" type="text" name="button_text_arabic">
                            @error('button_text_arabic')
                            <span class="text-danger mt-1">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="form-group col-md-6">
                            <label class="text-capitalize">Button Link English</label>
                            <input class="form-control" value="{{old('link_english')}}" type="text" name="link_english">
                            @error('link_english')
                            <span class="text-danger mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label class="text-capitalize">Button Link Arabic</label>
                            <input class="form-control" value="{{old('link_arabic')}}" type="text" name="link_arabic">
                            @error('link_arabic')
                            <span class="text-danger mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                        --}}
            

                        <div class="form-group col-md-12">
                            <label class="text-capitalize">English Body</label>
                           <textarea id="elm1" class="form-control" name="body_english">{!!old('body_english')!!}</textarea>
                            @error('body_english')
                            <span class="text-danger mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-md-12">
                            <label class="text-capitalize">Arabic Body</label>
                           <textarea id="elm1" class="form-control" name="body_arabic">{!!old('body_arabic')!!}</textarea>
                            @error('body_arabic')
                            <span class="text-danger mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>


                        <div class="row">
                            <div class="form-group col-md-12">
                                <label class="text-capitalize">Main Image (600x600px Square - Will be converted to WebP)</label>
                                <input accept="image/*"  class="form-control dropify" type="file" name="image">
                                @error('image')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label class="text-capitalize">Page Image (Width: 870px - Height: 450px - Will be converted to WebP)</label>
                                <input accept="image/*"  class="form-control dropify" type="file" name="page_image">
                                @error('page_image')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label class="text-capitalize">Cover Image (Width: 1890px - Height: 420px - Will be converted to WebP)</label>
                                <input accept="image/*"  class="form-control dropify" type="file" name="cover">
                                @error('cover')
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
                                                <textarea name="seo_des_en" id="desen" class="form-control" maxlength="225" rows="3" placeholder="This textarea has a limit of 1000 chars.">{{old('seo_des_en')}}</textarea>
                                                @error('seo_des_en')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                                <label> SEO Description Arabic</label>
                                                <textarea name="seo_des_ar" id="desar" class="form-control" maxlength="225" rows="3" placeholder="This textarea has a limit of 1000 chars.">{{old('seo_des_ar')}}</textarea>
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
