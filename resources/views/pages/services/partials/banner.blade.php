@php
    // Get the specific block if blockId is provided
    $block = isset($blockId) ? $service->blocks->firstWhere('id', $blockId) : null;
    
    // If no specific block, show all banner blocks
    $bannersToShow = $block ? collect([$block]) : $service->blocks->where('block_type', 'banner');
@endphp

@if($bannersToShow && $bannersToShow->count() > 0)
  @foreach($bannersToShow as $banner)
  <!-- start: Banner Block Section -->
  <section class="h9-cta-section section-gap-x">
    @if($banner->image)
    <div class="cta-bg" data-bg-image="{{ asset('storage/' . $banner->image) }}" style="background-image: url('{{ asset('storage/' . $banner->image) }}'); background-size: cover; background-position: center;"></div>
    @else
    <div class="cta-bg" data-bg-image="{{ asset('assets/images/cta/h9-cta-bg.webp') }}"></div>
    @endif
    
    <div class="container" style="max-width: 95%; margin: 0 auto;">
      <div class="row">
        <div class="col-12">
          <div class="cta-content">
            <h2 class="title text-anim">
              <span>
                @if(App::getLocale() == 'en')
                  {{ $banner->title_english }}
                @else
                  {{ $banner->title_arabic }}
                @endif
              </span>
              
              @if($banner->description_english || $banner->description_arabic)
              <span style="display: block; font-size: 18px; font-weight: 400; margin-top: 20px; line-height: 1.8;">
                @if(App::getLocale() == 'en')
                  {{ $banner->description_english }}
                @else
                  {{ $banner->description_arabic }}
                @endif
              </span>
              @endif
            </h2>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- end: Banner Block Section -->
  @endforeach
@endif