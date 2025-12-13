@extends('admin::layouts.master')
@section('title', 'Feasibility Study Report')

@section('css')
<!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<!-- Animate.css for animations -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<style>
    :root {
        --main-color: #cc2637;
        --secondary-color: #fc9534;
    }
    .study-header {
        background: linear-gradient(135deg, var(--main-color) 0%, var(--secondary-color) 100%);
        color: white;
        padding: 30px;
        border-radius: 10px;
        margin-bottom: 30px;
    }
    .calculation-section {
        background: #fff;
        border: 1px solid #e3e6f0;
        border-radius: 8px;
        padding: 25px;
        margin-bottom: 25px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    .section-header {
        border-bottom: 3px solid var(--main-color);
        padding-bottom: 10px;
        margin-bottom: 20px;
    }
    .calculation-table {
        width: 100%;
        margin-bottom: 0;
    }
    .calculation-table th {
        background-color: #f8f9fc;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
    }
    .total-row {
        background-color: #f8f9fc;
        font-weight: bold;
        font-size: 1.1rem;
    }
    .grand-total-row {
        background: linear-gradient(135deg, var(--main-color) 0%, var(--secondary-color) 100%);
        color: white;
        font-weight: bold;
        font-size: 1.2rem;
    }
    .cost-badge {
        background: linear-gradient(135deg, var(--main-color) 0%, var(--secondary-color) 100%);
        color: white;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 1rem;
        font-weight: 600;
    }
    .income-badge {
        background-color: #1cc88a;
        color: white;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 1rem;
        font-weight: 600;
    }
    .summary-card {
        border: 2px solid var(--main-color);
        border-radius: 10px;
        padding: 20px;
        text-align: center;
        margin-bottom: 20px;
    }
    .summary-label {
        font-size: 0.9rem;
        text-transform: uppercase;
        color: #858796;
        font-weight: 600;
        margin-bottom: 10px;
    }
    .summary-value {
        font-size: 2rem;
        font-weight: bold;
        color: var(--main-color);
    }
    @media print {
        .no-print {
            display: none !important;
        }
        .calculation-section {
            page-break-inside: avoid;
        }
    }
</style>
@endsection

@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs no-print">
            <a href="{{route('Admin')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a href="{{route('feasibility-study.index')}}" class="breadcrumbs__item"><i class="fa fa-chart-line"></i> Feasibility Studies</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-eye"></i> Study Report</a>
        </nav>

        <div class="col-lg-12">
            <hr class="no-print">
            
            <!-- Study Header -->
            <div class="study-header">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h2 class="mb-2">
                            @if($study->study_type == 'Master')
                                <i class="fa fa-star"></i>
                            @else
                                <i class="fa fa-edit"></i>
                            @endif
                            {{ $study->study_name }}
                        </h2>
                        <h5 class="mb-3">{{ $study->project_name_en }}</h5>
                        <p class="mb-0">
                            <i class="fa fa-user"></i> Created by: {{ $study->creator_name ?? 'N/A' }} | 
                            <i class="fa fa-calendar"></i> {{ \Carbon\Carbon::parse($study->created_at)->format('F d, Y') }}
                            @if(isset($study->currency_name))
                                | <i class="fa fa-money"></i> Currency: {{ $study->currency_name }} ({{ $study->currency_abbreviation }})
                            @endif
                        </p>
                    </div>
                    <div class="col-md-4 text-right">
                        <span class="badge badge-light" style="font-size: 1.2rem; padding: 10px 20px;">
                            @if($study->status == 'Active')
                                <i class="fa fa-check-circle text-success"></i> Active
                            @elseif($study->status == 'Draft')
                                <i class="fa fa-file text-warning"></i> Draft
                            @else
                                <i class="fa fa-archive text-secondary"></i> Archived
                            @endif
                        </span>
                    </div>
                </div>
                @if($study->description)
                <div class="row mt-3">
                    <div class="col-12">
                        <p class="mb-0"><strong>Description:</strong> {{ $study->description }}</p>
                    </div>
                </div>
                @endif
            </div>
            
            <!-- Action Buttons -->
            <div class="mb-4 no-print">
                <a href="{{ route('feasibility-study.edit', ['id' => $study->id]) }}" class="btn btn-warning">
                    <i class="fa fa-pencil"></i> Edit Study
                </a>
                <form action="{{ route('feasibility-study.duplicate', ['id' => $study->id]) }}" method="POST" style="display:inline;" id="duplicateForm">
                    @csrf
                    <button type="button" class="btn btn-secondary" onclick="confirmDuplicate()">
                        <i class="fa fa-copy"></i> Duplicate Study
                    </button>
                </form>
                <button onclick="window.print()" class="btn btn-info">
                    <i class="fa fa-print"></i> Print Report
                </button>
                <a href="{{ route('project.show', ['id' => $study->project_id]) }}" class="btn btn-primary">
                    <i class="fa fa-building"></i> Back to Project
                </a>
            </div>
            
            <!-- Building Components Section -->
            @if(isset($calculations['building_components']) && $calculations['building_components']['header'])
            <div class="calculation-section">
                <div class="section-header">
                    <h4 class="mb-0">
                        <i class="fa fa-cube text-primary"></i> 
                        {{ $calculations['building_components']['header']->header_english }}
                    </h4>
                </div>
                
                @if(count($calculations['building_components']['items']) > 0)
                    @foreach($calculations['building_components']['items'] as $item)
                    <div class="mb-4">
                        <h5 class="text-primary">
                            <i class="{{ $item['component']->icon }}"></i> 
                            {{ $item['component']->name_english }}
                        </h5>
                        <div class="table-responsive">
                            <table class="table table-bordered calculation-table">
                                <thead>
                                    <tr>
                                        <th>Floor Type</th>
                                        <th>SQFT</th>
                                        <th>Count</th>
                                        <th>Total Area (SQFT)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($item['floors'] as $floor)
                                    <tr>
                                        <td>{{ $floor->floor_name }}</td>
                                        <td>{{ number_format($floor->sqft, 2) }}</td>
                                        <td>{{ $floor->count }}</td>
                                        <td>{{ number_format($floor->total_area, 2) }}</td>
                                    </tr>
                                    @endforeach
                                    <tr class="total-row">
                                        <td colspan="3" class="text-right">Total Build Area:</td>
                                        <td>{{ number_format($item['total_build_area'], 2) }} SQFT</td>
                                    </tr>
                                    <tr class="grand-total-row">
                                        <td colspan="3" class="text-right">Total Cost:</td>
                                        <td>{{ number_format($item['total_cost'], 2) }} @if(isset($study->currency_abbreviation))<small>{{ $study->currency_abbreviation }}</small>@endif</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endforeach
                    
                    <div class="text-right">
                        <h4>
                            <span class="cost-badge">
                                Total Building Components Cost: {{ number_format($calculations['building_components']['total'], 2) }} @if(isset($study->currency_abbreviation)){{ $study->currency_abbreviation }}@endif
                            </span>
                        </h4>
                    </div>
                @else
                    <p class="text-muted">No building components data available.</p>
                @endif
            </div>
            @endif
            
            <!-- Length Components Section -->
            @if(isset($calculations['length_components']) && $calculations['length_components']['header'])
            <div class="calculation-section">
                <div class="section-header">
                    <h4 class="mb-0">
                        <i class="mdi mdi-ruler text-warning"></i> 
                        {{ $calculations['length_components']['header']->header_english }}
                    </h4>
                </div>
                
                @if(count($calculations['length_components']['items']) > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered calculation-table">
                            <thead>
                                <tr>
                                    <th>Component Name</th>
                                    <th>Length</th>
                                    <th>Count</th>
                                    <th>Total Length</th>
                                    <th>Unit Cost</th>
                                    <th>Total Cost</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($calculations['length_components']['items'] as $item)
                                <tr>
                                    <td>
                                        <i class="{{ $item['component']->icon }}"></i> 
                                        {{ $item['component']->length_component_name_en }}
                                    </td>
                                    <td>{{ number_format($item['length'], 2) }}</td>
                                    <td>{{ $item['count'] }}</td>
                                    <td>{{ number_format($item['total_length'], 2) }}</td>
                                    <td>{{ number_format($item['component']->unit_cost, 2) }} @if(isset($study->currency_abbreviation))<small>{{ $study->currency_abbreviation }}</small>@endif</td>
                                    <td>{{ number_format($item['total_cost'], 2) }} @if(isset($study->currency_abbreviation))<small>{{ $study->currency_abbreviation }}</small>@endif</td>
                                </tr>
                                @endforeach
                                <tr class="grand-total-row">
                                    <td colspan="5" class="text-right">Total Cost:</td>
                                    <td>{{ number_format($calculations['length_components']['total'], 2) }} @if(isset($study->currency_abbreviation))<small>{{ $study->currency_abbreviation }}</small>@endif</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted">No length components data available.</p>
                @endif
            </div>
            @endif
            
            <!-- Construction Costs Section -->
            @if(isset($calculations['construction_costs']) && $calculations['construction_costs']['header'])
            <div class="calculation-section">
                <div class="section-header">
                    <h4 class="mb-0">
                        <i class="fa fa-calculator text-danger"></i> 
                        {{ $calculations['construction_costs']['header']->header_english }}
                    </h4>
                </div>
                
                @php
                    // Calculate Main Contractor Cost (Building + Length Components)
                    $mainContractorCost = ($calculations['building_components']['total'] ?? 0) + 
                                         ($calculations['length_components']['total'] ?? 0);
                    $totalConstructionCosts = $mainContractorCost + 
                                             ($calculations['construction_costs']['substation_cost'] ?? 0) + 
                                             ($calculations['construction_costs']['pumps_cost'] ?? 0);
                @endphp
                
                <div class="table-responsive">
                    <table class="table table-bordered calculation-table">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Cost</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <i class="fa fa-building"></i> 
                                    Main Contractor Cost
                                </td>
                                <td>{{ number_format($mainContractorCost, 2) }} @if(isset($study->currency_abbreviation))<small>{{ $study->currency_abbreviation }}</small>@endif</td>
                            </tr>
                            
                            @if($calculations['construction_costs']['substation_cost'] > 0)
                            <tr>
                                <td>
                                    <i class="fa fa-plug"></i> 
                                    {{ $calculations['construction_costs']['substation_name'] ?? 'Substation Room' }}
                                </td>
                                <td>{{ number_format($calculations['construction_costs']['substation_cost'], 2) }} @if(isset($study->currency_abbreviation))<small>{{ $study->currency_abbreviation }}</small>@endif</td>
                            </tr>
                            @endif
                            
                            @if($calculations['construction_costs']['pumps_cost'] > 0)
                            <tr>
                                <td>
                                    <i class="fa fa-tint"></i> 
                                    {{ $calculations['construction_costs']['pumps_name'] ?? 'Pumps Room' }}
                                </td>
                                <td>{{ number_format($calculations['construction_costs']['pumps_cost'], 2) }} @if(isset($study->currency_abbreviation))<small>{{ $study->currency_abbreviation }}</small>@endif</td>
                            </tr>
                            @endif
                            
                            <tr class="grand-total-row">
                                <td class="text-right">Total Construction Costs:</td>
                                <td>{{ number_format($totalConstructionCosts, 2) }} @if(isset($study->currency_abbreviation))<small>{{ $study->currency_abbreviation }}</small>@endif</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
            
            <!-- Project Costs Section -->
            @if(isset($calculations['project_costs']) && $calculations['project_costs']['header'])
            <div class="calculation-section">
                <div class="section-header">
                    <h4 class="mb-0">
                        <i class="fa fa-money text-success"></i> 
                        {{ $calculations['project_costs']['header']->header_english }}
                    </h4>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-bordered calculation-table">
                        <thead>
                            <tr>
                                <th>Cost Category</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><i class="fa fa-wrench"></i> Total Construction Cost</td>
                                <td>{{ number_format($calculations['project_costs']['construction_cost'], 2) }} @if(isset($study->currency_abbreviation))<small>{{ $study->currency_abbreviation }}</small>@endif</td>
                            </tr>
                            <tr>
                                <td><i class="fa fa-map"></i> Land Cost</td>
                                <td>{{ number_format($calculations['project_costs']['land_cost'], 2) }} @if(isset($study->currency_abbreviation))<small>{{ $study->currency_abbreviation }}</small>@endif</td>
                            </tr>
                            <tr>
                                <td><i class="fa fa-user-tie"></i> Consultant Cost</td>
                                <td>{{ number_format($calculations['project_costs']['consultant_cost'], 2) }} @if(isset($study->currency_abbreviation))<small>{{ $study->currency_abbreviation }}</small>@endif</td>
                            </tr>
                            <tr>
                                <td><i class="fa fa-gavel"></i> Government Fees</td>
                                <td>{{ number_format($calculations['project_costs']['government_fees'], 2) }} @if(isset($study->currency_abbreviation))<small>{{ $study->currency_abbreviation }}</small>@endif</td>
                            </tr>
                            <tr>
                                <td><i class="fa fa-plus-circle"></i> Additional Fees</td>
                                <td>{{ number_format($calculations['project_costs']['additional_fees'], 2) }} @if(isset($study->currency_abbreviation))<small>{{ $study->currency_abbreviation }}</small>@endif</td>
                            </tr>
                            <tr class="grand-total-row">
                                <td class="text-right"><strong>TOTAL PROJECT COST:</strong></td>
                                <td><strong>{{ number_format($calculations['project_costs']['total'], 2) }} @if(isset($study->currency_abbreviation))<small>{{ $study->currency_abbreviation }}</small>@endif</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
            
            <!-- Income Components Section -->
            @if(isset($calculations['income_components']) && $calculations['income_components']['header'])
            <div class="calculation-section">
                <div class="section-header">
                    <h4 class="mb-0">
                        <i class="fa fa-dollar text-success"></i> 
                        {{ $calculations['income_components']['header']->header_english }}
                    </h4>
                </div>
                
                @if(count($calculations['income_components']['items']) > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered calculation-table">
                            <thead>
                                <tr>
                                    <th>Component Name</th>
                                    <th>Number of Units</th>
                                    <th>Rent per Year</th>
                                    <th>Total Income</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($calculations['income_components']['items'] as $item)
                                <tr>
                                    <td>
                                        <i class="{{ $item['component']->icon }}"></i> 
                                        {{ $item['component']->name_english }}
                                    </td>
                                    <td>{{ number_format($item['component']->number_of_units) }}</td>
                                    <td>{{ number_format($item['component']->rent_per_year, 2) }} @if(isset($study->currency_abbreviation))<small>{{ $study->currency_abbreviation }}</small>@endif</td>
                                    <td>{{ number_format($item['total_income'], 2) }} @if(isset($study->currency_abbreviation))<small>{{ $study->currency_abbreviation }}</small>@endif</td>
                                </tr>
                                @endforeach
                                <tr class="grand-total-row">
                                    <td colspan="3" class="text-right">Total Annual Income:</td>
                                    <td>{{ number_format($calculations['income_components']['total'], 2) }} @if(isset($study->currency_abbreviation))<small>{{ $study->currency_abbreviation }}</small>@endif</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted">No income components data available.</p>
                @endif
            </div>
            @endif
            
            <!-- Summary Section -->
            <div class="calculation-section">
                <div class="section-header">
                    <h4 class="mb-0">
                        <i class="fa fa-chart-pie text-info"></i> 
                        Financial Summary
                    </h4>
                </div>
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="summary-card">
                            <div class="summary-label">Total Project Cost</div>
                            <div class="summary-value text-danger">
                                {{ number_format($calculations['project_costs']['total'], 2) }} @if(isset($study->currency_abbreviation))<small style="font-size: 1rem;">{{ $study->currency_abbreviation }}</small>@endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="summary-card">
                            <div class="summary-label">Total Annual Income</div>
                            <div class="summary-value text-success">
                                {{ number_format($calculations['income_components']['total'], 2) }} @if(isset($study->currency_abbreviation))<small style="font-size: 1rem;">{{ $study->currency_abbreviation }}</small>@endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="summary-card">
                            <div class="summary-label">Payback Period (Years)</div>
                            <div class="summary-value text-primary">
                                @if($calculations['income_components']['total'] > 0)
                                    {{ number_format($calculations['project_costs']['total'] / $calculations['income_components']['total'], 2) }}
                                @else
                                    N/A
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Display success/error messages with SweetAlert2
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            toast: true,
            position: 'top-end',
            showClass: {
                popup: 'animate__animated animate__fadeInDown'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOutUp'
            }
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: '{{ session('error') }}',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            toast: true,
            position: 'top-end',
            showClass: {
                popup: 'animate__animated animate__fadeInDown'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOutUp'
            }
        });
    @endif
    
    // Confirm Duplicate Action
    function confirmDuplicate() {
        const studyName = '{{ $study->study_name }}';
        
        Swal.fire({
            title: 'Duplicate Feasibility Study?',
            html: `Create a copy of <strong>"${studyName}"</strong>?<br><span style="color: #6c757d; font-size: 14px;">A new study will be created with all the same data.</span>`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#17a2b8',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="fa fa-copy"></i> Yes, Duplicate It',
            cancelButtonText: '<i class="fa fa-times"></i> Cancel',
            reverseButtons: true,
            focusCancel: true,
            showClass: {
                popup: 'animate__animated animate__zoomIn animate__faster'
            },
            hideClass: {
                popup: 'animate__animated animate__zoomOut animate__faster'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                Swal.fire({
                    title: 'Duplicating...',
                    html: 'Please wait while we create a copy of the study<br><i class="fa fa-spinner fa-spin fa-2x mt-3"></i>',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                // Submit the form
                document.getElementById('duplicateForm').submit();
            }
        });
    }
    
    // Additional JavaScript for print formatting if needed
</script>
@endsection

