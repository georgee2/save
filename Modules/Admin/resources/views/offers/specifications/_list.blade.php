@php
    $specifications = \App\Models\OfferSpecification::getByOffer($offer->id);
    $trashedSpecifications = \App\Models\OfferSpecification::getTrashedByOffer($offer->id);
@endphp

@if($specifications->count() > 0 || $trashedSpecifications->count() > 0)
<div class="table-responsive mt-3">
    <table class="table table-bordered table-striped">
        <thead class="bg-light">
            <tr>
                <th>ID</th>
                <th>Specification</th>
                <th>Icon</th>
                <th>Value (English)</th>
                <th>Value (Arabic)</th>
                <th>Added Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($specifications as $spec)
            <tr>
                <td>{{ $spec->id }}</td>
                <td>
                    <strong>{{ $spec->title_english }}</strong><br>
                    <small class="text-muted">{{ $spec->title_arabic }}</small>
                </td>
                <td>
                    @if($spec->icon)
                        <img style="width:40px; height: 40px; object-fit: contain;" src="{{url('/storage'.$spec->icon)}}" alt="Icon">
                    @else
                        <span class="text-muted">N/A</span>
                    @endif
                </td>
                <td>{{ $spec->value_english }}</td>
                <td dir="rtl">{{ $spec->value_arabic }}</td>
                <td>{{ \Carbon\Carbon::parse($spec->created_at)->format('M d, Y') }}</td>
                <td>
                    <button type="button" class="btn btn-warning btn-sm" 
                        onclick="openEditSpecificationModal({{ $spec->id }}, '{{ $spec->title_english }}', '{{ addslashes($spec->value_english) }}', '{{ addslashes($spec->value_arabic) }}')" 
                        title="Edit">
                        <i class="fa fa-pencil"></i>
                    </button>
                    <button type="button" class="btn btn-danger btn-sm" 
                        onclick="openDeleteSpecificationModal({{ $spec->id }}, '{{ $spec->title_english }}')" 
                        title="Delete">
                        <i class="fa fa-trash-o"></i>
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@if($trashedSpecifications->count() > 0)
    <hr>
    <h6 class="text-danger mt-3 mb-2"><i class="fa fa-trash-o"></i> Deleted Specifications</h6>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="bg-light">
                <tr>
                    <th>ID</th>
                    <th>Specification</th>
                    <th>Value (English)</th>
                    <th>Value (Arabic)</th>
                    <th>Deleted Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($trashedSpecifications as $spec)
                <tr style="opacity: 0.7;">
                    <td>{{ $spec->id }}</td>
                    <td>
                        <strong class="text-danger">{{ $spec->title_english }}</strong><br>
                        <small class="text-muted">{{ $spec->title_arabic }}</small>
                    </td>
                    <td>{{ $spec->value_english }}</td>
                    <td dir="rtl">{{ $spec->value_arabic }}</td>
                    <td>{{ \Carbon\Carbon::parse($spec->deleted_at)->format('M d, Y') }}</td>
                    <td>
                        <button type="button" class="btn btn-success btn-sm" 
                            onclick="restoreSpecification({{ $spec->id }})" 
                            title="Restore">
                            <i class="fa fa-undo"></i> Restore
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
@else
<div class="alert alert-warning text-center mt-3">
    <i class="fa fa-exclamation-triangle fa-2x mb-2"></i>
    <h6>No Specifications Added Yet</h6>
    <p class="mb-2">Start by adding specifications to describe your offer.</p>
    <button type="button" class="btn btn-primary btn-sm" onclick="openAddSpecificationModal()">
        <i class="fa fa-plus"></i> Add First Specification
    </button>
</div>
@endif

