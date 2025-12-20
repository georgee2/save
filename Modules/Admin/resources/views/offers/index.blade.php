@extends('admin::layouts.master')
@section('title', 'Offers List')
@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Admin')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-tag"></i> Offers List</a> 
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
                        <h4 class="mt-0 header-title align-self-center">Offers List</h4>
                        <div class="buttons">
                            <a href="{{ route('offer.create') }}" class="mr-2">
                                <button class="btn btn-new"><i class="fa fa-plus"></i> Add New Offer</button>
                            </a>
                            <a href="{{ route('offer.trashed') }}" class="mr-2">
                                <button class="btn btn-danger"><i class="fa fa-trash"></i> Trashed Offers</button>
                            </a>
                            <button class="btn btn-primary" onclick="window.history.back()">
                                <i class="fa fa-angle-left"></i> Back
                            </button>
                        </div>
                    </div>
                    <hr>
                    
                    <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title (English)</th>
                                <th>Title (Arabic)</th>
                                <th>Category</th>
                                <th>Type</th>
                                <th>Publish Status</th>
                                <th>Home Status</th>
                                <th>Created At</th>
                                <th>#Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($offers as $offer)
                            <tr>
                                <td>{{ $offer->id }}</td>
                                <td>{{ $offer->title_english }}</td>
                                <td>{{ $offer->title_arabic }}</td>
                                <td>
                                    @if($offer->category_name)
                                        <span class="badge badge-primary">{{ $offer->category_name }}</span>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    @if($offer->type_name)
                                        <span class="badge badge-info">{{ $offer->type_name }}</span>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    @if($offer->publish_status == 0)
                                        <span class="badge badge-success"><i class="fa fa-check-circle"></i> Published</span>
                                    @else
                                        <span class="badge badge-danger"><i class="fa fa-times-circle"></i> Unpublished</span>
                                    @endif
                                </td>
                                <td>
                                    @if($offer->home_status == 0)
                                        <span class="badge badge-success"><i class="fa fa-eye"></i> Shown</span>
                                    @else
                                        <span class="badge badge-warning"><i class="fa fa-eye-slash"></i> Hidden</span>
                                    @endif
                                </td>
                                <td>{{ \Carbon\Carbon::parse($offer->created_at)->format('M d, Y') }}</td>
                                <td>
                                    <a href="{{ route('offer.show', ['id' => $offer->id]) }}" class="btn btn-info btn-sm mr-2" title="View">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a href="{{ route('offer.edit', ['id' => $offer->id]) }}" class="btn btn-warning btn-sm mr-2" title="Edit">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    
                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{ $offer->id }}" title="Delete">
                                        <i class="fa fa-trash-o"></i>
                                    </button>
                                    
                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteModal{{ $offer->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <form action="{{ route('offer.delete', ['id' => $offer->id]) }}" method="POST">
                                                    @csrf
                                                    <div style="text-align: center;font-size: 25px;" class="modal-body">
                                                        <br>
                                                        <p>Are you Sure ?!</p><br><i style="color: #d9534f" class="fa fa-trash-o fa-5x"></i> 
                                                        <br><br><p>You Want to Delete This Offer</p>
                                                        <p><strong>{{ $offer->title_english }}</strong></p>
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
            </div>
        </div>
    </div>
</div>
@endsection

