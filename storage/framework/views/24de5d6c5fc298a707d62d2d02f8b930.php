
<?php
    $emirates = \App\Models\Emirate::whereNull('deleted_at')->orderBy('title_english')->get();
    $selectedEmirateId = request('emirate_id');
    
    // Determine search type from request or current route
    $currentRouteName = \Route::currentRouteName();
    if (request('search_type')) {
        $selectedSearchType = request('search_type');
    } elseif (str_contains($currentRouteName ?? '', 'projects')) {
        $selectedSearchType = 'projects';
    } elseif (str_contains($currentRouteName ?? '', 'offers')) {
        $selectedSearchType = 'offers';
    } else {
        $selectedSearchType = 'offers'; // default
    }
?>

<section class="bg-primary global-search-section">
    <div class="container">
        
        <form class="property-search global-search-form d-none d-lg-block" id="globalSearchForm" action="<?php echo e(route('search.index')); ?>" method="GET">
            <div class="row align-items-lg-center" id="accordion-search">
                
                <div class="col-xl-2 col-lg-3 col-md-4">
                    <div class="property-search-status-tab d-flex flex-row">
                        <input class="search-field" type="hidden" name="search_type" id="searchTypeInput" value="<?php echo e($selectedSearchType); ?>">
                        <button type="button" data-value="offers"
                            class="btn shadow-none btn-active-secondary text-white rounded-0 hover-white text-uppercase h-lg-80 border-right-0 border-top-0 border-bottom-0 border-left border-white-opacity-03 search-type-btn <?php echo e($selectedSearchType === 'offers' ? 'active' : ''); ?> flex-md-1">
                            <?php echo e(__('lang.offers')); ?>

                        </button>
                        <button type="button" data-value="projects"
                            class="btn shadow-none btn-active-secondary text-white rounded-0 hover-white text-uppercase h-lg-80 border-left-0 border-top-0 border-bottom-0 border-right border-white-opacity-03 search-type-btn <?php echo e($selectedSearchType === 'projects' ? 'active' : ''); ?> flex-md-1">
                            <?php echo e(__('lang.projects')); ?>

                        </button>
                    </div>
                </div>
                
                
                <div class="col-xl-8 col-lg-7 d-md-flex">
                    
                    <select class="form-control shadow-none form-control-lg selectpicker rounded-right-md-0 rounded-md-top-left-0 rounded-lg-top-left flex-md-1 mt-3 mt-md-0 emirate-selector"
                            title="<?php echo e(__('lang.all_emirates')); ?>" data-style="btn-lg py-2 h-52 border-right bg-white" 
                            id="emirateSelect" name="emirate_id">
                        <option value=""><?php echo e(__('lang.all_emirates')); ?></option>
                        <?php $__currentLoopData = $emirates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emirate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($emirate->id); ?>" 
                                data-icon="<?php echo e($emirate->icon ? url('/storage' . $emirate->icon) : ''); ?>"
                                <?php echo e($selectedEmirateId == $emirate->id ? 'selected' : ''); ?>>
                            <?php echo e(app()->getLocale() == 'ar' ? $emirate->title_arabic : $emirate->title_english); ?>

                        </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    
                    
                    <div class="form-group mb-0 position-relative flex-md-3 mt-3 mt-md-0">
                        <input type="text"
                               class="form-control form-control-lg border-0 shadow-none rounded-left-md-0 pr-8 bg-white placeholder-muted"
                               id="globalSearchInput" name="keyword" autocomplete="off"
                               placeholder="<?php echo e(__('lang.enter_keyword')); ?>" value="<?php echo e(request('keyword')); ?>">
                        <button type="submit"
                            class="btn position-absolute pos-fixed-right-center p-0 text-heading fs-20 mr-4 shadow-none">
                            <i class="far fa-search"></i>
                        </button>
                        
                        
                        <div class="live-search-results" id="liveSearchResults" style="display: none;">
                            <div class="search-results-loading" style="display: none;">
                                <i class="fas fa-spinner fa-spin"></i> <?php echo e(__('lang.loading')); ?>...
                            </div>
                            <div class="search-results-list"></div>
                            <div class="search-results-empty" style="display: none;">
                                <?php echo e(__('lang.no_results_found') ?? 'No results found'); ?>

                            </div>
                            <div class="search-results-footer" style="display: none;">
                                <a href="#" class="view-all-results">
                                    <?php echo e(__('lang.view_all_results') ?? 'View all results'); ?> <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                
                <div class="col-lg-2">
                    <a href="#advanced-search-filters"
                       class="icon-white btn advanced-search w-100 shadow-none text-white text-left rounded-0 fs-14 font-weight-600 position-relative collapsed px-0 d-flex align-items-center"
                       data-toggle="collapse" data-target="#advanced-search-filters" aria-expanded="false"
                       aria-controls="advanced-search-filters">
                        <?php echo e(__('lang.advanced_search') ?? 'Advanced Search'); ?>

                    </a>
                </div>
                
                
                <div id="advanced-search-filters" class="col-12 pb-6 pt-lg-2 collapse" data-parent="#accordion-search">
                    
                    <div class="row mx-n2">
                        
                        <div class="col-sm-6 col-lg-3 pt-4 px-2">
                            <select class="form-control border-0 shadow-none form-control-lg selectpicker bg-white"
                                    name="category_id" id="categorySelect"
                                    title="<?php echo e(__('lang.all_categories')); ?>" data-style="btn-lg py-2 h-52 bg-white">
                                <option value=""><?php echo e(__('lang.all_categories')); ?></option>
                            </select>
                        </div>
                        
                        
                        <div class="col-sm-6 col-lg-3 pt-4 px-2">
                            <select class="form-control border-0 shadow-none form-control-lg selectpicker bg-white"
                                    name="subcategory_id" id="subcategorySelect"
                                    title="<?php echo e(__('lang.all_subcategories')); ?>" data-style="btn-lg py-2 h-52 bg-white">
                                <option value=""><?php echo e(__('lang.all_subcategories')); ?></option>
                            </select>
                        </div>
                        
                        
                        <div class="col-sm-6 col-lg-3 pt-4 px-2">
                            <select class="form-control border-0 shadow-none form-control-lg selectpicker bg-white"
                                    name="style_id" id="styleSelect"
                                    title="<?php echo e(__('lang.all_styles')); ?>" data-style="btn-lg py-2 h-52 bg-white">
                                <option value=""><?php echo e(__('lang.all_styles')); ?></option>
                            </select>
                        </div>
                        
                        
                        <div class="col-sm-6 col-lg-3 pt-4 px-2">
                            <input type="text"
                                   class="form-control form-control-lg border-0 shadow-none bg-white h-52"
                                   placeholder="<?php echo e(__('lang.offer_code')); ?> / <?php echo e(__('lang.project_code') ?? 'Project Code'); ?>" 
                                   name="code" id="codeInput">
                        </div>
                    </div>
                    
                    
                    <div class="row mx-n2 align-items-end">
                        
                        <div class="col-sm-6 col-lg-6 pt-5 px-2">
                            <label class="mb-3 text-white font-weight-500"><?php echo e(__('lang.area_size')); ?> (<?php echo e(__('lang.sqft')); ?>)</label>
                            <div class="global-search-slider-container">
                                <div id="global-sqft-slider" class="global-area-slider"></div>
                                <div class="slider-values-display text-center mt-2">
                                    <span id="global-sqft-display" class="text-white font-weight-500">
                                        0 <?php echo e(__('lang.sqft')); ?> - 50,000 <?php echo e(__('lang.sqft')); ?>

                                    </span>
                                </div>
                                <input type="hidden" id="global_sqft_min" name="sqft_min" value="">
                                <input type="hidden" id="global_sqft_max" name="sqft_max" value="">
                            </div>
                        </div>
                        
                        
                        <div class="col-sm-6 col-lg-3 pt-5 px-2 ml-auto">
                            <button type="submit" class="btn btn-secondary btn-lg w-100 h-52">
                                <i class="fas fa-search mr-2"></i> <?php echo e(__('lang.search')); ?>

                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        
        
        <form class="property-search property-search-mobile global-search-form d-lg-none py-6" id="globalSearchFormMobile" action="<?php echo e(route('search.index')); ?>" method="GET">
            <div class="row align-items-lg-center" id="accordion-search-mobile">
                <div class="col-12">
                    <div class="form-group mb-0 position-relative">
                        <a href="#advanced-search-filters-mobile"
                           class="icon-primary btn advanced-search shadow-none pr-3 pl-0 d-flex align-items-center position-absolute pos-fixed-left-center py-0 h-100 border-right collapsed"
                           data-toggle="collapse" data-target="#advanced-search-filters-mobile"
                           aria-expanded="false"
                           aria-controls="advanced-search-filters-mobile">
                        </a>
                        <input type="text"
                               class="form-control form-control-lg border-0 shadow-none pr-9 pl-11 bg-white placeholder-muted"
                               name="keyword" id="globalSearchInputMobile" autocomplete="off"
                               placeholder="<?php echo e(__('lang.search')); ?>..." value="<?php echo e(request('keyword')); ?>">
                        <button type="submit"
                            class="btn position-absolute pos-fixed-right-center p-0 text-heading fs-20 px-3 shadow-none h-100 border-left bg-white">
                            <i class="far fa-search"></i>
                        </button>
                        
                        
                        <div class="live-search-results" id="liveSearchResultsMobile" style="display: none;">
                            <div class="search-results-loading" style="display: none;">
                                <i class="fas fa-spinner fa-spin"></i> <?php echo e(__('lang.loading')); ?>...
                            </div>
                            <div class="search-results-list"></div>
                            <div class="search-results-empty" style="display: none;">
                                <?php echo e(__('lang.no_results_found') ?? 'No results found'); ?>

                            </div>
                        </div>
                    </div>
                </div>
                
                
                <div id="advanced-search-filters-mobile" class="col-12 pt-2 collapse" data-parent="#accordion-search-mobile">
                    <div class="row mx-n2">
                        
                        <div class="col-sm-6 pt-4 px-2">
                            <select class="form-control border-0 shadow-none form-control-lg selectpicker bg-white"
                                    title="<?php echo e(__('lang.search_in') ?? 'Search in'); ?>" data-style="btn-lg py-2 h-52 bg-white" 
                                    name="search_type" id="searchTypeMobile">
                                <option value="offers" <?php echo e($selectedSearchType === 'offers' ? 'selected' : ''); ?>><?php echo e(__('lang.offers')); ?></option>
                                <option value="projects" <?php echo e($selectedSearchType === 'projects' ? 'selected' : ''); ?>><?php echo e(__('lang.projects')); ?></option>
                            </select>
                        </div>
                        
                        
                        <div class="col-sm-6 pt-4 px-2">
                            <select class="form-control border-0 shadow-none form-control-lg selectpicker bg-white emirate-selector"
                                    title="<?php echo e(__('lang.all_emirates')); ?>" data-style="btn-lg py-2 h-52 bg-white" 
                                    name="emirate_id" id="emirateSelectMobile">
                                <option value=""><?php echo e(__('lang.all_emirates')); ?></option>
                                <?php $__currentLoopData = $emirates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emirate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($emirate->id); ?>" <?php echo e($selectedEmirateId == $emirate->id ? 'selected' : ''); ?>>
                                    <?php echo e(app()->getLocale() == 'ar' ? $emirate->title_arabic : $emirate->title_english); ?>

                                </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        
                        
                        <div class="col-sm-6 pt-4 px-2">
                            <select class="form-control border-0 shadow-none form-control-lg selectpicker bg-white"
                                    name="category_id" id="categorySelectMobile"
                                    title="<?php echo e(__('lang.all_categories')); ?>" data-style="btn-lg py-2 h-52 bg-white">
                                <option value=""><?php echo e(__('lang.all_categories')); ?></option>
                            </select>
                        </div>
                        
                        
                        <div class="col-sm-6 pt-4 px-2">
                            <select class="form-control border-0 shadow-none form-control-lg selectpicker bg-white"
                                    name="subcategory_id" id="subcategorySelectMobile"
                                    title="<?php echo e(__('lang.all_subcategories')); ?>" data-style="btn-lg py-2 h-52 bg-white">
                                <option value=""><?php echo e(__('lang.all_subcategories')); ?></option>
                            </select>
                        </div>
                        
                        
                        <div class="col-sm-6 pt-4 px-2">
                            <select class="form-control border-0 shadow-none form-control-lg selectpicker bg-white"
                                    name="style_id" id="styleSelectMobile"
                                    title="<?php echo e(__('lang.all_styles')); ?>" data-style="btn-lg py-2 h-52 bg-white">
                                <option value=""><?php echo e(__('lang.all_styles')); ?></option>
                            </select>
                        </div>
                        
                        
                        <div class="col-sm-6 pt-4 px-2">
                            <input type="text"
                                   class="form-control form-control-lg border-0 shadow-none bg-white"
                                   placeholder="<?php echo e(__('lang.offer_code')); ?> / <?php echo e(__('lang.project_code') ?? 'Project Code'); ?>" 
                                   name="code" id="codeInputMobile"
                                   style="height: 52px;">
                        </div>
                    </div>
                    
                    
                    <div class="row pt-4">
                        <div class="col-12">
                            <button type="submit" class="btn btn-secondary btn-lg w-100">
                                <i class="fas fa-search mr-2"></i> <?php echo e(__('lang.search')); ?>

                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>


