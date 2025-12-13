@extends('admin::layouts.master')
@section('title', 'Process Cards Management')

@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<style>
    #sortable-cards tr.dragging {
        opacity: 0.5;
        background: #f0f0f0;
    }
    #sortable-cards tr:hover {
        background-color: #f8f9fa;
    }
    .drag-handle:active {
        cursor: grabbing !important;
    }
    #sortable-cards tr.drag-over {
        border-top: 3px solid #2196f3;
    }
</style>
@endsection

@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Admin')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a href="{{route('admin.default-processes.index')}}" class="breadcrumbs__item"><i class="fa fa-cogs"></i> Default Processes</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-list"></i> Process Cards</a>
        </nav>

        <div class="col-lg-12">
            <hr>
            
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <h4 class="mt-0 header-title"><i class="fa fa-list"></i> Cards for: {{ $process->title_english }}</h4>
                        </div>
                        <div class="col-sm-6 text-right">
                            <a href="{{ route('admin.default-process-cards.create', ['processId' => $process->id]) }}" class="btn btn-success btn-sm">
                                <i class="fa fa-plus"></i> Add New Card
                            </a>
                            <a href="{{ route('admin.default-process-cards.trashed', ['processId' => $process->id]) }}" class="btn btn-danger btn-sm">
                                <i class="fa fa-trash"></i> Trashed Cards
                            </a>
                            <a href="{{ route('admin.default-processes.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fa fa-arrow-left"></i> Back to Processes
                            </a>
                        </div>
                    </div>
                    <hr>
                    
                    <div class="alert alert-info" style="background: #e3f2fd; border-left: 4px solid #2196f3; color: #1565c0;">
                        <i class="fa fa-info-circle"></i> <strong>Tip:</strong> Drag and drop cards to reorder them. Changes are saved automatically.
                    </div>
                    
                    @if($cards->isEmpty())
                        <div class="alert alert-warning">
                            <i class="fa fa-exclamation-triangle"></i> No cards found for this process. Click "Add New Card" to create one.
                        </div>
                    @else
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 50px; text-align: center;"><i class="fa fa-arrows-v"></i></th>
                                    <th style="width: 60px;">ID</th>
                                    <th>Title (English)</th>
                                    <th>Title (Arabic)</th>
                                    <th>Bio (English)</th>
                                    <th style="width: 80px; text-align: center;">Order</th>
                                    <th style="width: 130px;">Status</th>
                                    <th style="width: 100px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="sortable-cards">
                                @foreach($cards as $card)
                                <tr draggable="true" data-id="{{ $card->id }}" style="cursor: move; transition: all 0.3s ease;">
                                    <td style="text-align: center; cursor: grab;" class="drag-handle">
                                        <i class="fa fa-arrows-v" style="color: #9e9e9e; font-size: 18px;"></i>
                                    </td>
                                    <td>{{ $card->id }}</td>
                                    <td><strong>{{ $card->title_english }}</strong></td>
                                    <td dir="rtl"><strong>{{ $card->title_arabic }}</strong></td>
                                    <td>{{ Str::limit($card->bio_english, 50) }}</td>
                                    <td style="text-align: center;"><span class="badge badge-info ordering-badge">{{ $card->ordering }}</span></td>
                                    <td>
                                        <form action="{{ route('admin.default-process-cards.toggle-status', ['processId' => $process->id, 'id' => $card->id]) }}" method="POST" style="display:inline;" class="toggle-status-form">
                                            @csrf
                                            @if($card->status == 0)
                                                <button type="button" class="btn btn-sm btn-success toggle-status-btn" data-id="{{ $card->id }}" data-current-status="0">
                                                    <i class="fa fa-check"></i> Active
                                                </button>
                                            @else
                                                <button type="button" class="btn btn-sm btn-danger toggle-status-btn" data-id="{{ $card->id }}" data-current-status="1">
                                                    <i class="fa fa-times"></i> Not Active
                                                </button>
                                            @endif
                                        </form>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('admin.default-process-cards.edit', ['processId' => $process->id, 'id' => $card->id]) }}" class="btn btn-sm btn-warning" title="Edit">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <form action="{{ route('admin.default-process-cards.destroy', ['processId' => $process->id, 'id' => $card->id]) }}" method="POST" style="display:inline;" class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="{{ $card->id }}" data-title="{{ $card->title_english }}">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
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
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 3000,
                toast: true,
                position: 'top-end'
            });
        @endif

        $(document).on('click', '.delete-btn', function(e) {
            e.preventDefault();
            const title = $(this).data('title');
            const form = $(this).closest('form');
            
            Swal.fire({
                title: 'Delete Card?',
                html: `Are you sure you want to delete <strong>"${title}"</strong>?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                confirmButtonText: '<i class="fa fa-trash"></i> Yes, Delete It'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
        
        $(document).on('click', '.toggle-status-btn', function(e) {
            e.preventDefault();
            const form = $(this).closest('form');
            form.submit();
        });
        
        // Drag and Drop
        initializeDragAndDrop();
    });
    
    function initializeDragAndDrop() {
        const sortableTable = document.getElementById('sortable-cards');
        if (!sortableTable) return;
        
        let draggedRow = null;
        const rows = sortableTable.querySelectorAll('tr[draggable="true"]');
        
        rows.forEach(row => {
            row.addEventListener('dragstart', function(e) {
                draggedRow = this;
                this.classList.add('dragging');
            });
            
            row.addEventListener('dragend', function(e) {
                this.classList.remove('dragging');
                rows.forEach(r => r.classList.remove('drag-over'));
                updateCardOrders();
            });
            
            row.addEventListener('dragover', function(e) {
                e.preventDefault();
                if (this !== draggedRow) {
                    rows.forEach(r => r.classList.remove('drag-over'));
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
        });
    }
    
    function updateCardOrders() {
        const rows = document.querySelectorAll('#sortable-cards tr[draggable="true"]');
        const orders = [];
        
        rows.forEach((row, index) => {
            const id = row.getAttribute('data-id');
            const orderBadge = row.querySelector('.ordering-badge');
            if (orderBadge) {
                orderBadge.textContent = index;
            }
            orders.push({ id: parseInt(id), order: index });
        });
        
        const csrfToken = document.querySelector('meta[name="csrf-token"]');
        if (!csrfToken) return;
        
        $.ajax({
            url: '{{ route("admin.default-process-cards.update-orders", ["processId" => $process->id]) }}',
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
                        toast: true,
                        position: 'top-end'
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Failed to update order',
                    toast: true,
                    position: 'top-end',
                    timer: 3000
                });
            }
        });
    }
</script>
@endsection

