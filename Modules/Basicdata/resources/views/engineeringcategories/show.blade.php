@extends('admin::layouts.master')
@section('title', 'View Engineering Category')
@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Basicdata')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a href="{{route('engineeringcategory.index')}}" class="breadcrumbs__item"><i class="fa fa-list"></i> Engineering Categories List</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-eye"></i> View Category</a> 
        </nav>

        <div class="col-12 mx-auto">
            <hr>
            <div class="card m-b-20">
                <div class="card-body">
                    <div class="title d-flex justify-content-between">
                        <h4 class="mt-0 mb-0 header-title align-self-center text-capitalize">Engineering Category Details</h4>
                        <div class="buttons">
                            <a href="{{ route('engineeringcategory.edit', ['id' => $category->id]) }}" class="mr-2">
                                <button class="btn btn-warning"><i class="fa fa-pencil"></i> Edit</button>
                            </a>
                            <a href="{{ route('engineeringcategory.index') }}" class="mr-2">
                                <button class="btn btn-new"><i class="fa fa-list"></i>
                                    Engineering Categories List</button>
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
                                <p>{{ $category->title_english }}</p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Arabic Title:</label>
                                <p>{{ $category->title_arabic }}</p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Slug:</label>
                                <p><span class="badge badge-info">{{ $category->slug }}</span></p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Created At:</label>
                                <p>{{ \Carbon\Carbon::parse($category->created_at)->format('M d, Y H:i A') }}</p>
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
                                <p>{{ $category->bio_english }}</p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Bio Arabic:</label>
                                <p>{{ $category->bio_arabic }}</p>
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
                                <p>{{ $category->description_english }}</p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Description Arabic:</label>
                                <p>{{ $category->description_arabic }}</p>
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
                                <label class="font-weight-bold">Icon:</label>
                                @if($category->icon)
                                    <div>
                                        <a data-lightbox="icon" href="{{url('/storage'.$category->icon)}}">
                                            <img style="width:100px; height: 100px; object-fit: contain; border: 1px solid #ddd; border-radius: 4px; padding: 5px;" src="{{url('/storage'.$category->icon)}}" alt="Icon">
                                        </a>
                                    </div>
                                @else
                                    <p class="text-muted">N/A</p>
                                @endif
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="font-weight-bold">Image:</label>
                                @if($category->image)
                                    <div>
                                        <a data-lightbox="image" href="{{url('/storage'.$category->image)}}">
                                            <img style="width:200px; height: 150px; object-fit: cover; border: 1px solid #ddd; border-radius: 4px; padding: 5px;" src="{{url('/storage'.$category->image)}}" alt="Image">
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
                                @if($category->cover)
                                    <div>
                                        <a data-lightbox="cover" href="{{url('/storage'.$category->cover)}}">
                                            <img style="width:200px; height: 150px; object-fit: cover; border: 1px solid #ddd; border-radius: 4px; padding: 5px;" src="{{url('/storage'.$category->cover)}}" alt="Cover">
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
                                <p>{{ $category->seo_tags ?? 'N/A' }}</p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">SEO Description English:</label>
                                <p>{{ $category->seo_description_english ?? 'N/A' }}</p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">SEO Description Arabic:</label>
                                <p>{{ $category->seo_description_arabic ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

