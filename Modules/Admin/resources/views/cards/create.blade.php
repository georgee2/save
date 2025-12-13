@extends('admin::layouts.master')
@section('title', 'Add New Card')
@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Admin')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a href="{{route('card.index')}}" class="breadcrumbs__item"><i class="fa fa-id-card-o"></i> Cards List</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-plus"></i> Add New Card</a> 
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
                        <h4 class="mt-0 mb-0 header-title align-self-center text-capitalize">Add New Card</h4>
                        <div class="buttons">
                            <a href="{{ route('card.index') }}" class="mr-2">
                                <button class="btn btn-new"><i class="fa fa-list"></i> Cards List</button>
                            </a>
                            <button class="btn btn-primary" onclick="window.history.back()">
                                <i class="fa fa-angle-left"></i> Back
                            </button>
                        </div>
                    </div>
                    <hr>
                    
                    <form enctype="multipart/form-data" action="{{ route('card.store') }}" method="POST" id="cardForm">
                        @csrf
                        
                        <!-- Card Type & Home Block -->
                        <h5 class="mb-3 text-primary">Card Settings</h5>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Card Type <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <select class="form-control" name="card_type" id="card_type" required>
                                    <option value="">Select Card Type</option>
                                    <option value="card_with_background" {{ old('card_type') == 'card_with_background' ? 'selected' : '' }}>Card with Background</option>
                                    <option value="icon_card" {{ old('card_type') == 'icon_card' ? 'selected' : '' }}>Icon Card</option>
                                </select>
                                @error('card_type')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Home Block <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <select class="form-control select2" name="home_block_id" required>
                                    <option value="">Select Home Block</option>
                                    @foreach($homeBlocks as $homeBlock)
                                        <option value="{{ $homeBlock->id }}" {{ old('home_block_id') == $homeBlock->id ? 'selected' : '' }}>
                                            {{ $homeBlock->title_english }} - {{ $homeBlock->title_arabic }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('home_block_id')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <!-- Fields for Card with Background Type -->
                        <div id="card_with_background_fields" style="display: none;">
                            <h5 class="mb-3 mt-4 text-primary">Card with Background Details</h5>
                            <p class="text-muted">This card type includes only background image and icon.</p>
                            
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="text-capitalize">Background (420x345) <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                    <p class="text-muted small">Upload background image. Will be converted to 300x300 webp.</p>
                                    <input accept="image/*" class="form-control dropify" type="file" name="background" id="background_bg">
                                    @error('background')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="text-capitalize">Icon White (100x100) <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                    <p class="text-muted small">Upload white icon. Will be converted to 100x100 webp.</p>
                                    <input accept="image/*" class="form-control dropify" type="file" name="icon_white" id="icon_white_bg">
                                    @error('icon_white')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                                </div>
                            </div>
                        </div>

                        <!-- Fields for Icon Card Type -->
                        <div id="icon_card_fields" style="display: none;">
                            <h5 class="mb-3 mt-4 text-primary">Icon Card Details</h5>
                            <p class="text-muted">This card type includes icons and text content.</p>
                            
                            <!-- Title Information -->
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="text-capitalize">English Title <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i> <small class="text-muted">(Max 4 words)</small></label>
                                    <input class="form-control" value="{{old('title_english')}}" type="text" name="title_english" maxlength="100">
                                    <small class="text-muted">Character count: <span id="title_en_count">0</span>/100</small>
                                    @error('title_english')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="text-capitalize">Arabic Title <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i> <small class="text-muted">(Max 4 words)</small></label>
                                    <input class="form-control" value="{{old('title_arabic')}}" type="text" name="title_arabic" maxlength="100">
                                    <small class="text-muted">Character count: <span id="title_ar_count">0</span>/100</small>
                                    @error('title_arabic')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                                </div>
                            </div>

                            <!-- Bio Information -->
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="text-capitalize">Bio (English) <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i> <small class="text-muted">(Max 150 characters)</small></label>
                                    <textarea class="form-control" name="bio_english" rows="3" maxlength="150">{{old('bio_english')}}</textarea>
                                    <small class="text-muted">Character count: <span id="bio_en_count">0</span>/150</small>
                                    @error('bio_english')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="text-capitalize">Bio (Arabic) <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i> <small class="text-muted">(Max 150 characters)</small></label>
                                    <textarea class="form-control" name="bio_arabic" rows="3" maxlength="150">{{old('bio_arabic')}}</textarea>
                                    <small class="text-muted">Character count: <span id="bio_ar_count">0</span>/150</small>
                                    @error('bio_arabic')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                                </div>
                            </div>

                            <!-- Icons for Icon Card -->
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="text-capitalize">Icon Dark (100x100) <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                    <p class="text-muted small">Upload dark version icon. Will be converted to 100x100 webp.</p>
                                    <input accept="image/*" class="form-control dropify" type="file" name="icon_dark" id="icon_dark_icon">
                                    @error('icon_dark')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="text-capitalize">Icon White (100x100) <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                    <p class="text-muted small">Upload white version icon. Will be converted to 100x100 webp.</p>
                                    <input accept="image/*" class="form-control dropify" type="file" name="icon_white" id="icon_white_icon">
                                    @error('icon_white')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                                </div>
                            </div>
                        </div>

                        <!-- Status -->
                        <h5 class="mb-3 mt-4 text-primary">Status</h5>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Status <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <select class="form-control" name="status" required>
                                    <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Active</option>
                                    <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Not Active</option>
                                </select>
                                @error('status')<span class="text-danger mt-1">{{ $message }}</span>@enderror
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

@section('js')
<script src="{{ asset('/js/dropify.min.js') }}"></script>

<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Select an option",
            allowClear: true
        });

        // Initialize dropify
        $('.dropify').dropify();

        // Show/hide fields based on card type
        $('#card_type').on('change', function() {
            const cardType = $(this).val();
            
            if (cardType === 'card_with_background') {
                // Card with Background: show background + icon white
                $('#card_with_background_fields').show();
                $('#icon_card_fields').hide();
                
                // Set required for card_with_background fields
                $('#background_bg').prop('required', true);
                $('#icon_white_bg').prop('required', true);
                
                // Disable and unrequire icon_card fields
                $('#icon_card_fields input, #icon_card_fields textarea').prop('required', false).prop('disabled', true);
                
                // Enable card_with_background fields
                $('#background_bg').prop('disabled', false);
                $('#icon_white_bg').prop('disabled', false);
                
            } else if (cardType === 'icon_card') {
                // Icon Card: show text fields + icons
                $('#card_with_background_fields').hide();
                $('#icon_card_fields').show();
                
                // Set required for icon_card fields
                $('#icon_card_fields input[type="text"], #icon_card_fields textarea, #icon_card_fields input[type="file"]').prop('required', true);
                
                // Disable and unrequire card_with_background fields
                $('#background_bg').prop('required', false).prop('disabled', true);
                $('#icon_white_bg').prop('required', false).prop('disabled', true);
                
                // Enable icon_card fields
                $('#icon_card_fields input, #icon_card_fields textarea').prop('disabled', false);
                
            } else {
                $('#card_with_background_fields').hide();
                $('#icon_card_fields').hide();
            }
            
            // Reinitialize dropify after showing/hiding
            $('.dropify').dropify();
        });

        // Trigger on page load if old value exists
        @if(old('card_type'))
            $('#card_type').trigger('change');
        @endif

        // Character counters
        const fields = [
            { input: 'input[name="title_english"]', counter: 'title_en_count' },
            { input: 'input[name="title_arabic"]', counter: 'title_ar_count' },
            { input: 'textarea[name="bio_english"]', counter: 'bio_en_count' },
            { input: 'textarea[name="bio_arabic"]', counter: 'bio_ar_count' }
        ];

        fields.forEach(field => {
            const inputElement = document.querySelector(field.input);
            const counterElement = document.getElementById(field.counter);
            
            if (inputElement && counterElement) {
                counterElement.textContent = inputElement.value.length;
                inputElement.addEventListener('input', function() {
                    counterElement.textContent = this.value.length;
                });
            }
        });
    });
</script>
@endsection

