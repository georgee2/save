@extends('admin::layouts.master')
@section('title', 'Order All Gallery Images')

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
    .filter-bar {
        display: flex;
        gap: 15px;
        margin-bottom: 20px;
        padding: 15px;
        background: #f8f9fa;
        border-radius: 8px;
    }
    .filter-select {
        padding: 10px 15px;
        border: 1px solid #e9ecef;
        border-radius: 6px;
        font-size: 14px;
        min-width: 200px;
    }
    .filter-select:focus {
        border-color: #19868b;
        outline: none;
    }
    .images-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 15px;
    }
    .image-item {
        position: relative;
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        overflow: hidden;
        cursor: grab;
        transition: all 0.3s ease;
    }
    .image-item:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        transform: translateY(-3px);
    }
    .image-item.dragging {
        opacity: 0.5;
        cursor: grabbing;
    }
    .image-thumb {
        width: 100%;
        aspect-ratio: 16/9;
        object-fit: cover;
    }
    .image-info {
        padding: 10px;
    }
    .image-title {
        font-size: 12px;
        font-weight: 600;
        color: #2c3e50;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .image-category {
        font-size: 10px;
        color: #19868b;
        background: #e7f5f5;
        padding: 2px 6px;
        border-radius: 4px;
        display: inline-block;
        margin-top: 3px;
    }
    .order-badge {
        position: absolute;
        top: 8px;
        left: 8px;
        background: #19868b;
        color: white;
        min-width: 26px;
        height: 26px;
        padding: 0 6px;
        border-radius: 13px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        font-weight: 600;
        z-index: 1;
    }
    .drag-indicator {
        position: absolute;
        top: 8px;
        right: 8px;
        background: rgba(0,0,0,0.5);
        color: white;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 11px;
        z-index: 1;
    }
    .status-badges {
        position: absolute;
        bottom: 50px;
        left: 8px;
        display: flex;
        gap: 4px;
        z-index: 1;
    }
    .status-badge {
        padding: 2px 6px;
        border-radius: 4px;
        font-size: 9px;
        font-weight: 600;
    }
    .status-badge.published {
        background: #d4edda;
        color: #155724;
    }
    .status-badge.unpublished {
        background: #f8d7da;
        color: #721c24;
    }
    .status-badge.home {
        background: #cce5ff;
        color: #004085;
    }
    .action-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid #e9ecef;
    }
    .stats-bar {
        display: flex;
        gap: 20px;
        margin-bottom: 15px;
    }
    .stat-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        color: #6c757d;
    }
    .stat-item i {
        color: #19868b;
    }
    .stat-item strong {
        color: #2c3e50;
    }
</style>
@endsection

@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Admin')}}" class="breadcrumbs__item"><i class="fa fa-home"></i> Dashboard</a>
            <a href="{{route('home-interior-settings.index')}}" class="breadcrumbs__item"><i class="fa fa-image"></i> Home Interior Settings</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-sort"></i> Order All Images</a>
        </nav>

        <div class="col-lg-12">
            <hr>
            
            <div class="settings-card">
                <div class="settings-header">
                    <h4><i class="fa fa-sort"></i> Order All Gallery Images</h4>
                    <p>Drag and drop to reorder all interior gallery images. Filter by category for easier management.</p>
                </div>
                
                <div class="settings-body">
                    <div class="info-box">
                        <i class="fa fa-info-circle"></i>
                        <p><strong>Instructions:</strong> Drag images to reorder them. Use the category filter to focus on specific categories. Changes are saved automatically.</p>
                    </div>
                    
                    <div class="filter-bar">
                        <select id="categoryFilter" class="filter-select" onchange="filterByCategory()">
                            <option value="">All Categories ({{ $galleries->count() }} images)</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->title_english }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="stats-bar">
                        <div class="stat-item">
                            <i class="fa fa-images"></i>
                            <span>Total: <strong>{{ $galleries->count() }}</strong> images</span>
                        </div>
                        <div class="stat-item">
                            <i class="fa fa-check-circle"></i>
                            <span>Published: <strong>{{ $galleries->where('publish_status', 0)->count() }}</strong></span>
                        </div>
                        <div class="stat-item">
                            <i class="fa fa-home"></i>
                            <span>On Home: <strong>{{ $galleries->where('home_status', 0)->count() }}</strong></span>
                        </div>
                    </div>
                    
                    @if(count($galleries) > 0)
                    <div class="images-grid" id="imagesList">
                        @foreach($galleries as $index => $gallery)
                        <div class="image-item" data-id="{{ $gallery->id }}">
                            <span class="order-badge">{{ $gallery->ordering }}</span>
                            <span class="drag-indicator"><i class="fa fa-arrows"></i></span>
                            <div class="status-badges">
                                <span class="status-badge {{ $gallery->publish_status == 0 ? 'published' : 'unpublished' }}">
                                    {{ $gallery->publish_status == 0 ? 'Published' : 'Draft' }}
                                </span>
                                @if($gallery->home_status == 0)
                                <span class="status-badge home">Home</span>
                                @endif
                            </div>
                            @if($gallery->image)
                                <img src="{{ asset('storage' . $gallery->image) }}" alt="" class="image-thumb">
                            @else
                                <div class="image-thumb" style="background: #e9ecef; display: flex; align-items: center; justify-content: center;">
                                    <i class="fa fa-image" style="font-size: 24px; color: #adb5bd;"></i>
                                </div>
                            @endif
                            <div class="image-info">
                                <div class="image-title">{{ $gallery->title_english }}</div>
                                @if($gallery->category)
                                    <span class="image-category">{{ $gallery->category->title_english }}</span>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="alert alert-warning text-center">
                        <i class="fa fa-exclamation-triangle fa-2x mb-2"></i>
                        <p class="mb-0">No images found.</p>
                    </div>
                    @endif
                    
                    <div class="action-bar">
                        <a href="{{ route('home-interior-settings.index') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left"></i> Back to Settings
                        </a>
                        <div>
                            <a href="{{ route('interior-design-gallery.order-index') }}" class="btn btn-info">
                                <i class="fa fa-star"></i> Order Index Page
                            </a>
                            <a href="{{ route('interior-design-gallery.index') }}" class="btn btn-primary">
                                <i class="fa fa-th"></i> Gallery Management
                            </a>
                        </div>
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
    const imagesList = document.getElementById('imagesList');
    
    if (imagesList) {
        new Sortable(imagesList, {
            animation: 150,
            ghostClass: 'dragging',
            onEnd: function(evt) {
                updateOrderBadges();
                saveOrder();
            }
        });
    }
    
    function updateOrderBadges() {
        const items = imagesList.querySelectorAll('.image-item');
        items.forEach((item, index) => {
            const badge = item.querySelector('.order-badge');
            if (badge) {
                badge.textContent = index + 1;
            }
        });
    }
    
    function saveOrder() {
        const items = imagesList.querySelectorAll('.image-item');
        const orders = [];
        
        items.forEach((item, index) => {
            orders.push({
                id: parseInt(item.dataset.id),
                ordering: index + 1
            });
        });
        
        fetch('{{ route("interior-design-gallery.update-all-order") }}', {
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
    
    function filterByCategory() {
        const categoryId = document.getElementById('categoryFilter').value;
        const url = new URL(window.location.href);
        
        if (categoryId) {
            url.searchParams.set('category_id', categoryId);
        } else {
            url.searchParams.delete('category_id');
        }
        
        window.location.href = url.toString();
    }
</script>
@endsection
