<!-- Portfolio Gallery Section -->
<div class="portfolio-gallery-section wow fadeInUp" data-wow-delay=".7s">
  <h3 class="section-header">
    <img src="{{url('/pic/svg40.svg')}}">
    {{ __('lang.project_gallery') }}
  </h3>
  
  <div class="gallery-grid">
    @foreach($portfolio->images as $index => $image)
      <div class="gallery-item wow fadeInUp" data-wow-delay="{{ 0.1 + (($index % 3) * 0.1) }}s">
        <a href="{{ asset('storage' . $image->image) }}" 
           data-fancybox="portfolio-gallery" 
           data-caption="@if(App::getLocale() == 'en'){{ $portfolio->title_english }}@else{{ $portfolio->title_arabic }}@endif">
          <img src="{{ asset('storage' . $image->image) }}" 
               alt="@if(App::getLocale() == 'en'){{ $portfolio->title_english }}@else{{ $portfolio->title_arabic }}@endif">
          <div class="gallery-overlay">
            <i class="fa fa-search-plus"></i>
          </div>
        </a>
      </div>
    @endforeach
  </div>
</div>

<style>
.portfolio-gallery-section {
  margin: 50px 0;
  padding: 40px;
  background: white;
  border-radius: 15px;
  box-shadow: 0 5px 20px rgba(0,0,0,0.08);
}

.gallery-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
  gap: 20px;
  margin-top: 30px;
}

.gallery-item {
  position: relative;
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 4px 15px rgba(0,0,0,0.1);
  transition: all 0.3s ease;
  cursor: pointer;
}

.gallery-item:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.gallery-item a {
  display: block;
  position: relative;
  overflow: hidden;
}

.gallery-item img {
  width: 100%;
  height: auto;
  display: block;
  transition: transform 0.5s ease;
}

.gallery-item:hover img {
  transform: scale(1.1);
}

.gallery-overlay {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(255, 87, 34, 0.9);
  display: flex;
  align-items: center;
  justify-content: center;
  opacity: 0;
  transition: opacity 0.3s ease;
}

.gallery-item:hover .gallery-overlay {
  opacity: 1;
}

.gallery-overlay i {
  font-size: 32px;
  color: white;
  transform: scale(0.5);
  transition: transform 0.3s ease;
}

.gallery-item:hover .gallery-overlay i {
  transform: scale(1);
}

@media (max-width: 767px) {
  .portfolio-gallery-section {
    padding: 30px 20px;
  }
  
  .gallery-grid {
    grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
    gap: 15px;
  }
  
  .gallery-overlay i {
    font-size: 24px;
  }
}
</style>

<!-- Fancybox CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />

@section('js')
@parent
<!-- Fancybox JS -->
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
<script>
  // Initialize Fancybox
  Fancybox.bind('[data-fancybox="portfolio-gallery"]', {
    Toolbar: {
      display: {
        left: ["infobar"],
        middle: [],
        right: ["slideshow", "thumbs", "close"],
      },
    },
    Thumbs: {
      autoStart: false,
    },
  });
</script>
@endsection

