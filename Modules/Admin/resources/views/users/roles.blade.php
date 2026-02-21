@extends('admin::layouts.master')
@section('title', 'User Roles Management')

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
    .page-hero-stats {
        display: flex;
        gap: 15px;
        margin-top: 20px;
    }
    .hero-stat {
        background: rgba(255,255,255,0.15);
        padding: 12px 20px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        gap: 10px;
        backdrop-filter: blur(10px);
    }
    .hero-stat i { color: var(--accent-color); font-size: 1.1rem; }
    .hero-stat .stat-value { color: #fff; font-weight: 700; font-size: 1.2rem; }
    .hero-stat .stat-label { color: rgba(255,255,255,0.7); font-size: 0.8rem; margin-left: 5px; }
    .page-hero-actions { position: relative; z-index: 1; display: flex; gap: 12px; flex-wrap: wrap; }
    .hero-btn {
        padding: 12px 24px;
        border-radius: 12px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        text-decoration: none;
        border: none;
        cursor: pointer;
    }
    .hero-btn:hover { transform: translateY(-2px); }
    .hero-btn.secondary {
        background: rgba(255,255,255,0.15);
        border: 1px solid rgba(255,255,255,0.3);
        color: #fff;
    }
    .hero-btn.secondary:hover { background: rgba(255,255,255,0.25); color: #fff; }

    /* Filter Bar */
    .filter-bar {
        background: #fff;
        border-radius: 16px;
        padding: 20px 25px;
        margin-bottom: 25px;
        box-shadow: var(--card-shadow);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }
    .filter-tabs {
        display: flex;
        gap: 8px;
    }
    .filter-tab {
        padding: 10px 20px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s ease;
        border: 2px solid transparent;
        background: #f8f9fa;
        color: var(--secondary-color);
    }
    .filter-tab:hover { background: #e9ecef; }
    .filter-tab.active {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
        color: #fff;
    }
    .filter-tab .count {
        background: rgba(255,255,255,0.2);
        padding: 2px 8px;
        border-radius: 10px;
        font-size: 0.75rem;
        margin-left: 8px;
    }
    .filter-tab.active .count { background: rgba(255,255,255,0.3); }
    .search-box {
        position: relative;
        min-width: 280px;
    }
    .search-box input {
        width: 100%;
        padding: 12px 18px 12px 45px;
        border: 2px solid #e9ecef;
        border-radius: 12px;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }
    .search-box input:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 4px rgba(26, 125, 107, 0.1);
    }
    .search-box i {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #adb5bd;
    }

    /* Users Grid */
    .users-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
        gap: 25px;
    }

    /* User Card */
    .user-card {
        background: #fff;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: var(--card-shadow);
        transition: all 0.3s ease;
        position: relative;
    }
    .user-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 60px rgba(0,0,0,0.12);
    }
    .user-card.super-admin::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 5px;
        height: 100%;
        background: linear-gradient(180deg, var(--accent-color), var(--danger-color));
    }
    .user-card.no-roles { opacity: 0.85; }
    
    .user-card-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 50%, var(--secondary-color) 100%);
        padding: 25px;
        display: flex;
        align-items: center;
        gap: 20px;
    }
    .user-avatar {
        width: 70px;
        height: 70px;
        background: rgba(255,255,255,0.2);
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        font-weight: 700;
        color: #fff;
        flex-shrink: 0;
    }
    .user-info { flex: 1; }
    .user-name {
        color: #fff;
        font-size: 1.3rem;
        font-weight: 700;
        margin: 0 0 5px 0;
    }
    .user-email {
        color: rgba(255,255,255,0.7);
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .super-admin-badge {
        background: linear-gradient(135deg, var(--accent-color), #f5a623);
        color: #fff;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-top: 8px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .user-card-body { padding: 25px; }
    .roles-section {
        margin-bottom: 20px;
    }
    .roles-section-title {
        font-size: 0.85rem;
        font-weight: 600;
        color: #666;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 12px;
    }
    .role-badges {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }
    .role-badge {
        padding: 8px 16px;
        border-radius: 10px;
        font-size: 0.85rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .role-badge.super-admin {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: #fff;
    }
    .role-badge.admin {
        background: linear-gradient(135deg, #28a745, #20c997);
        color: #fff;
    }
    .role-badge.editor {
        background: linear-gradient(135deg, var(--accent-color), var(--accent-light));
        color: #fff;
    }
    .role-badge.viewer {
        background: linear-gradient(135deg, #17a2b8, #20c997);
        color: #fff;
    }
    .role-badge.default {
        background: linear-gradient(135deg, #6c757d, #495057);
        color: #fff;
    }
    .no-roles-badge {
        background: #f8f9fa;
        color: #999;
        padding: 10px 20px;
        border-radius: 10px;
        font-style: italic;
        font-size: 0.9rem;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .user-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        padding-top: 20px;
        border-top: 1px solid #f0f0f0;
    }
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
        text-decoration: none;
    }
    .action-btn:hover { transform: translateY(-2px); }
    .action-btn.edit {
        background: linear-gradient(135deg, var(--accent-color), var(--accent-light));
        color: #fff;
    }
    .action-btn.view {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
        color: #fff;
    }
    .action-btn.disabled {
        background: #e9ecef;
        color: #999;
        cursor: not-allowed;
        pointer-events: none;
    }

    /* Empty State */
    .empty-state {
        background: #fff;
        border-radius: 20px;
        padding: 60px 40px;
        text-align: center;
        box-shadow: var(--card-shadow);
    }
    .empty-state-icon {
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, rgba(26, 125, 107, 0.1), rgba(26, 125, 107, 0.05));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 25px;
    }
    .empty-state-icon i { font-size: 2.5rem; color: var(--primary-color); opacity: 0.5; }
    .empty-state h4 { color: var(--secondary-color); margin-bottom: 10px; font-weight: 600; }
    .empty-state p { color: #666; margin-bottom: 25px; }

    /* Pagination */
    .pagination-wrapper {
        margin-top: 30px;
        display: flex;
        justify-content: center;
    }

    @media (max-width: 992px) {
        .page-hero { flex-direction: column; text-align: center; gap: 25px; }
        .page-hero-stats { justify-content: center; flex-wrap: wrap; }
        .page-hero-actions { justify-content: center; }
        .users-grid { grid-template-columns: 1fr; }
        .filter-bar { flex-direction: column; align-items: stretch; }
        .filter-tabs { justify-content: center; flex-wrap: wrap; }
        .search-box { min-width: 100%; }
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
            <a href="#" class="breadcrumbs__item is-active" style="pointer-events: none;">
                <i class="fa fa-user-tag"></i> User Roles Management
            </a>
        </nav>

        <div class="col-lg-12">
            <hr>
            
            <!-- Page Hero -->
            <div class="page-hero">
                <div class="page-hero-content">
                    <div class="page-hero-icon">
                        <i class="fa fa-user-tag"></i>
                    </div>
                    <h1>User Roles Management</h1>
                    <p>Assign and manage roles for users across the system</p>
                    <div class="page-hero-stats">
                        <div class="hero-stat">
                            <i class="fa fa-users"></i>
                            <span class="stat-value">{{ $totalUsers }}</span>
                            <span class="stat-label">Total Users</span>
                        </div>
                        <div class="hero-stat">
                            <i class="fa fa-user-check"></i>
                            <span class="stat-value">{{ $usersWithRoles }}</span>
                            <span class="stat-label">With Roles</span>
                        </div>
                        <div class="hero-stat">
                            <i class="fa fa-user-times"></i>
                            <span class="stat-value">{{ $usersWithoutRoles }}</span>
                            <span class="stat-label">No Roles</span>
                        </div>
                    </div>
                </div>
                <div class="page-hero-actions">
                    <a href="{{ route('admin.roles.index') }}" class="hero-btn secondary">
                        <i class="fa fa-shield"></i> Manage Roles
                    </a>
                    <a href="{{ route('Admin') }}" class="hero-btn secondary">
                        <i class="fa fa-arrow-left"></i> Back
                    </a>
                </div>
            </div>

            <!-- Filter Bar -->
            <div class="filter-bar">
                <div class="filter-tabs">
                    <button class="filter-tab active" data-filter="all">
                        All Users <span class="count">{{ $users->total() }}</span>
                    </button>
                    <button class="filter-tab" data-filter="with-roles">
                        With Roles <span class="count">{{ $usersWithRoles }}</span>
                    </button>
                    <button class="filter-tab" data-filter="no-roles">
                        No Roles <span class="count">{{ $usersWithoutRoles }}</span>
                    </button>
                </div>
                <div class="search-box">
                    <i class="fa fa-search"></i>
                    <input type="text" id="userSearch" placeholder="Search users...">
                </div>
            </div>

            <!-- Users Grid -->
            @if($users->count() > 0)
                <div class="users-grid" id="usersContainer">
                    @foreach($users as $user)
                        @php
                            $isSuperAdmin = $user->hasRole('super-admin');
                            $hasRoles = $user->roles->count() > 0;
                        @endphp
                        <div class="user-card {{ $isSuperAdmin ? 'super-admin' : '' }} {{ !$hasRoles ? 'no-roles' : '' }}"
                             data-name="{{ strtolower($user->name) }}"
                             data-email="{{ strtolower($user->email) }}"
                             data-has-roles="{{ $hasRoles ? 'true' : 'false' }}">
                            <div class="user-card-header">
                                <div class="user-avatar">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div class="user-info">
                                    <h3 class="user-name">{{ $user->name }}</h3>
                                    <span class="user-email">
                                        <i class="fa fa-envelope"></i> {{ $user->email }}
                                    </span>
                                    @if($isSuperAdmin)
                                        <div class="super-admin-badge">
                                            <i class="fa fa-crown"></i> Super Admin
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="user-card-body">
                                <div class="roles-section">
                                    <div class="roles-section-title">Assigned Roles</div>
                                    <div class="role-badges">
                                        @if($user->roles->count() > 0)
                                            @foreach($user->roles as $role)
                                                @php
                                                    $badgeClass = 'default';
                                                    if ($role->slug === 'super-admin') $badgeClass = 'super-admin';
                                                    elseif ($role->slug === 'admin') $badgeClass = 'admin';
                                                    elseif ($role->slug === 'editor') $badgeClass = 'editor';
                                                    elseif ($role->slug === 'viewer') $badgeClass = 'viewer';
                                                @endphp
                                                <span class="role-badge {{ $badgeClass }}">
                                                    <i class="fa fa-shield"></i> {{ $role->name }}
                                                </span>
                                            @endforeach
                                        @else
                                            <span class="no-roles-badge">
                                                <i class="fa fa-exclamation-circle"></i> No roles assigned
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="user-actions">
                                    @if(auth()->user()->hasPermission('users-edit'))
                                        @if($isSuperAdmin && !auth()->user()->isSuperAdmin())
                                            <span class="action-btn disabled" title="Cannot edit Super Admin roles">
                                                <i class="fa fa-lock"></i> Protected
                                            </span>
                                        @else
                                            <a href="{{ route('admin.users.roles.edit', $user) }}" class="action-btn edit">
                                                <i class="fa fa-edit"></i> Edit Roles
                                            </a>
                                        @endif
                                    @endif
                                    @if(auth()->user()->hasPermission('users-view'))
                                        <a href="{{ route('admin.users.roles.permissions', $user) }}" class="action-btn view">
                                            <i class="fa fa-key"></i> View Permissions
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="pagination-wrapper">
                    {{ $users->links() }}
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="fa fa-users"></i>
                    </div>
                    <h4>No Users Found</h4>
                    <p>There are no users in the system yet.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('userSearch');
    const filterTabs = document.querySelectorAll('.filter-tab');
    const usersContainer = document.getElementById('usersContainer');
    
    if (!usersContainer) return;
    
    const userCards = usersContainer.querySelectorAll('.user-card');
    let currentFilter = 'all';

    // Search functionality
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            filterUsers();
        });
    }

    // Filter tabs
    filterTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            filterTabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            currentFilter = this.dataset.filter;
            filterUsers();
        });
    });

    function filterUsers() {
        const searchTerm = searchInput ? searchInput.value.toLowerCase() : '';
        
        userCards.forEach(card => {
            const name = card.dataset.name;
            const email = card.dataset.email;
            const hasRoles = card.dataset.hasRoles === 'true';
            
            let matchesFilter = true;
            let matchesSearch = name.includes(searchTerm) || email.includes(searchTerm);
            
            switch(currentFilter) {
                case 'with-roles':
                    matchesFilter = hasRoles;
                    break;
                case 'no-roles':
                    matchesFilter = !hasRoles;
                    break;
            }
            
            if (matchesFilter && matchesSearch) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }
});
</script>
@endsection
