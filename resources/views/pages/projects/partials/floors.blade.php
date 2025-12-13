@if($project->floors && $project->floors->count() > 0)
<!-- start: Project Floors Section -->
<section class="tj-floors-section ">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <h3 class="section-header wow fadeInUp" data-wow-delay=".3s">
          <img src="{{url('/pic/svg40.svg')}}">
          {{ __('lang.project_floors') }}
        </h3>
        
        <!-- Floors Tabs -->
        <ul class="nav nav-tabs" id="floorsTab" role="tablist">
          @foreach($project->floors as $index => $floor)
          <li class="nav-item" role="presentation">
            <button class="nav-link {{ $index == 0 ? 'active' : '' }}" id="floor-{{ $floor->id }}-tab" data-bs-toggle="tab" data-bs-target="#floor-{{ $floor->id }}" type="button" role="tab" aria-controls="floor-{{ $floor->id }}" aria-selected="{{ $index == 0 ? 'true' : 'false' }}">
              <div class="floor-tab-content">
                @if($floor->floorComponent)
                <h6 class="floor-name">
                  @if(App::getLocale() == 'en')
                    {{ $floor->floorComponent->name_english }}
                  @else
                    {{ $floor->floorComponent->name_arabic }}
                  @endif
                </h6>
                @endif
                @if($floor->sqft || $floor->sqm)
                <div class="floor-areas">
                  @if($floor->sqft)
                  <span class="area-item">
                    <i class="fa fa-expand"></i> {{ number_format($floor->sqft, 2) }} ft²
                  </span>
                  @endif
                  @if($floor->sqm)
                  <span class="area-item">
                    <i class="fa fa-expand"></i> {{ number_format($floor->sqm, 2) }} m²
                  </span>
                  @endif
                </div>
                @endif
              </div>
            </button>
          </li>
          @endforeach
        </ul>
        
        <!-- Floors Tab Content -->
        <div class="tab-content" id="floorsTabContent">
          @foreach($project->floors as $index => $floor)
          <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}" id="floor-{{ $floor->id }}" role="tabpanel" aria-labelledby="floor-{{ $floor->id }}-tab">
            <div class="floor-content">
              
              <!-- Floor Images -->
              @if($floor->image_3d || $floor->image_2d)
              <div class="floor-images-section" style="margin-bottom: 40px;">
                <div class="row">
                  <!-- 3D Visualization -->
                  @if($floor->image_3d)
                  <div class="col-md-6 mb-4">
                    <h5 class="floor-section-title">
                      @if(App::getLocale() == 'en')
                        3D Visualization
                      @else
                        التصور ثلاثي الأبعاد
                      @endif
                    </h5>
                    <div class="floor-image-box">
                      <a class="gallery" data-gall="floor-{{ $floor->id }}" href="{{ asset('storage/' . $floor->image_3d) }}">
                        <img src="{{ asset('storage/' . $floor->image_3d) }}" alt="3D Visualization" style="width: 100%; height: auto; border-radius: 10px;">
                      </a>
                    </div>
                  </div>
                  @endif
                  
                  <!-- 2D Floor Plan -->
                  @if($floor->image_2d)
                  <div class="col-md-6 mb-4">
                    <h5 class="floor-section-title">
                      @if(App::getLocale() == 'en')
                        2D Floor Plan
                      @else
                        مخطط الطابق ثنائي الأبعاد
                      @endif
                    </h5>
                    <div class="floor-image-box">
                      <a class="gallery" data-gall="floor-{{ $floor->id }}" href="{{ asset('storage/' . $floor->image_2d) }}">
                        <img src="{{ asset('storage/' . $floor->image_2d) }}" alt="2D Floor Plan" style="width: 100%; height: auto; border-radius: 10px;">
                      </a>
                    </div>
                  </div>
                  @endif
                </div>
              </div>
              @endif
              
              <!-- Floor Specifications -->
              @if($floor->specifications && $floor->specifications->count() > 0)
              <div class="floor-specifications-section" style="margin-bottom: 40px;">
                <h5 class="floor-section-title">
                  @if(App::getLocale() == 'en')
                    Floor Specifications
                  @else
                    مواصفات الطابق
                  @endif
                </h5>
                <div class="row">
                  @foreach($floor->specifications as $floorSpec)
                    @if($floorSpec->specification)
                    <div class="col-md-6 col-lg-4 mb-3">
                      <div class="floor-spec-item" style="display: flex; align-items: center; padding: 15px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 10px; transition: all 0.3s ease;">
                        @if($floorSpec->specification->icon)
                        <div class="spec-icon" style="width: 50px; height: 50px; border-radius: 50%; background: linear-gradient(135deg, #e8f4f8 0%, #d4e9f2 100%); display: flex; align-items: center; justify-content: center; margin-right: 12px; flex-shrink: 0;">
                          <img src="{{ asset('storage' . $floorSpec->specification->icon) }}" alt="{{ App::getLocale() == 'en' ? $floorSpec->specification->title_english : $floorSpec->specification->title_arabic }}" style="width: 30px; height: 30px; object-fit: contain;">
                        </div>
                        @else
                        <div class="spec-icon" style="width: 50px; height: 50px; border-radius: 50%; background: linear-gradient(135deg, #e8f4f8 0%, #d4e9f2 100%); display: flex; align-items: center; justify-content: center; margin-right: 12px; flex-shrink: 0;">
                          <i class="tji-check" style="font-size: 20px; color: #ff5722;"></i>
                        </div>
                        @endif
                        <div class="spec-text" style="flex: 1;">
                          <h6 style="margin: 0; font-size: 13px; font-weight: 600; color: #1a1a1a; line-height: 1.3;">
                            @if(App::getLocale() == 'en')
                              {{ $floorSpec->specification->title_english }}
                            @else
                              {{ $floorSpec->specification->title_arabic }}
                            @endif
                          </h6>
                          @if($floorSpec->value_english || $floorSpec->value_arabic)
                          <p style="margin: 3px 0 0 0; font-size: 11px; color: #666; line-height: 1.2;">
                            @if(App::getLocale() == 'en')
                              {{ $floorSpec->value_english }}
                            @else
                              {{ $floorSpec->value_arabic }}
                            @endif
                          </p>
                          @endif
                        </div>
                      </div>
                    </div>
                    @endif
                  @endforeach
                </div>
              </div>
              @endif
              
              <!-- Floor Amenities -->
              @if($floor->amenities && $floor->amenities->count() > 0)
              <div class="floor-amenities-section">
                <h5 class="floor-section-title">
                  @if(App::getLocale() == 'en')
                    Floor Amenities
                  @else
                    وسائل الراحة في الطابق
                  @endif
                </h5>
                <div class="row">
                  @foreach($floor->amenities as $floorAmenity)
                    @if($floorAmenity->amenity)
                    <div class="col-md-6 col-lg-4 mb-3">
                      <div class="floor-amenity-item" style="display: flex; align-items: center; padding: 15px; background: linear-gradient(135deg, #f0f8ff 0%, #e0f2ff 100%); border-radius: 10px; transition: all 0.3s ease;">
                        @if($floorAmenity->amenity->icon)
                        <div class="amenity-icon" style="width: 50px; height: 50px; border-radius: 50%; background: linear-gradient(135deg, #d4e9f2 0%, #c0e0f0 100%); display: flex; align-items: center; justify-content: center; margin-right: 12px; flex-shrink: 0;">
                          <img src="{{ asset('storage' . $floorAmenity->amenity->icon) }}" alt="{{ App::getLocale() == 'en' ? $floorAmenity->amenity->name_english : $floorAmenity->amenity->name_arabic }}" style="width: 30px; height: 30px; object-fit: contain;">
                        </div>
                        @else
                        <div class="amenity-icon" style="width: 50px; height: 50px; border-radius: 50%; background: linear-gradient(135deg, #d4e9f2 0%, #c0e0f0 100%); display: flex; align-items: center; justify-content: center; margin-right: 12px; flex-shrink: 0;">
                          <i class="fa fa-star" style="font-size: 20px; color: #ff5722;"></i>
                        </div>
                        @endif
                        <div class="amenity-text" style="flex: 1;">
                          <h6 style="margin: 0; font-size: 13px; font-weight: 600; color: #1a1a1a; line-height: 1.3;">
                            @if(App::getLocale() == 'en')
                              {{ $floorAmenity->amenity->name_english }}
                            @else
                              {{ $floorAmenity->amenity->name_arabic }}
                            @endif
                          </h6>
                        </div>
                      </div>
                    </div>
                    @endif
                  @endforeach
                </div>
              </div>
              @endif
              
            </div>
          </div>
          @endforeach
        </div>
        
      </div>
    </div>
  </div>
