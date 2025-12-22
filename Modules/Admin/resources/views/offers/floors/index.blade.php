@extends('admin::layouts.master')
@section('title', 'Offer Floors - ' . $offer->title_english)

@section('css')
<style>
    .floor-card {
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
        background: #fff;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
    }
    
    .floor-card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        transform: translateY(-2px);
    }
    
    .floor-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 2px solid #f0f0f0;
    }
    
    .floor-title {
        font-size: 18px;
        font-weight: 600;
        color: #2c3e50;
    }
    
    .floor-info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        margin-bottom: 15px;
    }
    
    .floor-info-item {
        display: flex;
        flex-direction: column;
    }
    
    .floor-info-label {
        font-size: 12px;
        color: #7f8c8d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 5px;
    }
    
    .floor-info-value {
        font-size: 15px;
        color: #2c3e50;
        font-weight: 500;
    }
    
    .floor-images {
        display: flex;
        gap: 10px;
        margin-top: 15px;
    }
    
    .floor-image-preview {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 6px;
        cursor: pointer;
        border: 2px solid #e0e0e0;
    }
    
    .floor-actions {
        display: flex;
        gap: 5px;
    }
</style>
@endsection

@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Admin')}}" class="breadcrumbs__item"><i class="fa fa-home"></i> Dashboard</a>
            <a href="{{route('offer.index')}}" class="breadcrumbs__item"><i class="fa fa-tags"></i> Offers</a>
            <a href="{{route('offer.show', ['id' => $offer->id])}}" class="breadcrumbs__item"><i class="fa fa-eye"></i> {{ $offer->title_english }}</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-layer-group"></i> Floors</a>
        </nav>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="mt-0 header-title">
                                <i class="fa fa-layer-group"></i> Offer Floors
                            </h4>
                            <div>
                                <a href="{{ route('offer.show', ['id' => $offer->id]) }}" class="btn btn-secondary">
                                    <i class="fa fa-arrow-left"></i> Back to Offer
                                </a>
                                <a href="{{ route('offer.floor.create', ['offerId' => $offer->id]) }}" class="btn btn-primary">
                                    <i class="fa fa-plus"></i> Add Floor
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
                        
                        @if($floors->count() > 0)
                            @foreach($floors as $floor)
                            <div class="floor-card">
                                <div class="floor-card-header">
                                    <div>
                                        <div class="floor-title">{{ $floor->floor_component_name_en }}</div>
                                        <small class="text-muted">{{ $floor->floor_component_name_ar }}</small>
                                    </div>
                                    <div class="floor-actions">
                                        <a href="{{ route('offer.floor.show', ['offerId' => $offer->id, 'id' => $floor->id]) }}" class="btn btn-info btn-sm" title="View">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="{{ route('offer.floor.edit', ['offerId' => $offer->id, 'id' => $floor->id]) }}" class="btn btn-warning btn-sm" title="Edit">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <form action="{{ route('offer.floor.delete', ['offerId' => $offer->id, 'id' => $floor->id]) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this floor?');">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                                                <i class="fa fa-trash-o"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                
                                <div class="floor-info-grid">
                                    <div class="floor-info-item">
                                        <div class="floor-info-label">Building Component</div>
                                        <div class="floor-info-value">
                                            <span class="badge badge-primary">{{ $floor->building_component_name_en }}</span>
                                        </div>
                                    </div>
                                    
                                    <div class="floor-info-item">
                                        <div class="floor-info-label">Area (SqFt)</div>
                                        <div class="floor-info-value">{{ number_format($floor->sqft, 2) }} ft²</div>
                                    </div>
                                    
                                    <div class="floor-info-item">
                                        <div class="floor-info-label">Area (SqM)</div>
                                        <div class="floor-info-value">{{ number_format($floor->sqm, 2) }} m²</div>
                                    </div>
                                    
                                    <div class="floor-info-item">
                                        <div class="floor-info-label">Count</div>
                                        <div class="floor-info-value">
                                            <span class="badge badge-success">{{ $floor->count }}</span>
                                        </div>
                                    </div>
                                    
                                    <div class="floor-info-item">
                                        <div class="floor-info-label">Created At</div>
                                        <div class="floor-info-value">{{ \Carbon\Carbon::parse($floor->created_at)->format('M d, Y') }}</div>
                                    </div>
                                </div>
                                
                                <div class="floor-images">
                                    @if($floor->image_2d)
                                        <img src="{{ asset('storage' . $floor->image_2d) }}" alt="2D Image" class="floor-image-preview" onclick="openLightbox('{{ asset('storage' . $floor->image_2d) }}')" title="2D Image">
                                    @endif
                                    @if($floor->image_3d)
                                        <img src="{{ asset('storage' . $floor->image_3d) }}" alt="3D Image" class="floor-image-preview" onclick="openLightbox('{{ asset('storage' . $floor->image_3d) }}')" title="3D Image">
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div class="alert alert-info text-center">
                                <i class="fa fa-info-circle fa-3x mb-3"></i>
                                <h5>No Floors Added Yet</h5>
                                <p>Start by adding floors to this offer.</p>
                                <a href="{{ route('offer.floor.create', ['offerId' => $offer->id]) }}" class="btn btn-primary mt-2">
                                    <i class="fa fa-plus"></i> Add First Floor
                                </a>
                            </div>
                        @endif
                        
                        @if($trashedFloors->count() > 0)
                            <hr>
                            <h5 class="text-danger mt-4 mb-3"><i class="fa fa-trash-o"></i> Deleted Floors</h5>
                            @foreach($trashedFloors as $floor)
                            <div class="floor-card" style="opacity: 0.7; border-color: #dc3545;">
                                <div class="floor-card-header">
                                    <div>
                                        <div class="floor-title text-danger">{{ $floor->floor_component_name_en }}</div>
                                        <small class="text-muted">{{ $floor->floor_component_name_ar }}</small>
                                    </div>
                                    <div>
                                        <form action="{{ route('offer.floor.restore', ['offerId' => $offer->id, 'id' => $floor->id]) }}" method="POST" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm" title="Restore">
                                                <i class="fa fa-undo"></i> Restore
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                
                                <div class="floor-info-grid">
                                    <div class="floor-info-item">
                                        <div class="floor-info-label">Building Component</div>
                                        <div class="floor-info-value">
                                            <span class="badge badge-secondary">{{ $floor->building_component_name_en }}</span>
                                        </div>
                                    </div>
                                    
                                    <div class="floor-info-item">
                                        <div class="floor-info-label">Deleted At</div>
                                        <div class="floor-info-value">{{ \Carbon\Carbon::parse($floor->deleted_at)->format('M d, Y') }}</div>
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

<!-- Lightbox Modal -->
<div class="modal fade" id="lightboxModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body p-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="position: absolute; right: 10px; top: 10px; z-index: 1; color: white; text-shadow: 0 0 5px black;">
                    <span aria-hidden="true">&times;</span>
                </button>
                <img id="lightboxImage" src="" style="width: 100%; height: auto;">
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    function openLightbox(imageUrl) {
        $('#lightboxImage').attr('src', imageUrl);
        $('#lightboxModal').modal('show');
    }
</script>
@endsection

