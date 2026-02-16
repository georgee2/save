{{-- Desktop Menu Item Partial (Recursive) --}}
@php
    $itemChildren = $item->relationLoaded('children') ? $item->getRelation('children') : collect();
    $dynamicChildren = collect();
    $hasDynamicContent = false;
    
    // Check visibility
    if (!$item->isVisible()) {
        return;
    }
    
    // Check desktop visibility
    if (!$item->is_visible_desktop) {
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
    $itemId = 'navbar-item-' . $item->id;
@endphp

@if($item->item_type === 'divider')
    <li class="dropdown-divider"></li>
@elseif($item->item_type === 'header')
    <li class="dropdown-header">{{ $itemTitle }}</li>
@else
    @php
        // For category_with_subs, we want the parent to be clickable (no data-toggle)
        $isClickableParent = $item->item_type === 'category_with_subs';
    @endphp
    <li id="{{ $itemId }}" 
        aria-haspopup="{{ $hasChildren ? 'true' : 'false' }}" 
        aria-expanded="false"
        class="nav-item {{ $hasChildren ? 'dropdown' : '' }} py-2 py-lg-5 px-0 px-lg-4 {{ $item->css_class ?? '' }}">
        
        <a class="nav-link {{ $hasChildren ? 'dropdown-toggle' : '' }} p-0"
           href="{{ $itemUrl }}" 
           @if($hasChildren && !$isClickableParent) data-toggle="dropdown" @endif
           @if($item->link_target) target="{{ $item->link_target }}" @endif>
            @if($item->icon)
                @if($item->icon_type === 'image')
                    <img src="{{ asset('storage' . $item->icon) }}" alt="" style="width: 18px; height: 18px; margin-right: 8px; object-fit: contain;">
                @else
                    <i class="{{ $item->icon }} mr-2"></i>
                @endif
            @endif
            {{ $itemTitle }}
            @if($hasChildren)
                <span class="caret"></span>
            @endif
        </a>
        
        @if($hasChildren)
            <ul class="dropdown-menu pt-3 pb-0 pb-lg-3" aria-labelledby="{{ $itemId }}" style="min-width: 320px;">
                {{-- Static children from menu items --}}
                @foreach($itemChildren as $child)
                    @include('includes.menu.desktop-dropdown-item', ['item' => $child, 'depth' => ($depth ?? 0) + 1])
                @endforeach
                
                {{-- Dynamic children based on item type --}}
                @if($hasDynamicContent)
                    @if($item->item_type === 'dynamic_services')
                        @foreach($dynamicChildren as $service)
                            <li class="dropdown-item dropdown dropright">
                                <a id="navbar-link-service-{{ $service->id }}"
                                   class="dropdown-link @if($service->subServices && $service->subServices->count() > 0) dropdown-toggle @endif"
                                   href="{{ route('services.show', $service->slug) }}">
                                    @if($service->icon)
                                        <img src="{{ asset('storage' . $service->icon) }}" alt="" style="width: 18px; height: 18px; margin-right: 8px; object-fit: contain;">
                                    @else
                                        <i class="fal fa-cog mr-2"></i>
                                    @endif
                                    {{ app()->getLocale() == 'ar' ? $service->title_arabic : $service->title_english }}
                                </a>
                                @if($service->subServices && $service->subServices->count() > 0)
                                    <ul class="dropdown-menu dropdown-submenu pt-3 pb-0 pb-lg-3" style="min-width: 280px;">
                                        @foreach($service->subServices as $subService)
                                            <li class="dropdown-item">
                                                <a class="dropdown-link" href="{{ route('services.show', $subService->slug) }}">
                                                    @if($subService->icon)
                                                        <img src="{{ asset('storage' . $subService->icon) }}" alt="" style="width: 16px; height: 16px; margin-right: 6px; object-fit: contain;">
                                                    @else
                                                        <i class="fal fa-angle-right mr-2"></i>
                                                    @endif
                                                    {{ app()->getLocale() == 'ar' ? $subService->title_arabic : $subService->title_english }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endforeach
                    @elseif($item->item_type === 'dynamic_offers')
                        @foreach($dynamicChildren as $offerCategory)
                            <li class="dropdown-item dropdown dropright">
                                <a id="navbar-link-offer-category-{{ $offerCategory->id }}"
                                   class="dropdown-link @if($offerCategory->subCategories && $offerCategory->subCategories->count() > 0) dropdown-toggle @endif"
                                   href="{{ route('offers.category', $offerCategory->slug) }}">
                                    @if($offerCategory->icon)
                                        <img src="{{ url('/storage' . $offerCategory->icon) }}" alt="" style="width: 18px; height: 18px; margin-right: 8px; object-fit: contain;">
                                    @else
                                        <i class="fal fa-tag mr-2"></i>
                                    @endif
                                    {{ app()->getLocale() == 'ar' ? $offerCategory->title_arabic : $offerCategory->title_english }}
                                </a>
                                @if($offerCategory->subCategories && $offerCategory->subCategories->count() > 0)
                                    <ul class="dropdown-menu dropdown-submenu pt-3 pb-0 pb-lg-3" style="min-width: 280px;">
                                        @foreach($offerCategory->subCategories as $offerSubCategory)
                                            <li class="dropdown-item">
                                                <a class="dropdown-link" href="{{ route('offers.subcategory', $offerSubCategory->slug) }}">
                                                    @if($offerSubCategory->icon)
                                                        <img src="{{ url('/storage' . $offerSubCategory->icon) }}" alt="" style="width: 16px; height: 16px; margin-right: 6px; object-fit: contain;">
                                                    @else
                                                        <i class="fal fa-angle-right mr-2"></i>
                                                    @endif
                                                    {{ app()->getLocale() == 'ar' ? $offerSubCategory->title_arabic : $offerSubCategory->title_english }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endforeach
                    @elseif($item->item_type === 'dynamic_projects')
                        @foreach($dynamicChildren as $category)
                            <li class="dropdown-item dropdown dropright">
                                <a id="navbar-link-category-{{ $category->id }}"
                                   class="dropdown-link @if($category->subCategories && $category->subCategories->count() > 0) dropdown-toggle @endif"
                                   href="{{ route('category.show', $category->slug) }}">
                                    @if($category->icon)
                                        <img src="{{ url('/storage' . $category->icon) }}" alt="" style="width: 18px; height: 18px; margin-right: 8px; object-fit: contain;">
                                    @endif
                                    {{ app()->getLocale() == 'ar' ? ($category->title_arabic ?? $category->title_english) : $category->title_english }}
                                </a>
                                @if($category->subCategories && $category->subCategories->count() > 0)
                                    <ul class="dropdown-menu dropdown-submenu pt-3 pb-0 pb-lg-3" style="min-width: 280px;">
                                        @foreach($category->subCategories as $subCategory)
                                            <li class="dropdown-item">
                                                <a class="dropdown-link" href="{{ route('subcategory.show', $subCategory->slug) }}">
                                                    @if($subCategory->icon)
                                                        <img src="{{ url('/storage' . $subCategory->icon) }}" alt="" style="width: 16px; height: 16px; margin-right: 6px; object-fit: contain;">
                                                    @endif
                                                    {{ app()->getLocale() == 'ar' ? ($subCategory->title_arabic ?? $subCategory->title_english) : $subCategory->title_english }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endforeach
                    @elseif($item->item_type === 'dynamic_news')
                        @foreach($dynamicChildren as $newsCategory)
                            <li class="dropdown-item">
                                <a class="dropdown-link" href="{{ route('blogs.index', ['category' => $newsCategory->id]) }}">
                                    <i class="fal fa-folder mr-2"></i>
                                    {{ app()->getLocale() == 'ar' ? $newsCategory->name_arabic : $newsCategory->name_english }}
                                </a>
                            </li>
                        @endforeach
                    @elseif($item->item_type === 'dynamic_query')
                        {{-- Dynamic Query Results - Shows Categories/Subcategories --}}
                        @foreach($dynamicChildren as $queryItem)
                            @if($queryItem->is_subcategory ?? false)
                                {{-- Render as subcategory (direct link, no children) --}}
                                <li class="dropdown-item">
                                    <a class="dropdown-link" href="{{ route($queryItem->route_name, $queryItem->slug) }}">
                                        @if($queryItem->icon)
                                            <img src="{{ url('/storage' . $queryItem->icon) }}" alt="" style="width: 18px; height: 18px; margin-right: 8px; object-fit: contain;">
                                        @else
                                            @if($item->query_source === 'offers')
                                                <i class="fal fa-tag mr-2"></i>
                                            @elseif($item->query_source === 'projects')
                                                <i class="fal fa-project-diagram mr-2"></i>
                                            @else
                                                <i class="fal fa-folder mr-2"></i>
                                            @endif
                                        @endif
                                        {{ app()->getLocale() == 'ar' ? ($queryItem->title_arabic ?? $queryItem->title_english) : $queryItem->title_english }}
                                    </a>
                                </li>
                            @else
                                {{-- Render as category (with subcategories dropdown) --}}
                                <li class="dropdown-item dropdown dropright">
                                    <a id="navbar-link-query-{{ $queryItem->id }}"
                                       class="dropdown-link @if($queryItem->subCategories && $queryItem->subCategories->count() > 0) dropdown-toggle @endif"
                                       href="{{ route($queryItem->route_name, $queryItem->slug) }}">
                                        @if($queryItem->icon)
                                            <img src="{{ url('/storage' . $queryItem->icon) }}" alt="" style="width: 18px; height: 18px; margin-right: 8px; object-fit: contain;">
                                        @else
                                            @if($item->query_source === 'offers')
                                                <i class="fal fa-tag mr-2"></i>
                                            @elseif($item->query_source === 'projects')
                                                <i class="fal fa-project-diagram mr-2"></i>
                                            @elseif($item->query_source === 'interior')
                                                <i class="fal fa-couch mr-2"></i>
                                            @else
                                                <i class="fal fa-folder mr-2"></i>
                                            @endif
                                        @endif
                                        {{ app()->getLocale() == 'ar' ? ($queryItem->title_arabic ?? $queryItem->title_english) : $queryItem->title_english }}
                                    </a>
                                    @if($queryItem->subCategories && $queryItem->subCategories->count() > 0)
                                        <ul class="dropdown-menu dropdown-submenu pt-3 pb-0 pb-lg-3" style="min-width: 280px;">
                                            @foreach($queryItem->subCategories as $subCat)
                                                <li class="dropdown-item">
                                                    @php
                                                        // Determine subcategory route based on source
                                                        $subRoute = match($item->query_source) {
                                                            'offers' => 'offers.subcategory',
                                                            'projects' => 'subcategory.show',
                                                            default => 'subcategory.show'
                                                        };
                                                    @endphp
                                                    <a class="dropdown-link" href="{{ route($subRoute, $subCat->slug) }}">
                                                        @if($subCat->icon)
                                                            <img src="{{ url('/storage' . $subCat->icon) }}" alt="" style="width: 16px; height: 16px; margin-right: 6px; object-fit: contain;">
                                                        @else
                                                            <i class="fal fa-angle-right mr-2"></i>
                                                        @endif
                                                        {{ app()->getLocale() == 'ar' ? ($subCat->title_arabic ?? $subCat->title_english) : $subCat->title_english }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endif
                        @endforeach
                    @elseif($item->item_type === 'category_with_subs')
                        {{-- Category with Subcategories - Subcategories as clickable children --}}
                        @foreach($dynamicChildren as $subCategory)
                            <li class="dropdown-item">
                                <a class="dropdown-link" href="{{ $subCategory->menu_url ?? '#' }}">
                                    @if($subCategory->icon)
                                        <img src="{{ url('/storage' . $subCategory->icon) }}" alt="" style="width: 18px; height: 18px; margin-right: 8px; object-fit: contain;">
                                    @else
                                        @if($item->query_source === 'offers')
                                            <i class="fal fa-tag mr-2"></i>
                                        @elseif($item->query_source === 'projects')
                                            <i class="fal fa-project-diagram mr-2"></i>
                                        @else
                                            <i class="fal fa-folder mr-2"></i>
                                        @endif
                                    @endif
                                    {{ app()->getLocale() == 'ar' ? ($subCategory->title_arabic ?? $subCategory->title_english) : $subCategory->title_english }}
                                </a>
                            </li>
                        @endforeach
                    @endif
                @endif
            </ul>
        @endif
    </li>
@endif
