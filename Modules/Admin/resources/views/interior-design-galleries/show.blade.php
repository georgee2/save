@extends('admin::layouts.master')
@section('title', 'View Interior Design Gallery')
@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Admin')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a href="{{route('interior-design-gallery.index')}}" class="breadcrumbs__item"><i class="fa fa-list"></i> Interior Design Gallery List</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-eye"></i> View Gallery</a> 
        </nav>

        <div class="col-12 mx-auto">
            <hr>
            <div class="card m-b-20">
                <div class="card-body">
                    <div class="title d-flex justify-content-between">
                        <h4 class="mt-0 mb-0 header-title align-self-center text-capitalize">Interior Design Gallery Details</h4>
                        <div class="buttons">
                            <a href="{{ route('interior-design-gallery.edit', ['id' => $gallery->id]) }}" class="mr-2">
                                <button class="btn btn-warning"><i class="fa fa-pencil"></i> Edit</button>
                            </a>
                            <a href="{{ route('interior-design-gallery.index') }}" class="mr-2">
                                <button class="btn btn-new"><i class="fa fa-list"></i>
                                    Gallery List</button>
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
                                <p>{{ $gallery->title_english }}</p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Arabic Title:</label>
                                <p>{{ $gallery->title_arabic }}</p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Slug:</label>
                                <p><span class="badge badge-info">{{ $gallery->slug }}</span></p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Created At:</label>
                                <p>{{ \Carbon\Carbon::parse($gallery->created_at)->format('M d, Y H:i A') }}</p>
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
                                <p>{{ $gallery->bio_english ?? 'N/A' }}</p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Bio Arabic:</label>
                                <p>{{ $gallery->bio_arabic ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="text-primary mb-3"><i class="fa fa-link"></i> Relations</h5>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Category:</label>
                                <p><span class="badge badge-primary">{{ $gallery->category->title_english ?? 'N/A' }}</span></p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Project Type:</label>
                                <p><span class="badge badge-info">{{ $gallery->projectType->name_english ?? 'N/A' }}</span></p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Project Style:</label>
                                <p>{{ $gallery->projectStyle->title_english ?? 'N/A' }}</p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Project:</label>
                                <p>{{ $gallery->project->title_english ?? 'N/A' }}</p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Emirate:</label>
                                <p>{{ $gallery->emirate->title_english ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="text-primary mb-3"><i class="fa fa-toggle-on"></i> Status</h5>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="font-weight-bold">Publish Status:</label>
                                <p>
                                    @if($gallery->publish_status == 0)
                                        <span class="badge badge-success">Published</span>
                                    @else
                                        <span class="badge badge-secondary">Not Published</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="font-weight-bold">Home Status:</label>
                                <p>
                                    @if($gallery->home_status == 0)
                                        <span class="badge badge-success">Shown on Home</span>
                                    @else
                                        <span class="badge badge-secondary">Not Shown on Home</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="font-weight-bold">Display Order:</label>
                                <p><span class="badge badge-dark">{{ $gallery->ordering }}</span></p>
                            </div>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="text-primary mb-3"><i class="fa fa-image"></i> Image</h5>
                        </div>
                        
                        <div class="col-md-12">
                            <div class="form-group">
                                @if($gallery->image)
                                    <div>
                                        <a data-lightbox="image" href="{{url('/storage'.$gallery->image)}}">
                                            <img style="max-width:765px; max-height: 432px; object-fit: cover; border: 1px solid #ddd; border-radius: 4px; padding: 5px;" src="{{url('/storage'.$gallery->image)}}" alt="Gallery Image">
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
                                <p>{{ $gallery->seo_tags ?? 'N/A' }}</p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">SEO Description English:</label>
                                <p>{{ $gallery->seo_description_english ?? 'N/A' }}</p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">SEO Description Arabic:</label>
                                <p>{{ $gallery->seo_description_arabic ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