<script>
document.addEventListener('DOMContentLoaded', function() {
    // Configuration
    var searchConfig = {
        liveSearchUrl: '<?php echo e(route("search.live")); ?>',
        categoriesUrl: '<?php echo e(route("search.categories")); ?>',
        subcategoriesUrl: '<?php echo e(route("search.subcategories")); ?>',
        typesUrl: '<?php echo e(route("search.types")); ?>',
        stylesUrl: '<?php echo e(route("search.styles")); ?>',
        minChars: 2,
        debounceTime: 300
    };
    
    var searchTimeout = null;
    var currentSearchType = '<?php echo e($selectedSearchType); ?>';
    
    // Search Type Tab Buttons (Desktop)
    var searchTypeBtns = document.querySelectorAll('.search-type-btn');
    var searchTypeInput = document.getElementById('searchTypeInput');
    
    searchTypeBtns.forEach(function(btn) {
        btn.addEventListener('click', function() {
            var value = this.getAttribute('data-value');
            
            // Update active state
            searchTypeBtns.forEach(function(b) {
                b.classList.remove('active');
            });
            this.classList.add('active');
            
            // Update hidden input
            if (searchTypeInput) {
                searchTypeInput.value = value;
            }
            
            currentSearchType = value;
            
            // Reload categories for new type
            loadCategories(value);
            loadStyles();
            
            // Clear subcategories
            clearSelect('subcategorySelect');
            clearSelect('subcategorySelectMobile');
        });
    });
    
    // Live Search Functionality
    var searchInputs = [
        { input: document.getElementById('globalSearchInput'), results: document.getElementById('liveSearchResults') },
        { input: document.getElementById('globalSearchInputMobile'), results: document.getElementById('liveSearchResultsMobile') }
    ];
    
    searchInputs.forEach(function(item) {
        if (!item.input || !item.results) return;
        
        item.input.addEventListener('input', function() {
            var query = this.value.trim();
            
            clearTimeout(searchTimeout);
            
            if (query.length < searchConfig.minChars) {
                item.results.style.display = 'none';
                return;
            }
            
            // Show loading
            item.results.style.display = 'block';
            item.results.querySelector('.search-results-loading').style.display = 'block';
            item.results.querySelector('.search-results-list').innerHTML = '';
            item.results.querySelector('.search-results-empty').style.display = 'none';
            
            searchTimeout = setTimeout(function() {
                performLiveSearch(query, item.results);
            }, searchConfig.debounceTime);
        });
        
        // Hide results on blur (with delay for click)
        item.input.addEventListener('blur', function() {
            setTimeout(function() {
                item.results.style.display = 'none';
            }, 200);
        });
        
        // Show results on focus if has content
        item.input.addEventListener('focus', function() {
            if (item.results.querySelector('.search-results-list').innerHTML !== '') {
                item.results.style.display = 'block';
            }
        });
    });
    
    // Perform Live Search
    function performLiveSearch(query, resultsContainer) {
        var emirateId = document.getElementById('emirateSelect') ? document.getElementById('emirateSelect').value : '';
        
        var url = searchConfig.liveSearchUrl + '?q=' + encodeURIComponent(query) + 
                  '&type=' + currentSearchType + 
                  '&emirate_id=' + emirateId +
                  '&limit=5';
        
        fetch(url)
            .then(function(response) { return response.json(); })
            .then(function(data) {
                resultsContainer.querySelector('.search-results-loading').style.display = 'none';
                
                if (data.success && data.results.length > 0) {
                    var html = '';
                    data.results.forEach(function(item) {
                        html += '<a href="' + item.url + '" class="search-result-item">';
                        html += '<div class="search-result-image">';
                        if (item.image) {
                            html += '<img src="' + item.image + '" alt="">';
                        } else {
                            html += '<div class="no-image"><i class="fas fa-image"></i></div>';
                        }
                        html += '</div>';
                        html += '<div class="search-result-content">';
                        html += '<div class="search-result-title">' + item.title + '</div>';
                        html += '<div class="search-result-meta">';
                        html += '<span class="search-result-type ' + item.type + '">' + item.type_label + '</span>';
                        if (item.category) {
                            html += '<span>' + item.category + '</span>';
                        }
                        if (item.code) {
                            html += '<span>' + item.code + '</span>';
                        }
                        html += '</div>';
                        html += '</div>';
                        html += '</a>';
                    });
                    
                    resultsContainer.querySelector('.search-results-list').innerHTML = html;
                    resultsContainer.querySelector('.search-results-empty').style.display = 'none';
                    
                    // Show footer if more results
                    var footer = resultsContainer.querySelector('.search-results-footer');
                    if (footer && data.total > 5) {
                        footer.style.display = 'block';
                    }
                } else {
                    resultsContainer.querySelector('.search-results-list').innerHTML = '';
                    resultsContainer.querySelector('.search-results-empty').style.display = 'block';
                }
            })
            .catch(function(error) {
                console.error('Search error:', error);
                resultsContainer.querySelector('.search-results-loading').style.display = 'none';
            });
    }
    
    // Load Categories based on search type
    function loadCategories(type) {
        var url = searchConfig.categoriesUrl + '?type=' + type;
        
        fetch(url)
            .then(function(response) { return response.json(); })
            .then(function(data) {
                if (data.success) {
                    updateSelect('categorySelect', data.categories, '<?php echo e(__("lang.all_categories")); ?>');
                    updateSelect('categorySelectMobile', data.categories, '<?php echo e(__("lang.all_categories")); ?>');
                }
            });
    }
    
    // Load Subcategories based on category
    function loadSubcategories(categoryId) {
        if (!categoryId) {
            clearSelect('subcategorySelect');
            clearSelect('subcategorySelectMobile');
            return;
        }
        
        var url = searchConfig.subcategoriesUrl + '?type=' + currentSearchType + '&category_id=' + categoryId;
        
        fetch(url)
            .then(function(response) { return response.json(); })
            .then(function(data) {
                if (data.success) {
                    updateSelect('subcategorySelect', data.subcategories, '<?php echo e(__("lang.all_subcategories")); ?>');
                    updateSelect('subcategorySelectMobile', data.subcategories, '<?php echo e(__("lang.all_subcategories")); ?>');
                }
            });
    }
    
    // Load Styles
    function loadStyles() {
        fetch(searchConfig.stylesUrl)
            .then(function(response) { return response.json(); })
            .then(function(data) {
                if (data.success) {
                    updateSelect('styleSelect', data.styles, '<?php echo e(__("lang.all_styles")); ?>');
                    updateSelect('styleSelectMobile', data.styles, '<?php echo e(__("lang.all_styles")); ?>');
                }
            });
    }
    
    // Update Select Element
    function updateSelect(selectId, items, defaultText) {
        var select = document.getElementById(selectId);
        if (!select) return;
        
        var currentValue = select.value;
        select.innerHTML = '<option value="">' + defaultText + '</option>';
        
        items.forEach(function(item) {
            var option = document.createElement('option');
            option.value = item.id;
            option.textContent = item.name;
            if (item.id == currentValue) {
                option.selected = true;
            }
            select.appendChild(option);
        });
        
        // Refresh selectpicker if using Bootstrap Select
        if (typeof $.fn.selectpicker !== 'undefined') {
            $(select).selectpicker('refresh');
        }
    }
    
    // Clear Select Element
    function clearSelect(selectId) {
        var select = document.getElementById(selectId);
        if (!select) return;
        
        select.innerHTML = '<option value=""><?php echo e(__("lang.all_subcategories")); ?></option>';
        
        if (typeof $.fn.selectpicker !== 'undefined') {
            $(select).selectpicker('refresh');
        }
    }
    
    // Category Change Handler
    var categorySelects = ['categorySelect', 'categorySelectMobile'];
    categorySelects.forEach(function(id) {
        var select = document.getElementById(id);
        if (select) {
            select.addEventListener('change', function() {
                loadSubcategories(this.value);
            });
        }
    });
    
    // Emirate Change Handler - Redirect to listing page with emirate filter
    function handleEmirateChange(emirateId) {
        var currentUrl = new URL(window.location.href);
        
        // Check if we're on a listing page
        var isOffersPage = currentUrl.pathname.includes('/offers');
        var isProjectsPage = currentUrl.pathname.includes('/projects');
        
        if (isOffersPage || isProjectsPage) {
            // Update URL with emirate filter
            if (emirateId) {
                currentUrl.searchParams.set('emirate_id', emirateId);
            } else {
                currentUrl.searchParams.delete('emirate_id');
            }
            window.location.href = currentUrl.toString();
        }
    }
    
    // Use jQuery for Bootstrap selectpicker compatibility
    if (typeof $ !== 'undefined') {
        // Global search emirate selector
        $('#emirateSelect, #emirateSelectMobile').on('changed.bs.select change', function() {
            handleEmirateChange($(this).val());
        });
        
        // Also sync with filter sidebar emirate selector (if exists)
        $('.filter-emirate-select').on('changed.bs.select change', function() {
            var emirateId = $(this).val();
            // Sync global search selector
            $('#emirateSelect, #emirateSelectMobile').val(emirateId);
            if (typeof $.fn.selectpicker !== 'undefined') {
                $('#emirateSelect, #emirateSelectMobile').selectpicker('refresh');
            }
        });
        
        // Refresh selectpicker to show selected value from URL
        setTimeout(function() {
            if (typeof $.fn.selectpicker !== 'undefined') {
                $('#emirateSelect, #emirateSelectMobile').selectpicker('refresh');
            }
        }, 100);
    } else {
        // Fallback for vanilla JS
        var emirateSelects = document.querySelectorAll('#emirateSelect, #emirateSelectMobile');
        emirateSelects.forEach(function(select) {
            select.addEventListener('change', function() {
                handleEmirateChange(this.value);
            });
        });
    }
    
    // Mobile Search Type Change
    var searchTypeMobile = document.getElementById('searchTypeMobile');
    if (searchTypeMobile) {
        searchTypeMobile.addEventListener('change', function() {
            currentSearchType = this.value;
            loadCategories(this.value);
            clearSelect('subcategorySelectMobile');
        });
    }
    
    // Sync global search emirate with filter sidebar emirate on page load
    function syncEmirateSelectors() {
        var urlParams = new URLSearchParams(window.location.search);
        var emirateIdFromUrl = urlParams.get('emirate_id');
        
        if (typeof $ !== 'undefined') {
            if (emirateIdFromUrl) {
                // Update global search selectors
                $('#emirateSelect, #emirateSelectMobile').val(emirateIdFromUrl);
                
                // Also update filter sidebar emirate selector if exists
                $('.filter-emirate-select').val(emirateIdFromUrl);
            }
            
            // Refresh all selectpickers
            if (typeof $.fn.selectpicker !== 'undefined') {
                $('.filter-emirate-select').selectpicker('refresh');
                $('#emirateSelect, #emirateSelectMobile').selectpicker('refresh');
            }
        }
    }
    
    // Initial Load
    loadCategories(currentSearchType);
    loadStyles();
    
    // Sync emirates after a short delay to ensure selectpickers are initialized
    setTimeout(syncEmirateSelectors, 200);
    
    // Initialize Area Size Slider (jQuery UI)
    function initGlobalAreaSlider() {
        if (typeof $ !== 'undefined' && typeof $.fn.slider !== 'undefined') {
            // Get values from URL if present
            var urlParams = new URLSearchParams(window.location.search);
            var minVal = parseInt(urlParams.get('sqft_min')) || 0;
            var maxVal = parseInt(urlParams.get('sqft_max')) || 50000;
            
            $("#global-sqft-slider").slider({
                range: true,
                min: 0,
                max: 50000,
                step: 100,
                values: [minVal, maxVal],
                slide: function(event, ui) {
                    updateSqftDisplay(ui.values[0], ui.values[1]);
                },
                change: function(event, ui) {
                    updateSqftDisplay(ui.values[0], ui.values[1]);
                }
            });
            
            // Initial display
            updateSqftDisplay(minVal, maxVal);
        }
    }
    
    function updateSqftDisplay(min, max) {
        var sqftText = '<?php echo e(__("lang.sqft")); ?>';
        $('#global-sqft-display').text(min.toLocaleString() + ' ' + sqftText + ' - ' + max.toLocaleString() + ' ' + sqftText);
        
        // Only set hidden inputs if values differ from default
        $('#global_sqft_min').val(min > 0 ? min : '');
        $('#global_sqft_max').val(max < 50000 ? max : '');
    }
    
    // Initialize slider after a short delay to ensure jQuery UI is loaded
    setTimeout(initGlobalAreaSlider, 300);
});
</script>
<?php /**PATH C:\wamp64\www\smartvisionuae\resources\views/includes/search.blade.php ENDPATH**/ ?>