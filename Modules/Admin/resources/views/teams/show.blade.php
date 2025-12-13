@extends('admin::layouts.master')
@section('title', 'Team Member Details')
@section('css')
<style>
.content-display {
    padding: 15px;
    background-color: #f8f9fa;
    border-radius: 5px;
    min-height: 100px;
}
</style>
@endsection
@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Admin')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a href="{{route('admin.team.index')}}" class="breadcrumbs__item"><i class="fa fa-users"></i> Team Members List</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-eye"></i> Team Member Details</a> 
        </nav>

        <div class="col-12 mx-auto">
            <hr>
            
            <div class="card m-b-20">
                <div class="card-body">
                    <div class="title d-flex justify-content-between">
                        <h4 class="mt-0 mb-0 header-title align-self-center text-capitalize">Team Member Details</h4>
                        <div class="buttons">
                            <a href="{{ route('admin.team.edit', ['id' => $team->id]) }}" class="mr-2">
                                <button class="btn btn-warning"><i class="fa fa-pencil"></i> Edit</button>
                            </a>
                            <a href="{{ route('admin.team.index') }}" class="mr-2">
                                <button class="btn btn-new"><i class="fa fa-list"></i> Team Members List</button>
                            </a>
                            <button class="btn btn-primary" onclick="window.history.back()">
                                <i class="fa fa-angle-left"></i> Back
                            </button>
                        </div>
                    </div>
                    <hr>
                    
                    <!-- Basic Information -->
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="mb-3 text-primary">Basic Information</h5>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="40%">ID</th>
                                    <td>{{ $team->id }}</td>
                                </tr>
                                <tr>
                                    <th>Name (English)</th>
                                    <td>{{ $team->name_english }}</td>
                                </tr>
                                <tr>
                                    <th>Name (Arabic)</th>
                                    <td>{{ $team->name_arabic }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="40%">Job Title</th>
                                    <td>{{ $team->jobTitle->name_english ?? 'N/A' }} / {{ $team->jobTitle->name_arabic ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Rank</th>
                                    <td>{{ $team->rank->name_english ?? 'N/A' }} / {{ $team->rank->name_arabic ?? 'N/A' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h5 class="mb-3 text-primary">Contact Information</h5>
                        </div>
                        <div class="col-md-12">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="20%">Email</th>
                                    <td>{{ $team->email }}</td>
                                </tr>
                                <tr>
                                    <th>Mobile</th>
                                    <td>{{ $team->mobile }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Images -->
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h5 class="mb-3 text-primary">Images</h5>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body text-center">
                                    <h6 class="mb-3">Main Image (400x400)</h6>
                                    @if($team->main_image)
                                        <a data-lightbox="team-images" href="{{url('/storage'.$team->main_image)}}">
                                            <img style="width:100%; max-width: 300px; height: auto; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);" src="{{url('/storage'.$team->main_image)}}" alt="Main Image">
                                        </a>
                                    @else
                                        <span class="text-muted">No Image</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body text-center">
                                    <h6 class="mb-3">Icon (100x100)</h6>
                                    @if($team->icon)
                                        <a data-lightbox="team-images" href="{{url('/storage'.$team->icon)}}">
                                            <img style="width:100%; max-width: 150px; height: auto; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);" src="{{url('/storage'.$team->icon)}}" alt="Icon">
                                        </a>
                                    @else
                                        <span class="text-muted">No Image</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body text-center">
                                    <h6 class="mb-3">Page Image (600x600)</h6>
                                    @if($team->page_image)
                                        <a data-lightbox="team-images" href="{{url('/storage'.$team->page_image)}}">
                                            <img style="width:100%; max-width: 300px; height: auto; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);" src="{{url('/storage'.$team->page_image)}}" alt="Page Image">
                                        </a>
                                    @else
                                        <span class="text-muted">No Image</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Work Experience -->
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h5 class="mb-3 text-primary">Work Experience</h5>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="mb-3">English</h6>
                                    <div class="content-display">
                                        {!! $team->work_experience_english ?? '<span class="text-muted">No work experience added</span>' !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="mb-3">Arabic</h6>
                                    <div class="content-display" dir="rtl">
                                        {!! $team->work_experience_arabic ?? '<span class="text-muted">لم يتم إضافة خبرة عمل</span>' !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Timestamps -->
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h5 class="mb-3 text-primary">Record Information</h5>
                        </div>
                        <div class="col-md-12">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="20%">Created At</th>
                                    <td>{{ \Carbon\Carbon::parse($team->created_at)->format('F d, Y h:i A') }}</td>
                                </tr>
                                <tr>
                                    <th>Updated At</th>
                                    <td>{{ \Carbon\Carbon::parse($team->updated_at)->format('F d, Y h:i A') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection

