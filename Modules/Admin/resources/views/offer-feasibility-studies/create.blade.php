@extends('admin::layouts.master')
@section('title', 'Create Offer Feasibility Study')

@section('css')
<style>
    .study-type-card {
        border: 2px solid #e3e6f0;
        border-radius: 10px;
        padding: 20px;
        cursor: pointer;
        transition: all 0.3s;
        text-align: center;
        height: 100%;
    }
    .study-type-card:hover {
        border-color: #4e73df;
        box-shadow: 0 0 15px rgba(78, 115, 223, 0.3);
        transform: translateY(-3px);
    }
    .study-type-card.selected {
        border-color: #4e73df;
        background-color: #f8f9fc;
    }
    .study-type-icon {
        font-size: 3rem;
        margin-bottom: 15px;
    }
    .component-override-section {
        background: #f8f9fc;
        border: 1px solid #e3e6f0;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
    }
    .cost-input {
        width: 150px;
        display: inline-block;
    }
</style>
@endsection

@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Admin')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a href="{{route('offer.show', ['id' => $offer->id])}}" class="breadcrumbs__item"><i class="fa fa-tag"></i> {{ $offer->title_english }}</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-plus"></i> Create Feasibility Study</a>
        </nav>

        <div class="col-lg-12">
            <hr>
            
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fa fa-times-circle"></i> {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            
            <form action="{{ route('offer-feasibility-study.store') }}" method="POST">
                @csrf
                <input type="hidden" name="offer_id" value="{{ $offer->id }}">
                
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4"><i class="fa fa-info-circle"></i> Study Information</h4>
                        
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="study_name">Study Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="study_name" name="study_name" 
                                           value="{{ old('study_name') }}" required>
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="emirate_id">Emirate <span class="text-danger">*</span></label>
                                    <select class="form-control" id="emirate_id" name="emirate_id" required>
                                        <option value="">Select Emirate</option>
                                        @foreach($offerPrices as $price)
                                            <option value="{{ $price->emirate_id }}" 
                                                    data-price="{{ $price->price }}"
                                                    {{ old('emirate_id') == $price->emirate_id ? 'selected' : '' }}>
                                                {{ $price->emirate_name_en }} - {{ number_format($price->price, 2) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="form-text text-muted">Select the emirate to base calculations on</small>
                                </div>
                            </div>
                            
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="currency_id">Currency</label>
                                    <select class="form-control" id="currency_id" name="currency_id">
                                        <option value="">Select Currency</option>
                                        @foreach($currencies as $currency)
                                            <option value="{{ $currency->id }}" {{ old('currency_id') == $currency->id ? 'selected' : '' }}>
                                                {{ $currency->name_english }} ({{ $currency->abbreviation }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="status">Status <span class="text-danger">*</span></label>
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="Draft" {{ old('status') == 'Draft' ? 'selected' : '' }}>Draft</option>
                                        <option value="Active" {{ old('status') == 'Active' ? 'selected' : '' }}>Active</option>
                                        <option value="Archived" {{ old('status') == 'Archived' ? 'selected' : '' }}>Archived</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Selected Emirate Price</label>
                                    <div class="form-control-plaintext">
                                        <h4 class="text-success mb-0" id="selected_price">--</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                        </div>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4"><i class="fa fa-cogs"></i> Study Type</h4>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="study-type-card" data-type="Master">
                                    <div class="study-type-icon">
                                        <i class="fa fa-star text-warning"></i>
                                    </div>
                                    <h5><strong>Master Study</strong></h5>
                                    <p class="text-muted">Uses original offer data without modifications</p>
                                    <input type="radio" name="study_type" value="Master" id="type_master" class="d-none" {{ old('study_type', 'Master') == 'Master' ? 'checked' : '' }}>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="study-type-card" data-type="Custom">
                                    <div class="study-type-icon">
                                        <i class="fa fa-edit text-primary"></i>
                                    </div>
                                    <h5><strong>Custom Study</strong></h5>
                                    <p class="text-muted">Modify component values for custom analysis</p>
                                    <input type="radio" name="study_type" value="Custom" id="type_custom" class="d-none" {{ old('study_type') == 'Custom' ? 'checked' : '' }}>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Custom Study Options (shown only if Custom is selected) -->
                <div id="custom-options" style="display: none;">
                    
                    <!-- Building Components Override -->
                    @if($offerFloors && $offerFloors->count() > 0)
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4"><i class="fa fa-cube"></i> Building Components Cost Override</h4>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Building Component</th>
                                            <th>Current Cost (per SQFT)</th>
                                            <th>New Cost (optional)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $buildingComponents = collect($offerFloors)->groupBy('building_component_id');
                                            // Get building component costs from offer_building_components
                                            $bcCosts = DB::table('offer_building_components')
                                                ->where('offer_id', $offer->id)
                                                ->whereNull('deleted_at')
                                                ->pluck('construction_cost', 'building_component_id');
                                        @endphp
                                        @foreach($buildingComponents as $bcId => $floors)
                                            @php
                                                $firstFloor = $floors->first();
                                                $currentCost = $bcCosts->get($bcId, 0);
                                            @endphp
                                            <tr>
                                                <td>{{ $firstFloor->building_component_name_en }}</td>
                                                <td><strong>{{ number_format($currentCost, 2) }}</strong></td>
                                                <td>
                                                    <input type="number" step="0.01" class="form-control cost-input" 
                                                           name="building_cost_{{ $bcId }}" 
                                                           placeholder="Leave empty to use current">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    <!-- Length Components Override -->
                    @if($offerLengthComponents && $offerLengthComponents->count() > 0)
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4"><i class="mdi mdi-ruler"></i> Length Components Cost Override</h4>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Length Component</th>
                                            <th>Current Unit Cost</th>
                                            <th>New Unit Cost (optional)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($offerLengthComponents as $lc)
                                            <tr>
                                                <td>{{ $lc->length_component_name_english }}</td>
                                                <td><strong>{{ number_format($lc->unit_cost, 2) }}</strong></td>
                                                <td>
                                                    <input type="number" step="0.01" class="form-control cost-input" 
                                                           name="length_cost_{{ $lc->length_component_id }}" 
                                                           placeholder="Leave empty to use current">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    <!-- Income Components Override -->
                    @if($offerIncomeComponents && $offerIncomeComponents->count() > 0)
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4"><i class="fa fa-dollar"></i> Income Components Override</h4>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Income Component</th>
                                            <th>Current Units</th>
                                            <th>Current Rent/Year</th>
                                            <th>New Units (optional)</th>
                                            <th>New Rent/Year (optional)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($offerIncomeComponents as $ic)
                                            <tr>
                                                <td>{{ $ic->name_english }}</td>
                                                <td><strong>{{ $ic->number_of_units }}</strong></td>
                                                <td><strong>{{ number_format($ic->rent_per_year, 2) }}</strong></td>
                                                <td>
                                                    <input type="number" class="form-control cost-input" 
                                                           name="income_units_{{ $ic->income_component_id }}" 
                                                           placeholder="Leave empty">
                                                </td>
                                                <td>
                                                    <input type="number" step="0.01" class="form-control cost-input" 
                                                           name="income_rent_{{ $ic->income_component_id }}" 
                                                           placeholder="Leave empty">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    <!-- Construction Costs Override -->
                    @if($offerConstructionCosts && $offerConstructionCosts->count() > 0)
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4"><i class="fa fa-calculator"></i> Construction Costs Override</h4>
                            @foreach($offerConstructionCosts as $cc)
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Substation Room Cost</label>
                                        <div class="input-group">
                                            <input type="number" step="0.01" class="form-control" name="substation_cost" 
                                                   placeholder="Enter custom cost (optional)">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="fa fa-info-circle" title="Current: {{ $cc->substation_price ?? 'N/A' }}"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Pumps Room Cost</label>
                                        <div class="input-group">
                                            <input type="number" step="0.01" class="form-control" name="pumps_cost" 
                                                   placeholder="Enter custom cost (optional)">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="fa fa-info-circle" title="Current: {{ $cc->pumps_price ?? 'N/A' }}"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
                
                <!-- Project Costs (always shown for custom study) -->
                <div id="project-costs-section">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4"><i class="fa fa-money"></i> Project Costs</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="land_cost">Land Cost</label>
                                        <input type="number" step="0.01" class="form-control" id="land_cost" 
                                               name="land_cost" value="{{ old('land_cost', 0) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="consultant_cost">Consultant Cost</label>
                                        <input type="number" step="0.01" class="form-control" id="consultant_cost" 
                                               name="consultant_cost" value="{{ old('consultant_cost', 0) }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="government_fees">Government Fees</label>
                                        <input type="number" step="0.01" class="form-control" id="government_fees" 
                                               name="government_fees" value="{{ old('government_fees', 0) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="additional_fees">Additional Fees</label>
                                        <input type="number" step="0.01" class="form-control" id="additional_fees" 
                                               name="additional_fees" value="{{ old('additional_fees', 0) }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn btn-success btn-lg">
                        <i class="fa fa-check"></i> Create Feasibility Study
                    </button>
                    <a href="{{ route('offer.show', ['id' => $offer->id]) }}" class="btn btn-secondary btn-lg">
                        <i class="fa fa-times"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        // Emirate selection - show price
        $('#emirate_id').on('change', function() {
            const selectedOption = $(this).find('option:selected');
            const price = selectedOption.data('price');
            if (price) {
                $('#selected_price').text(number_format(price, 2));
            } else {
                $('#selected_price').text('--');
            }
        });
        
        // Trigger on page load if value is selected
        if ($('#emirate_id').val()) {
            $('#emirate_id').trigger('change');
        }
        
        // Study type selection
        $('.study-type-card').on('click', function() {
            const type = $(this).data('type');
            $('.study-type-card').removeClass('selected');
            $(this).addClass('selected');
            $(`#type_${type.toLowerCase()}`).prop('checked', true);
            
            // Show/hide custom options
            if (type === 'Custom') {
                $('#custom-options').slideDown();
            } else {
                $('#custom-options').slideUp();
            }
        });
        
        // Set initial state
        const selectedType = $('input[name="study_type"]:checked').val();
        $(`.study-type-card[data-type="${selectedType}"]`).addClass('selected');
        if (selectedType === 'Custom') {
            $('#custom-options').show();
        }
    });
    
    // Helper function to format numbers
    function number_format(number, decimals) {
        return parseFloat(number).toFixed(decimals).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
</script>
@endsection

