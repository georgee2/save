@extends('admin::layouts.master')
@section('title', 'Add New Specification')
@section('css')
<link rel="stylesheet" href="{{ asset('/css/auto-translate.css') }}">
@endsection
@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Basicdata')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a href="{{route('specification.index')}}" class="breadcrumbs__item"><i class="fa fa-list"></i> Specifications List</a>
            <a style="pointer-events: none;" href="#checkout" class="breadcrumbs__item is-active"><i class="fa fa-check"></i> Add New Specification</a> 
        </nav>

        <div class="col-12 mx-auto">
            <hr>
            <div class="card m-b-20">
                <div class="card-body">
                    <div class="title d-flex justify-content-between">
                        <h4 class="mt-0 mb-0 header-title align-self-center text-capitalize">Add New Specification</h4>
                        <div class="buttons">
                            <a href="{{ route('specification.index') }}" class="mr-2">
                                <button class="btn btn-new"><i class="fa fa-list"></i>
                                    Specifications List</button>
                            </a>
                            <button class="btn btn-primary" onclick="window.history.back()">
                                <i class="fa fa-angle-left"></i>
                                Back
                            </button>
                        </div>
                    </div>
                    <hr>
                    <form enctype="multipart/form-data" action="{{ route('specification.store') }}" method="POST">
                        @csrf
                        <div class="mb-3 text-right">
                            <button type="button" class="translate-all-btn"><i class="fa fa-language"></i> Translate All to Arabic</button>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">English Title <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <input class="form-control" value="{{old('title_english')}}" type="text" name="title_english">
                                @error('title_english')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Arabic Title <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i> <button type="button" class="auto-translate-btn" data-translate-source="title_english" data-translate-target="title_arabic"><i class="fa fa-language"></i> Auto</button></label>
                                <input class="form-control" value="{{old('title_arabic')}}" type="text" name="title_arabic">
                                @error('title_arabic')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Project Type <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <select class="form-control" name="type_id">
                                    <option value="">Select Project Type</option>
                                    @foreach($projectTypes as $projectType)
                                        <option value="{{ $projectType->id }}" {{ old('type_id') == $projectType->id ? 'selected' : '' }}>
                                            {{ $projectType->name_english }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('type_id')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Status <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <select class="form-control" name="status">
                                    <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Active</option>
                                    <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Not Active</option>
                                </select>
                                @error('status')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label class="text-capitalize">Icon</label>
                                <div class="alert alert-info mb-2" role="alert">
                                    <i class="mdi mdi-information-outline"></i>
                                    <strong>Image Guide:</strong> Icon will be automatically resized to 100x100 pixels and converted to WebP format for optimal performance.
                                </div>
                                <input accept="image/*" class="form-control dropify" type="file" name="icon">
                                @error('icon')
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
<script src="{{ asset('/js/auto-translate.js') }}"></script>
<script src="{{ asset('/js/dropify.min.js') }}"></script>
<script>
    $('.dropify').dropify();
</script>
@endsection

