@extends('admin::layouts.master')
@section('title', 'Edit Portfolio')
@section('css')
<link rel="stylesheet" href="{{ asset('/css/tagify.css') }}">
<link rel="stylesheet" href="{{ asset('/css/auto-translate.css') }}">
@endsection
@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Admin')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a href="{{route('portfolio.index')}}" class="breadcrumbs__item"><i class="fa fa-list"></i> Portfolios</a>
            <a style="pointer-events: none;" href="#checkout" class="breadcrumbs__item is-active"><i class="fa fa-check"></i> Edit Portfolio</a> 
        </nav>

        <div class="col-12 mx-auto">
            <hr>
            <div class="card m-b-20">
                <div class="card-body">
                    <div class="title d-flex justify-content-between">
                        <h4 class="mt-0 mb-0 header-title align-self-center text-capitalize">Edit Portfolio</h4>
                        <div class="buttons">
                            <a href="{{ route('portfolio.index') }}" class="mr-2">
                                <button class="btn btn-new"><i class="fa fa-list"></i>
                                    Portfolios List</button>
                            </a>
                            <button class="btn btn-primary" onclick="window.history.back()">
                                <i class="fa fa-angle-left"></i>
                                Back
                            </button>
                        </div>
                    </div>
                    <hr>
                    <form enctype="multipart/form-data" action="{{ route('portfolio.update', ['id' => $portfolio->id]) }}" method="POST">
                        @csrf

                        <div class="mb-3 text-right">
                            <button type="button" class="translate-all-btn"><i class="fa fa-language"></i> Translate All to Arabic</button>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">English Title <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <input class="form-control" value="{{old('title_english', $portfolio->title_english)}}" type="text" name="title_english">
                                @error('title_english')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Arabic Title <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i> <button type="button" class="auto-translate-btn" data-translate-source="title_english" data-translate-target="title_arabic"><i class="fa fa-language"></i> Auto</button></label>
                                <input class="form-control" value="{{old('title_arabic', $portfolio->title_arabic)}}" type="text" name="title_arabic">
                                @error('title_arabic')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Client Name <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <input class="form-control" value="{{old('client_name', $portfolio->client_name)}}" type="text" name="client_name">
                                @error('client_name')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Date <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <input class="form-control" value="{{old('date', $portfolio->date)}}" type="date" name="date">
                                @error('date')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-12">
                                <label class="text-capitalize">Portfolio Type <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <select class="custom-select form-control select2" name="portfolio_type_id">
                                    <option value="">Select Portfolio Type</option>
                                    @foreach($portfolioTypes as $type)
                                        <option value="{{$type->id}}" {{old('portfolio_type_id', $portfolio->portfolio_type_id) == $type->id ? 'selected' : ''}}>
                                            @if(App::getLocale() == 'en')
                                                {{$type->name_english}}
                                            @else
                                                {{$type->name_arabic}}
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                @error('portfolio_type_id')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Bio English (Max 500 characters)</label>
                                <textarea class="form-control char-counter" id="bio_english" name="bio_english" rows="3" maxlength="500" data-max="500">{{old('bio_english', $portfolio->bio_english)}}</textarea>
                                <small class="form-text text-muted">
                                    <span id="bio_english_count">0</span> / 500 characters
                                </small>
                                @error('bio_english')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Bio Arabic (Max 500 characters) <button type="button" class="auto-translate-btn" data-translate-source="bio_english" data-translate-target="bio_arabic"><i class="fa fa-language"></i> Auto</button></label>
                                <textarea class="form-control char-counter" id="bio_arabic" name="bio_arabic" rows="3" maxlength="500" data-max="500">{{old('bio_arabic', $portfolio->bio_arabic)}}</textarea>
                                <small class="form-text text-muted">
                                    <span id="bio_arabic_count">0</span> / 500 characters
                                </small>
                                @error('bio_arabic')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-12">
                                <label class="text-capitalize">English Description (Max 3000 characters) <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <textarea class="form-control char-counter" id="description_english" name="description_english" rows="6" maxlength="3000" data-max="3000">{{old('description_english', $portfolio->description_english)}}</textarea>
                                <small class="form-text text-muted">
                                    <span id="description_english_count">0</span> / 3000 characters
                                </small>
                                @error('description_english')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-12">
                                <label class="text-capitalize">Arabic Description (Max 3000 characters) <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i> <button type="button" class="auto-translate-btn" data-translate-source="description_english" data-translate-target="description_arabic"><i class="fa fa-language"></i> Auto</button></label>
                                <textarea class="form-control char-counter" id="description_arabic" name="description_arabic" rows="6" maxlength="3000" data-max="3000">{{old('description_arabic', $portfolio->description_arabic)}}</textarea>
                                <small class="form-text text-muted">
                                    <span id="description_arabic_count">0</span> / 3000 characters
                                </small>
                                @error('description_arabic')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label class="text-capitalize">Main Image (Width: 645px - Height: 460px - Will be converted to WebP)</label>
                                <input accept="image/*" class="form-control dropify" type="file" name="main_image" @if($portfolio->main_image) data-default-file="{{url('/storage'.$portfolio->main_image)}}" @endif>
                                @error('main_image')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label class="text-capitalize">Page Image (Width: 868px - Height: 450px - Will be converted to WebP)</label>
                                <input accept="image/*" class="form-control dropify" type="file" name="page_image" @if($portfolio->page_image) data-default-file="{{url('/storage'.$portfolio->page_image)}}" @endif>
                                @error('page_image')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label class="text-capitalize">Icon (Width: 100px - Height: 100px - Will be converted to WebP)</label>
                                <input accept="image/*" class="form-control dropify" type="file" name="icon" @if($portfolio->icon) data-default-file="{{url('/storage'.$portfolio->icon)}}" @endif>
                                @error('icon')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label class="text-capitalize">Cover Image (Width: 1890px - Height: 420px - Will be converted to WebP)</label>
                                <input accept="image/*" class="form-control dropify" type="file" name="cover" @if($portfolio->cover) data-default-file="{{url('/storage'.$portfolio->cover)}}" @endif>
                                @error('cover')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Publish Status <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <select class="custom-select form-control" name="status">
                                    <option value="0" {{old('status', $portfolio->status) == 0 ? 'selected' : ''}}>Publish</option>
                                    <option value="1" {{old('status', $portfolio->status) == 1 ? 'selected' : ''}}>Not Publish</option>
                                </select>
                                @error('status')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Home Status <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <select class="custom-select form-control" name="home_status">
                                    <option value="0" {{old('home_status', $portfolio->home_status) == 0 ? 'selected' : ''}}>Shown</option>
                                    <option value="1" {{old('home_status', $portfolio->home_status) == 1 ? 'selected' : ''}}>Not Shown</option>
                                </select>
                                @error('home_status')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="form-group col-md-12">
                                <label>SEO Tags <span class="text-danger">Press Enter After You Type</span></label>
                                <input name="seo_tags" value="{{$portfolio->seo_tags}}" class="tagify form-control">
                                @error('seo_tags')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                <label>SEO Description English</label>
                                <textarea name="seo_description_english" class="form-control" maxlength="1000" rows="3" placeholder="This textarea has a limit of 1000 chars.">{{old('seo_description_english', $portfolio->seo_description_english)}}</textarea>
                                @error('seo_description_english')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                <label>SEO Description Arabic <button type="button" class="auto-translate-btn" data-translate-source="seo_description_english" data-translate-target="seo_description_arabic"><i class="fa fa-language"></i> Auto</button></label>
                                <textarea name="seo_description_arabic" class="form-control" maxlength="1000" rows="3" placeholder="This textarea has a limit of 1000 chars.">{{old('seo_description_arabic', $portfolio->seo_description_arabic)}}</textarea>
                                @error('seo_description_arabic')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <hr>
                        <div class="form-group mb-0">
                            <div>
                                <button type="submit" class="btn btn-dark waves-effect waves-light mr-2">
                                    Update
                                </button>
                                <button type="reset" class="btn btn-primary waves-effect m-l-5" onclick="window.history.back()">
                                    Cancel
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
<script src="{{ asset('/js/auto-translate.js') }}"></script>
<script src="{{ asset('/js/tagify.min.js') }}"></script>
<script src="{{ asset('/js/dropify.min.js') }}"></script>
<script>
    $('.dropify').dropify();
