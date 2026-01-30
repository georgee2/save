{{-- Desktop Dropdown Menu Item Partial (for nested items inside dropdowns) --}}
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
    
    $hasChildren = $itemChildren->isNotEmpty() || $hasDynamicContent;
    $itemUrl = $item->getUrl() ?? 'javascript:void(0);';
    $itemTitle = $item->getTitle();
    $itemId = 'navbar-link-' . $item->id;
    $depth = $depth ?? 1;
@endphp

@if($item->item_type === 'divider')
    <li class="dropdown-divider"></li>
@elseif($item->item_type === 'header')
    <li class="dropdown-header font-weight-600">
        @if($item->icon)
            @if($item->icon_type === 'image')
                <img src="{{ asset('storage' . $item->icon) }}" alt="" style="width: 18px; height: 18px; margin-right: 8px; object-fit: contain;">
            @else
                <i class="{{ $item->icon }} mr-2"></i>
            @endif
        @endif
        {{ $itemTitle }}
    </li>
@else
    <li class="dropdown-item {{ $hasChildren ? 'dropdown dropright' : '' }} {{ $item->css_class ?? '' }}">
        <a id="{{ $itemId }}"
           class="dropdown-link {{ $hasChildren ? 'dropdown-toggle' : '' }}"
           href="{{ $itemUrl }}"
           @if($item->link_target) target="{{ $item->link_target }}" @endif>
            @if($item->icon)
                @if($item->icon_type === 'image')
                    <img src="{{ asset('storage' . $item->icon) }}" alt="" style="width: 18px; height: 18px; margin-right: 8px; object-fit: contain;">
                @else
                    <i class="{{ $item->icon }} mr-2"></i>
                @endif
            @endif
            {{ $itemTitle }}
        </a>
        
        @if($hasChildren)
            <ul class="dropdown-menu dropdown-submenu pt-3 pb-0 pb-lg-3" style="min-width: 280px;" aria-labelledby="{{ $itemId }}">
                {{-- Static children from menu items --}}
                @foreach($itemChildren as $child)
                    @include('includes.menu.desktop-dropdown-item', ['item' => $child, 'depth' => $depth + 1])
                @endforeach
                
                {{-- Dynamic children based on item type (same rendering as parent) --}}
                @if($hasDynamicContent)
                    @if($item->item_type === 'dynamic_services')
                        @foreach($dynamicChildren as $service)
                            <li class="dropdown-item {{ $service->subServices && $service->subServices->count() > 0 ? 'dropdown dropright' : '' }}">
                                <a class="dropdown-link {{ $service->subServices && $service->subServices->count() > 0 ? 'dropdown-toggle' : '' }}"
                                   href="{{ route('services.show', $service->slug) }}">
                                    @if($service->icon)
                                        <img src="{{ asset('storage' . $service->icon) }}" alt="" style="width: 16px; height: 16px; margin-right: 6px; object-fit: contain;">
                                    @else
                                        <i class="fal fa-cog mr-2"></i>
                                    @endif
                                    {{ app()->getLocale() == 'ar' ? $service->title_arabic : $service->title_english }}
                                </a>
                                @if($service->subServices && $service->subServices->count() > 0)
                                    <ul class="dropdown-menu dropdown-submenu pt-3 pb-0 pb-lg-3" style="min-width: 260px;">
                                        @foreach($service->subServices as $subService)
                                            <li class="dropdown-item">
                                                <a class="dropdown-link" href="{{ route('services.show', $subService->slug) }}">
                                                    @if($subService->icon)
                                                        <img src="{{ asset('storage' . $subService->icon) }}" alt="" style="width: 14px; height: 14px; margin-right: 6px; object-fit: contain;">
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
                            <li class="dropdown-item {{ $offerCategory->subCategories && $offerCategory->subCategories->count() > 0 ? 'dropdown dropright' : '' }}">
                                <a class="dropdown-link {{ $offerCategory->subCategories && $offerCategory->subCategories->count() > 0 ? 'dropdown-toggle' : '' }}"
                                   href="{{ route('offers.category', $offerCategory->slug) }}">
                                    @if($offerCategory->icon)
                                        <img src="{{ url('/storage' . $offerCategory->icon) }}" alt="" style="width: 16px; height: 16px; margin-right: 6px; object-fit: contain;">
                                    @else
                                        <i class="fal fa-tag mr-2"></i>
                                    @endif
                                    {{ app()->getLocale() == 'ar' ? $offerCategory->title_arabic : $offerCategory->title_english }}
                                </a>
                                @if($offerCategory->subCategories && $offerCategory->subCategories->count() > 0)
                                    <ul class="dropdown-menu dropdown-submenu pt-3 pb-0 pb-lg-3" style="min-width: 260px;">
                                        @foreach($offerCategory->subCategories as $offerSubCategory)
                                            <li class="dropdown-item">
                                                <a class="dropdown-link" href="{{ route('offers.subcategory', $offerSubCategory->slug) }}">
                                                    @if($offerSubCategory->icon)
                                                        <img src="{{ url('/storage' . $offerSubCategory->icon) }}" alt="" style="width: 14px; height: 14px; margin-right: 6px; object-fit: contain;">
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
                            <li class="dropdown-item {{ $category->subCategories && $category->subCategories->count() > 0 ? 'dropdown dropright' : '' }}">
                                <a class="dropdown-link {{ $category->subCategories && $category->subCategories->count() > 0 ? 'dropdown-toggle' : '' }}"
                                   href="{{ route('category.show', $category->slug) }}">
                                    @if($category->icon)
                                        <img src="{{ url('/storage' . $category->icon) }}" alt="" style="width: 16px; height: 16px; margin-right: 6px; object-fit: contain;">
                                    @endif
                                    {{ app()->getLocale() == 'ar' ? ($category->title_arabic ?? $category->title_english) : $category->title_english }}
                                </a>
                                @if($category->subCategories && $category->subCategories->count() > 0)
                                    <ul class="dropdown-menu dropdown-submenu pt-3 pb-0 pb-lg-3" style="min-width: 260px;">
                                        @foreach($category->subCategories as $subCategory)
                                            <li class="dropdown-item">
                                                <a class="dropdown-link" href="{{ route('subcategory.show', $subCategory->slug) }}">
                                                    @if($subCategory->icon)
                                                        <img src="{{ url('/storage' . $subCategory->icon) }}" alt="" style="width: 14px; height: 14px; margin-right: 6px; object-fit: contain;">
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
                        {{-- Dynamic Query Results --}}
                        @if($item->query_source === 'offers')
                            @foreach($dynamicChildren as $offer)
                                <li class="dropdown-item">
                                    <a class="dropdown-link" href="{{ route('offers.show', $offer->slug) }}">
                                        @if($offer->image)
                                            <img src="{{ url('/storage' . $offer->image) }}" alt="" style="width: 16px; height: 16px; margin-right: 6px; object-fit: contain;">
                                        @else
                                            <i class="fal fa-tag mr-2"></i>
                                        @endif
                                        {{ app()->getLocale() == 'ar' ? ($offer->title_arabic ?? $offer->title_english) : $offer->title_english }}
                                    </a>
                                </li>
                            @endforeach
                        @elseif($item->query_source === 'projects')
                            @foreach($dynamicChildren as $project)
                                <li class="dropdown-item">
                                    <a class="dropdown-link" href="{{ route('projects.show', $project->slug) }}">
                                        @if($project->image)
                                            <img src="{{ url('/storage' . $project->image) }}" alt="" style="width: 16px; height: 16px; margin-right: 6px; object-fit: contain;">
                                        @else
                                            <i class="fal fa-project-diagram mr-2"></i>
                                        @endif
                                        {{ app()->getLocale() == 'ar' ? ($project->title_arabic ?? $project->title_english) : $project->title_english }}
                                    </a>
                                </li>
                            @endforeach
                        @elseif($item->query_source === 'interior')
                            @foreach($dynamicChildren as $interior)
                                <li class="dropdown-item">
                                    <a class="dropdown-link" href="{{ route('interior.show', $interior->slug ?? $interior->id) }}">
                                        @if($interior->image)
                                            <img src="{{ url('/storage' . $interior->image) }}" alt="" style="width: 16px; height: 16px; margin-right: 6px; object-fit: contain;">
                                        @else
                                            <i class="fal fa-couch mr-2"></i>
                                        @endif
                                        {{ app()->getLocale() == 'ar' ? ($interior->title_arabic ?? $interior->title_english) : $interior->title_english }}
                                    </a>
                                </li>
                            @endforeach
                        @endif
                    @endif
                @endif
            </ul>
        @endif
    </li>
@endif
