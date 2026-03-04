@extends('admin::layouts.master')
@section('title', 'Edit Substation Room')
@section('css')
<link rel="stylesheet" href="{{ asset('/css/auto-translate.css') }}">
@endsection
@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        <nav class="breadcrumbs">
            <a href="{{route('Basicdata')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a href="{{route('substationroom.index')}}" class="breadcrumbs__item"><i class="fa fa-list"></i> Substation Rooms List</a>
            <a style="pointer-events: none;" href="#checkout" class="breadcrumbs__item is-active"><i class="fa fa-check"></i> Edit Room</a> 
        </nav>
        <div class="col-12 mx-auto">
            <hr>
            <div class="card m-b-20">
                <div class="card-body">
                    <div class="title d-flex justify-content-between">
                        <h4 class="mt-0 mb-0 header-title align-self-center text-capitalize">Edit Substation Room</h4>
                        <div class="buttons">
                            <a href="{{ route('substationroom.index') }}" class="mr-2"><button class="btn btn-new"><i class="fa fa-list"></i> Rooms List</button></a>
                            <button class="btn btn-primary" onclick="window.history.back()"><i class="fa fa-angle-left"></i> Back</button>
                        </div>
                    </div>
                    <hr>
                    <form action="{{ route('substationroom.update', ['id' => $room->id]) }}" method="POST">
                        @csrf
                        <div class="mb-3 text-right">
                            <button type="button" class="translate-all-btn"><i class="fa fa-language"></i> Translate All to Arabic</button>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label class="text-capitalize">Project Type</label>
                                <select class="form-control select2" name="project_type_id">
                                    <option value="">Select Project Type (Optional)</option>
                                    @foreach($projectTypes as $projectType)
                                        <option value="{{ $projectType->id }}" {{ old('project_type_id', $room->project_type_id) == $projectType->id ? 'selected' : '' }}>{{ $projectType->name_english }}</option>
                                    @endforeach
                                </select>
                                @error('project_type_id')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">English Name <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <input class="form-control" value="{{old('name_english', $room->name_english)}}" type="text" name="name_english" required>
                                @error('name_english')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Arabic Name <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i> <button type="button" class="auto-translate-btn" data-translate-source="name_english" data-translate-target="name_arabic"><i class="fa fa-language"></i> Auto</button></label>
                                <input class="form-control" value="{{old('name_arabic', $room->name_arabic)}}" type="text" name="name_arabic" required>
                                @error('name_arabic')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label class="text-capitalize">Price <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <input class="form-control" value="{{old('price', $room->price)}}" type="number" step="0.01" min="0" name="price" required>
                                @error('price')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <hr>
                        <div class="form-group mb-0">
                            <div>
                                <button type="submit" class="btn btn-dark waves-effect waves-light mr-2">Submit</button>
                                <button type="reset" class="btn btn-primary waves-effect m-l-5" onclick="window.history.back()">Cancel</button>
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
@endsection

