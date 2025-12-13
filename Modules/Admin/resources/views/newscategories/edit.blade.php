@extends('admin::layouts.master')
@section('title' , 'Update News Category')
@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
                  <a href="{{route('Admin')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
                  <a href="{{route('newscategories.index')}}" class="breadcrumbs__item"><i class="fa fa-list"></i> News Categories List</a>
                  <a style="pointer-events: none;" href="#checkout" class="breadcrumbs__item is-active"><i class="fa fa-check"></i> Update News Category</a> 
                </nav>

        <div class="col-12 mx-auto">
            <hr>
            <div class="card m-b-20">
                <div class="card-body">
                    <div class="title d-flex justify-content-between">
                        <h4 class="mt-0 mb-0 header-title align-self-center text-capitalize">Update Category</h4>
                        <div class="buttons">
                            <a href="{{ route('newscategories.index') }}" class="mr-2">
                                <button class="btn btn-new"><i class="fa fa-list"></i>
                                     News Categories List</button>
                            </a>
                            <button class="btn btn-primary" onclick="window.history.back()">
                                <i class="fa fa-angle-left"></i>
                                Back
                            </button>
                        </div>
                    </div>
                    <hr>
                    <form enctype="multipart/form-data" action="{{ route('newscategories.update' , ['id' => $Category->id]) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-6">
                            <label class="text-capitalize">English Name <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                            <input class="form-control" value="{{$Category->name_english}}" type="text" name="name_english">
                            @error('name_english')
                            <span class="text-danger mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label class="text-capitalize">Arabic Name <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                            <input class="form-control" value="{{$Category->name_arabic}}" type="text" name="name_arabic">
                            @error('name_arabic')
                            <span class="text-danger mt-1">{{ $message }}</span>
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
<script src="{{ asset('/js/dropify.min.js') }}"></script>
<script>
    $('.dropify').dropify();
</script>

@endsection