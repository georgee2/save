@extends('admin::layouts.master')
@section('title', 'Home Interior Slider Settings')

@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<style>
    .settings-card {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        margin-bottom: 20px;
    }
    .settings-header {
        background: linear-gradient(135deg, #19868b 0%, #0d6b6f 100%);
        color: white;
        padding: 20px;
        border-radius: 10px 10px 0 0;
    }
    .settings-header h4 {
        margin: 0;
        font-weight: 600;
    }
    .settings-header p {
        margin: 5px 0 0;
        opacity: 0.9;
        font-size: 14px;
    }
    .settings-body {
        padding: 30px;
    }
    .setting-row {
        display: flex;
        align-items: center;
        gap: 20px;
        padding: 20px;
        background: #f8f9fa;
        border-radius: 8px;
        margin-bottom: 15px;
    }
    .setting-label {
        font-weight: 600;
        color: #2c3e50;
        min-width: 200px;
    }
    .setting-value {
        flex: 1;
    }
    .max-show-input {
        width: 100px;
        text-align: center;
        border: 2px solid #dee2e6;
        border-radius: 8px;
        padding: 10px 15px;
        font-size: 18px;
        font-weight: 600;
    }
    .max-show-input:focus {
        border-color: #19868b;
        outline: none;
        box-shadow: 0 0 0 3px rgba(25, 134, 139, 0.2);
    }
    .selection-mode {
        display: flex;
        align-items: center;
        gap: 15px;
    }
    .mode-badge {
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
    }
    .mode-badge.auto {
        background: #e2e3e5;
        color: #383d41;
    }
    .mode-badge.manual {
        background: #d4edda;
        color: #155724;
    }
    .btn-select-images {
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        color: white;
        border: none;
        padding: 12px 25px;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .btn-select-images:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
        color: white;
        text-decoration: none;
    }
    .btn-save {
        background: linear-gradient(135deg, #19868b 0%, #0d6b6f 100%);
        color: white;
        border: none;
        padding: 12px 30px;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(25, 134, 139, 0.3);
        color: white;
    }
    .info-box {
        background: #e7f5f5;
        border: 1px solid #19868b;
        border-radius: 8px;
        padding: 15px 20px;
        margin-bottom: 20px;
    }
    .info-box i {
        color: #19868b;
        margin-right: 10px;
    }
    .info-box p {
        margin: 0;
        color: #0d6b6f;
        font-size: 14px;
    }
    .quick-links {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #e9ecef;
    }
    .quick-link {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 15px 20px;
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        color: #2c3e50;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    .quick-link:hover {
        background: #e9ecef;
        border-color: #19868b;
        color: #19868b;
        text-decoration: none;
    }
    .quick-link i {
        font-size: 20px;
        color: #19868b;
    }
    .quick-link-text {
        font-weight: 500;
    }
    .quick-link-desc {
        font-size: 12px;
        color: #6c757d;
    }
</style>
@endsection

@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Admin')}}" class="breadcrumbs__item"><i class="fa fa-home"></i> Dashboard</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-image"></i> Home Interior Slider Settings</a>
        </nav>

        <div class="col-lg-12">
            <hr>
            
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert" style="border-left: 4px solid #28a745;">
                    <i class="fa fa-check-circle"></i> <strong>Success!</strong> {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            
            <div class="settings-card">
                <div class="settings-header">
                    <h4><i class="fa fa-image"></i> Home Interior Slider Settings</h4>
                    <p>Control which interior gallery images appear in the home page slider and their display order.</p>
                </div>
                
                <div class="settings-body">
                    <div class="info-box">
                        <i class="fa fa-info-circle"></i>
                        <p><strong>Instructions:</strong> Set the maximum number of images to show in the slider. Click "Select Images" to manually choose which images appear, or leave on "Auto" mode to show the latest published images.</p>
                    </div>
                    
                    <div class="setting-row">
                        <div class="setting-label">
                            <i class="fa fa-th-large"></i> Max Images to Show
                        </div>
                        <div class="setting-value">
                            <input type="number" 
                                   id="maxShow" 
                                   class="max-show-input" 
                                   value="{{ $settings->max_show }}" 
                                   min="1" 
                                   max="50">
                            <small class="text-muted ml-2">Maximum images displayed in the slider</small>
                        </div>
                        <button type="button" class="btn btn-save" onclick="saveMaxShow()">
                            <i class="fa fa-save"></i> Save
                        </button>
                    </div>
                    
                    <div class="setting-row">
                        <div class="setting-label">
                            <i class="fa fa-list-ol"></i> Selection Mode
                        </div>
                        <div class="setting-value">
                            <div class="selection-mode">
                                @if($hasManualSelection)
                                    <span class="mode-badge manual">
                                        <i class="fa fa-check"></i> Manual ({{ $selectedCount }} images selected)
                                    </span>
                                @else
                                    <span class="mode-badge auto">
                                        <i class="fa fa-magic"></i> Auto (Latest Images)
                                    </span>
                                @endif
                            </div>
                        </div>
                        <a href="{{ route('home-interior-settings.select-images') }}" class="btn-select-images">
                            <i class="fa fa-images"></i> Select Images
                        </a>
                    </div>
                    
                    <div class="quick-links">
                        <a href="{{ route('interior-category-order.index') }}" class="quick-link">
                            <i class="fa fa-folder"></i>
                            <div>
                                <div class="quick-link-text">Category Order</div>
                                <div class="quick-link-desc">Order categories & toggle publish status</div>
                            </div>
                        </a>
                        <a href="{{ route('interior-design-gallery.order-index') }}" class="quick-link">
                            <i class="fa fa-star"></i>
                            <div>
                                <div class="quick-link-text">Index Page Order</div>
                                <div class="quick-link-desc">Order first 6 images for index page</div>
                            </div>
                        </a>
                        <a href="{{ route('interior-design-gallery.order-all') }}" class="quick-link">
                            <i class="fa fa-sort"></i>
                            <div>
                                <div class="quick-link-text">All Images Order</div>
                                <div class="quick-link-desc">Sort all gallery images</div>
                            </div>
                        </a>
                        <a href="{{ route('interior-design-gallery.index') }}" class="quick-link">
                            <i class="fa fa-th"></i>
                            <div>
                                <div class="quick-link-text">Gallery Management</div>
                                <div class="quick-link-desc">Add, edit, delete gallery images</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function saveMaxShow() {
    const maxShow = document.getElementById('maxShow').value;
    
    fetch('{{ route("home-interior-settings.update") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            max_show: maxShow
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Saved!',
                text: data.message,
                timer: 1500,
                showConfirmButton: false
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Failed to save settings'
        });
    });
}
</script>
@endsection
