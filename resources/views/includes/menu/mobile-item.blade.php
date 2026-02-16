{{-- Mobile Menu Item Partial (Recursive) --}}
@php
    $itemChildren = $item->relationLoaded('children') ? $item->getRelation('children') : collect();
    $dynamicChildren = collect();
    $hasDynamicContent = false;
    
    // Check visibility
    if (!$item->isVisible()) {
        return;
    }
    
    // Check mobile visibility
    if (!$item->is_visible_mobile) {
        return;
    }
    
    // Get dynamic children if applicable
    if ($item->isDynamic() && $item->show_children) {
        $dynamicChildren = $item->getDynamicChildren();
        $hasDynamicContent = $dynamicChildren->isNotEmpty();
    }
    
    // Get dynamic query results
    if ($item->isDynamicQuery() && $item->show_children) {
        $dynamicChildren = $item->getQueryResults();
        $hasDynamicContent = $dynamicChildren->isNotEmpty();
    }
    
    // Get category with subcategories children
    if ($item->isCategoryWithSubs()) {
        $dynamicChildren = $item->getCategorySubcategories();
        $hasDynamicContent = $dynamicChildren->isNotEmpty();
    }
    
    $hasChildren = $itemChildren->isNotEmpty() || $hasDynamicContent;
    $itemUrl = $item->getUrl() ?? 'javascript:void(0);';
    $itemTitle = $item->getTitle();
    $depth = $depth ?? 0;
@endphp

@if($item->item_type === 'divider')
    {{-- Dividers in mobile are just visual separators --}}
    <div class="mobile-nav-divider"></div>
@elseif($item->item_type === 'header')
    <div class="mobile-nav-header">{{ $itemTitle }}</div>
