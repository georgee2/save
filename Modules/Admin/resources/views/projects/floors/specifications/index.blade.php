@extends('admin::layouts.master')
@section('title', 'Floor Specifications - ' . $project->title_english)

@section('css')
<style>
    .spec-card {
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 15px;
        background: #fff;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
    }
    
    .spec-card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        transform: translateY(-2px);
    }
    
    .spec-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 2px solid #f0f0f0;
    }
    
    .spec-title {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 16px;
        font-weight: 600;
        color: #2c3e50;
    }
    
    .spec-icon {
        width: 40px;
        height: 40px;
        object-fit: contain;
    }
    
    .spec-values {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
    }
    
    .spec-value-item {
        padding: 10px;
        background: #f8f9fa;
        border-radius: 6px;
    }
    
    .spec-value-label {
        font-size: 11px;
        color: #7f8c8d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 5px;
    }
    
    .spec-value-text {
        font-size: 14px;
        color: #2c3e50;
        font-weight: 500;
    }
</style>
@endsection

@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Admin')}}" class="breadcrumbs__item"><i class="fa fa-home"></i> Dashboard</a>
            <a href="{{route('project.index')}}" class="breadcrumbs__item"><i class="fa fa-building"></i> Projects</a>
            <a href="{{route('project.show', ['id' => $project->id])}}" class="breadcrumbs__item"><i class="fa fa-eye"></i> {{ $project->title_english }}</a>
            <a href="{{route('project.floor.index', ['projectId' => $project->id])}}" class="breadcrumbs__item"><i class="fa fa-layer-group"></i> Floors</a>
            <a href="{{route('project.floor.show', ['projectId' => $project->id, 'id' => $floor->id])}}" class="breadcrumbs__item"><i class="fa fa-eye"></i> Floor Details</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-list"></i> Specifications</a>
        </nav>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="mt-0 header-title">
                                <i class="fa fa-list"></i> Floor Specifications
                            </h4>
                            <div>
                                <a href="{{ route('project.floor.show', ['projectId' => $project->id, 'id' => $floor->id]) }}" class="btn btn-secondary">
                                    <i class="fa fa-arrow-left"></i> Back to Floor
                                </a>
                                <a href="{{ route('project.floor.specification.create', ['projectId' => $project->id, 'floorId' => $floor->id]) }}" class="btn btn-primary">
                                    <i class="fa fa-plus"></i> Add Specification
                                </a>
                            </div>
                        </div>
                        <hr>
                        
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fa fa-check-circle"></i> {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        
                        @if($specifications->count() > 0)
                            @foreach($specifications as $spec)
                            <div class="spec-card">
                                <div class="spec-card-header">
                                    <div class="spec-title">
                                        @if($spec->specification_icon)
                                            <img src="{{ asset('storage' . $spec->specification_icon) }}" alt="Icon" class="spec-icon">
                                        @endif
                                        <div>
                                            <div>{{ $spec->specification_title_en }}</div>
                                            <small class="text-muted">{{ $spec->specification_title_ar }}</small>
                                        </div>
                                    </div>
                                    <div>
                                        <a href="{{ route('project.floor.specification.edit', ['projectId' => $project->id, 'floorId' => $floor->id, 'id' => $spec->id]) }}" class="btn btn-warning btn-sm" title="Edit">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <form action="{{ route('project.floor.specification.delete', ['projectId' => $project->id, 'floorId' => $floor->id, 'id' => $spec->id]) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this specification?');">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                                                <i class="fa fa-trash-o"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                
                                <div class="spec-values">
                                    <div class="spec-value-item">
                                        <div class="spec-value-label">Value (English)</div>
                                        <div class="spec-value-text">{{ $spec->value_english }}</div>
                                    </div>
                                    
                                    <div class="spec-value-item">
                                        <div class="spec-value-label">Value (Arabic)</div>
                                        <div class="spec-value-text" dir="rtl">{{ $spec->value_arabic }}</div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div class="alert alert-info text-center">
                                <i class="fa fa-info-circle fa-3x mb-3"></i>
                                <h5>No Specifications Added Yet</h5>
                                <p>Start by adding specifications to this floor.</p>
                                <a href="{{ route('project.floor.specification.create', ['projectId' => $project->id, 'floorId' => $floor->id]) }}" class="btn btn-primary mt-2">
                                    <i class="fa fa-plus"></i> Add First Specification
                                </a>
                            </div>
                        @endif
                        
                        @if($trashedSpecifications->count() > 0)
                            <hr>
                            <h5 class="text-danger mt-4 mb-3"><i class="fa fa-trash-o"></i> Deleted Specifications</h5>
                            @foreach($trashedSpecifications as $spec)
                            <div class="spec-card" style="opacity: 0.7; border-color: #dc3545;">
                                <div class="spec-card-header">
                                    <div class="spec-title text-danger">
                                        <div>
                                            <div>{{ $spec->specification_title_en }}</div>
                                            <small class="text-muted">{{ $spec->specification_title_ar }}</small>
                                        </div>
                                    </div>
                                    <div>
                                        <form action="{{ route('project.floor.specification.restore', ['projectId' => $project->id, 'floorId' => $floor->id, 'id' => $spec->id]) }}" method="POST" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm" title="Restore">
                                                <i class="fa fa-undo"></i> Restore
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                
                                <div class="spec-values">
                                    <div class="spec-value-item">
                                        <div class="spec-value-label">Value (English)</div>
                                        <div class="spec-value-text">{{ $spec->value_english }}</div>
                                    </div>
                                    
                                    <div class="spec-value-item">
                                        <div class="spec-value-label">Value (Arabic)</div>
                                        <div class="spec-value-text" dir="rtl">{{ $spec->value_arabic }}</div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @endif
                        
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>
@endsection

