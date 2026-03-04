@extends('admin::layouts.master')
@section('title', 'Edit Portfolio Type')
@section('css')
<link rel="stylesheet" href="{{ asset('/css/auto-translate.css') }}">
@endsection
@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Basicdata')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a href="{{route('portfoliotype.index')}}" class="breadcrumbs__item"><i class="fa fa-list"></i> Portfolio Types List</a>
            <a style="pointer-events: none;" href="#checkout" class="breadcrumbs__item is-active"><i class="fa fa-check"></i> Edit Portfolio Type</a> 
        </nav>

        <div class="col-12 mx-auto">
            <hr>
            <div class="card m-b-20">
                <div class="card-body">
                    <div class="title d-flex justify-content-between">
                        <h4 class="mt-0 mb-0 header-title align-self-center text-capitalize">Edit Portfolio Type</h4>
                        <div class="buttons">
                            <a href="{{ route('portfoliotype.index') }}" class="mr-2">
                                <button class="btn btn-new"><i class="fa fa-list"></i>
                                    Portfolio Types List</button>
                            </a>
                            <button class="btn btn-primary" onclick="window.history.back()">
                                <i class="fa fa-angle-left"></i>
                                Back
                            </button>
                        </div>
                    </div>
                    <hr>
                    <form action="{{ route('portfoliotype.update', ['id' => $portfolioType->id]) }}" method="POST">
                        @csrf
                        <div class="mb-3 text-right">
                            <button type="button" class="translate-all-btn"><i class="fa fa-language"></i> Translate All to Arabic</button>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">English Name <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <input class="form-control" value="{{old('name_english', $portfolioType->name_english)}}" type="text" name="name_english">
                                @error('name_english')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Arabic Name <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i> <button type="button" class="auto-translate-btn" data-translate-source="name_english" data-translate-target="name_arabic"><i class="fa fa-language"></i> Auto</button></label>
                                <input class="form-control" value="{{old('name_arabic', $portfolioType->name_arabic)}}" type="text" name="name_arabic">
                                @error('name_arabic')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-12">
                                <label class="text-capitalize">Status <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <select class="form-control" name="status">
                                    <option value="0" {{ old('status', $portfolioType->status) == 0 ? 'selected' : '' }}>Active</option>
                                    <option value="1" {{ old('status', $portfolioType->status) == 1 ? 'selected' : '' }}>Not Active</option>
                                </select>
                                @error('status')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <hr>
                        <div class="form-group mb-0">
                            <div>
                                <button type="submit" class="btn btn-dark waves-effect waves-light mr-2">
                                    Submit
                                </button>
                                <button type="reset" class="btn btn-primary waves-effect m-l-5"
                                    onclick="window.history.back()">
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
@endsection