</section>
<!-- end: Project Floors Section -->

<style>
/* Floor Tabs Styling */
.nav-tabs {
  border-bottom: 2px solid #e9ecef;
  margin-bottom: 30px;
}

.nav-tabs .nav-link {
  border: none;
  border-bottom: 3px solid transparent;
  color: #666;
  padding: 15px 20px;
  transition: all 0.3s ease;
  background: transparent;
}

.nav-tabs .nav-link:hover {
  border-color: #ff5722;
  color: #ff5722;
}

.nav-tabs .nav-link.active {
  border-color: #ff5722;
  color: #ff5722;
  background: transparent;
  font-weight: 600;
}

.floor-tab-content .floor-name {
  margin: 0 0 5px 0;
  font-size: 16px;
  font-weight: 600;
}

.floor-tab-content .floor-areas {
  display: flex;
  gap: 15px;
  font-size: 12px;
  color: #666;
}

.floor-tab-content .area-item {
  display: inline-flex;
  align-items: center;
  gap: 5px;
}

.floor-section-title {
  font-size: 18px;
  font-weight: 600;
  color: #1a1a1a;
  margin-bottom: 20px;
  padding-bottom: 10px;
  border-bottom: 2px solid #e9ecef;
}

.floor-image-box {
  position: relative;
  overflow: hidden;
  border-radius: 10px;
  box-shadow: 0 3px 10px rgba(0,0,0,0.1);
  transition: all 0.3s ease;
}

.floor-image-box:hover {
  transform: translateY(-5px);
  box-shadow: 0 5px 20px rgba(0,0,0,0.15);
}

.floor-spec-item:hover,
.floor-amenity-item:hover {
  background: linear-gradient(135deg, #ff5722 0%, #ff7043 100%) !important;
  transform: translateY(-3px);
  box-shadow: 0 5px 15px rgba(255, 87, 34, 0.3);
}

.floor-spec-item:hover .spec-icon,
.floor-amenity-item:hover .amenity-icon {
  background: rgba(255, 255, 255, 0.2) !important;
  transform: scale(1.1);
}

.floor-spec-item:hover .spec-icon img,
.floor-amenity-item:hover .amenity-icon img {
  filter: brightness(0) invert(1);
}

.floor-spec-item:hover .spec-icon i,
.floor-amenity-item:hover .amenity-icon i {
  color: #fff !important;
}

.floor-spec-item:hover .spec-text h6,
.floor-spec-item:hover .spec-text p,
.floor-amenity-item:hover .amenity-text h6 {
  color: #fff !important;
}

.tab-content {
  padding: 20px 0;
}
</style>
@endif
