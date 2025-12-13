@extends('admin::layouts.master')
@section('title', 'Edit Currency')
@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        <nav class="breadcrumbs">
            <a href="{{route('Basicdata')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a href="{{route('currency.index')}}" class="breadcrumbs__item"><i class="fa fa-money"></i> Currencies List</a>
            <a style="pointer-events: none;" href="#checkout" class="breadcrumbs__item is-active"><i class="fa fa-edit"></i> Edit Currency</a> 
        </nav>
        <div class="col-12 mx-auto">
            <hr>
            <div class="card m-b-20">
                <div class="card-body">
                    <div class="title d-flex justify-content-between">
                        <h4 class="mt-0 mb-0 header-title align-self-center text-capitalize">Edit Currency: {{ $currency->name_english }}</h4>
                        <div class="buttons">
                            <a href="{{ route('currency.index') }}" class="mr-2"><button class="btn btn-new"><i class="fa fa-list"></i> Currencies List</button></a>
                            <button class="btn btn-primary" onclick="window.history.back()"><i class="fa fa-angle-left"></i> Back</button>
                        </div>
                    </div>
                    <hr>
                    <form action="{{ route('currency.update', ['id' => $currency->id]) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">English Name <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <input class="form-control" value="{{old('name_english', $currency->name_english)}}" type="text" name="name_english" placeholder="e.g., US Dollar" required>
                                @error('name_english')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Arabic Name <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <input class="form-control" value="{{old('name_arabic', $currency->name_arabic)}}" type="text" name="name_arabic" placeholder="e.g., دولار أمريكي" required>
                                @error('name_arabic')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Abbreviation <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <input class="form-control" value="{{old('abbreviation', $currency->abbreviation)}}" type="text" name="abbreviation" placeholder="e.g., USD, SAR, AED" maxlength="10" required>
                                <small class="form-text text-muted">Enter currency code (e.g., USD, EUR, SAR)</small>
                                @error('abbreviation')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-capitalize">Status <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                                <select class="form-control" name="status" required>
                                    <option value="">Select Status</option>
                                    <option value="0" {{ old('status', $currency->status) == '0' ? 'selected' : '' }}>Active</option>
                                    <option value="1" {{ old('status', $currency->status) == '1' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('status')<span class="text-danger mt-1">{{ $message }}</span>@enderror
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

