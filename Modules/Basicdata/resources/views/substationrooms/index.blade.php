@extends('admin::layouts.master')
@section('title', 'Substation Rooms List')
@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        <nav class="breadcrumbs">
            <a href="{{route('Basicdata')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-list"></i> Substation Rooms List</a> 
        </nav>
        <div class="col-12 mx-auto">
            <hr>
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert" style="border-left: 4px solid #28a745; font-size: 16px; padding: 15px 20px;">
                    <i class="fa fa-check-circle" style="font-size: 20px;"></i> <strong>Success!</strong> {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
            @endif
            <div class="card m-b-20">
                <div class="card-body">
                    <div class="title d-flex justify-content-between">
                        <h4 class="mt-0 mb-0 header-title align-self-center text-capitalize">Substation Rooms List</h4>
                        <div class="buttons">
                            <a href="{{ route('substationroom.create') }}" class="mr-2"><button class="btn btn-new"><i class="fa fa-plus"></i> Add New Room</button></a>
                            <a href="{{ route('substationroom.trashed') }}" class="mr-2"><button class="btn btn-danger"><i class="fa fa-trash"></i> Trashed Rooms</button></a>
                            <button class="btn btn-primary" onclick="window.history.back()"><i class="fa fa-angle-left"></i> Back</button>
                        </div>
                    </div>
                    <hr>
                    @if(count($rooms) > 0)
                        <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr><th>ID</th><th>Project Type</th><th>Name (English)</th><th>Name (Arabic)</th><th>Price</th><th>Created At</th><th>#Actions</th></tr>
                            </thead>
                            <tbody>
                                @foreach($rooms as $room)
                            <tr>
                                <td>{{ $room->id }}</td>
                                <td>
                                    @if($room->project_type_name)
                                        <span class="badge badge-primary">{{ $room->project_type_name }}</span>
                                    @else
                                        <span class="badge badge-secondary">N/A</span>
                                    @endif
                                </td>
                                <td>{{ $room->name_english }}</td>
                                <td>{{ $room->name_arabic }}</td>
                                <td><span class="badge badge-success">${{ number_format($room->price, 2) }}</span></td>
                                <td>{{ \Carbon\Carbon::parse($room->created_at)->format('M d, Y') }}</td>
                                <td>
                                    <a href="{{ route('substationroom.edit', ['id' => $room->id]) }}" class="btn btn-warning btn-sm mr-2" title="Edit"><i class="fa fa-pencil"></i></a>
                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{ $room->id }}" title="Delete"><i class="fa fa-trash-o"></i></button>
                                    <div class="modal fade" id="deleteModal{{ $room->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <form action="{{ route('substationroom.delete', ['id' => $room->id]) }}" method="POST">
                                                    @csrf
                                                    <div style="text-align: center;font-size: 25px;" class="modal-body">
                                                        <br><p>Are you Sure ?!</p><br><i style="color: #d9534f" class="fa fa-trash-o fa-5x"></i> 
                                                        <br><br><p>You Want to Delete This Substation Room</p><p><strong>{{ $room->name_english }}</strong></p>
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
                    @else
                        <div class="alert alert-info">
                            <i class="fa fa-info-circle"></i> No substation rooms found. Click "Add New Room" to create your first substation room.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

