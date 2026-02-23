@extends('admin::layouts.master')
@section('title', 'About Page Sections')

@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<style>
    .section-icon {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        background: linear-gradient(135deg, #19868b 0%, #25a5aa 100%);
        color: #fff;
        font-size: 16px;
    }
    
    .section-row {
        transition: all 0.3s ease;
    }
    
    .section-row:hover {
        background-color: #f8f9fa;
    }
    
    .section-row.dragging {
        opacity: 0.5;
        background: #e3f2fd;
    }
    
    .section-row.drag-over {
        border-top: 3px solid #19868b;
    }
    
    .drag-handle {
        cursor: grab;
    }
    
    .drag-handle:active {
        cursor: grabbing;
    }
    
    .order-badge {
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: #e9ecef;
        font-weight: 600;
        font-size: 14px;
    }
    
    .status-toggle {
        cursor: pointer;
        transition: all 0.2s ease;
    }
    
    .status-toggle:hover {
        transform: scale(1.1);
    }
    
    .action-btn {
        width: 32px;
        height: 32px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        margin: 0 2px;
    }
    
    .blade-view {
        font-family: 'Courier New', monospace;
        font-size: 12px;
        background: #f8f9fa;
        padding: 4px 8px;
        border-radius: 4px;
        color: #6c757d;
    }
    
    .section-info {
        max-width: 300px;
    }
    
    .section-title {
        font-weight: 600;
        color: #333;
        margin-bottom: 2px;
    }
    
    .section-description {
        font-size: 12px;
        color: #999;
        margin: 0;
    }
    
    .section-key {
        font-size: 11px;
        background: #f0f0f0;
        padding: 2px 6px;
        border-radius: 3px;
        color: #666;
        font-family: monospace;
    }
</style>
@endsection

@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Admin')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-info-circle"></i> About Page Sections</a>
        </nav>

        <div class="col-lg-12">
            <hr>
            
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fa fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <h4 class="mt-0 header-title"><i class="fa fa-info-circle"></i> About Page Sections Management</h4>
                        </div>
                        <div class="col-sm-6 text-right">
                            <a href="{{ route('about') }}" target="_blank" class="btn btn-info btn-sm">
                                <i class="fa fa-external-link"></i> View About Page
                            </a>
                        </div>
                    </div>
                    <hr>
                    
                    <div class="alert alert-info" style="background: #e3f2fd; border-left: 4px solid #2196f3; color: #1565c0;">
                        <i class="fa fa-info-circle"></i> <strong>Tip:</strong> Drag and drop sections to reorder them. Use the toggle buttons to enable/disable sections on the about page.
                    </div>
                    
                    @if(count($sections) > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead class="thead-light">
                                <tr>
                                    <th style="width: 50px; text-align: center;"><i class="fa fa-arrows-v"></i></th>
                                    <th style="width: 60px; text-align: center;">Order</th>
                                    <th style="width: 60px; text-align: center;">Icon</th>
                                    <th>Section Info</th>
                                    <th style="width: 180px;">Blade Partial</th>
                                    <th style="width: 100px; text-align: center;">Status</th>
                                    <th style="width: 140px; text-align: center;">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="sortable-sections">
                                @foreach($sections as $section)
                                <tr class="section-row" draggable="true" data-id="{{ $section->id }}">
                                    <td style="text-align: center;" class="drag-handle">
                                        <i class="fa fa-arrows-v" style="color: #9e9e9e; font-size: 18px;"></i>
                                    </td>
                                    <td style="text-align: center;">
                                        <span class="order-badge">{{ $section->ordering }}</span>
                                    </td>
                                    <td style="text-align: center;">
                                        <div class="section-icon">
                                            <i class="{{ $section->icon ?? 'fa fa-puzzle-piece' }}"></i>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="section-info">
                                            <div class="section-title">{{ $section->title_english }}</div>
                                            <div class="text-muted small">{{ $section->title_arabic }}</div>
                                            <span class="section-key">{{ $section->section_key }}</span>
                                            @if($section->description)
                                            <p class="section-description mt-1">{{ Str::limit($section->description, 60) }}</p>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <code class="blade-view">{{ $section->blade_partial }}</code>
                                    </td>
                                    <td style="text-align: center;">
                                        <button type="button" class="btn btn-sm status-toggle {{ $section->status == 0 ? 'btn-success' : 'btn-secondary' }}" 
                                                data-id="{{ $section->id }}"
                                                title="{{ $section->status == 0 ? 'Active - Click to deactivate' : 'Inactive - Click to activate' }}">
                                            <i class="fa {{ $section->status == 0 ? 'fa-check' : 'fa-times' }}"></i>
                                            {{ $section->status == 0 ? 'Active' : 'Inactive' }}
                                        </button>
                                    </td>
                                    <td style="text-align: center;">
                                        <form action="{{ route('about-page-sections.move-up', $section->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-primary action-btn" title="Move Up">
                                                <i class="fa fa-arrow-up"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('about-page-sections.move-down', $section->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-primary action-btn" title="Move Down">
                                                <i class="fa fa-arrow-down"></i>
                                            </button>
                                        </form>
                                        <a href="{{ route('about-page-sections.edit', $section->id) }}" class="btn btn-outline-info action-btn" title="Edit">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="alert alert-warning text-center">
                        <i class="fa fa-exclamation-triangle fa-2x mb-2"></i>
                        <p class="mb-0">No about page sections found. Please run the migration to seed default sections.</p>
                    </div>
                    @endif
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    // Drag and Drop functionality
    const tbody = document.getElementById('sortable-sections');
    let draggedRow = null;

    tbody.addEventListener('dragstart', function(e) {
        draggedRow = e.target.closest('tr');
        if (draggedRow) {
            draggedRow.classList.add('dragging');
            e.dataTransfer.effectAllowed = 'move';
        }
    });

    tbody.addEventListener('dragend', function(e) {
        if (draggedRow) {
            draggedRow.classList.remove('dragging');
            document.querySelectorAll('.section-row').forEach(row => {
                row.classList.remove('drag-over');
            });
            
            // Save new order
            saveOrder();
        }
        draggedRow = null;
    });

    tbody.addEventListener('dragover', function(e) {
        e.preventDefault();
        const targetRow = e.target.closest('tr');
        if (targetRow && targetRow !== draggedRow && targetRow.classList.contains('section-row')) {
            const rows = Array.from(tbody.querySelectorAll('.section-row'));
            const draggedIndex = rows.indexOf(draggedRow);
            const targetIndex = rows.indexOf(targetRow);
            
            document.querySelectorAll('.section-row').forEach(row => {
                row.classList.remove('drag-over');
            });
            targetRow.classList.add('drag-over');
            
            if (draggedIndex < targetIndex) {
                targetRow.parentNode.insertBefore(draggedRow, targetRow.nextSibling);
            } else {
                targetRow.parentNode.insertBefore(draggedRow, targetRow);
            }
        }
    });

    function saveOrder() {
        const rows = document.querySelectorAll('.section-row');
        const orderings = [];
        
        rows.forEach((row, index) => {
            orderings.push({
                id: row.dataset.id,
                ordering: index + 1
            });
            // Update visual order badge
            row.querySelector('.order-badge').textContent = index + 1;
        });

        fetch('{{ route("about-page-sections.update-order") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ orderings: orderings })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Order Updated!',
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
                text: 'Failed to update order. Please try again.'
            });
        });
    }

    // Status toggle via AJAX
    $('.status-toggle').click(function() {
        const btn = $(this);
        const id = btn.data('id');
        
        fetch('{{ url("admin/about-page-sections/toggle-status") }}/' + id, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Toggle button appearance
                if (data.status == 0) {
                    btn.removeClass('btn-secondary').addClass('btn-success');
                    btn.html('<i class="fa fa-check"></i> Active');
                    btn.attr('title', 'Active - Click to deactivate');
                } else {
                    btn.removeClass('btn-success').addClass('btn-secondary');
                    btn.html('<i class="fa fa-times"></i> Inactive');
                    btn.attr('title', 'Inactive - Click to activate');
                }
                
                Swal.fire({
                    icon: 'success',
                    title: 'Status Updated!',
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
                text: 'Failed to update status. Please try again.'
            });
        });
    });
});
</script>
@endsection
