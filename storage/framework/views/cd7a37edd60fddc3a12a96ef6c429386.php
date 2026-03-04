<?php $__env->startSection('title', 'Project Details'); ?>

<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('/css/auto-translate.css')); ?>">
<!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<!-- Animate.css for SweetAlert2 animations -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<!-- Image Uploader CSS -->
<link rel="stylesheet" href="<?php echo e(asset('/css/dropify.min.css')); ?>">
<link href="<?php echo e(asset('/css/select2.min.css')); ?>" rel="stylesheet" type="text/css" />
<script src="<?php echo e(asset('/js/image-uploader.min.js')); ?>"></script>
<style>
    .image-uploader {
        min-height: 200px;
    }
    #gallery-count {
        font-size: 0.9rem;
        padding: 0.25rem 0.5rem;
    }
    
    /* Gallery Preview Thumbnails */
    .gallery-thumbs-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }
    .gallery-thumbs-grid .gallery-thumb-item {
        display: block;
        width: 80px;
        height: 80px;
        position: relative;
        border-radius: 6px;
        overflow: hidden;
        box-shadow: 0 2px 5px rgba(0,0,0,0.15);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .gallery-thumbs-grid .gallery-thumb-item:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(0,0,0,0.25);
    }
    .gallery-thumbs-grid .gallery-thumb-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }
    .gallery-thumbs-grid .gallery-thumb-item .thumb-order {
        position: absolute;
        top: 3px;
        left: 3px;
        background: rgba(0,0,0,0.7);
        color: #fff;
        font-size: 10px;
        font-weight: bold;
        padding: 2px 6px;
        border-radius: 3px;
        z-index: 3;
    }
    .gallery-thumbs-grid .gallery-thumb-item .thumb-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.4);
        opacity: 0;
        transition: opacity 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .gallery-thumbs-grid .gallery-thumb-item:hover .thumb-overlay {
        opacity: 1;
    }
    .gallery-thumbs-grid .gallery-thumb-item .thumb-overlay i {
        color: white;
        font-size: 18px;
    }
    
    /* Lightbox2 Customization for Project Gallery */
    .lightboxOverlay {
        cursor: pointer !important;
        background-color: rgba(0, 0, 0, 0.85) !important;
    }
    .lb-outerContainer {
        background-color: transparent !important;
        border-radius: 8px !important;
    }
    .lb-container {
        padding: 0 !important;
    }
    .lb-image {
        max-width: 500px !important;
        max-height: 400px !important;
        border-radius: 8px !important;
        border: 3px solid #fff !important;
    }
    .lb-dataContainer {
        padding: 10px 0 !important;
    }
    .lb-data .lb-details {
        width: 100% !important;
    }
    .lb-data .lb-caption {
        font-size: 14px !important;
        color: #ccc !important;
    }
    .lb-data .lb-number {
        color: #999 !important;
        font-size: 12px !important;
    }
    .lb-closeContainer .lb-close {
        cursor: pointer !important;
        width: 30px !important;
        height: 30px !important;
        opacity: 0.7 !important;
        transition: opacity 0.2s ease !important;
    }
    .lb-closeContainer .lb-close:hover {
        opacity: 1 !important;
    }
    .lb-nav a.lb-prev,
    .lb-nav a.lb-next {
        opacity: 0.6 !important;
    }
    .lb-nav a.lb-prev:hover,
    .lb-nav a.lb-next:hover {
        opacity: 1 !important;
    }
    .project-show-container {
        display: flex;
        gap: 20px;
        min-height: 600px;
        width: 100%;
        max-width: 100%;
    }
    
    /* Left Section Styles */
    .left-section {
        flex: 0 0 350px;
        background: #fff;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        height: fit-content;
        position: sticky;
        top: 20px;
    }
    
    .project-main-image {
        width: 100%;
        height: 250px;
        object-fit: cover;
        border-radius: 8px;
        margin-bottom: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        cursor: pointer;
    }
    
    .project-title {
        font-size: 22px;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 15px;
        line-height: 1.4;
    }
    
    .project-meta-item {
        padding: 12px 0;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .project-meta-item:last-child {
        border-bottom: none;
    }
    
    .project-meta-label {
        font-size: 12px;
        color: #7f8c8d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 5px;
    }
    
    .project-meta-value {
        font-size: 15px;
        color: #2c3e50;
        font-weight: 500;
    }
    
    /* Action Buttons Styles */
    .btn-block {
        transition: all 0.3s ease;
        font-weight: 500;
        border-radius: 6px;
        padding: 10px 15px;
    }
    
    .btn-block:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }
    
    .btn-block i {
        margin-right: 5px;
    }
    
    /* SweetAlert2 Custom Styling */
    .swal2-popup {
        border-radius: 12px;
        font-family: inherit;
    }
    
    .swal2-title {
        font-size: 24px;
        font-weight: 600;
        color: #2c3e50;
    }
    
    .swal2-html-container {
        font-size: 16px;
        color: #6c757d;
    }
    
    .swal2-confirm, .swal2-cancel {
        border-radius: 6px;
        font-weight: 500;
        padding: 10px 24px;
        font-size: 15px;
    }
    
    .swal2-icon {
        border-width: 3px;
    }
    
    /* Toast Notification Custom Styling */
    .swal2-toast {
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    
    /* Right Section - Tabs */
    .right-section {
        flex: 1;
        min-width: 0;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        display: flex;
    }
    
    .vertical-tabs {
        flex: 0 0 200px;
        background: #f8f9fa;
        border-radius: 8px 0 0 8px;
        padding: 20px 0;
    }
    
    .tab-item {
        padding: 15px 25px;
        cursor: pointer;
        border-left: 3px solid transparent;
        transition: all 0.3s ease;
        font-size: 14px;
        color: #495057;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .tab-item i {
        font-size: 16px;
    }
    
    .tab-item:hover {
        background: #e9ecef;
    }
    
    .tab-item.active {
        background: #fff;
        border-left-color: #007bff;
        color: #007bff;
        font-weight: 600;
    }
    
    .tab-content-area {
        flex: 1;
        min-width: 0;
        padding: 30px;
        overflow-y: auto;
        overflow-x: hidden;
    }
    
    .tab-pane {
        display: none;
    }
    
    .tab-pane.active {
        display: block;
        animation: fadeIn 0.3s ease-in;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    /* Activity Log Styles */
    .activity-log-list {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }
    
    .activity-log-item {
        display: flex;
        gap: 15px;
        padding: 15px;
        background: #f8f9fa;
        border-radius: 8px;
        border-left: 4px solid #19868b;
        transition: all 0.2s ease;
    }
    
    .activity-log-item:hover {
        background: #fff;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .activity-log-icon {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        flex-shrink: 0;
    }
    
    .activity-log-icon.create { background: linear-gradient(135deg, #28a745 0%, #20c997 100%); }
    .activity-log-icon.update { background: linear-gradient(135deg, #17a2b8 0%, #6f42c1 100%); }
    .activity-log-icon.delete { background: linear-gradient(135deg, #dc3545 0%, #fd7e14 100%); }
    .activity-log-icon.restore { background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%); }
    .activity-log-icon.toggle_status { background: linear-gradient(135deg, #6c757d 0%, #495057 100%); }
    
    .activity-log-content {
        flex: 1;
        min-width: 0;
    }
    
    .activity-log-header {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 8px;
        flex-wrap: wrap;
    }
    
    .activity-log-time {
        font-size: 12px;
        color: #6c757d;
    }
    
    .activity-log-description {
        font-size: 14px;
        color: #333;
        margin-bottom: 8px;
    }
    
    .activity-log-meta {
        display: flex;
        gap: 15px;
        font-size: 12px;
        color: #6c757d;
    }
    
    .activity-log-meta i {
        margin-right: 4px;
    }
    
    .activity-log-changes {
        margin-top: 8px;
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
        align-items: center;
    }
    
    .changed-field-badge {
        font-size: 10px;
        padding: 2px 8px;
        background: #e9ecef;
        border-radius: 4px;
        color: #495057;
        text-transform: capitalize;
    }
    
    .activity-log-actions {
        flex-shrink: 0;
    }
    
    .activity-log-pagination {
        display: flex;
        justify-content: center;
    }
    
    .activity-log-pagination .pagination {
        margin: 0;
    }
    
    /* Timestamp Cards Styles */
    .timestamp-card {
        display: flex;
        gap: 15px;
        padding: 20px;
        background: #f8f9fa;
        border-radius: 10px;
        border-left: 4px solid #19868b;
        margin-bottom: 15px;
    }
    
    .timestamp-card.created {
        border-left-color: #28a745;
        background: linear-gradient(135deg, #f8fff9 0%, #f0fdf2 100%);
    }
    
    .timestamp-card.updated {
        border-left-color: #17a2b8;
        background: linear-gradient(135deg, #f8fcff 0%, #f0f9fd 100%);
    }
    
    .timestamp-icon {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        color: #fff;
        flex-shrink: 0;
    }
    
    .timestamp-card.created .timestamp-icon {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    }
    
    .timestamp-card.updated .timestamp-icon {
        background: linear-gradient(135deg, #17a2b8 0%, #6f42c1 100%);
    }
    
    .timestamp-content {
        flex: 1;
    }
    
    .timestamp-title {
        font-size: 14px;
        font-weight: 600;
        color: #333;
        margin-bottom: 10px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .timestamp-date,
    .timestamp-time,
    .timestamp-user {
        font-size: 13px;
        color: #495057;
        margin-bottom: 5px;
    }
    
    .timestamp-date i,
    .timestamp-time i,
    .timestamp-user i {
        width: 18px;
        color: #6c757d;
    }
    
    .timestamp-user {
        margin-top: 10px;
        padding-top: 10px;
        border-top: 1px dashed #dee2e6;
    }
    
    .last-update-fields {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }
    
    .last-update-fields .changed-field-badge {
        font-size: 11px;
        padding: 4px 10px;
        background: #e9ecef;
        border-radius: 4px;
        color: #495057;
        text-transform: capitalize;
    }
    
    .info-row {
        display: flex;
        padding: 15px 0;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .info-row:last-child {
        border-bottom: none;
    }
    
    .info-label {
        flex: 0 0 200px;
        font-weight: 600;
        color: #495057;
        font-size: 14px;
    }
    
    .info-value {
        flex: 1;
        color: #6c757d;
        font-size: 14px;
    }
    
    .description-content {
        line-height: 1.8;
        color: #495057;
        font-size: 14px;
    }
    
    .image-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 15px;
        margin-top: 15px;
    }
    
    .image-grid-item {
        position: relative;
        aspect-ratio: 1;
        overflow: hidden;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        cursor: pointer;
    }
    
    .image-grid-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    
    .image-grid-item:hover img {
        transform: scale(1.1);
    }
    
    .image-label {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0,0,0,0.7);
        color: #fff;
        padding: 8px;
        font-size: 12px;
        text-align: center;
    }
    
    /* Custom Lightbox for Project Images */
    .custom-lightbox {
        display: none;
        position: fixed;
        z-index: 9999;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.85);
        justify-content: center;
        align-items: center;
        cursor: pointer;
    }
    
    .custom-lightbox.active {
        display: flex;
    }
    
    .custom-lightbox img {
        max-width: 500px;
        max-height: 400px;
        border-radius: 8px;
        border: 3px solid #fff;
        box-shadow: 0 0 30px rgba(0,0,0,0.5);
        cursor: default;
    }
    
    .custom-lightbox-close {
        position: absolute;
        top: 20px;
        right: 30px;
        color: #fff;
        font-size: 30px;
        cursor: pointer;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
        transition: background 0.2s ease;
    }
    
    .custom-lightbox-close:hover {
        background: rgba(255,255,255,0.3);
    }
    
    .seo-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }
    
    .seo-tag {
        background: #e7f3ff;
        color: #0066cc;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 13px;
        border: 1px solid #b3d9ff;
    }
    
    /* Responsive Tables Fix */
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        margin-bottom: 1rem;
    }
    
    .table-responsive table {
        width: 100%;
    }
    
    /* Ensure tables don't break layout */
    .tab-content-area .table-responsive {
        max-width: 100%;
    }
    
    .table-responsive th,
    .table-responsive td {
        white-space: nowrap;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="<?php echo e(route('Admin')); ?>" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a href="<?php echo e(route('project.index')); ?>" class="breadcrumbs__item"><i class="fa fa-building"></i> Projects</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-eye"></i> Project Details</a>
        </nav>

        <div class="col-12">
            <hr>
            
            
            <!-- Project Show Container -->
            <div class="project-show-container">
                
                <!-- Left Section -->
                <div class="left-section">
                    <img src="<?php echo e(asset('storage' . $project->main_image)); ?>" alt="<?php echo e($project->title_english); ?>" class="project-main-image" onclick="openLightbox('<?php echo e(asset('storage' . $project->main_image)); ?>')">
                    
                    <h4 class="project-title"><?php echo e($project->title_english); ?></h4>
                    <p class="text-muted mb-3"><?php echo e($project->title_arabic); ?></p>
                    
                    <?php if($project->project_code): ?>
                    <div class="project-meta-item">
                        <div class="project-meta-label">Project Code</div>
                        <div class="project-meta-value">
                            <span class="badge" style="font-size: 13px; padding: 6px 12px; background: linear-gradient(135deg, #19868b 0%, #0d6b6f 100%); color: white;">
                                <i class="fa fa-barcode"></i> <?php echo e($project->project_code); ?>

                            </span>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <?php if($project->project_number): ?>
                    <div class="project-meta-item">
                        <div class="project-meta-label">Project Number</div>
                        <div class="project-meta-value">
                            <span class="badge badge-secondary" style="font-size: 13px; padding: 6px 12px;">
                                <i class="fa fa-list-ol"></i> <?php echo e($project->project_number); ?>

                            </span>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <div class="project-meta-item">
                        <div class="project-meta-label">Category</div>
                        <div class="project-meta-value">
                            <?php if($project->category_name_en): ?>
                                <span class="badge badge-primary"><?php echo e($project->category_name_en); ?></span>
                            <?php else: ?>
                                <span class="text-muted">N/A</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="project-meta-item">
                        <div class="project-meta-label">Type</div>
                        <div class="project-meta-value">
                            <?php if($project->type_name_en): ?>
                                <span class="badge badge-info"><?php echo e($project->type_name_en); ?></span>
                            <?php else: ?>
                                <span class="text-muted">N/A</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="project-meta-item">
                        <div class="project-meta-label">Publish Status</div>
                        <div class="project-meta-value">
                            <?php if($project->publish_status == 0): ?>
                                <span class="badge badge-success"><i class="fa fa-check-circle"></i> Published</span>
                            <?php else: ?>
                                <span class="badge badge-danger"><i class="fa fa-times-circle"></i> Unpublished</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="project-meta-item">
                        <div class="project-meta-label">Home Status</div>
                        <div class="project-meta-value">
                            <?php if($project->home_status == 0): ?>
                                <span class="badge badge-success"><i class="fa fa-eye"></i> Shown</span>
                            <?php else: ?>
                                <span class="badge badge-warning"><i class="fa fa-eye-slash"></i> Hidden</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <!-- Action Buttons -->
                        <div class="mb-3">
                            <h6 class="text-muted mb-2" style="font-size: 13px; text-transform: uppercase;">Quick Actions</h6>
                            
                            <!-- Publish Status Toggle -->
                            <form action="<?php echo e(route('project.toggle-publish', ['id' => $project->id])); ?>" method="POST" class="mb-2" id="publishForm">
                                <?php echo csrf_field(); ?>
                                <?php if($project->publish_status == 0): ?>
                                    <button type="button" class="btn btn-danger btn-block" onclick="confirmPublishToggle('unpublish')">
                                        <i class="fa fa-times-circle"></i> Unpublish Project
                                    </button>
                                <?php else: ?>
                                    <button type="button" class="btn btn-success btn-block" onclick="confirmPublishToggle('publish')">
                                        <i class="fa fa-check-circle"></i> Publish Project
                                    </button>
                                <?php endif; ?>
                            </form>
                            
                            <!-- Home Status Toggle -->
                            <form action="<?php echo e(route('project.toggle-home-feature', ['id' => $project->id])); ?>" method="POST" class="mb-2" id="homeForm">
                                <?php echo csrf_field(); ?>
                                <?php if($project->home_status == 0): ?>
                                    <button type="button" class="btn btn-warning btn-block" onclick="confirmHomeToggle('hide')">
                                        <i class="fa fa-eye-slash"></i> Hide from Home
                                    </button>
                                <?php else: ?>
                                    <button type="button" class="btn btn-info btn-block" onclick="confirmHomeToggle('show')">
                                        <i class="fa fa-eye"></i> Show on Home
                                    </button>
                                <?php endif; ?>
                            </form>
                        </div>
                        
                        <hr style="border-top: 1px solid #e0e0e0; margin: 20px 0;">
                        
                        <!-- Navigation Buttons -->
                        <a href="<?php echo e(route('project.index')); ?>" class="btn btn-primary btn-block mb-2">
                            <i class="fa fa-list"></i> Back to List
                        </a>
                        <a href="<?php echo e(route('project.edit', ['id' => $project->id])); ?>" class="btn btn-warning btn-block mb-2">
                            <i class="fa fa-pencil"></i> Edit Project
                        </a>
                        <a href="<?php echo e(url('en/projects/' . $project->slug)); ?>" target="_blank" class="btn btn-success btn-block" style="background: linear-gradient(135deg, #19868b 0%, #0d6b6f 100%); border: none;">
                            <i class="fa fa-external-link"></i> View on Website
                        </a>
                    </div>
                </div>
                
                <!-- Right Section - Tabs -->
                <div class="right-section">
                    <div class="vertical-tabs">
                        <div class="tab-item active" data-tab="basic-info">
                            <i class="fa fa-info-circle"></i>
                            <span>Basic Info</span>
                        </div>
                        <div class="tab-item" data-tab="classifications">
                            <i class="fa fa-tags"></i>
                            <span>Classifications</span>
                        </div>
                        <div class="tab-item" data-tab="measurements">
                            <i class="fa fa-calculator"></i>
                            <span>Measurements</span>
                        </div>
                        <div class="tab-item" data-tab="images">
                            <i class="fa fa-image"></i>
                            <span>Images</span>
                        </div>
                        <div class="tab-item" data-tab="gallery">
                            <i class="fa fa-image"></i>
                            <span>Gallery</span>
                        </div>
                        <div class="tab-item" data-tab="building-components">
                            <i class="fa fa-cube"></i>
                            <span>Building Components</span>
                        </div>
                        <div class="tab-item" data-tab="floors">
                            <i class="fa fa-building"></i>
                            <span>Floors</span>
                        </div>
                        <div class="tab-item" data-tab="length-components">
                            <i class="mdi mdi-ruler"></i>
                            <span>Length Components</span>
                        </div>
                        <div class="tab-item" data-tab="income-components">
                            <i class="fa fa-dollar"></i>
                            <span>Income Components</span>
                        </div>
                        <div class="tab-item" data-tab="construction-costs">
                            <i class="fa fa-calculator"></i>
                            <span>Construction Costs</span>
                        </div>
                        <div class="tab-item" data-tab="specifications">
                            <i class="fa fa-list-alt"></i>
                            <span>Specifications</span>
                        </div>
                        <div class="tab-item" data-tab="media">
                            <i class="fa fa-film"></i>
                            <span>Media</span>
                        </div>
                        <div class="tab-item" data-tab="descriptions">
                            <i class="fa fa-align-left"></i>
                            <span>Descriptions</span>
                        </div>
                        <div class="tab-item" data-tab="seo">
                            <i class="fa fa-search"></i>
                            <span>SEO</span>
                        </div>
                        <div class="tab-item" data-tab="timestamps">
                            <i class="fa fa-clock-o"></i>
                            <span>Timestamps</span>
                        </div>
                        <div class="tab-item" data-tab="feasibility-studies">
                            <i class="fa fa-money"></i>
                            <span>Feasibility Studies</span>
                        </div>
                        <div class="tab-item" data-tab="activity-log">
                            <i class="fa fa-history"></i>
                            <span>Activity Log</span>
                        </div>
                    </div>
                    
                    <div class="tab-content-area">
                        <!-- Basic Info Tab -->
                        <div class="tab-pane active" id="basic-info">
                            <h5 class="mb-4 text-primary">Basic Information</h5>
                            
                            <div class="info-row">
                                <div class="info-label">ID</div>
                                <div class="info-value"><strong>#<?php echo e($project->id); ?></strong></div>
                            </div>
                            
                            <?php if($project->project_code): ?>
                            <div class="info-row">
                                <div class="info-label">Project Code</div>
                                <div class="info-value">
                                    <span class="badge badge-success" style="font-size: 14px; padding: 8px 15px; background: linear-gradient(135deg, #19868b 0%, #0d6b6f 100%);">
                                        <i class="fa fa-barcode"></i> <?php echo e($project->project_code); ?>

                                    </span>
                                </div>
                            </div>
                            <?php endif; ?>
                            
                            <div class="info-row">
                                <div class="info-label">Project Number</div>
                                <div class="info-value">
                                    <?php if($project->project_number): ?>
                                        <span class="badge badge-secondary" style="font-size: 14px; padding: 8px 15px;">
                                            <i class="fa fa-list-ol"></i> <?php echo e($project->project_number); ?>

                                        </span>
                                    <?php else: ?>
                                        <span class="text-muted">N/A</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">English Title</div>
                                <div class="info-value"><?php echo e($project->title_english); ?></div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">Arabic Title</div>
                                <div class="info-value"><?php echo e($project->title_arabic); ?></div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">Slug</div>
                                <div class="info-value"><code><?php echo e($project->slug); ?></code></div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">Location (English)</div>
                                <div class="info-value">
                                    <?php if($project->location_english): ?>
                                        <i class="fa fa-map-marker text-danger"></i> <?php echo e($project->location_english); ?>

                                    <?php else: ?>
                                        <span class="text-muted">N/A</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">Location (Arabic)</div>
                                <div class="info-value">
                                    <?php if($project->location_arabic): ?>
                                        <i class="fa fa-map-marker text-danger"></i> <?php echo e($project->location_arabic); ?>

                                    <?php else: ?>
                                        <span class="text-muted">N/A</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">Project Cost</div>
                                <div class="info-value">
                                    <?php if($project->project_cost): ?>
                                        <strong class="text-success" style="font-size: 16px;">
                                            <?php if($project->currency_abbr): ?>
                                                <?php echo e($project->currency_abbr); ?> <?php echo e(number_format($project->project_cost, 2)); ?>

                                            <?php else: ?>
                                                <?php echo e(number_format($project->project_cost, 2)); ?>

                                            <?php endif; ?>
                                        </strong>
                                    <?php else: ?>
                                        <span class="text-muted">N/A</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">Emirate</div>
                                <div class="info-value">
                                    <?php if($project->emirate_name_en): ?>
                                        <span class="badge badge-secondary"><?php echo e($project->emirate_name_en); ?></span>
                                    <?php else: ?>
                                        <span class="text-muted">N/A</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">Bio English</div>
                                <div class="info-value"><?php echo e($project->bio_english ?: 'N/A'); ?></div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">Bio Arabic</div>
                                <div class="info-value"><?php echo e($project->bio_arabic ?: 'N/A'); ?></div>
                            </div>
                        </div>
                        
                        <!-- Classifications Tab -->
                        <div class="tab-pane" id="classifications">
                            <h5 class="mb-4 text-primary">Project Classifications</h5>
                            
                            <div class="info-row">
                                <div class="info-label">Category (English)</div>
                                <div class="info-value">
                                    <?php if($project->category_name_en): ?>
                                        <span class="badge badge-primary"><?php echo e($project->category_name_en); ?></span>
                                    <?php else: ?>
                                        <span class="text-muted">N/A</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">Category (Arabic)</div>
                                <div class="info-value">
                                    <?php if($project->category_name_ar): ?>
                                        <span class="badge badge-primary"><?php echo e($project->category_name_ar); ?></span>
                                    <?php else: ?>
                                        <span class="text-muted">N/A</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">Subcategory (English)</div>
                                <div class="info-value">
                                    <?php if($project->subcategory_name_en): ?>
                                        <span class="badge badge-secondary"><?php echo e($project->subcategory_name_en); ?></span>
                                    <?php else: ?>
                                        <span class="text-muted">N/A</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">Subcategory (Arabic)</div>
                                <div class="info-value">
                                    <?php if($project->subcategory_name_ar): ?>
                                        <span class="badge badge-secondary"><?php echo e($project->subcategory_name_ar); ?></span>
                                    <?php else: ?>
                                        <span class="text-muted">N/A</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">Type (English)</div>
                                <div class="info-value">
                                    <?php if($project->type_name_en): ?>
                                        <span class="badge badge-info"><?php echo e($project->type_name_en); ?></span>
                                    <?php else: ?>
                                        <span class="text-muted">N/A</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">Type (Arabic)</div>
                                <div class="info-value">
                                    <?php if($project->type_name_ar): ?>
                                        <span class="badge badge-info"><?php echo e($project->type_name_ar); ?></span>
                                    <?php else: ?>
                                        <span class="text-muted">N/A</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">Style (English)</div>
                                <div class="info-value">
                                    <?php if($project->style_name_en): ?>
                                        <span class="badge badge-success"><?php echo e($project->style_name_en); ?></span>
                                    <?php else: ?>
                                        <span class="text-muted">N/A</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">Style (Arabic)</div>
                                <div class="info-value">
                                    <?php if($project->style_name_ar): ?>
                                        <span class="badge badge-success"><?php echo e($project->style_name_ar); ?></span>
                                    <?php else: ?>
                                        <span class="text-muted">N/A</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">Currency</div>
                                <div class="info-value">
                                    <?php if($project->currency_name_en && $project->currency_abbr): ?>
                                        <span class="badge badge-warning"><?php echo e($project->currency_name_en); ?> (<?php echo e($project->currency_abbr); ?>)</span>
                                    <?php else: ?>
                                        <span class="text-muted">N/A</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">Partner (English)</div>
                                <div class="info-value">
                                    <?php if($project->partner_name_en): ?>
                                        <span class="badge badge-dark"><?php echo e($project->partner_name_en); ?></span>
                                    <?php else: ?>
                                        <span class="text-muted">N/A</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">Partner (Arabic)</div>
                                <div class="info-value">
                                    <?php if($project->partner_name_ar): ?>
                                        <span class="badge badge-dark"><?php echo e($project->partner_name_ar); ?></span>
                                    <?php else: ?>
                                        <span class="text-muted">N/A</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Measurements Tab -->
                        <div class="tab-pane" id="measurements">
                            <h5 class="mb-4 text-primary">Area Measurements</h5>
                            
                            <div class="info-row">
                                <div class="info-label">Square Feet (SQFT)</div>
                                <div class="info-value">
                                    <?php if($project->sqft): ?>
                                        <strong><?php echo e(number_format($project->sqft, 2)); ?></strong> sqft
                                    <?php else: ?>
                                        <span class="text-muted">N/A</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">Square Meters (SQM)</div>
                                <div class="info-value">
                                    <?php if($project->sqm): ?>
                                        <strong><?php echo e(number_format($project->sqm, 2)); ?></strong> m²
                                    <?php else: ?>
                                        <span class="text-muted">N/A</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <?php if($project->sqft && $project->sqm): ?>
                            <div class="alert alert-info mt-3">
                                <i class="fa fa-info-circle"></i> <strong>Conversion:</strong> 1 SQFT = 0.092903 SQM
                            </div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Media Tab -->
                        <div class="tab-pane" id="media">
                            <h5 class="mb-4 text-primary">Media URLs</h5>
                            
                            <div class="info-row">
                                <div class="info-label">Video URL</div>
                                <div class="info-value">
                                    <?php if($project->video_url): ?>
                                        <a href="<?php echo e($project->video_url); ?>" target="_blank" class="btn btn-sm btn-outline-danger">
                                            <i class="fa fa-youtube-play"></i> Watch Video
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted">N/A</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">Virtual Tour URL</div>
                                <div class="info-value">
                                    <?php if($project->tour_url): ?>
                                        <a href="<?php echo e($project->tour_url); ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                            <i class="fa fa-external-link"></i> View Tour
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted">N/A</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Images Tab -->
                        <div class="tab-pane" id="images">
                            <h5 class="mb-4 text-primary">Project Images</h5>
                            
                            <div class="image-grid">
                                <div class="image-grid-item" onclick="openLightbox('<?php echo e(asset('storage' . $project->main_image)); ?>')">
                                    <img src="<?php echo e(asset('storage' . $project->main_image)); ?>" alt="Main Image">
                                    <div class="image-label">Main Image (1080x1080)</div>
                                </div>
                                
                                
                                
                                
                                <?php if($project->site_image): ?>
                                <div class="image-grid-item" onclick="openLightbox('<?php echo e(asset('storage' . $project->site_image)); ?>')">
                                    <img src="<?php echo e(asset('storage' . $project->site_image)); ?>" alt="Site Image">
                                    <div class="image-label">Site Image (1080x1080)</div>
                                </div>
                                <?php endif; ?>
                                
                                <?php if($project->plan_2d_image): ?>
                                <div class="image-grid-item" style="cursor: pointer;" onclick="window.open('<?php echo e(asset('storage' . $project->plan_2d_image)); ?>', '_blank')">
                                    <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px; text-align: center;">
                                        <i class="fa fa-file-pdf-o" style="font-size: 48px; margin-bottom: 15px;"></i>
                                        <div style="font-weight: 600; font-size: 16px;">Project File (PDF)</div>
                                        <div style="font-size: 12px; margin-top: 5px; opacity: 0.9;">Click to view/download</div>
                                    </div>
                                </div>
                                <?php endif; ?>
                                
                                <?php if($project->plan_3d_image): ?>
                                <div class="image-grid-item" onclick="openLightbox('<?php echo e(asset('storage' . $project->plan_3d_image)); ?>')">
                                    <img src="<?php echo e(asset('storage' . $project->plan_3d_image)); ?>" alt="3D Image">
                                    <div class="image-label">3D Image (1080x1080)</div>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <!-- Gallery Tab -->
                        <div class="tab-pane" id="gallery">
                            <?php echo $__env->make('admin::projects.images._index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                        
                        <!-- Descriptions Tab -->
                        <div class="tab-pane" id="descriptions">
                            <h5 class="mb-4 text-primary">Descriptions</h5>
                            
                            <h6 class="text-secondary mt-4 mb-3">English Description</h6>
                            <div class="description-content">
                                <?php if($project->description_english): ?>
                                    <?php echo $project->description_english; ?>

                                <?php else: ?>
                                    <p class="text-muted">No English description available.</p>
                                <?php endif; ?>
                            </div>
                            
                            <hr class="my-4">
                            
                            <h6 class="text-secondary mb-3">Arabic Description</h6>
                            <div class="description-content" dir="rtl">
                                <?php if($project->description_arabic): ?>
                                    <?php echo $project->description_arabic; ?>

                                <?php else: ?>
                                    <p class="text-muted">لا يوجد وصف بالعربية</p>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <!-- SEO Tab -->
                        <div class="tab-pane" id="seo">
                            <h5 class="mb-4 text-primary">SEO Information</h5>
                            
                            <div class="info-row">
                                <div class="info-label">SEO Tags</div>
                                <div class="info-value">
                                    <?php if($project->seo_tags): ?>
                                        <div class="seo-tags">
                                            <?php $__currentLoopData = explode(',', $project->seo_tags); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <span class="seo-tag"><?php echo e(trim($tag)); ?></span>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-muted">No tags</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">SEO Description (English)</div>
                                <div class="info-value"><?php echo e($project->seo_description_english ?: 'N/A'); ?></div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">SEO Description (Arabic)</div>
                                <div class="info-value" dir="rtl"><?php echo e($project->seo_description_arabic ?: 'N/A'); ?></div>
                            </div>
                        </div>
                        
                        <!-- Building Components Tab -->
                        <div class="tab-pane" id="building-components">
                            <?php echo $__env->make('admin::projects.buildingcomponents._index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                        
                        <!-- Floors Tab -->
                        <div class="tab-pane" id="floors">
                            <?php echo $__env->make('admin::projects.floors._list', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                        
                        <!-- Income Components Tab -->
                        <div class="tab-pane" id="income-components">
                            <?php echo $__env->make('admin::projects.incomecomponents._index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                        
                        <!-- Length Components Tab -->
                        <div class="tab-pane" id="length-components">
                            <?php echo $__env->make('admin::projects.lengthcomponents._index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                        
                        <!-- Construction Costs Tab -->
                        <div class="tab-pane" id="construction-costs">
                            <?php echo $__env->make('admin::projects.constructioncosts._index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                        
                        <!-- Specifications Tab -->
                        <div class="tab-pane" id="specifications">
                            <?php echo $__env->make('admin::projects.specifications._index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                        
                        <!-- Timestamps Tab -->
                        <div class="tab-pane" id="timestamps">
                            <h5 class="mb-4 text-primary">Timestamps & User Activity</h5>
                            
                            <?php
                                // Get creator from activity log
                                $creatorLog = \App\Models\ActivityLog::where('model_type', 'App\Models\Project')
                                    ->where('model_id', $project->id)
                                    ->where('action', 'create')
                                    ->first();
                                
                                // Get last updater from activity log
                                $lastUpdateLog = \App\Models\ActivityLog::where('model_type', 'App\Models\Project')
                                    ->where('model_id', $project->id)
                                    ->where('action', 'update')
                                    ->orderBy('created_at', 'desc')
                                    ->first();
                            ?>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="timestamp-card created">
                                        <div class="timestamp-icon">
                                            <i class="fa fa-plus-circle"></i>
                                        </div>
                                        <div class="timestamp-content">
                                            <h6 class="timestamp-title">Created</h6>
                                            <div class="timestamp-date">
                                                <i class="fa fa-calendar"></i> 
                                                <?php echo e(\Carbon\Carbon::parse($project->created_at)->format('F d, Y')); ?>

                                            </div>
                                            <div class="timestamp-time">
                                                <i class="fa fa-clock-o"></i> 
                                                <?php echo e(\Carbon\Carbon::parse($project->created_at)->format('h:i A')); ?>

                                                <small class="text-muted">(<?php echo e(\Carbon\Carbon::parse($project->created_at)->diffForHumans()); ?>)</small>
                                            </div>
                                            <?php if($creatorLog && $creatorLog->user_name): ?>
                                            <div class="timestamp-user">
                                                <i class="fa fa-user"></i> 
                                                <strong><?php echo e($creatorLog->user_name); ?></strong>
                                                <?php if($creatorLog->user_email): ?>
                                                <br><small class="text-muted"><?php echo e($creatorLog->user_email); ?></small>
                                                <?php endif; ?>
                                            </div>
                                            <?php else: ?>
                                            <div class="timestamp-user text-muted">
                                                <i class="fa fa-user"></i> 
                                                <em>User info not available</em>
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="timestamp-card updated">
                                        <div class="timestamp-icon">
                                            <i class="fa fa-edit"></i>
                                        </div>
                                        <div class="timestamp-content">
                                            <h6 class="timestamp-title">Last Updated</h6>
                                            <div class="timestamp-date">
                                                <i class="fa fa-calendar"></i> 
                                                <?php echo e(\Carbon\Carbon::parse($project->updated_at)->format('F d, Y')); ?>

                                            </div>
                                            <div class="timestamp-time">
                                                <i class="fa fa-clock-o"></i> 
                                                <?php echo e(\Carbon\Carbon::parse($project->updated_at)->format('h:i A')); ?>

                                                <small class="text-muted">(<?php echo e(\Carbon\Carbon::parse($project->updated_at)->diffForHumans()); ?>)</small>
                                            </div>
                                            <?php if($lastUpdateLog && $lastUpdateLog->user_name): ?>
                                            <div class="timestamp-user">
                                                <i class="fa fa-user"></i> 
                                                <strong><?php echo e($lastUpdateLog->user_name); ?></strong>
                                                <?php if($lastUpdateLog->user_email): ?>
                                                <br><small class="text-muted"><?php echo e($lastUpdateLog->user_email); ?></small>
                                                <?php endif; ?>
                                            </div>
                                            <?php else: ?>
                                            <div class="timestamp-user text-muted">
                                                <i class="fa fa-user"></i> 
                                                <em>No updates recorded yet</em>
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <?php if($lastUpdateLog && $lastUpdateLog->changed_fields && count($lastUpdateLog->changed_fields) > 0): ?>
                            <div class="mt-4">
                                <h6 class="text-muted mb-3"><i class="fa fa-list"></i> Last Update Changed Fields</h6>
                                <div class="last-update-fields">
                                    <?php $__currentLoopData = $lastUpdateLog->changed_fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span class="changed-field-badge"><?php echo e(str_replace('_', ' ', $field)); ?></span>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Feasibility Studies Tab -->
                        <div class="tab-pane" id="feasibility-studies">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="text-primary mb-0">
                                    <i class="fa fa-chart-line"></i> Feasibility Studies
                                </h5>
                                
                                <!-- Website Visibility Toggle -->
                                <div>
                                    <form action="<?php echo e(route('project.toggle-feasibility-studies', ['id' => $project->id])); ?>" method="POST" style="display:inline;" id="toggleFSForm">
                                        <?php echo csrf_field(); ?>
                                        <?php if($project->show_feasibility_studies == 0): ?>
                                            <button type="button" class="btn btn-sm btn-success" onclick="confirmToggleFS('hide')" title="Feasibility Studies are currently visible on website">
                                                <i class="fa fa-eye"></i> Visible on Website
                                            </button>
                                        <?php else: ?>
                                            <button type="button" class="btn btn-sm btn-warning" onclick="confirmToggleFS('show')" title="Feasibility Studies are currently hidden from website">
                                                <i class="fa fa-eye-slash"></i> Hidden from Website
                                            </button>
                                        <?php endif; ?>
                                    </form>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <a href="<?php echo e(route('feasibility-study.create', ['projectId' => $project->id])); ?>" class="btn btn-success">
                                    <i class="fa fa-plus"></i> Create New Feasibility Study
                                </a>
                                <a href="<?php echo e(route('feasibility-study.index')); ?>" class="btn btn-primary">
                                    <i class="fa fa-list"></i> View All Studies
                                </a>
                            </div>
                            
                            <?php
                                use App\Models\FeasibilityStudy;
                                $feasibilityStudies = FeasibilityStudy::getByProject($project->id);
                            ?>
                            
                            <?php if($feasibilityStudies && $feasibilityStudies->count() > 0): ?>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>ID</th>
                                                <th>Study Name</th>
                                                <th>Type</th>
                                                <th>Status</th>
                                                <th>Created By</th>
                                                <th>Created Date</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $feasibilityStudies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $study): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($study->id); ?></td>
                                                <td><strong><?php echo e($study->study_name); ?></strong></td>
                                                <td>
                                                    <?php if($study->study_type == 'Master'): ?>
                                                        <span class="badge badge-warning"><i class="fa fa-star"></i> Master</span>
                                                    <?php else: ?>
                                                        <span class="badge badge-primary"><i class="fa fa-edit"></i> Custom</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if($study->status == 'Active'): ?>
                                                        <span class="badge badge-success"><i class="fa fa-check"></i> Active</span>
                                                    <?php elseif($study->status == 'Draft'): ?>
                                                        <span class="badge badge-warning"><i class="fa fa-file"></i> Draft</span>
                                                    <?php else: ?>
                                                        <span class="badge badge-secondary"><i class="fa fa-archive"></i> Archived</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?php echo e($study->creator_name ?? 'N/A'); ?></td>
                                                <td><?php echo e(\Carbon\Carbon::parse($study->created_at)->format('Y-m-d')); ?></td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="<?php echo e(route('feasibility-study.show', ['id' => $study->id])); ?>" 
                                                           class="btn btn-sm btn-info" title="View Study">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                        <a href="<?php echo e(route('feasibility-study.edit', ['id' => $study->id])); ?>" 
                                                           class="btn btn-sm btn-warning" title="Edit Study">
                                                            <i class="fa fa-pencil"></i>
                                                        </a>
                                                        <?php if($study->study_type != 'Master'): ?>
                                                        <form action="<?php echo e(route('feasibility-study.delete', ['id' => $study->id])); ?>" method="POST" style="display:inline;" class="delete-fs-form">
                                                            <?php echo csrf_field(); ?>
                                                            <button type="button" class="btn btn-sm btn-danger delete-fs-btn" title="Delete Study" 
                                                                    data-study-id="<?php echo e($study->id); ?>" data-study-name="<?php echo e($study->study_name); ?>">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </form>
                                                        <?php endif; ?>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <div class="alert alert-info">
                                    <i class="fa fa-info-circle"></i> No feasibility studies created for this project yet.
                                    <a href="<?php echo e(route('feasibility-study.create', ['projectId' => $project->id])); ?>">
                                        Create your first study
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Activity Log Tab -->
                        <div class="tab-pane" id="activity-log">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="text-primary mb-0">
                                    <i class="fa fa-history"></i> Activity Log
                                </h5>
                                <a href="<?php echo e(route('admin.activity-logs.index', ['model_name' => 'Project', 'search' => $project->title_english])); ?>" class="btn btn-sm btn-outline-primary">
                                    <i class="fa fa-external-link"></i> View All Logs
                                </a>
                            </div>
                            
                            <?php
                                use App\Models\ActivityLog;
                                $projectLogs = ActivityLog::where('model_type', 'App\Models\Project')
                                    ->where('model_id', $project->id)
                                    ->orderBy('created_at', 'desc')
                                    ->paginate(5, ['*'], 'activity_page');
                            ?>
                            
                            <?php if($projectLogs->count() > 0): ?>
                                <div class="activity-log-list">
                                    <?php $__currentLoopData = $projectLogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $actionInfo = $log->getActionLabel();
                                    ?>
                                    <div class="activity-log-item">
                                        <div class="activity-log-icon <?php echo e($log->action); ?>">
                                            <i class="fa <?php echo e($actionInfo['icon']); ?>"></i>
                                        </div>
                                        <div class="activity-log-content">
                                            <div class="activity-log-header">
                                                <span class="badge badge-<?php echo e($actionInfo['color']); ?>"><?php echo e($actionInfo['label']); ?></span>
                                                <span class="activity-log-time">
                                                    <i class="fa fa-clock-o"></i> <?php echo e($log->created_at->format('M d, Y H:i')); ?>

                                                    <small class="text-muted">(<?php echo e($log->created_at->diffForHumans()); ?>)</small>
                                                </span>
                                            </div>
                                            <div class="activity-log-description">
                                                <?php echo e($log->description); ?>

                                            </div>
                                            <div class="activity-log-meta">
                                                <span><i class="fa fa-user"></i> <?php echo e($log->user_name ?? 'System'); ?></span>
                                                <?php if($log->ip_address): ?>
                                                <span><i class="fa fa-globe"></i> <?php echo e($log->ip_address); ?></span>
                                                <?php endif; ?>
                                            </div>
                                            <?php if($log->changed_fields && count($log->changed_fields) > 0): ?>
                                            <div class="activity-log-changes">
                                                <small class="text-muted">Changed fields:</small>
                                                <?php $__currentLoopData = $log->changed_fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <span class="changed-field-badge"><?php echo e(str_replace('_', ' ', $field)); ?></span>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="activity-log-actions">
                                            <a href="<?php echo e(route('admin.activity-logs.show', $log->id)); ?>" class="btn btn-sm btn-outline-info" title="View Details">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                                
                                <?php if($projectLogs->hasPages()): ?>
                                <div class="activity-log-pagination mt-3">
                                    <?php echo e($projectLogs->appends(['tab' => 'activity-log'])->links()); ?>

                                </div>
                                <?php endif; ?>
                            <?php else: ?>
                                <div class="alert alert-info">
                                    <i class="fa fa-info-circle"></i> No activity logs recorded for this project yet.
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Custom Lightbox for Project Images -->
<div class="custom-lightbox" id="custom-lightbox" onclick="closeLightbox()">
    <span class="custom-lightbox-close" onclick="closeLightbox()">&times;</span>
    <img id="lightbox-img" src="" alt="Preview" onclick="event.stopPropagation()">
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script src="<?php echo e(asset('/js/auto-translate.js')); ?>"></script>
<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?php echo e(asset('/js/image-uploader.min.js')); ?>"></script>

<script>
    // Display success/error messages with SweetAlert2
    <?php if(session('success')): ?>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '<?php echo e(session('success')); ?>',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            toast: true,
            position: 'top-end',
            showClass: {
                popup: 'animate__animated animate__fadeInDown'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOutUp'
            }
        });
    <?php endif; ?>

    <?php if(session('error')): ?>
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: '<?php echo e(session('error')); ?>',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            toast: true,
            position: 'top-end',
            showClass: {
                popup: 'animate__animated animate__fadeInDown'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOutUp'
            }
        });
    <?php endif; ?>

    // Tab switching with persistence
    const projectTabKey = 'project_active_tab_<?php echo e($project->id); ?>';
    
    // Function to switch to a specific tab
    function switchToTab(tabId) {
        // Remove active class from all tabs and panes
        document.querySelectorAll('.tab-item').forEach(t => t.classList.remove('active'));
        document.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active'));
        
        // Find and activate the tab
        const tabItem = document.querySelector(`.tab-item[data-tab="${tabId}"]`);
        const tabPane = document.getElementById(tabId);
        
        if (tabItem && tabPane) {
            tabItem.classList.add('active');
            tabPane.classList.add('active');
            // Save to localStorage
            localStorage.setItem(projectTabKey, tabId);
        }
    }
    
    // Tab click handlers
    document.querySelectorAll('.tab-item').forEach(tab => {
        tab.addEventListener('click', function() {
            const tabId = this.getAttribute('data-tab');
            switchToTab(tabId);
        });
    });
    
    // Restore active tab on page load
    (function() {
        // Check URL parameter first (for pagination)
        const urlParams = new URLSearchParams(window.location.search);
        const tabFromUrl = urlParams.get('tab');
        
        if (tabFromUrl) {
            const tabExists = document.querySelector(`.tab-item[data-tab="${tabFromUrl}"]`);
            if (tabExists) {
                switchToTab(tabFromUrl);
                return;
            }
        }
        
        // Otherwise check localStorage
        const savedTab = localStorage.getItem(projectTabKey);
        if (savedTab) {
            const tabExists = document.querySelector(`.tab-item[data-tab="${savedTab}"]`);
            if (tabExists) {
                switchToTab(savedTab);
            }
        }
    })();
    
    // Custom Lightbox functions
    function openLightbox(imgSrc) {
        document.getElementById('lightbox-img').src = imgSrc;
        document.getElementById('custom-lightbox').classList.add('active');
    }
    
    function closeLightbox() {
        document.getElementById('custom-lightbox').classList.remove('active');
    }
    
    // ===================================
    // Action Button Confirmations with SweetAlert2
    // ===================================
    
    // Confirm Publish Toggle
    function confirmPublishToggle(action) {
        const isPublishing = action === 'publish';
        
        Swal.fire({
            title: isPublishing ? 'Publish Project?' : 'Unpublish Project?',
            text: isPublishing 
                ? 'This project will be visible to the public.' 
                : 'This project will be hidden from the public.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: isPublishing ? '#28a745' : '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: isPublishing ? '<i class="fa fa-check-circle"></i> Yes, Publish' : '<i class="fa fa-times-circle"></i> Yes, Unpublish',
            cancelButtonText: '<i class="fa fa-times"></i> Cancel',
            reverseButtons: true,
            focusCancel: true,
            showClass: {
                popup: 'animate__animated animate__zoomIn animate__faster'
            },
            hideClass: {
                popup: 'animate__animated animate__zoomOut animate__faster'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                Swal.fire({
                    title: 'Processing...',
                    text: 'Updating publish status',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                // Submit the form
                document.getElementById('publishForm').submit();
            }
        });
    }
    
    // Confirm Home Toggle
    function confirmHomeToggle(action) {
        const isShowing = action === 'show';
        
        Swal.fire({
            title: isShowing ? 'Show on Home?' : 'Hide from Home?',
            text: isShowing 
                ? 'This project will be displayed on the home page.' 
                : 'This project will be removed from the home page.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: isShowing ? '#17a2b8' : '#ffc107',
            cancelButtonColor: '#6c757d',
            confirmButtonText: isShowing ? '<i class="fa fa-eye"></i> Yes, Show' : '<i class="fa fa-eye-slash"></i> Yes, Hide',
            cancelButtonText: '<i class="fa fa-times"></i> Cancel',
            reverseButtons: true,
            focusCancel: true,
            showClass: {
                popup: 'animate__animated animate__zoomIn animate__faster'
            },
            hideClass: {
                popup: 'animate__animated animate__zoomOut animate__faster'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                Swal.fire({
                    title: 'Processing...',
                    text: 'Updating home visibility status',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                // Submit the form
                document.getElementById('homeForm').submit();
            }
        });
    }
    
    // Building Components JavaScript
    const projectId = <?php echo e($project->id); ?>;

    // Open Add Component Modal
    function openAddComponentModal() {
        // Load available components
        $.ajax({
            url: `/admin/project/${projectId}/buildingcomponents/available`,
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    let options = '<option value="">Select Building Component</option>';
                    if (response.components.length > 0) {
                        response.components.forEach(function(component) {
                            options += `<option value="${component.id}">${component.name_english} - ${component.name_arabic}</option>`;
                        });
                    } else {
                        options = '<option value="">No components available</option>';
                    }
                    $('#building_component_id').html(options);
                    $('#addComponentModal').modal('show');
                }
            },
            error: function() {
                showComponentAlert('error', 'Failed to load components');
            }
        });
    }

    // Add Component Form Submit
    $(document).ready(function() {
        $('#addComponentForm').on('submit', function(e) {
            e.preventDefault();
            
            $.ajax({
                url: `/admin/project/${projectId}/buildingcomponents/store`,
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    if (response.success) {
                        $('#addComponentModal').modal('hide');
                        $('#addComponentForm')[0].reset();
                        refreshComponentsList();
                        showComponentAlert('success', response.message);
                    } else {
                        showComponentAlert('error', response.message);
                    }
                },
                error: function(xhr) {
                    const message = xhr.responseJSON?.message || 'Failed to add component';
                    showComponentAlert('error', message);
                }
            });
        });

        // Edit Component Form Submit
        $('#editComponentForm').on('submit', function(e) {
            e.preventDefault();
            
            const componentId = $('#edit_component_id').val();
            
            $.ajax({
                url: `/admin/project/${projectId}/buildingcomponents/update/${componentId}`,
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    if (response.success) {
                        $('#editComponentModal').modal('hide');
                        refreshComponentsList();
                        showComponentAlert('success', response.message);
                    } else {
                        showComponentAlert('error', response.message);
                    }
                },
                error: function(xhr) {
                    const message = xhr.responseJSON?.message || 'Failed to update component';
                    showComponentAlert('error', message);
                }
            });
        });
    });

    // Open Edit Modal
    function openEditModal(id, name, cost) {
        $('#edit_component_id').val(id);
        $('#edit_component_name').val(name);
        $('#edit_construction_cost').val(cost);
        $('#editComponentModal').modal('show');
    }

    // Open Delete Modal
    function openDeleteModal(id, name) {
        $('#delete_component_id').val(id);
        $('#delete_component_name').text(name);
        $('#deleteComponentModal').modal('show');
    }

    // Confirm Delete
    function confirmDelete() {
        const componentId = $('#delete_component_id').val();
        
        $.ajax({
            url: `/admin/project/${projectId}/buildingcomponents/delete/${componentId}`,
            method: 'POST',
            data: {
                _token: '<?php echo e(csrf_token()); ?>'
            },
            success: function(response) {
                if (response.success) {
                    $('#deleteComponentModal').modal('hide');
                    refreshComponentsList();
                    showComponentAlert('success', response.message);
                } else {
                    showComponentAlert('error', response.message);
                }
            },
            error: function(xhr) {
                const message = xhr.responseJSON?.message || 'Failed to delete component';
                showComponentAlert('error', message);
            }
        });
    }

    // Restore Component
    function restoreComponent(id) {
        if (confirm('Are you sure you want to restore this component?')) {
            $.ajax({
                url: `/admin/project/${projectId}/buildingcomponents/restore/${id}`,
                method: 'POST',
                data: {
                    _token: '<?php echo e(csrf_token()); ?>'
                },
                success: function(response) {
                    if (response.success) {
                        refreshComponentsList();
                        showComponentAlert('success', response.message);
                    } else {
                        showComponentAlert('error', response.message);
                    }
                },
                error: function(xhr) {
                    const message = xhr.responseJSON?.message || 'Failed to restore component';
                    showComponentAlert('error', message);
                }
            });
        }
    }

    // Refresh Components List
    function refreshComponentsList() {
        $('#componentsListContainer').load(location.href + ' #componentsListContainer > *');
    }

    // Show Alert for Building Components
    function showComponentAlert(type, message) {
        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
        
        const alertHtml = `
            <div class="alert ${alertClass} alert-dismissible fade show shadow-sm" role="alert" style="border-left: 4px solid ${type === 'success' ? '#28a745' : '#dc3545'}; font-size: 16px; padding: 15px 20px;">
                <i class="fa ${icon}" style="font-size: 20px;"></i> <strong>${type === 'success' ? 'Success!' : 'Error!'}</strong> ${message}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
        `;
        
        $('.building-components-section').prepend(alertHtml);
        
        // Auto dismiss after 5 seconds
        setTimeout(function() {
            $('.building-components-section .alert').fadeOut('slow', function() {
                $(this).remove();
            });
        }, 5000);
    }
    
    // Income Components JavaScript
    // Open Add Income Component Modal
    function openAddIncomeComponentModal() {
        $.ajax({
            url: `/admin/project/${projectId}/incomecomponents/available`,
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    let options = '<option value="">Select Income Component</option>';
                    if (response.components.length > 0) {
                        response.components.forEach(function(component) {
                            options += `<option value="${component.id}">${component.name_english} - ${component.name_arabic}</option>`;
                        });
                    } else {
                        options = '<option value="">No components available</option>';
                    }
                    $('#income_component_id').html(options);
                    $('#addIncomeComponentModal').modal('show');
                }
            },
            error: function() {
                showIncomeComponentAlert('error', 'Failed to load components');
            }
        });
    }

    // Add Income Component Form Submit
    $('#addIncomeComponentForm').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: `/admin/project/${projectId}/incomecomponents/store`,
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    $('#addIncomeComponentModal').modal('hide');
                    $('#addIncomeComponentForm')[0].reset();
                    location.reload();
                }
            },
            error: function(xhr) {
                showIncomeComponentAlert('error', xhr.responseJSON?.message || 'Failed to add component');
            }
        });
    });

    // Open Edit Income Component Modal
    function openEditIncomeComponentModal(id, name, units, rent) {
        $('#edit_component_id').val(id);
        $('#edit_component_name').val(name);
        $('#edit_number_of_units').val(units);
        $('#edit_rent_per_year').val(rent);
        $('#editIncomeComponentModal').modal('show');
    }

    // Edit Income Component Form Submit
    $('#editIncomeComponentForm').on('submit', function(e) {
        e.preventDefault();
        const componentId = $('#edit_component_id').val();
        
        $.ajax({
            url: `/admin/project/${projectId}/incomecomponents/update/${componentId}`,
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    $('#editIncomeComponentModal').modal('hide');
                    location.reload();
                }
            },
            error: function(xhr) {
                showIncomeComponentAlert('error', xhr.responseJSON?.message || 'Failed to update component');
            }
        });
    });

    // Open Delete Income Component Modal
    function openDeleteIncomeComponentModal(id, name) {
        $('#delete_income_component_id').val(id);
        $('#delete_income_component_name').text(name);
        $('#deleteIncomeComponentModal').modal('show');
    }

    // Confirm Delete Income Component
    function confirmDeleteIncomeComponent() {
        const componentId = $('#delete_income_component_id').val();
        
        $.ajax({
            url: `/admin/project/${projectId}/incomecomponents/delete/${componentId}`,
            method: 'POST',
            data: { _token: '<?php echo e(csrf_token()); ?>' },
            success: function(response) {
                if (response.success) {
                    $('#deleteIncomeComponentModal').modal('hide');
                    location.reload();
                }
            },
            error: function() {
                showIncomeComponentAlert('error', 'Failed to delete component');
            }
        });
    }

    // Restore Income Component
    function restoreIncomeComponent(id) {
        if (confirm('Are you sure you want to restore this income component?')) {
            $.ajax({
                url: `/admin/project/${projectId}/incomecomponents/restore/${id}`,
                method: 'POST',
                data: { _token: '<?php echo e(csrf_token()); ?>' },
                success: function(response) {
                    if (response.success) {
                        location.reload();
                    }
                },
                error: function() {
                    showIncomeComponentAlert('error', 'Failed to restore component');
                }
            });
        }
    }

    // Show Income Component Alert
    function showIncomeComponentAlert(type, message) {
        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
        
        const alertHtml = `
            <div class="alert ${alertClass} alert-dismissible fade show shadow-sm" role="alert" style="border-left: 4px solid ${type === 'success' ? '#28a745' : '#dc3545'}; font-size: 16px; padding: 15px 20px;">
                <i class="fa ${icon}" style="font-size: 20px;"></i> <strong>${type === 'success' ? 'Success!' : 'Error!'}</strong> ${message}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
        `;
        
        $('.income-components-section').prepend(alertHtml);
        
        setTimeout(function() {
            $('.income-components-section .alert').fadeOut('slow', function() {
                $(this).remove();
            });
        }, 5000);
    }

    // ===================================
    // Feasibility Studies Actions
    // ===================================
    
    // Toggle Feasibility Studies Visibility on Website
    function confirmToggleFS(action) {
        const isShowing = action === 'show';
        
        Swal.fire({
            title: isShowing ? 'Show Feasibility Studies?' : 'Hide Feasibility Studies?',
            html: isShowing 
                ? 'All feasibility studies for this project will be <strong>visible on the website</strong>.' 
                : 'All feasibility studies for this project will be <strong>hidden from the website</strong>.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: isShowing ? '#28a745' : '#ffc107',
            cancelButtonColor: '#6c757d',
            confirmButtonText: isShowing ? '<i class="fa fa-eye"></i> Yes, Show on Website' : '<i class="fa fa-eye-slash"></i> Yes, Hide from Website',
            cancelButtonText: '<i class="fa fa-times"></i> Cancel',
            reverseButtons: true,
            focusCancel: true,
            showClass: {
                popup: 'animate__animated animate__zoomIn animate__faster'
            },
            hideClass: {
                popup: 'animate__animated animate__zoomOut animate__faster'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                Swal.fire({
                    title: 'Processing...',
                    text: 'Updating feasibility studies visibility',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                // Submit the form
                document.getElementById('toggleFSForm').submit();
            }
        });
    }
    
    // Handle Delete Feasibility Study Button Click
    $(document).on('click', '.delete-fs-btn', function(e) {
        e.preventDefault();
        const studyName = $(this).data('study-name');
        const form = $(this).closest('form');
        
        Swal.fire({
            title: 'Delete Feasibility Study?',
            html: `Are you sure you want to delete <strong>"${studyName}"</strong>?<br><span style="color: #dc3545; font-size: 14px;">This action will delete all associated data and cannot be undone!</span>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="fa fa-trash"></i> Yes, Delete It',
            cancelButtonText: '<i class="fa fa-times"></i> Cancel',
            reverseButtons: true,
            focusCancel: true,
            showClass: {
                popup: 'animate__animated animate__zoomIn animate__faster'
            },
            hideClass: {
                popup: 'animate__animated animate__zoomOut animate__faster'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                Swal.fire({
                    title: 'Deleting...',
                    text: 'Please wait while we delete the study and all its data',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                // Submit the form
                form.submit();
            }
        });
    });
    
    // ===================================
    // Specifications JavaScript
    // ===================================
    
    // Open Add Specification Modal
    function openAddSpecificationModal() {
        $.ajax({
            url: `/admin/project/${projectId}/specifications/available`,
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    let options = '<option value="">Select Specification</option>';
                    if (response.components.length > 0) {
                        response.components.forEach(function(spec) {
                            options += `<option value="${spec.id}">${spec.title_english} - ${spec.title_arabic}</option>`;
                        });
                    } else {
                        options = '<option value="">No specifications available</option>';
                    }
                    $('#specification_id').html(options);
                    $('#addSpecificationModal').modal('show');
                }
            },
            error: function() {
                showSpecificationAlert('error', 'Failed to load specifications');
            }
        });
    }

    // Add Specification Form Submit
    $('#addSpecificationForm').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: `/admin/project/${projectId}/specifications/store`,
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    $('#addSpecificationModal').modal('hide');
                    $('#addSpecificationForm')[0].reset();
                    location.reload();
                }
            },
            error: function(xhr) {
                showSpecificationAlert('error', xhr.responseJSON?.message || 'Failed to add specification');
            }
        });
    });

    // Open Edit Specification Modal
    function openEditSpecificationModal(id, name, valueEn, valueAr) {
        $('#edit_specification_id').val(id);
        $('#edit_specification_name').val(name);
        $('#edit_value_english').val(valueEn);
        $('#edit_value_arabic').val(valueAr);
        $('#editSpecificationModal').modal('show');
    }

    // Edit Specification Form Submit
    $('#editSpecificationForm').on('submit', function(e) {
        e.preventDefault();
        const specId = $('#edit_specification_id').val();
        
        $.ajax({
            url: `/admin/project/${projectId}/specifications/update/${specId}`,
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    $('#editSpecificationModal').modal('hide');
                    location.reload();
                }
            },
            error: function(xhr) {
                showSpecificationAlert('error', xhr.responseJSON?.message || 'Failed to update specification');
            }
        });
    });

    // Open Delete Specification Modal
    function openDeleteSpecificationModal(id, name) {
        $('#delete_specification_id').val(id);
        $('#delete_specification_name').text(name);
        $('#deleteSpecificationModal').modal('show');
    }

    // Confirm Delete Specification
    function confirmDeleteSpecification() {
        const specId = $('#delete_specification_id').val();
        
        $.ajax({
            url: `/admin/project/${projectId}/specifications/delete/${specId}`,
            method: 'POST',
            data: { _token: '<?php echo e(csrf_token()); ?>' },
            success: function(response) {
                if (response.success) {
                    $('#deleteSpecificationModal').modal('hide');
                    location.reload();
                }
            },
            error: function() {
                showSpecificationAlert('error', 'Failed to delete specification');
            }
        });
    }

    // Restore Specification
    function restoreSpecification(id) {
        if (confirm('Are you sure you want to restore this specification?')) {
            $.ajax({
                url: `/admin/project/${projectId}/specifications/restore/${id}`,
                method: 'POST',
                data: { _token: '<?php echo e(csrf_token()); ?>' },
                success: function(response) {
                    if (response.success) {
                        location.reload();
                    }
                },
                error: function() {
                    showSpecificationAlert('error', 'Failed to restore specification');
                }
            });
        }
    }
    
    // Open Force Delete Specification Modal
    function openForceDeleteSpecificationModal(id, name) {
        $('#force_delete_specification_id').val(id);
        $('#force_delete_specification_name').text(name);
        $('#forceDeleteSpecificationModal').modal('show');
    }
    
    // Confirm Force Delete Specification
    function confirmForceDeleteSpecification() {
        const specId = $('#force_delete_specification_id').val();
        
        $.ajax({
            url: `/admin/project/${projectId}/specifications/force-delete/${specId}`,
            method: 'POST',
            data: { _token: '<?php echo e(csrf_token()); ?>' },
            success: function(response) {
                if (response.success) {
                    $('#forceDeleteSpecificationModal').modal('hide');
                    showSpecificationAlert('success', 'Specification permanently deleted!');
                    location.reload();
                }
            },
            error: function() {
                showSpecificationAlert('error', 'Failed to permanently delete specification');
            }
        });
    }

    // Show Specification Alert
    function showSpecificationAlert(type, message) {
        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
        
        const alertHtml = `
            <div class="alert ${alertClass} alert-dismissible fade show shadow-sm" role="alert" style="border-left: 4px solid ${type === 'success' ? '#28a745' : '#dc3545'}; font-size: 16px; padding: 15px 20px;">
                <i class="fa ${icon}" style="font-size: 20px;"></i> <strong>${type === 'success' ? 'Success!' : 'Error!'}</strong> ${message}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        `;
        
        $('.specifications-section').prepend(alertHtml);
        
        // Auto dismiss after 5 seconds
        setTimeout(function() {
            $('.specifications-section .alert').fadeOut('slow', function() {
                $(this).remove();
            });
        }, 5000);
    }

    // ===================================
    // Bulk Add Specifications JavaScript
    // ===================================
    
    let availableSpecifications = [];
    let bulkRowCounter = 0;
    
    // Open Bulk Add Specification Modal
    function openBulkAddSpecificationModal() {
        // Reset
        bulkRowCounter = 0;
        $('#bulkSpecificationsContainer').empty();
        
        // Load available specifications first
        $.ajax({
            url: `/admin/project/${projectId}/specifications/available`,
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    availableSpecifications = response.components;
                    
                    if (availableSpecifications.length === 0) {
                        showSpecificationAlert('error', 'No specifications available to add. All specifications have already been added to this project.');
                        return;
                    }
                    
                    // Add initial rows (3 rows or available count, whichever is smaller)
                    const initialRows = Math.min(3, availableSpecifications.length);
                    for (let i = 0; i < initialRows; i++) {
                        addBulkSpecificationRow();
                    }
                    
                    $('#bulkAddSpecificationModal').modal('show');
                }
            },
            error: function() {
                showSpecificationAlert('error', 'Failed to load specifications');
            }
        });
    }
    
    // Add a new row for bulk specification
    function addBulkSpecificationRow() {
        bulkRowCounter++;
        
        // Build options HTML
        let optionsHtml = '<option value="">Select Specification</option>';
        availableSpecifications.forEach(function(spec) {
            optionsHtml += `<option value="${spec.id}" data-icon="${spec.icon || ''}">${spec.title_english} / ${spec.title_arabic}</option>`;
        });
        
        const rowHtml = `
            <div class="bulk-spec-row card mb-2" data-row="${bulkRowCounter}">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group mb-2">
                                <label class="small font-weight-bold">Specification <span class="text-danger">*</span></label>
                                <select class="form-control form-control-sm bulk-spec-select" name="spec_${bulkRowCounter}" required onchange="updateBulkRowCount()">
                                    ${optionsHtml}
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-2">
                                <label class="small font-weight-bold">Value (English) <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm bulk-value-en" name="value_en_${bulkRowCounter}" placeholder="English value" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-2">
                                <label class="small font-weight-bold">Value (Arabic) <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm bulk-value-ar" name="value_ar_${bulkRowCounter}" placeholder="القيمة بالعربية" dir="rtl" required>
                            </div>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="button" class="btn btn-outline-danger btn-sm mb-2 w-100" onclick="removeBulkSpecificationRow(${bulkRowCounter})">
                                <i class="fa fa-trash"></i> Remove
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        $('#bulkSpecificationsContainer').append(rowHtml);
        updateBulkRowCount();
    }
    
    // Remove a bulk specification row
    function removeBulkSpecificationRow(rowNum) {
        $(`.bulk-spec-row[data-row="${rowNum}"]`).fadeOut(200, function() {
            $(this).remove();
            updateBulkRowCount();
        });
    }
    
    // Update the row count display
    function updateBulkRowCount() {
        const validRows = $('.bulk-spec-row').filter(function() {
            return $(this).find('.bulk-spec-select').val() !== '';
        }).length;
        const totalRows = $('.bulk-spec-row').length;
        
        $('#bulkRowCount').text(`${validRows} of ${totalRows} specifications ready`);
        $('#bulkAddSubmitBtn').prop('disabled', validRows === 0);
    }
    
    // Bulk Add Specification Form Submit
    $('#bulkAddSpecificationForm').on('submit', function(e) {
        e.preventDefault();
        
        // Collect all specifications data
        const specifications = [];
        let hasError = false;
        
        $('.bulk-spec-row').each(function() {
            const specId = $(this).find('.bulk-spec-select').val();
            const valueEn = $(this).find('.bulk-value-en').val().trim();
            const valueAr = $(this).find('.bulk-value-ar').val().trim();
            
            if (specId) {
                if (!valueEn || !valueAr) {
                    hasError = true;
                    $(this).find('.card-body').addClass('border-danger');
                    return;
                }
                
                specifications.push({
                    specification_id: specId,
                    value_english: valueEn,
                    value_arabic: valueAr
                });
            }
        });
        
        if (hasError) {
            showSpecificationAlert('error', 'Please fill in all required fields for selected specifications');
            return;
        }
        
        if (specifications.length === 0) {
            showSpecificationAlert('error', 'Please add at least one specification');
            return;
        }
        
        // Check for duplicate specifications in the form
        const specIds = specifications.map(s => s.specification_id);
        const uniqueSpecIds = [...new Set(specIds)];
        if (specIds.length !== uniqueSpecIds.length) {
            showSpecificationAlert('error', 'Duplicate specifications detected. Please select unique specifications.');
            return;
        }
        
        // Disable submit button
        $('#bulkAddSubmitBtn').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Adding...');
        
        $.ajax({
            url: `/admin/project/${projectId}/specifications/bulk-store`,
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({
                _token: '<?php echo e(csrf_token()); ?>',
                specifications: specifications
            }),
            success: function(response) {
                if (response.success) {
                    $('#bulkAddSpecificationModal').modal('hide');
                    showSpecificationAlert('success', response.message);
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                } else {
                    showSpecificationAlert('error', response.message);
                    $('#bulkAddSubmitBtn').prop('disabled', false).html('<i class="fa fa-save"></i> Add All Specifications');
                }
            },
            error: function(xhr) {
                showSpecificationAlert('error', xhr.responseJSON?.message || 'Failed to add specifications');
                $('#bulkAddSubmitBtn').prop('disabled', false).html('<i class="fa fa-save"></i> Add All Specifications');
            }
        });
    });

    // ===================================
    // Length Components JavaScript
    // ===================================
    
    // Open Add Length Component Modal
    function openAddLengthComponentModal() {
        $('#addLengthComponentModal').modal('show');
        loadAvailableBuildingComponents();
    }
    
    // Load Available Building Components (only is_length = true)
    function loadAvailableBuildingComponents() {
        $.ajax({
            url: `/admin/project/${projectId}/lengthcomponents/available-building-components`,
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    const select = $('#building_component_id_add');
                    select.empty();
                    
                    if (response.components.length > 0) {
                        select.append('<option value="">Select Building Component</option>');
                        response.components.forEach(function(component) {
                            select.append(`<option value="${component.id}">${component.name_english}</option>`);
                        });
                    } else {
                        select.append('<option value="">No Length Building Components Available</option>');
                    }
                }
            },
            error: function() {
                showLengthComponentAlert('error', 'Failed to load building components');
            }
        });
    }
    
    // When building component changes, load length components
    $(document).on('change', '#building_component_id_add', function() {
        const buildingComponentId = $(this).val();
        const lengthSelect = $('#length_component_id_add');
        
        if (buildingComponentId) {
            $.ajax({
                url: `/admin/project/${projectId}/lengthcomponents/available-length-components`,
                method: 'GET',
                data: { building_component_id: buildingComponentId },
                success: function(response) {
                    if (response.success) {
                        lengthSelect.empty();
                        
                        if (response.components.length > 0) {
                            lengthSelect.append('<option value="">Select Length Component</option>');
                            response.components.forEach(function(component) {
                                lengthSelect.append(`<option value="${component.id}">${component.name_english}</option>`);
                            });
                            lengthSelect.prop('disabled', false);
                        } else {
                            lengthSelect.append('<option value="">No Length Components Available</option>');
                            lengthSelect.prop('disabled', true);
                        }
                    }
                },
                error: function() {
                    showLengthComponentAlert('error', 'Failed to load length components');
                }
            });
        } else {
            lengthSelect.empty();
            lengthSelect.append('<option value="">Select Building Component First</option>');
            lengthSelect.prop('disabled', true);
        }
    });
    
    // Add Length Component Form Submit
    $(document).on('submit', '#addLengthComponentForm', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: `/admin/project/${projectId}/lengthcomponents/store`,
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    $('#addLengthComponentModal').modal('hide');
                    $('#addLengthComponentForm')[0].reset();
                    location.reload();
                }
            },
            error: function(xhr) {
                showLengthComponentAlert('error', xhr.responseJSON?.message || 'Failed to add length component');
            }
        });
    });
    
    // Open Edit Length Component Modal
    function openEditLengthModal(id, name, unitCost) {
        $('#edit_length_component_id').val(id);
        $('#edit_length_component_name').val(name);
        $('#edit_length_unit_cost').val(unitCost);
        $('#editLengthComponentModal').modal('show');
    }
    
    // Edit Length Component Form Submit
    $(document).on('submit', '#editLengthComponentForm', function(e) {
        e.preventDefault();
        const componentId = $('#edit_length_component_id').val();
        
        $.ajax({
            url: `/admin/project/${projectId}/lengthcomponents/update/${componentId}`,
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    $('#editLengthComponentModal').modal('hide');
                    location.reload();
                }
            },
            error: function(xhr) {
                showLengthComponentAlert('error', xhr.responseJSON?.message || 'Failed to update length component');
            }
        });
    });
    
    // Open Delete Length Component Modal
    function openDeleteLengthModal(id, name) {
        $('#delete_length_component_id').val(id);
        $('#delete_length_component_name').text(name);
        $('#deleteLengthComponentModal').modal('show');
    }
    
    // Confirm Delete Length Component
    function confirmDeleteLengthComponent() {
        const componentId = $('#delete_length_component_id').val();
        
        $.ajax({
            url: `/admin/project/${projectId}/lengthcomponents/delete/${componentId}`,
            method: 'POST',
            data: { _token: '<?php echo e(csrf_token()); ?>' },
            success: function(response) {
                $('#deleteLengthComponentModal').modal('hide');
                if (response.success) {
                    location.reload();
                }
            },
            error: function() {
                showLengthComponentAlert('error', 'Failed to delete length component');
            }
        });
    }
    
    // Restore Length Component
    function restoreLengthComponent(id) {
        if (confirm('Are you sure you want to restore this length component?')) {
            $.ajax({
                url: `/admin/project/${projectId}/lengthcomponents/restore/${id}`,
                method: 'POST',
                data: { _token: '<?php echo e(csrf_token()); ?>' },
                success: function(response) {
                    if (response.success) {
                        location.reload();
                    }
                },
                error: function() {
                    showLengthComponentAlert('error', 'Failed to restore length component');
                }
            });
        }
    }
    
    // Show Length Component Alert
    function showLengthComponentAlert(type, message) {
        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
        
        const alertHtml = `
            <div class="alert ${alertClass} alert-dismissible fade show shadow-sm" role="alert" style="border-left: 4px solid ${type === 'success' ? '#28a745' : '#dc3545'}; font-size: 16px; padding: 15px 20px;">
                <i class="fa ${icon}" style="font-size: 20px;"></i> <strong>${type === 'success' ? 'Success!' : 'Error!'}</strong> ${message}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
        `;
        
        $('.length-components-section').prepend(alertHtml);
        
        setTimeout(function() {
            $('.length-components-section .alert').fadeOut('slow', function() {
                $(this).remove();
            });
        }, 5000);
    }

    // ===================================
    // Construction Costs JavaScript
    // ===================================
    
    // Open Add Construction Cost Modal
    function openAddConstructionCostModal() {
        $('#addConstructionCostModal').modal('show');
        loadAvailableFeasibilityComponents();
        loadAvailableSubstationRooms('add');
        loadAvailablePumpsRooms('add');
    }
    
    // Load Available Feasibility Study Components
    function loadAvailableFeasibilityComponents() {
        $.ajax({
            url: `/admin/project/${projectId}/constructioncosts/available-feasibility-components`,
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    const select = $('#feasibility_study_component_id_add');
                    select.empty();
                    
                    if (response.components.length > 0) {
                        select.append('<option value="">Select Feasibility Study Component</option>');
                        response.components.forEach(function(component) {
                            select.append(`<option value="${component.id}">${component.header_english} - ${component.title_english} (${component.target})</option>`);
                        });
                    } else {
                        select.append('<option value="">No Components Available</option>');
                    }
                }
            },
            error: function() {
                showConstructionCostAlert('error', 'Failed to load feasibility components');
            }
        });
    }
    
    // Load Available Substation Rooms
    function loadAvailableSubstationRooms(mode) {
        $.ajax({
            url: `/admin/project/${projectId}/constructioncosts/available-substation-rooms`,
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    const select = mode === 'add' ? $('#substation_room_id_add') : $('#substation_room_id_edit');
                    select.empty();
                    select.append('<option value="">None</option>');
                    
                    response.rooms.forEach(function(room) {
                        select.append(`<option value="${room.id}">${room.name_english} - ${room.price}</option>`);
                    });
                }
            },
            error: function() {
                showConstructionCostAlert('error', 'Failed to load substation rooms');
            }
        });
    }
    
    // Load Available Pumps Rooms
    function loadAvailablePumpsRooms(mode) {
        $.ajax({
            url: `/admin/project/${projectId}/constructioncosts/available-pumps-rooms`,
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    const select = mode === 'add' ? $('#pumps_room_id_add') : $('#pumps_room_id_edit');
                    select.empty();
                    select.append('<option value="">None</option>');
                    
                    response.rooms.forEach(function(room) {
                        select.append(`<option value="${room.id}">${room.name_english} - ${room.price}</option>`);
                    });
                }
            },
            error: function() {
                showConstructionCostAlert('error', 'Failed to load pumps rooms');
            }
        });
    }
    
    // Add Construction Cost Form Submit
    $(document).on('submit', '#addConstructionCostForm', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: `/admin/project/${projectId}/constructioncosts/store`,
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    $('#addConstructionCostModal').modal('hide');
                    $('#addConstructionCostForm')[0].reset();
                    location.reload();
                }
            },
            error: function(xhr) {
                showConstructionCostAlert('error', xhr.responseJSON?.message || 'Failed to add construction cost');
            }
        });
    });
    
    // Open Edit Construction Cost Modal
    function openEditConstructionCostModal(id, substationRoomId, pumpsRoomId) {
        $('#edit_construction_cost_id').val(id);
        loadAvailableSubstationRooms('edit');
        loadAvailablePumpsRooms('edit');
        
        // Set selected values after a short delay to allow options to load
        setTimeout(function() {
            if (substationRoomId) {
                $('#substation_room_id_edit').val(substationRoomId);
            }
            if (pumpsRoomId) {
                $('#pumps_room_id_edit').val(pumpsRoomId);
            }
        }, 500);
        
        $('#editConstructionCostModal').modal('show');
    }
    
    // Edit Construction Cost Form Submit
    $(document).on('submit', '#editConstructionCostForm', function(e) {
        e.preventDefault();
        const costId = $('#edit_construction_cost_id').val();
        
        $.ajax({
            url: `/admin/project/${projectId}/constructioncosts/update/${costId}`,
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    $('#editConstructionCostModal').modal('hide');
                    location.reload();
                }
            },
            error: function(xhr) {
                showConstructionCostAlert('error', xhr.responseJSON?.message || 'Failed to update construction cost');
            }
        });
    });
    
    // Open Delete Construction Cost Modal
    function openDeleteConstructionCostModal(id, name) {
        $('#delete_construction_cost_id').val(id);
        $('#delete_construction_cost_name').text(name);
        $('#deleteConstructionCostModal').modal('show');
    }
    
    // Confirm Delete Construction Cost
    function confirmDeleteConstructionCost() {
        const costId = $('#delete_construction_cost_id').val();
        
        $.ajax({
            url: `/admin/project/${projectId}/constructioncosts/delete/${costId}`,
            method: 'POST',
            data: { _token: '<?php echo e(csrf_token()); ?>' },
            success: function(response) {
                $('#deleteConstructionCostModal').modal('hide');
                if (response.success) {
                    location.reload();
                }
            },
            error: function() {
                showConstructionCostAlert('error', 'Failed to delete construction cost');
            }
        });
    }
    
    // Restore Construction Cost
    function restoreConstructionCost(id) {
        if (confirm('Are you sure you want to restore this construction cost?')) {
            $.ajax({
                url: `/admin/project/${projectId}/constructioncosts/restore/${id}`,
                method: 'POST',
                data: { _token: '<?php echo e(csrf_token()); ?>' },
                success: function(response) {
                    if (response.success) {
                        location.reload();
                    }
                },
                error: function() {
                    showConstructionCostAlert('error', 'Failed to restore construction cost');
                }
            });
        }
    }
    
    // Show Construction Cost Alert
    function showConstructionCostAlert(type, message) {
        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
        
        const alertHtml = `
            <div class="alert ${alertClass} alert-dismissible fade show shadow-sm" role="alert" style="border-left: 4px solid ${type === 'success' ? '#28a745' : '#dc3545'}; font-size: 16px; padding: 15px 20px;">
                <i class="fa ${icon}" style="font-size: 20px;"></i> <strong>${type === 'success' ? 'Success!' : 'Error!'}</strong> ${message}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
        `;
        
        $('.construction-costs-section').prepend(alertHtml);
        
        setTimeout(function() {
            $('.construction-costs-section .alert').fadeOut('slow', function() {
                $(this).remove();
            });
        }, 5000);
    }
    
    // Project Gallery JavaScript
    let projectImages = [];
    
    // Fetch existing gallery images
    fetch('/admin/project-image/galleries/<?php echo e($project->id); ?>')
        .then(res => res.json())
        .then(data => {
            projectImages = data;
            
            // Initialize image uploader
            $('.images').imageUploader({
                preloaded: projectImages,
                imagesInputName: 'images',
                preloadedInputName: 'preloaded',
                maxSize: 5 * 1024 * 1024, // 5MB
                maxFiles: 30,
                extensions: ['.jpg', '.jpeg', '.png', '.gif', '.svg', '.webp'],
                mimes: ['image/jpeg', 'image/png', 'image/gif', 'image/svg+xml', 'image/webp']
            });
            
            // Update gallery count
            updateProjectGalleryCount(projectImages.length);
            
            // Build lightbox preview gallery (same order as uploader)
            buildGalleryPreview(projectImages);
        })
        .catch(error => {
            console.error('Error loading gallery:', error);
            
            // Initialize empty uploader
            $('.images').imageUploader({
                imagesInputName: 'images',
                preloadedInputName: 'preloaded',
                maxSize: 5 * 1024 * 1024,
                maxFiles: 30,
                extensions: ['.jpg', '.jpeg', '.png', '.gif', '.svg', '.webp'],
                mimes: ['image/jpeg', 'image/png', 'image/gif', 'image/svg+xml', 'image/webp']
            });
        });
    
    // Build gallery preview with small thumbnails
    function buildGalleryPreview(images) {
        if (images.length > 0) {
            let galleryHtml = '';
            images.forEach((img, index) => {
                galleryHtml += `
                    <a href="${img.src}" 
                       data-lightbox="project-gallery" 
                       data-title="Image ${index + 1} of ${images.length}"
                       class="gallery-thumb-item">
                        <span class="thumb-order">${index + 1}</span>
                        <img src="${img.src}" alt="Gallery Image ${index + 1}">
                        <span class="thumb-overlay"><i class="fas fa-search-plus"></i></span>
                    </a>
                `;
            });
            $('#galleryPreviewRow').html(galleryHtml);
            $('#savedGalleryPreview').show();
        } else {
            $('#savedGalleryPreview').hide();
        }
    }
    
    // Update gallery count badge
    function updateProjectGalleryCount(count) {
        $('#gallery-count').text(count + ' image' + (count !== 1 ? 's' : ''));
    }
    
    // Update count when images are added/removed
    $(document).on('DOMSubtreeModified', '.images', function() {
        const currentCount = $('.image-uploader-images .uploaded').length;
        updateProjectGalleryCount(currentCount);
    });
    
    // Configure lightbox options
    if (typeof lightbox !== 'undefined') {
        lightbox.option({
            'resizeDuration': 200,
            'wrapAround': true,
            'maxWidth': 600,
            'maxHeight': 500,
            'fitImagesInViewport': true,
            'disableScrolling': true
        });
    }
    
    // Close lightbox when clicking on overlay (outside the image)
    $(document).on('click', '.lightboxOverlay, .lb-outerContainer', function(e) {
        if (!$(e.target).closest('.lb-image').length && !$(e.target).closest('.lb-nav').length) {
            if (typeof lightbox !== 'undefined') {
                lightbox.end();
            }
        }
    });
</script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\smartvisionuae\Modules/Admin\resources/views/projects/show.blade.php ENDPATH**/ ?>