@else
    <div class="mobile-nav-item {{ $item->css_class ?? '' }}">
        @if($hasChildren)
            <a href="javascript:void(0);" class="mobile-nav-link mobile-nav-toggle">
                @if($item->icon)
                    @if($item->icon_type === 'image')
                        <img src="{{ asset('storage' . $item->icon) }}" alt="">
                    @else
                        <i class="{{ $item->icon }}"></i>
                    @endif
                @endif
                {{ $itemTitle }}
                <i class="fal fa-chevron-right"></i>
            </a>
            <ul class="mobile-submenu">
                {{-- For category_with_subs, add a "View All" link to the category page --}}
                @if($item->item_type === 'category_with_subs' && $itemUrl && $itemUrl !== 'javascript:void(0);')
                    <li class="mobile-submenu-item">
                        <a href="{{ $itemUrl }}" class="mobile-submenu-link" style="font-weight: 600; color: #19868b;">
                            <i class="fal fa-arrow-right"></i>
                            {{ __('lang.view_all') }} {{ $itemTitle }}
                        </a>
                    </li>
                @endif
                
                {{-- Static children from menu items --}}
                @foreach($itemChildren as $child)
                    @include('includes.menu.mobile-submenu-item', ['item' => $child, 'depth' => $depth + 1])
                @endforeach
                
                {{-- Dynamic children based on item type --}}
                @if($hasDynamicContent)
                    @if($item->item_type === 'dynamic_services')
                        @foreach($dynamicChildren as $service)
                            @if($service->subServices && $service->subServices->count() > 0)
                                <li class="mobile-submenu-item">
                                    <a href="javascript:void(0);" class="mobile-submenu-link mobile-nav-toggle">
                                        @if($service->icon)
                                            <img src="{{ asset('storage' . $service->icon) }}" alt="">
                                        @else
                                            <i class="fal fa-cog"></i>
                                        @endif
                                        {{ app()->getLocale() == 'ar' ? $service->title_arabic : $service->title_english }}
                                        <i class="fal fa-chevron-right" style="margin-left: auto;"></i>
                                    </a>
                                    <ul class="mobile-nested-submenu">
                                        <li>
                                            <a href="{{ route('services.show', $service->slug) }}" class="mobile-nested-link">
                                                <i class="fal fa-arrow-right"></i>
                                                {{ __('lang.view_all') }}
                                            </a>
                                        </li>
                                        @foreach($service->subServices as $subService)
                                            <li>
                                                <a href="{{ route('services.show', $subService->slug) }}" class="mobile-nested-link">
                                                    @if($subService->icon)
                                                        <img src="{{ asset('storage' . $subService->icon) }}" alt="">
                                                    @else
                                                        <i class="fal fa-angle-right"></i>
                                                    @endif
                                                    {{ app()->getLocale() == 'ar' ? $subService->title_arabic : $subService->title_english }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @else
                                <li class="mobile-submenu-item">
                                    <a href="{{ route('services.show', $service->slug) }}" class="mobile-submenu-link">
                                        @if($service->icon)
                                            <img src="{{ asset('storage' . $service->icon) }}" alt="">
                                        @else
                                            <i class="fal fa-cog"></i>
                                        @endif
                                        {{ app()->getLocale() == 'ar' ? $service->title_arabic : $service->title_english }}
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    @elseif($item->item_type === 'dynamic_offers')
                        @foreach($dynamicChildren as $offerCategory)
                            @if($offerCategory->subCategories && $offerCategory->subCategories->count() > 0)
                                <li class="mobile-submenu-item">
                                    <a href="javascript:void(0);" class="mobile-submenu-link mobile-nav-toggle">
                                        @if($offerCategory->icon)
                                            <img src="{{ url('/storage' . $offerCategory->icon) }}" alt="">
                                        @else
                                            <i class="fal fa-tag"></i>
                                        @endif
                                        {{ app()->getLocale() == 'ar' ? $offerCategory->title_arabic : $offerCategory->title_english }}
                                        <i class="fal fa-chevron-right" style="margin-left: auto;"></i>
                                    </a>
                                    <ul class="mobile-nested-submenu">
                                        <li>
                                            <a href="{{ route('offers.category', $offerCategory->slug) }}" class="mobile-nested-link">
                                                <i class="fal fa-arrow-right"></i>
                                                {{ __('lang.view_all') }}
                                            </a>
                                        </li>
                                        @foreach($offerCategory->subCategories as $offerSubCategory)
                                            <li>
                                                <a href="{{ route('offers.subcategory', $offerSubCategory->slug) }}" class="mobile-nested-link">
                                                    @if($offerSubCategory->icon)
                                                        <img src="{{ url('/storage' . $offerSubCategory->icon) }}" alt="">
                                                    @else
                                                        <i class="fal fa-angle-right"></i>
                                                    @endif
                                                    {{ app()->getLocale() == 'ar' ? $offerSubCategory->title_arabic : $offerSubCategory->title_english }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @else
                                <li class="mobile-submenu-item">
                                    <a href="{{ route('offers.category', $offerCategory->slug) }}" class="mobile-submenu-link">
                                        @if($offerCategory->icon)
                                            <img src="{{ url('/storage' . $offerCategory->icon) }}" alt="">
                                        @else
                                            <i class="fal fa-tag"></i>
                                        @endif
                                        {{ app()->getLocale() == 'ar' ? $offerCategory->title_arabic : $offerCategory->title_english }}
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    @elseif($item->item_type === 'dynamic_projects')
                        @foreach($dynamicChildren as $category)
                            @if($category->subCategories && $category->subCategories->count() > 0)
                                <li class="mobile-submenu-item">
                                    <a href="javascript:void(0);" class="mobile-submenu-link mobile-nav-toggle">
                                        @if($category->icon)
                                            <img src="{{ url('/storage' . $category->icon) }}" alt="">
                                        @endif
                                        {{ app()->getLocale() == 'ar' ? ($category->title_arabic ?? $category->title_english) : $category->title_english }}
                                        <i class="fal fa-chevron-right" style="margin-left: auto;"></i>
                                    </a>
                                    <ul class="mobile-nested-submenu">
                                        <li>
                                            <a href="{{ route('category.show', $category->slug) }}" class="mobile-nested-link">
                                                <i class="fal fa-arrow-right"></i>
                                                {{ __('lang.view_all') }}
                                            </a>
                                        </li>
                                        @foreach($category->subCategories as $subCategory)
                                            <li>
                                                <a href="{{ route('subcategory.show', $subCategory->slug) }}" class="mobile-nested-link">
                                                    @if($subCategory->icon)
                                                        <img src="{{ url('/storage' . $subCategory->icon) }}" alt="">
                                                    @endif
                                                    {{ app()->getLocale() == 'ar' ? ($subCategory->title_arabic ?? $subCategory->title_english) : $subCategory->title_english }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @else
                                <li class="mobile-submenu-item">
                                    <a href="{{ route('category.show', $category->slug) }}" class="mobile-submenu-link">
                                        @if($category->icon)
                                            <img src="{{ url('/storage' . $category->icon) }}" alt="">
                                        @endif
                                        {{ app()->getLocale() == 'ar' ? ($category->title_arabic ?? $category->title_english) : $category->title_english }}
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    @elseif($item->item_type === 'dynamic_news')
                        @foreach($dynamicChildren as $newsCategory)
                            <li class="mobile-submenu-item">
                                <a href="{{ route('blogs.index', ['category' => $newsCategory->id]) }}" class="mobile-submenu-link">
                                    <i class="fal fa-folder"></i>
                                    {{ app()->getLocale() == 'ar' ? $newsCategory->name_arabic : $newsCategory->name_english }}
                                </a>
                            </li>
                        @endforeach
                    @elseif($item->item_type === 'dynamic_query')
                        {{-- Dynamic Query Results - Shows Categories/Subcategories --}}
                        @foreach($dynamicChildren as $queryItem)
                            @if($queryItem->is_subcategory ?? false)
                                {{-- Render as subcategory (direct link, no children) --}}
                                <li class="mobile-submenu-item">
                                    <a href="{{ route($queryItem->route_name, $queryItem->slug) }}" class="mobile-submenu-link">
                                        @if($queryItem->icon)
                                            <img src="{{ url('/storage' . $queryItem->icon) }}" alt="">
                                        @else
                                            @if($item->query_source === 'offers')
                                                <i class="fal fa-tag"></i>
                                            @elseif($item->query_source === 'projects')
                                                <i class="fal fa-project-diagram"></i>
                                            @else
                                                <i class="fal fa-folder"></i>
                                            @endif
                                        @endif
                                        {{ app()->getLocale() == 'ar' ? ($queryItem->title_arabic ?? $queryItem->title_english) : $queryItem->title_english }}
                                    </a>
                                </li>
                            @else
                                {{-- Render as category (with subcategories if available) --}}
                                @if($queryItem->subCategories && $queryItem->subCategories->count() > 0)
                                    <li class="mobile-submenu-item">
                                        <a href="javascript:void(0);" class="mobile-submenu-link mobile-nav-toggle">
                                            @if($queryItem->icon)
                                                <img src="{{ url('/storage' . $queryItem->icon) }}" alt="">
                                            @else
                                                @if($item->query_source === 'offers')
                                                    <i class="fal fa-tag"></i>
                                                @elseif($item->query_source === 'projects')
                                                    <i class="fal fa-project-diagram"></i>
                                                @elseif($item->query_source === 'interior')
                                                    <i class="fal fa-couch"></i>
                                                @else
                                                    <i class="fal fa-folder"></i>
                                                @endif
                                            @endif
                                            {{ app()->getLocale() == 'ar' ? ($queryItem->title_arabic ?? $queryItem->title_english) : $queryItem->title_english }}
                                            <i class="fal fa-chevron-right" style="margin-left: auto;"></i>
                                        </a>
                                        <ul class="mobile-nested-submenu">
                                            <li>
                                                <a href="{{ route($queryItem->route_name, $queryItem->slug) }}" class="mobile-nested-link">
                                                    <i class="fal fa-arrow-right"></i>
                                                    {{ __('lang.view_all') }}
                                                </a>
                                            </li>
                                            @foreach($queryItem->subCategories as $subCat)
                                                <li>
                                                    @php
                                                        $subRoute = match($item->query_source) {
                                                            'offers' => 'offers.subcategory',
                                                            'projects' => 'subcategory.show',
                                                            default => 'subcategory.show'
                                                        };
                                                    @endphp
                                                    <a href="{{ route($subRoute, $subCat->slug) }}" class="mobile-nested-link">
                                                        @if($subCat->icon)
                                                            <img src="{{ url('/storage' . $subCat->icon) }}" alt="">
                                                        @else
                                                            <i class="fal fa-angle-right"></i>
                                                        @endif
                                                        {{ app()->getLocale() == 'ar' ? ($subCat->title_arabic ?? $subCat->title_english) : $subCat->title_english }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @else
                                    {{-- Category without subcategories (or interior category) --}}
                                    <li class="mobile-submenu-item">
                                        <a href="{{ route($queryItem->route_name, $queryItem->slug) }}" class="mobile-submenu-link">
                                            @if($queryItem->icon)
                                                <img src="{{ url('/storage' . $queryItem->icon) }}" alt="">
                                            @else
                                                @if($item->query_source === 'offers')
                                                    <i class="fal fa-tag"></i>
                                                @elseif($item->query_source === 'projects')
                                                    <i class="fal fa-project-diagram"></i>
                                                @elseif($item->query_source === 'interior')
                                                    <i class="fal fa-couch"></i>
                                                @else
                                                    <i class="fal fa-folder"></i>
                                                @endif
                                            @endif
                                            {{ app()->getLocale() == 'ar' ? ($queryItem->title_arabic ?? $queryItem->title_english) : $queryItem->title_english }}
                                        </a>
                                    </li>
                                @endif
                            @endif
                        @endforeach
                    @elseif($item->item_type === 'category_with_subs')
                        {{-- Category with Subcategories - Subcategories as clickable children --}}
                        @foreach($dynamicChildren as $subCategory)
                            <li class="mobile-submenu-item">
                                <a href="{{ $subCategory->menu_url ?? '#' }}" class="mobile-submenu-link">
                                    @if($subCategory->icon)
                                        <img src="{{ url('/storage' . $subCategory->icon) }}" alt="">
                                    @else
                                        @if($item->query_source === 'offers')
                                            <i class="fal fa-tag"></i>
                                        @elseif($item->query_source === 'projects')
                                            <i class="fal fa-project-diagram"></i>
                                        @else
                                            <i class="fal fa-folder"></i>
                                        @endif
                                    @endif
                                    {{ app()->getLocale() == 'ar' ? ($subCategory->title_arabic ?? $subCategory->title_english) : $subCategory->title_english }}
                                </a>
                            </li>
                        @endforeach
                    @endif
                @endif
            </ul>
        @else
            <a href="{{ $itemUrl }}" class="mobile-nav-link" @if($item->link_target) target="{{ $item->link_target }}" @endif>
                @if($item->icon)
                    @if($item->icon_type === 'image')
                        <img src="{{ asset('storage' . $item->icon) }}" alt="">
                    @else
                        <i class="{{ $item->icon }}"></i>
                    @endif
                @endif
                {{ $itemTitle }}
            </a>
        @endif
    </div>
@endif
