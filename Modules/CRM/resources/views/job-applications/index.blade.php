@extends('admin::layouts.master')
@section('title', 'Job Applications')
@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">

        <nav class="breadcrumbs">
            <a href="{{route('CRM')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-file-text"></i> Job Applications</a>
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
                            Job Applications</h4>
                        <div class="buttons">
                            <button class="btn btn-primary" onclick="window.history.back()">
                                <i class="fa fa-angle-left"></i>
                                Back
                            </button>
                        </div>
                    </div>
                    <hr>

                    @if(count($applications) > 0)
                        <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Applicant</th>
                                    <th>Job</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Status</th>
                                    <th>Submitted</th>
                                    <th>#Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($applications as $application)
                                <tr>
                                    <td><strong>{{ $application->applicant_name }}</strong></td>
                                    <td>
                                        {{ App::getLocale() == 'en' ? $application->job_title_english : $application->job_title_arabic }}
                                        @if($application->job_code)
                                            <br><small class="text-muted">{{ $application->job_code }}</small>
                                        @endif
                                    </td>
                                    <td><a href="mailto:{{ $application->email }}">{{ $application->email }}</a></td>
                                    <td>{{ $application->phone }}</td>
                                    <td><span class="badge badge-info">{{ $application->status }}</span></td>
                                    <td>
                                        <small>{{ \Carbon\Carbon::parse($application->created_at)->format('d M Y, H:i') }}</small>
                                    </td>
                                    <td>
                                        @if($application->resume)
                                            <a href="{{ route('crm-job-applications.download', $application->id) }}" class="btn btn-sm btn-primary">
                                                <i class="fa fa-download"></i> CV
                                            </a>
                                        @else
                                            <span class="text-muted">&mdash;</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="alert alert-info mb-0">
                            <i class="fa fa-info-circle"></i> No job applications have been submitted yet.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
