@extends('layouts.master')
@php $seo = \App\Models\SeoPage::getSeo('favourites'); @endphp
@section('title', $seo['title'] ?? __('lang.my_favourites'))
@section('seo_desc', $seo['description'] ?? __('lang.my_favourites'))
@section('seo_tags', $seo['tags'] ?? __('lang.my_favourites'))

@section('css')
<link rel="stylesheet" href="{{ asset('/assets/css/favourites-page.css') }}?v=1.9">
@endsection

@section('content')
<section class="favourites-hero">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('index') }}">{{ __('lang.home') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('lang.favourites') }}</li>
            </ol>
        </nav>
        <h1><i class="fal fa-heart"></i> {{ __('lang.my_favourites') }}</h1>
        <p>{{ $totalCount }} {{ __('lang.favourite_items') }}</p>
        @if($totalCount > 0)
        <div class="fav-ref-id" id="favRefId" data-id="{{ $favouriteId }}">
            <span class="fav-ref-label">{{ __('lang.reference_id') }}:</span>
            <span class="fav-ref-code">{{ $favouriteId }}</span>
            <button class="fav-ref-copy" onclick="copyRefId()" title="{{ __('lang.copy_link') }}"><i class="fal fa-copy"></i></button>
        </div>
        <p class="fav-expiry-hint"><i class="fal fa-clock"></i> {{ __('lang.fav_expiry_hint') }}</p>
        @endif
    </div>
</section>

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
                            @if($fav->price && $offer->prices && $offer->prices->count() > 0)
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

@endsection

@section('js')
<script>
function copyRefId() {
    var el = document.getElementById('favRefId');
    var id = el ? el.getAttribute('data-id') : '';
    var btn = el ? el.querySelector('.fav-ref-copy') : null;
    if (!id) return;

    if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(id).then(function() { showRefCopied(btn); });
    } else {
        var input = document.createElement('input');
        input.value = id;
        document.body.appendChild(input);
        input.select();
        document.execCommand('copy');
        document.body.removeChild(input);
        showRefCopied(btn);
    }
}

function showRefCopied(btn) {
    if (!btn) return;
    var orig = btn.innerHTML;
    btn.innerHTML = '<i class="fal fa-check"></i>';
    btn.classList.add('copied');
    setTimeout(function() { btn.innerHTML = orig; btn.classList.remove('copied'); }, 2000);
}

