@extends('admin::layouts.master')
@section('title', 'Trashed Project Types')
@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Basicdata')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a href="{{route('projecttype.index')}}" class="breadcrumbs__item"><i class="fa fa-list"></i> Project Types List</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-trash"></i> Trashed Project Types</a> 
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
                            Trashed Project Types</h4>
                        <div class="buttons">
                            <a href="{{ route('projecttype.index') }}" class="mr-2">
                                <button class="btn btn-new"><i class="fa fa-list"></i> Project Types List</button>
                            </a>
                            <button class="btn btn-primary" onclick="window.history.back()">
                                <i class="fa fa-angle-left"></i>
                                Back
                            </button>
                        </div>
                    </div>
                    <hr>
                    
                    @if(count($projectTypes) > 0)
                        <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name (English)</th>
                                    <th>Name (Arabic)</th>
                                    <th>Slug</th>
                                    <th>Deleted At</th>
                                    <th>#Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($projectTypes as $projectType)
                                <tr>
                                    <td>{{ $projectType->id }}</td>
                                    <td>{{ $projectType->name_english }}</td>
                                    <td>{{ $projectType->name_arabic }}</td>
                                    <td><span class="badge badge-info">{{ $projectType->slug }}</span></td>
                                    <td>{{ \Carbon\Carbon::parse($projectType->deleted_at)->format('M d, Y H:i') }}</td>
                                    <td>
                                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#restoreModal{{ $projectType->id }}" title="Restore">
                                            <i class="fa fa-undo"></i> Restore
                                        </button>
                                        
                                        <!-- Restore Modal -->
                                        <div class="modal fade" id="restoreModal{{ $projectType->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <form action="{{ route('projecttype.restore', ['id' => $projectType->id]) }}" method="POST">
                                                        @csrf
                                                        <div style="text-align: center;font-size: 25px;" class="modal-body">
                                                            <br>
                                                            <p>Restore Project Type?</p><br><i style="color: #28a745" class="fa fa-undo fa-5x"></i> 
                                                            <br><br><p>You Want to Restore This Project Type</p>
                                                            <p><strong>{{ $projectType->name_english }}</strong></p>
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
                            <i class="fa fa-info-circle"></i> No trashed project types found.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

