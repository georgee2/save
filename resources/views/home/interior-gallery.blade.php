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
                {{-- Optional: Add a view all link if you have a gallery page --}}
                {{-- <a href="{{ route('interior-gallery.index') }}" class="view-all-btn">
                    {{ __('lang.view_all_gallery') ?? 'View All Gallery' }}
                    <i class="far fa-long-arrow-right"></i>
                </a> --}}
            </div>
        </div>
        
        {{-- Gallery Grid --}}
        <div class="interior-gallery-grid">
            @foreach($interiorGallery as $item)
            <div class="interior-gallery-card" 
                 data-gallery-id="{{ $item->id }}"
                 data-title="{{ app()->getLocale() == 'ar' ? $item->title_arabic : $item->title_english }}"
                 data-bio="{{ app()->getLocale() == 'ar' ? $item->bio_arabic : $item->bio_english }}"
                 data-image="{{ url('/storage' . $item->image) }}"
                 data-type="{{ $item->projectType ? (app()->getLocale() == 'ar' ? $item->projectType->name_arabic : $item->projectType->name_english) : '' }}"
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
                
                {{-- Card Content --}}
                <div class="card-content">
                    <h3 class="card-title">
                        {{ app()->getLocale() == 'ar' ? $item->title_arabic : $item->title_english }}
                    </h3>
                    
                    @php
                        $bio = app()->getLocale() == 'ar' ? $item->bio_arabic : $item->bio_english;
                    @endphp
                    @if($bio)
                    <p class="card-bio">{{ $bio }}</p>
                    @endif
                    
                    {{-- Meta Tags --}}
                    <div class="card-meta">
                        @if($item->projectType)
                        <span class="meta-tag">
                            <i class="fas fa-tag"></i>
                            {{ app()->getLocale() == 'ar' ? $item->projectType->name_arabic : $item->projectType->name_english }}
                        </span>
                        @endif
                        
                        @if($item->projectStyle)
                        <span class="meta-tag">
                            <i class="fas fa-palette"></i>
                            {{ app()->getLocale() == 'ar' ? $item->projectStyle->title_arabic : $item->projectStyle->title_english }}
                        </span>
                        @endif
                        
                        @if($item->emirate)
                        <span class="meta-tag">
                            <i class="fas fa-map-marker-alt"></i>
                            {{ app()->getLocale() == 'ar' ? $item->emirate->title_arabic : $item->emirate->title_english }}
                        </span>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
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
            <h2 class="modal-title" id="modalTitle"></h2>
            <p class="modal-bio" id="modalBio"></p>
            
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
    const modalTitle = document.getElementById('modalTitle');
    const modalBio = document.getElementById('modalBio');
    const modalMeta = document.getElementById('modalMeta');
    const relatedProjectContainer = document.getElementById('relatedProjectContainer');
    
    // Open modal on card click
    galleryCards.forEach(card => {
        card.addEventListener('click', function() {
            const title = this.dataset.title;
            const bio = this.dataset.bio;
            const image = this.dataset.image;
            const type = this.dataset.type;
            const style = this.dataset.style;
            const emirate = this.dataset.emirate;
            const projectTitle = this.dataset.projectTitle;
            const projectImage = this.dataset.projectImage;
            const projectUrl = this.dataset.projectUrl;
            
            // Set modal content
            modalImage.src = image;
            modalImage.alt = title;
            modalTitle.textContent = title;
            modalBio.textContent = bio || '';
            
            // Build meta items
            let metaHtml = '';
            
            if (type) {
                metaHtml += `
                    <div class="modal-meta-item">
                        <i class="fas fa-tag"></i>
                        <div>
                            <span class="meta-label">{{ __('lang.project_type') ?? 'Project Type' }}</span>
                            <span class="meta-value">${type}</span>
                        </div>
                    </div>
                `;
            }
            
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
