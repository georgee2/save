@extends('admin::layouts.master')
@section('title', 'Partner Profile')
@section('css')
<style>
    .partner-show-container {
        display: flex;
        gap: 20px;
        min-height: 600px;
    }
    
    /* Left Section Styles */
    .left-section {
        flex: 0 0 350px;
        background: #fff;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        height: fit-content;
        position: sticky;
        top: 20px;
    }
    
    .partner-logo {
        width: 100%;
        height: 200px;
        object-fit: contain;
        border-radius: 8px;
        margin-bottom: 20px;
        padding: 15px;
        background: #f8f9fa;
    }
    
    .partner-title {
        font-size: 22px;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 15px;
        line-height: 1.4;
    }
    
    .partner-meta-item {
        padding: 12px 0;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .partner-meta-item:last-child {
        border-bottom: none;
    }
    
    .partner-meta-label {
        font-size: 12px;
        color: #7f8c8d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 5px;
        font-weight: 600;
    }
    
    .partner-meta-value {
        font-size: 14px;
        color: #2c3e50;
        font-weight: 500;
    }
    
    /* Right Section Styles */
    .right-section {
        flex: 1;
        display: flex;
        gap: 15px;
    }
    
    /* Vertical Tabs Styles */
    .vertical-tabs {
        flex: 0 0 220px;
        background: #fff;
        border-radius: 8px;
        padding: 15px 0;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        height: fit-content;
    }
    
    .vertical-tab-item {
        padding: 15px 20px;
        cursor: pointer;
        transition: all 0.3s ease;
        border-left: 3px solid transparent;
        color: #5a6c7d;
        font-weight: 500;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .vertical-tab-item:hover {
        background: #f8f9fa;
        color: #2c3e50;
    }
    
    .vertical-tab-item.active {
        background: #e3f2fd;
        border-left-color: #2196F3;
        color: #2196F3;
        font-weight: 600;
    }
    
    .vertical-tab-item i {
        font-size: 16px;
        width: 20px;
    }
    
    /* Tab Content Styles */
    .tab-content-area {
        flex: 1;
        background: #fff;
        border-radius: 8px;
        padding: 25px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .tab-pane {
        display: none;
        animation: fadeIn 0.3s ease-in;
    }
    
    .tab-pane.active {
        display: block;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .tab-content-title {
        font-size: 20px;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #f0f0f0;
    }
    
    .info-row {
        display: flex;
        padding: 12px 0;
        border-bottom: 1px solid #f8f9fa;
    }
    
    .info-row:last-child {
        border-bottom: none;
    }
    
    .info-label {
        flex: 0 0 200px;
        font-weight: 600;
        color: #5a6c7d;
        font-size: 14px;
    }
    
    .info-value {
        flex: 1;
        color: #2c3e50;
        font-size: 14px;
    }
    
    .content-box {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 6px;
        margin-top: 10px;
        line-height: 1.6;
    }
    
    .logo-display {
        max-width: 100%;
        max-height: 250px;
        object-fit: contain;
        border-radius: 6px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        background: #f8f9fa;
        padding: 15px;
    }
    
    @media (max-width: 992px) {
        .partner-show-container {
            flex-direction: column;
        }
        
        .left-section {
            flex: 1;
            position: relative;
            top: 0;
        }
        
        .right-section {
            flex-direction: column;
        }
        
        .vertical-tabs {
            flex: 1;
            display: flex;
            overflow-x: auto;
            padding: 0;
        }
        
        .vertical-tab-item {
            border-left: none;
            border-bottom: 3px solid transparent;
            white-space: nowrap;
        }
        
        .vertical-tab-item.active {
            border-left: none;
            border-bottom-color: #2196F3;
        }
    }
</style>
@endsection

@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Admin')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a href="{{route('partner.index')}}" class="breadcrumbs__item"><i class="fa fa-handshake-o"></i> Partners List</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-eye"></i> Partner Profile</a> 
        </nav>

        <div class="col-12 mx-auto">
            <hr>
            
            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert" style="border-left: 4px solid #28a745; font-size: 16px; padding: 15px 20px;">
                    <i class="fa fa-check-circle" style="font-size: 20px;"></i> <strong>Success!</strong> {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            
            <!-- Header with Action Buttons -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="mt-0 mb-0 header-title">Partner Profile</h4>
                <div class="buttons">
                    <a href="{{ route('partner.index') }}" class="mr-2">
                        <button class="btn btn-new"><i class="fa fa-list"></i> Partners List</button>
                    </a>
                    <a href="{{ route('partner.edit', ['id' => $partner->id]) }}" class="mr-2">
                        <button class="btn btn-warning"><i class="fa fa-pencil"></i> Edit Partner</button>
                    </a>
                    <button class="btn btn-primary" onclick="window.history.back()">
                        <i class="fa fa-angle-left"></i> Back
                    </button>
                </div>
            </div>
            
            <!-- Main Content Layout -->
            <div class="partner-show-container">
                
                <!-- Left Section -->
                <div class="left-section">
                    @if($partner->logo_english)
                        <img src="{{url('/storage'.$partner->logo_english)}}" alt="{{ $partner->name_english }}" class="partner-logo">
                    @else
                        <div class="partner-logo" style="background: #f0f0f0; display: flex; align-items: center; justify-content: center; color: #999;">
                            <i class="fa fa-image" style="font-size: 48px;"></i>
                        </div>
                    @endif
                    
                    <h3 class="partner-title">{{ $partner->name_english }}</h3>
                    
                    @if($partner->email)
                    <div class="partner-meta-item">
                        <div class="partner-meta-label">Email</div>
                        <div class="partner-meta-value">
                            <a href="mailto:{{ $partner->email }}">{{ $partner->email }}</a>
                        </div>
                    </div>
                    @endif
                    
                    @if($partner->mobile)
                    <div class="partner-meta-item">
                        <div class="partner-meta-label">Mobile</div>
                        <div class="partner-meta-value">
                            <a href="tel:{{ $partner->mobile }}">{{ $partner->mobile }}</a>
                        </div>
                    </div>
                    @endif
                    
                    @if($partner->office_number)
                    <div class="partner-meta-item">
                        <div class="partner-meta-label">Office Number</div>
                        <div class="partner-meta-value">
                            <a href="tel:{{ $partner->office_number }}">{{ $partner->office_number }}</a>
                        </div>
                    </div>
                    @endif
                    
                    @if($partner->website_url)
                    <div class="partner-meta-item">
                        <div class="partner-meta-label">Website</div>
                        <div class="partner-meta-value">
                            <a href="{{ $partner->website_url }}" target="_blank"><i class="fa fa-external-link"></i> Visit Website</a>
                        </div>
                    </div>
                    @endif
                    
                    @if($partner->opening_hours)
                    <div class="partner-meta-item">
                        <div class="partner-meta-label">Opening Hours</div>
                        <div class="partner-meta-value">
                            <i class="fa fa-clock-o"></i> {{ $partner->opening_hours }}
                        </div>
                    </div>
                    @endif
                </div>
                
                <!-- Right Section with Vertical Tabs -->
                <div class="right-section">
                    
                    <!-- Vertical Tabs Navigation -->
                    <div class="vertical-tabs">
                        <div class="vertical-tab-item active" data-tab="basic-info">
                            <i class="fa fa-info-circle"></i>
                            <span>Basic Information</span>
                        </div>
                        <div class="vertical-tab-item" data-tab="contact">
                            <i class="fa fa-phone"></i>
                            <span>Contact & Location</span>
                        </div>
                        <div class="vertical-tab-item" data-tab="social">
                            <i class="fa fa-globe"></i>
                            <span>Social Media</span>
                        </div>
                        <div class="vertical-tab-item" data-tab="logos">
                            <i class="fa fa-image"></i>
                            <span>Logos</span>
                        </div>
                        <div class="vertical-tab-item" data-tab="about">
                            <i class="fa fa-file-text"></i>
                            <span>About</span>
                        </div>
                        <div class="vertical-tab-item" data-tab="mission">
                            <i class="fa fa-bullseye"></i>
                            <span>Mission</span>
                        </div>
                        <div class="vertical-tab-item" data-tab="vision">
                            <i class="fa fa-eye"></i>
                            <span>Vision</span>
                        </div>
                        <div class="vertical-tab-item" data-tab="seo">
                            <i class="fa fa-search"></i>
                            <span>SEO Information</span>
                        </div>
                        <div class="vertical-tab-item" data-tab="timestamps">
                            <i class="fa fa-clock-o"></i>
                            <span>Timestamps</span>
                        </div>
                    </div>
                    
                    <!-- Tab Content Area -->
                    <div class="tab-content-area">
                        
                        <!-- Basic Information Tab -->
                        <div class="tab-pane active" id="basic-info">
                            <h5 class="tab-content-title">Basic Information</h5>
                            
                            <div class="info-row">
                                <div class="info-label">Partner ID:</div>
                                <div class="info-value">{{ $partner->id }}</div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">English Name:</div>
                                <div class="info-value">{{ $partner->name_english }}</div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">Arabic Name:</div>
                                <div class="info-value">{{ $partner->name_arabic }}</div>
                            </div>
                            
                            @if($partner->tax_number)
                            <div class="info-row">
                                <div class="info-label">Tax Number:</div>
                                <div class="info-value">{{ $partner->tax_number }}</div>
                            </div>
                            @endif
                            
                            @if($partner->opening_hours)
                            <div class="info-row">
                                <div class="info-label">Opening Hours:</div>
                                <div class="info-value"><i class="fa fa-clock-o"></i> {{ $partner->opening_hours }}</div>
                            </div>
                            @endif
                        </div>
                        
                        <!-- Contact & Location Tab -->
                        <div class="tab-pane" id="contact">
                            <h5 class="tab-content-title">Contact & Location Information</h5>
                            
                            <div class="info-row">
                                <div class="info-label">Email:</div>
                                <div class="info-value">
                                    <a href="mailto:{{ $partner->email }}"><i class="fa fa-envelope"></i> {{ $partner->email }}</a>
                                </div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">Mobile:</div>
                                <div class="info-value">
                                    <a href="tel:{{ $partner->mobile }}"><i class="fa fa-phone"></i> {{ $partner->mobile }}</a>
                                </div>
                            </div>
                            
                            @if($partner->office_number)
                            <div class="info-row">
                                <div class="info-label">Office Number:</div>
                                <div class="info-value">
                                    <a href="tel:{{ $partner->office_number }}"><i class="fa fa-phone-square"></i> {{ $partner->office_number }}</a>
                                </div>
                            </div>
                            @endif
                            
                            @if($partner->location_text_english || $partner->location_text_arabic)
                            <hr class="my-4">
                            <h6 style="font-weight: 600; color: #5a6c7d; margin-bottom: 15px;"><i class="fa fa-map-marker"></i> Location</h6>
                            @endif
                            
                            @if($partner->location_text_english)
                            <div class="mb-3">
                                <div class="info-label mb-2">Location (English):</div>
                                <div class="content-box">{{ $partner->location_text_english }}</div>
                            </div>
                            @endif
                            
                            @if($partner->location_text_arabic)
                            <div class="mb-3">
                                <div class="info-label mb-2">Location (Arabic):</div>
                                <div class="content-box">{{ $partner->location_text_arabic }}</div>
                            </div>
                            @endif
                            
                            @if($partner->map_url)
                            <div class="info-row">
                                <div class="info-label">Map URL:</div>
                                <div class="info-value">
                                    <a href="{{ $partner->map_url }}" target="_blank"><i class="fa fa-map"></i> View on Map</a>
                                </div>
                            </div>
                            @endif
                        </div>
                        
                        <!-- Social Media Tab -->
                        <div class="tab-pane" id="social">
                            <h5 class="tab-content-title">Social Media & Website</h5>
                            
                            @if($partner->website_url || $partner->facebook_url || $partner->instagram_url || $partner->linkedin_url || $partner->twitter_url)
                                @if($partner->website_url)
                                <div class="info-row">
                                    <div class="info-label"><i class="fa fa-link"></i> Website:</div>
                                    <div class="info-value">
                                        <a href="{{ $partner->website_url }}" target="_blank">{{ $partner->website_url }}</a>
                                    </div>
                                </div>
                                @endif
                                
                                @if($partner->facebook_url)
                                <div class="info-row">
                                    <div class="info-label"><i class="fa fa-facebook"></i> Facebook:</div>
                                    <div class="info-value">
                                        <a href="{{ $partner->facebook_url }}" target="_blank">{{ $partner->facebook_url }}</a>
                                    </div>
                                </div>
                                @endif
                                
                                @if($partner->instagram_url)
                                <div class="info-row">
                                    <div class="info-label"><i class="fa fa-instagram"></i> Instagram:</div>
                                    <div class="info-value">
                                        <a href="{{ $partner->instagram_url }}" target="_blank">{{ $partner->instagram_url }}</a>
                                    </div>
                                </div>
                                @endif
                                
                                @if($partner->linkedin_url)
                                <div class="info-row">
                                    <div class="info-label"><i class="fa fa-linkedin"></i> LinkedIn:</div>
                                    <div class="info-value">
                                        <a href="{{ $partner->linkedin_url }}" target="_blank">{{ $partner->linkedin_url }}</a>
                                    </div>
                                </div>
                                @endif
                                
                                @if($partner->twitter_url)
                                <div class="info-row">
                                    <div class="info-label"><i class="fa fa-twitter"></i> Twitter:</div>
                                    <div class="info-value">
                                        <a href="{{ $partner->twitter_url }}" target="_blank">{{ $partner->twitter_url }}</a>
                                    </div>
                                </div>
                                @endif
                            @else
                                <div class="alert alert-info">
                                    <i class="fa fa-info-circle"></i> No social media links available.
                                </div>
                            @endif
                        </div>
                        
                        <!-- Logos Tab -->
                        <div class="tab-pane" id="logos">
                            <h5 class="tab-content-title">Company Logos</h5>
                            
                            <div class="mb-4">
                                <div class="info-label mb-3">Logo (English):</div>
                                @if($partner->logo_english)
                                    <img src="{{url('/storage'.$partner->logo_english)}}" alt="Logo English" class="logo-display">
                                @else
                                    <div class="alert alert-warning">
                                        <i class="fa fa-exclamation-triangle"></i> No English logo available.
                                    </div>
                                @endif
                            </div>
                            
                            <div class="mb-4">
                                <div class="info-label mb-3">Logo (Arabic):</div>
                                @if($partner->logo_arabic)
                                    <img src="{{url('/storage'.$partner->logo_arabic)}}" alt="Logo Arabic" class="logo-display">
                                @else
                                    <div class="alert alert-warning">
                                        <i class="fa fa-exclamation-triangle"></i> No Arabic logo available.
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        <!-- About Tab -->
                        <div class="tab-pane" id="about">
                            <h5 class="tab-content-title">About</h5>
                            
                            @if($partner->about_english || $partner->about_arabic)
                                @if($partner->about_english)
                                <div class="mb-4">
                                    <div class="info-label mb-2">About (English):</div>
                                    <div class="content-box">
                                        {!! $partner->about_english !!}
                                    </div>
                                </div>
                                @endif
                                
                                @if($partner->about_arabic)
                                <div class="mb-4">
                                    <div class="info-label mb-2">About (Arabic):</div>
                                    <div class="content-box">
                                        {!! $partner->about_arabic !!}
                                    </div>
                                </div>
                                @endif
                            @else
                                <div class="alert alert-info">
                                    <i class="fa fa-info-circle"></i> No about information available.
                                </div>
                            @endif
                        </div>
                        
                        <!-- Mission Tab -->
                        <div class="tab-pane" id="mission">
                            <h5 class="tab-content-title">Mission</h5>
                            
                            @if($partner->mission_english || $partner->mission_arabic)
                                @if($partner->mission_english)
                                <div class="mb-4">
                                    <div class="info-label mb-2">Mission (English):</div>
                                    <div class="content-box">
                                        {!! $partner->mission_english !!}
                                    </div>
                                </div>
                                @endif
                                
                                @if($partner->mission_arabic)
                                <div class="mb-4">
                                    <div class="info-label mb-2">Mission (Arabic):</div>
                                    <div class="content-box">
                                        {!! $partner->mission_arabic !!}
                                    </div>
                                </div>
                                @endif
                            @else
                                <div class="alert alert-info">
                                    <i class="fa fa-info-circle"></i> No mission information available.
                                </div>
                            @endif
                        </div>
                        
                        <!-- Vision Tab -->
                        <div class="tab-pane" id="vision">
                            <h5 class="tab-content-title">Vision</h5>
                            
                            @if($partner->vision_english || $partner->vision_arabic)
                                @if($partner->vision_english)
                                <div class="mb-4">
                                    <div class="info-label mb-2">Vision (English):</div>
                                    <div class="content-box">
                                        {!! $partner->vision_english !!}
                                    </div>
                                </div>
                                @endif
                                
                                @if($partner->vision_arabic)
                                <div class="mb-4">
                                    <div class="info-label mb-2">Vision (Arabic):</div>
                                    <div class="content-box">
                                        {!! $partner->vision_arabic !!}
                                    </div>
                                </div>
                                @endif
                            @else
                                <div class="alert alert-info">
                                    <i class="fa fa-info-circle"></i> No vision information available.
                                </div>
                            @endif
                        </div>
                        
                        <!-- SEO Tab -->
                        <div class="tab-pane" id="seo">
                            <h5 class="tab-content-title">SEO Information</h5>
                            
                            @if($partner->seo_tags || $partner->seo_description_english || $partner->seo_description_arabic)
                                @if($partner->seo_tags)
                                <div class="info-row">
                                    <div class="info-label">SEO Tags:</div>
                                    <div class="info-value">
                                        <span class="badge badge-primary" style="font-size: 13px; padding: 5px 10px; margin-right: 5px;">{{ $partner->seo_tags }}</span>
                                    </div>
                                </div>
                                @endif
                                
                                @if($partner->seo_description_english)
                                <div class="info-row">
                                    <div class="info-label">SEO Description (English):</div>
                                    <div class="info-value">{{ $partner->seo_description_english }}</div>
                                </div>
                                @endif
                                
                                @if($partner->seo_description_arabic)
                                <div class="info-row">
                                    <div class="info-label">SEO Description (Arabic):</div>
                                    <div class="info-value">{{ $partner->seo_description_arabic }}</div>
                                </div>
                                @endif
                            @else
                                <div class="alert alert-info">
                                    <i class="fa fa-info-circle"></i> No SEO information available for this partner.
                                </div>
                            @endif
                        </div>
                        
                        <!-- Timestamps Tab -->
                        <div class="tab-pane" id="timestamps">
                            <h5 class="tab-content-title">Timestamps</h5>
                            
                            <div class="info-row">
                                <div class="info-label">Created At:</div>
                                <div class="info-value">
                                    <i class="fa fa-calendar"></i> {{ \Carbon\Carbon::parse($partner->created_at)->format('F d, Y h:i A') }}
                                </div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">Updated At:</div>
                                <div class="info-value">
                                    <i class="fa fa-calendar"></i> {{ \Carbon\Carbon::parse($partner->updated_at)->format('F d, Y h:i A') }}
                                </div>
                            </div>
                            
                            @if($partner->deleted_at)
                            <div class="info-row">
                                <div class="info-label">Deleted At:</div>
                                <div class="info-value">
                                    <i class="fa fa-calendar"></i> {{ \Carbon\Carbon::parse($partner->deleted_at)->format('F d, Y h:i A') }}
                                </div>
                            </div>
                            @endif
                        </div>
                        
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    // Vertical Tabs Functionality
    document.addEventListener('DOMContentLoaded', function() {
        const tabItems = document.querySelectorAll('.vertical-tab-item');
        const tabPanes = document.querySelectorAll('.tab-pane');
        
        tabItems.forEach(item => {
            item.addEventListener('click', function() {
                const targetTab = this.getAttribute('data-tab');
                
                // Remove active class from all tabs and panes
                tabItems.forEach(tab => tab.classList.remove('active'));
                tabPanes.forEach(pane => pane.classList.remove('active'));
                
                // Add active class to clicked tab and corresponding pane
                this.classList.add('active');
                document.getElementById(targetTab).classList.add('active');
            });
        });
    });
</script>
@endsection
