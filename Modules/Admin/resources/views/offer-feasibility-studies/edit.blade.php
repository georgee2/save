@extends('admin::layouts.master')
@section('title', 'Edit Offer Feasibility Study')

@section('css')
<style>
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
            <a href="{{route('offer-feasibility-study.show', ['id' => $study->id])}}" class="breadcrumbs__item"><i class="fa fa-chart-line"></i> {{ $study->study_name }}</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-pencil"></i> Edit Study</a>
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
            
            <form action="{{ route('offer-feasibility-study.update', ['id' => $study->id]) }}" method="POST">
                @csrf
                
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4"><i class="fa fa-info-circle"></i> Study Information</h4>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Study Type</label>
                                    <div class="form-control-plaintext">
                                        @if($study->study_type == 'Master')
                                            <span class="badge badge-warning"><i class="fa fa-star"></i> Master Study</span>
                                        @else
                                            <span class="badge badge-primary"><i class="fa fa-edit"></i> Custom Study</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="study_name">Study Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="study_name" name="study_name" 
                                           value="{{ old('study_name', $study->study_name) }}" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="currency_id">Currency</label>
                                    <select class="form-control" id="currency_id" name="currency_id">
                                        <option value="">Select Currency</option>
                                        @foreach($currencies as $currency)
                                            <option value="{{ $currency->id }}" {{ old('currency_id', $study->currency_id) == $currency->id ? 'selected' : '' }}>
                                                {{ $currency->name_english }} ({{ $currency->abbreviation }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="status">Status <span class="text-danger">*</span></label>
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="Draft" {{ old('status', $study->status) == 'Draft' ? 'selected' : '' }}>Draft</option>
                                        <option value="Active" {{ old('status', $study->status) == 'Active' ? 'selected' : '' }}>Active</option>
                                        <option value="Archived" {{ old('status', $study->status) == 'Archived' ? 'selected' : '' }}>Archived</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $study->description) }}</textarea>
                        </div>
                    </div>
                </div>
                
                @if($study->study_type == 'Custom')
                
                <!-- Building Components -->
                @if($studyBuildingComponents && $studyBuildingComponents->count() > 0)
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4"><i class="fa fa-cube"></i> Building Components Cost</h4>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Component Name</th>
                                        <th>Current Cost per SQFT</th>
                                        <th>New Cost</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($studyBuildingComponents as $bc)
                                    <tr>
                                        <td>{{ $bc->name_english }}</td>
                                        <td><strong>{{ number_format($bc->construction_cost, 2) }}</strong></td>
                                        <td>
                                            <input type="number" step="0.01" class="form-control cost-input" 
                                                   name="building_costs[{{ $bc->id }}]" 
                                                   value="{{ $bc->construction_cost }}">
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif
                
                <!-- Length Components -->
                @if($studyLengthComponents && $studyLengthComponents->count() > 0)
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4"><i class="mdi mdi-ruler"></i> Length Components Unit Cost</h4>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Component Name</th>
                                        <th>Current Unit Cost</th>
                                        <th>New Unit Cost</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($studyLengthComponents as $lc)
                                    <tr>
                                        <td>{{ $lc->length_name_en }}</td>
                                        <td><strong>{{ number_format($lc->unit_cost, 2) }}</strong></td>
                                        <td>
                                            <input type="number" step="0.01" class="form-control cost-input" 
                                                   name="length_costs[{{ $lc->id }}]" 
                                                   value="{{ $lc->unit_cost }}">
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif
                
                <!-- Income Components -->
                @if($studyIncomeComponents && $studyIncomeComponents->count() > 0)
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4"><i class="fa fa-dollar"></i> Income Components</h4>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Component Name</th>
                                        <th>Number of Units</th>
                                        <th>Rent per Year</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($studyIncomeComponents as $ic)
                                    <tr>
                                        <td>{{ $ic->name_english }}</td>
                                        <td>
                                            <input type="number" class="form-control cost-input" 
                                                   name="income_units[{{ $ic->id }}]" 
                                                   value="{{ $ic->number_of_units }}">
                                        </td>
                                        <td>
                                            <input type="number" step="0.01" class="form-control cost-input" 
                                                   name="income_rents[{{ $ic->id }}]" 
                                                   value="{{ $ic->rent_per_year }}">
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif
                
                <!-- Construction Costs -->
                @if($studyConstructionCost)
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4"><i class="fa fa-calculator"></i> Construction Costs</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Substation Room Cost</label>
                                    <input type="number" step="0.01" class="form-control" name="substation_cost" 
                                           value="{{ old('substation_cost', $studyConstructionCost->substation_cost) }}">
                                    <small class="text-muted">{{ $studyConstructionCost->substation_name_en ?? 'Substation Room' }}</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Pumps Room Cost</label>
                                    <input type="number" step="0.01" class="form-control" name="pumps_cost" 
                                           value="{{ old('pumps_cost', $studyConstructionCost->pumps_cost) }}">
                                    <small class="text-muted">{{ $studyConstructionCost->pumps_name_en ?? 'Pumps Room' }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                
                <!-- Project Costs -->
                @if($studyProjectCost)
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4"><i class="fa fa-money"></i> Project Costs</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="land_cost">Land Cost</label>
                                    <input type="number" step="0.01" class="form-control" id="land_cost" 
                                           name="land_cost" value="{{ old('land_cost', $studyProjectCost->land_cost) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="consultant_cost">Consultant Cost</label>
                                    <input type="number" step="0.01" class="form-control" id="consultant_cost" 
                                           name="consultant_cost" value="{{ old('consultant_cost', $studyProjectCost->consultant_cost) }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="government_fees">Government Fees</label>
                                    <input type="number" step="0.01" class="form-control" id="government_fees" 
                                           name="government_fees" value="{{ old('government_fees', $studyProjectCost->government_fees) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="additional_fees">Additional Fees</label>
                                    <input type="number" step="0.01" class="form-control" id="additional_fees" 
                                           name="additional_fees" value="{{ old('additional_fees', $studyProjectCost->additional_fees) }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                
                @else
                    <div class="alert alert-info">
                        <i class="fa fa-info-circle"></i> This is a Master Study. Component values cannot be modified. 
                        Create a Custom Study to modify values.
                    </div>
                @endif
                
                <div class="form-group">
                    <button type="submit" class="btn btn-success btn-lg">
                        <i class="fa fa-check"></i> Update Feasibility Study
                    </button>
                    <a href="{{ route('offer-feasibility-study.show', ['id' => $study->id]) }}" class="btn btn-secondary btn-lg">
                        <i class="fa fa-times"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

