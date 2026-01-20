{{-- Offers Filter Sidebar - New Design --}}
<div class="primary-sidebar sidebar-sticky" id="sidebar">
    <div class="primary-sidebar-inner">
        <div class="card border-0 mb-4">
            <div class="card-body pl-0 pl-lg-6 pr-0 pt-2 pb-4">
                <h4 class="card-title fs-16 lh-2 text-dark mb-3">{{ __('lang.find_your_offer') }}</h4>
                <form method="GET" action="{{ $formAction ?? request()->url() }}" id="offerFilterForm">
                    {{-- Keyword Search --}}
                    <div class="form-group">
                        <label for="keyword" class="sr-only">{{ __('lang.keyword') }}</label>
                        <input type="text" class="form-control form-control-lg border-0 shadow-none"
                               id="keyword" name="keyword" value="{{ request('keyword') }}"
                               placeholder="{{ __('lang.enter_keyword') }}">
                    </div>
                    
                    {{-- Category --}}
                    @if(!isset($hideCategory) || !$hideCategory)
                    <div class="form-group">
                        <label for="category_id" class="sr-only">{{ __('lang.category') }}</label>
                        <select class="form-control border-0 shadow-none form-control-lg selectpicker filter-select"
                                title="{{ __('lang.all_categories') }}" data-style="btn-lg py-2 h-52" 
                                id="category_id" name="category_id">
                            <option value="">{{ __('lang.all_categories') }}</option>
                            @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id || (isset($currentCategory) && $currentCategory->id == $cat->id) ? 'selected' : '' }}>
                                {{ app()->getLocale() == 'ar' ? $cat->title_arabic : $cat->title_english }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                    
                    {{-- Subcategory --}}
                    @if(!isset($hideSubcategory) || !$hideSubcategory)
                    <div class="form-group">
                        <label for="subcategory_id" class="sr-only">{{ __('lang.subcategory') }}</label>
                        <select class="form-control border-0 shadow-none form-control-lg selectpicker filter-select"
                                title="{{ __('lang.all_subcategories') }}" data-style="btn-lg py-2 h-52" 
                                id="subcategory_id" name="subcategory_id">
                            <option value="">{{ __('lang.all_subcategories') }}</option>
                            @foreach($subcategories as $subcat)
                            <option value="{{ $subcat->id }}" data-category="{{ $subcat->category_id }}" {{ request('subcategory_id') == $subcat->id || (isset($currentSubcategory) && $currentSubcategory->id == $subcat->id) ? 'selected' : '' }}>
                                {{ app()->getLocale() == 'ar' ? $subcat->title_arabic : $subcat->title_english }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                    
                    {{-- Type --}}
                    @if(isset($types) && $types->count() > 0)
                    <div class="form-group">
                        <label for="type_id" class="sr-only">{{ __('lang.type') }}</label>
                        <select class="form-control border-0 shadow-none form-control-lg selectpicker filter-select"
                                title="{{ __('lang.all_types') }}" data-style="btn-lg py-2 h-52" 
                                id="type_id" name="type_id">
                            <option value="">{{ __('lang.all_types') }}</option>
                            @foreach($types as $type)
                            <option value="{{ $type->id }}" {{ request('type_id') == $type->id ? 'selected' : '' }}>
                                {{ app()->getLocale() == 'ar' ? $type->name_arabic : $type->name_english }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                    
                    {{-- Style --}}
                    @if(isset($styles) && $styles->count() > 0)
                    <div class="form-group">
                        <label for="style_id" class="sr-only">{{ __('lang.style') }}</label>
                        <select class="form-control border-0 shadow-none form-control-lg selectpicker filter-select"
                                title="{{ __('lang.all_styles') }}" data-style="btn-lg py-2 h-52" 
                                id="style_id" name="style_id">
                            <option value="">{{ __('lang.all_styles') }}</option>
                            @foreach($styles as $style)
                            <option value="{{ $style->id }}" {{ request('style_id') == $style->id ? 'selected' : '' }}>
                                {{ app()->getLocale() == 'ar' ? $style->title_arabic : $style->title_english }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                    
                    {{-- Emirate --}}
                    @if(isset($emirates) && $emirates->count() > 0)
                    <div class="form-group">
                        <label for="emirate_id" class="sr-only">{{ __('lang.emirate') }}</label>
                        <select class="form-control border-0 shadow-none form-control-lg selectpicker filter-select"
                                title="{{ __('lang.all_emirates') }}" data-style="btn-lg py-2 h-52" 
                                id="emirate_id" name="emirate_id">
                            <option value="">{{ __('lang.all_emirates') }}</option>
                            @foreach($emirates as $emirate)
                            <option value="{{ $emirate->id }}" {{ request('emirate_id') == $emirate->id ? 'selected' : '' }}>
                                {{ app()->getLocale() == 'ar' ? $emirate->title_arabic : $emirate->title_english }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                    
                    {{-- SQFT Range Slider --}}
                    <div class="form-group area-slider-group">
                        <label class="text-gray-light mb-3">{{ __('lang.area_size') }} ({{ __('lang.sqft') }})</label>
                        <div class="area-slider-container">
                            <div id="sqft-slider" class="area-range-slider"></div>
                            <div class="area-slider-values text-center mt-3">
                                <span id="sqft-range-display" class="font-weight-600 text-heading">
                                    {{ request('sqft_min', 50) }} {{ __('lang.sqft') }} {{ __('lang.to') }} {{ request('sqft_max', 15000) }} {{ __('lang.sqft') }}
                                </span>
                            </div>
                            <input type="hidden" id="sqft_min" name="sqft_min" value="{{ request('sqft_min', '') }}">
                            <input type="hidden" id="sqft_max" name="sqft_max" value="{{ request('sqft_max', '') }}">
                        </div>
                    </div>
                    
                    {{-- SQM Range Slider --}}
                    <div class="form-group area-slider-group">
                        <label class="text-gray-light mb-3">{{ __('lang.area_size') }} ({{ __('lang.sqm') }})</label>
                        <div class="area-slider-container">
                            <div id="sqm-slider" class="area-range-slider"></div>
                            <div class="area-slider-values text-center mt-3">
                                <span id="sqm-range-display" class="font-weight-600 text-heading">
                                    {{ request('sqm_min', 5) }} {{ __('lang.sqm') }} {{ __('lang.to') }} {{ request('sqm_max', 1400) }} {{ __('lang.sqm') }}
                                </span>
                            </div>
                            <input type="hidden" id="sqm_min" name="sqm_min" value="{{ request('sqm_min', '') }}">
                            <input type="hidden" id="sqm_max" name="sqm_max" value="{{ request('sqm_max', '') }}">
                        </div>
                    </div>
                    
                    {{-- Price Range --}}
                    <div class="form-group">
                        <a class="lh-17 d-inline-block" data-toggle="collapse" href="#price-filter"
                           role="button" aria-expanded="{{ request('price_min') || request('price_max') ? 'true' : 'false' }}" aria-controls="price-filter">
                            <span class="text-primary d-inline-block mr-1"><i class="far fa-plus-square"></i></span>
                            <span class="fs-15 text-heading font-weight-500 hover-primary">{{ __('lang.filter_by_price') }}</span>
                        </a>
                        <div class="collapse {{ request('price_min') || request('price_max') ? 'show' : '' }}" id="price-filter">
                            <div class="card card-body border-0 px-0 pb-0 pt-3">
                                <label class="text-gray-light mb-2">{{ __('lang.price_range') }} (AED)</label>
                                <div class="row">
                                    <div class="col-6">
                                        <input type="number" class="form-control form-control-lg border-0 shadow-none"
                                               id="price_min" name="price_min" value="{{ request('price_min') }}"
                                               placeholder="{{ __('lang.min') }}">
                                    </div>
                                    <div class="col-6">
                                        <input type="number" class="form-control form-control-lg border-0 shadow-none"
                                               id="price_max" name="price_max" value="{{ request('price_max') }}"
                                               placeholder="{{ __('lang.max') }}">
                                    </div>
                                </div>
                                <small class="text-muted d-block mt-1">{{ __('lang.price_filter_note') }}</small>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Buttons --}}
                    <div class="d-flex">
                        <button type="submit" class="btn btn-primary btn-lg flex-grow-1 shadow-none mr-2">
                            <i class="fas fa-search mr-2"></i>{{ __('lang.search') }}
                        </button>
                        <a href="{{ $formAction ?? request()->url() }}" class="btn btn-outline-secondary btn-lg shadow-none">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
