<?php $__env->startSection('title', 'Bulk Add Interior Design Gallery'); ?>
<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<style>
    .bulk-upload-container {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 15px;
        padding: 30px;
        margin-bottom: 30px;
    }
    
    .upload-header {
        text-align: center;
        margin-bottom: 30px;
    }
    
    .upload-header h2 {
        color: #19868b;
        font-weight: 700;
        margin-bottom: 10px;
    }
    
    .upload-header p {
        color: #6c757d;
        font-size: 16px;
    }
    
    .settings-card {
        background: white;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        margin-bottom: 25px;
    }
    
    .settings-card h5 {
        color: #2c3e50;
        font-weight: 600;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #19868b;
    }
    
    .settings-card h5 i {
        color: #19868b;
        margin-right: 10px;
    }
    
    .form-group label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 8px;
    }
    
    .form-group label i {
        color: #19868b;
        margin-right: 5px;
    }
    
    .form-control, .select2-container .select2-selection--single {
        border-radius: 8px;
        border: 2px solid #e9ecef;
        padding: 12px 15px;
        height: auto;
        transition: all 0.3s ease;
    }
    
    .form-control:focus {
        border-color: #19868b;
        box-shadow: 0 0 0 3px rgba(25, 134, 139, 0.1);
    }
    
    .select2-container--default .select2-selection--single {
        height: 48px;
        border: 2px solid #e9ecef;
        border-radius: 8px;
    }
    
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 44px;
        padding-left: 15px;
    }
    
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 46px;
    }
    
    .category-preview {
        background: linear-gradient(135deg, #19868b 0%, #0d6b6f 100%);
        color: white;
        border-radius: 10px;
        padding: 20px;
        margin-top: 15px;
        display: none;
    }
    
    .category-preview.active {
        display: block;
    }
    
    .category-preview h6 {
        font-weight: 600;
        margin-bottom: 15px;
        font-size: 14px;
        opacity: 0.9;
    }
    
    .category-preview .preview-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
        border-bottom: 1px solid rgba(255,255,255,0.2);
    }
    
    .category-preview .preview-item:last-child {
        border-bottom: none;
    }
    
    .category-preview .preview-label {
        font-size: 13px;
        opacity: 0.8;
    }
    
    .category-preview .preview-value {
        font-weight: 600;
        font-size: 15px;
    }
    
    .existing-numbers-list {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
        margin-top: 10px;
    }
    
    .existing-number-badge {
        background: rgba(255,255,255,0.2);
        padding: 3px 10px;
        border-radius: 15px;
        font-size: 12px;
    }
    
    /* Dropzone Styles */
    .dropzone-container {
        background: white;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    }
    
    .dropzone-container h5 {
        color: #2c3e50;
        font-weight: 600;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #19868b;
    }
    
    .dropzone-container h5 i {
        color: #19868b;
        margin-right: 10px;
    }
    
    .custom-dropzone {
        border: 3px dashed #19868b;
        border-radius: 15px;
        padding: 50px 30px;
        text-align: center;
        background: linear-gradient(135deg, rgba(25, 134, 139, 0.05) 0%, rgba(13, 107, 111, 0.05) 100%);
        transition: all 0.3s ease;
        cursor: pointer;
        position: relative;
    }
    
    .custom-dropzone:hover, .custom-dropzone.dragover {
        border-color: #0d6b6f;
        background: linear-gradient(135deg, rgba(25, 134, 139, 0.1) 0%, rgba(13, 107, 111, 0.1) 100%);
        transform: scale(1.01);
    }
    
    .custom-dropzone.dragover {
        border-style: solid;
    }
    
    .dropzone-icon {
        font-size: 60px;
        color: #19868b;
        margin-bottom: 20px;
    }
    
    .dropzone-text h4 {
        color: #2c3e50;
        font-weight: 600;
        margin-bottom: 10px;
    }
    
    .dropzone-text p {
        color: #6c757d;
        margin-bottom: 15px;
    }
    
    .dropzone-btn {
        background: linear-gradient(135deg, #19868b 0%, #0d6b6f 100%);
        color: white;
        border: none;
        padding: 12px 30px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .dropzone-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(25, 134, 139, 0.3);
    }
    
    .file-input {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
    }
    
    /* Preview Grid */
    .preview-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 15px;
        margin-top: 25px;
    }
    
    .preview-item-card {
        background: #f8f9fa;
        border-radius: 10px;
        overflow: hidden;
        position: relative;
        box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }
    
    .preview-item-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.15);
    }
    
    .preview-item-card img {
        width: 100%;
        height: 100px;
        object-fit: cover;
    }
    
    .preview-item-info {
        padding: 10px;
    }
    
    .preview-item-title {
        font-size: 12px;
        font-weight: 600;
        color: #2c3e50;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .preview-item-size {
        font-size: 11px;
        color: #6c757d;
    }
    
    .preview-item-remove {
        position: absolute;
        top: 5px;
        right: 5px;
        background: rgba(220, 53, 69, 0.9);
        color: white;
        border: none;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        transition: all 0.3s ease;
    }
    
    .preview-item-remove:hover {
        background: #dc3545;
        transform: scale(1.1);
    }
    
    .preview-item-number {
        position: absolute;
        top: 5px;
        left: 5px;
        background: rgba(25, 134, 139, 0.9);
        color: white;
        padding: 2px 8px;
        border-radius: 10px;
        font-size: 11px;
        font-weight: 600;
    }
    
    /* Upload Summary */
    .upload-summary {
        background: white;
        border-radius: 12px;
        padding: 20px;
        margin-top: 25px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        display: none;
    }
    
    .upload-summary.active {
        display: block;
    }
    
    .summary-stats {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
    }
    
    .stat-item {
        flex: 1;
        min-width: 120px;
        text-align: center;
        padding: 15px;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 10px;
    }
    
    .stat-item .stat-number {
        font-size: 28px;
        font-weight: 700;
        color: #19868b;
    }
    
    .stat-item .stat-label {
        font-size: 13px;
        color: #6c757d;
        margin-top: 5px;
    }
    
    /* Submit Button */
    .submit-section {
        margin-top: 30px;
        text-align: center;
    }
    
    .btn-upload {
        background: linear-gradient(135deg, #19868b 0%, #0d6b6f 100%);
        color: white;
        border: none;
        padding: 15px 50px;
        border-radius: 10px;
        font-size: 18px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .btn-upload:hover:not(:disabled) {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(25, 134, 139, 0.3);
        color: white;
    }
    
    .btn-upload:disabled {
        background: #6c757d;
        cursor: not-allowed;
    }
    
    .btn-upload i {
        margin-right: 10px;
    }
    
    /* Info Box */
    .info-box {
        background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
        border-left: 4px solid #2196f3;
        border-radius: 8px;
        padding: 15px 20px;
        margin-top: 20px;
    }
    
    .info-box h6 {
        color: #1565c0;
        font-weight: 600;
        margin-bottom: 10px;
    }
    
    .info-box ul {
        margin: 0;
        padding-left: 20px;
        color: #1976d2;
    }
    
    .info-box ul li {
        margin-bottom: 5px;
    }
    
    /* Loading Overlay */
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.7);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }
    
    .loading-overlay.active {
        display: flex;
    }
    
    .loading-content {
        background: white;
        padding: 40px 60px;
        border-radius: 15px;
        text-align: center;
    }
    
    .loading-spinner {
        width: 60px;
        height: 60px;
        border: 4px solid #e9ecef;
        border-top-color: #19868b;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin: 0 auto 20px;
    }
    
    @keyframes spin {
        to { transform: rotate(360deg); }
    }
    
    .loading-text {
        color: #2c3e50;
        font-size: 18px;
        font-weight: 600;
    }
    
    .loading-progress {
        color: #6c757d;
        font-size: 14px;
        margin-top: 10px;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="<?php echo e(route('Admin')); ?>" class="breadcrumbs__item"><i class="fa fa-home"></i> Dashboard</a>
            <a href="<?php echo e(route('interior-design-gallery.index')); ?>" class="breadcrumbs__item"><i class="fa fa-list"></i> Interior Design Gallery</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-plus"></i> Bulk Add</a>
        </nav>

        <div class="col-12 mx-auto">
            <hr>
            
            <?php if(session('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                    <i class="fa fa-exclamation-circle"></i> <strong>Error!</strong> <?php echo e(session('error')); ?>

                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>
            
            <div class="bulk-upload-container">
                <div class="upload-header">
                    <h2><i class="fa fa-images"></i> Bulk Add Interior Design Gallery</h2>
                    <p>Upload multiple images at once with auto-generated titles based on category</p>
                </div>
                
                <form action="<?php echo e(route('interior-design-gallery.bulk-store')); ?>" method="POST" enctype="multipart/form-data" id="bulkUploadForm">
                    <?php echo csrf_field(); ?>
                    
                    <div class="row">
                        <!-- Settings Column -->
                        <div class="col-lg-4">
                            <div class="settings-card">
                                <h5><i class="fa fa-cog"></i> Upload Settings</h5>
                                
                                <div class="form-group">
                                    <label><i class="fa fa-folder"></i> Category <span class="text-danger">*</span></label>
                                    <select class="form-control select2" name="category_id" id="categorySelect" required>
                                        <option value="">Select Category</option>
                                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($category->id); ?>" 
                                                    data-name-en="<?php echo e($category->title_english); ?>"
                                                    data-name-ar="<?php echo e($category->title_arabic); ?>">
                                                <?php echo e($category->title_english); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label><i class="fa fa-cube"></i> Project Type <span class="text-danger">*</span></label>
                                    <select class="form-control select2" name="project_type_id" id="projectTypeSelect" required>
                                        <option value="">Select Project Type</option>
                                        <?php $__currentLoopData = $projectTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($type->id); ?>"><?php echo e($type->name_english); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                
                                <!-- Category Preview -->
                                <div class="category-preview" id="categoryPreview">
                                    <h6><i class="fa fa-info-circle"></i> Auto-Generated Title Preview</h6>
                                    <div class="preview-item">
                                        <span class="preview-label">English Title:</span>
                                        <span class="preview-value" id="previewTitleEn">-</span>
                                    </div>
                                    <div class="preview-item">
                                        <span class="preview-label">Arabic Title:</span>
                                        <span class="preview-value" id="previewTitleAr">-</span>
                                    </div>
                                    <div class="preview-item">
                                        <span class="preview-label">Next Number:</span>
                                        <span class="preview-value" id="previewNextNumber">-</span>
                                    </div>
                                    <div id="existingNumbersContainer" style="display: none;">
                                        <h6 style="margin-top: 15px;"><i class="fa fa-list-ol"></i> Existing Numbers</h6>
                                        <div class="existing-numbers-list" id="existingNumbersList"></div>
                                    </div>
                                </div>
                                
                                <!-- Info Box -->
                                <div class="info-box">
                                    <h6><i class="fa fa-lightbulb-o"></i> How it works</h6>
                                    <ul>
                                        <li>Select a category to auto-generate titles</li>
                                        <li>Titles will be: "Category Name 1", "Category Name 2", etc.</li>
                                        <li>System checks for existing numbers to avoid duplicates</li>
                                        <li>Images are saved one by one for easy editing later</li>
                                        <li>Default: Unpublished & Hidden from Home</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Upload Column -->
                        <div class="col-lg-8">
                            <div class="dropzone-container">
                                <h5><i class="fa fa-cloud-upload"></i> Upload Images</h5>
                                
                                <div class="custom-dropzone" id="dropzone">
                                    <input type="file" name="images[]" id="fileInput" class="file-input" multiple accept="image/*">
                                    <div class="dropzone-icon">
                                        <i class="fa fa-cloud-upload"></i>
                                    </div>
                                    <div class="dropzone-text">
                                        <h4>Drag & Drop Images Here</h4>
                                        <p>or click to browse files</p>
                                        <span class="dropzone-btn">Select Images</span>
                                    </div>
                                </div>
                                
                                <!-- Preview Grid -->
                                <div class="preview-grid" id="previewGrid"></div>
                                
                                <!-- Upload Summary -->
                                <div class="upload-summary" id="uploadSummary">
                                    <div class="summary-stats">
                                        <div class="stat-item">
                                            <div class="stat-number" id="totalImages">0</div>
                                            <div class="stat-label">Total Images</div>
                                        </div>
                                        <div class="stat-item">
                                            <div class="stat-number" id="totalSize">0 MB</div>
                                            <div class="stat-label">Total Size</div>
                                        </div>
                                        <div class="stat-item">
                                            <div class="stat-number" id="startNumber">1</div>
                                            <div class="stat-label">Starting Number</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Submit Section -->
                            <div class="submit-section">
                                <button type="submit" class="btn btn-upload" id="submitBtn" disabled>
                                    <i class="fa fa-upload"></i> Upload All Images
                                </button>
                                <a href="<?php echo e(route('interior-design-gallery.index')); ?>" class="btn btn-secondary ml-3" style="padding: 15px 30px; border-radius: 10px;">
                                    <i class="fa fa-times"></i> Cancel
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Loading Overlay -->
<div class="loading-overlay" id="loadingOverlay">
    <div class="loading-content">
        <div class="loading-spinner"></div>
        <div class="loading-text">Uploading Images...</div>
        <div class="loading-progress" id="loadingProgress">Please wait...</div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    // Initialize Select2
    $('.select2').select2({
        width: '100%'
    });
    
    let selectedFiles = [];
    let nextNumber = 1;
    let categoryNameEn = '';
    let categoryNameAr = '';
    let existingNumbers = [];
    
    // Category change handler
    $('#categorySelect').on('change', function() {
        const categoryId = $(this).val();
        
        if (categoryId) {
            // Fetch next number from server
            $.ajax({
                url: '<?php echo e(route("interior-design-gallery.get-next-number", ["categoryId" => "__ID__"])); ?>'.replace('__ID__', categoryId),
                type: 'GET',
                success: function(response) {
                    categoryNameEn = response.category_name_english;
                    categoryNameAr = response.category_name_arabic;
                    nextNumber = response.next_number;
                    existingNumbers = response.existing_numbers || [];
                    
                    // Update preview
                    $('#previewTitleEn').text(categoryNameEn + ' ' + nextNumber);
                    $('#previewTitleAr').text(categoryNameAr + ' ' + nextNumber);
                    $('#previewNextNumber').text(nextNumber);
                    $('#startNumber').text(nextNumber);
                    
                    // Show existing numbers
                    if (existingNumbers.length > 0) {
                        $('#existingNumbersContainer').show();
                        let badgesHtml = '';
                        existingNumbers.forEach(function(num) {
                            badgesHtml += '<span class="existing-number-badge">' + num + '</span>';
                        });
                        $('#existingNumbersList').html(badgesHtml);
                    } else {
                        $('#existingNumbersContainer').hide();
                    }
                    
                    $('#categoryPreview').addClass('active');
                    
                    // Update preview items
                    updatePreviewTitles();
                    checkFormValidity();
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to fetch category information.',
                        confirmButtonColor: '#19868b'
                    });
                }
            });
        } else {
            $('#categoryPreview').removeClass('active');
            categoryNameEn = '';
            categoryNameAr = '';
            nextNumber = 1;
            existingNumbers = [];
            checkFormValidity();
        }
    });
    
    // Project type change handler
    $('#projectTypeSelect').on('change', function() {
        checkFormValidity();
    });
    
    // Dropzone functionality
    const dropzone = document.getElementById('dropzone');
    const fileInput = document.getElementById('fileInput');
    
    // Drag and drop events
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropzone.addEventListener(eventName, preventDefaults, false);
    });
    
    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }
    
    ['dragenter', 'dragover'].forEach(eventName => {
        dropzone.addEventListener(eventName, () => dropzone.classList.add('dragover'), false);
    });
    
    ['dragleave', 'drop'].forEach(eventName => {
        dropzone.addEventListener(eventName, () => dropzone.classList.remove('dragover'), false);
    });
    
    dropzone.addEventListener('drop', handleDrop, false);
    fileInput.addEventListener('change', handleFileSelect, false);
    
    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        handleFiles(files);
    }
    
    function handleFileSelect(e) {
        const files = e.target.files;
        handleFiles(files);
    }
    
    function handleFiles(files) {
        const validFiles = Array.from(files).filter(file => {
            if (!file.type.startsWith('image/')) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Invalid File',
                    text: `${file.name} is not an image file.`,
                    confirmButtonColor: '#19868b'
                });
                return false;
            }
            if (file.size > 5 * 1024 * 1024) {
                Swal.fire({
                    icon: 'warning',
                    title: 'File Too Large',
                    text: `${file.name} exceeds 5MB limit.`,
                    confirmButtonColor: '#19868b'
                });
                return false;
            }
            return true;
        });
        
        selectedFiles = selectedFiles.concat(validFiles);
        updatePreview();
        checkFormValidity();
    }
    
    function updatePreview() {
        const previewGrid = document.getElementById('previewGrid');
        previewGrid.innerHTML = '';
        
        let totalSize = 0;
        let tempNumbers = [...existingNumbers];
        
        selectedFiles.forEach((file, index) => {
            totalSize += file.size;
            
            // Calculate the number for this image
            let imageNumber = getNextAvailableNumber(tempNumbers);
            tempNumbers.push(imageNumber);
            
            const reader = new FileReader();
            reader.onload = function(e) {
                const card = document.createElement('div');
                card.className = 'preview-item-card';
                card.innerHTML = `
                    <span class="preview-item-number">#${imageNumber}</span>
                    <button type="button" class="preview-item-remove" onclick="removeFile(${index})">
                        <i class="fa fa-times"></i>
                    </button>
                    <img src="${e.target.result}" alt="Preview">
                    <div class="preview-item-info">
                        <div class="preview-item-title">${categoryNameEn ? categoryNameEn + ' ' + imageNumber : file.name}</div>
                        <div class="preview-item-size">${formatFileSize(file.size)}</div>
                    </div>
                `;
                previewGrid.appendChild(card);
            };
            reader.readAsDataURL(file);
        });
        
        // Update summary
        if (selectedFiles.length > 0) {
            document.getElementById('uploadSummary').classList.add('active');
            document.getElementById('totalImages').textContent = selectedFiles.length;
            document.getElementById('totalSize').textContent = formatFileSize(totalSize);
        } else {
            document.getElementById('uploadSummary').classList.remove('active');
        }
    }
    
    function getNextAvailableNumber(usedNumbers) {
        let num = 1;
        while (usedNumbers.includes(num)) {
            num++;
        }
        return num;
    }
    
    function updatePreviewTitles() {
        // Re-render preview with updated category names
        if (selectedFiles.length > 0) {
            updatePreview();
        }
    }
    
    window.removeFile = function(index) {
        selectedFiles.splice(index, 1);
        updateFileInput();
        updatePreview();
        checkFormValidity();
    };
    
    function updateFileInput() {
        // Create a new DataTransfer object and add remaining files
        const dt = new DataTransfer();
        selectedFiles.forEach(file => dt.items.add(file));
        fileInput.files = dt.files;
    }
    
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }
    
    function checkFormValidity() {
        const categorySelected = $('#categorySelect').val();
        const typeSelected = $('#projectTypeSelect').val();
        const hasFiles = selectedFiles.length > 0;
        
        $('#submitBtn').prop('disabled', !(categorySelected && typeSelected && hasFiles));
    }
    
    // Form submission
    $('#bulkUploadForm').on('submit', function(e) {
        if (selectedFiles.length === 0) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'No Images',
                text: 'Please select at least one image to upload.',
                confirmButtonColor: '#19868b'
            });
            return false;
        }
        
        // Update file input with selected files
        updateFileInput();
        
        // Show loading overlay
        $('#loadingOverlay').addClass('active');
        $('#loadingProgress').text(`Uploading ${selectedFiles.length} image(s)...`);
    });
    
    // Display success message if exists
    <?php if(session('success')): ?>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '<?php echo e(session('success')); ?>',
            confirmButtonColor: '#19868b'
        });
    <?php endif; ?>
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\smartvisionuae\Modules/Admin\resources/views/interior-design-galleries/bulk-add.blade.php ENDPATH**/ ?>