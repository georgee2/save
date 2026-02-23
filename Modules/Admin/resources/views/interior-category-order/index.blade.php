@extends('admin::layouts.master')
@section('title', 'Interior Category Order')

@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<style>
    .settings-card {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        margin-bottom: 20px;
    }
    .settings-header {
        background: linear-gradient(135deg, #19868b 0%, #0d6b6f 100%);
        color: white;
        padding: 20px;
        border-radius: 10px 10px 0 0;
    }
    .settings-header h4 {
        margin: 0;
        font-weight: 600;
    }
    .settings-header p {
        margin: 5px 0 0;
        opacity: 0.9;
        font-size: 14px;
    }
    .settings-body {
        padding: 20px;
    }
    .category-item {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 15px;
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        margin-bottom: 10px;
        transition: all 0.3s ease;
    }
    .category-item:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .category-item.dragging {
        opacity: 0.5;
        background: #e3f2fd;
    }
    .category-item.unpublished {
        opacity: 0.6;
        background: #f5f5f5;
    }
    .drag-handle {
        cursor: grab;
        color: #adb5bd;
        font-size: 18px;
    }
    .drag-handle:hover {
        color: #19868b;
    }
    .drag-handle:active {
        cursor: grabbing;
    }
    .order-badge {
        background: #19868b;
        color: white;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        font-weight: 600;
        flex-shrink: 0;
    }
    .category-image {
        width: 80px;
        height: 60px;
        border-radius: 6px;
        object-fit: cover;
        flex-shrink: 0;
    }
    .category-image-placeholder {
        width: 80px;
        height: 60px;
        border-radius: 6px;
        background: #e9ecef;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #adb5bd;
        font-size: 24px;
        flex-shrink: 0;
    }
    .category-info {
        flex: 1;
        min-width: 0;
    }
    .category-title {
        font-weight: 600;
        color: #2c3e50;
        font-size: 16px;
        margin-bottom: 3px;
    }
    .category-title-arabic {
        font-size: 13px;
        color: #6c757d;
    }
    .category-stats {
        display: flex;
        align-items: center;
        gap: 15px;
    }
    .stat-badge {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 13px;
        color: #6c757d;
    }
    .stat-badge i {
        color: #19868b;
    }
    .status-toggle {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .status-toggle.published {
        background: #d4edda;
        color: #155724;
    }
    .status-toggle.unpublished {
        background: #f8d7da;
        color: #721c24;
    }
    .status-toggle:hover {
        transform: scale(1.05);
    }
    .btn-order-images {
        background: #007bff;
        color: white;
        border: none;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .btn-order-images:hover {
        background: #0056b3;
        color: white;
        text-decoration: none;
    }
    .info-box {
        background: #e7f5f5;
        border: 1px solid #19868b;
        border-radius: 8px;
        padding: 15px 20px;
        margin-bottom: 20px;
    }
    .info-box i {
        color: #19868b;
        margin-right: 10px;
    }
    .info-box p {
        margin: 0;
        color: #0d6b6f;
        font-size: 14px;
    }
    .action-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid #e9ecef;
    }
</style>
@endsection

@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Admin')}}" class="breadcrumbs__item"><i class="fa fa-home"></i> Dashboard</a>
            <a href="{{route('home-interior-settings.index')}}" class="breadcrumbs__item"><i class="fa fa-image"></i> Home Interior Settings</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-folder"></i> Category Order</a>
        </nav>

        <div class="col-lg-12">
            <hr>
            
            <div class="settings-card">
                <div class="settings-header">
                    <h4><i class="fa fa-folder"></i> Interior Category Order</h4>
                    <p>Drag and drop to reorder categories. Toggle publish status to show/hide categories on the frontend.</p>
                </div>
                
                <div class="settings-body">
                    <div class="info-box">
                        <i class="fa fa-info-circle"></i>
                        <p><strong>Instructions:</strong> Drag categories to change their display order. Click the status button to publish/unpublish a category. Click "Order Images" to sort images within each category.</p>
                    </div>
                    
                    @if(count($categories) > 0)
                    <div id="categoriesList">
                        @foreach($categories as $index => $category)
                        <div class="category-item {{ $category->publish_status == 1 ? 'unpublished' : '' }}" data-id="{{ $category->id }}">
                            <div class="drag-handle">
                                <i class="fa fa-bars"></i>
                            </div>
                            
                            <span class="order-badge">{{ $index + 1 }}</span>
                            
                            @if($category->image)
                                <img src="{{ asset('storage/' . $category->image) }}" alt="" class="category-image">
                            @else
                                <div class="category-image-placeholder">
                                    <i class="fa fa-folder"></i>
                                </div>
                            @endif
                            
                            <div class="category-info">
                                <div class="category-title">{{ $category->title_english }}</div>
                                <div class="category-title-arabic">{{ $category->title_arabic }}</div>
                            </div>
                            
                            <div class="category-stats">
                                <div class="stat-badge">
                                    <i class="fa fa-images"></i>
                                    <span>{{ $category->galleries_count }} Images</span>
                                </div>
                                
                                <button type="button" 
                                        class="status-toggle {{ $category->publish_status == 0 ? 'published' : 'unpublished' }}"
                                        onclick="togglePublish({{ $category->id }}, this)"
                                        data-id="{{ $category->id }}">
                                    <i class="fa {{ $category->publish_status == 0 ? 'fa-check' : 'fa-times' }}"></i>
                                    {{ $category->publish_status == 0 ? 'Published' : 'Unpublished' }}
                                </button>
                                
                                <a href="{{ route('interior-category-order.category-images', $category->id) }}" class="btn-order-images">
                                    <i class="fa fa-sort"></i> Order Images
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="alert alert-warning text-center">
                        <i class="fa fa-exclamation-triangle fa-2x mb-2"></i>
                        <p class="mb-0">No categories found.</p>
                    </div>
                    @endif
                    
                    <div class="action-bar">
                        <a href="{{ route('home-interior-settings.index') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left"></i> Back to Settings
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
    const categoriesList = document.getElementById('categoriesList');
    
    if (categoriesList) {
        new Sortable(categoriesList, {
            handle: '.drag-handle',
            animation: 150,
            ghostClass: 'dragging',
            onEnd: function(evt) {
                updateOrderBadges();
                saveOrder();
            }
        });
    }
    
    function updateOrderBadges() {
        const items = categoriesList.querySelectorAll('.category-item');
        items.forEach((item, index) => {
            const badge = item.querySelector('.order-badge');
            if (badge) {
                badge.textContent = index + 1;
            }
        });
    }
    
    function saveOrder() {
        const items = categoriesList.querySelectorAll('.category-item');
        const orders = [];
        
        items.forEach((item, index) => {
            orders.push({
                id: parseInt(item.dataset.id),
                ordering: index + 1
            });
        });
        
        fetch('{{ route("interior-category-order.update-order") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ orders: orders })
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
                text: 'Failed to update order'
            });
        });
    }
    
    function togglePublish(id, button) {
        fetch(`{{ url('admin/interior-category-order/toggle-publish') }}/${id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const item = button.closest('.category-item');
                
                if (data.publish_status == 0) {
                    button.classList.remove('unpublished');
                    button.classList.add('published');
                    button.innerHTML = '<i class="fa fa-check"></i> Published';
                    item.classList.remove('unpublished');
                } else {
                    button.classList.remove('published');
                    button.classList.add('unpublished');
                    button.innerHTML = '<i class="fa fa-times"></i> Unpublished';
                    item.classList.add('unpublished');
                }
                
                Swal.fire({
                    icon: 'success',
                    title: 'Status Updated!',
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
                text: 'Failed to update status'
            });
        });
    }
</script>
@endsection
