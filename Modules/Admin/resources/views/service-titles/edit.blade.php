@extends('admin::layouts.master')
@section('title', 'Edit Service Title')
@section('css')
<link rel="stylesheet" href="{{ asset('/css/auto-translate.css') }}">
@endsection
@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Admin')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a href="{{route('service-title.index')}}" class="breadcrumbs__item"><i class="fa fa-text-width"></i> Service Titles List</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-pencil"></i> Edit Title</a> 
        </nav>

        <div class="col-lg-12">
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
            
            <div class="card">
                <div class="card-body">
                    <h4 class="mt-0 header-title">Edit Service Title</h4>
                    <hr>
                    
                    <form action="{{ route('service-title.update', ['id' => $ServiceTitle->id]) }}" method="POST">
                        @csrf
                        <div class="mb-3 text-right">
                            <button type="button" class="translate-all-btn"><i class="fa fa-language"></i> Translate All to Arabic</button>
                        </div>
                        
                        <div class="row">
                            <!-- Title English -->
                            <div class="form-group col-md-6">
                                <label>Title (English) <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <input type="text" class="form-control" name="title_english" value="{{ old('title_english', $ServiceTitle->title_english) }}" required>
                            </div>
                            
                            <!-- Title Arabic -->
                            <div class="form-group col-md-6">
                                <label>Title (Arabic) <button type="button" class="auto-translate-btn" data-translate-source="title_english" data-translate-target="title_arabic"><i class="fa fa-language"></i> Auto</button> <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <input type="text" class="form-control" name="title_arabic" value="{{ old('title_arabic', $ServiceTitle->title_arabic) }}" required>
                            </div>
                            
                            <!-- Subtitle English -->
                            <div class="form-group col-md-6">
                                <label>Subtitle (English)</label>
                                <input type="text" class="form-control" name="subtitle_english" value="{{ old('subtitle_english', $ServiceTitle->subtitle_english) }}">
                            </div>
                            
                            <!-- Subtitle Arabic -->
                            <div class="form-group col-md-6">
                                <label>Subtitle (Arabic) <button type="button" class="auto-translate-btn" data-translate-source="subtitle_english" data-translate-target="subtitle_arabic"><i class="fa fa-language"></i> Auto</button></label>
                                <input type="text" class="form-control" name="subtitle_arabic" value="{{ old('subtitle_arabic', $ServiceTitle->subtitle_arabic) }}">
                            </div>
                            
                            <!-- Target Section -->
                            <div class="form-group col-md-12">
                                <label>Target Section <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <select class="form-control" name="target" required>
                                    <option value="">-- Select Target Section --</option>
                                    <option value="features" {{ old('target', $ServiceTitle->target) == 'features' ? 'selected' : '' }}>Features</option>
                                    <option value="processes" {{ old('target', $ServiceTitle->target) == 'processes' ? 'selected' : '' }}>Processes</option>
                                    <option value="values" {{ old('target', $ServiceTitle->target) == 'values' ? 'selected' : '' }}>Values</option>
                                    <option value="faqs" {{ old('target', $ServiceTitle->target) == 'faqs' ? 'selected' : '' }}>FAQs</option>
                                    <option value="sub_services" {{ old('target', $ServiceTitle->target) == 'sub_services' ? 'selected' : '' }}>Sub Services</option>
                                </select>
                                <small class="form-text text-muted">Select which section this title will be used for</small>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-success waves-effect waves-light">
                                <i class="fa fa-save"></i> Update Title
                            </button>
                            <a href="{{ route('service-title.index') }}" class="btn btn-secondary waves-effect">
                                <i class="fa fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('/js/auto-translate.js') }}"></script>
@endsection

