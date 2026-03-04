@extends('admin::layouts.master')
@section('title', 'Add New Floor Component')
@section('css')
<link rel="stylesheet" href="{{ asset('/css/auto-translate.css') }}">
@endsection
@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Basicdata')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a href="{{route('floorcomponent.index')}}" class="breadcrumbs__item"><i class="fa fa-list"></i> Floor Components List</a>
            <a style="pointer-events: none;" href="#checkout" class="breadcrumbs__item is-active"><i class="fa fa-check"></i> Add New Floor Component</a> 
        </nav>

        <div class="col-12 mx-auto">
            <hr>
            <div class="card m-b-20">
                <div class="card-body">
                    <div class="title d-flex justify-content-between">
                        <h4 class="mt-0 mb-0 header-title align-self-center text-capitalize">Add New Floor Component</h4>
                        <div class="buttons">
                            <a href="{{ route('floorcomponent.index') }}" class="mr-2">
                                <button class="btn btn-new"><i class="fa fa-list"></i>
                                    Floor Components List</button>
                            </a>
                            <button class="btn btn-primary" onclick="window.history.back()">
                                <i class="fa fa-angle-left"></i>
                                Back
                            </button>
                        </div>
                    </div>
                    <hr>
                    <form enctype="multipart/form-data" action="{{ route('floorcomponent.store') }}" method="POST">
                        @csrf
                        <div class="mb-3 text-right">
                            <button type="button" class="translate-all-btn"><i class="fa fa-language"></i> Translate All to Arabic</button>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Project Type <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <select class="form-control select2" name="project_type_id" id="project_type_id" required>
                                    <option value="">Select Project Type</option>
                                    @foreach($projectTypes as $projectType)
                                        <option value="{{ $projectType->id }}" {{ old('project_type_id') == $projectType->id ? 'selected' : '' }}>
                                            {{ $projectType->name_english }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('project_type_id')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Building Component <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <select class="form-control select2" name="component_id" id="component_id" required>
                                    <option value="">Select Building Component</option>
                                    @foreach($buildingComponents as $component)
                                        <option value="{{ $component->id }}" data-project-type="{{ $component->project_type_id }}" {{ old('component_id') == $component->id ? 'selected' : '' }}>
                                            {{ $component->name_english }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('component_id')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label class="text-capitalize">English Name <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <input class="form-control" value="{{old('name_english')}}" type="text" name="name_english">
                                @error('name_english')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Arabic Name <button type="button" class="auto-translate-btn" data-translate-source="name_english" data-translate-target="name_arabic"><i class="fa fa-language"></i> Auto</button> <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <input class="form-control" value="{{old('name_arabic')}}" type="text" name="name_arabic">
                                @error('name_arabic')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label class="text-capitalize">Icon <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
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
    
    // Filter building components based on selected project type
    $('#project_type_id').on('change', function() {
        var projectTypeId = $(this).val();
        var componentSelect = $('#component_id');
        
        if (projectTypeId) {
            componentSelect.find('option').each(function() {
                var option = $(this);
                if (option.val() === '') {
                    option.show();
                } else if (option.data('project-type') == projectTypeId) {
                    option.show();
                } else {
                    option.hide();
                }
            });
            componentSelect.val('').trigger('change');
        } else {
            componentSelect.find('option').show();
            componentSelect.val('').trigger('change');
        }
    });
    
    // Trigger on page load if project type is already selected
    if ($('#project_type_id').val()) {
        $('#project_type_id').trigger('change');
    }
</script>
@endsection

