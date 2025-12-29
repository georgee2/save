{{-- Feasibility Studies Section - Only shown if show_feasibility_studies = 0 --}}
@if($project->show_feasibility_studies == 0 && $project->feasibilityStudies && $project->feasibilityStudies->count() > 0)
<section class="mt-2 pb-7 px-6 pt-6 bg-white rounded-lg">
    <h4 class="fs-22 text-heading mb-6">{{ __('lang.feasibility_studies') }}</h4>
    
    @foreach($project->feasibilityStudies as $index => $study)
    <div class="accordion accordion-03 mb-3" id="accordion-fs-{{ $study->id }}">
        <div class="card border-0 shadow-xxs-5 bg-gray-01">
            <div class="card-header bg-gray-01 border-gray border-0 p-0" id="fs-heading-{{ $study->id }}">
                <div class="heading bg-gray-01 d-flex justify-content-between align-items-center px-6"
                     data-toggle="collapse" data-target="#fs-collapse-{{ $study->id }}" 
                     aria-expanded="{{ $index === 0 ? 'true' : 'false' }}"
                     aria-controls="fs-collapse-{{ $study->id }}" role="button">
                    <h2 class="mb-0 fs-16 text-heading font-weight-500 py-4 lh-13">
                        <i class="fal fa-chart-line text-primary mr-2"></i>
                        {{ $study->study_name }}
                    </h2>
                    <div class="d-flex align-items-center">
                        <span class="badge badge-{{ $study->study_type == 'Master' ? 'primary' : 'secondary' }} mr-3">
                            {{ $study->study_type }}
                        </span>
                        @if($study->currency)
                        <span class="text-muted fs-13 font-weight-500 d-flex align-items-center" style="min-width: 180px;">
                            @if($study->currency->icon)
                            <img src="{{ url('/storage' . $study->currency->icon) }}" alt="" class="mr-2" style="width: 20px; height: 20px; object-fit: contain;">
                            @else
                            <i class="fal fa-coins text-primary mr-2"></i>
                            @endif
                            {{ app()->getLocale() == 'ar' ? $study->currency->name_arabic : $study->currency->name_english }} ({{ $study->currency->abbreviation }})
                        </span>
                        @endif
                    </div>
                </div>
            </div>
            <div id="fs-collapse-{{ $study->id }}"
                 class="collapse {{ $index === 0 ? 'show' : '' }} mx-6 mb-6 bg-white rounded-lg"
                 aria-labelledby="fs-heading-{{ $study->id }}"
                 data-parent="#accordion-fs-{{ $study->id }}">
                <div class="card-body p-4">
                    
                    {{-- Study Description --}}
                    @if($study->description)
                    <div class="mb-4">
                        <p class="text-muted mb-0">{{ $study->description }}</p>
                    </div>
                    @endif
                    
                    {{-- Building Components Table --}}
                    @if($study->buildingComponents && $study->buildingComponents->count() > 0)
                    <div class="mb-4">
                        <h6 class="fs-15 text-heading mb-3">
                            <i class="fal fa-building text-primary mr-2"></i>{{ __('lang.building_components') }}
                        </h6>
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="fs-13 font-weight-500">{{ __('lang.component') }}</th>
                                        <th class="fs-13 font-weight-500 text-right">{{ __('lang.construction_cost') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $totalBuildingCost = 0; @endphp
                                    @foreach($study->buildingComponents as $bc)
                                    @php $totalBuildingCost += $bc->construction_cost; @endphp
                                    <tr>
                                        <td class="fs-14">
                                            @if($bc->buildingComponent && $bc->buildingComponent->icon)
                                            <img src="{{ url('/storage' . $bc->buildingComponent->icon) }}" 
                                                 alt="" class="mr-2" style="width: 20px; height: 20px; object-fit: contain;">
                                            @endif
                                            {{ $bc->buildingComponent ? (app()->getLocale() == 'ar' ? $bc->buildingComponent->name_arabic : $bc->buildingComponent->name_english) : '-' }}
                                        </td>
                                        <td class="fs-14 text-right font-weight-500">
                                            {{ number_format($bc->construction_cost, 2) }}
                                            @if($study->currency) {{ $study->currency->abbreviation }} @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                    <tr class="bg-gray-01">
                                        <td class="fs-14 font-weight-600">{{ __('lang.total') }}</td>
                                        <td class="fs-14 text-right font-weight-600 text-primary">
                                            {{ number_format($totalBuildingCost, 2) }}
                                            @if($study->currency) {{ $study->currency->abbreviation }} @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif
                    
                    {{-- Income Components Table --}}
                    @if($study->incomeComponents && $study->incomeComponents->count() > 0)
                    <div class="mb-4">
                        <h6 class="fs-15 text-heading mb-3">
                            <i class="fal fa-hand-holding-usd text-primary mr-2"></i>{{ __('lang.income_components') }}
                        </h6>
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="fs-13 font-weight-500">{{ __('lang.component') }}</th>
                                        <th class="fs-13 font-weight-500 text-center">{{ __('lang.number_of_units') }}</th>
                                        <th class="fs-13 font-weight-500 text-right">{{ __('lang.rent_per_year') }}</th>
                                        <th class="fs-13 font-weight-500 text-right">{{ __('lang.total_income') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $totalIncome = 0; @endphp
                                    @foreach($study->incomeComponents as $ic)
                                    @php 
                                        $lineTotal = $ic->number_of_units * $ic->rent_per_year;
                                        $totalIncome += $lineTotal;
                                    @endphp
                                    <tr>
                                        <td class="fs-14">
                                            @if($ic->incomeComponent && $ic->incomeComponent->icon)
                                            <img src="{{ url('/storage' . $ic->incomeComponent->icon) }}" 
                                                 alt="" class="mr-2" style="width: 20px; height: 20px; object-fit: contain;">
                                            @endif
                                            {{ $ic->incomeComponent ? (app()->getLocale() == 'ar' ? $ic->incomeComponent->name_arabic : $ic->incomeComponent->name_english) : '-' }}
                                        </td>
                                        <td class="fs-14 text-center">{{ number_format($ic->number_of_units) }}</td>
                                        <td class="fs-14 text-right">
                                            {{ number_format($ic->rent_per_year, 2) }}
                                            @if($study->currency) {{ $study->currency->abbreviation }} @endif
                                        </td>
                                        <td class="fs-14 text-right font-weight-500">
                                            {{ number_format($lineTotal, 2) }}
                                            @if($study->currency) {{ $study->currency->abbreviation }} @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                    <tr class="bg-gray-01">
                                        <td colspan="3" class="fs-14 font-weight-600">{{ __('lang.total') }}</td>
                                        <td class="fs-14 text-right font-weight-600 text-success">
                                            {{ number_format($totalIncome, 2) }}
                                            @if($study->currency) {{ $study->currency->abbreviation }} @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif
                    
                    {{-- Construction Costs (Substation & Pumps) --}}
                    @if($study->constructionCosts && $study->constructionCosts->count() > 0)
                    <div class="mb-4">
                        <h6 class="fs-15 text-heading mb-3">
                            <i class="fal fa-hard-hat text-primary mr-2"></i>{{ __('lang.construction_costs') }}
                        </h6>
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="fs-13 font-weight-500">{{ __('lang.category') }}</th>
                                        <th class="fs-13 font-weight-500">{{ __('lang.item') }}</th>
                                        <th class="fs-13 font-weight-500 text-right">{{ __('lang.cost') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $totalConstCost = 0; @endphp
                                    @foreach($study->constructionCosts as $cc)
                                        @if($cc->substationRoom && $cc->substation_cost)
                                        @php $totalConstCost += $cc->substation_cost; @endphp
                                        <tr>
                                            <td class="fs-14">
                                                <i class="fal fa-bolt text-warning mr-2"></i>
                                                {{ __('lang.substation_room') }}
                                            </td>
                                            <td class="fs-14">
                                                {{ app()->getLocale() == 'ar' ? $cc->substationRoom->name_arabic : $cc->substationRoom->name_english }}
                                            </td>
                                            <td class="fs-14 text-right font-weight-500">
                                                {{ number_format($cc->substation_cost, 2) }}
                                                @if($study->currency) {{ $study->currency->abbreviation }} @endif
                                            </td>
                                        </tr>
                                        @endif
                                        @if($cc->pumpsRoom && $cc->pumps_cost)
                                        @php $totalConstCost += $cc->pumps_cost; @endphp
                                        <tr>
                                            <td class="fs-14">
                                                <i class="fal fa-water text-info mr-2"></i>
                                                {{ __('lang.pumps_room') }}
                                            </td>
                                            <td class="fs-14">
                                                {{ app()->getLocale() == 'ar' ? $cc->pumpsRoom->name_arabic : $cc->pumpsRoom->name_english }}
                                            </td>
                                            <td class="fs-14 text-right font-weight-500">
                                                {{ number_format($cc->pumps_cost, 2) }}
                                                @if($study->currency) {{ $study->currency->abbreviation }} @endif
                                            </td>
                                        </tr>
                                        @endif
                                    @endforeach
                                    @if($totalConstCost > 0)
                                    <tr class="bg-gray-01">
                                        <td colspan="2" class="fs-14 font-weight-600">{{ __('lang.total') }}</td>
                                        <td class="fs-14 text-right font-weight-600 text-primary">
                                            {{ number_format($totalConstCost, 2) }}
                                            @if($study->currency) {{ $study->currency->abbreviation }} @endif
                                        </td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif
                    
                    {{-- Project Costs --}}
                    @if($study->projectCost)
                    <div class="mb-0">
                        <h6 class="fs-15 text-heading mb-3">
                            <i class="fal fa-file-invoice-dollar text-primary mr-2"></i>{{ __('lang.project_costs') }}
                        </h6>
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="fs-13 font-weight-500">{{ __('lang.cost_type') }}</th>
                                        <th class="fs-13 font-weight-500 text-right">{{ __('lang.amount') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php 
                                        $pc = $study->projectCost;
                                        $totalProjectCost = $pc->land_cost + $pc->consultant_cost + $pc->government_fees + $pc->additional_fees;
                                    @endphp
                                    @if($pc->land_cost > 0)
                                    <tr>
                                        <td class="fs-14"><i class="fal fa-map-marked-alt text-primary mr-2"></i>{{ __('lang.land_cost') }}</td>
                                        <td class="fs-14 text-right font-weight-500">
                                            {{ number_format($pc->land_cost, 2) }}
                                            @if($study->currency) {{ $study->currency->abbreviation }} @endif
                                        </td>
                                    </tr>
                                    @endif
                                    @if($pc->consultant_cost > 0)
                                    <tr>
                                        <td class="fs-14"><i class="fal fa-user-tie text-primary mr-2"></i>{{ __('lang.consultant_cost') }}</td>
                                        <td class="fs-14 text-right font-weight-500">
                                            {{ number_format($pc->consultant_cost, 2) }}
                                            @if($study->currency) {{ $study->currency->abbreviation }} @endif
                                        </td>
                                    </tr>
                                    @endif
                                    @if($pc->government_fees > 0)
                                    <tr>
                                        <td class="fs-14"><i class="fal fa-landmark text-primary mr-2"></i>{{ __('lang.government_fees') }}</td>
                                        <td class="fs-14 text-right font-weight-500">
                                            {{ number_format($pc->government_fees, 2) }}
                                            @if($study->currency) {{ $study->currency->abbreviation }} @endif
                                        </td>
                                    </tr>
                                    @endif
                                    @if($pc->additional_fees > 0)
                                    <tr>
                                        <td class="fs-14"><i class="fal fa-plus-circle text-primary mr-2"></i>{{ __('lang.additional_fees') }}</td>
                                        <td class="fs-14 text-right font-weight-500">
                                            {{ number_format($pc->additional_fees, 2) }}
                                            @if($study->currency) {{ $study->currency->abbreviation }} @endif
                                        </td>
                                    </tr>
                                    @endif
                                    <tr class="bg-gray-01">
                                        <td class="fs-14 font-weight-600">{{ __('lang.total') }}</td>
                                        <td class="fs-14 text-right font-weight-600 text-primary">
                                            {{ number_format($totalProjectCost, 2) }}
                                            @if($study->currency) {{ $study->currency->abbreviation }} @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif
                    
                </div>
            </div>
        </div>
    </div>
    @endforeach
    
</section>
@endif

