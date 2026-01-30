@extends('admin::layouts.master')
@section('title', 'Interior Design Gallery List')
@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Admin')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-list"></i> Interior Design Gallery List</a> 
        </nav>

        <div class="col-12 mx-auto">
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
            
            <div class="card m-b-20">
                <div class="card-body">
                    <div class="title d-flex justify-content-between">
                        <h4 class="mt-0 mb-0 header-title align-self-center text-capitalize">
                            Interior Design Gallery List</h4>
                        <div class="buttons">
                            <a href="{{ route('interior-design-gallery.create') }}" class="mr-2">
                                <button class="btn btn-new"><i class="fa fa-plus"></i> Add New Gallery</button>
                            </a>
                            <a href="{{ route('interior-design-gallery.trashed') }}" class="mr-2">
                                <button class="btn btn-danger"><i class="fa fa-trash"></i> Trashed Galleries</button>
                            </a>
                            <button class="btn btn-primary" onclick="window.history.back()">
                                <i class="fa fa-angle-left"></i>
                                Back
                            </button>
                        </div>
                    </div>
                    <hr>
                    
                    @if(count($galleries) > 0)
                        <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Order</th>
                                    <th>Image</th>
                                    <th>Title (English)</th>
                                    <th>Category</th>
                                    <th>Project Type</th>
                                    <th>Publish</th>
                                    <th>Home</th>
                                    <th>Created At</th>
                                    <th>#Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($galleries as $gallery)
                            <tr>
                                <td><span class="badge badge-dark">{{ $gallery->ordering }}</span></td>
                                <td>
                                    @if($gallery->image)
                                        <a data-lightbox="{{url('/storage'.$gallery->image)}}" href="{{url('/storage'.$gallery->image)}}">
                                            <img style="width:100px; height: 56px; object-fit: cover; border-radius: 4px;" src="{{url('/storage'.$gallery->image)}}" alt="Image">
                                        </a>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td>{{ $gallery->title_english }}</td>
                                <td><span class="badge badge-primary">{{ $gallery->category_name ?? 'N/A' }}</span></td>
                                <td><span class="badge badge-info">{{ $gallery->type_name ?? 'N/A' }}</span></td>
                                <td>
                                    <form action="{{ route('interior-design-gallery.toggle-publish', ['id' => $gallery->id]) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @if($gallery->publish_status == 0)
                                            <button type="submit" class="btn btn-success btn-sm" title="Published - Click to Unpublish">
                                                <i class="fa fa-check"></i>
                                            </button>
                                        @else
                                            <button type="submit" class="btn btn-secondary btn-sm" title="Unpublished - Click to Publish">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        @endif
                                    </form>
                                </td>
                                <td>
                                    <form action="{{ route('interior-design-gallery.toggle-home', ['id' => $gallery->id]) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @if($gallery->home_status == 0)
                                            <button type="submit" class="btn btn-success btn-sm" title="Shown on Home - Click to Hide">
                                                <i class="fa fa-home"></i>
                                            </button>
                                        @else
                                            <button type="submit" class="btn btn-secondary btn-sm" title="Hidden from Home - Click to Show">
                                                <i class="fa fa-eye-slash"></i>
                                            </button>
                                        @endif
                                    </form>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($gallery->created_at)->format('M d, Y') }}</td>
                                <td>
                                    <a href="{{ route('interior-design-gallery.show', ['id' => $gallery->id]) }}" class="btn btn-primary btn-sm mr-1" title="Show">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    
                                    <a href="{{ route('interior-design-gallery.edit', ['id' => $gallery->id]) }}" class="btn btn-warning btn-sm mr-1" title="Edit">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    
                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{ $gallery->id }}" title="Delete">
                                        <i class="fa fa-trash-o"></i>
                                    </button>
                                    
                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteModal{{ $gallery->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <form action="{{ route('interior-design-gallery.delete', ['id' => $gallery->id]) }}" method="POST">
                                                    @csrf
                                                    <div style="text-align: center;font-size: 25px;" class="modal-body">
                                                        <br>
                                                        <p>Are you Sure ?!</p><br><i style="color: #d9534f" class="fa fa-trash-o fa-5x"></i> 
                                                        <br><br><p>You Want to Delete This Gallery Item</p>
                                                        <p><strong>{{ $gallery->title_english }}</strong></p>
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
                            <i class="fa fa-info-circle"></i> No interior design galleries found. Click "Add New Gallery" to create your first gallery item.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
