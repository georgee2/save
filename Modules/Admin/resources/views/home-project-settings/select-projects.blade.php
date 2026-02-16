@extends('admin::layouts.master')
@section('title', 'Select Projects - ' . ($setting->category->title_english ?? 'Category'))

@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<style>
    .page-header {
        background: linear-gradient(135deg, #19868b 0%, #0d6b6f 100%);
        color: white;
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 20px;
    }
    .page-header h4 {
        margin: 0;
        font-weight: 600;
    }
    .page-header p {
        margin: 5px 0 0;
        opacity: 0.9;
        font-size: 14px;
    }
    .selection-container {
        display: flex;
        gap: 20px;
    }
    .projects-panel {
        flex: 1;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        overflow: hidden;
    }
    .panel-header {
        background: #f8f9fa;
        padding: 15px 20px;
        border-bottom: 1px solid #e9ecef;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .panel-header h5 {
        margin: 0;
        font-weight: 600;
        color: #2c3e50;
    }
    .panel-header .count {
        background: #19868b;
        color: white;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }
    .panel-body {
        padding: 15px;
        max-height: 600px;
        overflow-y: auto;
    }
    .project-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px;
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        margin-bottom: 10px;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .project-item:hover {
        background: #e9ecef;
        border-color: #19868b;
    }
    .project-item.selected {
        background: #e7f5f5;
        border-color: #19868b;
        border-width: 2px;
    }
    .project-item.in-selected-list {
        opacity: 0.5;
        pointer-events: none;
    }
    .project-thumb {
        width: 60px;
        height: 60px;
        border-radius: 6px;
        object-fit: cover;
        flex-shrink: 0;
    }
    .project-thumb-placeholder {
        width: 60px;
        height: 60px;
        border-radius: 6px;
        background: #e9ecef;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #adb5bd;
        font-size: 20px;
        flex-shrink: 0;
    }
    .project-info {
        flex: 1;
        min-width: 0;
    }
    .project-title {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 3px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .project-code {
        font-size: 12px;
        color: #6c757d;
    }
    .project-subcategory {
        font-size: 11px;
        color: #19868b;
        background: #e7f5f5;
        padding: 2px 8px;
        border-radius: 4px;
        display: inline-block;
        margin-top: 3px;
    }
    .selected-panel .panel-header {
        background: #19868b;
        color: white;
    }
    .selected-panel .panel-header h5 {
        color: white;
    }
    .selected-panel .panel-header .count {
        background: white;
        color: #19868b;
    }
    .selected-list {
        min-height: 200px;
    }
    .selected-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px;
        background: #fff;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        margin-bottom: 10px;
        cursor: grab;
    }
    .selected-item:hover {
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    .selected-item.dragging {
        opacity: 0.5;
        cursor: grabbing;
    }
    .drag-handle-selected {
        color: #adb5bd;
        cursor: grab;
        font-size: 16px;
    }
    .drag-handle-selected:hover {
        color: #19868b;
    }
    .remove-btn {
        background: #dc3545;
        color: white;
        border: none;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s ease;
        flex-shrink: 0;
    }
    .remove-btn:hover {
        background: #c82333;
        transform: scale(1.1);
    }
    .order-number {
        background: #19868b;
        color: white;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        font-weight: 600;
        flex-shrink: 0;
    }
    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #6c757d;
    }
    .empty-state i {
        font-size: 48px;
        margin-bottom: 15px;
        opacity: 0.5;
    }
    .empty-state p {
        margin: 0;
        font-size: 14px;
    }
    .action-bar {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        padding: 15px 20px;
        margin-top: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .btn-save-selection {
        background: linear-gradient(135deg, #19868b 0%, #0d6b6f 100%);
        color: white;
        border: none;
        padding: 10px 25px;
        border-radius: 6px;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    .btn-save-selection:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(25, 134, 139, 0.3);
        color: white;
    }
    .btn-clear-selection {
        background: #dc3545;
        color: white;
        border: none;
        padding: 10px 25px;
        border-radius: 6px;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    .btn-clear-selection:hover {
        background: #c82333;
        color: white;
    }
    .search-box {
        position: relative;
        margin-bottom: 15px;
    }
    .search-box input {
        width: 100%;
        padding: 10px 15px 10px 40px;
        border: 1px solid #e9ecef;
        border-radius: 6px;
        font-size: 14px;
    }
    .search-box input:focus {
        border-color: #19868b;
        outline: none;
        box-shadow: 0 0 0 2px rgba(25, 134, 139, 0.2);
    }
    .search-box i {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #adb5bd;
    }
    .max-warning {
        background: #fff3cd;
        border: 1px solid #ffc107;
        color: #856404;
        padding: 10px 15px;
        border-radius: 6px;
        margin-bottom: 15px;
        font-size: 13px;
    }
    .max-warning i {
        margin-right: 8px;
    }
</style>
@endsection

@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Admin')}}" class="breadcrumbs__item"><i class="fa fa-home"></i> Dashboard</a>
            <a href="{{route('home-project-settings.index')}}" class="breadcrumbs__item"><i class="fa fa-cog"></i> Our Projects Settings</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-list"></i> Select Projects</a>
        </nav>

        <div class="col-lg-12">
            <hr>
            
            <div class="page-header">
                <h4><i class="fa fa-building"></i> Select Projects for: {{ $setting->category->title_english ?? 'Category' }}</h4>
                <p>Choose which projects will appear in this category on the home page. Drag to reorder selected projects. Maximum {{ $setting->max_projects }} projects will be shown.</p>
            </div>
            
            <div class="selection-container">
                <!-- Available Projects Panel -->
                <div class="projects-panel">
                    <div class="panel-header">
                        <h5><i class="fa fa-folder-open"></i> Available Projects</h5>
                        <span class="count" id="availableCount">{{ $availableProjects->count() }}</span>
                    </div>
                    <div class="panel-body">
                        <div class="search-box">
                            <i class="fa fa-search"></i>
                            <input type="text" id="searchProjects" placeholder="Search projects...">
                        </div>
                        
                        <div id="availableProjectsList">
                            @forelse($availableProjects as $project)
                            <div class="project-item {{ in_array($project->id, $selectedProjectIds) ? 'in-selected-list' : '' }}" 
                                 data-id="{{ $project->id }}"
                                 data-title="{{ $project->title_english }}"
                                 data-code="{{ $project->project_code }}"
                                 data-subcategory="{{ $project->subcategory->title_english ?? '' }}"
                                 data-image="{{ $project->main_image ? asset('storage/' . $project->main_image) : '' }}">
                                @if($project->main_image)
                                    <img src="{{ asset('storage/' . $project->main_image) }}" alt="" class="project-thumb">
                                @else
                                    <div class="project-thumb-placeholder">
                                        <i class="fa fa-image"></i>
                                    </div>
                                @endif
                                <div class="project-info">
                                    <div class="project-title">{{ $project->title_english }}</div>
                                    <div class="project-code">{{ $project->project_code }}</div>
                                    @if($project->subcategory)
                                        <span class="project-subcategory">{{ $project->subcategory->title_english }}</span>
                                    @endif
                                </div>
                            </div>
                            @empty
                            <div class="empty-state">
                                <i class="fa fa-folder-open"></i>
                                <p>No projects available in this category</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
                
                <!-- Selected Projects Panel -->
                <div class="projects-panel selected-panel">
                    <div class="panel-header">
                        <h5><i class="fa fa-check-circle"></i> Selected Projects</h5>
                        <span class="count" id="selectedCount">{{ count($selectedProjectIds) }}</span>
                    </div>
                    <div class="panel-body">
                        <div class="max-warning" id="maxWarning" style="{{ count($selectedProjectIds) >= $setting->max_projects ? '' : 'display: none;' }}">
                            <i class="fa fa-exclamation-triangle"></i>
                            Maximum {{ $setting->max_projects }} projects reached. Only the first {{ $setting->max_projects }} will be shown on the home page.
                        </div>
                        
                        <div id="selectedProjectsList" class="selected-list">
                            @forelse($setting->selectedProjects as $index => $item)
                                @if($item->project)
                                <div class="selected-item" data-id="{{ $item->project->id }}">
                                    <div class="drag-handle-selected">
                                        <i class="fa fa-bars"></i>
                                    </div>
                                    <span class="order-number">{{ $index + 1 }}</span>
                                    @if($item->project->main_image)
                                        <img src="{{ asset('storage/' . $item->project->main_image) }}" alt="" class="project-thumb">
                                    @else
                                        <div class="project-thumb-placeholder">
                                            <i class="fa fa-image"></i>
                                        </div>
                                    @endif
                                    <div class="project-info">
                                        <div class="project-title">{{ $item->project->title_english }}</div>
                                        <div class="project-code">{{ $item->project->project_code }}</div>
                                    </div>
                                    <button type="button" class="remove-btn" onclick="removeProject({{ $item->project->id }})">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </div>
                                @endif
                            @empty
                            <div class="empty-state" id="emptySelectedState">
                                <i class="fa fa-hand-pointer-o"></i>
                                <p>Click on projects from the left panel to add them here.<br>
                                <small>Leave empty to use automatic mode (latest projects)</small></p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="action-bar">
                <div>
                    <a href="{{ route('home-project-settings.index') }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left"></i> Back to Settings
                    </a>
                    <button type="button" class="btn btn-clear-selection" onclick="clearAllProjects()" id="clearBtn" style="{{ count($selectedProjectIds) > 0 ? '' : 'display: none;' }}">
                        <i class="fa fa-trash"></i> Clear All (Use Auto Mode)
                    </button>
                </div>
                <button type="button" class="btn btn-save-selection" onclick="saveSelection()">
                    <i class="fa fa-save"></i> Save Selection
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
    const settingId = {{ $setting->id }};
    const maxProjects = {{ $setting->max_projects }};
    let selectedProjects = @json($selectedProjectIds);
    
    // Initialize Sortable for selected projects
    const selectedList = document.getElementById('selectedProjectsList');
    new Sortable(selectedList, {
        handle: '.drag-handle-selected',
        animation: 150,
        ghostClass: 'dragging',
        onEnd: function(evt) {
            updateOrderNumbers();
        }
    });
    
    // Search functionality
    document.getElementById('searchProjects').addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const items = document.querySelectorAll('#availableProjectsList .project-item');
        
        items.forEach(item => {
            const title = item.dataset.title.toLowerCase();
            const code = item.dataset.code.toLowerCase();
            const subcategory = item.dataset.subcategory.toLowerCase();
            
            if (title.includes(searchTerm) || code.includes(searchTerm) || subcategory.includes(searchTerm)) {
                item.style.display = 'flex';
            } else {
                item.style.display = 'none';
            }
        });
    });
    
    // Click to add project
    document.querySelectorAll('#availableProjectsList .project-item').forEach(item => {
        item.addEventListener('click', function() {
            if (this.classList.contains('in-selected-list')) return;
            
            const projectId = parseInt(this.dataset.id);
            addProject(projectId, this.dataset.title, this.dataset.code, this.dataset.image);
        });
    });
    
    function addProject(id, title, code, image) {
        // Add to selected array
        if (!selectedProjects.includes(id)) {
            selectedProjects.push(id);
        }
        
        // Hide empty state
        const emptyState = document.getElementById('emptySelectedState');
        if (emptyState) {
            emptyState.style.display = 'none';
        }
        
        // Mark as selected in available list
        const availableItem = document.querySelector(`#availableProjectsList .project-item[data-id="${id}"]`);
        if (availableItem) {
            availableItem.classList.add('in-selected-list');
        }
        
        // Create selected item HTML
        const orderNum = selectedProjects.length;
        const imageHtml = image 
            ? `<img src="${image}" alt="" class="project-thumb">`
            : `<div class="project-thumb-placeholder"><i class="fa fa-image"></i></div>`;
        
        const itemHtml = `
            <div class="selected-item" data-id="${id}">
                <div class="drag-handle-selected">
                    <i class="fa fa-bars"></i>
                </div>
                <span class="order-number">${orderNum}</span>
                ${imageHtml}
                <div class="project-info">
                    <div class="project-title">${title}</div>
                    <div class="project-code">${code}</div>
                </div>
                <button type="button" class="remove-btn" onclick="removeProject(${id})">
                    <i class="fa fa-times"></i>
                </button>
            </div>
        `;
        
        selectedList.insertAdjacentHTML('beforeend', itemHtml);
        
        updateCounts();
        updateMaxWarning();
        updateClearButton();
    }
    
    function removeProject(id) {
        // Remove from array
        selectedProjects = selectedProjects.filter(p => p !== id);
        
        // Remove from selected list
        const selectedItem = document.querySelector(`#selectedProjectsList .selected-item[data-id="${id}"]`);
        if (selectedItem) {
            selectedItem.remove();
        }
        
        // Unmark in available list
        const availableItem = document.querySelector(`#availableProjectsList .project-item[data-id="${id}"]`);
        if (availableItem) {
            availableItem.classList.remove('in-selected-list');
        }
        
        // Show empty state if needed
        if (selectedProjects.length === 0) {
            const emptyHtml = `
                <div class="empty-state" id="emptySelectedState">
                    <i class="fa fa-hand-pointer-o"></i>
                    <p>Click on projects from the left panel to add them here.<br>
                    <small>Leave empty to use automatic mode (latest projects)</small></p>
                </div>
            `;
            selectedList.innerHTML = emptyHtml;
        }
        
        updateOrderNumbers();
        updateCounts();
        updateMaxWarning();
        updateClearButton();
    }
    
    function updateOrderNumbers() {
        const items = selectedList.querySelectorAll('.selected-item');
        items.forEach((item, index) => {
            const orderNum = item.querySelector('.order-number');
            if (orderNum) {
                orderNum.textContent = index + 1;
            }
        });
    }
    
    function updateCounts() {
        document.getElementById('selectedCount').textContent = selectedProjects.length;
        
        // Update available count (visible items not selected)
        const availableItems = document.querySelectorAll('#availableProjectsList .project-item:not(.in-selected-list)');
        let visibleCount = 0;
        availableItems.forEach(item => {
            if (item.style.display !== 'none') {
                visibleCount++;
            }
        });
        document.getElementById('availableCount').textContent = visibleCount;
    }
    
    function updateMaxWarning() {
        const warning = document.getElementById('maxWarning');
        if (selectedProjects.length >= maxProjects) {
            warning.style.display = 'block';
        } else {
            warning.style.display = 'none';
        }
    }
    
    function updateClearButton() {
        const clearBtn = document.getElementById('clearBtn');
        if (selectedProjects.length > 0) {
            clearBtn.style.display = 'inline-block';
        } else {
            clearBtn.style.display = 'none';
        }
    }
    
    function clearAllProjects() {
        if (!confirm('Are you sure you want to clear all selected projects? This will switch to automatic mode (latest projects).')) {
            return;
        }
        
        // Clear via AJAX
        fetch(`{{ url('admin/home-project-settings') }}/${settingId}/clear-projects`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Reset UI
                selectedProjects = [];
                document.querySelectorAll('#availableProjectsList .project-item').forEach(item => {
                    item.classList.remove('in-selected-list');
                });
                
                selectedList.innerHTML = `
                    <div class="empty-state" id="emptySelectedState">
                        <i class="fa fa-hand-pointer-o"></i>
                        <p>Click on projects from the left panel to add them here.<br>
                        <small>Leave empty to use automatic mode (latest projects)</small></p>
                    </div>
                `;
                
                updateCounts();
                updateMaxWarning();
                updateClearButton();
                
                Swal.fire({
                    icon: 'success',
                    title: 'Cleared!',
                    text: data.message,
                    timer: 2000,
                    showConfirmButton: false
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to clear projects'
            });
        });
    }
    
    function saveSelection() {
        // Get ordered project IDs from the DOM
        const orderedIds = [];
        document.querySelectorAll('#selectedProjectsList .selected-item').forEach(item => {
            orderedIds.push(parseInt(item.dataset.id));
        });
        
        fetch(`{{ url('admin/home-project-settings') }}/${settingId}/save-projects`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                projects: orderedIds
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Saved!',
                    text: data.message + (data.count > 0 ? ` (${data.count} projects selected)` : ' (Using automatic mode)'),
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = '{{ route("home-project-settings.index") }}';
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to save selection'
            });
        });
    }
</script>
@endsection
