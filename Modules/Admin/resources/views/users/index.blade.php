@extends('admin::layouts.master')
@section('title' , 'Users List')
@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
                  <a href="{{route('Admin')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
                  <a style="pointer-events: none;" href="#checkout" class="breadcrumbs__item is-active"><i class="fa fa-check"></i> Users List</a> 
                </nav>

        <div class="col-lg-12">
            <hr>
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="mt-0 header-title align-self-center">
                            Users List</h4>
                        <div class="buttons">
                            <a href="{{ route('users.create') }}" class="mr-2">
                                <button class="btn btn-new"><i class="fa fa-plus"></i> Add Users</button>
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