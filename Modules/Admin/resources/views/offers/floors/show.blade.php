@extends('admin::layouts.master')
@section('title', 'Floor Details - ' . $offer->title_english)

@section('css')
<style>
    .detail-card {
        background: #fff;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    
    .detail-header {
        padding-bottom: 15px;
        margin-bottom: 20px;
        border-bottom: 2px solid #3498db;
    }
    
    .detail-title {
        font-size: 22px;
        font-weight: 600;
        color: #2c3e50;
    }
    
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 20px;
    }
    
    .info-item {
        padding: 15px;
        background: #f8f9fa;
        border-radius: 6px;
        border-left: 3px solid #3498db;
    }
    
    .info-label {
        font-size: 12px;
        color: #7f8c8d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
    }
    
    .info-value {
        font-size: 16px;
        color: #2c3e50;
        font-weight: 500;
    }
    
    .image-section {
        margin-top: 30px;
    }
    
    .image-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
    }
    
    .image-box {
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        padding: 15px;
        background: #fff;
    }
    
    .image-box-title {
        font-size: 14px;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 10px;
        text-transform: uppercase;
    }
    
    .floor-image {
        width: 100%;
        height: 300px;
        object-fit: cover;
        border-radius: 6px;
        cursor: pointer;
    }
    
    .no-image {
        width: 100%;
        height: 300px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f8f9fa;
        border-radius: 6px;
        color: #7f8c8d;
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
            <a href="{{route('offer.floor.index', ['offerId' => $offer->id])}}" class="breadcrumbs__item"><i class="fa fa-layer-group"></i> Floors</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-eye"></i> Floor Details</a>
        </nav>

        <div class="row">
            <div class="col-12">
                <div class="detail-card">
                    <div class="detail-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="detail-title mb-2">
                                    <i class="fa fa-layer-group"></i> Floor Details
                                </h4>
                                <p class="text-muted mb-0">Detailed information about this floor</p>
                            </div>
                            <div>
                                <a href="{{ route('offer.floor.edit', ['offerId' => $offer->id, 'id' => $floor->id]) }}" class="btn btn-warning">
                                    <i class="fa fa-pencil"></i> Edit
                                </a>
                                <a href="{{ route('offer.floor.index', ['offerId' => $offer->id]) }}" class="btn btn-secondary">
                                    <i class="fa fa-arrow-left"></i> Back to List
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Floor Information -->
                    <h5 class="text-primary mb-3"><i class="fa fa-info-circle"></i> Floor Information</h5>
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">Floor ID</div>
                            <div class="info-value">#{{ $floor->id }}</div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-label">Building Component</div>
                            <div class="info-value">
                                <span class="badge badge-primary">{{ $floor->buildingComponent->name_english }}</span>
                                <br>
                                <small class="text-muted">{{ $floor->buildingComponent->name_arabic }}</small>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-label">Floor Component</div>
                            <div class="info-value">
                                <span class="badge badge-info">{{ $floor->floorComponent->name_english }}</span>
                                <br>
                                <small class="text-muted">{{ $floor->floorComponent->name_arabic }}</small>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-label">Area (SqFt)</div>
                            <div class="info-value">{{ number_format($floor->sqft, 2) }} ft²</div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-label">Area (SqM)</div>
                            <div class="info-value">{{ number_format($floor->sqm, 2) }} m²</div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-label">Count</div>
                            <div class="info-value">
                                <span class="badge badge-success" style="font-size: 16px;">{{ $floor->count }}</span>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-label">Created At</div>
                            <div class="info-value">{{ $floor->created_at->format('M d, Y h:i A') }}</div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-label">Updated At</div>
                            <div class="info-value">{{ $floor->updated_at->format('M d, Y h:i A') }}</div>
                        </div>
                    </div>
                    
                    <!-- Floor Images -->
                    <div class="image-section">
                        <h5 class="text-primary mb-3"><i class="fa fa-image"></i> Floor Images</h5>
                        <div class="image-container">
                            <div class="image-box">
                                <div class="image-box-title"><i class="fa fa-square"></i> 2D Floor Plan</div>
                                @if($floor->image_2d)
                                    <img src="{{ asset('storage' . $floor->image_2d) }}" alt="2D Image" class="floor-image" onclick="openLightbox('{{ asset('storage' . $floor->image_2d) }}')">
                                @else
                                    <div class="no-image">
                                        <span><i class="fa fa-image fa-3x"></i><br>No 2D Image</span>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="image-box">
                                <div class="image-box-title"><i class="fa fa-cube"></i> 3D Visualization</div>
                                @if($floor->image_3d)
                                    <img src="{{ asset('storage' . $floor->image_3d) }}" alt="3D Image" class="floor-image" onclick="openLightbox('{{ asset('storage' . $floor->image_3d) }}')">
                                @else
                                    <div class="no-image">
                                        <span><i class="fa fa-image fa-3x"></i><br>No 3D Image</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Floor Specifications -->
                    <div class="mt-4">
                        @include('admin::offers.floors.specifications._list')
                    </div>
                    
                    <!-- Floor Amenities -->
                    <h5 class="text-primary mb-3 mt-4"><i class="fa fa-star"></i> Amenities</h5>
                    <div class="amenities-section">
                        @include('admin::offers.floors.amenities._index')
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
    
    // Floor Amenities JavaScript
    const offerId = {{ $offer->id }};
    const floorId = {{ $floor->id }};

    // Initialize Select2 for Amenity dropdown
    function initAmenitySelect2() {
        $('.select2-amenity').select2({
            dropdownParent: $('#addAmenityModal'),
            placeholder: "Select Amenity",
            allowClear: true
        });
    }

    // Open Add Amenity Modal
    function openAddAmenityModal() {
        // Load available amenities
        $.ajax({
            url: `/admin/offer/${offerId}/floors/${floorId}/amenities/available`,
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    let options = '<option value="">Select Amenity</option>';
                    if (response.amenities.length > 0) {
                        response.amenities.forEach(function(amenity) {
                            options += `<option value="${amenity.id}" data-icon="${amenity.icon}" data-name-en="${amenity.name_english}" data-name-ar="${amenity.name_arabic}">${amenity.name_english} - ${amenity.name_arabic}</option>`;
                        });
                    } else {
                        options = '<option value="">No amenities available</option>';
                    }
                    $('#amenity_id').html(options);
                    initAmenitySelect2();
                    $('#addAmenityModal').modal('show');
                }
            },
            error: function(xhr) {
                alert('Error loading amenities');
            }
        });
    }

    // Show amenity preview when selected
    $(document).on('change', '#amenity_id', function() {
        var selectedOption = $(this).find('option:selected');
        var icon = selectedOption.data('icon');
        var nameEn = selectedOption.data('name-en');
        var nameAr = selectedOption.data('name-ar');
        
        if (selectedOption.val()) {
            $('#amenity-preview').show();
            if (icon) {
                $('#amenity-preview-icon').attr('src', '{{ asset("storage") }}' + icon).show();
            } else {
                $('#amenity-preview-icon').hide();
            }
            $('#amenity-preview-name-en').text(nameEn);
            $('#amenity-preview-name-ar').text(nameAr);
        } else {
            $('#amenity-preview').hide();
        }
    });

    // Submit Add Amenity Form
    $(document).on('submit', '#addAmenityForm', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: `/admin/offer/${offerId}/floors/${floorId}/amenities/store`,
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    $('#addAmenityModal').modal('hide');
                    $('#addAmenityForm')[0].reset();
                    $('#amenity-preview').hide();
                    
                    // Reload page
                    location.reload();
                } else {
                    alert(response.message);
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    alert(xhr.responseJSON.message);
                } else {
                    alert('Error adding amenity');
                }
            }
        });
    });

    // Open Delete Modal
    function openDeleteAmenityModal(id, name) {
        $('#delete_amenity_id').val(id);
        $('#delete_amenity_name').text(name);
        $('#deleteAmenityModal').modal('show');
    }

    // Confirm Delete
    function confirmDeleteAmenity() {
        const amenityId = $('#delete_amenity_id').val();
        
        $.ajax({
            url: `/admin/offer/${offerId}/floors/${floorId}/amenities/delete/${amenityId}`,
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    $('#deleteAmenityModal').modal('hide');
                    location.reload();
                } else {
                    alert(response.message);
                }
            },
            error: function() {
                alert('Error deleting amenity');
            }
        });
    }

    // Restore Amenity
    function restoreAmenity(id) {
        if (confirm('Are you sure you want to restore this amenity?')) {
            $.ajax({
                url: `/admin/offer/${offerId}/floors/${floorId}/amenities/restore/${id}`,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        location.reload();
                    } else {
                        alert(response.message);
                    }
                },
                error: function() {
                    alert('Error restoring amenity');
                }
            });
        }
    }
</script>
@endsection

