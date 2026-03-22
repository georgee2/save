@extends('admin::layouts.master')
@section('title', 'Contact Information')

@section('css')
<link rel="stylesheet" href="{{ asset('/css/tagify.css') }}">
<link rel="stylesheet" href="{{ asset('/css/auto-translate.css') }}">
<style>
    :root {
        --main-color: #19868b;
        --secondary-color: #0d6b6f;
        --accent-color: #e1273d;
    }
    .char-count {
        font-size: 12px;
        color: #6c757d;
        margin-top: 5px;
    }
    .char-count.error {
        color: #dc3545;
        font-weight: bold;
    }
    .section-header {
        background: linear-gradient(135deg, var(--main-color) 0%, var(--secondary-color) 100%);
        color: white;
        padding: 15px 20px;
        border-radius: 8px 8px 0 0;
        margin: -20px -20px 20px -20px;
    }
    .form-section {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 20px;
        border-left: 4px solid var(--main-color);
    }
    .form-section h5 {
        color: var(--main-color);
        border-bottom: 2px solid var(--main-color);
        padding-bottom: 10px;
        margin-bottom: 20px;
    }
    .btn-primary {
        background-color: var(--main-color) !important;
        border-color: var(--main-color) !important;
    }
    .btn-primary:hover {
        background-color: var(--secondary-color) !important;
        border-color: var(--secondary-color) !important;
    }
</style>
@endsection

