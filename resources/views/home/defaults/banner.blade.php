@if(isset($defaultBanner) && $defaultBanner)
<!-- START: Default Banner Section -->
<section class="tj-default-banner-wrapper" style="
    width: 100%;
    padding: 40px 0;
    display: flex;
    align-items: center;
    justify-content: center;
">
    <div class="tj-default-banner-section" style="
        background-image: url('{{ asset('storage' . $defaultBanner->background) }}'); 
        background-size: cover; 
        background-position: center; 
        background-repeat: no-repeat;
        width: 90%;
        max-width: 1700px;
        height: 492px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
        border-radius: 20px;
    ">
        <!-- Overlay with main color -->
        <div style="
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 90, 0, 0.3);
            z-index: 1;
        "></div>
        
        <!-- Content -->
        <div class="container" style="height: 100%; display: flex; align-items: center; justify-content: center; position: relative; z-index: 2;">
            <div class="row" style="width: 100%;">
                <div class="col-lg-12">
                    <div class="default-banner-content text-center">
                        @if(App::getLocale() == 'ar')
                            <h2 class="sec-title" style="
                                color: #fff; 
                                text-shadow: 2px 2px 8px rgba(0,0,0,0.7);
                                font-size: 48px;
                                font-weight: 700;
                                margin: 0;
                                padding: 20px;
                            ">
                                {{ $defaultBanner->title_arabic }}
                            </h2>
                        @else
                            <h2 class="sec-title" style="
                                color: #fff; 
                                text-shadow: 2px 2px 8px rgba(0,0,0,0.7);
                                font-size: 48px;
                                font-weight: 700;
                                margin: 0;
                                padding: 20px;
                            ">
                                {{ $defaultBanner->title_english }}
                            </h2>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- END: Default Banner Section -->
@endif
