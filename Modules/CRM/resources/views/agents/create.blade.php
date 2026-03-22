@extends('admin::layouts.master')
@section('title', 'Add New Agent')
@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('CRM')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a href="{{route('crm-agents.index')}}" class="breadcrumbs__item"><i class="fa fa-list"></i> Agents List</a>
            <a style="pointer-events: none;" href="#checkout" class="breadcrumbs__item is-active"><i class="fa fa-check"></i> Add New Agent</a> 
        </nav>

        <div class="col-12 mx-auto">
            <hr>

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
                        <h4 class="mt-0 mb-0 header-title align-self-center text-capitalize">Add New Agent</h4>
                        <div class="buttons">
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
                    <form action="{{ route('crm-agents.store') }}" method="POST">
                        @csrf
                        
                        <h5 class="text-primary mb-3"><i class="fa fa-user"></i> Select User</h5>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">System User <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <select class="custom-select form-control" name="user_id" id="userSelect">
                                    <option selected disabled value="">Choose User</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }} ({{ $user->email }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-3">
                                <label class="text-capitalize">Status <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <select class="custom-select form-control" name="status">
                                    <option value="Active" {{ old('status') == 'Active' ? 'selected' : '' }} selected>Active</option>
                                    <option value="Not Active" {{ old('status') == 'Not Active' ? 'selected' : '' }}>Not Active</option>
                                </select>
                                @error('status')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <hr>

                        <h5 class="text-primary mb-3"><i class="fa fa-info-circle"></i> Agent Information</h5>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Full Name in English <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <input class="form-control" value="{{ old('full_name_en') }}" type="text" name="full_name_en" placeholder="Enter Full Name in English">
                                @error('full_name_en')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Full Name in Arabic <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <input class="form-control" value="{{ old('full_name_ar') }}" type="text" name="full_name_ar" placeholder="Enter Full Name in Arabic" dir="rtl">
                                @error('full_name_ar')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Job Title <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <select class="custom-select form-control" name="job_title_id">
                                    <option selected disabled value="">Choose Job Title</option>
                                    @foreach($jobTitles as $title)
                                        <option value="{{ $title->id }}" {{ old('job_title_id') == $title->id ? 'selected' : '' }}>
                                            {{ App::getLocale() == 'en' ? $title->name_english : $title->name_arabic }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('job_title_id')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Rank <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <select class="custom-select form-control" name="rank_id">
                                    <option selected disabled value="">Choose Rank</option>
                                    @foreach($ranks as $rank)
                                        <option value="{{ $rank->id }}" {{ old('rank_id') == $rank->id ? 'selected' : '' }}>
                                            {{ App::getLocale() == 'en' ? $rank->name_english : $rank->name_arabic }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('rank_id')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <hr>
                        <div class="form-group mb-0">
                            <div>
                                <button type="submit" class="btn btn-dark waves-effect waves-light mr-2">
                                    <i class="fa fa-save"></i> Submit
                                </button>
                                <button type="reset" class="btn btn-primary waves-effect m-l-5" onclick="window.history.back()">
                                    <i class="fa fa-times"></i> Cancel
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
