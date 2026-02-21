{{-- Interior Design Gallery Section --}}
@if(isset($interiorGallery) && count($interiorGallery) > 0)
<section class="pt-lg-12 pb-lg-11 py-11 interior-gallery-section">
    <div class="container container-xxl">
        {{-- Section Header --}}
        <div class="row align-items-center mb-6 section-header">
            <div class="col-md-7">
                <span class="text-primary font-weight-600 letter-spacing-2 text-uppercase fs-13">{{ __('lang.interior_design') ?? 'Interior Design' }}</span>
                <h2 class="text-heading mt-2 mb-0">{{ __('lang.interior_gallery_title') ?? 'Our Interior Gallery' }}</h2>
                <span class="heading-divider"></span>
                <p class="mb-0">{{ __('lang.interior_gallery_bio') ?? 'Explore our stunning collection of interior design projects showcasing elegance, creativity, and modern aesthetics.' }}</p>
            </div>
            <div class="col-md-5 text-md-right mt-4 mt-md-0">
                <a href="{{ route('interior.index') }}" class="btn btn-primary">
                    {{ __('lang.view_all_gallery') ?? 'View All Gallery' }}
                    <i class="far fa-long-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
        
        {{-- Gallery Grid - Desktop Only --}}
        <div class="interior-gallery-grid d-none d-lg-grid">
            @foreach($interiorGallery as $item)
            <div class="interior-gallery-card" 
                 data-gallery-id="{{ $item->id }}"
                 data-title="{{ app()->getLocale() == 'ar' ? $item->title_arabic : $item->title_english }}"
                 data-bio="{{ app()->getLocale() == 'ar' ? $item->bio_arabic : $item->bio_english }}"
                 data-image="{{ url('/storage' . $item->image) }}"
                 data-category="{{ $item->category ? (app()->getLocale() == 'ar' ? $item->category->title_arabic : $item->category->title_english) : '' }}"
                 data-style="{{ $item->projectStyle ? (app()->getLocale() == 'ar' ? $item->projectStyle->title_arabic : $item->projectStyle->title_english) : '' }}"
                 data-emirate="{{ $item->emirate ? (app()->getLocale() == 'ar' ? $item->emirate->title_arabic : $item->emirate->title_english) : '' }}"
                 @if($item->project)
                 data-project-title="{{ app()->getLocale() == 'ar' ? $item->project->title_arabic : $item->project->title_english }}"
                 data-project-image="{{ $item->project->main_image ? url('/storage' . $item->project->main_image) : '' }}"
                 data-project-url="{{ route('projects.show', $item->project->slug) }}"
                 @endif
            >
                {{-- Card Image --}}
                <div class="card-image">
                    <img src="{{ url('/storage' . $item->image) }}" 
                         alt="{{ app()->getLocale() == 'ar' ? $item->title_arabic : $item->title_english }}"
                         loading="lazy">
                    <div class="card-overlay"></div>
                </div>
                
                {{-- View Button --}}
                <div class="view-btn">
                    <i class="fas fa-expand"></i>
                </div>
                
                {{-- Share Options --}}
                @php
                    $shareTitle = app()->getLocale() == 'ar' ? $item->title_arabic : $item->title_english;
                    $shareCategory = $item->category ? (app()->getLocale() == 'ar' ? $item->category->title_arabic : $item->category->title_english) : '';
                    $shareStyle = $item->projectStyle ? (app()->getLocale() == 'ar' ? $item->projectStyle->title_arabic : $item->projectStyle->title_english) : '';
                    $shareEmirate = $item->emirate ? (app()->getLocale() == 'ar' ? $item->emirate->title_arabic : $item->emirate->title_english) : '';
                    $shareText = $shareTitle;
                    if($shareCategory) {
                        $shareText .= ' - ' . $shareCategory;
                    }
                    if($shareStyle) {
                        $shareText .= ' (' . $shareStyle . ')';
                    }
                    if($shareEmirate) {
                        $shareText .= ' | ' . $shareEmirate;
                    }
                    $shareUrl = route('interior.index');
                    $shareImage = url('/storage' . $item->image);
                @endphp
                <div class="interior-share-badge" onclick="event.stopPropagation();">
                    <div class="share-actions">
                        <div class="share-slide-wrapper">
                            <button type="button" class="share-action-btn share-slide-btn">
                                <i class="fas fa-share-alt"></i>
                            </button>
                            <div class="share-slide-icons">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($shareUrl) }}&quote={{ urlencode($shareText) }}" 
                                   target="_blank" class="share-action-btn facebook-btn" onclick="event.stopPropagation();">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode($shareUrl) }}&text={{ urlencode($shareText) }}" 
                                   target="_blank" class="share-action-btn twitter-btn" onclick="event.stopPropagation();">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode($shareUrl) }}&title={{ urlencode($shareTitle) }}&summary={{ urlencode($shareText) }}" 
                                   target="_blank" class="share-action-btn linkedin-btn" onclick="event.stopPropagation();">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                                <a href="https://pinterest.com/pin/create/button/?url={{ urlencode($shareUrl) }}&media={{ urlencode($shareImage) }}&description={{ urlencode($shareText) }}" 
                                   target="_blank" class="share-action-btn pinterest-btn" onclick="event.stopPropagation();">
                                    <i class="fab fa-pinterest-p"></i>
                                </a>
                                <a href="mailto:?subject={{ rawurlencode($shareTitle) }}&body={{ urlencode($shareText . "\n\n" . $shareUrl) }}" 
                                   class="share-action-btn email-btn" onclick="event.stopPropagation();">
                                    <i class="fas fa-envelope"></i>
                                </a>
                            </div>
                        </div>
                        <a href="https://wa.me/?text={{ urlencode($shareText . "\n" . $shareUrl) }}" 
                           target="_blank" 
                           class="share-action-btn whatsapp-share-btn"
                           onclick="event.stopPropagation();">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    </div>
                </div>
                
                {{-- Card Content --}}
                <div class="card-content">
                    @if($item->category)
                    <h4 class="card-category-title">
                        {{ app()->getLocale() == 'ar' ? $item->category->title_arabic : $item->category->title_english }}
                    </h4>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        
        {{-- Gallery Slider - Mobile & Tablet Only (1 image per slide) --}}
        <div class="interior-gallery-slider d-lg-none">
            <div class="slick-slider interior-mobile-slider" data-slick-options='{"slidesToShow": 1, "slidesToScroll": 1, "dots": true, "arrows": false, "autoplay": true, "autoplaySpeed": 4000, "infinite": true, "centerMode": true, "centerPadding": "25px"}'>
                @foreach($interiorGallery as $item)
                <div class="interior-slide-item">
                    <div class="interior-gallery-card" 
                         data-gallery-id="{{ $item->id }}"
                         data-image="{{ url('/storage' . $item->image) }}"
                         data-category="{{ $item->category ? (app()->getLocale() == 'ar' ? $item->category->title_arabic : $item->category->title_english) : '' }}"
                         data-style="{{ $item->projectStyle ? (app()->getLocale() == 'ar' ? $item->projectStyle->title_arabic : $item->projectStyle->title_english) : '' }}"
                         data-emirate="{{ $item->emirate ? (app()->getLocale() == 'ar' ? $item->emirate->title_arabic : $item->emirate->title_english) : '' }}"
                         @if($item->project)
                         data-project-title="{{ app()->getLocale() == 'ar' ? $item->project->title_arabic : $item->project->title_english }}"
                         data-project-image="{{ $item->project->main_image ? url('/storage' . $item->project->main_image) : '' }}"
                         data-project-url="{{ route('projects.show', $item->project->slug) }}"
                         @endif
                    >
                        <div class="card-image">
                            <img src="{{ url('/storage' . $item->image) }}" 
                                 alt="{{ app()->getLocale() == 'ar' ? $item->title_arabic : $item->title_english }}"
                                 loading="lazy">
                            <div class="card-overlay"></div>
                        </div>
                        
                        <div class="view-btn">
                            <i class="fas fa-expand"></i>
                        </div>
                        
                        <div class="card-content">
                            @if($item->category)
                            <h4 class="card-category-title">
                                {{ app()->getLocale() == 'ar' ? $item->category->title_arabic : $item->category->title_english }}
                            </h4>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- Gallery Modal --}}
