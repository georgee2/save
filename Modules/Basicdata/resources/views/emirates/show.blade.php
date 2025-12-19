@extends('admin::layouts.master')
@section('title', 'View Emirate')
@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Basicdata')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a href="{{route('emirate.index')}}" class="breadcrumbs__item"><i class="fa fa-list"></i> Emirates List</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-eye"></i> View Emirate</a> 
        </nav>

        <div class="col-12 mx-auto">
            <hr>
            <div class="card m-b-20">
                <div class="card-body">
                    <div class="title d-flex justify-content-between">
                        <h4 class="mt-0 mb-0 header-title align-self-center text-capitalize">Emirate Details</h4>
                        <div class="buttons">
                            <a href="{{ route('emirate.edit', ['id' => $emirate->id]) }}" class="mr-2">
                                <button class="btn btn-warning"><i class="fa fa-pencil"></i> Edit</button>
                            </a>
                            <a href="{{ route('emirate.index') }}" class="mr-2">
                                <button class="btn btn-new"><i class="fa fa-list"></i>
                                    Emirates List</button>
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
                            <h5 class="text-primary mb-3"><i class="fa fa-info-circle"></i> Basic Information</h5>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">English Title:</label>
                                <p>{{ $emirate->title_english }}</p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Arabic Title:</label>
                                <p>{{ $emirate->title_arabic }}</p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Slug:</label>
                                <p><span class="badge badge-info">{{ $emirate->slug }}</span></p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Created At:</label>
                                <p>{{ \Carbon\Carbon::parse($emirate->created_at)->format('M d, Y H:i A') }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="text-primary mb-3"><i class="fa fa-file-text-o"></i> Bio</h5>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Bio English:</label>
                                <p>{{ $emirate->bio_english ?? 'N/A' }}</p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Bio Arabic:</label>
                                <p>{{ $emirate->bio_arabic ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="text-primary mb-3"><i class="fa fa-align-left"></i> Description</h5>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Description English:</label>
                                <p>{{ $emirate->description_english ?? 'N/A' }}</p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Description Arabic:</label>
                                <p>{{ $emirate->description_arabic ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="text-primary mb-3"><i class="fa fa-image"></i> Media</h5>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="font-weight-bold">Icon (150x150):</label>
                                @if($emirate->icon)
                                    <div>
                                        <a data-lightbox="icon" href="{{url('/storage'.$emirate->icon)}}">
                                            <img style="width:100px; height: 100px; object-fit: contain; border: 1px solid #ddd; border-radius: 4px; padding: 5px;" src="{{url('/storage'.$emirate->icon)}}" alt="Icon">
                                        </a>
                                    </div>
                                @else
                                    <p class="text-muted">N/A</p>
                                @endif
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="font-weight-bold">Image (540x675):</label>
                                @if($emirate->image)
                                    <div>
                                        <a data-lightbox="image" href="{{url('/storage'.$emirate->image)}}">
                                            <img style="width:135px; height: 169px; object-fit: cover; border: 1px solid #ddd; border-radius: 4px; padding: 5px;" src="{{url('/storage'.$emirate->image)}}" alt="Image">
                                        </a>
                                    </div>
                                @else
                                    <p class="text-muted">N/A</p>
                                @endif
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="font-weight-bold">Cover:</label>
                                @if($emirate->cover)
                                    <div>
                                        <a data-lightbox="cover" href="{{url('/storage'.$emirate->cover)}}">
                                            <img style="width:200px; height: 150px; object-fit: cover; border: 1px solid #ddd; border-radius: 4px; padding: 5px;" src="{{url('/storage'.$emirate->cover)}}" alt="Cover">
                                        </a>
                                    </div>
                                @else
                                    <p class="text-muted">N/A</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="text-primary mb-3"><i class="fa fa-search"></i> SEO Information</h5>
                        </div>
                        
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="font-weight-bold">SEO Tags:</label>
                                <p>{{ $emirate->seo_tags ?? 'N/A' }}</p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">SEO Description English:</label>
                                <p>{{ $emirate->seo_description_english ?? 'N/A' }}</p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">SEO Description Arabic:</label>
                                <p>{{ $emirate->seo_description_arabic ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

