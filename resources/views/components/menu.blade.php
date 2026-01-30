{{--
    Reusable Menu Component
    
    Usage:
    @include('components.menu', ['slug' => 'footer-menu'])
    @include('components.menu', ['location' => 'footer'])
    @include('components.menu', ['menu' => $menuObject])
    
    Optional parameters:
    - type: 'desktop' (default), 'mobile', 'simple', 'footer'
    - class: Additional CSS classes for the menu container
    - showTitle: Whether to show menu title (default: false)
--}}

@php
    use App\Models\Menu;
    
    // Get menu from various sources
    $menuToRender = null;
    
    if (isset($menu) && $menu instanceof Menu) {
        $menuToRender = $menu;
    } elseif (isset($slug)) {
        $menuToRender = Menu::getBySlug($slug);
    } elseif (isset($location)) {
        $menuToRender = Menu::getByLocation($location);
    }
    
    // Get menu items if menu exists
    $menuItems = $menuToRender ? $menuToRender->getHierarchicalItems() : collect();
    
    // Default values
    $menuType = $type ?? 'desktop';
    $containerClass = $class ?? '';
    $showMenuTitle = $showTitle ?? false;
@endphp

@if($menuToRender && $menuItems->isNotEmpty())
    @if($showMenuTitle)
        <h4 class="menu-title">{{ $menuToRender->getTitle() }}</h4>
    @endif
    
    @switch($menuType)
        @case('desktop')
            {{-- Desktop Navigation Style --}}
            <ul class="navbar-nav hover-menu {{ $containerClass }}">
                @foreach($menuItems as $item)
                    @include('includes.menu.desktop-item', ['item' => $item, 'depth' => 0])
                @endforeach
            </ul>
            @break
            
        @case('mobile')
            {{-- Mobile Sidebar Style --}}
            <div class="mobile-menu-container {{ $containerClass }}">
                @foreach($menuItems as $item)
                    @include('includes.menu.mobile-item', ['item' => $item, 'depth' => 0])
                @endforeach
            </div>
            @break
            
        @case('footer')
            {{-- Footer Menu Style --}}
            <ul class="footer-menu {{ $containerClass }}">
                @foreach($menuItems as $item)
                    @include('components.menu-partials.footer-item', ['item' => $item])
                @endforeach
            </ul>
            @break
            
        @case('simple')
            {{-- Simple List Style --}}
            <ul class="simple-menu {{ $containerClass }}">
                @foreach($menuItems as $item)
                    @include('components.menu-partials.simple-item', ['item' => $item])
                @endforeach
            </ul>
            @break
            
        @case('dropdown')
            {{-- Dropdown Style (for sidebar widgets) --}}
            <div class="dropdown-menu-container {{ $containerClass }}">
                @foreach($menuItems as $item)
                    @include('components.menu-partials.dropdown-item', ['item' => $item])
                @endforeach
            </div>
            @break
            
        @default
            {{-- Default to simple list --}}
            <ul class="menu-list {{ $containerClass }}">
                @foreach($menuItems as $item)
                    @if($item->isVisible())
                        <li>
                            <a href="{{ $item->getUrl() ?? '#' }}">{{ $item->getTitle() }}</a>
                        </li>
                    @endif
                @endforeach
            </ul>
    @endswitch
@endif
