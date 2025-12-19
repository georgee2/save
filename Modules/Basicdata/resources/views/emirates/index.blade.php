@extends('admin::layouts.master')
@section('title', 'Emirates List')
@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Basicdata')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-list"></i> Emirates List</a> 
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
                            Emirates List</h4>
                        <div class="buttons">
                            <a href="{{ route('emirate.create') }}" class="mr-2">
                                <button class="btn btn-new"><i class="fa fa-plus"></i> Add New Emirate</button>
                            </a>
                            <a href="{{ route('emirate.trashed') }}" class="mr-2">
                                <button class="btn btn-danger"><i class="fa fa-trash"></i> Trashed Emirates</button>
                            </a>
                            <button class="btn btn-primary" onclick="window.history.back()">
                                <i class="fa fa-angle-left"></i>
                                Back
                            </button>
                        </div>
                    </div>
                    <hr>
                    
                    @if(count($emirates) > 0)
                        <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title (English)</th>
                                    <th>Title (Arabic)</th>
                                    <th>Bio (English)</th>
                                    <th>Icon</th>
                                    <th>Image</th>
                                    <th>Slug</th>
                                    <th>Created At</th>
                                    <th>#Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($emirates as $emirate)
                            <tr>
                                <td>{{ $emirate->id }}</td>
                                <td>{{ $emirate->title_english }}</td>
                                <td>{{ $emirate->title_arabic }}</td>
                                <td>{{ \Illuminate\Support\Str::limit($emirate->bio_english, 50) }}</td>
                                <td>
                                    @if($emirate->icon)
                                        <a data-lightbox="{{url('/storage'.$emirate->icon)}}" href="{{url('/storage'.$emirate->icon)}}">
                                            <img style="width:40px; height: 50px; object-fit: cover;" src="{{url('/storage'.$emirate->icon)}}" alt="Icon">
                                        </a>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    @if($emirate->image)
                                        <a data-lightbox="{{url('/storage'.$emirate->image)}}" href="{{url('/storage'.$emirate->image)}}">
                                            <img style="width:80px; height: 60px; object-fit: cover;" src="{{url('/storage'.$emirate->image)}}" alt="Image">
                                        </a>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td><span class="badge badge-info">{{ $emirate->slug }}</span></td>
                                <td>{{ \Carbon\Carbon::parse($emirate->created_at)->format('M d, Y') }}</td>
                                <td>
                                    <a href="{{ route('emirate.show', ['id' => $emirate->id]) }}" class="btn btn-primary btn-sm mr-2" title="Show">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    
                                    <a href="{{ route('emirate.edit', ['id' => $emirate->id]) }}" class="btn btn-warning btn-sm mr-2" title="Edit">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    
                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{ $emirate->id }}" title="Delete">
                                        <i class="fa fa-trash-o"></i>
                                    </button>
                                    
                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteModal{{ $emirate->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <form action="{{ route('emirate.delete', ['id' => $emirate->id]) }}" method="POST">
                                                    @csrf
                                                    <div style="text-align: center;font-size: 25px;" class="modal-body">
                                                        <br>
                                                        <p>Are you Sure ?!</p><br><i style="color: #d9534f" class="fa fa-trash-o fa-5x"></i> 
                                                        <br><br><p>You Want to Delete This Emirate</p>
                                                        <p><strong>{{ $emirate->title_english }}</strong></p>
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
                            <i class="fa fa-info-circle"></i> No emirates found. Click "Add New Emirate" to create your first emirate.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

