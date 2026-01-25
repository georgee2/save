@extends('admin::layouts.master')
@section('title', 'Edit Offer')
@section('css')
<link rel="stylesheet" href="{{ asset('/css/tagify.css') }}">
@endsection
@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Admin')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a href="{{route('offer.index')}}" class="breadcrumbs__item"><i class="fa fa-tag"></i> Offers</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-pencil"></i> Edit Offer</a> 
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
                        <h4 class="mt-0 mb-0 header-title align-self-center text-capitalize">Edit Offer: {{ $offer->title_english }}</h4>
                        <div class="buttons">
                            <a href="{{ route('offer.index') }}" class="mr-2">
                                <button class="btn btn-new"><i class="fa fa-list"></i> Offers List</button>
                            </a>
                            <button class="btn btn-primary" onclick="window.history.back()">
                                <i class="fa fa-angle-left"></i> Back
                            </button>
                        </div>
                    </div>
                    <hr>
                    
                    <form enctype="multipart/form-data" action="{{ route('offer.update', ['id' => $offer->id]) }}" method="POST">
                        @csrf
                        
                        <!-- Basic Information -->
                        <h5 class="mb-3 text-primary">Basic Information</h5>
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label class="text-capitalize">Offer Code</label>
                                <input class="form-control" value="{{ $offer->offer_code }}" type="text" readonly disabled style="background-color: #f8f9fa;">
                                <small class="form-text text-muted">Pattern: CATEGORY-SUBCATEGORY-NUMBER</small>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="text-capitalize">Offer Number</label>
                                <input class="form-control" value="{{ old('offer_number', $offer->offer_number) }}" type="text" name="offer_number" placeholder="e.g., 001, A-001">
                                <small class="form-text text-muted">Used in offer code generation</small>
                                @error('offer_number')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group col-md-3">
                                <label class="text-capitalize">English Title <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <input class="form-control" value="{{ old('title_english', $offer->title_english) }}" type="text" name="title_english" required>
                                @error('title_english')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group col-md-3">
                                <label class="text-capitalize">Arabic Title <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <input class="form-control" value="{{ old('title_arabic', $offer->title_arabic) }}" type="text" name="title_arabic" required>
                                @error('title_arabic')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <!-- Classifications -->
                        <h5 class="mb-3 mt-4 text-primary">Classifications</h5>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Offer Category <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <select class="form-control select2" name="category_id" id="category_id" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $offer->category_id) == $category->id ? 'selected' : '' }}>{{ $category->title_english }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Offer Sub Category</label>
                                <select class="form-control select2" name="subcategory_id" id="subcategory_id">
                                    <option value="">Select Sub Category</option>
                                    @foreach($subcategories as $subcategory)
                                        <option value="{{ $subcategory->id }}" {{ old('subcategory_id', $offer->subcategory_id) == $subcategory->id ? 'selected' : '' }}>{{ $subcategory->title_english }}</option>
                                    @endforeach
                                </select>
                                @error('subcategory_id')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label class="text-capitalize">Type <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <select class="form-control select2" name="type_id" required>
                                    <option value="">Select Type</option>
                                    @foreach($types as $type)
                                        <option value="{{ $type->id }}" {{ old('type_id', $offer->type_id) == $type->id ? 'selected' : '' }}>{{ $type->name_english }}</option>
                                    @endforeach
                                </select>
                                @error('type_id')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label class="text-capitalize">Style</label>
                                <select class="form-control select2" name="style_id">
                                    <option value="">Select Style</option>
                                    @foreach($styles as $style)
                                        <option value="{{ $style->id }}" {{ old('style_id', $offer->style_id) == $style->id ? 'selected' : '' }}>{{ $style->title_english }}</option>
                                    @endforeach
                                </select>
                                @error('style_id')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label class="text-capitalize">Currency</label>
                                <select class="form-control select2" name="currency_id">
                                    <option value="">Select Currency</option>
                                    @foreach($currencies as $currency)
                                        <option value="{{ $currency->id }}" {{ old('currency_id', $offer->currency_id) == $currency->id ? 'selected' : '' }}>{{ $currency->name_english }} ({{ $currency->abbreviation }})</option>
                                    @endforeach
                                </select>
                                @error('currency_id')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <!-- Area Measurements -->
                        <h5 class="mb-3 mt-4 text-primary">Area Measurements</h5>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Square Feet (SQFT)</label>
                                <input class="form-control" value="{{ old('sqft', $offer->sqft) }}" type="number" step="0.01" name="sqft" id="sqft" placeholder="Enter area in square feet">
                                <small class="form-text text-muted">Enter value - SQM will be calculated automatically</small>
                                @error('sqft')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Square Meters (SQM) <span class="badge badge-info">Auto-calculated</span></label>
                                <input class="form-control" value="{{ old('sqm', $offer->sqm) }}" type="number" step="0.01" name="sqm" id="sqm" placeholder="Auto-calculated from SQFT" readonly>
                                <small class="form-text text-muted">1 SQFT = 0.092903 SQM</small>
                                @error('sqm')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <!-- URLs -->
                        <h5 class="mb-3 mt-4 text-primary">Media URLs</h5>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Video URL</label>
                                <input class="form-control" value="{{ old('video_url', $offer->video_url) }}" type="url" name="video_url" placeholder="https://youtube.com/...">
                                @error('video_url')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Virtual Tour URL</label>
                                <input class="form-control" value="{{ old('tour_url', $offer->tour_url) }}" type="url" name="tour_url" placeholder="https://...">
                                @error('tour_url')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <!-- Images -->
                        <h5 class="mb-3 mt-4 text-primary">Offer Images</h5>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Main Image (903x1146)</label>
                                <input accept="image/*" class="form-control dropify" type="file" name="main_image" data-default-file="{{ asset('storage' . $offer->main_image) }}">
                                <small class="form-text text-muted">Leave empty to keep current image. Recommended: 903x1146 pixels. Will be converted to WebP with 80% quality.</small>
                                @error('main_image')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Offer File (PDF)</label>
                                <input accept=".pdf,application/pdf" class="form-control dropify" type="file" name="plan_2d_image">
                                @if($offer->plan_2d_image)
                                    <small class="form-text text-muted">Current file: <a href="{{ asset('storage' . $offer->plan_2d_image) }}" target="_blank">View PDF</a></small>
                                @endif
                                <small class="form-text text-muted">Upload offer file in PDF format. Max size: 10MB.</small>
                                @error('plan_2d_image')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">3D Image (903x1146)</label>
                                <input accept="image/*" class="form-control dropify" type="file" name="plan_3d_image" data-default-file="{{ $offer->plan_3d_image ? asset('storage' . $offer->plan_3d_image) : '' }}">
                                <small class="form-text text-muted">Recommended: 903x1146 pixels (Portrait). Will be converted to WebP.</small>
                                @error('plan_3d_image')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <!-- Bio -->
                        <h5 class="mb-3 mt-4 text-primary">Bio (Short Description)</h5>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Bio English (Max 500 characters)</label>
                                <textarea class="form-control" id="bio_english" name="bio_english" rows="3" maxlength="500">{{ old('bio_english', $offer->bio_english) }}</textarea>
                                <small class="form-text text-muted">
                                    <span id="bio_english_count">0</span> / 500 characters
                                </small>
                                @error('bio_english')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Bio Arabic (Max 500 characters)</label>
                                <textarea class="form-control" id="bio_arabic" name="bio_arabic" rows="3" maxlength="500">{{ old('bio_arabic', $offer->bio_arabic) }}</textarea>
                                <small class="form-text text-muted">
                                    <span id="bio_arabic_count">0</span> / 500 characters
                                </small>
                                @error('bio_arabic')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <!-- Full Description -->
                        <h5 class="mb-3 mt-4 text-primary">Full Description</h5>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label class="text-capitalize">Description English (Max 3000 characters)</label>
                                <textarea id="elm1" class="form-control" name="description_english">{!! old('description_english', $offer->description_english) !!}</textarea>
                                @error('description_english')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group col-md-12">
                                <label class="text-capitalize">Description Arabic (Max 3000 characters)</label>
                                <textarea id="elm2" class="form-control" name="description_arabic">{!! old('description_arabic', $offer->description_arabic) !!}</textarea>
                                @error('description_arabic')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <!-- SEO -->
                        <h5 class="mb-3 mt-4 text-primary">SEO Information</h5>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label>SEO Tags <span class="text-muted">Press Enter After You Type</span></label>
                                <input name="seo_tags" value="{{ old('seo_tags', $offer->seo_tags) }}" class="tagify form-control">
                                @error('seo_tags')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label>SEO Description (English)</label>
                                <textarea name="seo_description_english" class="form-control" maxlength="1000" rows="3">{{ old('seo_description_english', $offer->seo_description_english) }}</textarea>
                                @error('seo_description_english')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label>SEO Description (Arabic)</label>
                                <textarea name="seo_description_arabic" class="form-control" maxlength="1000" rows="3">{{ old('seo_description_arabic', $offer->seo_description_arabic) }}</textarea>
                                @error('seo_description_arabic')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <!-- Status -->
                        <h5 class="mb-3 mt-4 text-primary">Status Settings</h5>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Publish Status <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <select class="form-control" name="publish_status" required>
                                    <option value="">Select Status</option>
                                    <option value="0" {{ old('publish_status', $offer->publish_status) == '0' ? 'selected' : '' }}>Published</option>
                                    <option value="1" {{ old('publish_status', $offer->publish_status) == '1' ? 'selected' : '' }}>Unpublished</option>
                                </select>
                                @error('publish_status')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Home Status <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <select class="form-control" name="home_status" required>
                                    <option value="">Select Status</option>
                                    <option value="0" {{ old('home_status', $offer->home_status) == '0' ? 'selected' : '' }}>Shown on Home</option>
                                    <option value="1" {{ old('home_status', $offer->home_status) == '1' ? 'selected' : '' }}>Not Shown on Home</option>
                                </select>
                                @error('home_status')<span class="text-danger mt-1">{{ $message }}</span>@enderror
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
    // Auto-calculate SQM from SQFT
    document.getElementById('sqft').addEventListener('input', function() {
        const sqft = parseFloat(this.value) || 0;
        const sqm = (sqft * 0.092903).toFixed(2);
        document.getElementById('sqm').value = sqm;
    });

    // Load subcategories when category changes
    $('#category_id').on('change', function() {
        const categoryId = $(this).val();
        const subcategorySelect = $('#subcategory_id');
        
        if (!categoryId) {
            subcategorySelect.empty().append('<option value="">Select Sub Category</option>').trigger('change');
            return;
        }
        
        // Show loading state
        subcategorySelect.empty().append('<option value="">Loading...</option>').trigger('change');
        
        fetch(`{{ route('offer.subcategories') }}?category_id=${categoryId}`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Subcategories received:', data);
            subcategorySelect.empty().append('<option value="">Select Sub Category</option>');
            
            if (data && data.length > 0) {
                data.forEach(subcategory => {
                    const option = new Option(subcategory.title_english, subcategory.id, false, false);
                    subcategorySelect.append(option);
                });
            } else {
                subcategorySelect.empty().append('<option value="">No subcategories available</option>');
            }
            
            // Trigger change to update Select2
            subcategorySelect.trigger('change');
        })
        .catch(error => {
            console.error('Error loading subcategories:', error);
            subcategorySelect.empty().append('<option value="">Error loading subcategories</option>').trigger('change');
        });
    });

    // Character counter for Bio English
    const bioEnglish = document.getElementById('bio_english');
    const bioEnglishCount = document.getElementById('bio_english_count');
    
    function updateBioEnglishCount() {
        const count = bioEnglish.value.length;
        bioEnglishCount.textContent = count;
        if (count > 450) {
            bioEnglishCount.style.color = '#dc3545'; // Red when close to limit
        } else if (count > 400) {
            bioEnglishCount.style.color = '#ffc107'; // Yellow warning
        } else {
            bioEnglishCount.style.color = '#6c757d'; // Default gray
        }
    }
    
    bioEnglish.addEventListener('input', updateBioEnglishCount);
    updateBioEnglishCount(); // Initial count on page load

    // Character counter for Bio Arabic
    const bioArabic = document.getElementById('bio_arabic');
    const bioArabicCount = document.getElementById('bio_arabic_count');
    
    function updateBioArabicCount() {
        const count = bioArabic.value.length;
        bioArabicCount.textContent = count;
        if (count > 450) {
            bioArabicCount.style.color = '#dc3545'; // Red when close to limit
        } else if (count > 400) {
            bioArabicCount.style.color = '#ffc107'; // Yellow warning
        } else {
            bioArabicCount.style.color = '#6c757d'; // Default gray
        }
    }
    
    bioArabic.addEventListener('input', updateBioArabicCount);
    updateBioArabicCount(); // Initial count on page load
</script>
@endsection

