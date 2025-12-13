@extends('admin::layouts.master')
@section('title', 'View Job Posting')
@section('css')
<style>
    .border-left-primary {
        border-left: 4px solid #4e73df !important;
    }
    .border-left-success {
        border-left: 4px solid #1cc88a !important;
    }
    .border-left-info {
        border-left: 4px solid #36b9cc !important;
    }
    .border-left-warning {
        border-left: 4px solid #f6c23e !important;
    }
    .border-left-danger {
        border-left: 4px solid #e74a3b !important;
    }
    .border-left-secondary {
        border-left: 4px solid #858796 !important;
    }
    .text-gray-300 {
        color: #dddfeb !important;
    }
    .text-gray-800 {
        color: #5a5c69 !important;
    }
    .shadow-sm {
        box-shadow: 0 0.125rem 0.25rem 0 rgba(58, 59, 69, 0.2) !important;
    }
    .card {
        transition: all 0.3s ease;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem 0 rgba(58, 59, 69, 0.3) !important;
    }
    .text-xs {
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 0.5px;
    }
</style>
@endsection
@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('CRM')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a href="{{route('jobs-posting.index')}}" class="breadcrumbs__item"><i class="fa fa-list"></i> Jobs Postings List</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-eye"></i> View Job Posting</a> 
        </nav>

        <div class="col-12 mx-auto">
            <hr>
            <div class="card m-b-20">
                <div class="card-body">
                    <div class="title d-flex justify-content-between">
                        <h4 class="mt-0 mb-0 header-title align-self-center text-capitalize">Job Posting Details</h4>
                        <div class="buttons">
                            <a href="{{ route('jobs-posting.edit', ['id' => $jobPosting->id]) }}" class="mr-2">
                                <button class="btn btn-warning"><i class="fa fa-pencil"></i> Edit</button>
                            </a>
                            <a href="{{ route('jobs-posting.index') }}" class="mr-2">
                                <button class="btn btn-new"><i class="fa fa-list"></i> Jobs Postings List</button>
                            </a>
                            <button class="btn btn-primary" onclick="window.history.back()">
                                <i class="fa fa-angle-left"></i>
                                Back
                            </button>
                        </div>
                    </div>
                    <hr>

                    <!-- Basic Information -->
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="text-primary mb-4"><i class="fa fa-info-circle"></i> Basic Information</h5>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card border-left-primary shadow-sm h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Job Code</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jobPosting->code }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa fa-barcode fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card border-left-info shadow-sm h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Job Title</div>
                                            <div class="h6 mb-0 font-weight-bold text-gray-800">{{ App::getLocale() == 'en' ? $jobPosting->job_title_english : $jobPosting->job_title_arabic }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa fa-briefcase fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card border-left-warning shadow-sm h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Job Category</div>
                                            <div class="h6 mb-0 font-weight-bold text-gray-800">{{ App::getLocale() == 'en' ? $jobPosting->job_category_english : $jobPosting->job_category_arabic }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa fa-folder fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card border-left-success shadow-sm h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Job Type</div>
                                            <div class="h6 mb-0">
                                                <span class="badge badge-info badge-lg" style="font-size: 14px; padding: 8px 12px;">{{ $jobPosting->job_type }}</span>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa fa-clock-o fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card border-left-danger shadow-sm h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Salary</div>
                                            <div class="h6 mb-0 font-weight-bold text-gray-800">
                                                @if($jobPosting->show_salary && $jobPosting->salary)
                                                    ${{ number_format($jobPosting->salary, 2) }}
                                                @else
                                                    <span class="text-muted">Not Disclosed</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa fa-dollar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card border-left-secondary shadow-sm h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Show Salary</div>
                                            <div class="h6 mb-0">
                                                @if($jobPosting->show_salary)
                                                    <span class="badge badge-success badge-lg" style="font-size: 14px; padding: 8px 12px;">Yes</span>
                                                @else
                                                    <span class="badge badge-secondary badge-lg" style="font-size: 14px; padding: 8px 12px;">No</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa fa-eye fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card border-left-primary shadow-sm h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Registration Start</div>
                                            <div class="h6 mb-0 font-weight-bold text-gray-800">{{ \Carbon\Carbon::parse($jobPosting->registration_start_date)->format('M d, Y') }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa fa-calendar-check-o fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card border-left-danger shadow-sm h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Registration End</div>
                                            <div class="h6 mb-0 font-weight-bold text-gray-800">{{ \Carbon\Carbon::parse($jobPosting->registration_end_date)->format('M d, Y') }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa fa-calendar-times-o fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card border-left-success shadow-sm h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Status</div>
                                            <div class="h6 mb-0">
                                                @if($jobPosting->status == 'Publish')
                                                    <span class="badge badge-success badge-lg" style="font-size: 14px; padding: 8px 12px;"><i class="fa fa-check-circle"></i> Published</span>
                                                @else
                                                    <span class="badge badge-secondary badge-lg" style="font-size: 14px; padding: 8px 12px;"><i class="fa fa-times-circle"></i> Not Published</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa fa-toggle-on fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if($jobPosting->icon)
                        <div class="col-md-6">
                            <div class="card border-left-info shadow-sm h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-2">Job Icon</div>
                                            <img src="{{ asset('storage' . $jobPosting->icon) }}" alt="Job Icon" class="img-thumbnail" style="max-width: 100px; max-height: 100px; border: 2px solid #36b9cc; border-radius: 8px;">
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa fa-image fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>

                    <hr>

                    <!-- Job Description -->
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="text-primary mb-3"><i class="fa fa-file-text"></i> Job Description</h5>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <strong>English:</strong>
                            <div class="border p-3 mt-2" style="background-color: #f9f9f9;">
                                {!! $jobPosting->job_description_en !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <strong>Arabic:</strong>
                            <div class="border p-3 mt-2" style="background-color: #f9f9f9;">
                                {!! $jobPosting->job_description_ar !!}
                            </div>
                        </div>
                    </div>

                    @if($jobPosting->requirements_en || $jobPosting->requirements_ar)
                    <hr>

                    <!-- Requirements -->
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="text-primary mb-3"><i class="fa fa-check-square"></i> Requirements</h5>
                        </div>
                    </div>

                    <div class="row mb-4">
                        @if($jobPosting->requirements_en)
                        <div class="col-md-6">
                            <strong>English:</strong>
                            <div class="border p-3 mt-2" style="background-color: #f9f9f9;">
                                {!! $jobPosting->requirements_en !!}
                            </div>
                        </div>
                        @endif
                        @if($jobPosting->requirements_ar)
                        <div class="col-md-6">
                            <strong>Arabic:</strong>
                            <div class="border p-3 mt-2" style="background-color: #f9f9f9;">
                                {!! $jobPosting->requirements_ar !!}
                            </div>
                        </div>
                        @endif
                    </div>
                    @endif

                    @if($jobPosting->responsibilities_en || $jobPosting->responsibilities_ar)
                    <hr>

                    <!-- Responsibilities -->
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="text-primary mb-3"><i class="fa fa-tasks"></i> Responsibilities</h5>
                        </div>
                    </div>

                    <div class="row mb-4">
                        @if($jobPosting->responsibilities_en)
                        <div class="col-md-6">
                            <strong>English:</strong>
                            <div class="border p-3 mt-2" style="background-color: #f9f9f9;">
                                {!! $jobPosting->responsibilities_en !!}
                            </div>
                        </div>
                        @endif
                        @if($jobPosting->responsibilities_ar)
                        <div class="col-md-6">
                            <strong>Arabic:</strong>
                            <div class="border p-3 mt-2" style="background-color: #f9f9f9;">
                                {!! $jobPosting->responsibilities_ar !!}
                            </div>
                        </div>
                        @endif
                    </div>
                    @endif

                    <hr>

                    <!-- Timestamps -->
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Created At:</strong>
                            <p class="text-muted">{{ \Carbon\Carbon::parse($jobPosting->created_at)->format('M d, Y - h:i A') }}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>Last Updated:</strong>
                            <p class="text-muted">{{ \Carbon\Carbon::parse($jobPosting->updated_at)->format('M d, Y - h:i A') }}</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

