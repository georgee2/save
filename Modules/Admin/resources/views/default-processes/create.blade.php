@extends('admin::layouts.master')
@section('title', 'Create Default Process')

@section('css')
<style>
    .word-count { font-size: 12px; color: #6c757d; margin-top: 5px; }
    .word-count.error { color: #dc3545; font-weight: bold; }
    .char-count { font-size: 12px; color: #6c757d; margin-top: 5px; }
    .char-count.error { color: #dc3545; font-weight: bold; }
</style>
@endsection

@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        <nav class="breadcrumbs">
            <a href="{{route('Admin')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a href="{{route('admin.default-processes.index')}}" class="breadcrumbs__item"><i class="fa fa-cogs"></i> Default Processes</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-plus"></i> Create</a>
        </nav>

        <div class="col-lg-12">
            <hr>
            <div class="card">
                <div class="card-body">
                    <h4 class="mt-0 header-title"><i class="fa fa-plus"></i> Create New Default Process</h4>
                    <hr>
                    
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <form action="{{ route('admin.default-processes.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Title English <i class="mdi mdi-18px mdi-alert-octagon text-danger"></i> <small>(Max 5 Words)</small></label>
                                    <input type="text" class="form-control" name="title_english" value="{{ old('title_english') }}" required maxlength="150" id="title_english">
                                    <div class="word-count" id="title_english_count">0 / 5 words</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Title Arabic <i class="mdi mdi-18px mdi-alert-octagon text-danger"></i> <small>(Max 5 Words)</small></label>
                                    <input type="text" class="form-control" name="title_arabic" value="{{ old('title_arabic') }}" required maxlength="150" dir="rtl" id="title_arabic">
                                    <div class="word-count" id="title_arabic_count">0 / 5 words</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Sub Title English <i class="mdi mdi-18px mdi-alert-octagon text-danger"></i> <small>(Max 3 Words)</small></label>
                                    <input type="text" class="form-control" name="sub_title_english" value="{{ old('sub_title_english') }}" required maxlength="100" id="sub_title_english">
                                    <div class="word-count" id="sub_title_english_count">0 / 3 words</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Sub Title Arabic <i class="mdi mdi-18px mdi-alert-octagon text-danger"></i> <small>(Max 3 Words)</small></label>
                                    <input type="text" class="form-control" name="sub_title_arabic" value="{{ old('sub_title_arabic') }}" required maxlength="100" dir="rtl" id="sub_title_arabic">
                                    <div class="word-count" id="sub_title_arabic_count">0 / 3 words</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Bio English <small>(Optional, Max 150 Char)</small></label>
                                    <textarea class="form-control" name="bio_english" rows="3" maxlength="150" id="bio_english">{{ old('bio_english') }}</textarea>
                                    <div class="char-count" id="bio_english_count">0 / 150 characters</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Bio Arabic <small>(Optional, Max 150 Char)</small></label>
                                    <textarea class="form-control" name="bio_arabic" rows="3" maxlength="150" dir="rtl" id="bio_arabic">{{ old('bio_arabic') }}</textarea>
                                    <div class="char-count" id="bio_arabic_count">0 / 150 characters</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Button Text English <small>(Optional, Max 2 Words)</small></label>
                                    <input type="text" class="form-control" name="button_text_english" value="{{ old('button_text_english') }}" maxlength="50" id="button_text_english">
                                    <div class="word-count" id="button_text_english_count">0 / 2 words</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Button Text Arabic <small>(Optional, Max 2 Words)</small></label>
                                    <input type="text" class="form-control" name="button_text_arabic" value="{{ old('button_text_arabic') }}" maxlength="50" dir="rtl" id="button_text_arabic">
                                    <div class="word-count" id="button_text_arabic_count">0 / 2 words</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>URL English <small>(Optional)</small></label>
                                    <input type="url" class="form-control" name="url_english" value="{{ old('url_english') }}" placeholder="https://example.com">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>URL Arabic <small>(Optional)</small></label>
                                    <input type="url" class="form-control" name="url_arabic" value="{{ old('url_arabic') }}" placeholder="https://example.com" dir="rtl">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Status <i class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                    <select class="form-control" name="status" required>
                                        <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Active</option>
                                        <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Not Active</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <hr>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Create Process</button>
                            <a href="{{ route('admin.default-processes.index') }}" class="btn btn-secondary"><i class="fa fa-times"></i> Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        function updateWordCount(selector, countSelector, maxWords) {
            const text = $(selector).val().trim();
            const wordCount = text === '' ? 0 : text.split(/\s+/).length;
            $(countSelector).text(wordCount + ' / ' + maxWords + ' words');
            if (wordCount > maxWords) $(countSelector).addClass('error'); else $(countSelector).removeClass('error');
        }
        
        function updateCharCount(selector, countSelector, maxChars) {
            const text = $(selector).val();
            $(countSelector).text(text.length + ' / ' + maxChars + ' characters');
            if (text.length > maxChars) $(countSelector).addClass('error'); else $(countSelector).removeClass('error');
        }
        
        $('#title_english').on('input', function() { updateWordCount('#title_english', '#title_english_count', 5); });
        $('#title_arabic').on('input', function() { updateWordCount('#title_arabic', '#title_arabic_count', 5); });
        $('#sub_title_english').on('input', function() { updateWordCount('#sub_title_english', '#sub_title_english_count', 3); });
        $('#sub_title_arabic').on('input', function() { updateWordCount('#sub_title_arabic', '#sub_title_arabic_count', 3); });
        $('#button_text_english').on('input', function() { updateWordCount('#button_text_english', '#button_text_english_count', 2); });
        $('#button_text_arabic').on('input', function() { updateWordCount('#button_text_arabic', '#button_text_arabic_count', 2); });
        $('#bio_english').on('input', function() { updateCharCount('#bio_english', '#bio_english_count', 150); });
        $('#bio_arabic').on('input', function() { updateCharCount('#bio_arabic', '#bio_arabic_count', 150); });
    });
</script>
@endsection

