@extends('admin::layouts.master')
@section('title', 'Language Manager')
@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Admin')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-language"></i> Language Manager</a> 
        </nav>

        <div class="col-lg-12">
            <hr>
            
            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert" style="border-left: 4px solid #28a745; font-size: 16px; padding: 15px 20px;">
                    <i class="fa fa-check-circle" style="font-size: 20px;"></i> <strong>Success!</strong> {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert" style="border-left: 4px solid #dc3545; font-size: 16px; padding: 15px 20px;">
                    <i class="fa fa-exclamation-circle" style="font-size: 20px;"></i> <strong>Error!</strong> {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <h4 class="mt-0 header-title align-self-center">Language Keys Manager</h4>
                        <div class="buttons">
                            <button class="btn btn-primary" onclick="window.history.back()">
                                <i class="fa fa-angle-left"></i> Back
                            </button>
                        </div>
                    </div>
                    
                    <!-- Search Form -->
                    <form method="GET" action="{{ route('language.index') }}" class="mb-4">
                        <div class="row">
                            <div class="col-md-10">
                                <input type="text" name="search" class="form-control" placeholder="Search by key, English or Arabic text..." value="{{ $search }}">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fa fa-search"></i> Search
                                </button>
                            </div>
                        </div>
                        @if($search)
                            <div class="mt-2">
                                <a href="{{ route('language.index') }}" class="btn btn-sm btn-secondary">
                                    <i class="fa fa-times"></i> Clear Search
                                </a>
                            </div>
                        @endif
                    </form>
                    
                    <hr>
                    
                    <div class="alert alert-info">
                        <i class="fa fa-info-circle"></i> <strong>Total Keys:</strong> {{ $total }} | <strong>Showing:</strong> {{ count($languages) }} keys
                    </div>
                    
                    <table class="table table-striped table-bordered table-hover" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th style="width: 20%;">Key</th>
                                <th style="width: 35%;">English</th>
                                <th style="width: 35%;">Arabic</th>
                                <th style="width: 10%;">#Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($languages as $language)
                            <tr>
                                <td><code>{{ $language['key'] }}</code></td>
                                <td>{{ Str::limit($language['english'], 80) }}</td>
                                <td style="direction: rtl; text-align: right;">{{ Str::limit($language['arabic'], 80) }}</td>
                                <td>
                                    <a href="{{ route('language.edit', ['key' => $language['key']]) }}" class="btn btn-warning btn-sm" title="Edit">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center">
                                    @if($search)
                                        No results found for "{{ $search }}"
                                    @else
                                        No language keys found
                                    @endif
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    
                    <!-- Simple Pagination -->
                    @if($total > $perPage)
                        <div class="mt-3">
                            <nav>
                                <ul class="pagination justify-content-center">
                                    @php
                                        $totalPages = ceil($total / $perPage);
                                    @endphp
                                    
                                    @if($currentPage > 1)
                                        <li class="page-item">
                                            <a class="page-link" href="{{ route('language.index', ['page' => $currentPage - 1, 'search' => $search]) }}">Previous</a>
                                        </li>
                                    @endif
                                    
                                    @for($i = 1; $i <= $totalPages; $i++)
                                        <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                                            <a class="page-link" href="{{ route('language.index', ['page' => $i, 'search' => $search]) }}">{{ $i }}</a>
                                        </li>
                                    @endfor
                                    
                                    @if($currentPage < $totalPages)
                                        <li class="page-item">
                                            <a class="page-link" href="{{ route('language.index', ['page' => $currentPage + 1, 'search' => $search]) }}">Next</a>
                                        </li>
                                    @endif
                                </ul>
                            </nav>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

