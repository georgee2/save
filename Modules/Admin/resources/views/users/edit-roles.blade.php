@extends('admin::layouts.master')
@section('title', 'Edit User Roles - ' . $user->name)

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
    .page-hero-content {
        position: relative;
        z-index: 1;
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
    }
    .current-roles {
        display: flex;
        gap: 8px;
        margin-top: 12px;
        flex-wrap: wrap;
    }
    .current-role-badge {
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
    .page-hero-actions {
        position: relative;
        z-index: 1;
        display: flex;
        gap: 12px;
    }
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

    /* Info Alert */
    .info-alert {
        background: linear-gradient(135deg, rgba(26, 125, 107, 0.08), rgba(26, 125, 107, 0.03));
        border: 1px solid rgba(26, 125, 107, 0.15);
        border-radius: 12px;
        padding: 18px 22px;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 15px;
    }
    .info-alert-icon {
        width: 45px;
        height: 45px;
        background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .info-alert-icon i { color: #fff; font-size: 1.1rem; }
    .info-alert-content p { margin: 0; color: #666; font-size: 0.95rem; }
    .info-alert-content strong { color: var(--secondary-color); }

    /* Warning Alert */
    .warning-alert {
        background: linear-gradient(135deg, rgba(232, 184, 94, 0.15), rgba(232, 184, 94, 0.05));
        border: 1px solid rgba(232, 184, 94, 0.3);
        border-radius: 12px;
        padding: 18px 22px;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 15px;
    }
    .warning-alert-icon {
        width: 45px;
        height: 45px;
        background: linear-gradient(135deg, var(--accent-color), var(--accent-light));
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .warning-alert-icon i { color: #fff; font-size: 1.1rem; }
    .warning-alert-content p { margin: 0; color: #666; font-size: 0.95rem; }

    /* Roles Grid */
    .roles-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 20px;
    }

    /* Role Option Card */
    .role-option {
        background: linear-gradient(145deg, #fafafa, #fff);
        border: 2px solid #e9ecef;
        border-radius: 16px;
        padding: 0;
        cursor: pointer;
        transition: all 0.3s ease;
        overflow: hidden;
        position: relative;
    }
    .role-option:hover {
        border-color: var(--primary-color);
        box-shadow: 0 10px 30px rgba(26, 125, 107, 0.1);
        transform: translateY(-3px);
    }
    .role-option.selected {
        border-color: var(--primary-color);
        background: linear-gradient(145deg, rgba(26, 125, 107, 0.05), #fff);
    }
    .role-option.selected::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 5px;
        height: 100%;
        background: linear-gradient(180deg, var(--primary-color), var(--accent-color));
    }
    .role-option.disabled {
        opacity: 0.5;
        cursor: not-allowed;
        pointer-events: none;
    }
    .role-option-header {
        padding: 20px;
        display: flex;
        align-items: flex-start;
        gap: 15px;
    }
    .role-checkbox {
        width: 24px;
        height: 24px;
        border: 2px solid #ddd;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        transition: all 0.3s ease;
        margin-top: 3px;
    }
    .role-option.selected .role-checkbox {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
        border-color: var(--primary-color);
    }
    .role-checkbox i {
        color: #fff;
        font-size: 0.8rem;
        opacity: 0;
        transition: all 0.3s ease;
    }
    .role-option.selected .role-checkbox i { opacity: 1; }
    .role-option input[type="checkbox"] { display: none; }
    .role-option-content { flex: 1; }
    .role-option-title {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 8px;
    }
    .role-option-title h5 {
        margin: 0;
        font-weight: 700;
        font-size: 1.1rem;
        color: var(--secondary-color);
    }
    .system-badge {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
        color: #fff;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .role-option-desc {
        color: #666;
        font-size: 0.9rem;
        line-height: 1.5;
        margin-bottom: 15px;
    }
    .role-stats {
        display: flex;
        gap: 20px;
    }
    .role-stat {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.85rem;
        color: #666;
    }
    .role-stat i { color: var(--primary-color); }
    .role-stat-value { font-weight: 600; color: var(--secondary-color); }

    /* Form Actions */
    .form-actions {
        display: flex;
        gap: 15px;
        padding-top: 25px;
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

    /* Quick Actions */
    .quick-actions {
        display: flex;
        gap: 10px;
        margin-bottom: 25px;
        flex-wrap: wrap;
    }
    .quick-action-btn {
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
        background: #f8f9fa;
        color: var(--secondary-color);
    }
    .quick-action-btn:hover {
        background: var(--primary-color);
        color: #fff;
        transform: translateY(-2px);
    }

    @media (max-width: 992px) {
        .page-hero { flex-direction: column; text-align: center; gap: 25px; }
        .page-hero-content { flex-direction: column; text-align: center; }
        .page-hero-actions { justify-content: center; }
        .roles-grid { grid-template-columns: 1fr; }
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
            <a href="{{ route('admin.users.roles.index') }}" class="breadcrumbs__item">
                <i class="fa fa-user-tag"></i> User Roles
            </a>
            <a href="#" class="breadcrumbs__item is-active" style="pointer-events: none;">
                Edit Roles
            </a>
        </nav>

        <div class="col-lg-12">
            <hr>
            
            <!-- Page Hero -->
            <div class="page-hero">
                <div class="page-hero-content">
                    <div class="user-avatar-large">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div class="user-details">
                        <h1>{{ $user->name }}</h1>
                        <span class="user-email">
                            <i class="fa fa-envelope"></i> {{ $user->email }}
                        </span>
                        @if($user->roles->count() > 0)
                            <div class="current-roles">
                                @foreach($user->roles as $role)
                                    <span class="current-role-badge">
                                        <i class="fa fa-shield"></i> {{ $role->name }}
                                    </span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
                <div class="page-hero-actions">
                    <a href="{{ route('admin.users.roles.permissions', $user) }}" class="hero-btn secondary">
                        <i class="fa fa-key"></i> View Permissions
                    </a>
                    <a href="{{ route('admin.users.roles.index') }}" class="hero-btn secondary">
                        <i class="fa fa-arrow-left"></i> Back
                    </a>
                </div>
            </div>

            <form action="{{ route('admin.users.roles.update', $user) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Roles Card -->
                <div class="form-card">
                    <div class="form-card-header">
                        <div class="header-icon">
                            <i class="fa fa-user-tag"></i>
                        </div>
                        <div>
                            <h3>Assign Roles</h3>
                            <p>Select the roles you want to assign to this user</p>
                        </div>
                    </div>
                    <div class="form-card-body">
                        <!-- Info Alert -->
                        <div class="info-alert">
                            <div class="info-alert-icon">
                                <i class="fa fa-info-circle"></i>
                            </div>
                            <div class="info-alert-content">
                                <p><strong>Note:</strong> Users can have multiple roles. Each role grants specific permissions that are combined when the user accesses the system.</p>
                            </div>
                        </div>

                        @if(!auth()->user()->isSuperAdmin())
                            <div class="warning-alert">
                                <div class="warning-alert-icon">
                                    <i class="fa fa-exclamation-triangle"></i>
                                </div>
                                <div class="warning-alert-content">
                                    <p><strong>Restricted:</strong> The Super Admin role is not available for assignment. Only Super Admins can assign this role.</p>
                                </div>
                            </div>
                        @endif

                        <!-- Quick Actions -->
                        <div class="quick-actions">
                            <button type="button" class="quick-action-btn" onclick="selectAllRoles()">
                                <i class="fa fa-check-double"></i> Select All
                            </button>
                            <button type="button" class="quick-action-btn" onclick="deselectAllRoles()">
                                <i class="fa fa-times"></i> Deselect All
                            </button>
                        </div>

                        <!-- Roles Grid -->
                        <div class="roles-grid">
                            @foreach($roles as $role)
                                @php
                                    $isSelected = in_array($role->id, $userRoleIds);
                                @endphp
                                <div class="role-option {{ $isSelected ? 'selected' : '' }}">
                                    <div class="role-option-header">
                                        <div class="role-checkbox">
                                            <i class="fa fa-check"></i>
                                        </div>
                                        <input type="checkbox" name="roles[]" value="{{ $role->id }}" 
                                               id="role_{{ $role->id }}"
                                               class="role-checkbox-input"
                                               {{ $isSelected ? 'checked' : '' }}>
                                        <div class="role-option-content">
                                            <div class="role-option-title">
                                                <h5>{{ $role->name }}</h5>
                                                @if($role->is_system)
                                                    <span class="system-badge">System</span>
                                                @endif
                                            </div>
                                            <p class="role-option-desc">
                                                {{ $role->description ?? 'No description provided for this role' }}
                                            </p>
                                            <div class="role-stats">
                                                <span class="role-stat">
                                                    <i class="fa fa-key"></i>
                                                    <span class="role-stat-value">{{ $role->permissions()->count() }}</span> permissions
                                                </span>
                                                <span class="role-stat">
                                                    <i class="fa fa-users"></i>
                                                    <span class="role-stat-value">{{ $role->users()->count() }}</span> users
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Form Actions -->
                        <div class="form-actions">
                            <button type="submit" class="submit-btn primary">
                                <i class="fa fa-save"></i> Save Roles
                            </button>
                            <a href="{{ route('admin.users.roles.index') }}" class="submit-btn secondary">
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
document.addEventListener('DOMContentLoaded', function() {
    // Handle role option clicks
    document.querySelectorAll('.role-option').forEach(option => {
        option.addEventListener('click', function(e) {
            // Don't toggle if clicking directly on checkbox
            if (e.target.type === 'checkbox') {
                this.classList.toggle('selected', e.target.checked);
                return;
            }
            
            // Toggle checkbox
            const checkbox = this.querySelector('input[type="checkbox"]');
            checkbox.checked = !checkbox.checked;
            this.classList.toggle('selected', checkbox.checked);
        });
    });

    // Initialize selected state
    document.querySelectorAll('.role-checkbox-input').forEach(checkbox => {
        if (checkbox.checked) {
            checkbox.closest('.role-option').classList.add('selected');
        }
    });
});

function selectAllRoles() {
    document.querySelectorAll('.role-option').forEach(option => {
        const checkbox = option.querySelector('input[type="checkbox"]');
        checkbox.checked = true;
        option.classList.add('selected');
    });
}

function deselectAllRoles() {
    document.querySelectorAll('.role-option').forEach(option => {
        const checkbox = option.querySelector('input[type="checkbox"]');
        checkbox.checked = false;
        option.classList.remove('selected');
    });
}
</script>
@endsection
