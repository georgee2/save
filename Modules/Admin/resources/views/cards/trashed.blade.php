@extends('admin::layouts.master')
@section('title', 'Trashed Cards')
@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Admin')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a href="{{route('card.index')}}" class="breadcrumbs__item"><i class="fa fa-id-card-o"></i> Cards List</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-trash"></i> Trashed Cards</a> 
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
                        <h4 class="mt-0 header-title align-self-center">Trashed Cards</h4>
                        <div class="buttons">
                            <a href="{{ route('card.index') }}" class="mr-2">
                                <button class="btn btn-new"><i class="fa fa-list"></i> Active Cards</button>
                            </a>
                            <button class="btn btn-primary" onclick="window.history.back()">
                                <i class="fa fa-angle-left"></i> Back
                            </button>
                        </div>
                    </div>
                    <hr>
                    
                    @if(count($cards) > 0)
                        <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Card Type</th>
                                    <th>Title (EN)</th>
                                    <th>Home Block</th>
                                    <th>Status</th>
                                    <th>Deleted At</th>
                                    <th>#Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cards as $card)
                                <tr>
                                    <td>{{ $card->id }}</td>
                                    <td>
                                        @if($card->card_type == 'card_with_background')
                                            <span class="badge badge-primary">Card with Background</span>
                                        @else
                                            <span class="badge badge-info">Icon Card</span>
                                        @endif
                                    </td>
                                    <td>{{ $card->title_english ?? 'N/A' }}</td>
                                    <td>{{ $card->home_block_title_en ?? 'N/A' }}</td>
                                    <td>
                                        @if($card->status == 0)
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-secondary">Not Active</span>
                                        @endif
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($card->deleted_at)->format('M d, Y') }}</td>
                                    <td>
                                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#restoreModal{{ $card->id }}" title="Restore">
                                            <i class="fa fa-undo"></i> Restore
                                        </button>
                                        
                                        <!-- Restore Modal -->
                                        <div class="modal fade" id="restoreModal{{ $card->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <form action="{{ route('card.restore', ['id' => $card->id]) }}" method="POST">
                                                        @csrf
                                                        <div style="text-align: center;font-size: 25px;" class="modal-body">
                                                            <br>
                                                            <p>Are you Sure ?!</p><br><i style="color: #28a745" class="fa fa-undo fa-5x"></i> 
                                                            <br><br><p>You Want to Restore This Card</p>
                                                            <p><strong>{{ $card->title_english ?? 'Card #' . $card->id }}</strong></p>
                                                        </div>
                                                        <br>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-success waves-effect waves-light"><i class="fa fa-undo"></i> Restore</button>
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
                    @else
                        <div class="alert alert-info text-center" role="alert">
                            <i class="fa fa-info-circle" style="font-size: 48px; margin-bottom: 15px;"></i>
                            <h5>No Trashed Cards Found</h5>
                            <p>There are no deleted cards at the moment.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

