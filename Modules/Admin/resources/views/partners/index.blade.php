@extends('admin::layouts.master')
@section('title', 'Partners List')
@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Admin')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-handshake-o"></i> Partners List</a> 
        </nav>

        <div class="col-lg-12">
            <hr>
            
            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert" style="border-left: 4px solid #28a745; font-size: 16px; padding: 15px 20px;">
                    <i class="fa fa-check-circle" style="font-size: 20px;"></i> <strong>Success!</strong> {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert" style="border-left: 4px solid #dc3545; font-size: 16px; padding: 15px 20px;">
                    <i class="fa fa-exclamation-circle" style="font-size: 20px;"></i> <strong>Error!</strong>
                    <ul class="mb-0" style="margin-top: 10px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="mt-0 header-title align-self-center">Partners List</h4>
                        <div class="buttons">
                            <a href="{{ route('partner.create') }}" class="mr-2">
                                <button class="btn btn-new"><i class="fa fa-plus"></i> Add New Partner</button>
                            </a>
                            <a href="{{ route('partner.trashed') }}" class="mr-2">
                                <button class="btn btn-danger"><i class="fa fa-trash"></i> Trashed Partners</button>
                            </a>
                            <button class="btn btn-primary" onclick="window.history.back()">
                                <i class="fa fa-angle-left"></i> Back
                            </button>
                        </div>
                    </div>
                    <hr>
                    
                    <!-- Nav Tabs for Partners, Branches, and Government -->
                    <ul class="nav nav-tabs mb-4" id="partnerTabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="partners-tab" data-toggle="tab" href="#partners-list" role="tab">
                                <i class="fa fa-handshake-o mr-1"></i> Partners
                                <span class="badge badge-primary ml-1">{{ $partners->where('partner_type', 'partner')->count() }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="branches-tab" data-toggle="tab" href="#branches-list" role="tab">
                                <i class="fa fa-building mr-1"></i> Branches
                                <span class="badge badge-info ml-1">{{ $partners->where('partner_type', 'branch')->count() }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="government-tab" data-toggle="tab" href="#government-list" role="tab">
                                <i class="fa fa-university mr-1"></i> Government
                                <span class="badge badge-success ml-1">{{ $partners->where('partner_type', 'government')->count() }}</span>
                            </a>
                        </li>
                    </ul>
                    
                    <div class="tab-content" id="partnerTabsContent">
                        <!-- Partners Tab -->
                        <div class="tab-pane fade show active" id="partners-list" role="tabpanel">
                            <div class="alert alert-info mb-3">
                                <i class="fa fa-info-circle mr-2"></i>
                                <strong>Tip:</strong> Drag and drop rows to reorder partners. The order will be saved automatically.
                            </div>
                            <table class="table table-striped table-bordered dt-responsive" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th style="width: 50px;">#</th>
                                        <th>Logo</th>
                                        <th>Name (English)</th>
                                        <th>Name (Arabic)</th>
                                        <th>Email</th>
                                        <th>Mobile</th>
                                        <th>#Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="partners-sortable">
                                    @foreach($partners->where('partner_type', 'partner') as $index => $partner)
                                    <tr data-id="{{ $partner->id }}">
                                        <td class="text-center">
                                            <i class="fa fa-arrows-v text-muted" style="cursor: grab;"></i>
                                            <span class="ml-2 badge badge-secondary">{{ $partner->display_order ?? ($index + 1) }}</span>
                                        </td>
                                        <td>
                                            @if($partner->logo_english)
                                                <a data-lightbox="{{url('/storage'.$partner->logo_english)}}" href="{{url('/storage'.$partner->logo_english)}}">
                                                    <img style="width:50px; height: 50px; object-fit: contain;" src="{{url('/storage'.$partner->logo_english)}}" alt="Logo">
                                                </a>
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td>{{ $partner->name_english }}</td>
                                        <td>{{ $partner->name_arabic }}</td>
                                        <td>{{ $partner->email }}</td>
                                        <td>{{ $partner->mobile }}</td>
                                        <td>
                                            <a href="{{ route('partner.show', ['id' => $partner->id]) }}" class="btn btn-info btn-sm mr-1" title="View Profile">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <a href="{{ route('partner.edit', ['id' => $partner->id]) }}" class="btn btn-warning btn-sm mr-1" title="Edit">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{ $partner->id }}" title="Delete">
                                                <i class="fa fa-trash-o"></i>
                                            </button>
                                            
                                            <!-- Delete Modal -->
                                            <div class="modal fade" id="deleteModal{{ $partner->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <form action="{{ route('partner.delete', ['id' => $partner->id]) }}" method="POST">
                                                            @csrf
                                                            <div style="text-align: center;font-size: 25px;" class="modal-body">
                                                                <br>
                                                                <p>Are you Sure ?!</p><br><i style="color: #d9534f" class="fa fa-trash-o fa-5x"></i> 
                                                                <br><br><p>You Want to Delete This Partner</p>
                                                                <p><strong>{{ $partner->name_english }}</strong></p>
                                                            </div>
                                                            <br>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Cancel</button>
                                                                <button type="submit" class="btn btn-danger waves-effect waves-light"><i class="fa fa-trash-o"></i> Delete</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @if($partners->where('partner_type', 'partner')->count() == 0)
                            <div class="text-center text-muted py-4">
                                <i class="fa fa-handshake-o fa-3x mb-3"></i>
                                <p>No partners found. <a href="{{ route('partner.create') }}">Add one now</a>.</p>
                            </div>
                            @endif
                        </div>
                        
                        <!-- Branches Tab -->
                        <div class="tab-pane fade" id="branches-list" role="tabpanel">
                            <div class="alert alert-info mb-3">
                                <i class="fa fa-info-circle mr-2"></i>
                                <strong>Tip:</strong> Drag and drop rows to reorder branches. The order will be saved automatically.
                            </div>
                            <table class="table table-striped table-bordered dt-responsive" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th style="width: 50px;">#</th>
                                        <th>Logo</th>
                                        <th>Name (English)</th>
                                        <th>Name (Arabic)</th>
                                        <th>Email</th>
                                        <th>Mobile</th>
                                        <th>#Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="branches-sortable">
                                    @foreach($partners->where('partner_type', 'branch') as $index => $partner)
                                    <tr data-id="{{ $partner->id }}">
                                        <td class="text-center">
                                            <i class="fa fa-arrows-v text-muted" style="cursor: grab;"></i>
                                            <span class="ml-2 badge badge-secondary">{{ $partner->display_order ?? ($index + 1) }}</span>
                                        </td>
                                        <td>
                                            @if($partner->logo_english)
                                                <a data-lightbox="{{url('/storage'.$partner->logo_english)}}" href="{{url('/storage'.$partner->logo_english)}}">
                                                    <img style="width:50px; height: 50px; object-fit: contain;" src="{{url('/storage'.$partner->logo_english)}}" alt="Logo">
                                                </a>
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td>{{ $partner->name_english }}</td>
                                        <td>{{ $partner->name_arabic }}</td>
                                        <td>{{ $partner->email }}</td>
                                        <td>{{ $partner->mobile }}</td>
                                        <td>
                                            <a href="{{ route('partner.show', ['id' => $partner->id]) }}" class="btn btn-info btn-sm mr-1" title="View Profile">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <a href="{{ route('partner.edit', ['id' => $partner->id]) }}" class="btn btn-warning btn-sm mr-1" title="Edit">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{ $partner->id }}" title="Delete">
                                                <i class="fa fa-trash-o"></i>
                                            </button>
                                            
                                            <!-- Delete Modal -->
                                            <div class="modal fade" id="deleteModal{{ $partner->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <form action="{{ route('partner.delete', ['id' => $partner->id]) }}" method="POST">
                                                            @csrf
                                                            <div style="text-align: center;font-size: 25px;" class="modal-body">
                                                                <br>
                                                                <p>Are you Sure ?!</p><br><i style="color: #d9534f" class="fa fa-trash-o fa-5x"></i> 
                                                                <br><br><p>You Want to Delete This Branch</p>
                                                                <p><strong>{{ $partner->name_english }}</strong></p>
                                                            </div>
                                                            <br>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Cancel</button>
                                                                <button type="submit" class="btn btn-danger waves-effect waves-light"><i class="fa fa-trash-o"></i> Delete</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @if($partners->where('partner_type', 'branch')->count() == 0)
                            <div class="text-center text-muted py-4">
                                <i class="fa fa-building fa-3x mb-3"></i>
                                <p>No branches found. <a href="{{ route('partner.create') }}">Add one now</a>.</p>
                            </div>
                            @endif
                        </div>
                        
                        <!-- Government Partners Tab -->
                        <div class="tab-pane fade" id="government-list" role="tabpanel">
                            <div class="alert alert-info mb-3">
                                <i class="fa fa-info-circle mr-2"></i>
                                <strong>Note:</strong> Government partners only display name and logo. Drag and drop rows to reorder.
                            </div>
                            <table class="table table-striped table-bordered dt-responsive" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th style="width: 50px;">#</th>
                                        <th>Logo</th>
                                        <th>Name (English)</th>
                                        <th>Name (Arabic)</th>
                                        <th>#Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="government-sortable">
                                    @foreach($partners->where('partner_type', 'government') as $index => $partner)
                                    <tr data-id="{{ $partner->id }}">
                                        <td class="text-center">
                                            <i class="fa fa-arrows-v text-muted" style="cursor: grab;"></i>
                                            <span class="ml-2 badge badge-secondary">{{ $partner->display_order ?? ($index + 1) }}</span>
                                        </td>
                                        <td>
                                            @if($partner->logo_english)
                                                <a data-lightbox="{{url('/storage'.$partner->logo_english)}}" href="{{url('/storage'.$partner->logo_english)}}">
                                                    <img style="width:50px; height: 50px; object-fit: contain;" src="{{url('/storage'.$partner->logo_english)}}" alt="Logo">
                                                </a>
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td>{{ $partner->name_english }}</td>
                                        <td>{{ $partner->name_arabic }}</td>
                                        <td>
                                            <a href="{{ route('partner.show', ['id' => $partner->id]) }}" class="btn btn-info btn-sm mr-1" title="View Profile">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <a href="{{ route('partner.edit', ['id' => $partner->id]) }}" class="btn btn-warning btn-sm mr-1" title="Edit">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{ $partner->id }}" title="Delete">
                                                <i class="fa fa-trash-o"></i>
                                            </button>
                                            
                                            <!-- Delete Modal -->
                                            <div class="modal fade" id="deleteModal{{ $partner->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <form action="{{ route('partner.delete', ['id' => $partner->id]) }}" method="POST">
                                                            @csrf
                                                            <div style="text-align: center;font-size: 25px;" class="modal-body">
                                                                <br>
                                                                <p>Are you Sure ?!</p><br><i style="color: #d9534f" class="fa fa-trash-o fa-5x"></i> 
                                                                <br><br><p>You Want to Delete This Government Partner</p>
                                                                <p><strong>{{ $partner->name_english }}</strong></p>
                                                            </div>
                                                            <br>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Cancel</button>
                                                                <button type="submit" class="btn btn-danger waves-effect waves-light"><i class="fa fa-trash-o"></i> Delete</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @if($partners->where('partner_type', 'government')->count() == 0)
                            <div class="text-center text-muted py-4">
                                <i class="fa fa-university fa-3x mb-3"></i>
                                <p>No government partners found. <a href="{{ route('partner.create') }}">Add one now</a>.</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
