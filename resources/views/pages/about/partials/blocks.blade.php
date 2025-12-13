<!-- start: Custom Blocks Section -->
@if($customBlocks->count() > 0)
@foreach($customBlocks as $index => $block)
<section class="tj-faq-section section-gap tj-arrange-container-2">
  <div class="container">
    <div class="row justify-content-between {{ $index % 2 != 0 ? 'flex-row-reverse' : '' }}">
      <div class="col-lg-6">
        <div class="faq-img-area tj-arrange-item-2">
          @if($block->image)
          <div class="faq-img overflow-hidden">
            <img src="{{ asset('storage/' . $block->image) }}" alt="{{ App::getLocale() == 'en' ? $block->title_english : $block->title_arabic }}">
          </div>
          @endif
        </div>
      </div>
      <div class="col-lg-6">
        <div class="tj-arrange-item-2">
          <div class="sec-heading style-8">
            <h2 class="sec-title title-anim">{{ App::getLocale() == 'en' ? $block->title_english : $block->title_arabic }}</h2>
            <div class="title-underline-with-logo">
              <span class="underline-left"></span>
              <img src="{{url('/pic/logosvg.svg')}}" alt="Logo" class="logo-center">
              <span class="underline-right"></span>
            </div>
          </div>
          <div class="about-content wow fadeInUp" data-wow-delay=".5s">
            <p>{!! App::getLocale() == 'en' ? nl2br(e($block->description_english)) : nl2br(e($block->description_arabic)) !!}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endforeach

<style>
.title-underline-with-logo {
  display: flex;
  align-items: center;
  gap: 15px;
  margin-top: 20px;
  margin-bottom: 25px;
}

.underline-left,
.underline-right {
  flex: 1;
  height: 2px;
  background: linear-gradient(90deg, #ff6b35 0%, rgba(255, 107, 53, 0.3) 100%);
}

.underline-right {
  background: linear-gradient(270deg, #ff6b35 0%, rgba(255, 107, 53, 0.3) 100%);
}

.logo-center {
  width: 40px;
  height: 40px;
  object-fit: contain;
}
</style>
@endif
<!-- end: Custom Blocks Section -->

