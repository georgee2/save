@extends('admin::layouts.master')
@section('title', 'View Engineering Sub Category')
@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Basicdata')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a href="{{route('engineeringsubcategory.index')}}" class="breadcrumbs__item"><i class="fa fa-list"></i> Eng.Sub Categories List</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-eye"></i> View Sub Category</a> 
        </nav>

        <div class="col-12 mx-auto">
            <hr>
            <div class="card m-b-20">
                <div class="card-body">
                    <div class="title d-flex justify-content-between">
                        <h4 class="mt-0 mb-0 header-title align-self-center text-capitalize">Engineering Sub Category Details</h4>
                        <div class="buttons">
                            <a href="{{ route('engineeringsubcategory.edit', ['id' => $subCategory->id]) }}" class="mr-2">
                                <button class="btn btn-warning"><i class="fa fa-pencil"></i> Edit</button>
                            </a>
                            <a href="{{ route('engineeringsubcategory.index') }}" class="mr-2">
                                <button class="btn btn-new"><i class="fa fa-list"></i>
                                    Eng.Sub Categories List</button>
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
                                <label class="font-weight-bold">Parent Category:</label>
                                <p><span class="badge badge-primary">{{ $subCategory->category->title_english }} - {{ $subCategory->category->title_arabic }}</span></p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Slug:</label>
                                <p><span class="badge badge-info">{{ $subCategory->slug }}</span></p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">English Title:</label>
                                <p>{{ $subCategory->title_english }}</p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Arabic Title:</label>
                                <p>{{ $subCategory->title_arabic }}</p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Created At:</label>
                                <p>{{ \Carbon\Carbon::parse($subCategory->created_at)->format('M d, Y H:i A') }}</p>
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
                                <p>{{ $subCategory->bio_english }}</p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Bio Arabic:</label>
                                <p>{{ $subCategory->bio_arabic }}</p>
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
                                <p>{{ $subCategory->description_english }}</p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Description Arabic:</label>
                                <p>{{ $subCategory->description_arabic }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="text-primary mb-3"><i class="fa fa-image"></i> Media</h5>
                        </div>
                        
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="font-weight-bold">Icon:</label>
                                @if($subCategory->icon)
                                    <div>
                                        <a data-lightbox="icon" href="{{url('/storage'.$subCategory->icon)}}">
                                            <img style="width:100px; height: 100px; object-fit: contain; border: 1px solid #ddd; border-radius: 4px; padding: 5px;" src="{{url('/storage'.$subCategory->icon)}}" alt="Icon">
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
                                <p>{{ $subCategory->seo_tags ?? 'N/A' }}</p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">SEO Description English:</label>
                                <p>{{ $subCategory->seo_description_english ?? 'N/A' }}</p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">SEO Description Arabic:</label>
                                <p>{{ $subCategory->seo_description_arabic ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

