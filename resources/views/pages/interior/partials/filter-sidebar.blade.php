{{-- Interior Gallery Filter Sidebar --}}
<div class="primary-sidebar sidebar-sticky" id="sidebar">
    <div class="primary-sidebar-inner">
        <div class="card border-0 mb-4">
            <div class="card-body pl-0 pl-lg-6 pr-0 pt-2 pb-4">
                <h4 class="card-title fs-16 lh-2 text-dark mb-3">
                    @if(__('lang.find_your_design') !== 'lang.find_your_design')
                        {{ __('lang.find_your_design') }}
                    @else
                        {{ app()->getLocale() == 'ar' ? 'ابحث عن تصميمك' : 'Find Your Design' }}
                    @endif
                </h4>
                <form method="GET" action="{{ $formAction ?? request()->url() }}" id="interiorFilterForm">
                    {{-- Keyword Search --}}
                    <div class="form-group">
                        <label for="keyword" class="sr-only">{{ __('lang.keyword') }}</label>
                        <input type="text" class="form-control form-control-lg border-0 shadow-none"
                               id="keyword" name="keyword" value="{{ request('keyword') }}"
                               placeholder="{{ __('lang.enter_keyword') }}">
                    </div>
                    
                    {{-- Category --}}
                    @if(isset($categories) && $categories->count() > 0 && (!isset($hideCategory) || !$hideCategory))
                    <div class="form-group">
                        <label for="category_id" class="sr-only">{{ __('lang.category') }}</label>
                        <select class="form-control border-0 shadow-none form-control-lg selectpicker filter-select"
                                title="{{ __('lang.all_categories') }}" data-style="btn-lg py-2 h-52" 
                                id="category_id" name="category_id">
                            <option value="">{{ __('lang.all_categories') }}</option>
                            @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id || (isset($currentCategory) && $currentCategory->id == $cat->id) ? 'selected' : '' }}>
                                {{ app()->getLocale() == 'ar' ? $cat->title_arabic : $cat->title_english }}
                                @if(isset($cat->galleries_count))
                                ({{ $cat->galleries_count }})
                                @endif
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
                    
                    {{-- Buttons --}}
                    <div class="d-flex">
                        <button type="submit" class="btn btn-lg flex-grow-1 shadow-none mr-2" style="background: #19868b; color: #fff;">
                            <i class="fas fa-search mr-2"></i>{{ __('lang.search') }}
                        </button>
                        <a href="{{ $formAction ?? request()->url() }}" class="btn btn-lg shadow-none" style="background: #e1273d; color: #fff;">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
