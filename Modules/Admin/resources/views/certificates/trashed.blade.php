@extends('admin::layouts.master')
@section('title', 'Trashed Certificates')
@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Admin')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a href="{{route('certificate.index')}}" class="breadcrumbs__item"><i class="fa fa-certificate"></i> Certificates List</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-trash"></i> Trashed Certificates</a> 
        </nav>

        <div class="col-lg-12">
            <hr>
            
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert" style="border-left: 4px solid #28a745; font-size: 16px; padding: 15px 20px;">
                    <i class="fa fa-check-circle" style="font-size: 20px;"></i> <strong>Success!</strong> {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="mt-0 header-title align-self-center">Trashed Certificates</h4>
                        <div class="buttons">
                            <a href="{{ route('certificate.index') }}">
                                <button class="btn btn-primary"><i class="fa fa-angle-left"></i> Back to List</button>
                            </a>
                        </div>
                    </div>
                    <hr>
                    
                    <div class="alert alert-warning mb-3">
                        <i class="fa fa-exclamation-triangle mr-2"></i>
                        <strong>Note:</strong> These certificates have been soft deleted. You can restore them to make them active again.
                    </div>
                    
                    <table class="table table-striped table-bordered dt-responsive" style="width: 100%;">
                        <thead>
                            <tr>
                                <th style="width: 50px;">#</th>
                                <th style="width: 100px;">Image</th>
                                <th>Name (English)</th>
                                <th>Name (Arabic)</th>
                                <th>Deleted At</th>
                                <th style="width: 100px;">#Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($certificates as $index => $certificate)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>
                                    @if($certificate->image)
                                        <a data-lightbox="{{url('/storage'.$certificate->image)}}" href="{{url('/storage'.$certificate->image)}}">
                                            <img style="width:60px; height: 60px; object-fit: contain; border-radius: 8px; opacity: 0.6;" src="{{url('/storage'.$certificate->image)}}" alt="Certificate">
                                        </a>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td>{{ $certificate->name_english }}</td>
                                <td>{{ $certificate->name_arabic }}</td>
                                <td>
                                    <span class="text-muted">
                                        <i class="fa fa-clock-o mr-1"></i>
                                        {{ \Carbon\Carbon::parse($certificate->deleted_at)->format('M d, Y H:i') }}
                                    </span>
                                </td>
                                <td>
                                    <form action="{{ route('certificate.restore', ['id' => $certificate->id]) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm" title="Restore">
                                            <i class="fa fa-undo"></i> Restore
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if(count($certificates) == 0)
                    <div class="text-center text-muted py-4">
                        <i class="fa fa-trash-o fa-3x mb-3"></i>
                        <p>No trashed certificates found.</p>
                        <a href="{{ route('certificate.index') }}" class="btn btn-primary btn-sm">
                            <i class="fa fa-angle-left"></i> Back to Certificates List
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
