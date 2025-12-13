@extends('admin::layouts.master')
@section('title', 'Sliders Management')

@section('css')
<!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<!-- Animate.css for animations -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<style>
    .slider-image-thumb {
        width: 120px;
        height: 60px;
        object-fit: cover;
        border-radius: 4px;
    }
    
    /* Drag and Drop Styles */
    #sortable-sliders tr.dragging {
        opacity: 0.5;
        background: #f0f0f0;
    }
    
    #sortable-sliders tr:hover {
        background-color: #f8f9fa;
    }
    
    .drag-handle:active {
        cursor: grabbing !important;
    }
    
    #sortable-sliders tr.drag-over {
        border-top: 3px solid #2196f3;
    }
</style>
@endsection

@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Admin')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-images"></i> Sliders</a>
        </nav>

        <div class="col-lg-12">
            <hr>
            
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <h4 class="mt-0 header-title"><i class="fa fa-images"></i> Sliders Management</h4>
                        </div>
                        <div class="col-sm-6 text-right">
                            <a href="{{ route('slider.create') }}" class="btn btn-success btn-sm">
                                <i class="fa fa-plus"></i> Add New Slider
                            </a>
                            <a href="{{ route('slider.trashed') }}" class="btn btn-danger btn-sm">
                                <i class="fa fa-trash"></i> Trashed Sliders
                            </a>
                        </div>
                    </div>
                    <hr>
                    
                    <div class="alert alert-info" style="background: #e3f2fd; border-left: 4px solid #2196f3; color: #1565c0;">
                        <i class="fa fa-info-circle"></i> <strong>Tip:</strong> Drag and drop sliders to reorder them. Changes are saved automatically.
                    </div>
                    
                    <table class="table table-striped table-bordered" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th style="width: 50px; text-align: center;"><i class="fa fa-arrows-v"></i></th>
                                <th style="width: 60px;">ID</th>
                                <th style="width: 140px;">Image</th>
                                <th>Title (English)</th>
                                <th>Title (Arabic)</th>
                                <th style="width: 80px; text-align: center;">Order</th>
                                <th style="width: 130px;">Status</th>
                                <th style="width: 110px;">Created Date</th>
                                <th style="width: 100px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="sortable-sliders">
                            @foreach($sliders as $slider)
                            <tr draggable="true" data-id="{{ $slider->id }}" style="cursor: move; transition: all 0.3s ease;">
                                <td style="text-align: center; cursor: grab;" class="drag-handle">
                                    <i class="fa fa-arrows-v" style="color: #9e9e9e; font-size: 18px;"></i>
                                </td>
                                <td>{{ $slider->id }}</td>
                                <td>
                                    <img src="{{ asset('storage' . $slider->image) }}" alt="{{ $slider->title_english }}" class="slider-image-thumb">
                                </td>
                                <td><strong>{{ $slider->title_english }}</strong></td>
                                <td dir="rtl"><strong>{{ $slider->title_arabic }}</strong></td>
                                <td style="text-align: center;"><span class="badge badge-info ordering-badge">{{ $slider->ordering }}</span></td>
                                <td>
                                    <form action="{{ route('slider.toggle-status', ['id' => $slider->id]) }}" method="POST" style="display:inline;" class="toggle-status-form">
                                        @csrf
                                        @if($slider->status == 0)
                                            <button type="button" class="btn btn-sm btn-success toggle-status-btn" data-slider-id="{{ $slider->id }}" data-current-status="0">
                                                <i class="fa fa-check"></i> Published
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-sm btn-danger toggle-status-btn" data-slider-id="{{ $slider->id }}" data-current-status="1">
                                                <i class="fa fa-times"></i> Not Published
                                            </button>
                                        @endif
                                    </form>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($slider->created_at)->format('Y-m-d') }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('slider.edit', ['id' => $slider->id]) }}" class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <form action="{{ route('slider.delete', ['id' => $slider->id]) }}" method="POST" style="display:inline;" class="delete-form">
                                            @csrf
                                            <button type="button" class="btn btn-sm btn-danger delete-btn" data-slider-id="{{ $slider->id }}" data-slider-title="{{ $slider->title_english }}">
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
            
            const sliderTitle = $(this).data('slider-title');
            const form = $(this).closest('form');
            
            Swal.fire({
                title: 'Delete Slider?',
                html: `Are you sure you want to delete <strong>"${sliderTitle}"</strong>?<br><span style="color: #dc3545; font-size: 14px;">This action cannot be undone!</span>`,
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
                        text: 'Please wait while we delete the slider',
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
            const action = currentStatus == 0 ? 'unpublish' : 'publish';
            
            Swal.fire({
                title: action == 'publish' ? 'Publish Slider?' : 'Unpublish Slider?',
                text: action == 'publish' ? 'This slider will be visible on the website.' : 'This slider will be hidden from the website.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: action == 'publish' ? '#28a745' : '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: action == 'publish' ? '<i class="fa fa-check"></i> Yes, Publish' : '<i class="fa fa-times"></i> Yes, Unpublish',
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
                        text: 'Updating slider status',
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
        const sortableTable = document.getElementById('sortable-sliders');
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
                updateSliderOrders();
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
    
    // Update slider orders and save via AJAX
    function updateSliderOrders() {
        const sortableTable = document.getElementById('sortable-sliders');
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
        
        console.log('Sending orders:', orders);
        
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
            url: '{{ route("slider.update-orders") }}',
            type: 'POST',
            dataType: 'json',
            data: {
                _token: csrfToken.getAttribute('content'),
                orders: JSON.stringify(orders)
            },
            beforeSend: function() {
                console.log('Sending AJAX request...');
                console.log('URL:', '{{ route("slider.update-orders") }}');
                console.log('Token:', csrfToken.getAttribute('content'));
                console.log('Orders:', orders);
            },
            success: function(response) {
                console.log('Success response:', response);
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
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Warning!',
                        text: response.message || 'Unknown response',
                        toast: true,
                        position: 'top-end',
                        timer: 3000
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error Details:');
                console.error('Status:', status);
                console.error('Error:', error);
                console.error('Response Status:', xhr.status);
                console.error('Response Text:', xhr.responseText);
                
                let errorMsg = 'Failed to update order';
                if (xhr.status === 419) {
                    errorMsg = 'Session expired. Please refresh the page.';
                } else if (xhr.status === 404) {
                    errorMsg = 'Update endpoint not found';
                } else if (xhr.status === 500) {
                    errorMsg = 'Server error. Check logs.';
                } else if (xhr.responseText) {
                    try {
                        const resp = JSON.parse(xhr.responseText);
                        errorMsg = resp.message || errorMsg;
                    } catch (e) {
                        errorMsg = xhr.responseText.substring(0, 100);
                    }
                }
                
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    html: '<strong>' + errorMsg + '</strong><br><small>Status: ' + xhr.status + '</small>',
                    showConfirmButton: true,
                    toast: false,
                    position: 'center'
                });
            }
        });
    }
</script>
@endsection

