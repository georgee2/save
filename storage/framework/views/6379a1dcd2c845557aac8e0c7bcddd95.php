
<?php if(isset($interiorGallery) && count($interiorGallery) > 0): ?>
<section class="pt-lg-12 pb-lg-11 py-11 interior-gallery-section">
    <div class="container container-xxl">
        
        <div class="row align-items-center mb-6 section-header">
            <div class="col-md-7">
                <span class="text-primary font-weight-600 letter-spacing-2 text-uppercase fs-13"><?php echo e(__('lang.interior_design') ?? 'Interior Design'); ?></span>
                <h2 class="text-heading mt-2 mb-0"><?php echo e(__('lang.interior_gallery_title') ?? 'Our Interior Gallery'); ?></h2>
                <span class="heading-divider"></span>
                <p class="mb-0"><?php echo e(__('lang.interior_gallery_bio') ?? 'Explore our stunning collection of interior design projects showcasing elegance, creativity, and modern aesthetics.'); ?></p>
            </div>
            <div class="col-md-5 text-md-right mt-4 mt-md-0">
                <a href="<?php echo e(route('interior.index')); ?>" class="btn btn-primary">
                    <?php echo e(__('lang.view_all_gallery') ?? 'View All Gallery'); ?>

                    <i class="far fa-long-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
        
        
        <div class="interior-gallery-grid d-none d-lg-grid">
            <?php $__currentLoopData = $interiorGallery; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="interior-gallery-card" 
                 data-gallery-id="<?php echo e($item->id); ?>"
                 data-title="<?php echo e(app()->getLocale() == 'ar' ? $item->title_arabic : $item->title_english); ?>"
                 data-bio="<?php echo e(app()->getLocale() == 'ar' ? $item->bio_arabic : $item->bio_english); ?>"
                 data-image="<?php echo e(url('/storage' . $item->image)); ?>"
                 data-category="<?php echo e($item->category ? (app()->getLocale() == 'ar' ? $item->category->title_arabic : $item->category->title_english) : ''); ?>"
                 data-style="<?php echo e($item->projectStyle ? (app()->getLocale() == 'ar' ? $item->projectStyle->title_arabic : $item->projectStyle->title_english) : ''); ?>"
                 data-emirate="<?php echo e($item->emirate ? (app()->getLocale() == 'ar' ? $item->emirate->title_arabic : $item->emirate->title_english) : ''); ?>"
                 <?php if($item->project): ?>
                 data-project-title="<?php echo e(app()->getLocale() == 'ar' ? $item->project->title_arabic : $item->project->title_english); ?>"
                 data-project-image="<?php echo e($item->project->main_image ? url('/storage' . $item->project->main_image) : ''); ?>"
                 data-project-url="<?php echo e(route('projects.show', $item->project->slug)); ?>"
                 <?php endif; ?>
            >
                
                <div class="card-image">
                    <img src="<?php echo e(url('/storage' . $item->image)); ?>" 
                         alt="<?php echo e(app()->getLocale() == 'ar' ? $item->title_arabic : $item->title_english); ?>"
                         loading="lazy">
                    <div class="card-overlay"></div>
                </div>
                
                
                <div class="view-btn">
                    <i class="fas fa-expand"></i>
                </div>
                
                
                <?php
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
                ?>
                <button class="btn-favourite" data-type="interior" data-id="<?php echo e($item->id); ?>" title="<?php echo e(__('lang.add_to_favourites')); ?>">
                    <i class="fal fa-heart"></i>
                </button>
                <div class="interior-share-badge" onclick="event.stopPropagation();">
                    <div class="share-actions">
                        <div class="share-slide-wrapper">
                            <button type="button" class="share-action-btn share-slide-btn">
                                <i class="fas fa-share-alt"></i>
                            </button>
                            <div class="share-slide-icons">
                                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo e(urlencode($shareUrl)); ?>&quote=<?php echo e(urlencode($shareText)); ?>" 
                                   target="_blank" class="share-action-btn facebook-btn" onclick="event.stopPropagation();">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="https://twitter.com/intent/tweet?url=<?php echo e(urlencode($shareUrl)); ?>&text=<?php echo e(urlencode($shareText)); ?>" 
                                   target="_blank" class="share-action-btn twitter-btn" onclick="event.stopPropagation();">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo e(urlencode($shareUrl)); ?>&title=<?php echo e(urlencode($shareTitle)); ?>&summary=<?php echo e(urlencode($shareText)); ?>" 
                                   target="_blank" class="share-action-btn linkedin-btn" onclick="event.stopPropagation();">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                                <a href="https://pinterest.com/pin/create/button/?url=<?php echo e(urlencode($shareUrl)); ?>&media=<?php echo e(urlencode($shareImage)); ?>&description=<?php echo e(urlencode($shareText)); ?>" 
                                   target="_blank" class="share-action-btn pinterest-btn" onclick="event.stopPropagation();">
                                    <i class="fab fa-pinterest-p"></i>
                                </a>
                                <a href="mailto:?subject=<?php echo e(rawurlencode($shareTitle)); ?>&body=<?php echo e(urlencode($shareText . "\n\n" . $shareUrl)); ?>" 
                                   class="share-action-btn email-btn" onclick="event.stopPropagation();">
                                    <i class="fas fa-envelope"></i>
                                </a>
                            </div>
                        </div>
                        <a href="https://wa.me/?text=<?php echo e(urlencode($shareText . "\n" . $shareUrl)); ?>" 
                           target="_blank" 
                           class="share-action-btn whatsapp-share-btn"
                           onclick="event.stopPropagation();">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    </div>
                </div>
                
                
                <div class="card-content">
                    <?php if($item->category): ?>
                    <h4 class="card-category-title">
                        <?php echo e(app()->getLocale() == 'ar' ? $item->category->title_arabic : $item->category->title_english); ?>

                    </h4>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        
        
        <div class="interior-gallery-slider d-lg-none">
            <div class="slick-slider interior-mobile-slider" data-slick-options='{"slidesToShow": 1, "slidesToScroll": 1, "dots": true, "arrows": false, "autoplay": true, "autoplaySpeed": 4000, "infinite": true, "centerMode": true, "centerPadding": "25px"}'>
                <?php $__currentLoopData = $interiorGallery; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="interior-slide-item">
                    <div class="interior-gallery-card" 
                         data-gallery-id="<?php echo e($item->id); ?>"
                         data-image="<?php echo e(url('/storage' . $item->image)); ?>"
                         data-category="<?php echo e($item->category ? (app()->getLocale() == 'ar' ? $item->category->title_arabic : $item->category->title_english) : ''); ?>"
                         data-style="<?php echo e($item->projectStyle ? (app()->getLocale() == 'ar' ? $item->projectStyle->title_arabic : $item->projectStyle->title_english) : ''); ?>"
                         data-emirate="<?php echo e($item->emirate ? (app()->getLocale() == 'ar' ? $item->emirate->title_arabic : $item->emirate->title_english) : ''); ?>"
                         <?php if($item->project): ?>
                         data-project-title="<?php echo e(app()->getLocale() == 'ar' ? $item->project->title_arabic : $item->project->title_english); ?>"
                         data-project-image="<?php echo e($item->project->main_image ? url('/storage' . $item->project->main_image) : ''); ?>"
                         data-project-url="<?php echo e(route('projects.show', $item->project->slug)); ?>"
                         <?php endif; ?>
                    >
                        <div class="card-image">
                            <img src="<?php echo e(url('/storage' . $item->image)); ?>" 
                                 alt="<?php echo e(app()->getLocale() == 'ar' ? $item->title_arabic : $item->title_english); ?>"
                                 loading="lazy">
                            <div class="card-overlay"></div>
                        </div>
                        
                        <div class="view-btn">
                            <i class="fas fa-expand"></i>
                        </div>
                        
                        <button class="btn-favourite" data-type="interior" data-id="<?php echo e($item->id); ?>" title="<?php echo e(__('lang.add_to_favourites')); ?>">
                            <i class="fal fa-heart"></i>
                        </button>
                        
                        <div class="card-content">
                            <?php if($item->category): ?>
                            <h4 class="card-category-title">
                                <?php echo e(app()->getLocale() == 'ar' ? $item->category->title_arabic : $item->category->title_english); ?>

                            </h4>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
