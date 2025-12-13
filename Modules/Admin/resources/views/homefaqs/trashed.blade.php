@extends('admin::layouts.master')
@section('title', 'Trashed FAQs')
@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Admin')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a href="{{route('homefaq.index')}}" class="breadcrumbs__item"><i class="fa fa-list"></i> Home FAQs</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-trash"></i> Trashed FAQs</a>
        </nav>

        <div class="col-12 mx-auto">
            <hr>
            <div class="card m-b-20">
                <div class="card-body">
                    <div class="title d-flex justify-content-between">
                        <h4 class="mt-0 mb-0 header-title align-self-center text-capitalize">Trashed FAQs</h4>
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
                    @include('admin::layouts.trashed')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

