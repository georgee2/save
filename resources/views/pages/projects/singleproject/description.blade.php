<section class="pb-8 px-6 pt-5 bg-white rounded-lg">
                <h4 class="fs-22 text-heading mb-3">{{ __('lang.description') }}</h4>
                @if(app()->getLocale() == 'ar')
                  @if($project->bio_arabic)
                  <p class="mb-0 lh-214">{!! $project->bio_arabic !!}</p>
                  @else
                  <p class="mb-0 lh-214 text-muted">{{ __('lang.no_description') }}</p>
                  @endif
                @else
                  @if($project->bio_english)
                  <p class="mb-0 lh-214">{!! $project->bio_english !!}</p>
                  @else
                  <p class="mb-0 lh-214 text-muted">{{ __('lang.no_description') }}</p>
                  @endif
                @endif
              </section>
