<!-- Offer Gallery Section -->
<div class="gallery-section">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="text-primary mb-0">
            <i class="fa fa-images"></i> Offer Gallery
            <span class="badge badge-light text-primary ml-2" id="offer-gallery-count">0</span>
        </h5>
    </div>
    
    @if($errors->all())
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
                Gallery Images 
                <small class="text-muted">(1080px x 1080px)</small>
            </label>
            <div class="offer-gallery-images mb-3"></div>
            <small class="form-text text-muted">
                <i class="fa fa-info-circle"></i> 
                You can upload multiple images. Drag and drop to reorder. Click the X to remove an image. Images will be automatically resized to 1080x1080 and converted to WebP format with 80% quality.
            </small>
        </div>

        <div class="form-group">
            <button class="btn btn-primary" type="submit">
                <i class="fa fa-save"></i> Save Gallery
            </button>
            <button class="btn btn-secondary" type="button" onclick="location.reload()">
                <i class="fa fa-history"></i> Reset
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
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
                maxFiles: 30
            });
            
            // Update gallery count
            updateOfferGalleryCount(offerImages.length);
        },
        error: function() {
            // Initialize empty uploader
            $('.offer-gallery-images').imageUploader({
                imagesInputName: 'images',
                preloadedInputName: 'preloaded',
                maxSize: 5 * 1024 * 1024,
                maxFiles: 30
            });
        }
    });
    
    // Update gallery count badge
    function updateOfferGalleryCount(count) {
        $('#offer-gallery-count').text(count + ' image' + (count !== 1 ? 's' : ''));
    }
    
    // Update count when images are added/removed
    $(document).on('DOMSubtreeModified', '.offer-gallery-images', function() {
        const currentCount = $('.offer-gallery-images .image-uploader .uploaded').length;
        updateOfferGalleryCount(currentCount);
    });
</script>
@endpush

