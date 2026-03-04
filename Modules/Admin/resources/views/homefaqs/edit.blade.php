@extends('admin::layouts.master')
@section('title', 'Edit FAQ')
@section('css')
<link rel="stylesheet" href="{{ asset('/css/auto-translate.css') }}">
@endsection
@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Admin')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a href="{{route('homefaq.index')}}" class="breadcrumbs__item"><i class="fa fa-list"></i> Home FAQs</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-edit"></i> Edit FAQ</a> 
        </nav>

        <div class="col-12 mx-auto">
            <hr>
            <div class="card m-b-20">
                <div class="card-body">
                    <div class="title d-flex justify-content-between">
                        <h4 class="mt-0 mb-0 header-title align-self-center text-capitalize">Edit FAQ</h4>
                        <div class="buttons">
                            <a href="{{ route('homefaq.index') }}" class="mr-2">
                                <button class="btn btn-new"><i class="fa fa-list"></i>
                                    FAQs List</button>
                            </a>
                            <button class="btn btn-primary" onclick="window.history.back()">
                                <i class="fa fa-angle-left"></i>
                                Back
                            </button>
                        </div>
                    </div>
                    <hr>
                    <form action="{{ route('homefaq.update', $faq->id) }}" method="POST">
                        @csrf
                        <div class="mb-3 text-right">
                            <button type="button" class="translate-all-btn"><i class="fa fa-language"></i> Translate All to Arabic</button>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Question English <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <input class="form-control" value="{{old('question_english', $faq->question_english)}}" type="text" name="question_english">
                                @error('question_english')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Question Arabic <button type="button" class="auto-translate-btn" data-translate-source="question_english" data-translate-target="question_arabic"><i class="fa fa-language"></i> Auto</button> <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <input class="form-control" value="{{old('question_arabic', $faq->question_arabic)}}" type="text" name="question_arabic">
                                @error('question_arabic')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-12">
                                <label class="text-capitalize">Answer English <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <textarea class="form-control" name="answer_english" rows="4">{{old('answer_english', $faq->answer_english)}}</textarea>
                                @error('answer_english')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-12">
                                <label class="text-capitalize">Answer Arabic <button type="button" class="auto-translate-btn" data-translate-source="answer_english" data-translate-target="answer_arabic"><i class="fa fa-language"></i> Auto</button> <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <textarea class="form-control" name="answer_arabic" rows="4">{{old('answer_arabic', $faq->answer_arabic)}}</textarea>
                                @error('answer_arabic')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Order <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <input class="form-control" value="{{old('order', $faq->order)}}" type="number" name="order" min="0">
                                @error('order')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                                <small class="form-text text-muted">Lower numbers appear first</small>
                            </div>

                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Status <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <select class="custom-select form-control" name="status">
                                    <option value="0" {{old('status', $faq->status) == 0 ? 'selected' : ''}}>Active</option>
                                    <option value="1" {{old('status', $faq->status) == 1 ? 'selected' : ''}}>Inactive</option>
                                </select>
                                @error('status')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-12 text-right">
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-save"></i> Update FAQ
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
@endsection

