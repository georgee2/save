@extends('admin::layouts.master')
@section('title', 'Showcase Details')

@section('css')
<link rel="stylesheet" href="{{ asset('/css/dropify.min.css') }}">
<link href="{{ asset('/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<style>
    .showcase-show-container {
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
    
    .showcase-main-image {
        width: 100%;
        height: 250px;
        object-fit: cover;
        border-radius: 8px;
        margin-bottom: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .showcase-title {
        font-size: 22px;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 15px;
        line-height: 1.4;
    }
    
    .showcase-meta-item {
        padding: 12px 0;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .showcase-meta-item:last-child {
        border-bottom: none;
    }
    
    .showcase-meta-label {
        font-size: 12px;
        color: #7f8c8d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 5px;
        font-weight: 600;
    }
    
    .showcase-meta-value {
        font-size: 14px;
        color: #2c3e50;
        font-weight: 500;
    }
    
    /* Right Section with Tabs */
    .right-section {
        flex: 1;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        overflow: hidden;
        display: flex;
    }
    
    /* Vertical Tabs */
    .vertical-tabs {
        flex: 0 0 220px;
        background: #f8f9fa;
        border-right: 1px solid #e9ecef;
        padding: 20px 0;
    }
    
    .vertical-tab-item {
        padding: 15px 20px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 12px;
        color: #5a6c7d;
        font-size: 14px;
        font-weight: 500;
        border-left: 3px solid transparent;
    }
    
    .vertical-tab-item:hover {
        background: #e9ecef;
        color: #2c3e50;
    }
    
    .vertical-tab-item.active {
        background: #fff;
        color: #5369f8;
        border-left-color: #5369f8;
    }
    
    .vertical-tab-item i {
        font-size: 16px;
        width: 20px;
        text-align: center;
    }
    
    /* Tab Content */
    .tab-content-area {
        flex: 1;
        padding: 30px;
        overflow-y: auto;
        max-height: 800px;
    }
    
    .tab-pane {
        display: none;
    }
    
    .tab-pane.active {
        display: block;
        animation: fadeIn 0.3s ease;
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .tab-content-title {
        font-size: 20px;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 2px solid #f0f0f0;
    }
    
    .info-row {
        display: flex;
        padding: 15px 0;
        border-bottom: 1px solid #f0f0f0;
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
    
    .image-preview {
        max-width: 100%;
        max-height: 400px;
        border-radius: 6px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        cursor: pointer;
        transition: transform 0.3s ease;
    }
    
    .image-preview:hover {
        transform: scale(1.02);
    }
    
    .description-content {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 6px;
        margin-top: 10px;
        line-height: 1.6;
    }
    
    @media (max-width: 992px) {
        .showcase-show-container {
            flex-direction: column;
        }
        
        .left-section {
            flex: 1;
            position: relative;
        }
        
        .right-section {
            flex-direction: column;
        }
        
        .vertical-tabs {
            flex: 1;
            display: flex;
            overflow-x: auto;
            border-right: none;
            border-bottom: 1px solid #e9ecef;
            padding: 0;
        }
        
        .vertical-tab-item {
            border-left: none;
            border-bottom: 3px solid transparent;
            white-space: nowrap;
        }
        
        .vertical-tab-item.active {
            border-left: none;
            border-bottom-color: #5369f8;
        }
    }
</style>
@endsection

@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Admin')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a href="{{route('showcase.index')}}" class="breadcrumbs__item"><i class="fa fa-star"></i> Showcases List</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-eye"></i> Showcase Details</a> 
        </nav>

        <div class="col-lg-12">
            <hr>
            
            <!-- Success/Error Messages -->
            <div id="notification-area">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert" style="border-left: 4px solid #28a745; font-size: 16px; padding: 15px 20px;">
                        <i class="fa fa-check-circle" style="font-size: 20px;"></i> <strong>Success!</strong> {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                
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
            </div>
            
            <!-- Header with Action Buttons -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="mt-0 mb-0 header-title">Showcase Details</h4>
                <div class="buttons">
                    <a href="{{ route('showcase.index') }}" class="mr-2">
                        <button class="btn btn-new"><i class="fa fa-list"></i> Showcases List</button>
                    </a>
                    <a href="{{ route('showcase.edit', ['id' => $showcase->id]) }}" class="mr-2">
                        <button class="btn btn-primary"><i class="fa fa-edit"></i> Edit Showcase</button>
                    </a>
                    <button class="btn btn-secondary" onclick="window.history.back()">
                        <i class="fa fa-angle-left"></i> Back
                    </button>
                </div>
            </div>
            
            <!-- Main Content Layout -->
            <div class="showcase-show-container">
                
                <!-- Left Section -->
                <div class="left-section">
                    @if($showcase->main_image)
                        <img src="{{url('/storage' . $showcase->main_image)}}" alt="{{ $showcase->title_english }}" class="showcase-main-image">
                    @else
                        <div class="showcase-main-image" style="background: #f0f0f0; display: flex; align-items: center; justify-content: center; color: #999;">
                            <i class="fa fa-image" style="font-size: 48px;"></i>
                        </div>
                    @endif
                    
                    <h3 class="showcase-title">
                        @if(App::getLocale() == 'en')
                            {{ $showcase->title_english }}
                        @else
                            {{ $showcase->title_arabic }}
                        @endif
                    </h3>
                    
                    <div class="showcase-meta-item">
                        <div class="showcase-meta-label">Status</div>
                        <div class="showcase-meta-value">
                            @if($showcase->status == 'active')
                                <span class="badge badge-success"><i class="fa fa-check-circle"></i> Active</span>
                            @else
                                <span class="badge badge-secondary"><i class="fa fa-times-circle"></i> Inactive</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="showcase-meta-item">
                        <div class="showcase-meta-label">Home Status</div>
                        <div class="showcase-meta-value">
                            @if($showcase->home_status == 'shown')
                                <span class="badge badge-info"><i class="fa fa-eye"></i> Shown on Home</span>
                            @else
                                <span class="badge badge-warning"><i class="fa fa-eye-slash"></i> Not Shown</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="showcase-meta-item">
                        <div class="showcase-meta-label">Slug</div>
                        <div class="showcase-meta-value">
                            <code>{{ $showcase->slug }}</code>
                        </div>
                    </div>
                    
                    <div class="showcase-meta-item">
                        <div class="showcase-meta-label">Created At</div>
                        <div class="showcase-meta-value">
                            {{ $showcase->created_at->format('M d, Y H:i') }}
                        </div>
                    </div>
                    
                    <div class="showcase-meta-item">
                        <div class="showcase-meta-label">Last Updated</div>
                        <div class="showcase-meta-value">
                            {{ $showcase->updated_at->format('M d, Y H:i') }}
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="showcase-actions mt-4">
                        <div class="showcase-meta-label mb-3">Quick Actions</div>
                        
                        <!-- Toggle Status Button -->
                        @if($showcase->status == 'active')
                            <button class="btn btn-warning btn-block mb-2" onclick="toggleStatus('inactive')">
                                <i class="fa fa-times-circle"></i> Set as Inactive
                            </button>
                        @else
                            <button class="btn btn-success btn-block mb-2" onclick="toggleStatus('active')">
                                <i class="fa fa-check-circle"></i> Set as Active
                            </button>
                        @endif
                        
                        <!-- Toggle Home Status Button -->
                        @if($showcase->home_status == 'shown')
                            <button class="btn btn-secondary btn-block mb-2" onclick="toggleHomeStatus('not_shown')">
                                <i class="fa fa-eye-slash"></i> Hide from Home
                            </button>
                        @else
                            <button class="btn btn-info btn-block mb-2" onclick="toggleHomeStatus('shown')">
                                <i class="fa fa-eye"></i> Show on Home
                            </button>
                        @endif
                        
                        <!-- Edit Button -->
                        <a href="{{ route('showcase.edit', ['id' => $showcase->id]) }}" class="btn btn-primary btn-block">
                            <i class="fa fa-edit"></i> Edit Showcase
                        </a>
                    </div>
                </div>
                
                <!-- Right Section with Vertical Tabs -->
                <div class="right-section">
                    
                    <!-- Vertical Tabs Navigation -->
                    <div class="vertical-tabs">
                        <div class="vertical-tab-item active" data-tab="showcase-info">
                            <i class="fa fa-info-circle"></i>
                            <span>Basic Information</span>
                        </div>
                        <div class="vertical-tab-item" data-tab="descriptions">
                            <i class="fa fa-file-text"></i>
                            <span>Descriptions</span>
                        </div>
                        <div class="vertical-tab-item" data-tab="images">
                            <i class="fa fa-image"></i>
                            <span>Images</span>
                        </div>
                        <div class="vertical-tab-item" data-tab="seo">
                            <i class="fa fa-search"></i>
                            <span>SEO Information</span>
                        </div>
                        <div class="vertical-tab-item" data-tab="related-services">
                            <i class="fa fa-link"></i>
                            <span>Related Services</span>
                        </div>
                        <div class="vertical-tab-item" data-tab="related-projects">
                            <i class="fa fa-building"></i>
                            <span>Related Projects</span>
                        </div>
                        <div class="vertical-tab-item" data-tab="related-portfolios">
                            <i class="fa fa-folder-open"></i>
                            <span>Related Portfolios</span>
                        </div>
                        <div class="vertical-tab-item" data-tab="related-team">
                            <i class="fa fa-users"></i>
                            <span>Related Team</span>
                        </div>
                        <div class="vertical-tab-item" data-tab="related-news">
                            <i class="fa fa-newspaper-o"></i>
                            <span>Related News</span>
                        </div>
                    </div>
                    
                    <!-- Tab Content Area -->
                    <div class="tab-content-area">
                        
                        <!-- Basic Information Tab -->
                        <div class="tab-pane active" id="showcase-info">
                            <h5 class="tab-content-title">Basic Information</h5>
                            
                            <div class="info-row">
                                <div class="info-label">Showcase ID:</div>
                                <div class="info-value">{{ $showcase->id }}</div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">Title (English):</div>
                                <div class="info-value">{{ $showcase->title_english }}</div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">Title (Arabic):</div>
                                <div class="info-value" dir="rtl">{{ $showcase->title_arabic }}</div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">Status:</div>
                                <div class="info-value">
                                    @if($showcase->status == 'active')
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-secondary">Inactive</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">Home Status:</div>
                                <div class="info-value">
                                    @if($showcase->home_status == 'shown')
                                        <span class="badge badge-info">Shown</span>
                                    @else
                                        <span class="badge badge-warning">Not Shown</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <!-- Descriptions Tab -->
                        <div class="tab-pane" id="descriptions">
                            <h5 class="tab-content-title">Descriptions</h5>
                            
                            <div class="mb-4">
                                <h6 class="font-weight-bold text-primary mb-2">Description (English)</h6>
                                <div class="description-content">
                                    {!! $showcase->description_english !!}
                                </div>
                            </div>
                            
                            <div>
                                <h6 class="font-weight-bold text-primary mb-2">Description (Arabic)</h6>
                                <div class="description-content" dir="rtl">
                                    {!! $showcase->description_arabic !!}
                                </div>
                            </div>
                        </div>
                        
                        <!-- Images Tab -->
                        <div class="tab-pane" id="images">
                            <h5 class="tab-content-title">Images</h5>
                            
                            <div class="mb-4">
                                <h6 class="font-weight-bold text-primary mb-3">Cover Image (1890x420)</h6>
                                @if($showcase->cover_image)
                                    <a href="{{url('/storage' . $showcase->cover_image)}}" data-lightbox="showcase-images" data-title="Cover Image">
                                        <img src="{{url('/storage' . $showcase->cover_image)}}" alt="Cover Image" class="image-preview">
                                    </a>
                                @else
                                    <p class="text-muted">No cover image available</p>
                                @endif
                            </div>
                            
                            <div class="mb-4">
                                <h6 class="font-weight-bold text-primary mb-3">Main Image (292x330)</h6>
                                @if($showcase->main_image)
                                    <a href="{{url('/storage' . $showcase->main_image)}}" data-lightbox="showcase-images" data-title="Main Image">
                                        <img src="{{url('/storage' . $showcase->main_image)}}" alt="Main Image" class="image-preview">
                                    </a>
                                @else
                                    <p class="text-muted">No main image available</p>
                                @endif
                            </div>
                            
                            <div>
                                <h6 class="font-weight-bold text-primary mb-3">Page Image (870x450)</h6>
                                @if($showcase->page_image)
                                    <a href="{{url('/storage' . $showcase->page_image)}}" data-lightbox="showcase-images" data-title="Page Image">
                                        <img src="{{url('/storage' . $showcase->page_image)}}" alt="Page Image" class="image-preview">
                                    </a>
                                @else
                                    <p class="text-muted">No page image available</p>
                                @endif
                            </div>
                        </div>
                        
                        <!-- SEO Tab -->
                        <div class="tab-pane" id="seo">
                            <h5 class="tab-content-title">SEO Information</h5>
                            
                            <div class="info-row">
                                <div class="info-label">SEO Tags:</div>
                                <div class="info-value">
                                    @if($showcase->seo_tags)
                                        @php
                                            $tags = explode(',', $showcase->seo_tags);
                                        @endphp
                                        @foreach($tags as $tag)
                                            <span class="badge badge-primary mr-1 mb-1">{{ trim($tag) }}</span>
                                        @endforeach
                                    @else
                                        <span class="text-muted">No SEO tags</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">SEO Description (English):</div>
                                <div class="info-value">
                                    {{ $showcase->seo_description_english ?? 'Not provided' }}
                                </div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">SEO Description (Arabic):</div>
                                <div class="info-value" dir="rtl">
                                    {{ $showcase->seo_description_arabic ?? 'Not provided' }}
                                </div>
                            </div>
                        </div>
                        
                        <!-- Related Services Tab -->
                        <div class="tab-pane" id="related-services">
                            <h5 class="tab-content-title">Related Services</h5>
                            @include('admin::showcases.related-services._index')
                        </div>
                        
                        <!-- Related Projects Tab -->
                        <div class="tab-pane" id="related-projects">
                            <h5 class="tab-content-title">Related Projects</h5>
                            @include('admin::showcases.related-projects._index')
                        </div>
                        
                        <!-- Related Portfolios Tab -->
                        <div class="tab-pane" id="related-portfolios">
                            <h5 class="tab-content-title">Related Portfolios</h5>
                            @include('admin::showcases.related-portfolios._index')
                        </div>
                        
                        <!-- Related Team Tab -->
                        <div class="tab-pane" id="related-team">
                            <h5 class="tab-content-title">Related Team Members</h5>
                            @include('admin::showcases.related-team._index')
                        </div>
                        
                        <!-- Related News Tab -->
                        <div class="tab-pane" id="related-news">
                            <h5 class="tab-content-title">Related News</h5>
                            @include('admin::showcases.related-news._index')
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
    const showcaseId = {{ $showcase->id }};
    
    // Toggle Status Function
    function toggleStatus(newStatus) {
        if (!confirm(`Are you sure you want to set this showcase as ${newStatus}?`)) {
            return;
        }
        
        $.ajax({
            url: `{{ url(app()->getLocale() . '/admin/showcase/toggle-status') }}/${showcaseId}`,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                status: newStatus
            },
            success: function(response) {
                if (response.success) {
                    location.reload();
                }
            },
            error: function(xhr) {
                alert('Error updating status');
                console.error(xhr);
            }
        });
    }
    
    // Toggle Home Status Function
    function toggleHomeStatus(newHomeStatus) {
        if (!confirm(`Are you sure you want to ${newHomeStatus === 'shown' ? 'show' : 'hide'} this showcase on home page?`)) {
            return;
        }
        
        $.ajax({
            url: `{{ url(app()->getLocale() . '/admin/showcase/toggle-home-status') }}/${showcaseId}`,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                home_status: newHomeStatus
            },
            success: function(response) {
                if (response.success) {
                    location.reload();
                }
            },
            error: function(xhr) {
                alert('Error updating home status');
                console.error(xhr);
            }
        });
    }
</script>

<script>
    // Vertical Tabs Functionality
    document.addEventListener('DOMContentLoaded', function() {
        const tabItems = document.querySelectorAll('.vertical-tab-item');
        const tabPanes = document.querySelectorAll('.tab-pane');
        
        tabItems.forEach(item => {
            item.addEventListener('click', function() {
                // Remove active class from all tabs and panes
                tabItems.forEach(tab => tab.classList.remove('active'));
                tabPanes.forEach(pane => pane.classList.remove('active'));
                
                // Add active class to clicked tab
                this.classList.add('active');
                
                // Show corresponding pane
                const tabId = this.getAttribute('data-tab');
                document.getElementById(tabId).classList.add('active');
            });
        });
    });
</script>

<script>
    // Initialize Select2 when modal is shown
    $('#addServiceModal').on('shown.bs.modal', function () {
        $('#service_id').select2({
            dropdownParent: $('#addServiceModal'),
            placeholder: '-- Select Service --',
            allowClear: true
        });
    });
    
    // Destroy Select2 when modal is hidden to prevent duplicates
    $('#addServiceModal').on('hidden.bs.modal', function () {
        $('#service_id').select2('destroy');
        $('#addServiceForm')[0].reset();
    });
</script>

<script>
// Load available services when modal opens
$('#addServiceModal').on('show.bs.modal', function() {
    loadAvailableServices();
});

function loadAvailableServices() {
    $.ajax({
        url: `{{ url(app()->getLocale() . '/admin/showcase') }}/${showcaseId}/services/available`,
        type: 'GET',
        success: function(response) {
            let select = $('#service_id');
            select.empty();
            select.append('<option value="">-- Select Service --</option>');
            
            if (response.length === 0) {
                select.append('<option value="" disabled>No available services</option>');
            } else {
                response.forEach(function(service) {
                    select.append(`<option value="${service.id}">${service.title_english} - ${service.title_arabic}</option>`);
                });
            }
        },
        error: function(xhr) {
            console.error('Error loading services:', xhr);
            alert('Error loading available services');
        }
    });
}

function addService() {
    let serviceId = $('#service_id').val();
    
    if (!serviceId) {
        alert('Please select a service');
        return;
    }
    
    $.ajax({
        url: `{{ url(app()->getLocale() . '/admin/showcase') }}/${showcaseId}/services/store`,
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            service_id: serviceId
        },
        success: function(response) {
            if (response.success) {
                $('#addServiceModal').modal('hide');
                location.reload(); // Reload to show updated list
            }
        },
        error: function(xhr) {
            let message = xhr.responseJSON?.message || 'Error adding service';
            alert(message);
        }
    });
}

let serviceToDelete = null;

function deleteService(id, name) {
    serviceToDelete = id;
    $('#service-name-display').text(name);
    $('#deleteServiceModal').modal('show');
}

function confirmDeleteService() {
    if (!serviceToDelete) return;
    
    $.ajax({
        url: `{{ url(app()->getLocale() . '/admin/showcase') }}/${showcaseId}/services/delete/${serviceToDelete}`,
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            if (response.success) {
                $('#deleteServiceModal').modal('hide');
                $(`#service-row-${serviceToDelete}`).fadeOut(300, function() {
                    $(this).remove();
                    
                    // Check if table is empty
                    if ($('#services-table-body tr').length === 0) {
                        $('#services-list').html(`
                            <div class="alert alert-info text-center" id="no-services-message">
                                <i class="fa fa-info-circle"></i> No services added yet. Click "Add Service" to get started.
                            </div>
                        `);
                    }
                });
                serviceToDelete = null;
            }
        },
        error: function(xhr) {
            alert('Error removing service');
            console.error(xhr);
        }
    });
}
</script>

<script>
    // Initialize Select2 for Projects Modal
    $('#addProjectModal').on('shown.bs.modal', function () {
        $('#project_id').select2({
            dropdownParent: $('#addProjectModal'),
            placeholder: '-- Select Project --',
            allowClear: true
        });
    });
    
    // Destroy Select2 when modal is hidden to prevent duplicates
    $('#addProjectModal').on('hidden.bs.modal', function () {
        $('#project_id').select2('destroy');
        $('#addProjectForm')[0].reset();
    });
</script>

<script>
// Load available projects when modal opens
$('#addProjectModal').on('show.bs.modal', function() {
    loadAvailableProjects();
});

function loadAvailableProjects() {
    $.ajax({
        url: `{{ url(app()->getLocale() . '/admin/showcase') }}/${showcaseId}/projects/available`,
        type: 'GET',
        success: function(response) {
            let select = $('#project_id');
            select.empty();
            select.append('<option value="">-- Select Project --</option>');
            
            if (response.length === 0) {
                select.append('<option value="" disabled>No available projects</option>');
            } else {
                response.forEach(function(project) {
                    select.append(`<option value="${project.id}">${project.title_english} - ${project.title_arabic}</option>`);
                });
            }
        },
        error: function(xhr) {
            console.error('Error loading projects:', xhr);
            alert('Error loading available projects');
        }
    });
}

function addProject() {
    let projectId = $('#project_id').val();
    
    if (!projectId) {
        alert('Please select a project');
        return;
    }
    
    $.ajax({
        url: `{{ url(app()->getLocale() . '/admin/showcase') }}/${showcaseId}/projects/store`,
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            project_id: projectId
        },
        success: function(response) {
            if (response.success) {
                $('#addProjectModal').modal('hide');
                location.reload(); // Reload to show updated list
            }
        },
        error: function(xhr) {
            let message = xhr.responseJSON?.message || 'Error adding project';
            alert(message);
        }
    });
}

let projectToDelete = null;

function deleteProject(id, name) {
    projectToDelete = id;
    $('#project-name-display').text(name);
    $('#deleteProjectModal').modal('show');
}

function confirmDeleteProject() {
    if (!projectToDelete) return;
    
    $.ajax({
        url: `{{ url(app()->getLocale() . '/admin/showcase') }}/${showcaseId}/projects/delete/${projectToDelete}`,
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            if (response.success) {
                $('#deleteProjectModal').modal('hide');
                $(`#project-row-${projectToDelete}`).fadeOut(300, function() {
                    $(this).remove();
                    
                    // Check if table is empty
                    if ($('#projects-table-body tr').length === 0) {
                        $('#projects-list').html(`
                            <div class="alert alert-info text-center" id="no-projects-message">
                                <i class="fa fa-info-circle"></i> No projects added yet. Click "Add Project" to get started.
                            </div>
                        `);
                    }
                });
                projectToDelete = null;
            }
        },
        error: function(xhr) {
            alert('Error removing project');
            console.error(xhr);
        }
    });
}
</script>

