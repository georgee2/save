@extends('admin::layouts.master')
@section('title', 'Trashed Offer Categories')
@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Basicdata')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a href="{{route('offercategory.index')}}" class="breadcrumbs__item"><i class="fa fa-list"></i> Offer Categories List</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-trash"></i> Trashed Categories</a> 
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
            
            <div class="card m-b-20">
                <div class="card-body">
                    <div class="title d-flex justify-content-between">
                        <h4 class="mt-0 mb-0 header-title align-self-center text-capitalize">
                            Trashed Offer Categories</h4>
                        <div class="buttons">
                            <a href="{{ route('offercategory.index') }}" class="mr-2">
                                <button class="btn btn-new"><i class="fa fa-list"></i> Offer Categories List</button>
                            </a>
                            <button class="btn btn-primary" onclick="window.history.back()">
                                <i class="fa fa-angle-left"></i>
                                Back
                            </button>
                        </div>
                    </div>
                    <hr>
                    
                    @if(count($categories) > 0)
                        <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title (English)</th>
                                    <th>Title (Arabic)</th>
                                    <th>Slug</th>
                                    <th>Deleted At</th>
                                    <th>#Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categories as $category)
                                <tr>
                                    <td>{{ $category->id }}</td>
                                    <td>{{ $category->title_english }}</td>
                                    <td>{{ $category->title_arabic }}</td>
                                    <td><span class="badge badge-info">{{ $category->slug }}</span></td>
                                    <td>{{ \Carbon\Carbon::parse($category->deleted_at)->format('M d, Y H:i') }}</td>
                                    <td>
                                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#restoreModal{{ $category->id }}" title="Restore">
                                            <i class="fa fa-undo"></i> Restore
                                        </button>
                                        
                                        <!-- Restore Modal -->
                                        <div class="modal fade" id="restoreModal{{ $category->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <form action="{{ route('offercategory.restore', ['id' => $category->id]) }}" method="POST">
                                                        @csrf
                                                        <div style="text-align: center;font-size: 25px;" class="modal-body">
                                                            <br>
                                                            <p>Restore Offer Category?</p><br><i style="color: #28a745" class="fa fa-undo fa-5x"></i> 
                                                            <br><br><p>You Want to Restore This Category</p>
                                                            <p><strong>{{ $category->title_english }}</strong></p>
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
                        <div class="alert alert-info">
                            <i class="fa fa-info-circle"></i> No trashed offer categories found.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

