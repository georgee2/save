@extends('admin::layouts.master')
@section('title' , 'Add New User')
@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
                  <a href="{{route('Admin')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
                  <a href="{{route('users.index')}}" class="breadcrumbs__item"><i class="fa fa-list"></i> Users List</a>
                  <a style="pointer-events: none;" href="#checkout" class="breadcrumbs__item is-active"><i class="fa fa-check"></i> Add New User</a> 
                </nav>

        <div class="col-12 mx-auto">
            <hr>
            <div class="card m-b-20">
                <div class="card-body">
                    <div class="title d-flex justify-content-between">
                        <h4 class="mt-0 mb-0 header-title align-self-center text-capitalize">Add New User</h4>
                        <div class="buttons">
                            <a href="{{ route('users.index') }}" class="mr-2">
                                <button class="btn btn-new"><i class="fa fa-list"></i>
                                     Users List</button>
                            </a>
                            <button class="btn btn-primary" onclick="window.history.back()">
                                <i class="fa fa-angle-left"></i>
                                Back
                            </button>
                        </div>
                    </div>
                    <hr>
                    <form enctype="multipart/form-data" action="{{ route('users.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-4">
                            <label class="text-capitalize">User Name <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                            <input class="form-control" value="{{old('name')}}" type="text" name="name">
                            @error('name')
                            <span class="text-danger mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label class="text-capitalize">Email <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                            <input class="form-control" value="{{old('email')}}" type="text" name="email">
                            @error('email')
                            <span class="text-danger mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-md-4">
                            <label class="text-capitalize">Password <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                            <input class="form-control" value="{{old('password')}}" type="text" name="password">
                            @error('password')
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