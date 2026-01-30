@extends('admin::layouts.master')
@section('title', 'Menu Items - ' . $menu->title_english)

@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<style>
    .menu-tree {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .menu-tree .menu-tree {
        padding-left: 30px;
        margin-top: 5px;
    }
    
    .menu-item {
        background: #fff;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        margin-bottom: 8px;
        transition: all 0.3s ease;
    }
    
    .menu-item:hover {
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .menu-item.dragging {
        opacity: 0.5;
        background: #e3f2fd;
    }
    
    .menu-item.drag-over {
        border: 2px dashed #19868b;
    }
    
    .menu-item-content {
        display: flex;
        align-items: center;
        padding: 12px 15px;
        gap: 12px;
    }
    
    .drag-handle {
        cursor: grab;
        color: #9e9e9e;
        font-size: 16px;
    }
    
    .drag-handle:active {
        cursor: grabbing;
    }
    
    .menu-item-icon {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        background: #f8f9fa;
        color: #666;
        font-size: 14px;
    }
    
    .menu-item-icon.dynamic {
        background: linear-gradient(135deg, #19868b 0%, #25a5aa 100%);
        color: #fff;
    }
    
    .menu-item-info {
        flex-grow: 1;
    }
    
    .menu-item-title {
        font-weight: 600;
        color: #333;
        margin-bottom: 2px;
    }
    
    .menu-item-meta {
        font-size: 12px;
        color: #999;
    }
    
    .menu-item-badges {
        display: flex;
        gap: 5px;
        flex-wrap: wrap;
    }
    
    .menu-item-badges .badge {
        font-size: 10px;
        padding: 3px 8px;
    }
    
    .menu-item-actions {
        display: flex;
        gap: 5px;
    }
    
    .action-btn {
        width: 32px;
        height: 32px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        transition: all 0.2s ease;
    }
    
    .action-btn:hover {
        transform: scale(1.1);
    }
    
    .menu-item.inactive {
        opacity: 0.6;
        background: #f8f9fa;
    }
    
    .type-badge {
        font-size: 10px;
        padding: 2px 6px;
        border-radius: 4px;
    }
    
    .type-static { background: #e3f2fd; color: #1565c0; }
    .type-dynamic { background: #e8f5e9; color: #2e7d32; }
    .type-divider { background: #fce4ec; color: #c2185b; }
    .type-header { background: #fff3e0; color: #ef6c00; }
    
    .expand-toggle {
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        border-radius: 4px;
        transition: all 0.2s ease;
    }
    
    .expand-toggle:hover {
        background: #e9ecef;
    }
    
    .expand-toggle i {
        transition: transform 0.2s ease;
    }
    
    .menu-item.collapsed > .menu-tree {
        display: none;
    }
    
    .menu-item.collapsed .expand-toggle i {
        transform: rotate(-90deg);
    }
    
    .empty-children-zone {
        min-height: 40px;
        border: 2px dashed #dee2e6;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #adb5bd;
        font-size: 12px;
        margin-left: 30px;
        margin-top: 5px;
    }
    
    .depth-indicator {
        width: 20px;
        height: 20px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: #e9ecef;
        font-size: 10px;
        font-weight: 600;
        color: #666;
    }
</style>
@endsection

@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Admin')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a href="{{route('admin.menu.index')}}" class="breadcrumbs__item"><i class="fa fa-bars"></i> Menus</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-list"></i> {{ $menu->title_english }}</a>
        </nav>

        <div class="col-lg-12">
            <hr>
            
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <h4 class="mt-0 header-title">
                                <i class="fa fa-list"></i> Menu Items: {{ $menu->title_english }}
                                @if($menu->is_primary)
                                <span class="badge badge-info ml-2"><i class="fa fa-star"></i> Primary</span>
                                @endif
                            </h4>
                        </div>
                        <div class="col-sm-6 text-right">
                            <a href="{{ route('admin.menu.items.trashed', $menu->id) }}" class="btn btn-danger btn-sm mr-2">
                                <i class="fa fa-trash"></i> Trashed
                            </a>
                            <a href="{{ route('admin.menu.item.create', $menu->id) }}" class="btn btn-success btn-sm">
                                <i class="fa fa-plus"></i> Add New Item
                            </a>
                        </div>
                    </div>
                    <hr>
                    
                    <div class="alert alert-info" style="background: #e3f2fd; border-left: 4px solid #2196f3; color: #1565c0;">
                        <i class="fa fa-info-circle"></i> <strong>Tip:</strong> Drag and drop items to reorder. You can also drag items into other items to create nested menus. <span class="badge badge-success">Dynamic</span> items automatically pull content from the database.
                    </div>
                    
                    @if($menuItems->count() > 0)
                    <ul class="menu-tree" id="menu-tree">
                        @foreach($menuItems as $item)
                            @include('admin::menus.partials.menu-item', ['item' => $item, 'menuId' => $menu->id])
                        @endforeach
                    </ul>
                    @else
                    <div class="alert alert-warning text-center">
                        <i class="fa fa-exclamation-triangle fa-2x mb-2"></i>
                        <p class="mb-0">No menu items found. <a href="{{ route('admin.menu.item.create', $menu->id) }}">Add your first item</a>.</p>
                    </div>
                    @endif
                    
                    <hr>
                    
                    <div class="form-group">
                        <a href="{{ route('admin.menu.index') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left"></i> Back to Menus
                        </a>
                        <a href="{{ route('admin.menu.edit', $menu->id) }}" class="btn btn-info">
                            <i class="fa fa-edit"></i> Edit Menu Settings
                        </a>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
$(document).ready(function() {
    // Initialize Sortable for nested drag and drop
    function initSortable(el) {
        new Sortable(el, {
            group: 'menu-items',
            animation: 150,
            fallbackOnBody: true,
            swapThreshold: 0.65,
            handle: '.drag-handle',
            ghostClass: 'dragging',
            chosenClass: 'drag-over',
            onEnd: function(evt) {
                saveMenuOrder();
            }
        });
    }
    
    // Initialize all menu trees
    document.querySelectorAll('.menu-tree').forEach(function(tree) {
        initSortable(tree);
    });
    
    // Toggle expand/collapse
    $(document).on('click', '.expand-toggle', function() {
        $(this).closest('.menu-item').toggleClass('collapsed');
    });
    
    // Save menu order
    function saveMenuOrder() {
        const items = [];
        let order = 0;
        
        function processTree(tree, parentId, depth) {
            $(tree).children('.menu-item').each(function() {
                const $item = $(this);
                const itemId = $item.data('id');
                
                items.push({
                    id: itemId,
                    order: ++order,
                    parent_id: parentId,
                    depth: depth
                });
                
                // Process children
                const $childTree = $item.children('.menu-tree');
                if ($childTree.length) {
                    processTree($childTree[0], itemId, depth + 1);
                }
            });
        }
        
        processTree(document.getElementById('menu-tree'), null, 0);
        
        if (items.length === 0) return;
        
        fetch('{{ route("admin.menu.items.update-order", $menu->id) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ items: items })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Order Updated!',
                    text: data.message,
                    timer: 1500,
                    showConfirmButton: false
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to update order. Please try again.'
            });
        });
    }
});
</script>
@endsection
