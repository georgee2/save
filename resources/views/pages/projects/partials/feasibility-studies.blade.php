@php
  // Filter only active feasibility studies
  $activeFeasibilityStudies = $project->feasibilityStudies->where('status', 'Active');
@endphp

@if($project->show_feasibility_studies == 0 && $activeFeasibilityStudies && $activeFeasibilityStudies->count() > 0)
<!-- start: Feasibility Studies Section -->
<section class="tj-feasibility-section">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <h3 class="section-header wow fadeInUp" data-wow-delay=".3s">
          <img src="{{url('/pic/svg40.svg')}}">
          {{ __('lang.feasibility_studies') }}
        </h3>
        <P class="wow fadeInUp" data-wow-delay=".3s" style="margin-bottom: 30px;">
          {{ __('lang.comprehensive_feasibility_studies') }}
        </P>
        
        <!-- Accordion for Feasibility Studies -->
        <div class="accordion" id="feasibilityAccordion">
          @foreach($activeFeasibilityStudies as $index => $study)
          @php
            // Get calculations for this study
            $calculations = app('Modules\Admin\App\Http\Controllers\FeasibilityStudyController')->calculateStudyPublic($study->id, $project->type_id);
            // Get currency abbreviation
            $currencyAbbr = $study->currency ? $study->currency->abbreviation : '';
          @endphp
          
          <div class="accordion-item wow fadeInUp" data-wow-delay=".{{ ($index + 1) * 1 }}s" style="margin-bottom: 15px; border: 1px solid #e9ecef; border-radius: 10px; overflow: hidden;">
            <h2 class="accordion-header" id="heading{{ $study->id }}">
              <button class="accordion-button {{ $index == 0 ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $study->id }}" aria-expanded="{{ $index == 0 ? 'true' : 'false' }}" aria-controls="collapse{{ $study->id }}" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border: none; padding: 20px; font-weight: 600; color: #1a1a1a;">
                <div class="study-header-content" style="width: 100%;">
                  <h5 style="margin: 0; font-size: 18px; color: #1a1a1a;">{{ $study->study_name }}</h5>
                </div>
              </button>
            </h2>
            <div id="collapse{{ $study->id }}" class="accordion-collapse collapse {{ $index == 0 ? 'show' : '' }}" aria-labelledby="heading{{ $study->id }}" data-bs-parent="#feasibilityAccordion">
              <div class="accordion-body" style="padding: 30px; background: #fff;">
                
                <!-- Building Components Section -->
                @if(isset($calculations['building_components']) && $calculations['building_components']['header'] && count($calculations['building_components']['items']) > 0)
                <div class="calculation-section" style="margin-bottom: 30px;">
                  <h5 style="font-size: 18px; font-weight: 600; color: #1a1a1a; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #e9ecef;">
                    <i class="fa fa-cube" style="color: #ff5722;"></i> 
                    @if(App::getLocale() == 'en')
                      {{ $calculations['building_components']['header']->header_english }}
                    @else
                      {{ $calculations['building_components']['header']->header_arabic }}
                    @endif
                  </h5>
                  
                  @foreach($calculations['building_components']['items'] as $item)
                  <div style="margin-bottom: 25px;">
                    <h6 style="font-size: 16px; font-weight: 600; color: #ff5722; margin-bottom: 15px;">
                      @if(App::getLocale() == 'en')
                        {{ $item['component']->name_english }}
                      @else
                        {{ $item['component']->name_arabic }}
                      @endif
                    </h6>
                    <div class="table-responsive">
                      <table class="table table-bordered fs-table" style="font-size: 14px;">
                        <thead>
                          <tr>
                            <th>
                              @if(App::getLocale() == 'en')
                                Floor Type
                              @else
                                نوع الطابق
                              @endif
                            </th>
                            <th>
                              @if(App::getLocale() == 'en')
                                SQFT
                              @else
                                قدم مربع
                              @endif
                            </th>
                            <th>
                              @if(App::getLocale() == 'en')
                                Count
                              @else
                                العدد
                              @endif
                            </th>
                            <th>
                              @if(App::getLocale() == 'en')
                                Total Area
                              @else
                                المساحة الإجمالية
                              @endif
                            </th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($item['floors'] as $floor)
                          <tr>
                            <td>
                              @if(App::getLocale() == 'en')
                                {{ $floor->floor_name }}
                              @else
                                {{ $floor->floor_name }}
                              @endif
                            </td>
                            <td>{{ number_format($floor->sqft, 2) }}</td>
                            <td>{{ $floor->count }}</td>
                            <td>{{ number_format($floor->total_area, 2) }}</td>
                          </tr>
                          @endforeach
                          <tr style="background: #f8f9fa; font-weight: 600;">
                            <td colspan="3" style="text-align: right;">
                              @if(App::getLocale() == 'en')
                                Total Build Area:
                              @else
                                إجمالي مساحة البناء:
                              @endif
                            </td>
                            <td>{{ number_format($item['total_build_area'], 2) }} SQFT</td>
                          </tr>
                          <tr style="background: linear-gradient(135deg, #ff5722 0%, #ff7043 100%); color: #fff; font-weight: 600;">
                            <td colspan="3" style="text-align: right;">
                              @if(App::getLocale() == 'en')
                                Total Cost:
                              @else
                                التكلفة الإجمالية:
                              @endif
                            </td>
                            <td>{{ number_format($item['total_cost'], 2) }} @if($currencyAbbr)<small>{{ $currencyAbbr }}</small>@endif</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  @endforeach
                  
                  <div style="text-align: right; margin-top: 20px;">
                    <span style="background: linear-gradient(135deg, #ff5722 0%, #ff7043 100%); color: #fff; padding: 10px 20px; border-radius: 25px; font-size: 16px; font-weight: 600;">
                      @if(App::getLocale() == 'en')
                        Total Building Components Cost:
                      @else
                        إجمالي تكلفة مكونات البناء:
                      @endif
                      {{ number_format($calculations['building_components']['total'], 2) }} @if($currencyAbbr){{ $currencyAbbr }}@endif
                    </span>
                  </div>
                </div>
                @endif
                
                <!-- Length Components Section -->
                @if(isset($calculations['length_components']) && $calculations['length_components']['header'] && count($calculations['length_components']['items']) > 0)
                <div class="calculation-section" style="margin-bottom: 30px;">
                  <h5 style="font-size: 18px; font-weight: 600; color: #1a1a1a; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #e9ecef;">
                    <i class="fa fa-ruler" style="color: #ff5722;"></i> 
                    @if(App::getLocale() == 'en')
                      {{ $calculations['length_components']['header']->header_english }}
                    @else
                      {{ $calculations['length_components']['header']->header_arabic }}
                    @endif
                  </h5>
                  
                  <div class="table-responsive">
                    <table class="table table-bordered fs-table" style="font-size: 14px;">
                      <thead>
                        <tr>
                          <th>
                            @if(App::getLocale() == 'en')
                              Component Name
                            @else
                              اسم المكون
                            @endif
                          </th>
                          <th>
                            @if(App::getLocale() == 'en')
                              Length
                            @else
                              الطول
                            @endif
                          </th>
                          <th>
                            @if(App::getLocale() == 'en')
                              Count
                            @else
                              العدد
                            @endif
                          </th>
                          <th>
                            @if(App::getLocale() == 'en')
                              Total Length
                            @else
                              الطول الإجمالي
                            @endif
                          </th>
                          <th>
                            @if(App::getLocale() == 'en')
                              Unit Cost
                            @else
                              تكلفة الوحدة
                            @endif
                          </th>
                          <th>
                            @if(App::getLocale() == 'en')
                              Total Cost
                            @else
                              التكلفة الإجمالية
                            @endif
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($calculations['length_components']['items'] as $item)
                        <tr>
                          <td>
                            @if(App::getLocale() == 'en')
                              {{ $item['component']->length_component_name_en }}
                            @else
                              {{ $item['component']->length_component_name_ar }}
                            @endif
                          </td>
                          <td>{{ number_format($item['length'], 2) }}</td>
                          <td>{{ $item['count'] }}</td>
                          <td>{{ number_format($item['total_length'], 2) }}</td>
                          <td>{{ number_format($item['component']->unit_cost, 2) }} @if($currencyAbbr)<small>{{ $currencyAbbr }}</small>@endif</td>
                          <td>{{ number_format($item['total_cost'], 2) }} @if($currencyAbbr)<small>{{ $currencyAbbr }}</small>@endif</td>
                        </tr>
                        @endforeach
                        <tr style="background: linear-gradient(135deg, #ff5722 0%, #ff7043 100%); color: #fff; font-weight: 600;">
                          <td colspan="5" style="text-align: right;">
                            @if(App::getLocale() == 'en')
                              Total Cost:
                            @else
                              التكلفة الإجمالية:
                            @endif
                          </td>
                          <td>{{ number_format($calculations['length_components']['total'], 2) }} @if($currencyAbbr)<small>{{ $currencyAbbr }}</small>@endif</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                @endif
                
                <!-- Construction Costs Section -->
                @if(isset($calculations['construction_costs']) && $calculations['construction_costs']['header'])
                <div class="calculation-section" style="margin-bottom: 30px;">
                  <h5 style="font-size: 18px; font-weight: 600; color: #1a1a1a; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #e9ecef;">
                    <i class="fa fa-calculator" style="color: #ff5722;"></i> 
                    @if(App::getLocale() == 'en')
                      {{ $calculations['construction_costs']['header']->header_english }}
                    @else
                      {{ $calculations['construction_costs']['header']->header_arabic }}
                    @endif
                  </h5>
                  
                  @php
                    // Calculate Main Contractor Cost (Building + Length Components)
                    $mainContractorCost = ($calculations['building_components']['total'] ?? 0) + 
                                         ($calculations['length_components']['total'] ?? 0);
                    $totalConstructionCosts = $mainContractorCost + 
                                             ($calculations['construction_costs']['substation_cost'] ?? 0) + 
                                             ($calculations['construction_costs']['pumps_cost'] ?? 0);
                  @endphp
                  
                  <div class="table-responsive">
                    <table class="table table-bordered fs-table" style="font-size: 14px;">
                      <thead>
                        <tr>
                          <th>
                            @if(App::getLocale() == 'en')
                              Item
                            @else
                              البند
                            @endif
                          </th>
                          <th>
                            @if(App::getLocale() == 'en')
                              Cost
                            @else
                              التكلفة
                            @endif
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>
                            <i class="fa fa-building" style="color: #ff5722;"></i> 
                            @if(App::getLocale() == 'en')
                              Main Contractor Cost
                            @else
                              تكلفة المقاول الرئيسي
                            @endif
                          </td>
                          <td>{{ number_format($mainContractorCost, 2) }} @if($currencyAbbr)<small>{{ $currencyAbbr }}</small>@endif</td>
                        </tr>
                        
                        @if($calculations['construction_costs']['substation_cost'] > 0)
                        <tr>
                          <td>
                            <i class="fa fa-plug" style="color: #ff5722;"></i> 
                            @if(App::getLocale() == 'en')
                              {{ $calculations['construction_costs']['substation_name'] ?? 'Substation Room' }}
                            @else
                              {{ $calculations['construction_costs']['substation_name'] ?? 'غرفة المحطة الفرعية' }}
                            @endif
                            <small style="color: #666;">(Substation Room)</small>
                          </td>
                          <td>{{ number_format($calculations['construction_costs']['substation_cost'], 2) }} @if($currencyAbbr)<small>{{ $currencyAbbr }}</small>@endif</td>
                        </tr>
                        @endif
                        
                        @if($calculations['construction_costs']['pumps_cost'] > 0)
                        <tr>
                          <td>
                            <i class="fa fa-tint" style="color: #ff5722;"></i> 
                            @if(App::getLocale() == 'en')
                              {{ $calculations['construction_costs']['pumps_name'] ?? 'Pumps Room' }}
                            @else
                              {{ $calculations['construction_costs']['pumps_name'] ?? 'غرفة المضخات' }}
                            @endif
                            <small style="color: #666;">(Pumps Room)</small>
                          </td>
                          <td>{{ number_format($calculations['construction_costs']['pumps_cost'], 2) }} @if($currencyAbbr)<small>{{ $currencyAbbr }}</small>@endif</td>
                        </tr>
                        @endif
                        
                        <tr style="background: linear-gradient(135deg, #ff5722 0%, #ff7043 100%); color: #fff; font-weight: 600;">
                          <td style="text-align: right;">
                            @if(App::getLocale() == 'en')
                              Total Construction Costs:
                            @else
                              إجمالي تكاليف البناء:
                            @endif
                          </td>
                          <td>{{ number_format($totalConstructionCosts, 2) }} @if($currencyAbbr)<small>{{ $currencyAbbr }}</small>@endif</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                @endif
                
                <!-- Project Costs Section -->
                @if(isset($calculations['project_costs']) && $calculations['project_costs']['header'])
                <div class="calculation-section" style="margin-bottom: 30px;">
                  <h5 style="font-size: 18px; font-weight: 600; color: #1a1a1a; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #e9ecef;">
                    <i class="fa fa-money" style="color: #28a745;"></i> 
                    @if(App::getLocale() == 'en')
                      {{ $calculations['project_costs']['header']->header_english }}
                    @else
                      {{ $calculations['project_costs']['header']->header_arabic }}
                    @endif
                  </h5>
                  
                  <div class="table-responsive">
                    <table class="table table-bordered fs-table" style="font-size: 14px;">
                      <thead>
                        <tr>
                          <th>
                            @if(App::getLocale() == 'en')
                              Cost Category
                            @else
                              فئة التكلفة
                            @endif
                          </th>
                          <th>
                            @if(App::getLocale() == 'en')
                              Amount
                            @else
                              المبلغ
                            @endif
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>
                            <i class="fa fa-wrench" style="color: #28a745;"></i> 
                            @if(App::getLocale() == 'en')
                              Total Construction Cost
                            @else
                              إجمالي تكلفة البناء
                            @endif
                          </td>
                          <td>{{ number_format($calculations['project_costs']['construction_cost'], 2) }} @if($currencyAbbr)<small>{{ $currencyAbbr }}</small>@endif</td>
                        </tr>
                        <tr>
                          <td>
                            <i class="fa fa-map" style="color: #28a745;"></i> 
                            @if(App::getLocale() == 'en')
                              Land Cost
                            @else
                              تكلفة الأرض
                            @endif
                          </td>
                          <td>{{ number_format($calculations['project_costs']['land_cost'], 2) }} @if($currencyAbbr)<small>{{ $currencyAbbr }}</small>@endif</td>
                        </tr>
                        <tr>
                          <td>
                            <i class="fa fa-user-tie" style="color: #28a745;"></i> 
                            @if(App::getLocale() == 'en')
                              Consultant Cost
                            @else
                              تكلفة الاستشاري
                            @endif
                          </td>
                          <td>{{ number_format($calculations['project_costs']['consultant_cost'], 2) }} @if($currencyAbbr)<small>{{ $currencyAbbr }}</small>@endif</td>
                        </tr>
                        <tr>
                          <td>
                            <i class="fa fa-gavel" style="color: #28a745;"></i> 
                            @if(App::getLocale() == 'en')
                              Government Fees
                            @else
                              الرسوم الحكومية
                            @endif
                          </td>
                          <td>{{ number_format($calculations['project_costs']['government_fees'], 2) }} @if($currencyAbbr)<small>{{ $currencyAbbr }}</small>@endif</td>
                        </tr>
                        <tr>
                          <td>
                            <i class="fa fa-plus-circle" style="color: #28a745;"></i> 
                            @if(App::getLocale() == 'en')
                              Additional Fees
                            @else
                              رسوم إضافية
                            @endif
                          </td>
                          <td>{{ number_format($calculations['project_costs']['additional_fees'], 2) }} @if($currencyAbbr)<small>{{ $currencyAbbr }}</small>@endif</td>
                        </tr>
                        <tr style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: #fff; font-weight: 600;">
                          <td style="text-align: right;">
                            <strong>
                              @if(App::getLocale() == 'en')
                                TOTAL PROJECT COST:
                              @else
                                إجمالي تكلفة المشروع:
                              @endif
                            </strong>
                          </td>
                          <td><strong>{{ number_format($calculations['project_costs']['total'], 2) }} @if($currencyAbbr)<small>{{ $currencyAbbr }}</small>@endif</strong></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                @endif
                
                <!-- Income Components Section -->
                @if(isset($calculations['income_components']) && $calculations['income_components']['header'] && count($calculations['income_components']['items']) > 0)
                <div class="calculation-section" style="margin-bottom: 30px;">
                  <h5 style="font-size: 18px; font-weight: 600; color: #1a1a1a; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #e9ecef;">
                    <i class="fa fa-dollar" style="color: #28a745;"></i> 
                    @if(App::getLocale() == 'en')
                      {{ $calculations['income_components']['header']->header_english }}
                    @else
                      {{ $calculations['income_components']['header']->header_arabic }}
                    @endif
                  </h5>
                  
                  <div class="table-responsive">
                    <table class="table table-bordered fs-table" style="font-size: 14px;">
                      <thead>
                        <tr>
                          <th>
                            @if(App::getLocale() == 'en')
                              Component Name
                            @else
                              اسم المكون
                            @endif
                          </th>
                          <th>
                            @if(App::getLocale() == 'en')
                              Number of Units
                            @else
                              عدد الوحدات
                            @endif
                          </th>
                          <th>
                            @if(App::getLocale() == 'en')
                              Rent per Year
                            @else
                              الإيجار السنوي
                            @endif
                          </th>
                          <th>
                            @if(App::getLocale() == 'en')
                              Total Income
                            @else
                              الدخل الإجمالي
                            @endif
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($calculations['income_components']['items'] as $item)
                        <tr>
                          <td>
                            @if(App::getLocale() == 'en')
                              {{ $item['component']->name_english }}
                            @else
                              {{ $item['component']->name_arabic }}
                            @endif
                          </td>
                          <td>{{ number_format($item['component']->number_of_units) }}</td>
                          <td>{{ number_format($item['component']->rent_per_year, 2) }} @if($currencyAbbr)<small>{{ $currencyAbbr }}</small>@endif</td>
                          <td>{{ number_format($item['total_income'], 2) }} @if($currencyAbbr)<small>{{ $currencyAbbr }}</small>@endif</td>
                        </tr>
                        @endforeach
                        <tr style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: #fff; font-weight: 600;">
                          <td colspan="3" style="text-align: right;">
                            @if(App::getLocale() == 'en')
                              Total Annual Income:
                            @else
                              إجمالي الدخل السنوي:
                            @endif
                          </td>
                          <td>{{ number_format($calculations['income_components']['total'], 2) }} @if($currencyAbbr)<small>{{ $currencyAbbr }}</small>@endif</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                @endif
                
                <!-- Financial Summary -->
                @if(isset($calculations['project_costs']) && isset($calculations['income_components']))
                <div class="calculation-section">
                  <h5 style="font-size: 18px; font-weight: 600; color: #1a1a1a; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #e9ecef;">
                    <i class="fa fa-chart-pie" style="color: #ff5722;"></i> 
                    @if(App::getLocale() == 'en')
                      Financial Summary
                    @else
                      الملخص المالي
                    @endif
                  </h5>
                  
                  <div class="row">
                    <div class="col-md-4 mb-3">
                      <div style="border: 2px solid #ff5722; border-radius: 10px; padding: 20px; text-align: center;">
                        <div style="font-size: 14px; text-transform: uppercase; color: #666; font-weight: 600; margin-bottom: 10px;">
                          @if(App::getLocale() == 'en')
                            Total Project Cost
                          @else
                            إجمالي تكلفة المشروع
                          @endif
                        </div>
                        <div style="font-size: 28px; font-weight: bold; color: #ff5722;">
                          {{ number_format($calculations['project_costs']['total'], 2) }} @if($currencyAbbr)<small style="font-size: 16px;">{{ $currencyAbbr }}</small>@endif
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4 mb-3">
                      <div style="border: 2px solid #28a745; border-radius: 10px; padding: 20px; text-align: center;">
                        <div style="font-size: 14px; text-transform: uppercase; color: #666; font-weight: 600; margin-bottom: 10px;">
                          @if(App::getLocale() == 'en')
                            Total Annual Income
                          @else
                            إجمالي الدخل السنوي
                          @endif
                        </div>
                        <div style="font-size: 28px; font-weight: bold; color: #28a745;">
                          {{ number_format($calculations['income_components']['total'], 2) }} @if($currencyAbbr)<small style="font-size: 16px;">{{ $currencyAbbr }}</small>@endif
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4 mb-3">
                      <div style="border: 2px solid #007bff; border-radius: 10px; padding: 20px; text-align: center;">
                        <div style="font-size: 14px; text-transform: uppercase; color: #666; font-weight: 600; margin-bottom: 10px;">
                          @if(App::getLocale() == 'en')
                            Payback Period (Years)
                          @else
                            فترة الاسترداد (سنوات)
                          @endif
                        </div>
                        <div style="font-size: 28px; font-weight: bold; color: #007bff;">
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
                @endif
                
              </div>
            </div>
          </div>
          @endforeach
        </div>
        
      </div>
    </div>
  </div>
</section>
<!-- end: Feasibility Studies Section -->


@endif
