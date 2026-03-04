@extends('admin::layouts.master')
@section('title', 'Edit Floor - ' . $offer->title_english)

@section('css')
<link rel="stylesheet" href="{{asset('/css/dropify.min.css')}}">
<link rel="stylesheet" href="{{ asset('/css/auto-translate.css') }}">
<style>
    .form-section {
        background: #fff;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    
    .section-title {
        font-size: 18px;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #3498db;
    }
</style>
@endsection

@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Admin')}}" class="breadcrumbs__item"><i class="fa fa-home"></i> Dashboard</a>
            <a href="{{route('offer.index')}}" class="breadcrumbs__item"><i class="fa fa-tags"></i> Offers</a>
            <a href="{{route('offer.show', ['id' => $offer->id])}}" class="breadcrumbs__item"><i class="fa fa-eye"></i> {{ $offer->title_english }}</a>
            <a href="{{route('offer.floor.index', ['offerId' => $offer->id])}}" class="breadcrumbs__item"><i class="fa fa-layer-group"></i> Floors</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-pencil"></i> Edit Floor</a>
        </nav>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="mt-0 header-title">
                            <i class="fa fa-pencil"></i> Edit Floor
                        </h4>
                        <p class="text-muted mb-4">Update floor information for {{ $offer->title_english }}</p>
                        <hr>
                        
                        <form enctype="multipart/form-data" action="{{ route('offer.floor.update', ['offerId' => $offer->id, 'id' => $floor->id]) }}" method="POST">
                            @csrf
                            <button type="button" class="btn btn-translate-all mb-3" id="translateAllBtn"><i class="fa fa-language"></i> Translate All</button>
                            
                            <!-- Component Selection -->
                            <div class="form-section">
                                <h5 class="section-title"><i class="fa fa-cube"></i> Component Selection</h5>
                                
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class="text-capitalize">Building Component <span class="text-danger">*</span></label>
                                        <select class="form-control select2" name="building_component_id" id="building_component_id" required style="width: 100%;">
                                            <option value="">Select Building Component</option>
                                            @foreach($offerBuildingComponents as $component)
                                                <option value="{{ $component->building_component_id }}" 
                                                    {{ old('building_component_id', $floor->building_component_id) == $component->building_component_id ? 'selected' : '' }}>
                                                    {{ $component->name_english }} - {{ $component->name_arabic }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <small class="form-text text-muted">Select the building component for this floor</small>
                                        @error('building_component_id')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                                    </div>
                                    
                                    <div class="form-group col-md-6">
                                        <label class="text-capitalize">Floor Component <span class="text-danger">*</span></label>
                                        <select class="form-control" name="floor_component_id" id="floor_component_id" required>
                                            <option value="">Loading...</option>
                                            @foreach($floorComponents as $component)
                                                <option value="{{ $component->id }}" 
                                                    {{ old('floor_component_id', $floor->floor_component_id) == $component->id ? 'selected' : '' }}>
                                                    {{ $component->name_english }} - {{ $component->name_arabic }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <small class="form-text text-muted">Floor components will be loaded based on building component</small>
                                        @error('floor_component_id')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Measurements -->
                            <div class="form-section">
                                <h5 class="section-title"><i class="fa fa-calculator"></i> Measurements</h5>
                                
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label class="text-capitalize">Area (SqFt) <span class="text-danger">*</span></label>
                                        <input class="form-control" value="{{old('sqft', $floor->sqft)}}" type="number" name="sqft" id="sqft" step="0.01" min="0" required>
                                        <small class="form-text text-muted">Square feet measurement</small>
                                        @error('sqft')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                                    </div>
                                    
                                    <div class="form-group col-md-4">
                                        <label class="text-capitalize">Area (SqM)</label>
                                        <input class="form-control" type="text" id="sqm" value="{{ number_format($floor->sqm, 2) }} m²" readonly disabled>
                                        <small class="form-text text-muted">Auto-calculated from SqFt</small>
                                    </div>
                                    
                                    <div class="form-group col-md-4">
                                        <label class="text-capitalize">Count <span class="text-danger">*</span></label>
                                        <input class="form-control" value="{{old('count', $floor->count)}}" type="number" name="count" min="1" required>
                                        <small class="form-text text-muted">Number of floors</small>
                                        @error('count')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Images -->
                            <div class="form-section">
                                <h5 class="section-title"><i class="fa fa-image"></i> Floor Images</h5>
                                
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class="text-capitalize">2D Image</label>
                                        <input accept="image/*" class="form-control dropify" type="file" name="image_2d" 
                                            data-default-file="{{ $floor->image_2d ? asset('storage' . $floor->image_2d) : '' }}">
                                        <small class="form-text text-muted">Optional 2D floor plan image (870px x 420px)</small>
                                        @error('image_2d')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                                    </div>
                                    
                                    <div class="form-group col-md-6">
                                        <label class="text-capitalize">3D Image</label>
                                        <input accept="image/*" class="form-control dropify" type="file" name="image_3d" 
                                            data-default-file="{{ $floor->image_3d ? asset('storage' . $floor->image_3d) : '' }}">
                                        <small class="form-text text-muted">3D floor visualization - leave empty to keep current (870px x 420px)</small>
                                        @error('image_3d')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Submit Buttons -->
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-save"></i> Update Floor
                                    </button>
                                    <a href="{{ route('offer.floor.index', ['offerId' => $offer->id]) }}" class="btn btn-secondary">
                                        <i class="fa fa-times"></i> Cancel
                                    </a>
                                </div>
                            </div>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('/js/auto-translate.js') }}"></script>
<script src="{{asset('/js/dropify.min.js')}}"></script>
<script>
    $(document).ready(function() {
        // Initialize Dropify
        $('.dropify').dropify();
        
        // Auto-calculate SqM from SqFt
        $('#sqft').on('input', function() {
            var sqft = parseFloat($(this).val()) || 0;
            var sqm = sqft * 0.092903;
            $('#sqm').val(sqm.toFixed(2) + ' m²');
        });
        
        // Load floor components when building component is selected
        $('#building_component_id').on('change', function() {
            var buildingComponentId = $(this).val();
            var floorComponentSelect = $('#floor_component_id');
            var currentFloorComponentId = '{{ old("floor_component_id", $floor->floor_component_id) }}';
            
            if (buildingComponentId) {
                floorComponentSelect.html('<option value="">Loading...</option>');
                
                $.ajax({
                    url: '{{ route("offer.floor.get-floor-components", ["offerId" => $offer->id]) }}',
                    type: 'GET',
                    data: {
                        building_component_id: buildingComponentId
                    },
                    success: function(response) {
                        floorComponentSelect.html('<option value="">Select Floor Component</option>');
                        
                        if (response && response.length > 0) {
                            $.each(response, function(index, component) {
                                var selected = (component.id == currentFloorComponentId) ? 'selected' : '';
                                floorComponentSelect.append(
                                    '<option value="' + component.id + '" ' + selected + '>' + 
                                    component.name_english + ' - ' + component.name_arabic + 
                                    '</option>'
                                );
                            });
                        } else {
                            floorComponentSelect.html('<option value="">No floor components available</option>');
                        }
                    },
                    error: function() {
                        floorComponentSelect.html('<option value="">Error loading components</option>');
                    }
                });
            } else {
                floorComponentSelect.html('<option value="">Select Building Component First</option>');
            }
        });
    });
</script>
@endsection

