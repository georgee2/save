@extends('admin::layouts.master')
@section('title', 'User Permissions - ' . $user->name)

@section('css')
<style>
    :root {
        --primary-color: #1a7d6b;
        --primary-dark: #145f52;
        --primary-light: #22a88f;
        --secondary-color: #2d3748;
        --accent-color: #e8b85e;
        --accent-light: #f0cb82;
        --danger-color: #e1273d;
        --card-shadow: 0 10px 40px rgba(0,0,0,0.08);
    }

    /* Page Hero */
    .page-hero {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 50%, var(--secondary-color) 100%);
        border-radius: 20px;
        padding: 35px 40px;
        margin-bottom: 30px;
        position: relative;
        overflow: hidden;
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
    .page-hero-content {
        position: relative;
        z-index: 1;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }
    .user-profile {
        display: flex;
        align-items: center;
        gap: 25px;
    }
    .user-avatar-large {
        width: 90px;
        height: 90px;
        background: rgba(255,255,255,0.2);
        border-radius: 22px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        font-weight: 700;
        color: #fff;
        flex-shrink: 0;
    }
    .user-details h1 {
        color: #fff;
        font-size: 1.8rem;
        font-weight: 700;
        margin: 0 0 8px 0;
    }
    .user-details .user-email {
        color: rgba(255,255,255,0.8);
        font-size: 1rem;
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 12px;
    }
    .user-roles-badges {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }
    .role-badge {
        background: rgba(255,255,255,0.2);
        color: #fff;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .hero-stats {
        display: flex;
        gap: 15px;
    }
    .hero-stat-card {
        background: rgba(255,255,255,0.15);
        padding: 20px 25px;
        border-radius: 16px;
        text-align: center;
        backdrop-filter: blur(10px);
        min-width: 120px;
    }
    .hero-stat-card .stat-value {
        font-size: 2rem;
        font-weight: 700;
        color: #fff;
        line-height: 1;
    }
    .hero-stat-card .stat-label {
        font-size: 0.8rem;
        color: rgba(255,255,255,0.7);
        margin-top: 8px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Action Buttons */
    .page-actions {
        display: flex;
        gap: 12px;
        margin-bottom: 30px;
    }
    .action-btn {
        padding: 12px 24px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.9rem;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        transition: all 0.3s ease;
        text-decoration: none;
        border: none;
        cursor: pointer;
    }
    .action-btn:hover { transform: translateY(-2px); }
    .action-btn.primary {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
        color: #fff;
        box-shadow: 0 8px 25px rgba(26, 125, 107, 0.35);
    }
    .action-btn.secondary {
        background: #fff;
        color: var(--secondary-color);
        border: 2px solid #e9ecef;
    }
    .action-btn.secondary:hover { border-color: var(--primary-color); color: var(--primary-color); }

    /* Super Admin Notice */
    .super-admin-notice {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 16px;
        padding: 25px 30px;
        margin-bottom: 30px;
        display: flex;
        align-items: center;
        gap: 20px;
        color: #fff;
    }
    .super-admin-notice-icon {
        width: 60px;
        height: 60px;
        background: rgba(255,255,255,0.2);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .super-admin-notice-icon i { font-size: 1.5rem; color: var(--accent-color); }
    .super-admin-notice-content h4 { margin: 0 0 8px 0; font-weight: 700; }
    .super-admin-notice-content p { margin: 0; opacity: 0.9; }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        gap: 15px;
        margin-bottom: 30px;
    }
    .stat-card {
        background: #fff;
        border-radius: 16px;
        padding: 25px 20px;
        text-align: center;
        box-shadow: var(--card-shadow);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 60px rgba(0,0,0,0.12);
    }
    .stat-card .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 15px;
        font-size: 1.2rem;
    }
    .stat-card .stat-number {
        font-size: 2rem;
        font-weight: 700;
        line-height: 1;
        margin-bottom: 8px;
    }
    .stat-card .stat-text {
        font-size: 0.8rem;
        color: #666;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
    }
    
    .stat-card.view::before { background: linear-gradient(135deg, var(--primary-color), var(--primary-light)); }
    .stat-card.view .stat-icon { background: rgba(26, 125, 107, 0.1); color: var(--primary-color); }
    .stat-card.view .stat-number { color: var(--primary-color); }
    
    .stat-card.create::before { background: linear-gradient(135deg, #28a745, #20c997); }
    .stat-card.create .stat-icon { background: rgba(40, 167, 69, 0.1); color: #28a745; }
    .stat-card.create .stat-number { color: #28a745; }
    
    .stat-card.edit::before { background: linear-gradient(135deg, var(--accent-color), var(--accent-light)); }
    .stat-card.edit .stat-icon { background: rgba(232, 184, 94, 0.15); color: var(--accent-color); }
    .stat-card.edit .stat-number { color: #d4a84a; }
    
    .stat-card.delete::before { background: linear-gradient(135deg, #e1273d, #c82333); }
    .stat-card.delete .stat-icon { background: rgba(225, 39, 61, 0.1); color: #e1273d; }
    .stat-card.delete .stat-number { color: #e1273d; }
    
    .stat-card.restore::before { background: linear-gradient(135deg, #6f42c1, #9561e2); }
    .stat-card.restore .stat-icon { background: rgba(111, 66, 193, 0.1); color: #6f42c1; }
    .stat-card.restore .stat-number { color: #6f42c1; }
    
    .stat-card.force::before { background: linear-gradient(135deg, var(--secondary-color), #1a202c); }
    .stat-card.force .stat-icon { background: rgba(45, 55, 72, 0.1); color: var(--secondary-color); }
    .stat-card.force .stat-number { color: var(--secondary-color); }

    /* Permissions Card */
    .permissions-card {
        background: #fff;
        border-radius: 20px;
        box-shadow: var(--card-shadow);
        overflow: hidden;
    }
    .permissions-card-header {
        padding: 25px 30px;
        border-bottom: 1px solid #f0f0f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .permissions-card-header h3 {
        margin: 0;
        font-size: 1.2rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 12px;
        color: var(--secondary-color);
    }
    .permissions-card-header h3 .header-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .permissions-card-header h3 .header-icon i { color: #fff; font-size: 1rem; }
    .header-badge {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
        color: #fff;
        padding: 6px 16px;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 600;
    }
    .permissions-card-body { padding: 30px; }

    /* Search Box */
    .search-box {
        position: relative;
        margin-bottom: 25px;
    }
    .search-box input {
        width: 100%;
        padding: 14px 20px 14px 50px;
        border: 2px solid #e9ecef;
        border-radius: 12px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }
    .search-box input:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 4px rgba(26, 125, 107, 0.1);
    }
    .search-box i {
        position: absolute;
        left: 18px;
        top: 50%;
        transform: translateY(-50%);
        color: #adb5bd;
    }

    /* Modules Grid */
    .modules-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 20px;
    }
    .module-card {
        background: linear-gradient(145deg, #fafafa, #fff);
        border: 1px solid #eee;
        border-radius: 16px;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    .module-card:hover {
        border-color: var(--primary-color);
        box-shadow: 0 10px 30px rgba(26, 125, 107, 0.15);
        transform: translateY(-3px);
    }
    .module-header {
        padding: 18px 20px;
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 50%, var(--secondary-color) 100%);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .module-title {
        display: flex;
        align-items: center;
        gap: 12px;
        color: #fff;
        font-weight: 700;
        font-size: 0.95rem;
    }
    .module-icon {
        width: 38px;
        height: 38px;
        background: rgba(255,255,255,0.2);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .module-icon i { color: #fff; font-size: 0.95rem; }
    .module-count {
        background: rgba(255,255,255,0.2);
        color: #fff;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
    }
    .module-permissions {
        padding: 15px 20px;
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }
    .perm-badge {
        padding: 8px 14px;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
    }
    .perm-badge:hover { transform: scale(1.05); }
    .perm-badge.view { background: rgba(26, 125, 107, 0.12); color: var(--primary-color); }
    .perm-badge.create { background: rgba(40, 167, 69, 0.12); color: #28a745; }
    .perm-badge.edit { background: rgba(232, 184, 94, 0.2); color: #c9a227; }
    .perm-badge.delete { background: rgba(225, 39, 61, 0.12); color: #e1273d; }
    .perm-badge.restore { background: rgba(111, 66, 193, 0.12); color: #6f42c1; }
    .perm-badge.force_delete { background: var(--secondary-color); color: #fff; }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 40px;
    }
    .empty-state-icon {
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, rgba(232, 184, 94, 0.15), rgba(232, 184, 94, 0.05));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 25px;
    }
    .empty-state-icon i { font-size: 2.5rem; color: var(--accent-color); }
    .empty-state h4 { color: var(--secondary-color); margin-bottom: 10px; font-weight: 600; }
    .empty-state p { color: #666; margin-bottom: 25px; }

    @media (max-width: 1200px) {
        .stats-grid { grid-template-columns: repeat(3, 1fr); }
    }
    @media (max-width: 992px) {
        .page-hero-content { flex-direction: column; gap: 25px; }
        .user-profile { flex-direction: column; text-align: center; }
        .user-roles-badges { justify-content: center; }
        .hero-stats { justify-content: center; }
        .stats-grid { grid-template-columns: repeat(2, 1fr); }
        .modules-grid { grid-template-columns: 1fr; }
        .page-actions { flex-wrap: wrap; justify-content: center; }
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
            <a href="{{ route('admin.users.roles.index') }}" class="breadcrumbs__item">
                <i class="fa fa-user-tag"></i> User Roles
            </a>
            <a href="#" class="breadcrumbs__item is-active" style="pointer-events: none;">
                User Permissions
            </a>
        </nav>

        <div class="col-lg-12">
            <hr>
            
            <!-- Page Hero -->
            <div class="page-hero">
                <div class="page-hero-content">
                    <div class="user-profile">
                        <div class="user-avatar-large">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div class="user-details">
                            <h1>{{ $user->name }}</h1>
                            <span class="user-email">
                                <i class="fa fa-envelope"></i> {{ $user->email }}
                            </span>
                            <div class="user-roles-badges">
                                @if($user->roles->count() > 0)
                                    @foreach($user->roles as $role)
                                        <span class="role-badge">
                                            <i class="fa fa-shield"></i> {{ $role->name }}
                                        </span>
                                    @endforeach
                                @else
                                    <span class="role-badge">
                                        <i class="fa fa-exclamation-circle"></i> No roles assigned
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="hero-stats">
                        <div class="hero-stat-card">
                            <div class="stat-value">{{ $user->roles->count() }}</div>
                            <div class="stat-label">Roles</div>
                        </div>
                        <div class="hero-stat-card">
                            <div class="stat-value">{{ $permissions->flatten()->count() }}</div>
                            <div class="stat-label">Permissions</div>
                        </div>
                        <div class="hero-stat-card">
                            <div class="stat-value">{{ $permissions->count() }}</div>
                            <div class="stat-label">Modules</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="page-actions">
                @if(auth()->user()->hasPermission('users-edit') && !($user->isSuperAdmin() && !auth()->user()->isSuperAdmin()))
                    <a href="{{ route('admin.users.roles.edit', $user) }}" class="action-btn primary">
                        <i class="fa fa-edit"></i> Edit Roles
                    </a>
                @endif
                <a href="{{ route('admin.users.roles.index') }}" class="action-btn secondary">
                    <i class="fa fa-arrow-left"></i> Back to Users
                </a>
            </div>

            @if($user->isSuperAdmin())
                <div class="super-admin-notice">
                    <div class="super-admin-notice-icon">
                        <i class="fa fa-crown"></i>
                    </div>
                    <div class="super-admin-notice-content">
                        <h4>Super Admin Access</h4>
                        <p>This user has the Super Admin role and has full access to all permissions in the system.</p>
                    </div>
                </div>
            @endif

            @php
                $allPermissions = $permissions->flatten();
                $actionCounts = [
                    'view' => $allPermissions->where('action', 'view')->count(),
                    'create' => $allPermissions->where('action', 'create')->count(),
                    'edit' => $allPermissions->where('action', 'edit')->count(),
                    'delete' => $allPermissions->where('action', 'delete')->count(),
                    'restore' => $allPermissions->where('action', 'restore')->count(),
                    'force_delete' => $allPermissions->where('action', 'force_delete')->count(),
                ];
            @endphp

            <!-- Stats Grid -->
            <div class="stats-grid">
                <div class="stat-card view">
                    <div class="stat-icon"><i class="fa fa-eye"></i></div>
                    <div class="stat-number">{{ $actionCounts['view'] }}</div>
                    <div class="stat-text">View</div>
                </div>
                <div class="stat-card create">
                    <div class="stat-icon"><i class="fa fa-plus"></i></div>
                    <div class="stat-number">{{ $actionCounts['create'] }}</div>
                    <div class="stat-text">Create</div>
                </div>
                <div class="stat-card edit">
                    <div class="stat-icon"><i class="fa fa-pencil"></i></div>
                    <div class="stat-number">{{ $actionCounts['edit'] }}</div>
                    <div class="stat-text">Edit</div>
                </div>
                <div class="stat-card delete">
                    <div class="stat-icon"><i class="fa fa-trash"></i></div>
                    <div class="stat-number">{{ $actionCounts['delete'] }}</div>
                    <div class="stat-text">Delete</div>
                </div>
                <div class="stat-card restore">
                    <div class="stat-icon"><i class="fa fa-undo"></i></div>
                    <div class="stat-number">{{ $actionCounts['restore'] }}</div>
                    <div class="stat-text">Restore</div>
                </div>
                <div class="stat-card force">
                    <div class="stat-icon"><i class="fa fa-times"></i></div>
                    <div class="stat-number">{{ $actionCounts['force_delete'] }}</div>
                    <div class="stat-text">Force Delete</div>
                </div>
            </div>

            <!-- Permissions Card -->
            <div class="permissions-card">
                <div class="permissions-card-header">
                    <h3>
                        <span class="header-icon"><i class="fa fa-key"></i></span>
                        Permissions by Module
                    </h3>
                    <span class="header-badge">{{ $permissions->flatten()->count() }} Total</span>
                </div>
                <div class="permissions-card-body">
                    @if($permissions->count() > 0)
                        <div class="search-box">
                            <i class="fa fa-search"></i>
                            <input type="text" id="moduleSearch" placeholder="Search modules...">
                        </div>
                        
                        <div class="modules-grid" id="modulesContainer">
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
                                
                                $actionIcons = [
                                    'view' => 'eye',
                                    'create' => 'plus',
                                    'edit' => 'pencil',
                                    'delete' => 'trash',
                                    'restore' => 'undo',
                                    'force_delete' => 'times',
                                ];
                            @endphp
                            
                            @foreach($permissions as $module => $modulePermissions)
                                <div class="module-card" data-module="{{ strtolower($module) }}">
                                    <div class="module-header">
                                        <div class="module-title">
                                            <span class="module-icon">
                                                <i class="fa {{ $moduleIcons[$module] ?? 'fa-folder' }}"></i>
                                            </span>
                                            {{ ucwords(str_replace('-', ' ', $module)) }}
                                        </div>
                                        <span class="module-count">{{ $modulePermissions->count() }}</span>
                                    </div>
                                    <div class="module-permissions">
                                        @foreach($modulePermissions->sortBy('order') as $permission)
                                            <span class="perm-badge {{ $permission->action }}">
                                                <i class="fa fa-{{ $actionIcons[$permission->action] ?? 'check' }}"></i>
                                                {{ ucfirst(str_replace('_', ' ', $permission->action)) }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <i class="fa fa-exclamation-triangle"></i>
                            </div>
                            <h4>No Permissions</h4>
                            <p>This user has no permissions. Please assign a role to grant permissions.</p>
                            @if(auth()->user()->hasPermission('users-edit'))
                                <a href="{{ route('admin.users.roles.edit', $user) }}" class="action-btn primary">
                                    <i class="fa fa-user-tag"></i> Assign Roles
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('moduleSearch');
    const modulesContainer = document.getElementById('modulesContainer');
    
    if (searchInput && modulesContainer) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const moduleCards = modulesContainer.querySelectorAll('.module-card');
            
            moduleCards.forEach(card => {
                const moduleName = card.dataset.module;
                if (moduleName.includes(searchTerm)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    }
});
</script>
@endsection
