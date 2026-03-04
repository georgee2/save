@extends('admin::layouts.master')
@section('title', 'Edit Process Card')

@section('css')
<link rel="stylesheet" href="{{ asset('/css/auto-translate.css') }}">
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
            <a href="{{route('admin.default-processes.index')}}" class="breadcrumbs__item"><i class="fa fa-cogs"></i> Processes</a>
            <a href="{{route('admin.default-process-cards.index', ['processId' => $process->id])}}" class="breadcrumbs__item"><i class="fa fa-list"></i> Cards</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-edit"></i> Edit Card</a>
        </nav>

        <div class="col-lg-12">
            <hr>
            <div class="card">
                <div class="card-body">
                    <h4 class="mt-0 header-title"><i class="fa fa-edit"></i> Edit Card</h4>
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
                    
                    <form action="{{ route('admin.default-process-cards.update', ['processId' => $process->id, 'id' => $card->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3 text-right">
                            <button type="button" class="translate-all-btn"><i class="fa fa-language"></i> Translate All to Arabic</button>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Title English <i class="mdi mdi-18px mdi-alert-octagon text-danger"></i> <small>(Max 5 Words)</small></label>
                                    <input type="text" class="form-control" name="title_english" value="{{ old('title_english', $card->title_english) }}" required maxlength="150" id="title_english">
                                    <div class="word-count" id="title_english_count">0 / 5 words</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Title Arabic <button type="button" class="auto-translate-btn" data-translate-source="title_english" data-translate-target="title_arabic"><i class="fa fa-language"></i> Auto</button> <i class="mdi mdi-18px mdi-alert-octagon text-danger"></i> <small>(Max 5 Words)</small></label>
                                    <input type="text" class="form-control" name="title_arabic" value="{{ old('title_arabic', $card->title_arabic) }}" required maxlength="150" dir="rtl" id="title_arabic">
                                    <div class="word-count" id="title_arabic_count">0 / 5 words</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Bio English <i class="mdi mdi-18px mdi-alert-octagon text-danger"></i> <small>(Max 300 Char)</small></label>
                                    <textarea class="form-control" name="bio_english" rows="4" required maxlength="300" id="bio_english">{{ old('bio_english', $card->bio_english) }}</textarea>
                                    <div class="char-count" id="bio_english_count">0 / 300 characters</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Bio Arabic <button type="button" class="auto-translate-btn" data-translate-source="bio_english" data-translate-target="bio_arabic"><i class="fa fa-language"></i> Auto</button> <i class="mdi mdi-18px mdi-alert-octagon text-danger"></i> <small>(Max 300 Char)</small></label>
                                    <textarea class="form-control" name="bio_arabic" rows="4" required maxlength="300" dir="rtl" id="bio_arabic">{{ old('bio_arabic', $card->bio_arabic) }}</textarea>
                                    <div class="char-count" id="bio_arabic_count">0 / 300 characters</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Ordering <i class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                    <input type="number" class="form-control" name="ordering" value="{{ old('ordering', $card->ordering) }}" required min="0">
                                    <small class="form-text text-muted">Lower numbers appear first</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Status <i class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                    <select class="form-control" name="status" required>
                                        <option value="0" {{ old('status', $card->status) == '0' ? 'selected' : '' }}>Active</option>
                                        <option value="1" {{ old('status', $card->status) == '1' ? 'selected' : '' }}>Not Active</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <hr>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Update Card</button>
                            <a href="{{ route('admin.default-process-cards.index', ['processId' => $process->id]) }}" class="btn btn-secondary"><i class="fa fa-times"></i> Cancel</a>
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
        
        // Initialize counts
        updateWordCount('#title_english', '#title_english_count', 5);
        updateWordCount('#title_arabic', '#title_arabic_count', 5);
        updateCharCount('#bio_english', '#bio_english_count', 300);
        updateCharCount('#bio_arabic', '#bio_arabic_count', 300);
        
        $('#title_english').on('input', function() { updateWordCount('#title_english', '#title_english_count', 5); });
        $('#title_arabic').on('input', function() { updateWordCount('#title_arabic', '#title_arabic_count', 5); });
        $('#bio_english').on('input', function() { updateCharCount('#bio_english', '#bio_english_count', 300); });
        $('#bio_arabic').on('input', function() { updateCharCount('#bio_arabic', '#bio_arabic_count', 300); });
    });
</script>
@endsection