<script>
    // Initialize Select2 for Portfolios Modal
    $('#addPortfolioModal').on('shown.bs.modal', function () {
        $('#portfolio_id').select2({
            dropdownParent: $('#addPortfolioModal'),
            placeholder: '-- Select Portfolio --',
            allowClear: true
        });
    });
    
    // Destroy Select2 when modal is hidden to prevent duplicates
    $('#addPortfolioModal').on('hidden.bs.modal', function () {
        $('#portfolio_id').select2('destroy');
        $('#addPortfolioForm')[0].reset();
    });
</script>

<script>
// Load available portfolios when modal opens
$('#addPortfolioModal').on('show.bs.modal', function() {
    loadAvailablePortfolios();
});

function loadAvailablePortfolios() {
    $.ajax({
        url: `{{ url(app()->getLocale() . '/admin/showcase') }}/${showcaseId}/portfolios/available`,
        type: 'GET',
        success: function(response) {
            let select = $('#portfolio_id');
            select.empty();
            select.append('<option value="">-- Select Portfolio --</option>');
            
            if (response.length === 0) {
                select.append('<option value="" disabled>No available portfolios</option>');
            } else {
                response.forEach(function(portfolio) {
                    select.append(`<option value="${portfolio.id}">${portfolio.title_english} - ${portfolio.title_arabic}</option>`);
                });
            }
        },
        error: function(xhr) {
            console.error('Error loading portfolios:', xhr);
            alert('Error loading available portfolios');
        }
    });
}

