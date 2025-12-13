@extends('admin::layouts.master')

@section('title')
Site Settings
@endsection

@section('css')
<style>
.settings-card {
    background: #fff;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    padding: 30px;
    margin-bottom: 30px;
}

.settings-header {
    display: flex;
    align-items: center;
    margin-bottom: 25px;
    padding-bottom: 20px;
    border-bottom: 3px solid #e64c29;
}

.settings-header i {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #e64c29 0%, #ff7043 100%);
    color: white;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 15px;
    font-size: 24px;
}

.settings-header h4 {
    margin: 0;
    font-size: 24px;
    font-weight: 700;
    color: #2c3e50;
}

.mode-toggle-container {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 25px;
    margin-bottom: 20px;
}

.mode-status {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
    padding: 20px;
    background: white;
    border-radius: 10px;
    border-left: 4px solid #e64c29;
}

.mode-status.active {
    border-left-color: #28a745;
    background: #f0fff4;
}

.mode-status.inactive {
    border-left-color: #dc3545;
    background: #fff5f5;
}

.status-info h5 {
    margin: 0 0 5px 0;
    font-size: 18px;
    font-weight: 700;
    color: #2c3e50;
}

.status-info p {
    margin: 0;
    color: #666;
    font-size: 14px;
}

.status-badge {
    padding: 8px 20px;
    border-radius: 20px;
    font-weight: 600;
    font-size: 14px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.status-badge.active {
    background: #28a745;
    color: white;
}

.status-badge.inactive {
    background: #dc3545;
    color: white;
}

.toggle-buttons {
    display: flex;
    gap: 15px;
}

.toggle-buttons button {
    flex: 1;
    padding: 15px 30px;
    border: none;
    border-radius: 10px;
    font-size: 16px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s ease;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.btn-enable {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    color: white;
}

.btn-enable:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(40, 167, 69, 0.4);
}

.btn-disable {
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
    color: white;
}

.btn-disable:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(220, 53, 69, 0.4);
}

.info-box {
    background: #fff3cd;
    border: 1px solid #ffc107;
    border-radius: 10px;
    padding: 20px;
    margin-top: 20px;
}

.info-box i {
    color: #ffc107;
    font-size: 20px;
    margin-right: 10px;
}

.info-box p {
    margin: 0;
    color: #856404;
    font-size: 14px;
    line-height: 1.6;
}
</style>
@endsection

@section('content')
<div class="page-content" style="margin-top: 100px;">
    <div class="container-fluid">
        
        <!-- Page Title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">Site Settings</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('Admin') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Site Settings</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Success Message -->
        @if(session('success'))
        <div class="row">
            <div class="col-12">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fa fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
        @endif

        <!-- Settings Card -->
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="settings-card">
                    <div class="settings-header">
                        <i class="fa fa-cog"></i>
                        <h4>Under Construction Mode</h4>
                    </div>

                    <!-- Current Status -->
                    <div class="mode-status {{ $underConstruction ? 'active' : 'inactive' }}">
                        <div class="status-info">
                            <h5>Current Status</h5>
                            <p>{{ $underConstruction ? 'Under Construction mode is currently ENABLED' : 'Site is currently LIVE and accessible to all visitors' }}</p>
                        </div>
                        <div>
                            <span class="status-badge {{ $underConstruction ? 'active' : 'inactive' }}">
                                {{ $underConstruction ? 'Enabled' : 'Disabled' }}
                            </span>
                        </div>
                    </div>

                    <!-- Toggle Form -->
                    <div class="mode-toggle-container">
                        <form action="{{ route('site-settings.update-construction') }}" method="POST">
                            @csrf
                            <div class="toggle-buttons">
                                <button type="submit" name="under_construction" value="true" class="btn-enable" 
                                    {{ $underConstruction ? 'disabled' : '' }}>
                                    <i class="fa fa-lock me-2"></i>
                                    Enable Under Construction
                                </button>
                                <button type="submit" name="under_construction" value="false" class="btn-disable"
                                    {{ !$underConstruction ? 'disabled' : '' }}>
                                    <i class="fa fa-unlock me-2"></i>
                                    Disable Under Construction
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Info Box -->
                    <div class="info-box">
                        <i class="fa fa-info-circle"></i>
                        <strong>Note:</strong>
                        <p>
                            When Under Construction mode is enabled, all visitors will see a maintenance page. 
                            Admin users will still be able to access the admin panel and the site normally.
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

