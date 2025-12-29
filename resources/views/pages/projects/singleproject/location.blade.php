{{-- Project Attachments Section - Hidden until attachment system is implemented --}}
{{-- 
@if($project->attachments && $project->attachments->count() > 0)
<section class="mt-2 pb-7 px-6 pt-6 bg-white rounded-lg">
    <h4 class="fs-22 text-heading mb-6">{{ __('lang.property_attachments') }}</h4>
    <div class="d-sm-flex flex-wrap">
        @foreach($project->attachments as $attachment)
        <div class="w-sm-170 mb-sm-0 mb-6 mr-sm-6">
            <div class="card text-center pt-4">
                @php
                    $extension = pathinfo($attachment->file, PATHINFO_EXTENSION);
                    $icon = 'images/file-icon.png';
                    if(in_array($extension, ['pdf'])) $icon = 'images/pdf-icon.png';
                    elseif(in_array($extension, ['doc', 'docx'])) $icon = 'images/word-icon.png';
                    elseif(in_array($extension, ['xls', 'xlsx'])) $icon = 'images/excel-icon.png';
                @endphp
                <img src="{{ asset($icon) }}" class="card-img card-img w-78px mx-auto" alt="{{ $attachment->title }}">
                <div class="card-body p-0 mt-4">
                    <p class="fs-13 lh-2 mb-0 py-0 px-2">{{ app()->getLocale() == 'ar' ? $attachment->title_arabic : $attachment->title_english }}</p>
                    <a href="{{ url('/storage' . $attachment->file) }}" download
                       class="btn btn-block bg-gray-01 border-0 fs-14 text-heading">
                        {{ __('lang.download') }}<i class="far fa-arrow-alt-circle-down ml-1 text-primary"></i>
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>
@endif
--}}

{{-- Virtual Tour Section --}}
@if($project->tour_url)
<section class="mt-2 pb-6 px-6 pt-6 bg-white rounded-lg">
    <h4 class="fs-22 text-heading mb-6">{{ __('lang.virtual_tour') }}</h4>
    <div class="embed-responsive embed-responsive-16by9 rounded-lg overflow-hidden">
        <iframe class="embed-responsive-item" 
                src="{{ $project->tour_url }}" 
                allowfullscreen></iframe>
    </div>
</section>
@endif

{{-- Video Section --}}
@if($project->video_url)
<section class="mt-2 pb-6 px-6 pt-6 bg-white rounded-lg">
    <h4 class="fs-22 text-heading mb-6">{{ __('lang.project_video') }}</h4>
    <div class="embed-responsive embed-responsive-16by9 rounded-lg overflow-hidden">
        @php
            // Convert YouTube URLs to embed format
            $videoUrl = $project->video_url;
            if (preg_match('/youtube\.com\/watch\?v=([^\&\?\/]+)/', $videoUrl, $matches)) {
                $videoUrl = 'https://www.youtube.com/embed/' . $matches[1];
            } elseif (preg_match('/youtu\.be\/([^\&\?\/]+)/', $videoUrl, $matches)) {
                $videoUrl = 'https://www.youtube.com/embed/' . $matches[1];
            } elseif (preg_match('/vimeo\.com\/([^\&\?\/]+)/', $videoUrl, $matches)) {
                $videoUrl = 'https://player.vimeo.com/video/' . $matches[1];
            }
        @endphp
        <iframe class="embed-responsive-item" 
                src="{{ $videoUrl }}" 
                allowfullscreen></iframe>
    </div>
</section>
@endif

{{-- Location Section - Hidden for now --}}
{{--
<section class="mt-2 pb-6 px-6 pt-6 bg-white rounded-lg">
    <h4 class="fs-22 text-heading mb-6">{{ __('lang.location') }}</h4>
    <div class="position-relative">
        <div class="position-relative">
            <div id="map" class="mapbox-gl map-point-animate"
                 data-mapbox-access-token="pk.eyJ1IjoiZHVvbmdsaCIsImEiOiJjanJnNHQ4czExMzhyNDVwdWo5bW13ZmtnIn0.f1bmXQsS6o4bzFFJc8RCcQ"
                 data-mapbox-options='{"center":[-73.9927227, 40.6741035],"setLngLat":[-73.9927227, 40.6741035]}'
                 data-mapbox-marker='[{"position":[-73.9927227, 40.6741035],"className":"marker","backgroundImage":"images/googlle-market-01.png","backgroundRepeat":"no-repeat","width":"30px","height":"40px"}]'>
            </div>
            @if($project->emirate)
            <p class="mb-0 p-3 bg-white shadow rounded-lg position-absolute pos-fixed-bottom mb-4 ml-4 lh-17 z-index-2">
                {{ app()->getLocale() == 'ar' ? $project->emirate->title_arabic : $project->emirate->title_english }}
            </p>
            @endif
        </div>
    </div>
</section>
--}}