function addPortfolio() {
    let portfolioId = $('#portfolio_id').val();
    
    if (!portfolioId) {
        alert('Please select a portfolio');
        return;
    }
    
    $.ajax({
        url: `{{ url(app()->getLocale() . '/admin/showcase') }}/${showcaseId}/portfolios/store`,
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            portfolio_id: portfolioId
        },
        success: function(response) {
            if (response.success) {
                $('#addPortfolioModal').modal('hide');
                location.reload(); // Reload to show updated list
            }
        },
        error: function(xhr) {
            let message = xhr.responseJSON?.message || 'Error adding portfolio';
            alert(message);
        }
    });
}

let portfolioToDelete = null;

function deletePortfolio(id, name) {
    portfolioToDelete = id;
    $('#portfolio-name-display').text(name);
    $('#deletePortfolioModal').modal('show');
}

function confirmDeletePortfolio() {
    if (!portfolioToDelete) return;
    
    $.ajax({
        url: `{{ url(app()->getLocale() . '/admin/showcase') }}/${showcaseId}/portfolios/delete/${portfolioToDelete}`,
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            if (response.success) {
                $('#deletePortfolioModal').modal('hide');
                $(`#portfolio-row-${portfolioToDelete}`).fadeOut(300, function() {
                    $(this).remove();
                    
                    // Check if table is empty
                    if ($('#portfolios-table-body tr').length === 0) {
                        $('#portfolios-list').html(`
                            <div class="alert alert-info text-center" id="no-portfolios-message">
                                <i class="fa fa-info-circle"></i> No portfolios added yet. Click "Add Portfolio" to get started.
                            </div>
                        `);
                    }
                });
                portfolioToDelete = null;
            }
        },
        error: function(xhr) {
            alert('Error removing portfolio');
            console.error(xhr);
        }
    });
}
</script>

