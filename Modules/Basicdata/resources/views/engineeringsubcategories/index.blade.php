@extends('admin::layouts.master')
@section('title', 'Engineering Sub Categories List')
@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Basicdata')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-list"></i> Eng.Sub Categories List</a> 
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
                            Engineering Sub Categories List</h4>
                        <div class="buttons">
                            <a href="{{ route('engineeringsubcategory.create') }}" class="mr-2">
                                <button class="btn btn-new"><i class="fa fa-plus"></i> Add New Sub Category</button>
                            </a>
                            <a href="{{ route('engineeringsubcategory.trashed') }}" class="mr-2">
                                <button class="btn btn-danger"><i class="fa fa-trash"></i> Trashed Sub Categories</button>
                            </a>
                            <button class="btn btn-primary" onclick="window.history.back()">
                                <i class="fa fa-angle-left"></i>
                                Back
                            </button>
                        </div>
                    </div>
                    <hr>
                    
                    @if(count($subCategories) > 0)
                        <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Category</th>
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
                                @foreach($subCategories as $subCategory)
                            <tr>
                                <td>{{ $subCategory->id }}</td>
                                <td><span class="badge badge-primary">{{ $subCategory->category_name }}</span></td>
                                <td>{{ $subCategory->title_english }}</td>
                                <td>{{ $subCategory->title_arabic }}</td>
                                <td>{{ \Illuminate\Support\Str::limit($subCategory->bio_english, 50) }}</td>
                                <td>
                                    @if($subCategory->icon)
                                        <a data-lightbox="{{url('/storage'.$subCategory->icon)}}" href="{{url('/storage'.$subCategory->icon)}}">
                                            <img style="width:40px; height: 40px; object-fit: contain;" src="{{url('/storage'.$subCategory->icon)}}" alt="Icon">
                                        </a>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    @if($subCategory->image)
                                        <a data-lightbox="{{url('/storage'.$subCategory->image)}}" href="{{url('/storage'.$subCategory->image)}}">
                                            <img style="width:80px; height: 60px; object-fit: cover;" src="{{url('/storage'.$subCategory->image)}}" alt="Image">
                                        </a>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td><span class="badge badge-info">{{ $subCategory->slug }}</span></td>
                                <td>{{ \Carbon\Carbon::parse($subCategory->created_at)->format('M d, Y') }}</td>
                                <td>
                                    <a href="{{ route('engineeringsubcategory.show', ['id' => $subCategory->id]) }}" class="btn btn-primary btn-sm mr-2" title="Show">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    
                                    <a href="{{ route('engineeringsubcategory.edit', ['id' => $subCategory->id]) }}" class="btn btn-warning btn-sm mr-2" title="Edit">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    
                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{ $subCategory->id }}" title="Delete">
                                        <i class="fa fa-trash-o"></i>
                                    </button>
                                    
                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteModal{{ $subCategory->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <form action="{{ route('engineeringsubcategory.delete', ['id' => $subCategory->id]) }}" method="POST">
                                                    @csrf
                                                    <div style="text-align: center;font-size: 25px;" class="modal-body">
                                                        <br>
                                                        <p>Are you Sure ?!</p><br><i style="color: #d9534f" class="fa fa-trash-o fa-5x"></i> 
                                                        <br><br><p>You Want to Delete This Sub Category</p>
                                                        <p><strong>{{ $subCategory->title_english }}</strong></p>
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
                            <i class="fa fa-info-circle"></i> No engineering subcategories found. Click "Add New Subcategory" to create your first engineering subcategory.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

