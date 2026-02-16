@extends('admin::layouts.master')
@section('title', 'Home Projects Section Settings')

@section('css')
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
        padding: 20px;
    }
    .category-item {
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 10px;
        transition: all 0.3s ease;
        cursor: grab;
    }
    .category-item:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .category-item.dragging {
        opacity: 0.5;
        cursor: grabbing;
    }
    .category-item.disabled {
        opacity: 0.6;
        background: #e9ecef;
    }
    .category-item.manual-selection {
        border-left: 4px solid #007bff;
    }
    .category-info {
        display: flex;
        align-items: center;
        gap: 15px;
        flex-wrap: wrap;
    }
    .drag-handle {
        color: #adb5bd;
        cursor: grab;
        font-size: 18px;
    }
    .drag-handle:hover {
        color: #19868b;
    }
    .category-name {
        flex: 1;
        font-weight: 600;
        color: #2c3e50;
        font-size: 15px;
        min-width: 150px;
    }
    .category-stats {
        display: flex;
        align-items: center;
        gap: 15px;
        flex-wrap: wrap;
    }
    .stat-item {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 13px;
        color: #6c757d;
    }
    .stat-item i {
        color: #19868b;
    }
    .max-projects-input {
        width: 70px;
        text-align: center;
        border: 1px solid #dee2e6;
        border-radius: 5px;
        padding: 5px 10px;
        font-size: 14px;
        font-weight: 600;
    }
    .max-projects-input:focus {
        border-color: #19868b;
        outline: none;
        box-shadow: 0 0 0 2px rgba(25, 134, 139, 0.2);
    }
    .toggle-switch {
        position: relative;
        width: 50px;
        height: 26px;
    }
    .toggle-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }
    .toggle-slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: 0.3s;
        border-radius: 26px;
    }
    .toggle-slider:before {
        position: absolute;
        content: "";
        height: 20px;
        width: 20px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: 0.3s;
        border-radius: 50%;
    }
    .toggle-switch input:checked + .toggle-slider {
        background-color: #28a745;
    }
    .toggle-switch input:checked + .toggle-slider:before {
        transform: translateX(24px);
    }
    .action-buttons {
        display: flex;
        gap: 10px;
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid #e9ecef;
    }
    .btn-save {
        background: linear-gradient(135deg, #19868b 0%, #0d6b6f 100%);
        color: white;
        border: none;
        padding: 10px 25px;
        border-radius: 6px;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(25, 134, 139, 0.3);
        color: white;
    }
    .btn-reset {
        background: #6c757d;
        color: white;
        border: none;
        padding: 10px 25px;
        border-radius: 6px;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    .btn-reset:hover {
        background: #5a6268;
        color: white;
    }
    .btn-select-projects {
        background: #007bff;
        color: white;
        border: none;
        padding: 5px 12px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 500;
        transition: all 0.3s ease;
        white-space: nowrap;
    }
    .btn-select-projects:hover {
        background: #0056b3;
        color: white;
    }
    .btn-select-projects.has-selection {
        background: #28a745;
    }
    .btn-select-projects.has-selection:hover {
        background: #218838;
    }
    .info-box {
        background: #e7f5f5;
        border: 1px solid #19868b;
        border-radius: 8px;
        padding: 15px;
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
    .order-badge {
        background: #19868b;
        color: white;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 600;
    }
    .status-badge {
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }
    .status-badge.active {
        background: #d4edda;
        color: #155724;
    }
    .status-badge.inactive {
        background: #f8d7da;
        color: #721c24;
    }
    .selection-mode-badge {
        padding: 3px 8px;
        border-radius: 4px;
        font-size: 10px;
        font-weight: 600;
        text-transform: uppercase;
    }
    .selection-mode-badge.auto {
        background: #e2e3e5;
        color: #383d41;
    }
    .selection-mode-badge.manual {
        background: #cce5ff;
        color: #004085;
    }
</style>
@endsection

@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Admin')}}" class="breadcrumbs__item"><i class="fa fa-home"></i> Dashboard</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-cog"></i> Home Projects Section Settings</a>
        </nav>

        <div class="col-lg-12">
            <hr>
            
            <!-- Success/Error Messages -->
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
                    <h4><i class="fa fa-building"></i> Our Projects Section Settings</h4>
                    <p>Control which categories appear in the "Our Projects" section on the home page and how many projects to show per category.</p>
                </div>
                
                <div class="settings-body">
                    <div class="info-box">
                        <i class="fa fa-info-circle"></i>
                        <p><strong>Instructions:</strong> Drag categories to reorder them. Set the maximum number of projects to display per category (max 9 recommended). Toggle the switch to enable/disable a category from appearing on the home page. Click "Select Projects" to manually choose which projects appear, or leave on "Auto" to show the latest projects.</p>
                    </div>
                    
                    <form action="{{ route('home-project-settings.bulk-update') }}" method="POST" id="settingsForm">
                        @csrf
                        
                        <div id="categoriesList">
                            @foreach($settings as $index => $setting)
                            @php
                                $hasManualSelection = $setting->selectedProjects->count() > 0;
                            @endphp
                            <div class="category-item {{ !$setting->is_active ? 'disabled' : '' }} {{ $hasManualSelection ? 'manual-selection' : '' }}" data-id="{{ $setting->id }}">
                                <div class="category-info">
                                    <div class="drag-handle">
                                        <i class="fa fa-bars"></i>
                                    </div>
                                    
                                    <div class="order-badge">{{ $index + 1 }}</div>
                                    
                                    <div class="category-name">
                                        {{ $setting->category->title_english ?? 'Unknown Category' }}
                                        <input type="hidden" name="settings[{{ $index }}][id]" value="{{ $setting->id }}">
                                        <input type="hidden" name="settings[{{ $index }}][ordering]" value="{{ $index + 1 }}" class="ordering-input">
                                        <br>
                                        <span class="selection-mode-badge {{ $hasManualSelection ? 'manual' : 'auto' }}">
                                            {{ $hasManualSelection ? 'Manual (' . $setting->selectedProjects->count() . ' selected)' : 'Auto (Latest)' }}
                                        </span>
                                    </div>
                                    
                                    <div class="category-stats">
                                        <div class="stat-item">
                                            <i class="fa fa-folder"></i>
                                            <span>{{ $setting->category->projects_count ?? 0 }} Projects</span>
                                        </div>
                                        
                                        <div class="stat-item">
                                            <a href="{{ route('home-project-settings.select-projects', $setting->id) }}" 
                                               class="btn btn-select-projects {{ $hasManualSelection ? 'has-selection' : '' }}">
                                                <i class="fa fa-list"></i> Select Projects
                                            </a>
                                        </div>
                                        
                                        <div class="stat-item">
                                            <label style="margin: 0; font-weight: 500;">Max:</label>
                                            <input type="number" 
                                                   name="settings[{{ $index }}][max_projects]" 
                                                   value="{{ $setting->max_projects }}" 
                                                   min="1" 
                                                   max="50" 
                                                   class="max-projects-input">
                                        </div>
                                        
                                        <div class="stat-item">
                                            <span class="status-badge {{ $setting->is_active ? 'active' : 'inactive' }}">
                                                {{ $setting->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </div>
                                        
                                        <label class="toggle-switch">
                                            <input type="checkbox" 
                                                   name="settings[{{ $index }}][is_active]" 
                                                   value="1" 
                                                   {{ $setting->is_active ? 'checked' : '' }}
                                                   class="status-toggle"
                                                   data-id="{{ $setting->id }}">
                                            <span class="toggle-slider"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        
                        <div class="action-buttons">
                            <button type="submit" class="btn btn-save">
                                <i class="fa fa-save"></i> Save All Changes
                            </button>
                            <a href="{{ route('home-project-settings.reset') }}" class="btn btn-reset" onclick="return confirm('Are you sure you want to reset all settings to default?')">
                                <i class="fa fa-refresh"></i> Reset to Default
                            </a>
                            <button type="button" class="btn btn-primary" onclick="window.history.back()">
                                <i class="fa fa-angle-left"></i> Back
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
    // Initialize Sortable for drag and drop
    const categoriesList = document.getElementById('categoriesList');
    
    new Sortable(categoriesList, {
        handle: '.drag-handle',
        animation: 150,
        ghostClass: 'dragging',
        onEnd: function(evt) {
            updateOrderBadges();
            updateOrderingInputs();
        }
    });
    
    // Update order badges after drag
    function updateOrderBadges() {
        const items = categoriesList.querySelectorAll('.category-item');
        items.forEach((item, index) => {
            const badge = item.querySelector('.order-badge');
            if (badge) {
                badge.textContent = index + 1;
            }
        });
    }
    
    // Update hidden ordering inputs
    function updateOrderingInputs() {
        const items = categoriesList.querySelectorAll('.category-item');
        items.forEach((item, index) => {
            const orderingInput = item.querySelector('.ordering-input');
            if (orderingInput) {
                orderingInput.value = index + 1;
            }
            
            // Update array index in name attributes
            const inputs = item.querySelectorAll('input[name^="settings["]');
            inputs.forEach(input => {
                const name = input.getAttribute('name');
                const newName = name.replace(/settings\[\d+\]/, `settings[${index}]`);
                input.setAttribute('name', newName);
            });
        });
    }
    
    // Toggle status visual update
    document.querySelectorAll('.status-toggle').forEach(toggle => {
        toggle.addEventListener('change', function() {
            const item = this.closest('.category-item');
            const badge = item.querySelector('.status-badge');
            
            if (this.checked) {
                item.classList.remove('disabled');
                badge.classList.remove('inactive');
                badge.classList.add('active');
                badge.textContent = 'Active';
            } else {
                item.classList.add('disabled');
                badge.classList.remove('active');
                badge.classList.add('inactive');
                badge.textContent = 'Inactive';
            }
        });
    });
</script>
@endsection
