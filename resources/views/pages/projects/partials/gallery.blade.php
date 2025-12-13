@php
  // Get project gallery images
  $galleryImages = \App\Models\ProjectImage::where('project_id', $project->id)
                                            ->orderBy('created_at', 'DESC')
                                            ->get();
@endphp

@if($galleryImages && $galleryImages->count() > 0)
<!-- start: Project Gallery Section -->
<section class="tj-gallery-section" style="padding: 60px 0;">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <h3 class="section-header wow fadeInUp" data-wow-delay=".3s">
          <img src="{{url('/pic/svg40.svg')}}">
          {{ __('lang.project_gallery') }}
        </h3>
        <p class="wow fadeInUp" data-wow-delay=".3s" style="margin-bottom: 40px; color: #666;">
          {{ __('lang.explore_project_details') }}
        </p>
        
        <div class="row">
          @foreach($galleryImages as $index => $image)
          <div class="col-md-6 col-lg-6 mb-4">
            <div class="gallery-item wow fadeInUp" data-wow-delay=".{{ ($index + 1) * 1 }}s">
              <a class="gallery" data-gall="project-gallery" href="{{ asset('storage' . $image->image) }}">
                <img src="{{ asset('storage' . $image->image) }}" 
                     alt="Project Gallery Image {{ $index + 1 }}" 
                     style="width: 100%; height: auto; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); transition: all 0.3s ease;">
              </a>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</section>
<!-- end: Project Gallery Section -->

<style>
  .gallery-item {
    position: relative;
    overflow: hidden;
    border-radius: 10px;
  }
  
  .gallery-item img {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }
  
  .gallery-item:hover img {
    transform: scale(1.05);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
  }
  
  .gallery-item a {
    display: block;
    position: relative;
  }
  
  .gallery-item a::before {
    content: '\f002';
    font-family: 'FontAwesome';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 32px;
    color: white;
    opacity: 0;
    transition: opacity 0.3s ease;
    z-index: 2;
  }
  
  .gallery-item a::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(255, 87, 34, 0.8);
    opacity: 0;
    transition: opacity 0.3s ease;
    border-radius: 10px;
  }
  
  .gallery-item:hover a::before,
  .gallery-item:hover a::after {
    opacity: 1;
  }
</style>
@endif

