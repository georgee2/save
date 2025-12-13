@extends('admin::layouts.master')
@section('title', 'Facts Management')

@section('css')
<!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<!-- Animate.css for animations -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<style>
    .fact-icon-thumb {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 8px;
        border: 2px solid #e0e0e0;
    }
    
    /* Drag and Drop Styles */
    #sortable-facts tr.dragging {
        opacity: 0.5;
        background: #f0f0f0;
    }
    
    #sortable-facts tr:hover {
        background-color: #f8f9fa;
    }
    
    .drag-handle:active {
        cursor: grabbing !important;
    }
    
    #sortable-facts tr.drag-over {
        border-top: 3px solid #2196f3;
    }
</style>
@endsection

@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Admin')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-chart-line"></i> Facts</a>
        </nav>

        <div class="col-lg-12">
            <hr>
            
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <h4 class="mt-0 header-title"><i class="fa fa-chart-line"></i> Facts Management</h4>
                        </div>
                        <div class="col-sm-6 text-right">
                            <a href="{{ route('admin.facts.create') }}" class="btn btn-success btn-sm">
                                <i class="fa fa-plus"></i> Add New Fact
                            </a>
                            <a href="{{ route('admin.facts.trashed') }}" class="btn btn-danger btn-sm">
                                <i class="fa fa-trash"></i> Trashed Facts
                            </a>
                        </div>
                    </div>
                    <hr>
                    
                    <div class="alert alert-info" style="background: #e3f2fd; border-left: 4px solid #2196f3; color: #1565c0;">
                        <i class="fa fa-info-circle"></i> <strong>Tip:</strong> Drag and drop facts to reorder them. Changes are saved automatically.
                    </div>
                    
                    <table class="table table-striped table-bordered" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th style="width: 50px; text-align: center;"><i class="fa fa-arrows-v"></i></th>
                                <th style="width: 60px;">ID</th>
                                <th style="width: 120px;">Icon</th>
                                <th>Title (English)</th>
                                <th>Title (Arabic)</th>
                                <th style="width: 120px;">Fact Number</th>
                                <th style="width: 80px; text-align: center;">Order</th>
                                <th style="width: 130px;">Status</th>
                                <th style="width: 110px;">Created Date</th>
                                <th style="width: 100px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="sortable-facts">
                            @foreach($facts as $fact)
                            <tr draggable="true" data-id="{{ $fact->id }}" style="cursor: move; transition: all 0.3s ease;">
                                <td style="text-align: center; cursor: grab;" class="drag-handle">
                                    <i class="fa fa-arrows-v" style="color: #9e9e9e; font-size: 18px;"></i>
                                </td>
                                <td>{{ $fact->id }}</td>
                                <td>
                                    <img src="{{ asset('storage' . $fact->icon) }}" alt="{{ $fact->title_english }}" class="fact-icon-thumb">
                                </td>
                                <td><strong>{{ $fact->title_english }}</strong></td>
                                <td dir="rtl"><strong>{{ $fact->title_arabic }}</strong></td>
                                <td style="text-align: center;"><span class="badge badge-primary" style="font-size: 16px;">{{ $fact->fact_number }}</span></td>
                                <td style="text-align: center;"><span class="badge badge-info ordering-badge">{{ $fact->ordering }}</span></td>
                                <td>
                                    <form action="{{ route('admin.facts.toggle-status', ['id' => $fact->id]) }}" method="POST" style="display:inline;" class="toggle-status-form">
                                        @csrf
                                        @if($fact->status == 0)
                                            <button type="button" class="btn btn-sm btn-success toggle-status-btn" data-fact-id="{{ $fact->id }}" data-current-status="0">
                                                <i class="fa fa-check"></i> Active
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-sm btn-danger toggle-status-btn" data-fact-id="{{ $fact->id }}" data-current-status="1">
                                                <i class="fa fa-times"></i> Not Active
                                            </button>
                                        @endif
                                    </form>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($fact->created_at)->format('Y-m-d') }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.facts.edit', ['id' => $fact->id]) }}" class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.facts.destroy', ['id' => $fact->id]) }}" method="POST" style="display:inline;" class="delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger delete-btn" data-fact-id="{{ $fact->id }}" data-fact-title="{{ $fact->title_english }}">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        // Display success/error messages with SweetAlert2
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                toast: true,
                position: 'top-end',
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                }
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: '{{ session('error') }}',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                toast: true,
                position: 'top-end',
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                }
            });
        @endif
        
        // Attach event handlers
        attachEventHandlers();
        
        // Initialize Drag and Drop
        initializeDragAndDrop();
    });
    
    // Attach event handlers function
    function attachEventHandlers() {
        // Handle Delete Button Click
        $(document).on('click', '.delete-btn', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const factTitle = $(this).data('fact-title');
            const form = $(this).closest('form');
            
            Swal.fire({
                title: 'Delete Fact?',
                html: `Are you sure you want to delete <strong>"${factTitle}"</strong>?<br><span style="color: #dc3545; font-size: 14px;">This will move it to trash!</span>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fa fa-trash"></i> Yes, Delete It',
                cancelButtonText: '<i class="fa fa-times"></i> Cancel',
                reverseButtons: true,
                focusCancel: true,
                showClass: {
                    popup: 'animate__animated animate__zoomIn animate__faster'
                },
                hideClass: {
                    popup: 'animate__animated animate__zoomOut animate__faster'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Deleting...',
                        text: 'Please wait while we delete the fact',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    form.submit();
                }
            });
        });
        
        // Handle Toggle Status Button Click
        $(document).on('click', '.toggle-status-btn', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const currentStatus = $(this).data('current-status');
            const form = $(this).closest('form');
            const action = currentStatus == 0 ? 'deactivate' : 'activate';
            
            Swal.fire({
                title: action == 'activate' ? 'Activate Fact?' : 'Deactivate Fact?',
                text: action == 'activate' ? 'This fact will be visible on the website.' : 'This fact will be hidden from the website.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: action == 'activate' ? '#28a745' : '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: action == 'activate' ? '<i class="fa fa-check"></i> Yes, Activate' : '<i class="fa fa-times"></i> Yes, Deactivate',
                cancelButtonText: '<i class="fa fa-times"></i> Cancel',
                reverseButtons: true,
                focusCancel: true,
                showClass: {
                    popup: 'animate__animated animate__zoomIn animate__faster'
                },
                hideClass: {
                    popup: 'animate__animated animate__zoomOut animate__faster'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Processing...',
                        text: 'Updating fact status',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    form.submit();
                }
            });
        });
    }
    
    // Drag and Drop Functionality
    function initializeDragAndDrop() {
        const sortableTable = document.getElementById('sortable-facts');
        if (!sortableTable) return;
        
        let draggedRow = null;
        
        // Add event listeners to all draggable rows
        const rows = sortableTable.querySelectorAll('tr[draggable="true"]');
        
        rows.forEach(row => {
            row.addEventListener('dragstart', function(e) {
                draggedRow = this;
                this.classList.add('dragging');
                e.dataTransfer.effectAllowed = 'move';
                e.dataTransfer.setData('text/html', this.innerHTML);
            });
            
            row.addEventListener('dragend', function(e) {
                this.classList.remove('dragging');
                
                // Remove drag-over class from all rows
                rows.forEach(r => r.classList.remove('drag-over'));
                
                // Update order and save
                updateFactOrders();
            });
            
            row.addEventListener('dragover', function(e) {
                e.preventDefault();
                e.dataTransfer.dropEffect = 'move';
                
                if (this !== draggedRow) {
                    // Remove drag-over from all
                    rows.forEach(r => r.classList.remove('drag-over'));
                    
                    // Add to current
                    this.classList.add('drag-over');
                    
                    const rect = this.getBoundingClientRect();
                    const midpoint = rect.top + rect.height / 2;
                    
                    if (e.clientY < midpoint) {
                        this.parentNode.insertBefore(draggedRow, this);
                    } else {
                        this.parentNode.insertBefore(draggedRow, this.nextSibling);
                    }
                }
            });
            
            row.addEventListener('dragleave', function(e) {
                this.classList.remove('drag-over');
            });
        });
    }
    
    // Update fact orders and save via AJAX
    function updateFactOrders() {
        const sortableTable = document.getElementById('sortable-facts');
        const rows = sortableTable.querySelectorAll('tr[draggable="true"]');
        const orders = [];
        
        rows.forEach((row, index) => {
            const id = row.getAttribute('data-id');
            const orderBadge = row.querySelector('.ordering-badge');
            const newOrder = index;
            
            // Update badge display
            if (orderBadge) {
                orderBadge.textContent = newOrder;
            }
            
            orders.push({
                id: parseInt(id),
                order: newOrder
            });
        });
        
        // Get CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]');
        if (!csrfToken) {
            console.error('CSRF token not found!');
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'CSRF token not found. Please refresh the page.',
                toast: true,
                position: 'top-end',
                timer: 3000
            });
            return;
        }
        
        // Save via AJAX using jQuery
        $.ajax({
            url: '{{ route("admin.facts.update-orders") }}',
            type: 'POST',
            dataType: 'json',
            data: {
                _token: csrfToken.getAttribute('content'),
                orders: JSON.stringify(orders)
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Order Updated!',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true,
                        toast: true,
                        position: 'top-end',
                        showClass: {
                            popup: 'animate__animated animate__fadeInDown'
                        },
                        hideClass: {
                            popup: 'animate__animated animate__fadeOutUp'
                        }
                    });
                }
            },
            error: function(xhr, status, error) {
                let errorMsg = 'Failed to update order';
                if (xhr.status === 419) {
                    errorMsg = 'Session expired. Please refresh the page.';
                }
                
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: errorMsg,
                    toast: true,
                    position: 'top-end',
                    timer: 3000
                });
            }
        });
    }
</script>
@endsection