$(document).ready(function() {
    // Initialize sortable for partners
    var partnersSortable = document.getElementById('partners-sortable');
    if (partnersSortable) {
        new Sortable(partnersSortable, {
            animation: 150,
            handle: '.fa-arrows-v',
            ghostClass: 'bg-light',
            onEnd: function(evt) {
                updateOrder('partners-sortable');
            }
        });
    }
    
    // Initialize sortable for branches
    var branchesSortable = document.getElementById('branches-sortable');
    if (branchesSortable) {
        new Sortable(branchesSortable, {
            animation: 150,
            handle: '.fa-arrows-v',
            ghostClass: 'bg-light',
            onEnd: function(evt) {
                updateOrder('branches-sortable');
            }
        });
    }
    
    // Initialize sortable for government partners
    var governmentSortable = document.getElementById('government-sortable');
    if (governmentSortable) {
        new Sortable(governmentSortable, {
            animation: 150,
            handle: '.fa-arrows-v',
            ghostClass: 'bg-light',
            onEnd: function(evt) {
                updateOrder('government-sortable');
            }
        });
    }
    
    // Function to update order via AJAX
    function updateOrder(listId) {
        var orders = [];
        $('#' + listId + ' tr').each(function(index) {
            orders.push({
                id: $(this).data('id'),
                order: index + 1
            });
            // Update the badge display
            $(this).find('.badge-secondary').text(index + 1);
        });
        
        $.ajax({
            url: '{{ route("partner.update-order") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                orders: orders
            },
            success: function(response) {
                if (response.success) {
                    // Show a brief success notification
                    var notification = $('<div class="alert alert-success alert-dismissible fade show position-fixed" style="top: 20px; right: 20px; z-index: 9999; min-width: 250px;"><i class="fa fa-check-circle mr-2"></i>Order updated successfully!<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                    $('body').append(notification);
                    setTimeout(function() {
                        notification.fadeOut(function() {
                            $(this).remove();
                        });
                    }, 2000);
                }
            },
            error: function(xhr) {
                alert('Error updating order. Please try again.');
            }
        });
    }
});
</script>
@endsection

