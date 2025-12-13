<!-- start: Project Section -->
        <section class="tj-project-section-2 section-gap">
          <div class="container">
            <div class="row">
              <div class="col-12">
                <div class="sec-heading style-2 text-center">
                  <span class="sub-title wow fadeInUp" data-wow-delay=".3s"><img src="{{url('/pic/logosvg.svg')}}"> {{ __('lang.proud_projects') }}</span>
                  <h2 class="sec-title text-anim">{{ __('lang.breaking_boundaries_building_dreams') }}</h2>
                </div>
              </div>
            </div>
          </div>
          <div class="container-fluid">
            <div class="row">
              <div class="col-12">
                <div class="project-wrapper wow fadeInUp" data-wow-delay=".5s">
                  <div class="swiper project-slider">
                    <div class="swiper-wrapper">
                      @forelse($engineeringProjects as $project)
                      <div class="swiper-slide">
                        <div class="project-item">
                          <div class="project-img" data-bg-image="{{ asset('storage' . $project->main_image) }}"></div>
                          <div class="project-content">
                            @if($project->category)
                              <span class="categories">
                                <a href="{{ route('projects.show', ['slug' => $project->slug]) }}">
                                  {{ app()->getLocale() == 'ar' ? $project->category->title_arabic : $project->category->title_english }}
                                </a>
                              </span>
                            @endif
                            <div class="project-text">
                              <h3 class="title">
                                <a href="{{ route('projects.show', ['slug' => $project->slug]) }}">
                                  {{ app()->getLocale() == 'ar' ? $project->title_arabic : $project->title_english }}
                                </a>
                              </h3>
                              <a class="project-btn" href="{{ route('projects.show', ['slug' => $project->slug]) }}">
                                <i class="tji-arrow-right-big"></i>
                              </a>
                            </div>
                          </div>
                        </div>
                      </div>
                      @empty
                      <div class="swiper-slide">
                        <div class="project-item">
                          <div class="project-img" data-bg-image="assets/images/project/project-1.webp"></div>
                          <div class="project-content">
                            <span class="categories"><a href="#">No Category</a></span>
                            <div class="project-text">
                              <h3 class="title"><a href="#">No Projects Available</a></h3>
                              <a class="project-btn" href="#">
                                <i class="tji-arrow-right-big"></i>
                              </a>
                            </div>
                          </div>
                        </div>
                      </div>
                      @endforelse
                    </div>
                    <div class="swiper-pagination-area"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
        <!-- end: Project Section -->


        