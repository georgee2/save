@if($project->specifications && $project->specifications->count() > 0)
<section class="mt-2 pb-6 px-6 pt-5 bg-white rounded-lg">
                <h4 class="fs-22 text-heading mb-4">{{ __('lang.specifications') }}</h4>
                <div class="row">
                  @foreach($project->specifications as $spec)
                  @if($spec->specification)
                  <div class="col-sm-6 col-md-4 mb-4">
                    <div class="d-flex align-items-center">
                      <div class="p-2 shadow-xxs-1 rounded-lg mr-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; min-width: 48px;">
                        @if($spec->specification->icon)
                        <img src="{{ url('/storage' . $spec->specification->icon) }}" 
                             alt="{{ app()->getLocale() == 'ar' ? $spec->specification->title_arabic : $spec->specification->title_english }}"
                             style="width: 28px; height: 28px; object-fit: contain;">
                        @else
                        <span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-primary text-white" 
                              style="width: 28px; height: 28px; font-size: 12px; font-weight: 600;">
                            {{ mb_substr(app()->getLocale() == 'ar' ? $spec->specification->title_arabic : $spec->specification->title_english, 0, 1) }}
                        </span>
                        @endif
                      </div>
                      <div>
                        <h5 class="fs-14 font-weight-500 text-muted mb-1">
                          {{ app()->getLocale() == 'ar' ? $spec->specification->title_arabic : $spec->specification->title_english }}
                        </h5>
                        <p class="mb-0 fs-15 font-weight-bold text-heading">
                          {{ app()->getLocale() == 'ar' ? $spec->value_arabic : $spec->value_english }}
                        </p>
                      </div>
                    </div>
                  </div>
                  @endif
                  @endforeach
                </div>
              </section>
@endif
