@if($project->site_image || $project->plan_3d_image)
<section class="mt-2 pb-6 px-6 pt-5 bg-white rounded-lg">
                <h4 class="fs-22 text-heading mb-4">{{ __('lang.site_plan_3d') }}</h4>
                
                {{-- Project Bio --}}
                @if(app()->getLocale() == 'ar' && $project->bio_arabic)
                <p class="text-muted mb-5 lh-2">{!! $project->bio_arabic !!}</p>
                @elseif($project->bio_english)
                <p class="text-muted mb-5 lh-2">{!! $project->bio_english !!}</p>
                @endif
                
                <div class="row">
                  {{-- Site Image --}}
                  @if($project->site_image)
                  <div class="col-md-{{ $project->plan_3d_image ? '6' : '12' }} mb-4">
                    <div class="position-relative rounded-lg overflow-hidden">
                      <a href="{{ url('/storage' . $project->site_image) }}" 
                         data-gtf-mfp="true" 
                         data-gallery-id="site-plan-gallery"
                         class="d-block">
                        <img src="{{ url('/storage' . $project->site_image) }}" 
                             alt="{{ __('lang.site_image') }}" 
                             class="w-100 rounded-lg"
                             style="object-fit: cover; max-height: 400px;">
                        <div class="position-absolute d-flex align-items-center justify-content-center" 
                             style="bottom: 15px; left: 15px; background: rgba(0,0,0,0.7); padding: 8px 16px; border-radius: 6px;">
                          <i class="fal fa-map text-white mr-2"></i>
                          <span class="text-white font-weight-500 fs-14">{{ __('lang.site_image') }}</span>
                        </div>
                        <div class="position-absolute d-flex align-items-center justify-content-center hover-overlay" 
                             style="top: 0; left: 0; right: 0; bottom: 0; background: rgba(25,134,139,0.3); opacity: 0; transition: opacity 0.3s;">
                          <i class="fal fa-search-plus text-white fs-40"></i>
                        </div>
                      </a>
                    </div>
                  </div>
                  @endif
                  
                  {{-- 3D Image --}}
                  @if($project->plan_3d_image)
                  <div class="col-md-{{ $project->site_image ? '6' : '12' }} mb-4">
                    <div class="position-relative rounded-lg overflow-hidden">
                      <a href="{{ url('/storage' . $project->plan_3d_image) }}" 
                         data-gtf-mfp="true" 
                         data-gallery-id="site-plan-gallery"
                         class="d-block">
                        <img src="{{ url('/storage' . $project->plan_3d_image) }}" 
                             alt="{{ __('lang.3d_image') }}" 
                             class="w-100 rounded-lg"
                             style="object-fit: cover; max-height: 400px;">
                        <div class="position-absolute d-flex align-items-center justify-content-center" 
                             style="bottom: 15px; left: 15px; background: rgba(0,0,0,0.7); padding: 8px 16px; border-radius: 6px;">
                          <i class="fal fa-cube text-white mr-2"></i>
                          <span class="text-white font-weight-500 fs-14">{{ __('lang.3d_image') }}</span>
                        </div>
                        <div class="position-absolute d-flex align-items-center justify-content-center hover-overlay" 
                             style="top: 0; left: 0; right: 0; bottom: 0; background: rgba(25,134,139,0.3); opacity: 0; transition: opacity 0.3s;">
                          <i class="fal fa-search-plus text-white fs-40"></i>
                        </div>
                      </a>
                    </div>
                  </div>
                  @endif
                </div>
              </section>

<style>
.hover-overlay {
    opacity: 0;
    transition: opacity 0.3s ease;
}
.position-relative:hover .hover-overlay {
    opacity: 1 !important;
}
</style>
@endif

