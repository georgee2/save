@extends('admin::layouts.master')
@section('title', 'Create Role')

@section('css')
<style>
    :root {
        --primary-color: #1a7d6b;
        --primary-dark: #145f52;
        --primary-light: #22a88f;
        --secondary-color: #2d3748;
        --accent-color: #e8b85e;
        --accent-light: #f0cb82;
        --card-shadow: 0 10px 40px rgba(0,0,0,0.08);
    }

    /* Page Header */
    .page-hero {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 50%, var(--secondary-color) 100%);
        border-radius: 20px;
        padding: 35px 40px;
        margin-bottom: 30px;
        position: relative;
        overflow: hidden;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .page-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        pointer-events: none;
    }
    .page-hero-content { position: relative; z-index: 1; }
    .page-hero-icon {
        width: 60px;
        height: 60px;
        background: rgba(255,255,255,0.2);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 15px;
    }
    .page-hero-icon i { font-size: 1.5rem; color: #fff; }
    .page-hero h1 { color: #fff; font-size: 1.8rem; font-weight: 700; margin: 0 0 8px 0; }
    .page-hero p { color: rgba(255,255,255,0.8); margin: 0; font-size: 1rem; }
    .page-hero-actions { position: relative; z-index: 1; }
    .hero-btn {
        background: rgba(255,255,255,0.15);
        border: 1px solid rgba(255,255,255,0.3);
        color: #fff;
        padding: 12px 24px;
        border-radius: 12px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        text-decoration: none;
    }
    .hero-btn:hover { background: rgba(255,255,255,0.25); color: #fff; transform: translateY(-2px); }

    /* Form Card */
    .form-card {
        background: #fff;
        border-radius: 20px;
        box-shadow: var(--card-shadow);
        overflow: hidden;
        margin-bottom: 30px;
    }
    .form-card-header {
        padding: 25px 30px;
        border-bottom: 1px solid #f0f0f0;
        display: flex;
        align-items: center;
        gap: 15px;
    }
    .form-card-header .header-icon {
        width: 45px;
        height: 45px;
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .form-card-header .header-icon i { color: #fff; font-size: 1.1rem; }
    .form-card-header h3 { margin: 0; font-size: 1.2rem; font-weight: 700; color: var(--secondary-color); }
    .form-card-header p { margin: 0; font-size: 0.9rem; color: #666; }
    .form-card-body { padding: 30px; }

    /* Form Elements */
    .form-group { margin-bottom: 25px; }
    .form-group label {
        font-weight: 600;
        color: var(--secondary-color);
        margin-bottom: 10px;
        display: block;
        font-size: 0.95rem;
    }
    .form-group label .required { color: #e1273d; }
    .form-control {
        border: 2px solid #e9ecef;
        border-radius: 12px;
        padding: 14px 18px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }
    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 4px rgba(26, 125, 107, 0.1);
    }
    .form-control::placeholder { color: #adb5bd; }

    /* Toggle Switch */
    .toggle-wrapper {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 20px;
        background: linear-gradient(135deg, #f8f9fa, #fff);
        border-radius: 12px;
        border: 1px solid #e9ecef;
    }
    .toggle-switch {
        position: relative;
        width: 56px;
        height: 30px;
    }
    .toggle-switch input { opacity: 0; width: 0; height: 0; }
    .toggle-slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: 0.4s;
        border-radius: 30px;
    }
    .toggle-slider:before {
        position: absolute;
        content: "";
        height: 22px;
        width: 22px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        transition: 0.4s;
        border-radius: 50%;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    }
    .toggle-switch input:checked + .toggle-slider { background: linear-gradient(135deg, var(--primary-color), var(--primary-light)); }
    .toggle-switch input:checked + .toggle-slider:before { transform: translateX(26px); }
    .toggle-label h6 { margin: 0 0 4px 0; font-weight: 600; color: var(--secondary-color); }
    .toggle-label p { margin: 0; font-size: 0.85rem; color: #666; }

    /* Global Actions */
    .global-actions {
        background: linear-gradient(135deg, #f8f9fa, #fff);
        padding: 20px 25px;
        border-radius: 16px;
        margin-bottom: 25px;
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        align-items: center;
        border: 1px solid #e9ecef;
    }
    .global-actions-title {
        font-weight: 600;
        color: var(--secondary-color);
        margin-right: 10px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .global-actions-title i { color: var(--primary-color); }
    .action-btn {
        padding: 10px 18px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.85rem;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }
    .action-btn:hover { transform: translateY(-2px); }
    .action-btn.success { background: linear-gradient(135deg, #28a745, #20c997); color: #fff; }
    .action-btn.secondary { background: #e9ecef; color: var(--secondary-color); }
    .action-btn.info { background: linear-gradient(135deg, var(--primary-color), var(--primary-light)); color: #fff; }
    .action-btn.warning { background: linear-gradient(135deg, var(--accent-color), var(--accent-light)); color: #fff; }

    /* Permission Modules */
    .permissions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 20px;
    }
    .permission-module {
        background: #fff;
        border: 1px solid #e9ecef;
        border-radius: 16px;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    .permission-module:hover {
        border-color: var(--primary-color);
        box-shadow: 0 10px 30px rgba(26, 125, 107, 0.1);
    }
    .permission-module-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 50%, var(--secondary-color) 100%);
        color: #fff;
        padding: 18px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .module-title {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .module-icon {
        width: 36px;
        height: 36px;
        background: rgba(255,255,255,0.2);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .module-icon i { font-size: 0.95rem; color: #fff; }
    .module-title h5 { margin: 0; font-weight: 600; font-size: 1rem; text-transform: capitalize; }
    .toggle-all-btn {
        background: rgba(255,255,255,0.2);
        border: 1px solid rgba(255,255,255,0.3);
        color: #fff;
        padding: 8px 16px;
        border-radius: 8px;
        cursor: pointer;
        font-size: 0.8rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    .toggle-all-btn:hover { background: rgba(255,255,255,0.3); }
    .permission-module-body { padding: 15px; }
    .permission-item {
        display: flex;
        align-items: center;
        padding: 12px 15px;
        border-radius: 10px;
        margin-bottom: 8px;
        background: #f8f9fa;
        border: 2px solid transparent;
        transition: all 0.2s ease;
        cursor: pointer;
    }
    .permission-item:last-child { margin-bottom: 0; }
    .permission-item:hover { background: #f0f0f0; }
    .permission-item.selected {
        background: rgba(26, 125, 107, 0.08);
        border-color: var(--primary-color);
    }
    .permission-item label {
        margin: 0;
        cursor: pointer;
        flex: 1;
        display: flex;
        align-items: center;
        gap: 12px;
        font-weight: 500;
        color: var(--secondary-color);
    }
    .permission-item input[type="checkbox"] {
        width: 20px;
        height: 20px;
        cursor: pointer;
        accent-color: var(--primary-color);
    }
    .permission-badge {
        font-size: 0.75rem;
        padding: 5px 12px;
        border-radius: 6px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .permission-badge.view { background: rgba(26, 125, 107, 0.12); color: var(--primary-color); }
    .permission-badge.create { background: rgba(40, 167, 69, 0.12); color: #28a745; }
    .permission-badge.edit { background: rgba(232, 184, 94, 0.2); color: #c9a227; }
    .permission-badge.delete { background: rgba(225, 39, 61, 0.12); color: #e1273d; }
    .permission-badge.restore { background: rgba(111, 66, 193, 0.12); color: #6f42c1; }
    .permission-badge.force_delete { background: var(--secondary-color); color: #fff; }

    /* Submit Buttons */
    .form-actions {
        display: flex;
        gap: 15px;
        padding-top: 20px;
        border-top: 1px solid #f0f0f0;
        margin-top: 30px;
    }
    .submit-btn {
        padding: 14px 30px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 1rem;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }
    .submit-btn:hover { transform: translateY(-2px); }
    .submit-btn.primary {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
        color: #fff;
        box-shadow: 0 8px 25px rgba(26, 125, 107, 0.35);
    }
    .submit-btn.primary:hover { box-shadow: 0 12px 35px rgba(26, 125, 107, 0.45); }
    .submit-btn.secondary {
        background: #e9ecef;
        color: var(--secondary-color);
    }
    .submit-btn.secondary:hover { background: #dee2e6; }

    /* Module Icons Map */
    @php
        $moduleIcons = [
            'projects' => 'fa-building',
            'offers' => 'fa-tag',
            'services' => 'fa-briefcase',
            'news' => 'fa-newspaper-o',
            'portfolios' => 'fa-folder-open',
            'sliders' => 'fa-image',
            'partners' => 'fa-handshake-o',
            'team' => 'fa-users',
            'interior-design-galleries' => 'fa-paint-brush',
            'menus' => 'fa-bars',
            'menu-items' => 'fa-list',
            'certificates' => 'fa-certificate',
            'users' => 'fa-user',
            'roles' => 'fa-shield',
            'settings' => 'fa-cog',
            'activity-logs' => 'fa-history',
            'dashboard' => 'fa-dashboard',
        ];
    @endphp

    @media (max-width: 768px) {
        .page-hero { flex-direction: column; text-align: center; gap: 20px; }
        .permissions-grid { grid-template-columns: 1fr; }
        .global-actions { justify-content: center; }
        .form-actions { flex-direction: column; }
        .submit-btn { width: 100%; justify-content: center; }
    }
</style>
@endsection

@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        <nav class="breadcrumbs">
            <a href="{{ route('Admin') }}" class="breadcrumbs__item">
                <i class="fa fa-home"></i> Dashboard
            </a>
            <a href="{{ route('admin.roles.index') }}" class="breadcrumbs__item">
                <i class="fa fa-shield"></i> Roles
            </a>
            <a href="#" class="breadcrumbs__item is-active" style="pointer-events: none;">
                Create Role
            </a>
        </nav>

        <div class="col-lg-12">
            <hr>
            
            <!-- Page Hero -->
            <div class="page-hero">
                <div class="page-hero-content">
                    <div class="page-hero-icon">
                        <i class="fa fa-plus"></i>
                    </div>
                    <h1>Create New Role</h1>
                    <p>Define a new role with specific permissions for your team</p>
                </div>
                <div class="page-hero-actions">
                    <a href="{{ route('admin.roles.index') }}" class="hero-btn">
                        <i class="fa fa-arrow-left"></i> Back to Roles
                    </a>
                </div>
            </div>

            <form action="{{ route('admin.roles.store') }}" method="POST">
                @csrf

                <!-- Role Details Card -->
                <div class="form-card">
                    <div class="form-card-header">
                        <div class="header-icon">
                            <i class="fa fa-info-circle"></i>
                        </div>
                        <div>
                            <h3>Role Details</h3>
                            <p>Basic information about the role</p>
                        </div>
                    </div>
                    <div class="form-card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Role Name <span class="required">*</span></label>
                                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" 
                                           value="{{ old('name') }}" required placeholder="e.g., Content Manager">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Description</label>
                                    <input type="text" name="description" id="description" class="form-control @error('description') is-invalid @enderror" 
                                           value="{{ old('description') }}" placeholder="Brief description of this role">
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="toggle-wrapper">
                            <label class="toggle-switch">
                                <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                            </label>
                            <div class="toggle-label">
                                <h6>Active Status</h6>
                                <p>Inactive roles cannot be assigned to users</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Permissions Card -->
                <div class="form-card">
                    <div class="form-card-header">
                        <div class="header-icon">
                            <i class="fa fa-key"></i>
                        </div>
                        <div>
                            <h3>Permissions</h3>
                            <p>Select the permissions for this role</p>
                        </div>
                    </div>
                    <div class="form-card-body">
                        <!-- Global Actions -->
                        <div class="global-actions">
                            <span class="global-actions-title">
                                <i class="fa fa-magic"></i> Quick Actions:
                            </span>
                            <button type="button" class="action-btn success" onclick="selectAllPermissions()">
                                <i class="fa fa-check-double"></i> Select All
                            </button>
                            <button type="button" class="action-btn secondary" onclick="deselectAllPermissions()">
                                <i class="fa fa-times"></i> Deselect All
                            </button>
                            <button type="button" class="action-btn info" onclick="selectAllView()">
                                <i class="fa fa-eye"></i> All View
                            </button>
                            <button type="button" class="action-btn warning" onclick="selectAllCRUD()">
                                <i class="fa fa-edit"></i> All CRUD
                            </button>
                        </div>

                        <!-- Permissions Grid -->
                        <div class="permissions-grid">
                            @php
                                $moduleIcons = [
                                    'projects' => 'fa-building',
                                    'offers' => 'fa-tag',
                                    'services' => 'fa-briefcase',
                                    'news' => 'fa-newspaper-o',
                                    'portfolios' => 'fa-folder-open',
                                    'sliders' => 'fa-image',
                                    'partners' => 'fa-handshake-o',
                                    'team' => 'fa-users',
                                    'interior-design-galleries' => 'fa-paint-brush',
                                    'menus' => 'fa-bars',
                                    'menu-items' => 'fa-list',
                                    'certificates' => 'fa-certificate',
                                    'users' => 'fa-user',
                                    'roles' => 'fa-shield',
                                    'settings' => 'fa-cog',
                                    'activity-logs' => 'fa-history',
                                    'dashboard' => 'fa-dashboard',
                                    'about-information' => 'fa-info-circle',
                                    'about-features' => 'fa-star',
                                    'about-custom-blocks' => 'fa-th-large',
                                    'contact-information' => 'fa-phone',
                                    'home-sections' => 'fa-home',
                                    'home-projects' => 'fa-building',
                                    'page-banners' => 'fa-image',
                                    'job-postings' => 'fa-briefcase',
                                    'job-applications' => 'fa-file-text',
                                    'contact-us' => 'fa-envelope',
                                    'categories' => 'fa-tags',
                                    'engineering-sub-categories' => 'fa-sitemap',
                                ];
                            @endphp
                            
                            @foreach($permissions as $module => $modulePermissions)
                                <div class="permission-module">
                                    <div class="permission-module-header">
                                        <div class="module-title">
                                            <span class="module-icon">
                                                <i class="fa {{ $moduleIcons[$module] ?? 'fa-folder' }}"></i>
                                            </span>
                                            <h5>{{ ucwords(str_replace('-', ' ', $module)) }}</h5>
                                        </div>
                                        <button type="button" class="toggle-all-btn" onclick="toggleModulePermissions('{{ Str::slug($module) }}')">
                                            Toggle All
                                        </button>
                                    </div>
                                    <div class="permission-module-body">
                                        @foreach($modulePermissions as $permission)
                                            <div class="permission-item" onclick="togglePermission(this)">
                                                <label onclick="event.stopPropagation()">
                                                    <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" 
                                                           class="permission-checkbox module-{{ Str::slug($module) }}" 
                                                           data-action="{{ $permission->action }}"
                                                           {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}>
                                                    {{ ucfirst(str_replace('_', ' ', $permission->action)) }}
                                                </label>
                                                <span class="permission-badge {{ $permission->action }}">
                                                    {{ strtoupper(str_replace('_', ' ', $permission->action)) }}
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Form Actions -->
                        <div class="form-actions">
                            <button type="submit" class="submit-btn primary">
                                <i class="fa fa-save"></i> Create Role
                            </button>
                            <a href="{{ route('admin.roles.index') }}" class="submit-btn secondary">
                                <i class="fa fa-times"></i> Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    function togglePermission(item) {
        const checkbox = item.querySelector('input[type="checkbox"]');
        checkbox.checked = !checkbox.checked;
        item.classList.toggle('selected', checkbox.checked);
    }

    function selectAllPermissions() {
        document.querySelectorAll('.permission-checkbox').forEach(cb => {
            cb.checked = true;
            cb.closest('.permission-item').classList.add('selected');
        });
    }
    
    function deselectAllPermissions() {
        document.querySelectorAll('.permission-checkbox').forEach(cb => {
            cb.checked = false;
            cb.closest('.permission-item').classList.remove('selected');
        });
    }
    
    function selectAllView() {
        document.querySelectorAll('.permission-checkbox[data-action="view"]').forEach(cb => {
            cb.checked = true;
            cb.closest('.permission-item').classList.add('selected');
        });
    }
    
    function selectAllCRUD() {
        document.querySelectorAll('.permission-checkbox').forEach(cb => {
            const action = cb.dataset.action;
            const shouldCheck = ['view', 'create', 'edit'].includes(action);
            cb.checked = shouldCheck;
            cb.closest('.permission-item').classList.toggle('selected', shouldCheck);
        });
    }
    
    function toggleModulePermissions(module) {
        const checkboxes = document.querySelectorAll('.module-' + module);
        const allChecked = Array.from(checkboxes).every(cb => cb.checked);
        checkboxes.forEach(cb => {
            cb.checked = !allChecked;
            cb.closest('.permission-item').classList.toggle('selected', !allChecked);
        });
    }

    // Initialize selected state on page load
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.permission-checkbox:checked').forEach(cb => {
            cb.closest('.permission-item').classList.add('selected');
        });
    });
</script>
@endsection
