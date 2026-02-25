<?php $__env->startSection('title', 'Select Images for Home Slider'); ?>

<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<style>
    .page-header {
        background: linear-gradient(135deg, #19868b 0%, #0d6b6f 100%);
        color: white;
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 20px;
    }
    .page-header h4 {
        margin: 0;
        font-weight: 600;
    }
    .page-header p {
        margin: 5px 0 0;
        opacity: 0.9;
        font-size: 14px;
    }
    .selection-container {
        display: flex;
        gap: 20px;
    }
    .images-panel {
        flex: 1;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        overflow: hidden;
    }
    .panel-header {
        background: #f8f9fa;
        padding: 15px 20px;
        border-bottom: 1px solid #e9ecef;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .panel-header h5 {
        margin: 0;
        font-weight: 600;
        color: #2c3e50;
    }
    .panel-header .count {
        background: #19868b;
        color: white;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }
    .panel-body {
        padding: 15px;
        max-height: 600px;
        overflow-y: auto;
    }
    .image-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 15px;
    }
    .image-item {
        position: relative;
        border-radius: 8px;
        overflow: hidden;
        cursor: pointer;
        transition: all 0.2s ease;
        border: 2px solid transparent;
    }
    .image-item:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    .image-item.selected {
        border-color: #19868b;
        box-shadow: 0 0 0 3px rgba(25, 134, 139, 0.3);
    }
    .image-item.in-selected-list {
        opacity: 0.4;
        pointer-events: none;
    }
    .image-thumb {
        width: 100%;
        aspect-ratio: 16/9;
        object-fit: cover;
    }
    .image-info {
        padding: 8px;
        background: #f8f9fa;
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
    .selected-panel .panel-header {
        background: #19868b;
        color: white;
    }
    .selected-panel .panel-header h5 {
        color: white;
    }
    .selected-panel .panel-header .count {
        background: white;
        color: #19868b;
    }
    .selected-list {
        min-height: 200px;
    }
    .selected-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px;
        background: #fff;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        margin-bottom: 10px;
        cursor: grab;
    }
    .selected-item:hover {
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    .selected-item.dragging {
        opacity: 0.5;
        cursor: grabbing;
    }
    .drag-handle-selected {
        color: #adb5bd;
        cursor: grab;
        font-size: 16px;
    }
    .drag-handle-selected:hover {
        color: #19868b;
    }
    .selected-thumb {
        width: 80px;
        height: 45px;
        border-radius: 4px;
        object-fit: cover;
        flex-shrink: 0;
    }
    .selected-info {
        flex: 1;
        min-width: 0;
    }
    .selected-title {
        font-weight: 600;
        color: #2c3e50;
        font-size: 13px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .selected-category {
        font-size: 11px;
        color: #6c757d;
    }
    .remove-btn {
        background: #dc3545;
        color: white;
        border: none;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s ease;
        flex-shrink: 0;
    }
    .remove-btn:hover {
        background: #c82333;
        transform: scale(1.1);
    }
    .order-number {
        background: #19868b;
        color: white;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        font-weight: 600;
        flex-shrink: 0;
    }
    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #6c757d;
    }
    .empty-state i {
        font-size: 48px;
        margin-bottom: 15px;
        opacity: 0.5;
    }
    .empty-state p {
        margin: 0;
        font-size: 14px;
    }
    .action-bar {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        padding: 15px 20px;
        margin-top: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .btn-save-selection {
        background: linear-gradient(135deg, #19868b 0%, #0d6b6f 100%);
        color: white;
        border: none;
        padding: 10px 25px;
        border-radius: 6px;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    .btn-save-selection:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(25, 134, 139, 0.3);
        color: white;
    }
    .btn-clear-selection {
        background: #dc3545;
        color: white;
        border: none;
        padding: 10px 25px;
        border-radius: 6px;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    .btn-clear-selection:hover {
        background: #c82333;
        color: white;
    }
    .search-box {
        position: relative;
        margin-bottom: 15px;
    }
    .search-box input {
        width: 100%;
        padding: 10px 15px 10px 40px;
        border: 1px solid #e9ecef;
        border-radius: 6px;
        font-size: 14px;
    }
    .search-box input:focus {
        border-color: #19868b;
        outline: none;
        box-shadow: 0 0 0 2px rgba(25, 134, 139, 0.2);
    }
    .search-box i {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #adb5bd;
    }
    .max-warning {
        background: #fff3cd;
        border: 1px solid #ffc107;
        color: #856404;
        padding: 10px 15px;
        border-radius: 6px;
        margin-bottom: 15px;
        font-size: 13px;
    }
    .max-warning i {
        margin-right: 8px;
    }
    .filter-row {
        display: flex;
        gap: 10px;
        margin-bottom: 15px;
    }
    .filter-select {
        flex: 1;
        padding: 8px 12px;
        border: 1px solid #e9ecef;
        border-radius: 6px;
        font-size: 13px;
    }
    .filter-select:focus {
        border-color: #19868b;
        outline: none;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="<?php echo e(route('Admin')); ?>" class="breadcrumbs__item"><i class="fa fa-home"></i> Dashboard</a>
            <a href="<?php echo e(route('home-interior-settings.index')); ?>" class="breadcrumbs__item"><i class="fa fa-image"></i> Home Interior Settings</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-list"></i> Select Images</a>
        </nav>

        <div class="col-lg-12">
            <hr>
            
            <div class="page-header">
                <h4><i class="fa fa-images"></i> Select Images for Home Slider</h4>
                <p>Choose which interior gallery images will appear in the home page slider. Drag to reorder selected images. Maximum <?php echo e($settings->max_show); ?> images will be shown.</p>
            </div>
            
            <div class="selection-container">
                <!-- Available Images Panel -->
                <div class="images-panel">
                    <div class="panel-header">
                        <h5><i class="fa fa-folder-open"></i> Available Images</h5>
                        <span class="count" id="availableCount"><?php echo e($availableGalleries->count()); ?></span>
                    </div>
                    <div class="panel-body">
                        <div class="search-box">
                            <i class="fa fa-search"></i>
                            <input type="text" id="searchImages" placeholder="Search images...">
                        </div>
                        
                        <div class="filter-row">
                            <select id="categoryFilter" class="filter-select">
                                <option value="">All Categories</option>
                                <?php
                                    $categories = $availableGalleries->pluck('category')->filter()->unique('id');
                                ?>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($category->id); ?>"><?php echo e($category->title_english); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        
                        <div class="image-grid" id="availableImagesList">
                            <?php $__empty_1 = true; $__currentLoopData = $availableGalleries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gallery): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="image-item <?php echo e(in_array($gallery->id, $selectedGalleryIds) ? 'in-selected-list' : ''); ?>" 
                                 data-id="<?php echo e($gallery->id); ?>"
                                 data-title="<?php echo e($gallery->title_english); ?>"
                                 data-category="<?php echo e($gallery->category->title_english ?? ''); ?>"
                                 data-category-id="<?php echo e($gallery->category_id); ?>"
                                 data-image="<?php echo e($gallery->image ? asset('storage' . $gallery->image) : ''); ?>">
                                <?php if($gallery->image): ?>
                                    <img src="<?php echo e(asset('storage' . $gallery->image)); ?>" alt="" class="image-thumb">
                                <?php else: ?>
                                    <div class="image-thumb" style="background: #e9ecef; display: flex; align-items: center; justify-content: center;">
                                        <i class="fa fa-image" style="font-size: 24px; color: #adb5bd;"></i>
                                    </div>
                                <?php endif; ?>
                                <div class="image-info">
                                    <div class="image-title"><?php echo e($gallery->title_english); ?></div>
                                    <?php if($gallery->category): ?>
                                        <span class="image-category"><?php echo e($gallery->category->title_english); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="empty-state" style="grid-column: 1 / -1;">
                                <i class="fa fa-folder-open"></i>
                                <p>No published images available</p>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <!-- Selected Images Panel -->
                <div class="images-panel selected-panel">
                    <div class="panel-header">
                        <h5><i class="fa fa-check-circle"></i> Selected Images</h5>
                        <span class="count" id="selectedCount"><?php echo e(count($selectedGalleryIds)); ?></span>
                    </div>
                    <div class="panel-body">
                        <div class="max-warning" id="maxWarning" style="<?php echo e(count($selectedGalleryIds) >= $settings->max_show ? '' : 'display: none;'); ?>">
                            <i class="fa fa-exclamation-triangle"></i>
                            Maximum <?php echo e($settings->max_show); ?> images reached. Only the first <?php echo e($settings->max_show); ?> will be shown on the home page.
                        </div>
                        
                        <div id="selectedImagesList" class="selected-list">
                            <?php $__empty_1 = true; $__currentLoopData = $selectedItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <?php if($item->gallery): ?>
                                <div class="selected-item" data-id="<?php echo e($item->gallery->id); ?>">
                                    <div class="drag-handle-selected">
                                        <i class="fa fa-bars"></i>
                                    </div>
                                    <span class="order-number"><?php echo e($index + 1); ?></span>
                                    <?php if($item->gallery->image): ?>
                                        <img src="<?php echo e(asset('storage' . $item->gallery->image)); ?>" alt="" class="selected-thumb">
                                    <?php else: ?>
                                        <div class="selected-thumb" style="background: #e9ecef; display: flex; align-items: center; justify-content: center;">
                                            <i class="fa fa-image" style="color: #adb5bd;"></i>
                                        </div>
                                    <?php endif; ?>
                                    <div class="selected-info">
                                        <div class="selected-title"><?php echo e($item->gallery->title_english); ?></div>
                                        <div class="selected-category"><?php echo e($item->gallery->category->title_english ?? 'No Category'); ?></div>
                                    </div>
                                    <button type="button" class="remove-btn" onclick="removeImage(<?php echo e($item->gallery->id); ?>)">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </div>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="empty-state" id="emptySelectedState">
                                <i class="fa fa-hand-pointer-o"></i>
                                <p>Click on images from the left panel to add them here.<br>
                                <small>Leave empty to use automatic mode (latest images)</small></p>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="action-bar">
                <div>
                    <a href="<?php echo e(route('home-interior-settings.index')); ?>" class="btn btn-secondary">
                        <i class="fa fa-arrow-left"></i> Back to Settings
                    </a>
                    <button type="button" class="btn btn-clear-selection" onclick="clearAllImages()" id="clearBtn" style="<?php echo e(count($selectedGalleryIds) > 0 ? '' : 'display: none;'); ?>">
                        <i class="fa fa-trash"></i> Clear All (Use Auto Mode)
                    </button>
                </div>
                <button type="button" class="btn btn-save-selection" onclick="saveSelection()">
                    <i class="fa fa-save"></i> Save Selection
                </button>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
    const maxImages = <?php echo e($settings->max_show); ?>;
    let selectedImages = <?php echo json_encode($selectedGalleryIds, 15, 512) ?>;
    
    // Initialize Sortable for selected images
    const selectedList = document.getElementById('selectedImagesList');
    new Sortable(selectedList, {
        handle: '.drag-handle-selected',
        animation: 150,
        ghostClass: 'dragging',
        onEnd: function(evt) {
            updateOrderNumbers();
        }
    });
    
    // Search functionality
    document.getElementById('searchImages').addEventListener('input', filterImages);
    document.getElementById('categoryFilter').addEventListener('change', filterImages);
    
    function filterImages() {
        const searchTerm = document.getElementById('searchImages').value.toLowerCase();
        const categoryId = document.getElementById('categoryFilter').value;
        const items = document.querySelectorAll('#availableImagesList .image-item');
        
        let visibleCount = 0;
        items.forEach(item => {
            const title = item.dataset.title.toLowerCase();
            const category = item.dataset.category.toLowerCase();
            const itemCategoryId = item.dataset.categoryId;
            
            const matchesSearch = title.includes(searchTerm) || category.includes(searchTerm);
            const matchesCategory = !categoryId || itemCategoryId === categoryId;
            
            if (matchesSearch && matchesCategory && !item.classList.contains('in-selected-list')) {
                item.style.display = 'block';
                visibleCount++;
            } else if (item.classList.contains('in-selected-list')) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    }
    
    // Click to add image
    document.querySelectorAll('#availableImagesList .image-item').forEach(item => {
        item.addEventListener('click', function() {
            if (this.classList.contains('in-selected-list')) return;
            
            const imageId = parseInt(this.dataset.id);
            addImage(imageId, this.dataset.title, this.dataset.category, this.dataset.image);
        });
    });
    
    function addImage(id, title, category, image) {
        if (!selectedImages.includes(id)) {
            selectedImages.push(id);
        }
        
        const emptyState = document.getElementById('emptySelectedState');
        if (emptyState) {
            emptyState.style.display = 'none';
        }
        
        const availableItem = document.querySelector(`#availableImagesList .image-item[data-id="${id}"]`);
        if (availableItem) {
            availableItem.classList.add('in-selected-list');
        }
        
        const orderNum = selectedImages.length;
        const imageHtml = image 
            ? `<img src="${image}" alt="" class="selected-thumb">`
            : `<div class="selected-thumb" style="background: #e9ecef; display: flex; align-items: center; justify-content: center;"><i class="fa fa-image" style="color: #adb5bd;"></i></div>`;
        
        const itemHtml = `
            <div class="selected-item" data-id="${id}">
                <div class="drag-handle-selected">
                    <i class="fa fa-bars"></i>
                </div>
                <span class="order-number">${orderNum}</span>
                ${imageHtml}
                <div class="selected-info">
                    <div class="selected-title">${title}</div>
                    <div class="selected-category">${category || 'No Category'}</div>
                </div>
                <button type="button" class="remove-btn" onclick="removeImage(${id})">
                    <i class="fa fa-times"></i>
                </button>
            </div>
        `;
        
        selectedList.insertAdjacentHTML('beforeend', itemHtml);
        
        updateCounts();
        updateMaxWarning();
        updateClearButton();
    }
    
    function removeImage(id) {
        selectedImages = selectedImages.filter(i => i !== id);
        
        const selectedItem = document.querySelector(`#selectedImagesList .selected-item[data-id="${id}"]`);
        if (selectedItem) {
            selectedItem.remove();
        }
        
        const availableItem = document.querySelector(`#availableImagesList .image-item[data-id="${id}"]`);
        if (availableItem) {
            availableItem.classList.remove('in-selected-list');
        }
        
        if (selectedImages.length === 0) {
            const emptyHtml = `
                <div class="empty-state" id="emptySelectedState">
                    <i class="fa fa-hand-pointer-o"></i>
                    <p>Click on images from the left panel to add them here.<br>
                    <small>Leave empty to use automatic mode (latest images)</small></p>
                </div>
            `;
            selectedList.innerHTML = emptyHtml;
        }
        
        updateOrderNumbers();
        updateCounts();
        updateMaxWarning();
        updateClearButton();
    }
    
    function updateOrderNumbers() {
        const items = selectedList.querySelectorAll('.selected-item');
        items.forEach((item, index) => {
            const orderNum = item.querySelector('.order-number');
            if (orderNum) {
                orderNum.textContent = index + 1;
            }
        });
    }
    
    function updateCounts() {
        document.getElementById('selectedCount').textContent = selectedImages.length;
        
        const availableItems = document.querySelectorAll('#availableImagesList .image-item:not(.in-selected-list)');
        let visibleCount = 0;
        availableItems.forEach(item => {
            if (item.style.display !== 'none') {
                visibleCount++;
            }
        });
        document.getElementById('availableCount').textContent = visibleCount;
    }
    
    function updateMaxWarning() {
        const warning = document.getElementById('maxWarning');
        if (selectedImages.length >= maxImages) {
            warning.style.display = 'block';
        } else {
            warning.style.display = 'none';
        }
    }
    
    function updateClearButton() {
        const clearBtn = document.getElementById('clearBtn');
        if (selectedImages.length > 0) {
            clearBtn.style.display = 'inline-block';
        } else {
            clearBtn.style.display = 'none';
        }
    }
    
    function clearAllImages() {
        if (!confirm('Are you sure you want to clear all selected images? This will switch to automatic mode (latest images).')) {
            return;
        }
        
        fetch('<?php echo e(route("home-interior-settings.clear-images")); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                selectedImages = [];
                document.querySelectorAll('#availableImagesList .image-item').forEach(item => {
                    item.classList.remove('in-selected-list');
                });
                
                selectedList.innerHTML = `
                    <div class="empty-state" id="emptySelectedState">
                        <i class="fa fa-hand-pointer-o"></i>
                        <p>Click on images from the left panel to add them here.<br>
                        <small>Leave empty to use automatic mode (latest images)</small></p>
                    </div>
                `;
                
                updateCounts();
                updateMaxWarning();
                updateClearButton();
                
                Swal.fire({
                    icon: 'success',
                    title: 'Cleared!',
                    text: data.message,
                    timer: 2000,
                    showConfirmButton: false
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to clear images'
            });
        });
    }
    
    function saveSelection() {
        const orderedIds = [];
        document.querySelectorAll('#selectedImagesList .selected-item').forEach(item => {
            orderedIds.push(parseInt(item.dataset.id));
        });
        
        fetch('<?php echo e(route("home-interior-settings.save-images")); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
            },
            body: JSON.stringify({
                galleries: orderedIds
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Saved!',
                    text: data.message + (data.count > 0 ? ` (${data.count} images selected)` : ' (Using automatic mode)'),
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = '<?php echo e(route("home-interior-settings.index")); ?>';
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to save selection'
            });
        });
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\smartvisionuae\Modules/Admin\resources/views/home-interior-settings/select-images.blade.php ENDPATH**/ ?>