@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Admin')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-info-circle"></i> Contact Information</a>
        </nav>

        <div class="col-lg-12">
            <hr>
            
            <div class="card">
                <div class="card-body">
                    <div class="section-header">
                        <h4 class="mt-0 mb-0"><i class="fa fa-info-circle"></i> Contact Information Management</h4>
                        <small>Manage your website contact details and social media links</small>
                    </div>
                    
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="fa fa-check-circle"></i> {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>
                    @endif
                    
                    <form action="{{ route('contact-information.update') }}" method="POST">
                        @csrf
                        <button type="button" class="btn btn-translate-all mb-3" id="translateAllBtn"><i class="fa fa-language"></i> Translate All</button>
                        
                        <!-- Contact Details Section -->
                        <div class="form-section">
                            <h5><i class="fa fa-phone"></i> Contact Details</h5>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Email Address</label>
                                        <input type="email" class="form-control" name="email" value="{{ old('email', $contactInfo->email) }}" placeholder="info@example.com">
                                        @error('email')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Primary Mobile</label>
                                        <input type="text" class="form-control" name="mobile" value="{{ old('mobile', $contactInfo->mobile) }}" placeholder="+1234567890">
                                        @error('mobile')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Secondary Mobile</label>
                                        <input type="text" class="form-control" name="secondary_mobile" value="{{ old('secondary_mobile', $contactInfo->secondary_mobile) }}" placeholder="+1234567890">
                                        @error('secondary_mobile')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>WhatsApp Number</label>
                                        <input type="text" class="form-control" name="whatsapp" value="{{ old('whatsapp', $contactInfo->whatsapp) }}" placeholder="+1234567890">
                                        @error('whatsapp')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Social Media Section -->
                        <div class="form-section">
                            <h5><i class="fa fa-share-alt"></i> Social Media Links</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><i class="fa fa-facebook"></i> Facebook</label>
                                        <input type="url" class="form-control" name="facebook" value="{{ old('facebook', $contactInfo->facebook) }}" placeholder="https://facebook.com/yourpage">
                                        @error('facebook')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><i class="fa fa-instagram"></i> Instagram</label>
                                        <input type="url" class="form-control" name="instagram" value="{{ old('instagram', $contactInfo->instagram) }}" placeholder="https://instagram.com/yourpage">
                                        @error('instagram')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><i class="fa fa-linkedin"></i> LinkedIn</label>
                                        <input type="url" class="form-control" name="linkedin" value="{{ old('linkedin', $contactInfo->linkedin) }}" placeholder="https://linkedin.com/company/yourcompany">
                                        @error('linkedin')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><i class="fa fa-twitter"></i> Twitter</label>
                                        <input type="url" class="form-control" name="twitter" value="{{ old('twitter', $contactInfo->twitter) }}" placeholder="https://twitter.com/yourhandle">
                                        @error('twitter')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label><i class="fa fa-pinterest"></i> Pinterest</label>
                                        <input type="url" class="form-control" name="pinterest" value="{{ old('pinterest', $contactInfo->pinterest) }}" placeholder="https://pinterest.com/yourpage">
                                        @error('pinterest')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Location Section -->
                        <div class="form-section">
                            <h5><i class="fa fa-map-marker"></i> Location Information</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Location Text (English)</label>
                                        <input type="text" class="form-control" name="location_text_english" value="{{ old('location_text_english', $contactInfo->location_text_english) }}" placeholder="123 Main St, City, Country">
                                        @error('location_text_english')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Location Text (Arabic) <button type="button" class="auto-translate-btn" data-translate-source="location_text_english" data-translate-target="location_text_arabic"><i class="fa fa-language"></i> Auto</button></label>
                                        <input type="text" class="form-control" name="location_text_arabic" value="{{ old('location_text_arabic', $contactInfo->location_text_arabic) }}" placeholder="العنوان بالعربي" dir="rtl">
                                        @error('location_text_arabic')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Location on Map (Google Maps Embed URL or iframe)</label>
                                        <textarea class="form-control" name="location_map" rows="3" placeholder="Paste Google Maps embed code or URL here">{{ old('location_map', $contactInfo->location_map) }}</textarea>
                                        <small class="form-text text-muted">Get embed code from Google Maps → Share → Embed a map</small>
                                        @error('location_map')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Footer Bio Section -->
                        <div class="form-section">
                            <h5><i class="fa fa-file-text-o"></i> Footer Bio</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Footer Bio (English) <small>(Max 250 characters)</small></label>
                                        <textarea class="form-control char-counter" name="footer_bio_english" rows="4" maxlength="250" id="footer_bio_english">{{ old('footer_bio_english', $contactInfo->footer_bio_english) }}</textarea>
                                        <div class="char-count" id="footer_bio_english_count">0 / 250 characters</div>
                                        @error('footer_bio_english')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Footer Bio (Arabic) <small>(Max 250 characters)</small> <button type="button" class="auto-translate-btn" data-translate-source="footer_bio_english" data-translate-target="footer_bio_arabic"><i class="fa fa-language"></i> Auto</button></label>
                                        <textarea class="form-control char-counter" name="footer_bio_arabic" rows="4" maxlength="250" dir="rtl" id="footer_bio_arabic">{{ old('footer_bio_arabic', $contactInfo->footer_bio_arabic) }}</textarea>
                                        <div class="char-count" id="footer_bio_arabic_count">0 / 250 characters</div>
                                        @error('footer_bio_arabic')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Tags Section -->
                        <div class="form-section">
                            <h5><i class="fa fa-tags"></i> Tags (For Services)</h5>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Tags <small>(Press Enter or comma to add tags)</small></label>
                                        <input type="text" class="tagify" name="tags" value="{{ old('tags', $contactInfo->tags) }}" placeholder="Add tags...">
                                        <small class="form-text text-muted">These tags will be available for use in services</small>
                                        @error('tags')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- SEO Section -->
                        <div class="form-section">
                            <h5><i class="fa fa-search"></i> SEO Information</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>SEO Description (English) <small>(Max 500 characters)</small></label>
                                        <textarea class="form-control char-counter" name="seo_description_english" rows="4" maxlength="500" id="seo_description_english">{{ old('seo_description_english', $contactInfo->seo_description_english) }}</textarea>
                                        <div class="char-count" id="seo_description_english_count">0 / 500 characters</div>
                                        @error('seo_description_english')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>SEO Description (Arabic) <small>(Max 500 characters)</small> <button type="button" class="auto-translate-btn" data-translate-source="seo_description_english" data-translate-target="seo_description_arabic"><i class="fa fa-language"></i> Auto</button></label>
                                        <textarea class="form-control char-counter" name="seo_description_arabic" rows="4" maxlength="500" dir="rtl" id="seo_description_arabic">{{ old('seo_description_arabic', $contactInfo->seo_description_arabic) }}</textarea>
                                        <div class="char-count" id="seo_description_arabic_count">0 / 500 characters</div>
                                        @error('seo_description_arabic')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Contact Form Confirmation Email Section -->
                        <div class="form-section">
                            <h5><i class="fa fa-envelope"></i> Contact Form Confirmation Email</h5>
                            <p class="text-muted mb-3" style="font-size:13px;">
                                <i class="fa fa-info-circle"></i> This message will be sent to users after they submit the contact form. The email will automatically include WhatsApp, phone, branches, and website links. Leave empty to use the default message.
                            </p>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Confirmation Email Body (English) <small>(Max 2000 characters)</small></label>
                                        <textarea class="form-control char-counter" name="confirmation_email_body_en" rows="6" maxlength="2000" id="confirmation_email_body_en" placeholder="Thank you for reaching out to us!&#10;&#10;We have received your message and our team will get back to you as soon as possible.&#10;&#10;We appreciate your interest in our services and look forward to working with you.">{{ old('confirmation_email_body_en', $contactInfo->confirmation_email_body_en) }}</textarea>
                                        <div class="char-count" id="confirmation_email_body_en_count">0 / 2000 characters</div>
                                        @error('confirmation_email_body_en')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Confirmation Email Body (Arabic) <small>(Max 2000 characters)</small> <button type="button" class="auto-translate-btn" data-translate-source="confirmation_email_body_en" data-translate-target="confirmation_email_body_ar"><i class="fa fa-language"></i> Auto</button></label>
                                        <textarea class="form-control char-counter" name="confirmation_email_body_ar" rows="6" maxlength="2000" dir="rtl" id="confirmation_email_body_ar" placeholder="شكراً لتواصلك معنا!&#10;&#10;لقد استلمنا رسالتك وسيقوم فريقنا بالرد عليك في أقرب وقت ممكن.&#10;&#10;نقدر اهتمامك بخدماتنا ونتطلع للعمل معك.">{{ old('confirmation_email_body_ar', $contactInfo->confirmation_email_body_ar) }}</textarea>
                                        <div class="char-count" id="confirmation_email_body_ar_count">0 / 2000 characters</div>
                                        @error('confirmation_email_body_ar')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fa fa-save"></i> Save Contact Information
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('/js/auto-translate.js') }}"></script>
<script src="{{ asset('/js/tagify.min.js') }}"></script>

