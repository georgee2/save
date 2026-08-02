{{-- Shared favourites body: share card, summary, tabs, item lists, empty state, email modal.
     Used by the guest favourites page (pages/favourites/index) and the customer
     account favourites page (pages/account/favourites). Expects: $grouped,
     $totalCount, $shareUrl, $favouriteId (and global $footerContactInfo). --}}
<section class="favourites-content">
    <div class="container">
        @if($totalCount > 0)
        <div class="row">
            {{-- Sidebar --}}
            <div class="col-lg-4 order-lg-2 d-lg-block d-none">
                {{-- Share Card --}}
                <div class="fav-share-card">
                    <h5><i class="fal fa-share-alt"></i> {{ __('lang.share_favourites') }}</h5>
                    <p>{{ __('lang.share_favourites_desc') }}</p>
                    <div class="fav-share-actions">
                        @if(isset($footerContactInfo) && $footerContactInfo->whatsapp)
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $footerContactInfo->whatsapp) }}?text={{ urlencode(__('lang.send_to_our_whatsapp_msg') . "\nID: " . $favouriteId . "\n" . $shareUrl) }}" target="_blank" class="fav-share-btn fav-share-our-whatsapp">
                            <i class="fab fa-whatsapp"></i> {{ __('lang.send_to_our_whatsapp') }}
                        </a>
                        @endif
                        <button class="fav-share-btn fav-share-whatsapp" data-url="{{ $shareUrl }}">
                            <i class="fab fa-whatsapp"></i> {{ __('lang.share_whatsapp') }}
                        </button>
                        <button class="fav-share-btn fav-share-link" data-url="{{ $shareUrl }}">
                            <i class="fal fa-link"></i> {{ __('lang.copy_link') }}
                        </button>
                        <button class="fav-share-btn fav-share-email" onclick="document.getElementById('favEmailModal').style.display='flex'">
                            <i class="fal fa-envelope"></i> {{ __('lang.send_email') }}
                        </button>
                        <span class="fav-share-hint">{{ __('lang.share_email_hint') }}</span>
                    </div>
                </div>

                {{-- Summary --}}
                <div class="fav-summary">
                    <h5><i class="fal fa-clipboard-list"></i> {{ __('lang.favourite_summary') }}</h5>
                    @if($grouped['projects']->count() > 0)
                    <div class="fav-summary-row">
                        <span><i class="fal fa-building"></i> {{ __('lang.favourite_projects') }}</span>
                        <span class="count">{{ $grouped['projects']->count() }}</span>
                    </div>
                    @endif
                    @if($grouped['offers']->count() > 0)
                    <div class="fav-summary-row">
                        <span><i class="fal fa-tags"></i> {{ __('lang.favourite_offers') }}</span>
                        <span class="count">{{ $grouped['offers']->count() }}</span>
                    </div>
                    @endif
                    @if($grouped['interiors']->count() > 0)
                    <div class="fav-summary-row">
                        <span><i class="fal fa-paint-roller"></i> {{ __('lang.favourite_interior') }}</span>
                        <span class="count">{{ $grouped['interiors']->count() }}</span>
                    </div>
                    @endif
                    <div class="fav-summary-total">
                        <span>{{ __('lang.total_items') }}</span>
                        <span class="count">{{ $totalCount }}</span>
                    </div>
                </div>
            </div>

            <div class="col-lg-8 order-lg-1">
                {{-- Tabs --}}
                <div class="fav-toolbar d-flex justify-content-between align-items-center flex-wrap mb-3">
                    <div class="fav-tabs">
                        <button class="fav-tab active" data-target="all">
                            {{ __('lang.all') ?? 'All' }}
                            <span class="tab-count">{{ $totalCount }}</span>
                        </button>
                        @if($grouped['projects']->count() > 0)
                        <button class="fav-tab" data-target="projects">
                            <i class="fal fa-building"></i>
                            {{ __('lang.favourite_projects') }}
                            <span class="tab-count">{{ $grouped['projects']->count() }}</span>
                        </button>
                        @endif
                        @if($grouped['offers']->count() > 0)
                        <button class="fav-tab" data-target="offers">
                            <i class="fal fa-tags"></i>
                            {{ __('lang.favourite_offers') }}
                            <span class="tab-count">{{ $grouped['offers']->count() }}</span>
                        </button>
                        @endif
                        @if($grouped['interiors']->count() > 0)
                        <button class="fav-tab" data-target="interiors">
                            <i class="fal fa-paint-roller"></i>
                            {{ __('lang.favourite_interior') }}
                            <span class="tab-count">{{ $grouped['interiors']->count() }}</span>
                        </button>
                        @endif
                    </div>
                    <button class="fav-clear-all" id="clearAllFavourites">
                        <i class="fal fa-trash-alt"></i>
                        {{ __('lang.clear_all') }}
                    </button>
                </div>

                {{-- Mobile Share Bar --}}
                <div class="fav-share-mobile d-lg-none mb-3">
                    @if(isset($footerContactInfo) && $footerContactInfo->whatsapp)
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $footerContactInfo->whatsapp) }}?text={{ urlencode(__('lang.send_to_our_whatsapp_msg') . "\nID: " . $favouriteId . "\n" . $shareUrl) }}" target="_blank" class="fav-share-btn fav-share-our-whatsapp">
                        <i class="fab fa-whatsapp"></i> {{ __('lang.send_to_us') }}
                    </a>
                    @endif
                    <button class="fav-share-btn fav-share-whatsapp" data-url="{{ $shareUrl }}">
                        <i class="fab fa-whatsapp"></i> {{ __('lang.share') }}
                    </button>
                    <button class="fav-share-btn fav-share-link" data-url="{{ $shareUrl }}">
                        <i class="fal fa-link"></i> {{ __('lang.copy_link') }}
                    </button>
                    <button class="fav-share-btn fav-share-email" onclick="document.getElementById('favEmailModal').style.display='flex'">
                        <i class="fal fa-envelope"></i> {{ __('lang.email_short') }}
                    </button>
                </div>

                {{-- Projects --}}
                @if($grouped['projects']->count() > 0)
                <div class="fav-section" data-section="projects">
                    @foreach($grouped['projects'] as $fav)
                    @php $project = $fav->itemData; @endphp
                    <div class="fav-item" data-fav-id="{{ $fav->id }}">
                        <a href="{{ route('projects.show', $project->slug) }}" class="fav-item-image">
                            <img src="{{ url('/storage' . $project->main_image) }}" alt="{{ $project->{'alt_text_' . app()->getLocale()} ?? (app()->getLocale() == 'ar' ? $project->title_arabic : $project->title_english) }}">
                        </a>
                        <div class="fav-item-body">
                            <span class="fav-type-badge project">{{ __('lang.projects') }}</span>
                            <a href="{{ route('projects.show', $project->slug) }}" class="fav-item-title">
                                {{ app()->getLocale() == 'ar' ? $project->title_arabic : $project->title_english }}
                            </a>
                            <div class="fav-item-meta">
                                @if($project->category)
                                <span><i class="fal fa-folder"></i> {{ app()->getLocale() == 'ar' ? $project->category->title_arabic : $project->category->title_english }}</span>
                                @endif
                                @if($project->emirate)
                                <span><i class="fal fa-map-marker-alt"></i> {{ app()->getLocale() == 'ar' ? $project->emirate->title_arabic : $project->emirate->title_english }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="fav-item-actions">
                            <button class="fav-remove-btn" data-id="{{ $fav->id }}" title="{{ __('lang.remove_from_favourites') }}">
                                <i class="fal fa-times"></i>
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif

                {{-- Offers --}}
                @if($grouped['offers']->count() > 0)
                <div class="fav-section" data-section="offers">
                    @foreach($grouped['offers'] as $fav)
                    @php $offer = $fav->itemData; @endphp
                    <div class="fav-item" data-fav-id="{{ $fav->id }}">
                        <a href="{{ route('offers.show', $offer->slug) }}" class="fav-item-image">
                            <img src="{{ url('/storage' . $offer->main_image) }}" alt="{{ $offer->{'alt_text_' . app()->getLocale()} ?? (app()->getLocale() == 'ar' ? $offer->title_arabic : $offer->title_english) }}">
                        </a>
                        <div class="fav-item-body">
                            <span class="fav-type-badge offer">{{ __('lang.offers') }}</span>
                            <a href="{{ route('offers.show', $offer->slug) }}" class="fav-item-title">
                                {{ app()->getLocale() == 'ar' ? $offer->title_arabic : $offer->title_english }}
                            </a>
                            <div class="fav-item-meta">
                                @if($offer->category)
                                <span><i class="fal fa-folder"></i> {{ app()->getLocale() == 'ar' ? $offer->category->title_arabic : $offer->category->title_english }}</span>
                                @endif
                                @if(isset($fav->selectedPrice) && $fav->selectedPrice && $fav->selectedPrice->emirate)
                                <span><i class="fal fa-map-marker-alt"></i> {{ app()->getLocale() == 'ar' ? $fav->selectedPrice->emirate->title_arabic : $fav->selectedPrice->emirate->title_english }}</span>
                                @endif
                            </div>
                            @if($fav->selectedPrice && $fav->price)
                            <div class="fav-item-price">
                                {{ number_format($fav->price) }} {{ $offer->currency ? $offer->currency->code : 'AED' }}
                            </div>
                            @endif
                        </div>
                        <div class="fav-item-actions">
                            <button class="fav-remove-btn" data-id="{{ $fav->id }}" title="{{ __('lang.remove_from_favourites') }}">
                                <i class="fal fa-times"></i>
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif

                {{-- Interior --}}
                @if($grouped['interiors']->count() > 0)
                <div class="fav-section" data-section="interiors">
                    @foreach($grouped['interiors'] as $fav)
                    @php $interior = $fav->itemData; @endphp
                    <div class="fav-item" data-fav-id="{{ $fav->id }}">
                        <div class="fav-item-image">
                            <img src="{{ url('/storage' . $interior->image) }}" alt="{{ app()->getLocale() == 'ar' ? $interior->title_arabic : $interior->title_english }}">
                        </div>
                        <div class="fav-item-body">
                            <span class="fav-type-badge interior">{{ __('lang.interior_design') ?? 'Interior' }}</span>
                            <span class="fav-item-title">
                                {{ app()->getLocale() == 'ar' ? $interior->title_arabic : $interior->title_english }}
                            </span>
                            <div class="fav-item-meta">
                                @if($interior->category)
                                <span><i class="fal fa-folder"></i> {{ app()->getLocale() == 'ar' ? $interior->category->title_arabic : $interior->category->title_english }}</span>
                                @endif
                                @if($interior->projectStyle)
                                <span><i class="fal fa-palette"></i> {{ app()->getLocale() == 'ar' ? $interior->projectStyle->title_arabic : $interior->projectStyle->title_english }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="fav-item-actions">
                            <button class="fav-remove-btn" data-id="{{ $fav->id }}" title="{{ __('lang.remove_from_favourites') }}">
                                <i class="fal fa-times"></i>
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

        </div>
        @else
        {{-- Empty State --}}
        <div class="fav-empty">
            <div class="fav-empty-icon">
                <i class="fal fa-heart"></i>
            </div>
            <h3>{{ __('lang.no_favourites') }}</h3>
            <p>{{ __('lang.no_favourites_desc') }}</p>
            <div class="fav-empty-actions">
                <a href="{{ route('projects.index') }}" class="fav-browse-btn">
                    <i class="fal fa-building"></i> {{ __('lang.browse_projects') }}
                </a>
                <a href="{{ route('offers.index') }}" class="fav-browse-btn">
                    <i class="fal fa-tags"></i> {{ __('lang.browse_offers') }}
                </a>
                <a href="{{ route('interior.index') }}" class="fav-browse-btn">
                    <i class="fal fa-paint-roller"></i> {{ __('lang.browse_interior') }}
                </a>
            </div>
        </div>
        @endif
    </div>
</section>

{{-- Email Modal --}}
@if($totalCount > 0)
<div class="fav-email-modal" id="favEmailModal">
    <div class="fav-email-modal-card">
        <div class="fav-email-modal-header">
            <h5><i class="fal fa-envelope"></i> {{ __('lang.send_favourites_email') }}</h5>
            <button type="button" class="fav-email-modal-close" onclick="document.getElementById('favEmailModal').style.display='none'">&times;</button>
        </div>
        <div class="fav-email-modal-body">
            <p>{{ __('lang.send_email_desc') }}</p>
            <div class="fav-email-field">
                <label for="favEmailInput">{{ __('lang.your_email') }} <span style="color:#e1273d">*</span></label>
                <input type="email" id="favEmailInput" placeholder="email@example.com" required>
            </div>
            <div class="fav-email-field">
                <label for="favNameInput">{{ __('lang.your_name') }}</label>
                <input type="text" id="favNameInput" placeholder="{{ __('lang.your_name') }}">
            </div>
        </div>
        <div class="fav-email-modal-footer">
            <button type="button" class="fav-email-cancel" onclick="document.getElementById('favEmailModal').style.display='none'">{{ __('lang.cancel') ?? 'Cancel' }}</button>
            <button type="button" class="fav-email-send" id="favEmailSendBtn">
                <i class="fal fa-paper-plane"></i> {{ __('lang.send_email') }}
            </button>
        </div>
    </div>
</div>
@endif
