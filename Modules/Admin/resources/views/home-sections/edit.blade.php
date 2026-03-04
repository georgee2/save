@extends('admin::layouts.master')
@section('title', 'Edit Home Section')
@section('css')
<link rel="stylesheet" href="{{ asset('/css/auto-translate.css') }}">
@endsection

@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Admin')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a href="{{route('home-sections.index')}}" class="breadcrumbs__item"><i class="fa fa-th-list"></i> Home Sections</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-edit"></i> Edit Section</a>
        </nav>

        <div class="col-12 mx-auto">
            <hr>
            <div class="card m-b-20">
                <div class="card-body">
                    <div class="title d-flex justify-content-between">
                        <h4 class="mt-0 mb-0 header-title align-self-center text-capitalize">
                            <i class="{{ $section->icon ?? 'fa fa-puzzle-piece' }}"></i> Edit: {{ $section->title_english }}
                        </h4>
                        <div class="buttons">
                            <a href="{{ route('home-sections.index') }}" class="mr-2">
                                <button class="btn btn-new"><i class="fa fa-list"></i> Sections List</button>
                            </a>
                            <button class="btn btn-primary" onclick="window.history.back()">
                                <i class="fa fa-angle-left"></i> Back
                            </button>
                        </div>
                    </div>
                    <hr>
                    
                    <form action="{{ route('home-sections.update', $section->id) }}" method="POST">
                        @csrf

                        <div class="mb-3 text-right">
                            <button type="button" class="translate-all-btn"><i class="fa fa-language"></i> Translate All to Arabic</button>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-capitalize">Section Name <span class="text-muted">(Read Only)</span></label>
                                    <input class="form-control" type="text" value="{{ $section->name }}" readonly disabled style="background: #f8f9fa;">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-capitalize">Blade View <span class="text-muted">(Read Only)</span></label>
                                    <input class="form-control" type="text" value="{{ $section->blade_view }}" readonly disabled style="background: #f8f9fa; font-family: monospace;">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-capitalize">Title English <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                    <input class="form-control" type="text" name="title_english" value="{{ old('title_english', $section->title_english) }}" required>
                                    @error('title_english')
                                    <span class="text-danger mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-capitalize">Title Arabic <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i> <button type="button" class="auto-translate-btn" data-translate-source="title_english" data-translate-target="title_arabic"><i class="fa fa-language"></i> Auto</button></label>
                                    <input class="form-control" type="text" name="title_arabic" value="{{ old('title_arabic', $section->title_arabic) }}" required>
                                    @error('title_arabic')
                                    <span class="text-danger mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="text-capitalize">Icon Class</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="{{ $section->icon ?? 'fa fa-puzzle-piece' }}" id="icon-preview"></i></span>
                                        </div>
                                        <input class="form-control" type="text" name="icon" id="icon-input" value="{{ old('icon', $section->icon) }}" placeholder="fa fa-icon-name">
                                    </div>
                                    <small class="form-text text-muted">FontAwesome icon class (e.g., fa fa-home)</small>
                                    @error('icon')
                                    <span class="text-danger mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="text-capitalize">Display Order <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                    <input class="form-control" type="number" name="ordering" value="{{ old('ordering', $section->ordering) }}" min="0" required>
                                    @error('ordering')
                                    <span class="text-danger mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="text-capitalize">Status <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                    <select class="form-control" name="status" required>
                                        <option value="0" {{ old('status', $section->status) == '0' ? 'selected' : '' }}>Active (Visible)</option>
                                        <option value="1" {{ old('status', $section->status) == '1' ? 'selected' : '' }}>Inactive (Hidden)</option>
                                    </select>
                                    @error('status')
                                    <span class="text-danger mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-capitalize">Show Divider After Section <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                    <select class="form-control" name="show_divider" required>
                                        <option value="0" {{ old('show_divider', $section->show_divider) == '0' ? 'selected' : '' }}>Yes - Show Divider</option>
                                        <option value="1" {{ old('show_divider', $section->show_divider) == '1' ? 'selected' : '' }}>No - Hide Divider</option>
                                    </select>
                                    <small class="form-text text-muted">Whether to show a visual divider after this section</small>
                                    @error('show_divider')
                                    <span class="text-danger mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-capitalize">Description</label>
                                    <textarea class="form-control" name="description" rows="3" maxlength="500" placeholder="Optional description for this section">{{ old('description', $section->description) }}</textarea>
                                    @error('description')
                                    <span class="text-danger mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <hr>
                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-dark waves-effect waves-light mr-2">
                                <i class="fa fa-save"></i> Update Section
                            </button>
                            <button type="reset" class="btn btn-primary waves-effect m-l-5" onclick="window.history.back()">
                                Cancel
                            </button>
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
<script>
    // Live icon preview
    document.getElementById('icon-input').addEventListener('input', function() {
        const iconPreview = document.getElementById('icon-preview');
        iconPreview.className = this.value || 'fa fa-puzzle-piece';
    });
</script>
@endsection
