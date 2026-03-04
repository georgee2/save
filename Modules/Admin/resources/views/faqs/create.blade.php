@extends('admin::layouts.master')
@section('title', 'Add New FAQ')
@section('css')
<link rel="stylesheet" href="{{ asset('/css/auto-translate.css') }}">
@endsection
@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Admin')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a href="{{route('faq.index')}}" class="breadcrumbs__item"><i class="fa fa-question-circle"></i> FAQs List</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-plus"></i> Add New FAQ</a> 
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
                    <h4 class="mt-0 header-title">Add New FAQ</h4>
                    <hr>
                    
                    <form action="{{ route('faq.store') }}" method="POST">
                        @csrf

                        <div class="mb-3 text-right">
                            <button type="button" class="translate-all-btn"><i class="fa fa-language"></i> Translate All to Arabic</button>
                        </div>
                        
                        <div class="row">
                            <!-- Question English -->
                            <div class="form-group col-md-12">
                                <label>Question (English) <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <textarea class="form-control" name="question_english" rows="2" required>{{ old('question_english') }}</textarea>
                            </div>
                            
                            <!-- Question Arabic -->
                            <div class="form-group col-md-12">
                                <label>Question (Arabic) <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i> <button type="button" class="auto-translate-btn" data-translate-source="question_english" data-translate-target="question_arabic"><i class="fa fa-language"></i> Auto</button></label>
                                <textarea class="form-control" name="question_arabic" rows="2" required>{{ old('question_arabic') }}</textarea>
                            </div>
                            
                            <!-- Answer English -->
                            <div class="form-group col-md-12">
                                <label>Answer (English) <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <textarea class="form-control" name="answer_english" rows="5" required>{{ old('answer_english') }}</textarea>
                            </div>
                            
                            <!-- Answer Arabic -->
                            <div class="form-group col-md-12">
                                <label>Answer (Arabic) <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i> <button type="button" class="auto-translate-btn" data-translate-source="answer_english" data-translate-target="answer_arabic"><i class="fa fa-language"></i> Auto</button></label>
                                <textarea class="form-control" name="answer_arabic" rows="5" required>{{ old('answer_arabic') }}</textarea>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-success waves-effect waves-light">
                                <i class="fa fa-save"></i> Save FAQ
                            </button>
                            <a href="{{ route('faq.index') }}" class="btn btn-secondary waves-effect">
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

