@php
    // Use the children set by buildTree (includes inactive items for admin)
    $itemChildren = $item->relationLoaded('children') ? $item->getRelation('children') : collect();
@endphp
<li class="menu-item {{ !$item->is_active ? 'inactive' : '' }}" data-id="{{ $item->id }}">
    <div class="menu-item-content">
        <div class="drag-handle">
            <i class="fa fa-arrows-v"></i>
        </div>
        
        @if($itemChildren->count() > 0)
        <div class="expand-toggle">
            <i class="fa fa-chevron-down"></i>
        </div>
        @else
        <div style="width: 24px;"></div>
        @endif
        
        <div class="menu-item-icon {{ $item->isDynamic() || $item->isDynamicQuery() || $item->isCategoryWithSubs() ? 'dynamic' : '' }}">
            @if($item->icon)
                <i class="{{ $item->icon }}"></i>
            @else
                <i class="fa fa-link"></i>
            @endif
        </div>
        
        <div class="menu-item-info">
            <div class="menu-item-title">
                {{ $item->title_english }}
                <span class="depth-indicator">{{ $item->depth }}</span>
            </div>
            <div class="menu-item-meta">
                @if($item->title_arabic)
                    <span>{{ $item->title_arabic }}</span> •
                @endif
                @if($item->route_name)
                    <span><i class="fa fa-route"></i> {{ $item->route_name }}</span>
                @elseif($item->url)
                    <span><i class="fa fa-link"></i> {{ Str::limit($item->url, 30) }}</span>
                @endif
            </div>
        </div>
        
        <div class="menu-item-badges">
            @php
                $typeClass = 'type-static';
                $typeLabel = 'Static';
                if ($item->isCategoryWithSubs()) {
                    $typeClass = 'type-dynamic';
                    $typeLabel = 'Category+Subs: ' . ucfirst($item->query_source ?? '');
                } elseif ($item->isDynamicQuery()) {
                    $typeClass = 'type-dynamic';
                    $typeLabel = 'Query: ' . ucfirst($item->query_source ?? 'Custom');
                } elseif ($item->isDynamic()) {
                    $typeClass = 'type-dynamic';
                    $typeLabel = 'Dynamic';
                } elseif ($item->item_type === 'divider') {
                    $typeClass = 'type-divider';
                    $typeLabel = 'Divider';
                } elseif ($item->item_type === 'header') {
                    $typeClass = 'type-header';
                    $typeLabel = 'Header';
                }
            @endphp
            <span class="badge type-badge {{ $typeClass }}">{{ $typeLabel }}</span>
            
            @if($item->isCategoryWithSubs())
                @if($item->query_category_ids && count($item->query_category_ids) > 0)
                    @php
                        $catName = '';
                        if ($item->query_source === 'offers') {
                            $cat = \App\Models\OfferCategory::find($item->query_category_ids[0]);
                            $catName = $cat ? $cat->title_english : '';
                        } elseif ($item->query_source === 'projects') {
                            $cat = \App\Models\EngineeringCategory::find($item->query_category_ids[0]);
                            $catName = $cat ? $cat->title_english : '';
                        }
                    @endphp
                    <span class="badge badge-info" title="Category: {{ $catName }}"><i class="fa fa-folder"></i> {{ Str::limit($catName, 15) }}</span>
                @endif
            @elseif($item->isDynamicQuery())
                @if($item->query_category_ids && count($item->query_category_ids) > 0)
                    <span class="badge badge-info" title="Categories selected"><i class="fa fa-folder"></i> {{ count($item->query_category_ids) }} cat</span>
                @endif
                @if($item->query_subcategory_ids && count($item->query_subcategory_ids) > 0)
                    <span class="badge badge-info" title="Subcategories selected"><i class="fa fa-folder-open"></i> {{ count($item->query_subcategory_ids) }} subcat</span>
                @endif
            @endif
            
            @if(!$item->is_visible_desktop)
                <span class="badge badge-secondary"><i class="fa fa-desktop"></i> Hidden</span>
            @endif
            @if(!$item->is_visible_mobile)
                <span class="badge badge-secondary"><i class="fa fa-mobile"></i> Hidden</span>
            @endif
            @if(!$item->is_active)
                <span class="badge badge-warning"><i class="fa fa-eye-slash"></i> Inactive</span>
            @endif
        </div>
        
        <div class="menu-item-actions">
            <form action="{{ route('admin.menu.item.toggle-status', [$menuId, $item->id]) }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="action-btn btn btn-sm {{ $item->is_active ? 'btn-outline-success' : 'btn-outline-secondary' }}" title="{{ $item->is_active ? 'Deactivate' : 'Activate' }}">
                    <i class="fa {{ $item->is_active ? 'fa-eye' : 'fa-eye-slash' }}"></i>
                </button>
            </form>
            <a href="{{ route('admin.menu.item.edit', [$menuId, $item->id]) }}" class="action-btn btn btn-outline-info btn-sm" title="Edit">
                <i class="fa fa-edit"></i>
            </a>
            <form action="{{ route('admin.menu.item.delete', [$menuId, $item->id]) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this item?')">
                @csrf
                <button type="submit" class="action-btn btn btn-outline-danger btn-sm" title="Delete">
                    <i class="fa fa-trash"></i>
                </button>
            </form>
        </div>
    </div>
    
    @if($itemChildren->count() > 0)
    <ul class="menu-tree">
        @foreach($itemChildren as $child)
            @include('admin::menus.partials.menu-item', ['item' => $child, 'menuId' => $menuId])
        @endforeach
    </ul>
    @else
    <ul class="menu-tree" style="display: none;"></ul>
    @endif
</li>
