@extends('admin::layouts.master')
@section('title', 'Team Members List')
@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Admin')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-users"></i> Team Members List</a> 
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
                        <h4 class="mt-0 header-title align-self-center">Team Members List</h4>
                        <div class="buttons">
                            <a href="{{ route('admin.team.create') }}" class="mr-2">
                                <button class="btn btn-new"><i class="fa fa-plus"></i> Add New Team Member</button>
                            </a>
                            <a href="{{ route('admin.team.trashed') }}" class="mr-2">
                                <button class="btn btn-danger"><i class="fa fa-trash"></i> Trashed Members</button>
                            </a>
                            <button class="btn btn-primary" onclick="window.history.back()">
                                <i class="fa fa-angle-left"></i> Back
                            </button>
                        </div>
                    </div>
                    <hr>
                    
                    <!-- Nav tabs for Team Members and Board -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#allMembers" role="tab">
                                <i class="fa fa-users"></i> All Members ({{ count($teams) }})
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#regularOrder" role="tab">
                                <i class="fa fa-sort"></i> Regular Members Order ({{ count($regularMembers) }})
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#boardOrder" role="tab">
                                <i class="fa fa-star"></i> Board of Directors Order ({{ count($boardMembers) }})
                            </a>
                        </li>
                    </ul>
                    
                    <div class="tab-content mt-3">
                        <!-- All Members Tab -->
                        <div class="tab-pane fade show active" id="allMembers" role="tabpanel">
                    
                    <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Name (English)</th>
                                <th>Name (Arabic)</th>
                                <th>Job Title</th>
                                <th>Rank</th>
                                <th>Board</th>
                                <th>Email</th>
                                <th>Created At</th>
                                <th>#Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($teams as $team)
                            <tr>
                                <td>{{ $team->id }}</td>
                                <td>
                                    @if($team->main_image)
                                        <a data-lightbox="{{url('/storage'.$team->main_image)}}" href="{{url('/storage'.$team->main_image)}}">
                                            <img style="width:50px; height: 50px; object-fit: cover; border-radius: 50%;" src="{{url('/storage'.$team->main_image)}}" alt="Team Member">
                                        </a>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td>{{ $team->name_english }}</td>
                                <td>{{ $team->name_arabic }}</td>
                                <td>{{ $team->job_title_english ?? 'N/A' }}</td>
                                <td>{{ $team->rank_english ?? 'N/A' }}</td>
                                <td>
                                    @if($team->is_board_director)
                                        <span class="badge badge-success"><i class="fa fa-star"></i> Board</span>
                                    @else
                                        <span class="badge badge-secondary">Regular</span>
                                    @endif
                                </td>
                                <td>{{ $team->email }}</td>
                                <td>{{ \Carbon\Carbon::parse($team->created_at)->format('M d, Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.team.show', ['id' => $team->id]) }}" class="btn btn-info btn-sm mr-2" title="View Details">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.team.edit', ['id' => $team->id]) }}" class="btn btn-warning btn-sm mr-2" title="Edit">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    
                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{ $team->id }}" title="Delete">
                                        <i class="fa fa-trash-o"></i>
                                    </button>
                                    
                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteModal{{ $team->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <form action="{{ route('admin.team.delete', ['id' => $team->id]) }}" method="POST">
                                                    @csrf
                                                    <div style="text-align: center;font-size: 25px;" class="modal-body">
                                                        <br>
                                                        <p>Are you Sure ?!</p><br><i style="color: #d9534f" class="fa fa-trash-o fa-5x"></i> 
                                                        <br><br><p>You Want to Delete This Team Member</p>
                                                        <p><strong>{{ $team->name_english }}</strong></p>
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
                        </div>
                        <!-- End All Members Tab -->
                        
                        <!-- Regular Members Order Tab -->
                        <div class="tab-pane fade" id="regularOrder" role="tabpanel">
                            <div class="alert alert-info">
                                <i class="fa fa-info-circle"></i> Drag and drop to reorder regular team members. Changes are saved automatically.
                            </div>
                            <div id="regularMembersList" class="sortable-list">
                                @foreach($regularMembers as $index => $member)
                                <div class="sortable-item card mb-2" data-id="{{ $member->id }}">
                                    <div class="card-body d-flex align-items-center py-2">
                                        <span class="drag-handle mr-3" style="cursor: move; font-size: 18px;">
                                            <i class="fa fa-bars text-muted"></i>
                                        </span>
                                        <span class="badge badge-primary mr-3" style="min-width: 30px;">{{ $index + 1 }}</span>
                                        @if($member->main_image)
                                            <img style="width:40px; height: 40px; object-fit: cover; border-radius: 50%;" src="{{url('/storage'.$member->main_image)}}" alt="Team Member" class="mr-3">
                                        @else
                                            <div style="width:40px; height: 40px; border-radius: 50%; background: #eee; display: flex; align-items: center; justify-content: center;" class="mr-3">
                                                <i class="fa fa-user text-muted"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <strong>{{ $member->name_english }}</strong>
                                            <br><small class="text-muted">{{ $member->job_title_english }} - {{ $member->rank_english }}</small>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @if(count($regularMembers) == 0)
                                <div class="alert alert-warning">
                                    <i class="fa fa-exclamation-triangle"></i> No regular team members found.
                                </div>
                            @endif
                        </div>
                        <!-- End Regular Members Order Tab -->
                        
                        <!-- Board of Directors Order Tab -->
                        <div class="tab-pane fade" id="boardOrder" role="tabpanel">
                            <div class="alert alert-info">
                                <i class="fa fa-info-circle"></i> Drag and drop to reorder board of directors. Changes are saved automatically.
                            </div>
                            <div id="boardMembersList" class="sortable-list">
                                @foreach($boardMembers as $index => $member)
                                <div class="sortable-item card mb-2" data-id="{{ $member->id }}">
                                    <div class="card-body d-flex align-items-center py-2">
                                        <span class="drag-handle mr-3" style="cursor: move; font-size: 18px;">
                                            <i class="fa fa-bars text-muted"></i>
                                        </span>
                                        <span class="badge badge-success mr-3" style="min-width: 30px;">{{ $index + 1 }}</span>
                                        @if($member->main_image)
                                            <img style="width:40px; height: 40px; object-fit: cover; border-radius: 50%;" src="{{url('/storage'.$member->main_image)}}" alt="Team Member" class="mr-3">
                                        @else
                                            <div style="width:40px; height: 40px; border-radius: 50%; background: #eee; display: flex; align-items: center; justify-content: center;" class="mr-3">
                                                <i class="fa fa-user text-muted"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <strong>{{ $member->name_english }}</strong> <span class="badge badge-success ml-2"><i class="fa fa-star"></i> Board</span>
                                            <br><small class="text-muted">{{ $member->job_title_english }} - {{ $member->rank_english }}</small>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @if(count($boardMembers) == 0)
                                <div class="alert alert-warning">
                                    <i class="fa fa-exclamation-triangle"></i> No board of directors members found.
                                </div>
                            @endif
                        </div>
                        <!-- End Board of Directors Order Tab -->
                        
                    </div>
                    <!-- End Tab Content -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
<style>
    .sortable-item {
        transition: all 0.2s ease;
        border: 1px solid #e9ecef;
    }
    .sortable-item:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .sortable-item.sortable-ghost {
        opacity: 0.4;
        background: #f8f9fa;
    }
    .sortable-item.sortable-chosen {
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    .drag-handle:hover i {
        color: #333 !important;
    }
    .nav-tabs .nav-link.active {
        font-weight: 600;
        border-bottom: 3px solid #007bff;
    }
</style>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
$(document).ready(function() {
    // Initialize Sortable for Regular Members
    var regularList = document.getElementById('regularMembersList');
    if (regularList) {
        new Sortable(regularList, {
            animation: 150,
            handle: '.drag-handle',
            ghostClass: 'sortable-ghost',
            chosenClass: 'sortable-chosen',
            onEnd: function(evt) {
                updateRegularOrder();
            }
        });
    }
    
    // Initialize Sortable for Board Members
    var boardList = document.getElementById('boardMembersList');
    if (boardList) {
        new Sortable(boardList, {
            animation: 150,
            handle: '.drag-handle',
            ghostClass: 'sortable-ghost',
            chosenClass: 'sortable-chosen',
            onEnd: function(evt) {
                updateBoardOrder();
            }
        });
    }
    
    // Update Regular Members Order
    function updateRegularOrder() {
        var orders = [];
        $('#regularMembersList .sortable-item').each(function(index) {
            orders.push({
                id: $(this).data('id'),
                position: index + 1
            });
            // Update badge number
            $(this).find('.badge-primary').text(index + 1);
        });
        
        $.ajax({
            url: '{{ route("admin.team.update-display-order") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                orders: orders
            },
            success: function(response) {
                // Optional: show toast/notification
                console.log('Display order updated');
            },
            error: function(xhr) {
                console.error('Error updating display order');
            }
        });
    }
    
    // Update Board Members Order
    function updateBoardOrder() {
        var orders = [];
        $('#boardMembersList .sortable-item').each(function(index) {
            orders.push({
                id: $(this).data('id'),
                position: index + 1
            });
            // Update badge number
            $(this).find('.badge-success').first().text(index + 1);
        });
        
        $.ajax({
            url: '{{ route("admin.team.update-board-order") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                orders: orders
            },
            success: function(response) {
                // Optional: show toast/notification
                console.log('Board order updated');
            },
            error: function(xhr) {
                console.error('Error updating board order');
            }
        });
    }
});
</script>
@endsection

