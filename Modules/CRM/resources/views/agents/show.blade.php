@extends('admin::layouts.master')
@section('title', 'View Agent')
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
            <a href="{{route('crm-agents.index')}}" class="breadcrumbs__item"><i class="fa fa-list"></i> Agents List</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-eye"></i> View Agent</a> 
        </nav>

        <div class="col-12 mx-auto">
            <hr>
            <div class="card m-b-20">
                <div class="card-body">
                    <div class="title d-flex justify-content-between">
                        <h4 class="mt-0 mb-0 header-title align-self-center text-capitalize">Agent Details</h4>
                        <div class="buttons">
                            <a href="{{ route('crm-agents.edit', ['id' => $agent->id]) }}" class="mr-2">
                                <button class="btn btn-warning"><i class="fa fa-pencil"></i> Edit</button>
                            </a>
                            <a href="{{ route('crm-agents.index') }}" class="mr-2">
                                <button class="btn btn-new"><i class="fa fa-list"></i> Agents List</button>
                            </a>
                            <button class="btn btn-primary" onclick="window.history.back()">
                                <i class="fa fa-angle-left"></i>
                                Back
                            </button>
                        </div>
                    </div>
                    <hr>

                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="text-primary mb-4"><i class="fa fa-info-circle"></i> Agent Information</h5>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card border-left-primary shadow-sm h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Full Name (English)</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $agent->full_name_en }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa fa-user fa-2x text-gray-300"></i>
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
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Full Name (Arabic)</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800" dir="rtl">{{ $agent->full_name_ar }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa fa-user fa-2x text-gray-300"></i>
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
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Job Title</div>
                                            <div class="h6 mb-0 font-weight-bold text-gray-800">{{ App::getLocale() == 'en' ? $agent->job_title_english : $agent->job_title_arabic }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa fa-briefcase fa-2x text-gray-300"></i>
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
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Rank</div>
                                            <div class="h6 mb-0 font-weight-bold text-gray-800">{{ App::getLocale() == 'en' ? $agent->rank_english : $agent->rank_arabic }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa fa-star fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="card border-left-danger shadow-sm h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Status</div>
                                            <div class="h6 mb-0">
                                                @if($agent->status == 'Active')
                                                    <span class="badge badge-success badge-lg" style="font-size: 14px; padding: 8px 12px;"><i class="fa fa-check-circle"></i> Active</span>
                                                @else
                                                    <span class="badge badge-secondary badge-lg" style="font-size: 14px; padding: 8px 12px;"><i class="fa fa-times-circle"></i> Not Active</span>
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
                        <div class="col-md-4">
                            <div class="card border-left-secondary shadow-sm h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">System User</div>
                                            <div class="h6 mb-0 font-weight-bold text-gray-800">{{ $agent->user_name }}</div>
                                            <small class="text-muted">{{ $agent->user_email }}</small>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa fa-id-card fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-left-primary shadow-sm h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Agent ID</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">#{{ $agent->id }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa fa-hashtag fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <strong>Created At:</strong>
                            <p class="text-muted">{{ \Carbon\Carbon::parse($agent->created_at)->format('M d, Y - h:i A') }}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>Last Updated:</strong>
                            <p class="text-muted">{{ \Carbon\Carbon::parse($agent->updated_at)->format('M d, Y - h:i A') }}</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
