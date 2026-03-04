@extends('admin::layouts.master')
@section('title', 'Add Specification - ' . $offer->title_english)

@section('css')
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
    
    .spec-preview {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px;
        background: #f8f9fa;
        border-radius: 6px;
        margin-top: 10px;
    }
    
    .spec-preview-icon {
        width: 40px;
        height: 40px;
        object-fit: contain;
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
            <a href="{{route('offer.floor.show', ['offerId' => $offer->id, 'id' => $floor->id])}}" class="breadcrumbs__item"><i class="fa fa-eye"></i> Floor Details</a>
            <a href="{{route('offer.floor.specification.index', ['offerId' => $offer->id, 'floorId' => $floor->id])}}" class="breadcrumbs__item"><i class="fa fa-list"></i> Specifications</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-plus"></i> Add Specification</a>
        </nav>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="mt-0 header-title">
                            <i class="fa fa-plus"></i> Add New Specification
                        </h4>
                        <p class="text-muted mb-4">Add a specification to this floor</p>
                        <hr>
                        
                        @if($availableSpecifications->count() == 0)
                            <div class="alert alert-warning">
                                <i class="fa fa-exclamation-triangle"></i> 
                                <strong>Warning:</strong> No active specifications are available for this offer type. 
                                Please add specifications in the Basic Data section first.
                            </div>
                        @else
                            <form action="{{ route('offer.floor.specification.store', ['offerId' => $offer->id, 'floorId' => $floor->id]) }}" method="POST">
                                @csrf
                                <button type="button" class="btn btn-translate-all mb-3" id="translateAllBtn"><i class="fa fa-language"></i> Translate All</button>
                                
                                <!-- Specification Selection -->
                                <div class="form-section">
                                    <h5 class="section-title"><i class="fa fa-list"></i> Specification</h5>
                                    
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label class="text-capitalize">Specification <span class="text-danger">*</span></label>
                                            <select class="form-control select2" name="specification_id" id="specification_id" required style="width: 100%;">
                                                <option value="">Select Specification</option>
                                                @foreach($availableSpecifications as $spec)
                                                    <option value="{{ $spec->id }}" 
                                                        data-icon="{{ $spec->icon }}"
                                                        data-title-en="{{ $spec->title_english }}"
                                                        data-title-ar="{{ $spec->title_arabic }}"
                                                        {{ old('specification_id') == $spec->id ? 'selected' : '' }}>
                                                        {{ $spec->title_english }} - {{ $spec->title_arabic }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <small class="form-text text-muted">Select the specification type</small>
                                            @error('specification_id')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                                            
                                            <div id="spec-preview" style="display: none;" class="spec-preview">
                                                <img id="spec-preview-icon" src="" alt="Icon" class="spec-preview-icon">
                                                <div>
                                                    <div id="spec-preview-title-en" style="font-weight: 600;"></div>
                                                    <small id="spec-preview-title-ar" class="text-muted"></small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Values -->
                                <div class="form-section">
                                    <h5 class="section-title"><i class="fa fa-pencil"></i> Values</h5>
                                    
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label class="text-capitalize">Value (English) <span class="text-danger">*</span></label>
                                            <input class="form-control" value="{{old('value_english')}}" type="text" name="value_english" required>
                                            <small class="form-text text-muted">Enter the specification value in English</small>
                                            @error('value_english')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                                        </div>
                                        
                                        <div class="form-group col-md-6">
                                            <label class="text-capitalize">Value (Arabic) <span class="text-danger">*</span> <button type="button" class="auto-translate-btn" data-translate-source="value_english" data-translate-target="value_arabic"><i class="fa fa-language"></i> Auto</button></label>
                                            <input class="form-control" value="{{old('value_arabic')}}" type="text" name="value_arabic" dir="rtl" required>
                                            <small class="form-text text-muted">Enter the specification value in Arabic</small>
                                            @error('value_arabic')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Submit Buttons -->
                                <div class="row mt-4">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-save"></i> Save Specification
                                        </button>
                                        <a href="{{ route('offer.floor.specification.index', ['offerId' => $offer->id, 'floorId' => $floor->id]) }}" class="btn btn-secondary">
                                            <i class="fa fa-times"></i> Cancel
                                        </a>
                                    </div>
                                </div>
                            </form>
                        @endif
                        
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('/js/auto-translate.js') }}"></script>
<script>
    $(document).ready(function() {
        // Show specification preview when selected
        $('#specification_id').on('change', function() {
            var selectedOption = $(this).find('option:selected');
            var icon = selectedOption.data('icon');
            var titleEn = selectedOption.data('title-en');
            var titleAr = selectedOption.data('title-ar');
            
            if (selectedOption.val()) {
                $('#spec-preview').show();
                if (icon) {
                    $('#spec-preview-icon').attr('src', '{{ asset("storage") }}' + icon).show();
                } else {
                    $('#spec-preview-icon').hide();
                }
                $('#spec-preview-title-en').text(titleEn);
                $('#spec-preview-title-ar').text(titleAr);
            } else {
                $('#spec-preview').hide();
            }
        });
        
        // Trigger change if there's an old value
        @if(old('specification_id'))
            $('#specification_id').trigger('change');
        @endif
    });
</script>
@endsection

