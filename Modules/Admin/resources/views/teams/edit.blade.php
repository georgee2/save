@extends('admin::layouts.master')
@section('title', 'Edit Team Member')
@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Admin')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a href="{{route('admin.team.index')}}" class="breadcrumbs__item"><i class="fa fa-users"></i> Team Members List</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-pencil"></i> Edit Team Member</a> 
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
                        <h4 class="mt-0 mb-0 header-title align-self-center text-capitalize">Edit Team Member</h4>
                        <div class="buttons">
                            <a href="{{ route('admin.team.index') }}" class="mr-2">
                                <button class="btn btn-new"><i class="fa fa-list"></i> Team Members List</button>
                            </a>
                            <button class="btn btn-primary" onclick="window.history.back()">
                                <i class="fa fa-angle-left"></i> Back
                            </button>
                        </div>
                    </div>
                    <hr>
                    
                    <form enctype="multipart/form-data" action="{{ route('admin.team.update', ['id' => $team->id]) }}" method="POST">
                        @csrf
                        
                        <!-- Basic Information -->
                        <h5 class="mb-3 text-primary">Basic Information</h5>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">English Name <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <input class="form-control" value="{{old('name_english', $team->name_english)}}" type="text" name="name_english" required>
                                @error('name_english')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Arabic Name <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <input class="form-control" value="{{old('name_arabic', $team->name_arabic)}}" type="text" name="name_arabic" required>
                                @error('name_arabic')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <!-- Job Information -->
                        <h5 class="mb-3 mt-4 text-primary">Job Information</h5>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Job Title <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <select class="form-control select2" name="job_title_id" required>
                                    <option value="">Select Job Title</option>
                                    @foreach($jobTitles as $jobTitle)
                                        <option value="{{ $jobTitle->id }}" {{ old('job_title_id', $team->job_title_id) == $jobTitle->id ? 'selected' : '' }}>
                                            {{ $jobTitle->name_english }} - {{ $jobTitle->name_arabic }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('job_title_id')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Rank <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <select class="form-control select2" name="rank_id" required>
                                    <option value="">Select Rank</option>
                                    @foreach($ranks as $rank)
                                        <option value="{{ $rank->id }}" {{ old('rank_id', $team->rank_id) == $rank->id ? 'selected' : '' }}>
                                            {{ $rank->name_english }} - {{ $rank->name_arabic }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('rank_id')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <!-- Contact Information -->
                        <h5 class="mb-3 mt-4 text-primary">Contact Information</h5>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Email <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <input class="form-control" value="{{old('email', $team->email)}}" type="email" name="email" required>
                                @error('email')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Mobile <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <input class="form-control" value="{{old('mobile', $team->mobile)}}" type="text" name="mobile" required>
                                @error('mobile')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <!-- Current Images Display -->
                        <h5 class="mb-3 mt-4 text-primary">Current Images</h5>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <h6>Main Image (400x400)</h6>
                                        @if($team->main_image)
                                            <a data-lightbox="{{url('/storage'.$team->main_image)}}" href="{{url('/storage'.$team->main_image)}}">
                                                <img style="width:100%; max-width: 200px; height: auto; border-radius: 10px;" src="{{url('/storage'.$team->main_image)}}" alt="Main Image">
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
                                        <h6>Icon (100x100)</h6>
                                        @if($team->icon)
                                            <a data-lightbox="{{url('/storage'.$team->icon)}}" href="{{url('/storage'.$team->icon)}}">
                                                <img style="width:100%; max-width: 100px; height: auto; border-radius: 10px;" src="{{url('/storage'.$team->icon)}}" alt="Icon">
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
                                        <h6>Page Image (600x600)</h6>
                                        @if($team->page_image)
                                            <a data-lightbox="{{url('/storage'.$team->page_image)}}" href="{{url('/storage'.$team->page_image)}}">
                                                <img style="width:100%; max-width: 200px; height: auto; border-radius: 10px;" src="{{url('/storage'.$team->page_image)}}" alt="Page Image">
                                            </a>
                                        @else
                                            <span class="text-muted">No Image</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Image Upload -->
                        <h5 class="mb-3 mt-4 text-primary">Update Image (Optional)</h5>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label class="text-capitalize">Team Member Image</label>
                                <p class="text-muted small">Upload a new image to replace all three versions. Leave empty to keep current images.</p>
                                <ul class="text-muted small">
                                    <li>Main Image: 308x375px (for listings)</li>
                                    <li>Icon: 100x100px (for small displays)</li>
                                    <li>Page Image: 645x700px (for detail pages)</li>
                                </ul>
                                <input accept="image/*" class="form-control dropify" type="file" name="main_image">
                                @error('main_image')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <!-- Work Experience -->
                        <h5 class="mb-3 mt-4 text-primary">Work Experience</h5>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label class="text-capitalize">Work Experience (English)</label>
                                <textarea id="elm1" class="form-control" name="work_experience_english">{!!old('work_experience_english', $team->work_experience_english)!!}</textarea>
                                @error('work_experience_english')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group col-md-12">
                                <label class="text-capitalize">Work Experience (Arabic)</label>
                                <textarea id="elm2" class="form-control" name="work_experience_arabic">{!!old('work_experience_arabic', $team->work_experience_arabic)!!}</textarea>
                                @error('work_experience_arabic')<span class="text-danger mt-1">{{ $message }}</span>@enderror
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

@section('js')
<script src="{{ asset('/js/dropify.min.js') }}"></script>

<script>
    $('.dropify').dropify();
</script>

<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Select an option",
            allowClear: true
        });
    });
</script>
@endsection

