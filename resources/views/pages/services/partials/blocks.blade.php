@php
    // Get the specific block if blockId is provided
    $block = isset($blockId) ? $service->blocks->firstWhere('id', $blockId) : null;
    
    // If no specific block, show all image_with_text blocks
    $blocksToShow = $block ? collect([$block]) : $service->blocks->where('block_type', 'image_with_text');
@endphp

@if($blocksToShow && $blocksToShow->count() > 0)
  @foreach($blocksToShow as $customBlock)
  <!-- start: Custom Block Section -->
  <section class="h10-about section-gap">
    <div class="container">
      <div class="row flex-column-reverse flex-md-row">
        @if($customBlock->image)
        <div class="col-12 col-lg-5 d-block d-md-none d-lg-block">
          <div class="about-img-area h10-about-banner wow bounceInLeft" data-wow-delay=".3s">
            <div class="about-img overflow-hidden">
              <img data-speed=".8" src="{{ asset('storage/' . $customBlock->image) }}" alt="{{ App::getLocale() == 'en' ? $customBlock->title_english : $customBlock->title_arabic }}">
            </div>
          </div>
        </div>
        @endif
        
        <div class="col-12 {{ $customBlock->image ? 'col-lg-7' : 'col-lg-12' }}">
          <div class="h10-about-content-wrapper">
            <div class="sec-heading style-3">
              <span class="sub-title wow fadeInUp" data-wow-delay=".3s">
                @if(App::getLocale() == 'en')
                  {{ $customBlock->title_english }}
                @else
                  {{ $customBlock->title_arabic }}
                @endif
              </span>
              
              <!-- Decorative Line with Logo -->
              <div class="title-divider-with-logo wow fadeInUp" data-wow-delay=".4s">
                <span class="divider-line divider-line-left"></span>
                <span class="divider-logo">
                  <img src="{{url('/pic/logosvg.svg')}}" alt="Logo">
                </span>
                <span class="divider-line divider-line-right"></span>
              </div>
            </div>
            
            @if($customBlock->image)
            <div class="row d-md-block d-lg-none mb-4">
              <div class="col-12">
                <div class="about-img-area h10-about-banner wow bounceInLeft" data-wow-delay=".3s">
                  <div class="about-img">
                    <img src="{{ asset('storage/' . $customBlock->image) }}" alt="{{ App::getLocale() == 'en' ? $customBlock->title_english : $customBlock->title_arabic }}">
                  </div>
                </div>
              </div>
            </div>
            @endif
            
            <div class="h10-about-content">
              <div class="wow fadeInUp" data-wow-delay=".4s" style="width: 100%;">
                @if($customBlock->description_english || $customBlock->description_arabic)
                <p class="desc wow fadeInUp" data-wow-delay=".4s" style="width: 100%; max-width: 100%;">
                  @if(App::getLocale() == 'en')
                    {{ $customBlock->description_english }}
                  @else
                    {{ $customBlock->description_arabic }}
                  @endif
                </p>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- end: Custom Block Section -->
  @endforeach
@endif