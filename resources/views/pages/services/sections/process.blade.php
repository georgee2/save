{{-- Process Section - Modern Timeline Design --}}
<section class="service-process-section py-12">
    <div class="container">
        <div class="section-header text-center mb-10">
            <div class="section-badge mb-3">
                <span class="badge-line"></span>
                <span class="badge-text">{{ __('lang.how_we_work') }}</span>
                <span class="badge-line"></span>
            </div>
            @if(isset($titles['processes']) && $titles['processes'])
            <h2 class="section-title">
                {{ app()->getLocale() == 'ar' ? $titles['processes']->title_arabic : $titles['processes']->title_english }}
            </h2>
            @if($titles['processes']->subtitle_english || $titles['processes']->subtitle_arabic)
            <p class="section-subtitle">
                {{ app()->getLocale() == 'ar' ? $titles['processes']->subtitle_arabic : $titles['processes']->subtitle_english }}
            </p>
            @endif
            @else
            <h2 class="section-title">{{ __('lang.our_process') }}</h2>
            <p class="section-subtitle">{{ __('lang.process_subtitle') }}</p>
            @endif
        </div>
        
        <div class="process-modern-wrapper">
            @foreach($service->processes as $index => $process)
            <div class="process-modern-item {{ $index % 2 == 1 ? 'process-item-reverse' : '' }}" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                {{-- Left/Right Content Based on Index --}}
                <div class="process-modern-content">
                    <div class="process-content-inner">
                        <span class="process-step-label">{{ __('lang.step') }} {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                        <h3 class="process-modern-title">
                            {{ app()->getLocale() == 'ar' ? $process->title_arabic : $process->title_english }}
                        </h3>
                        <p class="process-modern-desc">
                            {{ app()->getLocale() == 'ar' ? $process->description_arabic : $process->description_english }}
                        </p>
                        @if($process->icon)
                        <div class="process-modern-icon">
                            <img src="{{ asset('storage' . $process->icon) }}" alt="">
                        </div>
                        @endif
                    </div>
                </div>
                
                {{-- Center Timeline --}}
                <div class="process-modern-timeline">
                    <div class="process-timeline-number">
                        <span>{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                    </div>
                    @if(!$loop->last)
                    <div class="process-timeline-line"></div>
                    @endif
                </div>
                
                {{-- Image Side --}}
                <div class="process-modern-visual">
                    @if($process->image)
                    <div class="process-visual-card">
                        <img src="{{ asset('storage' . $process->image) }}" alt="{{ $process->title_english }}">
                        <div class="process-visual-overlay">
                            <span class="process-visual-number">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                        </div>
                    </div>
                    @else
                    <div class="process-visual-placeholder">
                        <div class="process-placeholder-icon">
                            @if($process->icon)
                            <img src="{{ asset('storage' . $process->icon) }}" alt="">
                            @else
                            <i class="fal fa-cogs"></i>
                            @endif
                        </div>
                        <span class="process-placeholder-number">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
