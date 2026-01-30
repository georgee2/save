{{-- Dropdown Menu Item Partial (for sidebar widgets) --}}
@php
    if (!$item->isVisible()) {
        return;
    }
    
    $itemChildren = $item->relationLoaded('children') ? $item->getRelation('children') : collect();
    $dynamicChildren = collect();
    $hasDynamicContent = false;
    
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
    $itemUrl = $item->getUrl() ?? '#';
    $itemTitle = $item->getTitle();
@endphp

@if($item->item_type === 'divider')
    <div class="dropdown-divider"></div>
@elseif($item->item_type === 'header')
    <div class="dropdown-header">{{ $itemTitle }}</div>
@else
    <div class="dropdown-menu-item {{ $hasChildren ? 'has-submenu' : '' }}">
        <a href="{{ $itemUrl }}" class="dropdown-link" @if($item->link_target) target="{{ $item->link_target }}" @endif>
            @if($item->icon)
                @if($item->icon_type === 'image')
                    <img src="{{ asset('storage' . $item->icon) }}" alt="" class="dropdown-icon">
                @else
                    <i class="{{ $item->icon }}"></i>
                @endif
            @endif
            <span>{{ $itemTitle }}</span>
            @if($hasChildren)
                <i class="fal fa-chevron-right dropdown-arrow"></i>
            @endif
        </a>
        
        @if($hasChildren)
            <div class="dropdown-submenu">
                {{-- Static children --}}
                @foreach($itemChildren as $child)
                    @include('components.menu-partials.dropdown-item', ['item' => $child])
                @endforeach
                
                {{-- Dynamic children --}}
                @if($hasDynamicContent)
                    @foreach($dynamicChildren as $dynamicItem)
                        <a href="{{ $dynamicItem->url ?? '#' }}" class="dropdown-link">
                            @if(isset($dynamicItem->icon))
                                <img src="{{ asset('storage' . $dynamicItem->icon) }}" alt="" class="dropdown-icon">
                            @endif
                            <span>{{ app()->getLocale() == 'ar' ? ($dynamicItem->title_arabic ?? $dynamicItem->title_english ?? $dynamicItem->name_arabic ?? '') : ($dynamicItem->title_english ?? $dynamicItem->name_english ?? '') }}</span>
                        </a>
                    @endforeach
                @endif
            </div>
        @endif
    </div>
@endif
