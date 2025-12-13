@php
    $amenities = \App\Models\ProjectFloorAmenity::getByFloor($floor->id);
    $trashedAmenities = \App\Models\ProjectFloorAmenity::getTrashedByFloor($floor->id);
@endphp

@if($amenities->count() > 0 || $trashedAmenities->count() > 0)
<div class="table-responsive mt-3">
    <table class="table table-bordered table-striped">
        <thead class="bg-light">
            <tr>
                <th style="width: 60px;">Icon</th>
                <th>Amenity Name</th>
                <th style="width: 150px;">Added Date</th>
                <th style="width: 100px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($amenities as $amenity)
            <tr>
                <td class="text-center">
                    @if($amenity->amenity_icon)
                        <img style="width:40px; height: 40px; object-fit: contain;" src="{{url('/storage'.$amenity->amenity_icon)}}" alt="Icon">
                    @else
                        <i class="fa fa-star fa-2x text-muted"></i>
                    @endif
                </td>
                <td>
                    <strong>{{ $amenity->amenity_name_en }}</strong><br>
                    <small class="text-muted">{{ $amenity->amenity_name_ar }}</small>
                </td>
                <td>{{ \Carbon\Carbon::parse($amenity->created_at)->format('M d, Y') }}</td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm" onclick="openDeleteAmenityModal({{ $amenity->id }}, '{{ $amenity->amenity_name_en }}')" title="Delete">
                        <i class="fa fa-trash-o"></i>
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@if($trashedAmenities->count() > 0)
    <hr>
    <h6 class="text-danger mt-3 mb-2"><i class="fa fa-trash-o"></i> Deleted Amenities</h6>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="bg-light">
                <tr>
                    <th>Amenity Name</th>
                    <th style="width: 150px;">Deleted Date</th>
                    <th style="width: 100px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($trashedAmenities as $amenity)
                <tr style="opacity: 0.7;">
                    <td>
                        <strong class="text-danger">{{ $amenity->amenity_name_en }}</strong><br>
                        <small class="text-muted">{{ $amenity->amenity_name_ar }}</small>
                    </td>
                    <td>{{ \Carbon\Carbon::parse($amenity->deleted_at)->format('M d, Y') }}</td>
                    <td>
                        <button type="button" class="btn btn-success btn-sm" onclick="restoreAmenity({{ $amenity->id }})" title="Restore">
                            <i class="fa fa-undo"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif

<div class="alert alert-success mt-3">
    <i class="fa fa-check-circle"></i> 
    <strong>Total Amenities:</strong> {{ $amenities->count() }} amenity(ies) added to this floor.
</div>
@else
<div class="alert alert-warning text-center mt-3">
    <i class="fa fa-exclamation-triangle fa-2x mb-2"></i>
    <h6>No Amenities Added Yet</h6>
    <p class="mb-2">Start by adding amenities to this floor.</p>
    <button type="button" class="btn btn-primary btn-sm" onclick="openAddAmenityModal()">
        <i class="fa fa-plus"></i> Add First Amenity
    </button>
</div>
@endif

