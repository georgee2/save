@extends('admin::layouts.master')
@section('title', 'Jobs Postings List')
@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('CRM')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-list"></i> Jobs Postings List</a> 
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
                            Jobs Postings List</h4>
                        <div class="buttons">
                            <a href="{{ route('jobs-posting.create') }}" class="mr-2">
                                <button class="btn btn-new"><i class="fa fa-plus"></i> Add New Job Posting</button>
                            </a>
                            <a href="{{ route('jobs-posting.trashed') }}" class="mr-2">
                                <button class="btn btn-danger"><i class="fa fa-trash"></i> Trashed Jobs</button>
                            </a>
                            <button class="btn btn-primary" onclick="window.history.back()">
                                <i class="fa fa-angle-left"></i>
                                Back
                            </button>
                        </div>
                    </div>
                    <hr>
                    
                    @if(count($jobsPostings) > 0)
                        <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Job Title</th>
                                    <th>Category</th>
                                    <th>Job Type</th>
                                    <th>Registration Period</th>
                                    <th>Status</th>
                                    <th>#Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($jobsPostings as $job)
                            <tr>
                                <td><strong>{{ $job->code }}</strong></td>
                                <td>{{ App::getLocale() == 'en' ? $job->job_title_english : $job->job_title_arabic }}</td>
                                <td>{{ App::getLocale() == 'en' ? $job->job_category_english : $job->job_category_arabic }}</td>
                                <td><span class="badge badge-info">{{ $job->job_type }}</span></td>
                                <td>
                                    <small>
                                        {{ \Carbon\Carbon::parse($job->registration_start_date)->format('M d, Y') }} - 
                                        {{ \Carbon\Carbon::parse($job->registration_end_date)->format('M d, Y') }}
                                    </small>
                                </td>
                                <td>
                                    @if($job->status == 'Publish')
                                        <span class="badge badge-success">Published</span>
                                    @else
                                        <span class="badge badge-secondary">Not Published</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('jobs-posting.show', ['id' => $job->id]) }}" class="btn btn-info btn-sm mr-1" title="View">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a href="{{ route('jobs-posting.edit', ['id' => $job->id]) }}" class="btn btn-warning btn-sm mr-1" title="Edit">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    
                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{ $job->id }}" title="Delete">
                                        <i class="fa fa-trash-o"></i>
                                    </button>
                                    
                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteModal{{ $job->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <form action="{{ route('jobs-posting.delete', ['id' => $job->id]) }}" method="POST">
                                                    @csrf
                                                    <div style="text-align: center;font-size: 25px;" class="modal-body">
                                                        <br>
                                                        <p>Are you Sure ?!</p><br><i style="color: #d9534f" class="fa fa-trash-o fa-5x"></i> 
                                                        <br><br><p>You Want to Delete This Job Posting</p>
                                                        <p><strong>{{ $job->code }}</strong></p>
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
                            <i class="fa fa-info-circle"></i> No jobs postings found. Click "Add New Job Posting" to create your first job posting.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

