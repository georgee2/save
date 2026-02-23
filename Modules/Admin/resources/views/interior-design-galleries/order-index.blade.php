@extends('admin::layouts.master')
@section('title', 'Order Index Page Images')

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
    .featured-section {
        margin-bottom: 30px;
    }
    .section-title {
        font-size: 16px;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 2px solid #19868b;
    }
    .section-title .badge {
        background: #19868b;
        color: white;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 12px;
        margin-left: 10px;
    }
    .images-grid {
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        gap: 15px;
    }
    @media (max-width: 1200px) {
        .images-grid {
            grid-template-columns: repeat(4, 1fr);
        }
    }
    @media (max-width: 768px) {
        .images-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    .image-item {
        position: relative;
        background: #f8f9fa;
        border: 2px solid #e9ecef;
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
    .image-item.featured {
        border-color: #19868b;
        box-shadow: 0 0 0 3px rgba(25, 134, 139, 0.2);
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
        width: 26px;
        height: 26px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        font-weight: 600;
        z-index: 1;
    }
    .featured-badge {
        position: absolute;
        top: 8px;
        right: 8px;
        background: #ffc107;
        color: #000;
        padding: 3px 8px;
        border-radius: 4px;
        font-size: 10px;
        font-weight: 600;
        z-index: 1;
    }
    .action-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid #e9ecef;
    }
    .other-images-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 10px;
        max-height: 400px;
        overflow-y: auto;
        padding: 10px;
        background: #f8f9fa;
        border-radius: 8px;
    }
    .other-image-item {
        position: relative;
        border-radius: 6px;
        overflow: hidden;
        cursor: grab;
        transition: all 0.2s ease;
        border: 2px solid transparent;
    }
    .other-image-item:hover {
        border-color: #19868b;
    }
    .other-image-item.dragging {
        opacity: 0.5;
    }
    .other-image-thumb {
        width: 100%;
        aspect-ratio: 16/9;
        object-fit: cover;
    }
    .other-order-badge {
        position: absolute;
        top: 5px;
        left: 5px;
        background: rgba(0,0,0,0.6);
        color: white;
        padding: 2px 6px;
        border-radius: 4px;
        font-size: 10px;
        font-weight: 600;
    }
</style>
@endsection

