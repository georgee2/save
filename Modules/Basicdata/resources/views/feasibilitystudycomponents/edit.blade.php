@extends('admin::layouts.master')
@section('title', 'Edit Feasibility Study Component')
@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Basicdata')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a href="{{route('feasibilitystudycomponent.index')}}" class="breadcrumbs__item"><i class="fa fa-list"></i> Feasibility Study Components List</a>
            <a style="pointer-events: none;" href="#checkout" class="breadcrumbs__item is-active"><i class="fa fa-check"></i> Edit Component</a> 
        </nav>

        <div class="col-12 mx-auto">
            <hr>
            <div class="card m-b-20">
                <div class="card-body">
                    <div class="title d-flex justify-content-between">
                        <h4 class="mt-0 mb-0 header-title align-self-center text-capitalize">Edit Feasibility Study Component</h4>
                        <div class="buttons">
                            <a href="{{ route('feasibilitystudycomponent.index') }}" class="mr-2">
                                <button class="btn btn-new"><i class="fa fa-list"></i>
                                    Components List</button>
                            </a>
                            <button class="btn btn-primary" onclick="window.history.back()">
                                <i class="fa fa-angle-left"></i>
                                Back
                            </button>
                        </div>
                    </div>
                    <hr>
                    <form action="{{ route('feasibilitystudycomponent.update', ['id' => $component->id]) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Project Type <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <select class="form-control select2" name="project_type_id" required>
                                    <option value="">Select Project Type</option>
                                    @foreach($projectTypes as $projectType)
                                        <option value="{{ $projectType->id }}" {{ old('project_type_id', $component->project_type_id) == $projectType->id ? 'selected' : '' }}>
                                            {{ $projectType->name_english }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('project_type_id')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Target <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <select class="form-control select2" name="target" required>
                                    <option value="">Select Target</option>
                                    <option value="Building Components" {{ old('target', $component->target) == 'Building Components' ? 'selected' : '' }}>Building Components</option>
                                    <option value="Income Components" {{ old('target', $component->target) == 'Income Components' ? 'selected' : '' }}>Income Components</option>
                                    <option value="Length Components" {{ old('target', $component->target) == 'Length Components' ? 'selected' : '' }}>Length Components</option>
                                    <option value="Construction Cost" {{ old('target', $component->target) == 'Construction Cost' ? 'selected' : '' }}>Construction Cost</option>
                                    <option value="Project Cost" {{ old('target', $component->target) == 'Project Cost' ? 'selected' : '' }}>Project Cost</option>
                                </select>
                                @error('target')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Header English <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <input class="form-control" value="{{old('header_english', $component->header_english)}}" type="text" name="header_english" required>
                                @error('header_english')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Header Arabic <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <input class="form-control" value="{{old('header_arabic', $component->header_arabic)}}" type="text" name="header_arabic" required>
                                @error('header_arabic')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Title English <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <input class="form-control" value="{{old('title_english', $component->title_english)}}" type="text" name="title_english" required>
                                @error('title_english')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Title Arabic <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <input class="form-control" value="{{old('title_arabic', $component->title_arabic)}}" type="text" name="title_arabic" required>
                                @error('title_arabic')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Status <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <select class="form-control select2" name="status" required>
                                    <option value="Active" {{ old('status', $component->status) == 'Active' ? 'selected' : '' }}>Active</option>
                                    <option value="Not Active" {{ old('status', $component->status) == 'Not Active' ? 'selected' : '' }}>Not Active</option>
                                </select>
                                @error('status')
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