<script>
    $(document).ready(function() {
        // Initialize Tagify for tags input
        if(document.querySelector('.tagify')) {
            const input = document.querySelector('.tagify');
            new Tagify(input, {
                delimiters: ",",
                maxTags: 50,
                dropdown: {
                    enabled: 0
                }
            });
        }
        
        // Character counter function
        function updateCharCount(inputId, countId, maxChars) {
            const input = document.getElementById(inputId);
            const countDiv = document.getElementById(countId);
            
            if (input && countDiv) {
                function update() {
                    const charCount = input.value.length;
                    countDiv.textContent = `${charCount} / ${maxChars} characters`;
                    
                    if (charCount > maxChars) {
                        countDiv.classList.add('error');
                    } else {
                        countDiv.classList.remove('error');
                    }
                }
                
                // Update on load
                update();
                
                // Update on input
                input.addEventListener('input', update);
            }
        }
        
        // Apply character counters
        updateCharCount('footer_bio_english', 'footer_bio_english_count', 250);
        updateCharCount('footer_bio_arabic', 'footer_bio_arabic_count', 250);
        updateCharCount('seo_description_english', 'seo_description_english_count', 500);
        updateCharCount('seo_description_arabic', 'seo_description_arabic_count', 500);
        updateCharCount('confirmation_email_body_en', 'confirmation_email_body_en_count', 2000);
        updateCharCount('confirmation_email_body_ar', 'confirmation_email_body_ar_count', 2000);
    });
</script>
@endsection