</section>


<div class="interior-gallery-modal" id="interiorGalleryModal">
    <div class="modal-container">
        
        <button class="modal-close" id="closeGalleryModal">
            <i class="fas fa-times"></i>
        </button>
        
        
        <div class="modal-image-section">
            <img src="" alt="" id="modalImage">
        </div>
        
        
        <div class="modal-content-section">
            <span class="modal-category-badge" id="modalCategory"></span>
            
            
            <div class="modal-meta" id="modalMeta">
                
            </div>
            
            
            <div id="relatedProjectContainer">
                
            </div>
        </div>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function() {
    // Smart Dots for Interior Mobile Slider
    var interiorMaxVisible = 5;

    function updateInteriorSmartDots() {
        var $dots = $('.interior-gallery-slider .slick-dots li');
        var total = $dots.length;
        if (total <= interiorMaxVisible) return;

        var activeIndex = $dots.filter('.slick-active').index();

        $dots.removeClass('smart-dot-hidden smart-dot-far');

        $dots.each(function(i) {
            var distance = Math.abs(i - activeIndex);
            if (distance > Math.floor(interiorMaxVisible / 2) + 1) {
                $(this).addClass('smart-dot-far');
            } else if (distance > Math.floor(interiorMaxVisible / 2)) {
                $(this).addClass('smart-dot-hidden');
            }
        });
    }

    var $interiorSlider = $('.interior-mobile-slider');
    if ($interiorSlider.length) {
        $interiorSlider.on('afterChange', updateInteriorSmartDots);
        $interiorSlider.on('init', updateInteriorSmartDots);
        setTimeout(updateInteriorSmartDots, 500);
    }
    const galleryCards = document.querySelectorAll('.interior-gallery-card');
    const modal = document.getElementById('interiorGalleryModal');
    const closeBtn = document.getElementById('closeGalleryModal');
    const modalImage = document.getElementById('modalImage');
    const modalCategory = document.getElementById('modalCategory');
    const modalMeta = document.getElementById('modalMeta');
    const relatedProjectContainer = document.getElementById('relatedProjectContainer');
    
    // Open modal on card click
    galleryCards.forEach(card => {
        card.addEventListener('click', function(e) {
            if (e.target.closest('.btn-favourite') || e.target.closest('.interior-share-badge')) return;
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
                            <span class="meta-label"><?php echo e(__('lang.design_style') ?? 'Design Style'); ?></span>
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
                            <span class="meta-label"><?php echo e(__('lang.location') ?? 'Location'); ?></span>
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
                            <span class="related-project-label"><?php echo e(__('lang.related_project') ?? 'Related Project'); ?></span>
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
<?php endif; ?>
<?php /**PATH C:\wamp64\www\smartvisionuae\resources\views/home/interior-gallery.blade.php ENDPATH**/ ?>