@extends('admin::layouts.master')
@section('title', 'Edit Partner')
@section('css')
<link rel="stylesheet" href="{{ asset('/css/tagify.css') }}">
@endsection
@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Admin')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a href="{{route('partner.index')}}" class="breadcrumbs__item"><i class="fa fa-handshake-o"></i> Partners List</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-pencil"></i> Edit Partner</a> 
        </nav>

        <div class="col-12 mx-auto">
            <hr>
            
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert" style="border-left: 4px solid #dc3545; font-size: 16px; padding: 15px 20px;">
                    <i class="fa fa-exclamation-circle" style="font-size: 20px;"></i> <strong>Error!</strong>
                    <ul class="mb-0" style="margin-top: 10px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            
            <div class="card m-b-20">
                <div class="card-body">
                    <div class="title d-flex justify-content-between">
                        <h4 class="mt-0 mb-0 header-title align-self-center text-capitalize">Edit Partner: {{ $partner->name_english }}</h4>
                        <div class="buttons">
                            <a href="{{ route('partner.index') }}" class="mr-2">
                                <button class="btn btn-new"><i class="fa fa-list"></i> Partners List</button>
                            </a>
                            <a href="{{ route('partner.show', ['id' => $partner->id]) }}" class="mr-2">
                                <button class="btn btn-info"><i class="fa fa-eye"></i> View Profile</button>
                            </a>
                            <button class="btn btn-primary" onclick="window.history.back()">
                                <i class="fa fa-angle-left"></i> Back
                            </button>
                        </div>
                    </div>
                    <hr>
                    
                    <form enctype="multipart/form-data" action="{{ route('partner.update', ['id' => $partner->id]) }}" method="POST">
                        @csrf
                        
                        <!-- Type Selection -->
                        <h5 class="mb-3 text-primary">Type Selection</h5>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Type <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <select class="form-control" name="partner_type" id="partner_type" required>
                                    <option value="partner" {{ old('partner_type', $partner->partner_type) == 'partner' ? 'selected' : '' }}>Partner</option>
                                    <option value="branch" {{ old('partner_type', $partner->partner_type) == 'branch' ? 'selected' : '' }}>Branch</option>
                                    <option value="government" {{ old('partner_type', $partner->partner_type) == 'government' ? 'selected' : '' }}>Government Partner</option>
                                </select>
                                @error('partner_type')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                                <small class="text-muted" id="type-hint">Select partner type. Government partners only require name and logo.</small>
                            </div>
                        </div>
                        
                        <!-- Basic Information -->
                        <h5 class="mb-3 mt-4 text-primary">Basic Information</h5>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">English Name <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <input class="form-control" value="{{old('name_english', $partner->name_english)}}" type="text" name="name_english" required>
                                @error('name_english')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Arabic Name <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <input class="form-control" value="{{old('name_arabic', $partner->name_arabic)}}" type="text" name="name_arabic" required>
                                @error('name_arabic')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <!-- Contact Information - Hidden for Government -->
                        <div id="contact-section" class="partner-section">
                        <h5 class="mb-3 mt-4 text-primary">Contact Information</h5>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label class="text-capitalize">Email <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger required-icon"></i></label>
                                <input class="form-control" value="{{old('email', $partner->email)}}" type="email" name="email" id="email_field">
                                @error('email')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label class="text-capitalize">Mobile <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger required-icon"></i></label>
                                <input class="form-control" value="{{old('mobile', $partner->mobile)}}" type="text" name="mobile" id="mobile_field">
                                @error('mobile')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label class="text-capitalize">Office Number</label>
                                <input class="form-control" value="{{old('office_number', $partner->office_number)}}" type="text" name="office_number">
                                @error('office_number')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Tax Number</label>
                                <input class="form-control" value="{{old('tax_number', $partner->tax_number)}}" type="text" name="tax_number">
                                @error('tax_number')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Opening Hours</label>
                                <input class="form-control" value="{{old('opening_hours', $partner->opening_hours)}}" type="text" name="opening_hours" placeholder="e.g., Mon-Fri 9AM-5PM">
                                @error('opening_hours')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        </div>

                        <!-- Location Information - Hidden for Government -->
                        <div id="location-section" class="partner-section">
                        <h5 class="mb-3 mt-4 text-primary">Location Information</h5>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Location Text (English)</label>
                                <textarea class="form-control" name="location_text_english" rows="3">{{old('location_text_english', $partner->location_text_english)}}</textarea>
                                @error('location_text_english')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Location Text (Arabic)</label>
                                <textarea class="form-control" name="location_text_arabic" rows="3">{{old('location_text_arabic', $partner->location_text_arabic)}}</textarea>
                                @error('location_text_arabic')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group col-md-12">
                                <label class="text-capitalize">Map URL</label>
                                <textarea class="form-control" name="map_url" rows="3" placeholder="Google Maps embed URL or iframe code">{{old('map_url', $partner->map_url)}}</textarea>
                                @error('map_url')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        </div>

                        <!-- Social Media Links - Hidden for Government -->
                        <div id="social-section" class="partner-section">
                        <h5 class="mb-3 mt-4 text-primary">Social Media Links</h5>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Website URL</label>
                                <input class="form-control" value="{{old('website_url', $partner->website_url)}}" type="url" name="website_url">
                                @error('website_url')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Facebook URL</label>
                                <input class="form-control" value="{{old('facebook_url', $partner->facebook_url)}}" type="url" name="facebook_url">
                                @error('facebook_url')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Instagram URL</label>
                                <input class="form-control" value="{{old('instagram_url', $partner->instagram_url)}}" type="url" name="instagram_url">
                                @error('instagram_url')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">LinkedIn URL</label>
                                <input class="form-control" value="{{old('linkedin_url', $partner->linkedin_url)}}" type="url" name="linkedin_url">
                                @error('linkedin_url')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Twitter URL</label>
                                <input class="form-control" value="{{old('twitter_url', $partner->twitter_url)}}" type="url" name="twitter_url">
                                @error('twitter_url')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        </div>

                        <!-- Logos -->
                        <h5 class="mb-3 mt-4 text-primary">Logos</h5>
                        <div class="alert alert-light border mb-3" style="background: #f8f9fa;">
                            <i class="fa fa-info-circle text-info mr-2"></i>
                            <strong>Logo Guidelines:</strong>
                            <ul class="mb-0 mt-2" style="font-size: 13px;">
                                <li><strong>Recommended Size:</strong> <code>200 x 80 px</code> (or proportional)</li>
                                <li><strong>Format:</strong> PNG with transparent background preferred</li>
                                <li><strong>Max File Size:</strong> 2MB</li>
                                <li><strong>Usage:</strong> Partner/Branch logos will be displayed in sliders, cards, and listing pages</li>
                            </ul>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Logo (English)</label>
                                @if($partner->logo_english)
                                    <div class="mb-2">
                                        <img src="{{url('/storage'.$partner->logo_english)}}" alt="Current Logo EN" style="max-width: 200px; max-height: 200px; object-fit: contain;">
                                    </div>
                                @endif
                                <input accept="image/*" class="form-control dropify" type="file" name="logo_english" data-default-file="{{$partner->logo_english ? url('/storage'.$partner->logo_english) : ''}}">
                                <small class="text-muted">Recommended: <strong>200x80px</strong>, PNG transparent</small>
                                @error('logo_english')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Logo (Arabic)</label>
                                @if($partner->logo_arabic)
                                    <div class="mb-2">
                                        <img src="{{url('/storage'.$partner->logo_arabic)}}" alt="Current Logo AR" style="max-width: 200px; max-height: 200px; object-fit: contain;">
                                    </div>
                                @endif
                                <input accept="image/*" class="form-control dropify" type="file" name="logo_arabic" data-default-file="{{$partner->logo_arabic ? url('/storage'.$partner->logo_arabic) : ''}}">
                                <small class="text-muted">Recommended: <strong>200x80px</strong>, PNG transparent</small>
                                @error('logo_arabic')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <!-- About, Mission, Vision - Hidden for Government -->
                        <div id="about-section" class="partner-section">
                        <h5 class="mb-3 mt-4 text-primary">About, Mission & Vision</h5>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label class="text-capitalize">About (English)</label>
                                <textarea id="elm1" class="form-control" name="about_english">{!!old('about_english', $partner->about_english)!!}</textarea>
                                @error('about_english')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group col-md-12">
                                <label class="text-capitalize">About (Arabic)</label>
                                <textarea id="elm2" class="form-control" name="about_arabic">{!!old('about_arabic', $partner->about_arabic)!!}</textarea>
                                @error('about_arabic')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group col-md-12">
                                <label class="text-capitalize">Mission (English)</label>
                                <textarea id="elm3" class="form-control" name="mission_english">{!!old('mission_english', $partner->mission_english)!!}</textarea>
                                @error('mission_english')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group col-md-12">
                                <label class="text-capitalize">Mission (Arabic)</label>
                                <textarea id="elm4" class="form-control" name="mission_arabic">{!!old('mission_arabic', $partner->mission_arabic)!!}</textarea>
                                @error('mission_arabic')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group col-md-12">
                                <label class="text-capitalize">Vision (English)</label>
                                <textarea id="elm5" class="form-control" name="vision_english">{!!old('vision_english', $partner->vision_english)!!}</textarea>
                                @error('vision_english')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group col-md-12">
                                <label class="text-capitalize">Vision (Arabic)</label>
                                <textarea id="elm6" class="form-control" name="vision_arabic">{!!old('vision_arabic', $partner->vision_arabic)!!}</textarea>
                                @error('vision_arabic')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        </div>

                        <!-- SEO Information - Hidden for Government -->
                        <div id="seo-section" class="partner-section">
                        <h5 class="mb-3 mt-4 text-primary">SEO Information</h5>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label>SEO Tags <span class="text-muted">Press Enter After You Type</span></label>
                                <input name="seo_tags" value="{{old('seo_tags', $partner->seo_tags)}}" class="tagify form-control">
                                @error('seo_tags')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label>SEO Description (English)</label>
                                <textarea name="seo_description_english" class="form-control" maxlength="225" rows="3">{{old('seo_description_english', $partner->seo_description_english)}}</textarea>
                                @error('seo_description_english')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label>SEO Description (Arabic)</label>
                                <textarea name="seo_description_arabic" class="form-control" maxlength="225" rows="3">{{old('seo_description_arabic', $partner->seo_description_arabic)}}</textarea>
                                @error('seo_description_arabic')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        </div>

                        <hr>
                        <div class="form-group mb-0">
                            <div>
                                <button type="submit" class="btn btn-dark waves-effect waves-light mr-2">
                                    <i class="fa fa-save"></i> Update
                                </button>
                                <button type="reset" class="btn btn-primary waves-effect m-l-5" onclick="window.history.back()">
                                    <i class="fa fa-times"></i> Cancel
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('/js/tagify.min.js') }}"></script>
<script src="{{ asset('/js/dropify.min.js') }}"></script>

<script>
    $('.dropify').dropify();
    
    // Toggle sections based on partner type
    function togglePartnerSections() {
        var partnerType = $('#partner_type').val();
        var isGovernment = partnerType === 'government';
        
        if (isGovernment) {
            // Hide all extra sections for government partners
            $('.partner-section').slideUp(300);
            // Remove required from email and mobile
            $('#email_field').removeAttr('required');
            $('#mobile_field').removeAttr('required');
            // Update hint text
            $('#type-hint').html('<i class="fa fa-building text-success"></i> Government partner - only name and logo required.');
        } else {
            // Show all sections for partners/branches
            $('.partner-section').slideDown(300);
            // Add required back to email and mobile
            $('#email_field').attr('required', true);
            $('#mobile_field').attr('required', true);
            // Update hint text
            $('#type-hint').html('Select partner type. Government partners only require name and logo.');
        }
    }
    
    // Run on page load
    $(document).ready(function() {
        togglePartnerSections();
        
        // Run on change
        $('#partner_type').on('change', function() {
            togglePartnerSections();
        });
    });
</script>

<script>
    if(document.querySelectorAll('.tagify').length > 0){
        const el = document.querySelector('.tagify');
        new Tagify(el);
    }
</script>
@endsection