</script>
<script>
    if(document.querySelectorAll('.tagify').length > 0){
        const el = document.querySelector('.tagify');
        new Tagify(el);
    }
</script>
<script>
    // Character counter functionality
    document.addEventListener('DOMContentLoaded', function() {
        const textareas = document.querySelectorAll('.char-counter');
        
        textareas.forEach(function(textarea) {
            const counterId = textarea.id + '_count';
            const counter = document.getElementById(counterId);
            const maxLength = parseInt(textarea.getAttribute('data-max'));
            
            // Update counter on page load
            updateCounter(textarea, counter, maxLength);
            
            // Update counter on input
            textarea.addEventListener('input', function() {
                updateCounter(textarea, counter, maxLength);
            });
        });
        
        function updateCounter(textarea, counter, maxLength) {
            const currentLength = textarea.value.length;
            counter.textContent = currentLength;
            
            // Change color based on usage
            if (currentLength >= maxLength) {
                counter.style.color = '#dc3545'; // Red
                counter.style.fontWeight = 'bold';
            } else if (currentLength >= maxLength * 0.9) {
                counter.style.color = '#ffc107'; // Orange
                counter.style.fontWeight = 'bold';
            } else {
                counter.style.color = '#6c757d'; // Gray
                counter.style.fontWeight = 'normal';
            }
        }
    });
</script>
@endsection