<script>
    // Initialize Select2 for Team Modal
    $('#addTeamModal').on('shown.bs.modal', function () {
        $('#team_id').select2({
            dropdownParent: $('#addTeamModal'),
            placeholder: '-- Select Team Member --',
            allowClear: true
        });
    });
    
    // Destroy Select2 when modal is hidden to prevent duplicates
    $('#addTeamModal').on('hidden.bs.modal', function () {
        $('#team_id').select2('destroy');
        $('#addTeamForm')[0].reset();
    });
</script>

<script>
// Load available team members when modal opens
$('#addTeamModal').on('show.bs.modal', function() {
    loadAvailableTeam();
});

function loadAvailableTeam() {
    $.ajax({
        url: `{{ url(app()->getLocale() . '/admin/showcase') }}/${showcaseId}/team/available`,
        type: 'GET',
        success: function(response) {
            let select = $('#team_id');
            select.empty();
            select.append('<option value="">-- Select Team Member --</option>');
            
            if (response.length === 0) {
                select.append('<option value="" disabled>No available team members</option>');
            } else {
                response.forEach(function(member) {
                    select.append(`<option value="${member.id}">${member.name_english} - ${member.name_arabic}</option>`);
                });
            }
        },
        error: function(xhr) {
            console.error('Error loading team members:', xhr);
            alert('Error loading available team members');
        }
    });
}

