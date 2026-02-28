@extends('admin::layouts.master')
@section('title', 'SEO Pages Management')

@section('css')
<style>
    :root {
        --main-color: #19868b;
        --secondary-color: #0d6b6f;
        --accent-color: #e1273d;
    }
    .section-header {
        background: linear-gradient(135deg, var(--main-color) 0%, var(--secondary-color) 100%);
        color: white;
        padding: 15px 20px;
        border-radius: 8px 8px 0 0;
        margin: -20px -20px 20px -20px;
    }
    .seo-table th {
        background: var(--main-color);
        color: #fff;
        font-weight: 600;
        border: none;
        vertical-align: middle;
    }
    .seo-table td {
        vertical-align: middle;
    }
    .badge-page {
        background: var(--main-color);
        color: #fff;
        font-size: 12px;
        padding: 5px 12px;
        border-radius: 20px;
    }
    .badge-empty {
        background: #f8d7da;
        color: #721c24;
        font-size: 11px;
        padding: 4px 10px;
        border-radius: 12px;
    }
    .badge-filled {
        background: #d4edda;
        color: #155724;
        font-size: 11px;
        padding: 4px 10px;
        border-radius: 12px;
    }
    .btn-edit {
        background: var(--main-color);
        color: #fff;
        border: none;
        padding: 6px 16px;
        border-radius: 5px;
        font-size: 13px;
        transition: all 0.3s;
    }
    .btn-edit:hover {
        background: var(--secondary-color);
        color: #fff;
    }
    .seo-preview {
        max-width: 300px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        color: #6c757d;
        font-size: 13px;
    }
</style>
@endsection

@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">

        <nav class="breadcrumbs">
            <a href="{{ route('Admin') }}" class="breadcrumbs__item"><i class="fa fa-home"></i> Dashboard</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-search"></i> SEO Pages</a>
        </nav>

        <div class="col-lg-12">
            <hr>

            <div class="card">
                <div class="card-body">
                    <div class="section-header">
                        <h4 class="mt-0 mb-0"><i class="fa fa-search"></i> SEO Pages Management</h4>
                        <small>Manage SEO titles, descriptions and keywords for each page</small>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="fa fa-check-circle"></i> {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover seo-table">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="15%">Page</th>
                                    <th width="20%">SEO Title (EN)</th>
                                    <th width="20%">SEO Title (AR)</th>
                                    <th width="10%">Description</th>
                                    <th width="10%">Tags</th>
                                    <th width="10%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($seoPages as $index => $page)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td><span class="badge-page">{{ $page->page_name }}</span></td>
                                    <td>
                                        <div class="seo-preview">{{ $page->seo_title_english ?? '—' }}</div>
                                    </td>
                                    <td>
                                        <div class="seo-preview" dir="rtl">{{ $page->seo_title_arabic ?? '—' }}</div>
                                    </td>
                                    <td class="text-center">
                                        @if($page->seo_description_english || $page->seo_description_arabic)
                                            <span class="badge-filled"><i class="fa fa-check"></i> Set</span>
                                        @else
                                            <span class="badge-empty"><i class="fa fa-times"></i> Empty</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($page->seo_tags)
                                            <span class="badge-filled"><i class="fa fa-check"></i> Set</span>
                                        @else
                                            <span class="badge-empty"><i class="fa fa-times"></i> Empty</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.seo-pages.edit', $page->id) }}" class="btn-edit">
                                            <i class="fa fa-pencil"></i> Edit
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
