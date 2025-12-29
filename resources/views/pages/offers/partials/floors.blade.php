@if($offer->floors && $offer->floors->count() > 0)
<div class="card border-0 shadow-sm mb-6">
    <div class="card-body p-4">
        <div class="section-header">
            <h3 class="fs-20 text-heading font-weight-600">
                <i class="fas fa-layer-group"></i>
                {{ __('lang.floor_plans') }}
            </h3>
        </div>
        
        @foreach($offer->floors as $index => $floor)
        <div class="accordion accordion-03 mb-3" id="accordion-floor-{{ $floor->id }}">
            <div class="card border-0 shadow-xxs-5 bg-gray-01">
                <div class="card-header bg-gray-01 border-gray border-0 p-0" id="floor-plans-{{ $floor->id }}">
                    <div class="heading bg-gray-01 d-flex justify-content-between align-items-center px-6"
                         data-toggle="collapse" data-target="#collapse-floor-{{ $floor->id }}" 
                         aria-expanded="{{ $index === 0 ? 'true' : 'false' }}"
                         aria-controls="collapse-floor-{{ $floor->id }}" role="button">
                        <h2 class="mb-0 fs-16 text-heading font-weight-500 py-4 lh-13">
                            @if($floor->floorComponent)
                                {{ app()->getLocale() == 'ar' ? $floor->floorComponent->name_arabic : $floor->floorComponent->name_english }}
                            @else
                                {{ __('lang.floor') }} {{ $index + 1 }}
                            @endif
                        </h2>
                        <ul class="list-inline mb-0 d-none d-sm-block pr-2">
                            @if($floor->count)
                            <li class="list-inline-item text-muted mr-4">{{ __('lang.count') }}: <span class="font-weight-500 text-heading">{{ $floor->count }}</span></li>
                            @endif
                            @if($floor->sqft)
                            <li class="list-inline-item text-muted mr-4">{{ __('lang.sqft') }}: <span class="font-weight-500 text-heading">{{ number_format($floor->sqft) }}</span></li>
                            @endif
                            @if($floor->sqm)
                            <li class="list-inline-item text-muted">{{ __('lang.sqm') }}: <span class="font-weight-500 text-heading">{{ number_format($floor->sqm, 2) }}</span></li>
                            @endif
                        </ul>
                    </div>
                </div>
                <div id="collapse-floor-{{ $floor->id }}"
                     class="collapse {{ $index === 0 ? 'show' : '' }} mx-6 mb-6 bg-white rounded-lg"
                     aria-labelledby="floor-plans-{{ $floor->id }}"
                     data-parent="#accordion-floor-{{ $floor->id }}">
                    <div class="card-body p-4">
                        
                        {{-- Floor Images --}}
                        @if($floor->image_2d || $floor->image_3d)
                        <div class="row mb-4 galleries justify-content-center">
                            @if($floor->image_2d)
                            <div class="{{ $floor->image_3d ? 'col-md-6' : 'col-md-8 col-lg-6' }} mb-3 mb-md-0">
                                <div class="position-relative">
                                    <a href="{{ url('/storage' . $floor->image_2d) }}" data-gtf-mfp="true" data-gallery-id="floor-{{ $floor->id }}">
                                        <img src="{{ url('/storage' . $floor->image_2d) }}" class="rounded-lg w-100" alt="{{ __('lang.2d_floor_plan') }}" style="object-fit: contain;">
                                    </a>
                                    <span class="position-absolute bg-dark text-white px-3 py-1 rounded fs-13" style="bottom: 10px; left: 10px;">
                                        <i class="fal fa-drafting-compass mr-1"></i> {{ __('lang.2d_floor_plan') }}
                                    </span>
                                </div>
                            </div>
                            @endif
                            @if($floor->image_3d)
                            <div class="{{ $floor->image_2d ? 'col-md-6' : 'col-md-8 col-lg-6' }}">
                                <div class="position-relative">
                                    <a href="{{ url('/storage' . $floor->image_3d) }}" data-gtf-mfp="true" data-gallery-id="floor-{{ $floor->id }}">
                                        <img src="{{ url('/storage' . $floor->image_3d) }}" class="rounded-lg w-100" alt="{{ __('lang.3d_visualization') }}" style="object-fit: contain;">
                                    </a>
                                    <span class="position-absolute bg-primary text-white px-3 py-1 rounded fs-13" style="bottom: 10px; left: 10px;">
                                        <i class="fal fa-cube mr-1"></i> {{ __('lang.3d_visualization') }}
                                    </span>
                                </div>
                            </div>
                            @endif
                        </div>
                        @endif
                        
                        {{-- Floor Information & Measurements --}}
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="fs-15 text-heading mb-3"><i class="fal fa-info-circle text-primary mr-2"></i>{{ __('lang.floor_information') }}</h6>
                                <div class="row">
                                    @if($floor->buildingComponent)
                                    <div class="col-sm-6 col-md-3 mb-3">
                                        <div class="d-flex align-items-center">
                                            <div class="p-2 bg-gray-01 rounded mr-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                @if($floor->buildingComponent->icon)
                                                <img src="{{ url('/storage' . $floor->buildingComponent->icon) }}" alt="" style="width: 22px; height: 22px; object-fit: contain;">
                                                @else
                                                <i class="fal fa-building text-primary fs-18"></i>
                                                @endif
                                            </div>
                                            <div>
                                                <span class="text-muted fs-12">{{ __('lang.building') }}</span>
                                                <p class="mb-0 fs-14 font-weight-500 text-heading">{{ app()->getLocale() == 'ar' ? $floor->buildingComponent->name_arabic : $floor->buildingComponent->name_english }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    
                                    @if($floor->floorComponent)
                                    <div class="col-sm-6 col-md-3 mb-3">
                                        <div class="d-flex align-items-center">
                                            <div class="p-2 bg-gray-01 rounded mr-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                @if($floor->floorComponent->icon)
                                                <img src="{{ url('/storage' . $floor->floorComponent->icon) }}" alt="" style="width: 22px; height: 22px; object-fit: contain;">
                                                @else
                                                <i class="fal fa-layer-group text-primary fs-18"></i>
                                                @endif
                                            </div>
                                            <div>
                                                <span class="text-muted fs-12">{{ __('lang.floor_type') }}</span>
                                                <p class="mb-0 fs-14 font-weight-500 text-heading">{{ app()->getLocale() == 'ar' ? $floor->floorComponent->name_arabic : $floor->floorComponent->name_english }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    
                                    @if($floor->sqft)
                                    <div class="col-sm-6 col-md-3 mb-3">
                                        <div class="d-flex align-items-center">
                                            <div class="p-2 bg-gray-01 rounded mr-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                <i class="fal fa-ruler-combined text-primary fs-18"></i>
                                            </div>
                                            <div>
                                                <span class="text-muted fs-12">{{ __('lang.area') }} ({{ __('lang.sqft') }})</span>
                                                <p class="mb-0 fs-14 font-weight-500 text-heading">{{ number_format($floor->sqft) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    
                                    @if($floor->sqm)
                                    <div class="col-sm-6 col-md-3 mb-3">
                                        <div class="d-flex align-items-center">
                                            <div class="p-2 bg-gray-01 rounded mr-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                <i class="fal fa-vector-square text-primary fs-18"></i>
                                            </div>
                                            <div>
                                                <span class="text-muted fs-12">{{ __('lang.area') }} ({{ __('lang.sqm') }})</span>
                                                <p class="mb-0 fs-14 font-weight-500 text-heading">{{ number_format($floor->sqm, 2) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        {{-- Floor Specifications --}}
                        @if($floor->specifications && $floor->specifications->count() > 0)
                        <div class="mb-4">
                            <h6 class="fs-15 text-heading mb-3"><i class="fal fa-list-alt text-primary mr-2"></i>{{ __('lang.floor_specifications') }}</h6>
                            <div class="row">
                                @foreach($floor->specifications as $spec)
                                @if($spec->specification)
                                <div class="col-sm-6 mb-3">
                                    <div class="d-flex align-items-start bg-gray-01 rounded p-3">
                                        <div class="mr-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 40px; height: 40px;">
                                            @if($spec->specification->icon)
                                            <img src="{{ url('/storage' . $spec->specification->icon) }}" 
                                                 alt="{{ app()->getLocale() == 'ar' ? $spec->specification->title_arabic : $spec->specification->title_english }}"
                                                 style="width: 32px; height: 32px; object-fit: contain;">
                                            @else
                                            <span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-primary text-white" 
                                                  style="width: 32px; height: 32px; font-size: 12px; font-weight: 600;">
                                                {{ mb_substr(app()->getLocale() == 'ar' ? $spec->specification->title_arabic : $spec->specification->title_english, 0, 1) }}
                                            </span>
                                            @endif
                                        </div>
                                        <div>
                                            <span class="text-muted fs-13 d-block">{{ app()->getLocale() == 'ar' ? $spec->specification->title_arabic : $spec->specification->title_english }}</span>
                                            <span class="fs-14 font-weight-500 text-heading d-block">{{ app()->getLocale() == 'ar' ? $spec->value_arabic : $spec->value_english }}</span>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @endforeach
                            </div>
                        </div>
                        @endif
                        
                        {{-- Floor Amenities --}}
                        @if($floor->amenities && $floor->amenities->count() > 0)
                        <div>
                            <h6 class="fs-15 text-heading mb-3"><i class="fal fa-sparkles text-primary mr-2"></i>{{ __('lang.floor_amenities') }}</h6>
                            <div class="d-flex flex-wrap">
                                @foreach($floor->amenities as $amenity)
                                @if($amenity->amenity)
                                <div class="d-flex align-items-center bg-gray-01 rounded px-3 py-2 mr-2 mb-2">
                                    @if($amenity->amenity->icon)
                                    <img src="{{ url('/storage' . $amenity->amenity->icon) }}" 
                                         alt="{{ app()->getLocale() == 'ar' ? $amenity->amenity->name_arabic : $amenity->amenity->name_english }}"
                                         class="mr-2"
                                         style="width: 20px; height: 20px; object-fit: contain;">
                                    @else
                                    <i class="fal fa-check-circle text-primary mr-2 fs-14"></i>
                                    @endif
                                    <span class="fs-13 text-heading">{{ app()->getLocale() == 'ar' ? $amenity->amenity->name_arabic : $amenity->amenity->name_english }}</span>
                                </div>
                                @endif
                                @endforeach
                            </div>
                        </div>
                        @endif
                        
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        
    </div>
</div>
@endif