<div class="interior-gallery-modal" id="interiorGalleryModal">
    <div class="modal-container">
        {{-- Close Button --}}
        <button class="modal-close" id="closeGalleryModal">
            <i class="fas fa-times"></i>
        </button>
        
        {{-- Image Section --}}
        <div class="modal-image-section">
            <img src="" alt="" id="modalImage">
        </div>
        
        {{-- Content Section --}}
        <div class="modal-content-section">
            <span class="modal-category-badge" id="modalCategory"></span>
            
            {{-- Meta Information --}}
            <div class="modal-meta" id="modalMeta">
                {{-- Dynamic content will be inserted here --}}
            </div>
            
            {{-- Related Project --}}
            <div id="relatedProjectContainer">
                {{-- Dynamic content will be inserted here --}}
            </div>
        </div>
    </div>
</div>

{{-- Gallery JavaScript --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const galleryCards = document.querySelectorAll('.interior-gallery-card');
    const modal = document.getElementById('interiorGalleryModal');
    const closeBtn = document.getElementById('closeGalleryModal');
    const modalImage = document.getElementById('modalImage');
    const modalCategory = document.getElementById('modalCategory');
    const modalMeta = document.getElementById('modalMeta');
    const relatedProjectContainer = document.getElementById('relatedProjectContainer');
    
    // Open modal on card click
    galleryCards.forEach(card => {
        card.addEventListener('click', function() {
            const image = this.dataset.image;
            const category = this.dataset.category;
            const style = this.dataset.style;
            const emirate = this.dataset.emirate;
            const projectTitle = this.dataset.projectTitle;
            const projectImage = this.dataset.projectImage;
            const projectUrl = this.dataset.projectUrl;
            
            // Set modal content
            modalImage.src = image;
            modalImage.alt = category || '';
            modalCategory.textContent = category || '';
            
            // Build meta items
            let metaHtml = '';
            
            if (style) {
                metaHtml += `
                    <div class="modal-meta-item">
                        <i class="fas fa-palette"></i>
                        <div>
                            <span class="meta-label">{{ __('lang.design_style') ?? 'Design Style' }}</span>
                            <span class="meta-value">${style}</span>
                        </div>
                    </div>
                `;
            }
            
            if (emirate) {
                metaHtml += `
                    <div class="modal-meta-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <div>
                            <span class="meta-label">{{ __('lang.location') ?? 'Location' }}</span>
                            <span class="meta-value">${emirate}</span>
                        </div>
                    </div>
                `;
            }
            
            modalMeta.innerHTML = metaHtml;
            
            // Build related project card
            let projectHtml = '';
            if (projectTitle && projectUrl) {
                projectHtml = `
                    <a href="${projectUrl}" class="related-project">
                        ${projectImage ? `
                            <div class="related-project-image">
                                <img src="${projectImage}" alt="${projectTitle}">
                            </div>
                        ` : ''}
                        <div class="related-project-info">
                            <span class="related-project-label">{{ __('lang.related_project') ?? 'Related Project' }}</span>
                            <span class="related-project-title">${projectTitle}</span>
                        </div>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                `;
            }
            relatedProjectContainer.innerHTML = projectHtml;
            
            // Show modal
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        });
    });
    
    // Close modal
    function closeModal() {
        modal.classList.remove('active');
        document.body.style.overflow = '';
    }
    
    closeBtn.addEventListener('click', closeModal);
    
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            closeModal();
        }
    });
    
    // Close on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modal.classList.contains('active')) {
            closeModal();
        }
    });
});
</script>
@endif
