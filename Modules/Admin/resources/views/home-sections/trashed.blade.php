@extends('admin::layouts.master')
@section('title', 'Trashed Home Sections')

@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endsection

@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Admin')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a href="{{route('home-sections.index')}}" class="breadcrumbs__item"><i class="fa fa-th-list"></i> Home Sections</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-trash"></i> Trashed</a>
        </nav>

        <div class="col-lg-12">
            <hr>
            
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <h4 class="mt-0 header-title"><i class="fa fa-trash"></i> Trashed Home Sections</h4>
                        </div>
                        <div class="col-sm-6 text-right">
                            <a href="{{ route('home-sections.index') }}" class="btn btn-primary btn-sm">
                                <i class="fa fa-arrow-left"></i> Back to Sections
                            </a>
                        </div>
                    </div>
                    <hr>
                    
                    @if(count($sections) > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th style="width: 60px;">ID</th>
                                    <th>Section Name</th>
                                    <th>Title (English)</th>
                                    <th>Title (Arabic)</th>
                                    <th style="width: 150px;">Deleted At</th>
                                    <th style="width: 100px; text-align: center;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sections as $section)
                                <tr>
                                    <td>{{ $section->id }}</td>
                                    <td><code>{{ $section->name }}</code></td>
                                    <td>{{ $section->title_english }}</td>
                                    <td>{{ $section->title_arabic }}</td>
                                    <td>{{ $section->deleted_at ? \Carbon\Carbon::parse($section->deleted_at)->format('M d, Y H:i') : '-' }}</td>
                                    <td style="text-align: center;">
                                        <form action="{{ route('home-sections.restore', $section->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm" title="Restore Section">
                                                <i class="fa fa-undo"></i> Restore
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="alert alert-info text-center">
                        <i class="fa fa-info-circle fa-2x mb-2"></i>
                        <p class="mb-0">No trashed sections found.</p>
                    </div>
                    @endif
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
