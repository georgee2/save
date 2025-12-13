@extends('admin::layouts.master')
@section('title', 'Home FAQs List')
@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Admin')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-list"></i> Home FAQs</a>
        </nav>

        <div class="col-12 mx-auto">
            <hr>
            <div class="card m-b-20">
                <div class="card-body">
                    <div class="title d-flex justify-content-between">
                        <h4 class="mt-0 mb-0 header-title align-self-center text-capitalize">Home FAQs List</h4>
                        <div class="buttons">
                            <a href="{{ route('homefaq.create') }}" class="mr-2">
                                <button class="btn btn-success"><i class="fa fa-plus"></i>
                                    Add New FAQ</button>
                            </a>
                            <a href="{{ route('homefaq.trashed') }}" class="mr-2">
                                <button class="btn btn-warning"><i class="fa fa-trash"></i>
                                    Trashed FAQs</button>
                            </a>
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

