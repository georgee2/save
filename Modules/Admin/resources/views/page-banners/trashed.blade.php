@extends('admin::layouts.master')
@section('title', 'Trashed Page Banners')
@section('content')

<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav style="margin-left: 1px !important;" class="breadcrumbs">
            <a href="{{ route('Admin') }}" class="breadcrumbs__item">
                <i class="fa fa-home"></i> Dashboard
            </a>
            <a href="{{ route('page-banner.index') }}" class="breadcrumbs__item">
                <i class="fa fa-image"></i> Page Banners
            </a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active">
                <i class="fa fa-trash"></i> Trashed Banners
            </a>
        </nav>

        <hr>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="mt-0 header-title">Trashed Page Banners</h4>
                            <a href="{{ route('page-banner.index') }}" class="btn btn-primary">
                                <i class="fa fa-arrow-left"></i> Back to Banners
                            </a>
                        </div>

                        <div class="table-responsive">
                            <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Target Page</th>
                                        <th>Cover Image</th>
                                        <th>Deleted At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($banners as $banner)
                                    <tr>
                                        <td>{{ $banner->id }}</td>
                                        <td>
                                            <span class="badge badge-secondary">
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
                                        <td>{{ \Carbon\Carbon::parse($banner->deleted_at)->format('Y-m-d H:i') }}</td>
                                        <td>
                                            <form action="{{ route('page-banner.restore', $banner->id) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Are you sure you want to restore this banner?')">
                                                    <i class="fa fa-undo"></i> Restore
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No trashed banners found.</td>
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

