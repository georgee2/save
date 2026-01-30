{{-- Simple Menu Item Partial --}}
@php
    if (!$item->isVisible()) {
        return;
    }
    
    $itemChildren = $item->relationLoaded('children') ? $item->getRelation('children') : collect();
    $itemUrl = $item->getUrl() ?? '#';
    $itemTitle = $item->getTitle();
@endphp

@if($item->item_type === 'divider')
    <li class="menu-divider"></li>
@elseif($item->item_type === 'header')
    <li class="menu-header">{{ $itemTitle }}</li>
@else
    <li class="menu-item {{ $itemChildren->isNotEmpty() ? 'has-children' : '' }}">
        <a href="{{ $itemUrl }}" @if($item->link_target) target="{{ $item->link_target }}" @endif>
            @if($item->icon)
                @if($item->icon_type === 'image')
                    <img src="{{ asset('storage' . $item->icon) }}" alt="" class="menu-icon">
                @else
                    <i class="{{ $item->icon }}"></i>
                @endif
            @endif
            <span>{{ $itemTitle }}</span>
        </a>
        
        @if($itemChildren->isNotEmpty())
            <ul class="submenu">
                @foreach($itemChildren as $child)
                    @include('components.menu-partials.simple-item', ['item' => $child])
                @endforeach
            </ul>
        @endif
    </li>
@endif
