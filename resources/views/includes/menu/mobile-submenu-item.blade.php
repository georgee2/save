{{-- Mobile Submenu Item Partial (for nested items inside mobile menus) --}}
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
    
    $hasChildren = $itemChildren->isNotEmpty() || $hasDynamicContent;
    $itemUrl = $item->getUrl() ?? 'javascript:void(0);';
    $itemTitle = $item->getTitle();
    $depth = $depth ?? 1;
@endphp

@if($item->item_type === 'divider')
    <li class="mobile-submenu-divider"></li>
@elseif($item->item_type === 'header')
    <li class="mobile-submenu-header">
        @if($item->icon)
            @if($item->icon_type === 'image')
                <img src="{{ asset('storage' . $item->icon) }}" alt="">
            @else
                <i class="{{ $item->icon }}"></i>
            @endif
        @endif
        {{ $itemTitle }}
    </li>
@else
    <li class="mobile-submenu-item {{ $item->css_class ?? '' }}">
        @if($hasChildren)
            <a href="javascript:void(0);" class="mobile-submenu-link mobile-nav-toggle">
                @if($item->icon)
                    @if($item->icon_type === 'image')
                        <img src="{{ asset('storage' . $item->icon) }}" alt="">
                    @else
                        <i class="{{ $item->icon }}"></i>
                    @endif
                @endif
                {{ $itemTitle }}
                <i class="fal fa-chevron-right" style="margin-left: auto;"></i>
            </a>
            <ul class="mobile-nested-submenu">
                {{-- Link to view all for this item --}}
                @if($item->getUrl())
                    <li>
                        <a href="{{ $itemUrl }}" class="mobile-nested-link">
                            <i class="fal fa-arrow-right"></i>
                            {{ __('lang.view_all') }}
                        </a>
                    </li>
                @endif
                
                {{-- Static children from menu items --}}
                @foreach($itemChildren as $child)
                    <li>
                        <a href="{{ $child->getUrl() ?? '#' }}" class="mobile-nested-link" @if($child->link_target) target="{{ $child->link_target }}" @endif>
                            @if($child->icon)
                                @if($child->icon_type === 'image')
                                    <img src="{{ asset('storage' . $child->icon) }}" alt="">
                                @else
                                    <i class="{{ $child->icon }}"></i>
                                @endif
                            @else
                                <i class="fal fa-angle-right"></i>
                            @endif
                            {{ $child->getTitle() }}
                        </a>
                    </li>
                @endforeach
                
                {{-- Dynamic children --}}
                @if($hasDynamicContent)
                    @if($item->item_type === 'dynamic_services')
                        @foreach($dynamicChildren as $service)
                            <li>
                                <a href="{{ route('services.show', $service->slug) }}" class="mobile-nested-link">
                                    @if($service->icon)
                                        <img src="{{ asset('storage' . $service->icon) }}" alt="">
                                    @else
                                        <i class="fal fa-angle-right"></i>
                                    @endif
                                    {{ app()->getLocale() == 'ar' ? $service->title_arabic : $service->title_english }}
                                </a>
                            </li>
                        @endforeach
                    @elseif($item->item_type === 'dynamic_offers')
                        @foreach($dynamicChildren as $offerCategory)
                            <li>
                                <a href="{{ route('offers.category', $offerCategory->slug) }}" class="mobile-nested-link">
                                    @if($offerCategory->icon)
                                        <img src="{{ url('/storage' . $offerCategory->icon) }}" alt="">
                                    @else
                                        <i class="fal fa-angle-right"></i>
                                    @endif
                                    {{ app()->getLocale() == 'ar' ? $offerCategory->title_arabic : $offerCategory->title_english }}
                                </a>
                            </li>
                        @endforeach
                    @elseif($item->item_type === 'dynamic_projects')
                        @foreach($dynamicChildren as $category)
                            <li>
                                <a href="{{ route('category.show', $category->slug) }}" class="mobile-nested-link">
                                    @if($category->icon)
                                        <img src="{{ url('/storage' . $category->icon) }}" alt="">
                                    @endif
                                    {{ app()->getLocale() == 'ar' ? ($category->title_arabic ?? $category->title_english) : $category->title_english }}
                                </a>
                            </li>
                        @endforeach
                    @elseif($item->item_type === 'dynamic_news')
                        @foreach($dynamicChildren as $newsCategory)
                            <li>
                                <a href="{{ route('blogs.index', ['category' => $newsCategory->id]) }}" class="mobile-nested-link">
                                    <i class="fal fa-folder"></i>
                                    {{ app()->getLocale() == 'ar' ? $newsCategory->name_arabic : $newsCategory->name_english }}
                                </a>
                            </li>
                        @endforeach
                    @elseif($item->item_type === 'dynamic_query')
                        @if($item->query_source === 'offers')
                            @foreach($dynamicChildren as $offer)
                                <li>
                                    <a href="{{ route('offers.show', $offer->slug) }}" class="mobile-nested-link">
                                        <i class="fal fa-tag"></i>
                                        {{ app()->getLocale() == 'ar' ? ($offer->title_arabic ?? $offer->title_english) : $offer->title_english }}
                                    </a>
                                </li>
                            @endforeach
                        @elseif($item->query_source === 'projects')
                            @foreach($dynamicChildren as $project)
                                <li>
                                    <a href="{{ route('projects.show', $project->slug) }}" class="mobile-nested-link">
                                        <i class="fal fa-project-diagram"></i>
                                        {{ app()->getLocale() == 'ar' ? ($project->title_arabic ?? $project->title_english) : $project->title_english }}
                                    </a>
                                </li>
                            @endforeach
                        @elseif($item->query_source === 'interior')
                            @foreach($dynamicChildren as $interior)
                                <li>
                                    <a href="{{ route('interior.show', $interior->slug ?? $interior->id) }}" class="mobile-nested-link">
                                        <i class="fal fa-couch"></i>
                                        {{ app()->getLocale() == 'ar' ? ($interior->title_arabic ?? $interior->title_english) : $interior->title_english }}
                                    </a>
                                </li>
                            @endforeach
                        @endif
                    @endif
                @endif
            </ul>
        @else
            <a href="{{ $itemUrl }}" class="mobile-submenu-link" @if($item->link_target) target="{{ $item->link_target }}" @endif>
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
    </li>
@endif
