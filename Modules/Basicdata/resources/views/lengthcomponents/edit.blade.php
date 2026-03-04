@extends('admin::layouts.master')
@section('title', 'Edit Length Component')
@section('css')
<link rel="stylesheet" href="{{ asset('/css/auto-translate.css') }}">
@endsection
@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Basicdata')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a href="{{route('lengthcomponent.index')}}" class="breadcrumbs__item"><i class="fa fa-list"></i> Length Components List</a>
            <a style="pointer-events: none;" href="#checkout" class="breadcrumbs__item is-active"><i class="fa fa-check"></i> Edit Component</a> 
        </nav>

        <div class="col-12 mx-auto">
            <hr>
            <div class="card m-b-20">
                <div class="card-body">
                    <div class="title d-flex justify-content-between">
                        <h4 class="mt-0 mb-0 header-title align-self-center text-capitalize">Edit Length Component</h4>
                        <div class="buttons">
                            <a href="{{ route('lengthcomponent.index') }}" class="mr-2">
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
                    <form enctype="multipart/form-data" action="{{ route('lengthcomponent.update', ['id' => $component->id]) }}" method="POST">
                        @csrf
                        <div class="mb-3 text-right">
                            <button type="button" class="translate-all-btn"><i class="fa fa-language"></i> Translate All to Arabic</button>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Project Type <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <select class="form-control select2" id="project_type_id" name="project_type_id" required>
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
                                <label class="text-capitalize">Building Component (Length) <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <select class="form-control select2" id="building_component_id" name="building_component_id" required>
                                    <option value="">Select Building Component</option>
                                    @foreach($buildingComponents as $buildingComponent)
                                        <option value="{{ $buildingComponent->id }}" {{ old('building_component_id', $component->building_component_id) == $buildingComponent->id ? 'selected' : '' }}>
                                            {{ $buildingComponent->name_english }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('building_component_id')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">English Name <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <input class="form-control" value="{{old('name_english', $component->name_english)}}" type="text" name="name_english">
                                @error('name_english')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Arabic Name <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i> <button type="button" class="auto-translate-btn" data-translate-source="name_english" data-translate-target="name_arabic"><i class="fa fa-language"></i> Auto</button></label>
                                <input class="form-control" value="{{old('name_arabic', $component->name_arabic)}}" type="text" name="name_arabic">
                                @error('name_arabic')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label class="text-capitalize">Icon <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <input accept="image/*" class="form-control dropify" type="file" name="icon" 
                                    @if($component->icon) data-default-file="{{url('/storage'.$component->icon)}}" @endif>
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
    
    // Load building components when project type changes
    $('#project_type_id').on('change', function() {
        var projectTypeId = $(this).val();
        var buildingComponentSelect = $('#building_component_id');
        
        console.log('Project Type Changed:', projectTypeId);
        
        if (projectTypeId) {
            $.ajax({
                url: '{{ route("lengthcomponent.get-building-components") }}',
                type: 'GET',
                data: { project_type_id: projectTypeId },
                success: function(data) {
                    console.log('Building Components Loaded:', data);
                    buildingComponentSelect.empty();
                    
                    if (data.length > 0) {
                        buildingComponentSelect.append('<option value="">Select Building Component</option>');
                        $.each(data, function(key, component) {
                            buildingComponentSelect.append('<option value="' + component.id + '">' + component.name_english + '</option>');
                        });
                        buildingComponentSelect.prop('disabled', false);
                    } else {
                        buildingComponentSelect.append('<option value="">No Length Building Components Available</option>');
                        buildingComponentSelect.prop('disabled', true);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error loading building components:', error);
                    buildingComponentSelect.empty();
                    buildingComponentSelect.append('<option value="">Error Loading Components</option>');
                    buildingComponentSelect.prop('disabled', true);
                }
            });
        } else {
            buildingComponentSelect.empty();
            buildingComponentSelect.append('<option value="">Select Project Type First</option>');
            buildingComponentSelect.prop('disabled', true);
        }
    });
</script>
@endsection

