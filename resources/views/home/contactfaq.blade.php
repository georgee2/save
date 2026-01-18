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
                        
                        {{-- Contact Us Button --}}
                        <button type="button" class="btn-contact-popup" data-toggle="modal" data-target="#homeContactModal">
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
    </div>
</section>

{{-- Contact Modal Popup --}}
<div class="modal fade" id="homeContactModal" tabindex="-1" role="dialog" aria-labelledby="homeContactModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content home-contact-modal-content">
            {{-- Modal Header --}}
            <div class="modal-header home-contact-modal-header">
                <div class="modal-header-content">
                    <div class="modal-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="modal-title-wrapper">
                        <h5 class="modal-title" id="homeContactModalLabel">{{ __('lang.send_us_message') }}</h5>
                        <p class="modal-subtitle">{{ __('lang.contact_us_subtitle') }}</p>
                    </div>
                </div>
                <button type="button" class="close modal-close-btn" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fas fa-times"></i></span>
                </button>
            </div>
            
            {{-- Modal Body --}}
            <div class="modal-body home-contact-modal-body">
                <form action="{{ route('contact.store') }}" method="POST" class="home-contact-form" id="homeContactForm">
                    @csrf
                    <input type="hidden" name="source" value="home_popup">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="popup_name">{{ __('lang.full_name') }} <span class="text-danger">*</span></label>
                                <div class="input-icon-wrapper">
                                    <i class="fas fa-user"></i>
                                    <input type="text" class="form-control" id="popup_name" name="name" placeholder="{{ __('lang.enter_your_name') }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="popup_email">{{ __('lang.email_address') }} <span class="text-danger">*</span></label>
                                <div class="input-icon-wrapper">
                                    <i class="fas fa-envelope"></i>
                                    <input type="email" class="form-control" id="popup_email" name="email" placeholder="{{ __('lang.enter_your_email') }}" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="popup_phone">{{ __('lang.phone_number') }}</label>
                                <div class="input-icon-wrapper">
                                    <i class="fas fa-phone-alt"></i>
                                    <input type="tel" class="form-control" id="popup_phone" name="phone" placeholder="{{ __('lang.enter_your_phone') }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="popup_service_id">{{ __('lang.select_service') }}</label>
                                <div class="input-icon-wrapper">
                                    <i class="fas fa-cog"></i>
                                    <select class="form-control" id="popup_service_id" name="service_id">
                                        <option value="">{{ __('lang.choose_service') }}</option>
                                        @if(isset($services))
                                            @foreach($services as $service)
                                            <option value="{{ $service->id }}">
                                                {{ app()->getLocale() == 'ar' ? $service->title_arabic : $service->title_english }}
                                            </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="popup_subject">{{ __('lang.subject') }} <span class="text-danger">*</span></label>
                        <div class="input-icon-wrapper">
                            <i class="fas fa-tag"></i>
                            <input type="text" class="form-control" id="popup_subject" name="subject" placeholder="{{ __('lang.enter_subject') }}" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="popup_message">{{ __('lang.your_message') }} <span class="text-danger">*</span></label>
                        <div class="input-icon-wrapper textarea-wrapper">
                            <i class="fas fa-comment-alt"></i>
                            <textarea class="form-control" id="popup_message" name="message" rows="4" placeholder="{{ __('lang.enter_your_message') }}" required></textarea>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <button type="button" class="btn btn-cancel" data-dismiss="modal">
                            <i class="fas fa-times"></i>
                            <span>{{ __('lang.cancel') }}</span>
                        </button>
                        <button type="submit" class="btn btn-submit-popup">
                            <i class="fas fa-paper-plane"></i>
                            <span>{{ __('lang.send_message') }}</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Form Submission Script --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const homeContactForm = document.getElementById('homeContactForm');
    
    if (homeContactForm) {
        homeContactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const submitBtn = homeContactForm.querySelector('.btn-submit-popup');
            const originalContent = submitBtn.innerHTML;
            
            // Show loading state
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> <span>{{ __("lang.sending") }}...</span>';
            
            // Create FormData
            const formData = new FormData(homeContactForm);
            
            // Submit via fetch
            fetch(homeContactForm.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalContent;
                
                if (data.success) {
                    // Close modal
                    $('#homeContactModal').modal('hide');
                    
                    // Reset form
                    homeContactForm.reset();
                    
                    // Show success message
                    Swal.fire({
                        icon: 'success',
                        title: '{{ __("lang.success") }}',
                        text: data.message || '{{ __("lang.message_sent_successfully") }}',
                        confirmButtonColor: '#19868b'
                    });
                } else {
                    // Show error message
                    Swal.fire({
                        icon: 'error',
                        title: '{{ __("lang.error") }}',
                        text: data.message || '{{ __("lang.something_went_wrong") }}',
                        confirmButtonColor: '#e1273d'
                    });
                }
            })
            .catch(error => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalContent;
                
                // Show error message
                Swal.fire({
                    icon: 'error',
                    title: '{{ __("lang.error") }}',
                    text: '{{ __("lang.something_went_wrong") }}',
                    confirmButtonColor: '#e1273d'
                });
            });
        });
    }
});
</script>
@endif

