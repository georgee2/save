{{-- Engineering Sub Categories Section --}}
@if(isset($engineeringSubCategories) && $engineeringSubCategories->count() > 0)
<section>
    <div class="bg-gray-02 py-lg-13 pt-11 pb-6">
        <div class="container container-xxl">
            <div class="row">
                <div class="col-lg-4 pr-xl-13" data-animate="fadeInLeft">
                    <h2 class="text-heading lh-1625">
                        {{ __('lang.subcategories_title') }} <br>
                        <span class="text-primary">{{ __('lang.subcategories_title_highlight') }}</span>
                    </h2>
                    <span class="heading-divider"></span>
                    <p class="mb-6">{{ __('lang.subcategories_bio') }}</p>
                    <a href="{{ route('projects.index') }}" class="btn btn-lg text-secondary btn-accent">
                        +{{ $engineeringSubCategories->sum('projects_count') }} {{ __('lang.subcategories_button') }}
                        <i class="far fa-long-arrow-right ml-1"></i>
                    </a>
                </div>
                <div class="col-lg-8" data-animate="fadeInRight">
                    <div class="slick-slider arrow-haft-inner custom-arrow-xxl-hide mx-0"
                        data-slick-options='{"slidesToShow": 4, "autoplay":true,"dots":false,"responsive":[{"breakpoint": 1200,"settings": {"slidesToShow":3,"arrows":false}},{"breakpoint": 992,"settings": {"slidesToShow":3,"arrows":false}},{"breakpoint": 768,"settings": {"slidesToShow": 3,"arrows":false,"autoplay":true}},{"breakpoint": 576,"settings": {"slidesToShow": 2,"arrows":false,"autoplay":true}}]}'>
                        
                        @foreach($engineeringSubCategories as $subCategory)
                        <div class="box px-0 py-6">
                            <a href="{{ route('engineering.subcategory.show', $subCategory->slug) }}"
                                class="card border-0 align-items-center justify-content-center pt-7 pb-5 px-3 shadow-hover-3 bg-transparent bg-hover-white text-decoration-none">
                                @if($subCategory->icon)
                                <img src="{{ url('/storage' . $subCategory->icon) }}" 
                                     class="card-img-top" 
                                     alt="{{ app()->getLocale() == 'ar' ? $subCategory->title_arabic : $subCategory->title_english }}"
                                     style="width: 80px; height: 80px; object-fit: contain;">
                                @else
                                <div class="card-img-top d-flex align-items-center justify-content-center" 
                                     style="width: 80px; height: 80px; background-color: #f0f0f0; border-radius: 8px;">
                                    <i class="fas fa-cogs fa-2x text-primary"></i>
                                </div>
                                @endif
                                <div class="card-body px-0 pt-5 pb-0 text-center">
                                    <h4 class="card-title fs-16 lh-2 text-dark mb-1">
                                        {{ app()->getLocale() == 'ar' ? $subCategory->title_arabic : $subCategory->title_english }}
                                    </h4>
                                    <p class="text-muted fs-13 mb-0">
                                        {{ $subCategory->projects_count }} {{ __('lang.projects') }}
                                    </p>
                                </div>
                            </a>
                        </div>
                        @endforeach
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