document.addEventListener('DOMContentLoaded', function() {
    // Tab switching
    var tabs = document.querySelectorAll('.fav-tab');
    var sections = document.querySelectorAll('.fav-section');

    tabs.forEach(function(tab) {
        tab.addEventListener('click', function() {
            tabs.forEach(function(t) { t.classList.remove('active'); });
            tab.classList.add('active');
            var target = tab.getAttribute('data-target');

            sections.forEach(function(section) {
                if (target === 'all') {
                    section.style.display = '';
                } else {
                    section.style.display = section.getAttribute('data-section') === target ? '' : 'none';
                }
            });
        });
    });

    // Remove single item
    document.querySelectorAll('.fav-remove-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var favId = btn.getAttribute('data-id');
            var item = btn.closest('.fav-item');
            var csrfEl = document.querySelector('meta[name="csrf-token"]');
            var csrf = csrfEl ? csrfEl.getAttribute('content') : '';

            var xhr = new XMLHttpRequest();
            xhr.open('DELETE', '/{{ app()->getLocale() }}/favourites/' + favId, true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.setRequestHeader('Accept', 'application/json');
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            xhr.setRequestHeader('X-CSRF-TOKEN', csrf);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    item.style.opacity = '0';
                    item.style.transform = 'translateX(20px)';
                    item.style.transition = 'all 0.3s ease';
                    setTimeout(function() {
                        item.remove();
                        checkEmpty();
                    }, 300);
                    try {
                        var data = JSON.parse(xhr.responseText);
                        var badges = document.querySelectorAll('.favourite-badge');
                        badges.forEach(function(b) {
                            b.textContent = data.count;
                            b.style.display = data.count > 0 ? '' : 'none';
                        });
                    } catch(e) {}
                }
            };
            xhr.send();
        });
    });

    // Clear all
    var clearBtn = document.getElementById('clearAllFavourites');
    if (clearBtn) {
        clearBtn.addEventListener('click', function() {
            if (typeof Swal !== 'undefined') {
                var isAr = document.documentElement.getAttribute('lang') === 'ar';
                Swal.fire({
                    title: isAr ? 'هل أنت متأكد؟' : 'Are you sure?',
                    text: isAr ? 'سيتم حذف جميع المفضلات' : 'All favourites will be removed',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#e1273d',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: isAr ? 'نعم، احذف الكل' : 'Yes, clear all',
                    cancelButtonText: isAr ? 'إلغاء' : 'Cancel',
                }).then(function(result) {
                    if (result.isConfirmed) { doClearAll(); }
                });
            } else {
                if (confirm('Clear all favourites?')) { doClearAll(); }
            }
        });
    }

    function doClearAll() {
        var csrfEl = document.querySelector('meta[name="csrf-token"]');
        var csrf = csrfEl ? csrfEl.getAttribute('content') : '';
        var xhr = new XMLHttpRequest();
        xhr.open('DELETE', '/{{ app()->getLocale() }}/favourites/clear/all', true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.setRequestHeader('Accept', 'application/json');
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.setRequestHeader('X-CSRF-TOKEN', csrf);
        xhr.onload = function() {
            if (xhr.status === 200) {
                window.location.reload();
            }
        };
        xhr.send();
    }

    function checkEmpty() {
        var items = document.querySelectorAll('.fav-item');
        if (items.length === 0) {
            window.location.reload();
        }
    }

    // Share via WhatsApp
    document.querySelectorAll('.fav-share-whatsapp').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var url = btn.getAttribute('data-url');
            var isAr = document.documentElement.getAttribute('lang') === 'ar';
            var text = isAr
                ? 'شاهد مفضلاتي على سمارت فيجن: ' + url
                : 'Check out my favourites on Smart Vision: ' + url;
            window.open('https://wa.me/?text=' + encodeURIComponent(text), '_blank');
        });
    });

    // Copy link
    document.querySelectorAll('.fav-share-link').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var url = btn.getAttribute('data-url');
            var isAr = document.documentElement.getAttribute('lang') === 'ar';

            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(url).then(function() {
                    showCopied(btn, isAr);
                });
            } else {
                var input = document.createElement('input');
                input.value = url;
                document.body.appendChild(input);
                input.select();
                document.execCommand('copy');
                document.body.removeChild(input);
                showCopied(btn, isAr);
            }
        });
    });

    function showCopied(btn, isAr) {
        var originalHtml = btn.innerHTML;
        btn.classList.add('copied');
        btn.innerHTML = '<i class="fal fa-check"></i> ' + (isAr ? 'تم النسخ!' : 'Copied!');
        setTimeout(function() {
            btn.classList.remove('copied');
            btn.innerHTML = originalHtml;
        }, 2500);
    }

    // Email modal: close on overlay click
    var emailModal = document.getElementById('favEmailModal');
    if (emailModal) {
        emailModal.addEventListener('click', function(e) {
            if (e.target === emailModal) emailModal.style.display = 'none';
        });

        // Close on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && emailModal.style.display === 'flex') {
                emailModal.style.display = 'none';
            }
        });
    }

    // Send email
    var sendBtn = document.getElementById('favEmailSendBtn');
    if (sendBtn) {
        sendBtn.addEventListener('click', function() {
            var emailInput = document.getElementById('favEmailInput');
            var nameInput = document.getElementById('favNameInput');
            var email = emailInput.value.trim();
            var name = nameInput.value.trim();
            var isAr = document.documentElement.getAttribute('lang') === 'ar';

            if (!email || !emailInput.checkValidity()) {
                emailInput.focus();
                emailInput.style.borderColor = '#e1273d';
                return;
            }
            emailInput.style.borderColor = '';

            var originalHtml = sendBtn.innerHTML;
            sendBtn.disabled = true;
            sendBtn.innerHTML = '<i class="fal fa-spinner fa-spin"></i> ' + (isAr ? 'جاري الإرسال...' : 'Sending...');

            var csrfEl = document.querySelector('meta[name="csrf-token"]');
            var csrf = csrfEl ? csrfEl.getAttribute('content') : '';

            var xhr = new XMLHttpRequest();
            xhr.open('POST', '/{{ app()->getLocale() }}/favourites/send-email', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.setRequestHeader('Accept', 'application/json');
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            xhr.setRequestHeader('X-CSRF-TOKEN', csrf);
            xhr.onload = function() {
                sendBtn.disabled = false;
                sendBtn.innerHTML = originalHtml;

                if (xhr.status === 200) {
                    document.getElementById('favEmailModal').style.display = 'none';
                    emailInput.value = '';
                    nameInput.value = '';

                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'success',
                            title: isAr ? 'تم الإرسال بنجاح!' : 'Email Sent!',
                            text: isAr ? 'تم إرسال المفضلة إلى بريدك الإلكتروني.' : 'Your favourites have been sent to your email.',
                            confirmButtonColor: '#19868b',
                            confirmButtonText: isAr ? 'حسناً' : 'OK',
                        });
                    } else {
                        alert(isAr ? 'تم إرسال المفضلة إلى بريدك الإلكتروني.' : 'Your favourites have been sent to your email.');
                    }
                } else {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'error',
                            title: isAr ? 'فشل الإرسال' : 'Failed to Send',
                            text: isAr ? 'حدث خطأ أثناء إرسال البريد الإلكتروني. حاول مرة أخرى.' : 'Something went wrong while sending the email. Please try again.',
                            confirmButtonColor: '#e1273d',
                            confirmButtonText: isAr ? 'حسناً' : 'OK',
                        });
                    } else {
                        alert(isAr ? 'فشل في إرسال البريد الإلكتروني' : 'Failed to send email. Please try again.');
                    }
                }
            };
            xhr.onerror = function() {
                sendBtn.disabled = false;
                sendBtn.innerHTML = originalHtml;
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'error',
                        title: isAr ? 'خطأ في الاتصال' : 'Connection Error',
                        text: isAr ? 'تعذر الاتصال بالخادم. تحقق من اتصالك بالإنترنت.' : 'Could not connect to the server. Please check your connection.',
                        confirmButtonColor: '#e1273d',
                        confirmButtonText: isAr ? 'حسناً' : 'OK',
                    });
                } else {
                    alert(isAr ? 'خطأ في الاتصال' : 'Connection error. Please try again.');
                }
            };
            xhr.send(JSON.stringify({ email: email, name: name }));
        });
    }
});
</script>
@endsection