function addTeamMember() {
    let teamId = $('#team_id').val();
    
    if (!teamId) {
        alert('Please select a team member');
        return;
    }
    
    $.ajax({
        url: `{{ url(app()->getLocale() . '/admin/showcase') }}/${showcaseId}/team/store`,
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            team_id: teamId
        },
        success: function(response) {
            if (response.success) {
                $('#addTeamModal').modal('hide');
                location.reload(); // Reload to show updated list
            }
        },
        error: function(xhr) {
            let message = xhr.responseJSON?.message || 'Error adding team member';
            alert(message);
        }
    });
}

let teamToDelete = null;

function deleteTeamMember(id, name) {
    teamToDelete = id;
    $('#team-name-display').text(name);
    $('#deleteTeamModal').modal('show');
}

function confirmDeleteTeamMember() {
    if (!teamToDelete) return;
    
    $.ajax({
        url: `{{ url(app()->getLocale() . '/admin/showcase') }}/${showcaseId}/team/delete/${teamToDelete}`,
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            if (response.success) {
                $('#deleteTeamModal').modal('hide');
                $(`#team-row-${teamToDelete}`).fadeOut(300, function() {
                    $(this).remove();
                    
                    // Check if table is empty
                    if ($('#team-table-body tr').length === 0) {
                        $('#team-list').html(`
                            <div class="alert alert-info text-center" id="no-team-message">
                                <i class="fa fa-info-circle"></i> No team members added yet. Click "Add Team Member" to get started.
                            </div>
                        `);
                    }
                });
                teamToDelete = null;
            }
        },
        error: function(xhr) {
            alert('Error removing team member');
            console.error(xhr);
        }
    });
}
</script>

