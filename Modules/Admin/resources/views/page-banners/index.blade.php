@extends('admin::layouts.master')
@section('title', 'Page Banners')
@section('content')

<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav style="margin-left: 1px !important;" class="breadcrumbs">
            <a href="{{ route('Admin') }}" class="breadcrumbs__item">
                <i class="fa fa-home"></i> Dashboard
            </a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active">
                <i class="fa fa-image"></i> Page Banners
            </a>
        </nav>

        <hr>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="mt-0 header-title">Page Banners Management</h4>
                            <div>
                                <a href="{{ route('page-banner.create') }}" class="btn btn-primary">
                                    <i class="fa fa-plus"></i> Add New Banner
                                </a>
                                <a href="{{ route('page-banner.trashed') }}" class="btn btn-secondary">
                                    <i class="fa fa-trash"></i> Trashed Banners
                                </a>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Target Page</th>
                                        <th>Cover Image</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($banners as $banner)
                                    <tr>
                                        <td>{{ $banner->id }}</td>
                                        <td>
                                            <span class="badge badge-primary">
                                                {{ $targetPages[$banner->target] ?? $banner->target }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($banner->cover)
                                            <a href="{{ asset($banner->cover) }}" data-lightbox="banner-{{ $banner->id }}">
                                                <img src="{{ asset($banner->cover) }}" alt="Banner" style="height: 50px; width: auto; border-radius: 4px;">
                                            </a>
                                            @else
                                            <span class="text-muted">No Image</span>
                                            @endif
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($banner->created_at)->format('Y-m-d') }}</td>
                                        <td>
                                            <a href="{{ route('page-banner.edit', $banner->id) }}" class="btn btn-sm btn-info">
                                                <i class="fa fa-edit"></i> Edit
                                            </a>
                                            <form action="{{ route('page-banner.delete', $banner->id) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this banner?')">
                                                    <i class="fa fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No page banners found.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection

