{{-- Home Contact & FAQ Section --}}
@if($homeContact || ($homeFaqs && $homeFaqs->count() > 0))
<section class="home-contact-faq-section py-lg-12 py-11">
    <div class="container">
        <div class="row">
            {{-- Left Side - Contact Card with Image --}}
            <div class="col-lg-5 mb-6 mb-lg-0">
                <div class="contact-card-wrapper position-relative h-100">
                    @if($homeContact && $homeContact->background)
                    <div class="contact-image-card position-relative rounded-lg overflow-hidden">
                        <img src="{{ url('/storage' . $homeContact->background) }}" 
                             alt="{{ app()->getLocale() == 'ar' ? $homeContact->title_arabic : $homeContact->title_english }}"
                             class="w-100 h-100">
                        <div class="contact-image-overlay"></div>
                        <div class="contact-image-content position-absolute">
                            <h3 class="contact-image-title">
                                {{ app()->getLocale() == 'ar' ? $homeContact->title_arabic : $homeContact->title_english }}
                            </h3>
                        </div>
                    </div>
                    @endif
                    
                    {{-- Why Choose Us Card with Phone --}}
                    <div class="contact-phone-card">
                        <h4 class="contact-phone-title">{{ __('lang.why_choose_us') }}</h4>
                        @if($contactInfo && $contactInfo->mobile)
                        <div class="contact-phone-box">
                            <div class="phone-icon">
                                <i class="fas fa-phone-alt"></i>
                            </div>
                            <a href="tel:{{ $contactInfo->mobile }}" class="phone-number">
                                {{ $contactInfo->mobile }}
                            </a>
                        </div>
                        @endif
                        
                        {{-- Contact Us Button - Opens Inline Form --}}
                        <button type="button" class="btn-contact-popup" id="toggleContactForm">
                            <i class="fas fa-envelope"></i>
                            <span>{{ __('lang.send_us_message') }}</span>
                        </button>
                    </div>
                </div>
            </div>
            
            {{-- Right Side - FAQ Accordion --}}
            <div class="col-lg-7">
                @if($homeFaqs && $homeFaqs->count() > 0)
                <div class="faq-wrapper">
                    <div class="accordion accordion-faq" id="homeFaqAccordion">
                        @foreach($homeFaqs as $index => $faq)
                        <div class="faq-item {{ $index === 0 ? 'active' : '' }}">
                            <div class="faq-header" id="faqHeading{{ $faq->id }}">
                                <button class="faq-button {{ $index !== 0 ? 'collapsed' : '' }}" 
                                        type="button" 
                                        data-toggle="collapse" 
                                        data-target="#faqCollapse{{ $faq->id }}" 
                                        aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" 
                                        aria-controls="faqCollapse{{ $faq->id }}">
                                    <span class="faq-question">
                                        {{ app()->getLocale() == 'ar' ? $faq->question_arabic : $faq->question_english }}
                                    </span>
                                    <span class="faq-icon">
                                        <i class="fas fa-plus"></i>
                                        <i class="fas fa-minus"></i>
                                    </span>
                                </button>
                            </div>
                            <div id="faqCollapse{{ $faq->id }}" 
                                 class="faq-collapse collapse {{ $index === 0 ? 'show' : '' }}" 
                                 aria-labelledby="faqHeading{{ $faq->id }}" 
                                 data-parent="#homeFaqAccordion">
                                <div class="faq-body">
                                    {!! app()->getLocale() == 'ar' ? $faq->answer_arabic : $faq->answer_english !!}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
        
        {{-- Inline Contact Form Popup --}}
        <div class="inline-contact-popup" id="inlineContactPopup">
            <div class="inline-popup-overlay" id="inlinePopupOverlay"></div>
            <div class="inline-popup-content">
                {{-- Popup Header --}}
                <div class="inline-popup-header">
                    <div class="popup-header-content">
                        <div class="popup-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="popup-title-wrapper">
                            <h4>{{ __('lang.send_us_message') }}</h4>
                            <p>{{ __('lang.contact_us_subtitle') ?? 'We\'d love to hear from you' }}</p>
                        </div>
                    </div>
                    <button type="button" class="popup-close-btn" id="closeContactPopup">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                {{-- Popup Body --}}
                <div class="inline-popup-body">
                    <form action="{{ route('contact.store') }}" method="POST" class="inline-contact-form" id="inlineContactForm">
                        @csrf
                        <input type="hidden" name="source" value="home_inline">
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-icon-wrapper">
                                        <i class="fas fa-user"></i>
                                        <input type="text" class="form-control" name="name" placeholder="{{ __('lang.full_name') ?? 'Full Name' }} *" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-icon-wrapper">
                                        <i class="fas fa-envelope"></i>
                                        <input type="email" class="form-control" name="email" placeholder="{{ __('lang.email_address') ?? 'Email' }} *" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-icon-wrapper">
                                        <i class="fas fa-phone-alt"></i>
                                        <input type="tel" class="form-control" name="phone" placeholder="{{ __('lang.phone_number') ?? 'Phone' }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-icon-wrapper">
                                        <i class="fas fa-tag"></i>
                                        <input type="text" class="form-control" name="subject" placeholder="{{ __('lang.subject') ?? 'Subject' }} *" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="input-icon-wrapper textarea-wrapper">
                                <i class="fas fa-comment-alt"></i>
                                <textarea class="form-control" name="message" rows="3" placeholder="{{ __('lang.your_message') ?? 'Your Message' }} *" required></textarea>
                            </div>
                        </div>
                        
                        <div class="form-actions">
                            <button type="button" class="btn-cancel-inline" id="cancelContactForm">
                                <i class="fas fa-times"></i>
                                <span>{{ __('lang.cancel') ?? 'Cancel' }}</span>
                            </button>
                            <button type="submit" class="btn-submit-inline">
                                <i class="fas fa-paper-plane"></i>
                                <span>{{ __('lang.send_message') ?? 'Send' }}</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Inline Contact Form Script --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    var toggleBtn = document.getElementById('toggleContactForm');
    var closeBtn = document.getElementById('closeContactPopup');
    var cancelBtn = document.getElementById('cancelContactForm');
    var popup = document.getElementById('inlineContactPopup');
    var overlay = document.getElementById('inlinePopupOverlay');
    var contactForm = document.getElementById('inlineContactForm');
    
    function openPopup() {
        popup.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
    
    function closePopup() {
        popup.classList.remove('active');
        document.body.style.overflow = '';
    }
    
    if (toggleBtn) {
        toggleBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            openPopup();
        });
    }
    
    if (closeBtn) {
        closeBtn.addEventListener('click', closePopup);
    }
    
    if (cancelBtn) {
        cancelBtn.addEventListener('click', closePopup);
    }
    
    if (overlay) {
        overlay.addEventListener('click', closePopup);
    }
    
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && popup.classList.contains('active')) {
            closePopup();
        }
    });
    
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            var submitBtn = contactForm.querySelector('.btn-submit-inline');
            var originalContent = submitBtn.innerHTML;
            
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> <span>{{ __("lang.sending") ?? "Sending" }}...</span>';
            
            var formData = new FormData(contactForm);
            
            fetch(contactForm.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(function(response) { return response.json(); })
            .then(function(data) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalContent;
                
                if (data.success) {
                    closePopup();
                    contactForm.reset();
                    Swal.fire({
                        icon: 'success',
                        title: '{{ __("lang.success") ?? "Success" }}',
                        text: data.message || '{{ __("lang.message_sent_successfully") ?? "Message sent!" }}',
                        confirmButtonColor: '#19868b'
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: '{{ __("lang.error") ?? "Error" }}',
                        text: data.message || '{{ __("lang.something_went_wrong") ?? "Something went wrong" }}',
                        confirmButtonColor: '#e1273d'
                    });
                }
            })
            .catch(function(error) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalContent;
                Swal.fire({
                    icon: 'error',
                    title: '{{ __("lang.error") ?? "Error" }}',
                    text: '{{ __("lang.something_went_wrong") ?? "Something went wrong" }}',
                    confirmButtonColor: '#e1273d'
                });
            });
        });
    }
});
</script>
@endif
