<?php $__env->startSection('title', 'Roles Management'); ?>

<?php $__env->startSection('css'); ?>
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
    .hero-btn.primary {
        background: rgba(255,255,255,0.95);
        color: var(--primary-color);
    }
    .hero-btn.primary:hover { background: #fff; color: var(--primary-dark); }
    .hero-btn.secondary {
        background: rgba(255,255,255,0.15);
        border: 1px solid rgba(255,255,255,0.3);
        color: #fff;
    }
    .hero-btn.secondary:hover { background: rgba(255,255,255,0.25); color: #fff; }
    .hero-btn.danger {
        background: rgba(225, 39, 61, 0.2);
        border: 1px solid rgba(225, 39, 61, 0.4);
        color: #fff;
    }
    .hero-btn.danger:hover { background: rgba(225, 39, 61, 0.3); color: #fff; }

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

    /* Roles Grid */
    .roles-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
        gap: 25px;
    }

    /* Role Card */
    .role-card {
        background: #fff;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: var(--card-shadow);
        transition: all 0.3s ease;
        position: relative;
    }
    .role-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 60px rgba(0,0,0,0.12);
    }
    .role-card.system-role::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 5px;
        height: 100%;
        background: linear-gradient(180deg, var(--primary-color), var(--accent-color));
    }
    .role-card.inactive { opacity: 0.7; }
    .role-card.inactive .role-card-header { background: linear-gradient(135deg, #6c757d, #495057); }
    
    .role-card-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 50%, var(--secondary-color) 100%);
        padding: 25px;
        position: relative;
    }
    .role-card-header::after {
        content: '\f132';
        font-family: 'FontAwesome';
        position: absolute;
        right: 20px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 4rem;
        opacity: 0.1;
        color: #fff;
    }
    .role-title-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        position: relative;
        z-index: 1;
    }
    .role-icon {
        width: 50px;
        height: 50px;
        background: rgba(255,255,255,0.2);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 15px;
    }
    .role-icon i { color: #fff; font-size: 1.2rem; }
    .role-name {
        color: #fff;
        font-size: 1.4rem;
        font-weight: 700;
        margin: 0 0 8px 0;
    }
    .role-slug {
        color: rgba(255,255,255,0.6);
        font-size: 0.85rem;
        font-family: monospace;
    }
    .role-badges {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }
    .role-badge {
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .role-badge.system {
        background: rgba(232, 184, 94, 0.3);
        color: var(--accent-light);
        border: 1px solid rgba(232, 184, 94, 0.5);
    }
    .role-badge.active {
        background: rgba(34, 168, 143, 0.3);
        color: #7dffda;
        border: 1px solid rgba(34, 168, 143, 0.5);
    }
    .role-badge.inactive {
        background: rgba(255,255,255,0.15);
        color: rgba(255,255,255,0.7);
        border: 1px solid rgba(255,255,255,0.2);
    }

    .role-card-body { padding: 25px; }
    .role-description {
        color: #666;
        font-size: 0.95rem;
        line-height: 1.6;
        margin-bottom: 20px;
        min-height: 48px;
    }
    .role-stats {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
        margin-bottom: 20px;
    }
    .role-stat {
        background: linear-gradient(135deg, #f8f9fa, #fff);
        border: 1px solid #e9ecef;
        border-radius: 12px;
        padding: 15px;
        display: flex;
        align-items: center;
        gap: 12px;
        transition: all 0.3s ease;
    }
    .role-stat:hover {
        border-color: var(--primary-color);
        transform: translateY(-2px);
    }
    .role-stat-icon {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
    }
    .role-stat-icon.users {
        background: rgba(26, 125, 107, 0.1);
        color: var(--primary-color);
    }
    .role-stat-icon.permissions {
        background: rgba(232, 184, 94, 0.15);
        color: var(--accent-color);
    }
    .role-stat-info { flex: 1; }
    .role-stat-value {
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--secondary-color);
        line-height: 1;
    }
    .role-stat-label {
        font-size: 0.8rem;
        color: #666;
        margin-top: 4px;
    }

    .role-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        padding-top: 20px;
        border-top: 1px solid #f0f0f0;
    }
    .action-btn {
        padding: 10px 16px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.85rem;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        text-decoration: none;
    }
    .action-btn:hover { transform: translateY(-2px); }
    .action-btn.view {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
        color: #fff;
    }
    .action-btn.edit {
        background: linear-gradient(135deg, var(--accent-color), var(--accent-light));
        color: #fff;
    }
    .action-btn.toggle {
        background: #e9ecef;
        color: var(--secondary-color);
    }
    .action-btn.toggle.activate {
        background: linear-gradient(135deg, #28a745, #20c997);
        color: #fff;
    }
    .action-btn.delete {
        background: linear-gradient(135deg, var(--danger-color), #c82333);
        color: #fff;
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
    .empty-state .hero-btn { display: inline-flex; }

    @media (max-width: 992px) {
        .page-hero { flex-direction: column; text-align: center; gap: 25px; }
        .page-hero-stats { justify-content: center; }
        .page-hero-actions { justify-content: center; }
        .roles-grid { grid-template-columns: 1fr; }
        .filter-bar { flex-direction: column; align-items: stretch; }
        .filter-tabs { justify-content: center; }
        .search-box { min-width: 100%; }
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="page-content-wrapper">
    <div class="container-fluid">
        <nav class="breadcrumbs">
            <a href="<?php echo e(route('Admin')); ?>" class="breadcrumbs__item">
                <i class="fa fa-home"></i> Dashboard
            </a>
            <a href="#" class="breadcrumbs__item is-active" style="pointer-events: none;">
                <i class="fa fa-shield"></i> Roles Management
            </a>
        </nav>

        <div class="col-lg-12">
            <hr>
            
            <!-- Page Hero -->
            <div class="page-hero">
                <div class="page-hero-content">
                    <div class="page-hero-icon">
                        <i class="fa fa-shield"></i>
                    </div>
                    <h1>Roles Management</h1>
                    <p>Manage user roles and their permissions across the system</p>
                    <div class="page-hero-stats">
                        <div class="hero-stat">
                            <i class="fa fa-shield"></i>
                            <span class="stat-value"><?php echo e($roles->count()); ?></span>
                            <span class="stat-label">Total Roles</span>
                        </div>
                        <div class="hero-stat">
                            <i class="fa fa-users"></i>
                            <span class="stat-value"><?php echo e($roles->sum('users_count')); ?></span>
                            <span class="stat-label">Assigned Users</span>
                        </div>
                        <div class="hero-stat">
                            <i class="fa fa-lock"></i>
                            <span class="stat-value"><?php echo e($roles->where('is_system', true)->count()); ?></span>
                            <span class="stat-label">System Roles</span>
                        </div>
                    </div>
                </div>
                <div class="page-hero-actions">
                    <?php if(auth()->user()->hasPermission('roles-create')): ?>
                        <a href="<?php echo e(route('admin.roles.create')); ?>" class="hero-btn primary">
                            <i class="fa fa-plus"></i> Add New Role
                        </a>
                    <?php endif; ?>
                    <?php if($trashedCount > 0): ?>
                        <a href="<?php echo e(route('admin.roles.trashed')); ?>" class="hero-btn danger">
                            <i class="fa fa-trash"></i> Trashed (<?php echo e($trashedCount); ?>)
                        </a>
                    <?php endif; ?>
                    <a href="<?php echo e(route('Admin')); ?>" class="hero-btn secondary">
                        <i class="fa fa-arrow-left"></i> Back
                    </a>
                </div>
            </div>

            <!-- Filter Bar -->
            <div class="filter-bar">
                <div class="filter-tabs">
                    <button class="filter-tab active" data-filter="all">
                        All Roles <span class="count"><?php echo e($roles->count()); ?></span>
                    </button>
                    <button class="filter-tab" data-filter="system">
                        System <span class="count"><?php echo e($roles->where('is_system', true)->count()); ?></span>
                    </button>
                    <button class="filter-tab" data-filter="custom">
                        Custom <span class="count"><?php echo e($roles->where('is_system', false)->count()); ?></span>
                    </button>
                    <button class="filter-tab" data-filter="active">
                        Active <span class="count"><?php echo e($roles->where('is_active', true)->count()); ?></span>
                    </button>
                    <button class="filter-tab" data-filter="inactive">
                        Inactive <span class="count"><?php echo e($roles->where('is_active', false)->count()); ?></span>
                    </button>
                </div>
                <div class="search-box">
                    <i class="fa fa-search"></i>
                    <input type="text" id="roleSearch" placeholder="Search roles...">
                </div>
            </div>

            <!-- Roles Grid -->
            <?php if($roles->count() > 0): ?>
                <div class="roles-grid" id="rolesContainer">
                    <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="role-card <?php echo e($role->is_system ? 'system-role' : ''); ?> <?php echo e(!$role->is_active ? 'inactive' : ''); ?>"
                             data-name="<?php echo e(strtolower($role->name)); ?>"
                             data-system="<?php echo e($role->is_system ? 'true' : 'false'); ?>"
                             data-active="<?php echo e($role->is_active ? 'true' : 'false'); ?>">
                            <div class="role-card-header">
                                <div class="role-title-row">
                                    <div>
                                        <div class="role-icon">
                                            <i class="fa fa-<?php echo e($role->is_system ? 'lock' : 'shield'); ?>"></i>
                                        </div>
                                        <h3 class="role-name"><?php echo e($role->name); ?></h3>
                                        <span class="role-slug"><?php echo e($role->slug); ?></span>
                                    </div>
                                    <div class="role-badges">
                                        <?php if($role->is_system): ?>
                                            <span class="role-badge system">System</span>
                                        <?php endif; ?>
                                        <?php if($role->is_active): ?>
                                            <span class="role-badge active">Active</span>
                                        <?php else: ?>
                                            <span class="role-badge inactive">Inactive</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="role-card-body">
                                <p class="role-description">
                                    <?php echo e($role->description ?? 'No description provided for this role'); ?>

                                </p>
                                
                                <div class="role-stats">
                                    <div class="role-stat">
                                        <div class="role-stat-icon users">
                                            <i class="fa fa-users"></i>
                                        </div>
                                        <div class="role-stat-info">
                                            <div class="role-stat-value"><?php echo e($role->users_count); ?></div>
                                            <div class="role-stat-label">Users</div>
                                        </div>
                                    </div>
                                    <div class="role-stat">
                                        <div class="role-stat-icon permissions">
                                            <i class="fa fa-key"></i>
                                        </div>
                                        <div class="role-stat-info">
                                            <div class="role-stat-value"><?php echo e($role->permissions_count); ?></div>
                                            <div class="role-stat-label">Permissions</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="role-actions">
                                    <a href="<?php echo e(route('admin.roles.show', $role)); ?>" class="action-btn view">
                                        <i class="fa fa-eye"></i> View
                                    </a>
                                    
                                    <?php if(auth()->user()->hasPermission('roles-edit')): ?>
                                        <?php if(!($role->is_system && $role->slug === 'super-admin')): ?>
                                            <a href="<?php echo e(route('admin.roles.edit', $role)); ?>" class="action-btn edit">
                                                <i class="fa fa-edit"></i> Edit
                                            </a>
                                            
                                            <form action="<?php echo e(route('admin.roles.toggle-active', $role)); ?>" method="POST" style="display: inline;">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PATCH'); ?>
                                                <button type="submit" class="action-btn toggle <?php echo e(!$role->is_active ? 'activate' : ''); ?>">
                                                    <i class="fa fa-<?php echo e($role->is_active ? 'ban' : 'check'); ?>"></i>
                                                    <?php echo e($role->is_active ? 'Deactivate' : 'Activate'); ?>

                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    
                                    <?php if(auth()->user()->hasPermission('roles-delete')): ?>
                                        <?php if(!$role->is_system && $role->users_count == 0): ?>
                                            <form action="<?php echo e(route('admin.roles.destroy', $role)); ?>" method="POST" style="display: inline;" 
                                                  onsubmit="return confirm('Are you sure you want to delete this role?');">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="action-btn delete">
                                                    <i class="fa fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="fa fa-shield"></i>
                    </div>
                    <h4>No Roles Found</h4>
                    <p>Get started by creating your first role to manage user permissions.</p>
                    <?php if(auth()->user()->hasPermission('roles-create')): ?>
                        <a href="<?php echo e(route('admin.roles.create')); ?>" class="hero-btn primary">
                            <i class="fa fa-plus"></i> Create First Role
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('roleSearch');
    const filterTabs = document.querySelectorAll('.filter-tab');
    const rolesContainer = document.getElementById('rolesContainer');
    
    if (!rolesContainer) return;
    
    const roleCards = rolesContainer.querySelectorAll('.role-card');
    let currentFilter = 'all';

    // Search functionality
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            filterRoles();
        });
    }

    // Filter tabs
    filterTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            filterTabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            currentFilter = this.dataset.filter;
            filterRoles();
        });
    });

    function filterRoles() {
        const searchTerm = searchInput ? searchInput.value.toLowerCase() : '';
        
        roleCards.forEach(card => {
            const name = card.dataset.name;
            const isSystem = card.dataset.system === 'true';
            const isActive = card.dataset.active === 'true';
            
            let matchesFilter = true;
            let matchesSearch = name.includes(searchTerm);
            
            switch(currentFilter) {
                case 'system':
                    matchesFilter = isSystem;
                    break;
                case 'custom':
                    matchesFilter = !isSystem;
                    break;
                case 'active':
                    matchesFilter = isActive;
                    break;
                case 'inactive':
                    matchesFilter = !isActive;
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\smartvisionuae\Modules/Admin\resources/views/roles/index.blade.php ENDPATH**/ ?>