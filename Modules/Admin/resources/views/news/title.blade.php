@extends('admin::layouts.master')
@section('title' , 'Blog Title Home')
@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
                  <a href="{{route('Admin')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
                  <a style="pointer-events: none;" href="#checkout" class="breadcrumbs__item is-active"><i class="fa fa-check"></i>Blog Title Home</a> 
                </nav>

        <div class="col-12 mx-auto">
            <hr>
            <div class="card m-b-20">
                <div class="card-body">
                    <div class="title d-flex justify-content-between">
                        <h4 class="mt-0 mb-0 header-title align-self-center text-capitalize">Blog Title Home</h4>
                        <div class="buttons">
                            <button class="btn btn-primary" onclick="window.history.back()">
                                <i class="fa fa-angle-left"></i>
                                Back
                            </button>
                        </div>
                    </div>
                    <hr>
                    <form enctype="multipart/form-data" action="{{ route('newsheader.update' , $Header->id) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-6">
                            <label class="text-capitalize">Header English <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                            <input value="{{$Header->header}}" class="form-control" type="text" name="header">
                            @error('header')
                            <span class="text-danger mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label class="text-capitalize">Header Arabic <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                            <input value="{{$Header->header_arabic}}" class="form-control" type="text" name="header_arabic">
                            @error('header_arabic')
                            <span class="text-danger mt-1">{{ $message }}</span>
                            @enderror
                        </div>



                        <div class="form-group col-md-6">
                            <label class="text-capitalize">Bio English  <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                            <textarea  class="form-control"  rows="3" name="bio_english">{{$Header->bio_english}} </textarea>
                            @error('bio_english')
                            <span class="text-danger mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label class="text-capitalize">Bio Arabic  <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                            <textarea  class="form-control"  rows="3" name="bio_arabic">{{$Header->bio_arabic}} </textarea>
                            @error('bio_arabic')
                            <span class="text-danger mt-1">{{ $message }}</span>
                            @enderror
                        </div>


                        </div>
                        <div class="row">
                                        <div class="form-group col-md-6">
                                            <label class="text-capitalize">Hero Image <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger">(Width: 1920px - Height : 560px)</i></label>
                                            <input accept="image/*"  class="form-control dropify" type="file" name="cover">
                                            @error('cover')
                                            <span class="text-danger mt-1">{{ $message }}</span>
                                            @enderror
                                        </div>

                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                        <label class="mb-3">Hero Image </label>
                                                        <br>
                                                        @if($Header->cover != null)
                                                        <img src="{{url('/storage' . $Header->cover)}}" width="400" height="200">
                                                        @else
                                                        <p class="red-text">No Image Found</p>
                                                        @endif
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
<script src="{{ asset('/js/dropify.min.js') }}"></script>
<script>
    $('.dropify').dropify();
</script>

@endsection