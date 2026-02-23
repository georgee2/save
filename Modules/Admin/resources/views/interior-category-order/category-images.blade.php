@extends('admin::layouts.master')
@section('title', 'Order Images - ' . $category->title_english)

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
    .images-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
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
        font-size: 13px;
        font-weight: 600;
        color: #2c3e50;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .order-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        background: #19868b;
        color: white;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 600;
        z-index: 1;
    }
    .drag-indicator {
        position: absolute;
        top: 10px;
        right: 10px;
        background: rgba(0,0,0,0.5);
        color: white;
        padding: 5px 8px;
        border-radius: 4px;
        font-size: 12px;
        z-index: 1;
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
    .category-header {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid #e9ecef;
    }
    .category-thumb {
        width: 60px;
        height: 60px;
        border-radius: 8px;
        object-fit: cover;
    }
    .category-thumb-placeholder {
        width: 60px;
        height: 60px;
        border-radius: 8px;
        background: #e9ecef;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #adb5bd;
        font-size: 24px;
    }
    .category-details h5 {
        margin: 0 0 5px;
        font-weight: 600;
        color: #2c3e50;
    }
    .category-details p {
        margin: 0;
        font-size: 13px;
        color: #6c757d;
    }
</style>
@endsection

@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Admin')}}" class="breadcrumbs__item"><i class="fa fa-home"></i> Dashboard</a>
            <a href="{{route('home-interior-settings.index')}}" class="breadcrumbs__item"><i class="fa fa-image"></i> Home Interior Settings</a>
            <a href="{{route('interior-category-order.index')}}" class="breadcrumbs__item"><i class="fa fa-folder"></i> Category Order</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-sort"></i> Order Images</a>
        </nav>

        <div class="col-lg-12">
            <hr>
            
            <div class="settings-card">
                <div class="settings-header">
                    <h4><i class="fa fa-sort"></i> Order Images in Category</h4>
                    <p>Drag and drop images to change their display order within this category.</p>
                </div>
                
                <div class="settings-body">
                    <div class="category-header">
                        @if($category->image)
                            <img src="{{ asset('storage/' . $category->image) }}" alt="" class="category-thumb">
                        @else
                            <div class="category-thumb-placeholder">
                                <i class="fa fa-folder"></i>
                            </div>
                        @endif
                        <div class="category-details">
                            <h5>{{ $category->title_english }}</h5>
                            <p>{{ $category->title_arabic }} | {{ $galleries->count() }} images</p>
                        </div>
                    </div>
                    
                    <div class="info-box">
                        <i class="fa fa-info-circle"></i>
                        <p><strong>Instructions:</strong> Drag and drop images to reorder them. The order will be saved automatically.</p>
                    </div>
                    
                    @if(count($galleries) > 0)
                    <div class="images-grid" id="imagesList">
                        @foreach($galleries as $index => $gallery)
                        <div class="image-item" data-id="{{ $gallery->id }}">
                            <span class="order-badge">{{ $index + 1 }}</span>
                            <span class="drag-indicator"><i class="fa fa-arrows"></i></span>
                            @if($gallery->image)
                                <img src="{{ asset('storage' . $gallery->image) }}" alt="" class="image-thumb">
                            @else
                                <div class="image-thumb" style="background: #e9ecef; display: flex; align-items: center; justify-content: center;">
                                    <i class="fa fa-image" style="font-size: 32px; color: #adb5bd;"></i>
                                </div>
                            @endif
                            <div class="image-info">
                                <div class="image-title">{{ $gallery->title_english }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="alert alert-warning text-center">
                        <i class="fa fa-exclamation-triangle fa-2x mb-2"></i>
                        <p class="mb-0">No published images in this category.</p>
                    </div>
                    @endif
                    
                    <div class="action-bar">
                        <a href="{{ route('interior-category-order.index') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left"></i> Back to Categories
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
    const imagesList = document.getElementById('imagesList');
    const categoryId = {{ $category->id }};
    
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
        
        fetch(`{{ url('admin/interior-category-order/update-category-images-order') }}/${categoryId}`, {
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
</script>
@endsection
