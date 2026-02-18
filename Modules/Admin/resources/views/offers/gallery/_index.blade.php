<!-- Offer Gallery Section -->
<div class="gallery-section">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="text-primary mb-0">
            <i class="fa fa-images"></i> Offer Gallery
            <span class="badge badge-light text-primary ml-2" id="offer-gallery-count">0</span>
        </h5>
    </div>
    
    @if(isset($errors) && $errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('offer-image.store', $offer->id) }}" enctype="multipart/form-data" method="POST">
        @csrf
        
        <div class="form-group">
            <label class="font-weight-bold">
                <i class="fas fa-upload"></i> Upload / Manage Gallery Images 
                <small class="text-muted">(903px x 1146px - Portrait)</small>
            </label>
            <div class="offer-gallery-images mb-3"></div>
            <small class="form-text text-muted">
                <i class="fa fa-info-circle"></i> 
                You can upload multiple images. Drag and drop to reorder. Click the X to remove an image. Images will be automatically resized to <strong>903x1146</strong> (portrait) and converted to <strong>WebP format</strong> with 80% quality.
            </small>
        </div>

        <div class="form-group">
            <button class="btn btn-primary" type="submit">
                <i class="fa fa-save"></i> Save Gallery
            </button>
            <button class="btn btn-secondary" type="button" onclick="reloadWithTab()">
                <i class="fa fa-history"></i> Reset
            </button>
        </div>
    </form>
    
    <!-- Saved Images Preview with Lightbox (Below Uploader) -->
    <div class="saved-gallery-preview mt-4" id="offerSavedGalleryPreview" style="display: none;">
        <hr>
        <label class="font-weight-bold d-block mb-3">
            <i class="fas fa-eye text-primary"></i> Saved Images Preview 
            <small class="text-muted">(Click to view full size - Same order as uploader)</small>
        </label>
        <div class="gallery-thumbs-grid" id="offerGalleryPreviewRow">
            <!-- Images will be loaded via JavaScript -->
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Helper function to reload page while preserving current tab
    function reloadWithTab() {
        const activeTab = document.querySelector('.tab-item.active');
        if (activeTab) {
            const tabId = activeTab.getAttribute('data-tab');
            const url = new URL(window.location.href);
            url.searchParams.set('tab', tabId);
            window.location.href = url.toString();
        } else {
            location.reload();
        }
    }
    
    // Fetch and initialize offer gallery
    $.ajax({
        url: '/admin/offer-image/galleries/{{ $offer->id }}',
        method: 'GET',
        success: function(offerImages) {
            // Initialize image uploader with preloaded images
            $('.offer-gallery-images').imageUploader({
                preloaded: offerImages,
                imagesInputName: 'images',
                preloadedInputName: 'preloaded',
                maxSize: 5 * 1024 * 1024, // 5MB
                maxFiles: 30,
                extensions: ['.jpg', '.jpeg', '.png', '.gif', '.webp'],
                mimes: ['image/jpeg', 'image/png', 'image/gif', 'image/webp']
            });
            
            // Update gallery count
            updateOfferGalleryCount(offerImages.length);
            
            // Build lightbox preview gallery (same order as uploader)
            buildOfferGalleryPreview(offerImages);
        },
        error: function() {
            // Initialize empty uploader
            $('.offer-gallery-images').imageUploader({
                imagesInputName: 'images',
                preloadedInputName: 'preloaded',
                maxSize: 5 * 1024 * 1024,
                maxFiles: 30,
                extensions: ['.jpg', '.jpeg', '.png', '.gif', '.webp'],
                mimes: ['image/jpeg', 'image/png', 'image/gif', 'image/webp']
            });
        }
    });
    
    // Build gallery preview with small thumbnails
    function buildOfferGalleryPreview(images) {
        if (images.length > 0) {
            let galleryHtml = '';
            images.forEach((img, index) => {
                galleryHtml += `
                    <a href="${img.src}" 
                       data-lightbox="offer-gallery" 
                       data-title="Image ${index + 1} of ${images.length}"
                       class="gallery-thumb-item">
                        <span class="thumb-order">${index + 1}</span>
                        <img src="${img.src}" alt="Gallery Image ${index + 1}">
                        <span class="thumb-overlay"><i class="fas fa-search-plus"></i></span>
                    </a>
                `;
            });
            $('#offerGalleryPreviewRow').html(galleryHtml);
            $('#offerSavedGalleryPreview').show();
        } else {
            $('#offerSavedGalleryPreview').hide();
        }
    }
    
    // Update gallery count badge
    function updateOfferGalleryCount(count) {
        $('#offer-gallery-count').text(count + ' image' + (count !== 1 ? 's' : ''));
    }
    
    // Update count when images are added/removed
    $(document).on('DOMSubtreeModified', '.offer-gallery-images', function() {
        const currentCount = $('.offer-gallery-images .image-uploader .uploaded').length;
        updateOfferGalleryCount(currentCount);
    });
    
    // Configure lightbox options for offer gallery
    if (typeof lightbox !== 'undefined') {
        lightbox.option({
            'resizeDuration': 200,
            'wrapAround': true,
            'maxWidth': 500,
            'maxHeight': 400,
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
@endpush

