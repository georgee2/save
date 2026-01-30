{{-- Footer Menu Item Partial --}}
@php
    if (!$item->isVisible()) {
        return;
    }
    
    $itemChildren = $item->relationLoaded('children') ? $item->getRelation('children') : collect();
    $itemUrl = $item->getUrl() ?? '#';
    $itemTitle = $item->getTitle();
@endphp

@if($item->item_type === 'divider')
    <li class="footer-menu-divider"></li>
@elseif($item->item_type === 'header')
    <li class="footer-menu-header">{{ $itemTitle }}</li>
@else
    <li class="footer-menu-item">
        <a href="{{ $itemUrl }}" @if($item->link_target) target="{{ $item->link_target }}" @endif>
            @if($item->icon)
                @if($item->icon_type === 'image')
                    <img src="{{ asset('storage' . $item->icon) }}" alt="" class="footer-menu-icon">
                @else
                    <i class="{{ $item->icon }}"></i>
                @endif
            @endif
            {{ $itemTitle }}
        </a>
        
        @if($itemChildren->isNotEmpty())
            <ul class="footer-submenu">
                @foreach($itemChildren as $child)
                    @include('components.menu-partials.footer-item', ['item' => $child])
                @endforeach
            </ul>
        @endif
    </li>
@endif