<script>
    // Initialize Select2 for News Modal
    $('#addNewsModal').on('shown.bs.modal', function () {
        $('#new_id').select2({
            dropdownParent: $('#addNewsModal'),
            placeholder: '-- Select News --',
            allowClear: true
        });
    });
    
    // Destroy Select2 when modal is hidden to prevent duplicates
    $('#addNewsModal').on('hidden.bs.modal', function () {
        $('#new_id').select2('destroy');
        $('#addNewsForm')[0].reset();
    });
</script>

<script>
// Load available news when modal opens
$('#addNewsModal').on('show.bs.modal', function() {
    loadAvailableNews();
});

function loadAvailableNews() {
    $.ajax({
        url: `{{ url(app()->getLocale() . '/admin/showcase') }}/${showcaseId}/news/available`,
        type: 'GET',
        success: function(response) {
            let select = $('#new_id');
            select.empty();
            select.append('<option value="">-- Select News --</option>');
            
            if (response.length === 0) {
                select.append('<option value="" disabled>No available news</option>');
            } else {
                response.forEach(function(newsItem) {
                    select.append(`<option value="${newsItem.id}">${newsItem.title_english} - ${newsItem.title_arabic}</option>`);
                });
            }
        },
        error: function(xhr) {
            console.error('Error loading news:', xhr);
            alert('Error loading available news');
        }
    });
}

