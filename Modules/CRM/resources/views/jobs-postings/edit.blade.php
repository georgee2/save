@extends('admin::layouts.master')
@section('title', 'Edit Job Posting')
@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('CRM')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a href="{{route('jobs-posting.index')}}" class="breadcrumbs__item"><i class="fa fa-list"></i> Jobs Postings List</a>
            <a style="pointer-events: none;" href="#checkout" class="breadcrumbs__item is-active"><i class="fa fa-edit"></i> Edit Job Posting</a> 
        </nav>

        <div class="col-12 mx-auto">
            <hr>
            <div class="card m-b-20">
                <div class="card-body">
                    <div class="title d-flex justify-content-between">
                        <h4 class="mt-0 mb-0 header-title align-self-center text-capitalize">Edit Job Posting - {{ $jobPosting->code }}</h4>
                        <div class="buttons">
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
                    <form enctype="multipart/form-data" action="{{ route('jobs-posting.update', ['id' => $jobPosting->id]) }}" method="POST">
                        @csrf
                        
                        <!-- Basic Information -->
                        <h5 class="text-primary mb-3"><i class="fa fa-info-circle"></i> Basic Information</h5>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label class="text-capitalize">Job Title <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <select class="custom-select form-control" name="job_title_id">
                                    <option selected disabled value="">Choose Job Title</option>
                                    @foreach($jobTitles as $title)
                                        <option value="{{$title->id}}" {{ old('job_title_id', $jobPosting->job_title_id) == $title->id ? 'selected' : '' }}>
                                            {{ App::getLocale() == 'en' ? $title->name_english : $title->name_arabic }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('job_title_id')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label class="text-capitalize">Job Category <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <select class="custom-select form-control" name="job_category_id">
                                    <option selected disabled value="">Choose Job Category</option>
                                    @foreach($jobCategories as $category)
                                        <option value="{{$category->id}}" {{ old('job_category_id', $jobPosting->job_category_id) == $category->id ? 'selected' : '' }}>
                                            {{ App::getLocale() == 'en' ? $category->name_english : $category->name_arabic }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('job_category_id')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label class="text-capitalize">Job Type <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <select class="custom-select form-control" name="job_type">
                                    <option selected disabled value="">Choose Job Type</option>
                                    <option value="Contract" {{ old('job_type', $jobPosting->job_type) == 'Contract' ? 'selected' : '' }}>Contract</option>
                                    <option value="Full Time" {{ old('job_type', $jobPosting->job_type) == 'Full Time' ? 'selected' : '' }}>Full Time</option>
                                    <option value="Intern" {{ old('job_type', $jobPosting->job_type) == 'Intern' ? 'selected' : '' }}>Intern</option>
                                    <option value="Hybrid" {{ old('job_type', $jobPosting->job_type) == 'Hybrid' ? 'selected' : '' }}>Hybrid</option>
                                    <option value="Remotely" {{ old('job_type', $jobPosting->job_type) == 'Remotely' ? 'selected' : '' }}>Remotely</option>
                                    <option value="Part-time" {{ old('job_type', $jobPosting->job_type) == 'Part-time' ? 'selected' : '' }}>Part-time</option>
                                </select>
                                @error('job_type')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Salary & Registration -->
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label class="text-capitalize">Salary</label>
                                <input class="form-control" value="{{old('salary', $jobPosting->salary)}}" type="number" step="0.01" name="salary" placeholder="Enter Salary">
                                @error('salary')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-3">
                                <label class="text-capitalize">Show Salary <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <select class="custom-select form-control" name="show_salary">
                                    <option value="1" {{ old('show_salary', $jobPosting->show_salary) == '1' ? 'selected' : '' }}>Yes</option>
                                    <option value="0" {{ old('show_salary', $jobPosting->show_salary) == '0' ? 'selected' : '' }}>No</option>
                                </select>
                                @error('show_salary')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-3">
                                <label class="text-capitalize">Registration Start Date <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <input class="form-control" value="{{old('registration_start_date', $jobPosting->registration_start_date ? \Carbon\Carbon::parse($jobPosting->registration_start_date)->format('Y-m-d') : '')}}" type="date" name="registration_start_date">
                                @error('registration_start_date')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-3">
                                <label class="text-capitalize">Registration End Date <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <input class="form-control" value="{{old('registration_end_date', $jobPosting->registration_end_date ? \Carbon\Carbon::parse($jobPosting->registration_end_date)->format('Y-m-d') : '')}}" type="date" name="registration_end_date">
                                @error('registration_end_date')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Status & Icon -->
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Status <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <select class="custom-select form-control" name="status">
                                    <option value="Publish" {{ old('status', $jobPosting->status) == 'Publish' ? 'selected' : '' }}>Publish</option>
                                    <option value="Not Publish" {{ old('status', $jobPosting->status) == 'Not Publish' ? 'selected' : '' }}>Not Publish</option>
                                </select>
                                @error('status')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Icon (100x100)</label>
                                @if($jobPosting->icon)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage' . $jobPosting->icon) }}" alt="Current Icon" style="max-width: 100px; max-height: 100px;">
                                    </div>
                                @endif
                                <input class="form-control" type="file" name="icon" accept="image/*">
                                <small class="text-muted">Recommended size: 100x100 pixels. Leave empty to keep current icon.</small>
                                @error('icon')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <hr>
                        
                        <!-- Job Description -->
                        <h5 class="text-primary mb-3"><i class="fa fa-file-text"></i> Job Description</h5>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label class="text-capitalize">Job Description (English) <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <textarea id="elm1" class="form-control" name="job_description_en">{!!old('job_description_en', $jobPosting->job_description_en)!!}</textarea>
                                @error('job_description_en')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-12">
                                <label class="text-capitalize">Job Description (Arabic) <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <textarea id="elm2" class="form-control" name="job_description_ar">{!!old('job_description_ar', $jobPosting->job_description_ar)!!}</textarea>
                                @error('job_description_ar')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <hr>

                        <!-- Requirements -->
                        <h5 class="text-primary mb-3"><i class="fa fa-check-square"></i> Requirements (Optional)</h5>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label class="text-capitalize">Requirements (English)</label>
                                <textarea id="elm3" class="form-control" name="requirements_en">{!!old('requirements_en', $jobPosting->requirements_en)!!}</textarea>
                                @error('requirements_en')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-12">
                                <label class="text-capitalize">Requirements (Arabic)</label>
                                <textarea id="elm4" class="form-control" name="requirements_ar">{!!old('requirements_ar', $jobPosting->requirements_ar)!!}</textarea>
                                @error('requirements_ar')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <hr>

                        <!-- Responsibilities -->
                        <h5 class="text-primary mb-3"><i class="fa fa-tasks"></i> Responsibilities (Optional)</h5>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label class="text-capitalize">Responsibilities (English)</label>
                                <textarea id="elm5" class="form-control" name="responsibilities_en">{!!old('responsibilities_en', $jobPosting->responsibilities_en)!!}</textarea>
                                @error('responsibilities_en')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-12">
                                <label class="text-capitalize">Responsibilities (Arabic)</label>
                                <textarea id="elm6" class="form-control" name="responsibilities_ar">{!!old('responsibilities_ar', $jobPosting->responsibilities_ar)!!}</textarea>
                                @error('responsibilities_ar')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <hr>
                        <div class="form-group mb-0">
                            <div>
                                <button type="submit" class="btn btn-dark waves-effect waves-light mr-2">
                                    <i class="fa fa-save"></i> Update
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

