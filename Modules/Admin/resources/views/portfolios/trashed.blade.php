@extends('admin::layouts.master')
@section('title', 'Trashed Portfolios')
@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Admin')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a href="{{route('portfolio.index')}}" class="breadcrumbs__item"><i class="fa fa-list"></i> Portfolios List</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-trash"></i> Trashed Portfolios</a> 
        </nav>

        <div class="col-lg-12">
            <hr>
            
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fa fa-check-circle"></i> {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="mt-0 header-title align-self-center">
                            Trashed Portfolios</h4>
                        <div class="buttons">
                            <a href="{{ route('portfolio.index') }}" class="mr-2">
                                <button class="btn btn-new"><i class="fa fa-list"></i> Portfolios List</button>
                            </a>
                            <button class="btn btn-primary" onclick="window.history.back()">
                                <i class="fa fa-angle-left"></i>
                                Back
                            </button>
                        </div>
                    </div>
                    <hr>
                    @include('admin::layouts.tables')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