@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Admin')}}" class="breadcrumbs__item"><i class="fa fa-home"></i> Dashboard</a>
            <a href="{{route('home-interior-settings.index')}}" class="breadcrumbs__item"><i class="fa fa-image"></i> Home Interior Settings</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-star"></i> Index Page Order</a>
        </nav>

        <div class="col-lg-12">
            <hr>
            
            <div class="settings-card">
                <div class="settings-header">
                    <h4><i class="fa fa-star"></i> Order Index Page Images</h4>
                    <p>Drag and drop to set the order of the first 6 images that appear on the Interior Gallery index page.</p>
                </div>
                
                <div class="settings-body">
                    <div class="info-box">
                        <i class="fa fa-info-circle"></i>
                        <p><strong>Instructions:</strong> The first 6 images in the order will be displayed prominently on the Interior Gallery index page. Drag images to reorder them. Changes are saved automatically.</p>
                    </div>
                    
                    @if(count($galleries) > 0)
                    <div class="featured-section">
                        <div class="section-title">
                            <i class="fa fa-star"></i> Featured Images (First 6)
                            <span class="badge">{{ min(6, $galleries->count()) }} of 6</span>
                        </div>
                        <div class="images-grid" id="featuredList">
                            @foreach($galleries->take(6) as $index => $gallery)
                            <div class="image-item featured" data-id="{{ $gallery->id }}">
                                <span class="order-badge">{{ $index + 1 }}</span>
                                <span class="featured-badge"><i class="fa fa-star"></i> Featured</span>
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
                    </div>
                    
                    @if($galleries->count() > 6)
                    <div class="featured-section">
                        <div class="section-title">
                            <i class="fa fa-images"></i> Other Images
                            <span class="badge">{{ $galleries->count() - 6 }} images</span>
                        </div>
                        <div class="other-images-grid" id="otherList">
                            @foreach($galleries->skip(6) as $index => $gallery)
                            <div class="other-image-item" data-id="{{ $gallery->id }}">
                                <span class="other-order-badge">{{ $index + 7 }}</span>
                                @if($gallery->image)
                                    <img src="{{ asset('storage' . $gallery->image) }}" alt="" class="other-image-thumb">
                                @else
                                    <div class="other-image-thumb" style="background: #e9ecef; display: flex; align-items: center; justify-content: center;">
                                        <i class="fa fa-image" style="font-size: 16px; color: #adb5bd;"></i>
                                    </div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    @else
                    <div class="alert alert-warning text-center">
                        <i class="fa fa-exclamation-triangle fa-2x mb-2"></i>
                        <p class="mb-0">No published images found.</p>
                    </div>
                    @endif
                    
                    <div class="action-bar">
                        <a href="{{ route('home-interior-settings.index') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left"></i> Back to Settings
                        </a>
                        <a href="{{ route('interior-design-gallery.order-all') }}" class="btn btn-primary">
                            <i class="fa fa-sort"></i> Order All Images
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
    const featuredList = document.getElementById('featuredList');
    const otherList = document.getElementById('otherList');
    
    // Make featured list sortable and allow items from other list
    if (featuredList) {
        new Sortable(featuredList, {
            group: 'images',
            animation: 150,
            ghostClass: 'dragging',
            onEnd: function(evt) {
                updateAllOrderBadges();
                saveOrder();
            }
        });
    }
    
    // Make other list sortable and allow items to go to featured
    if (otherList) {
        new Sortable(otherList, {
            group: 'images',
            animation: 150,
            ghostClass: 'dragging',
            onEnd: function(evt) {
                updateAllOrderBadges();
                saveOrder();
            }
        });
    }
    
    function updateAllOrderBadges() {
        let order = 1;
        
        // Update featured items
        const featuredItems = featuredList.querySelectorAll('.image-item, .other-image-item');
        featuredItems.forEach((item) => {
            const badge = item.querySelector('.order-badge') || item.querySelector('.other-order-badge');
            if (badge) {
                badge.textContent = order;
            }
            
            // Convert to featured style if in featured list
            if (!item.classList.contains('image-item')) {
                item.classList.remove('other-image-item');
                item.classList.add('image-item', 'featured');
                
                // Update badge styling
                if (badge) {
                    badge.classList.remove('other-order-badge');
                    badge.classList.add('order-badge');
                }
                
                // Add featured badge if not exists
                if (!item.querySelector('.featured-badge')) {
                    const featuredBadge = document.createElement('span');
                    featuredBadge.className = 'featured-badge';
                    featuredBadge.innerHTML = '<i class="fa fa-star"></i> Featured';
                    item.insertBefore(featuredBadge, item.firstChild.nextSibling);
                }
            }
            
            order++;
        });
        
        // Update other items
        if (otherList) {
            const otherItems = otherList.querySelectorAll('.image-item, .other-image-item');
            otherItems.forEach((item) => {
                const badge = item.querySelector('.order-badge') || item.querySelector('.other-order-badge');
                if (badge) {
                    badge.textContent = order;
                }
                
                // Convert to other style if in other list
                if (item.classList.contains('image-item')) {
                    item.classList.remove('image-item', 'featured');
                    item.classList.add('other-image-item');
                    
                    // Update badge styling
                    if (badge) {
                        badge.classList.remove('order-badge');
                        badge.classList.add('other-order-badge');
                    }
                    
                    // Remove featured badge
                    const featuredBadge = item.querySelector('.featured-badge');
                    if (featuredBadge) {
                        featuredBadge.remove();
                    }
                    
                    // Remove image-info if exists (for compact view)
                    const imageInfo = item.querySelector('.image-info');
                    if (imageInfo) {
                        imageInfo.remove();
                    }
                }
                
                order++;
            });
        }
    }
    
    function saveOrder() {
        const orders = [];
        let order = 1;
        
        // Get featured items
        const featuredItems = featuredList.querySelectorAll('.image-item, .other-image-item');
        featuredItems.forEach((item) => {
            orders.push({
                id: parseInt(item.dataset.id),
                ordering: order++
            });
        });
        
        // Get other items
        if (otherList) {
            const otherItems = otherList.querySelectorAll('.image-item, .other-image-item');
            otherItems.forEach((item) => {
                orders.push({
                    id: parseInt(item.dataset.id),
                    ordering: order++
                });
            });
        }
        
        fetch('{{ route("interior-design-gallery.update-index-order") }}', {
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
