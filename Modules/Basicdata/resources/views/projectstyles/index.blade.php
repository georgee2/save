@extends('admin::layouts.master')
@section('title', 'Project Styles List')
@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Basicdata')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-list"></i> Project Styles List</a> 
        </nav>

        <div class="col-12 mx-auto">
            <hr>
            
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert" style="border-left: 4px solid #28a745; font-size: 16px; padding: 15px 20px;">
                    <i class="fa fa-check-circle" style="font-size: 20px;"></i> <strong>Success!</strong> {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            
            <div class="card m-b-20">
                <div class="card-body">
                    <div class="title d-flex justify-content-between">
                        <h4 class="mt-0 mb-0 header-title align-self-center text-capitalize">
                            Project Styles List</h4>
                        <div class="buttons">
                            <a href="{{ route('projectstyle.create') }}" class="mr-2">
                                <button class="btn btn-new"><i class="fa fa-plus"></i> Add New Project Style</button>
                            </a>
                            <a href="{{ route('projectstyle.trashed') }}" class="mr-2">
                                <button class="btn btn-danger"><i class="fa fa-trash"></i> Trashed Styles</button>
                            </a>
                            <button class="btn btn-primary" onclick="window.history.back()">
                                <i class="fa fa-angle-left"></i>
                                Back
                            </button>
                        </div>
                    </div>
                    <hr>
                    
                    @if(count($projectStyles) > 0)
                        <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title (English)</th>
                                    <th>Title (Arabic)</th>
                                    <th>Icon</th>
                                    <th>Image</th>
                                    <th>Slug</th>
                                    <th>Created At</th>
                                    <th>#Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($projectStyles as $style)
                            <tr>
                                <td>{{ $style->id }}</td>
                                <td>{{ $style->title_english }}</td>
                                <td>{{ $style->title_arabic }}</td>
                                <td>
                                    @if($style->icon)
                                        <a data-lightbox="{{url('/storage'.$style->icon)}}" href="{{url('/storage'.$style->icon)}}">
                                            <img style="width:40px; height: 40px; object-fit: contain;" src="{{url('/storage'.$style->icon)}}" alt="Icon">
                                        </a>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    @if($style->image)
                                        <a data-lightbox="{{url('/storage'.$style->image)}}" href="{{url('/storage'.$style->image)}}">
                                            <img style="width:80px; height: 60px; object-fit: cover;" src="{{url('/storage'.$style->image)}}" alt="Image">
                                        </a>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td><span class="badge badge-info">{{ $style->slug }}</span></td>
                                <td>{{ \Carbon\Carbon::parse($style->created_at)->format('M d, Y') }}</td>
                                <td>
                                    <a href="{{ route('projectstyle.edit', ['id' => $style->id]) }}" class="btn btn-warning btn-sm mr-2" title="Edit">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    
                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{ $style->id }}" title="Delete">
                                        <i class="fa fa-trash-o"></i>
                                    </button>
                                    
                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteModal{{ $style->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <form action="{{ route('projectstyle.delete', ['id' => $style->id]) }}" method="POST">
                                                    @csrf
                                                    <div style="text-align: center;font-size: 25px;" class="modal-body">
                                                        <br>
                                                        <p>Are you Sure ?!</p><br><i style="color: #d9534f" class="fa fa-trash-o fa-5x"></i> 
                                                        <br><br><p>You Want to Delete This Project Style</p>
                                                        <p><strong>{{ $style->title_english }}</strong></p>
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
                            <i class="fa fa-info-circle"></i> No project styles found. Click "Add New Style" to create your first project style.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