function addNews() {
    let newId = $('#new_id').val();
    
    if (!newId) {
        alert('Please select a news item');
        return;
    }
    
    $.ajax({
        url: `{{ url(app()->getLocale() . '/admin/showcase') }}/${showcaseId}/news/store`,
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            new_id: newId
        },
        success: function(response) {
            if (response.success) {
                $('#addNewsModal').modal('hide');
                location.reload(); // Reload to show updated list
            }
        },
        error: function(xhr) {
            let message = xhr.responseJSON?.message || 'Error adding news';
            alert(message);
        }
    });
}

let newsToDelete = null;

function deleteNews(id, name) {
    newsToDelete = id;
    $('#news-name-display').text(name);
    $('#deleteNewsModal').modal('show');
}

function confirmDeleteNews() {
    if (!newsToDelete) return;
    
    $.ajax({
        url: `{{ url(app()->getLocale() . '/admin/showcase') }}/${showcaseId}/news/delete/${newsToDelete}`,
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            if (response.success) {
                $('#deleteNewsModal').modal('hide');
                $(`#news-row-${newsToDelete}`).fadeOut(300, function() {
                    $(this).remove();
                    
                    // Check if table is empty
                    if ($('#news-table-body tr').length === 0) {
                        $('#news-list').html(`
                            <div class="alert alert-info text-center" id="no-news-message">
                                <i class="fa fa-info-circle"></i> No news added yet. Click "Add News" to get started.
                            </div>
                        `);
                    }
                });
                newsToDelete = null;
            }
        },
        error: function(xhr) {
            alert('Error removing news');
            console.error(xhr);
        }
    });
}
</script>
@endsection
