@php
    $components = \App\Models\OfferLengthComponent::getByOffer($offer->id);
    $trashedComponents = \App\Models\OfferLengthComponent::getTrashedByOffer($offer->id);
@endphp

@if($components->count() > 0 || $trashedComponents->count() > 0)
<div class="table-responsive mt-3">
    <table class="table table-bordered table-striped">
        <thead class="bg-light">
            <tr>
                <th>ID</th>
                <th>Building Component</th>
                <th>Length Component</th>
                <th>Icon</th>
                <th>Unit Cost</th>
                <th>Added Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($components as $component)
            <tr>
                <td>{{ $component->id }}</td>
                <td>
                    <strong>{{ $component->building_component_name_english }}</strong><br>
                    <small class="text-muted">{{ $component->building_component_name_arabic }}</small>
                </td>
                <td>
                    <strong>{{ $component->length_component_name_english }}</strong><br>
                    <small class="text-muted">{{ $component->length_component_name_arabic }}</small>
                </td>
                <td>
                    @if($component->length_component_icon)
                        <img style="width:40px; height: 40px; object-fit: contain;" src="{{url('/storage'.$component->length_component_icon)}}" alt="Icon">
                    @else
                        <span class="text-muted">N/A</span>
                    @endif
                </td>
                <td><span class="badge badge-success">{{ number_format($component->unit_cost, 2) }}</span></td>
                <td>{{ \Carbon\Carbon::parse($component->created_at)->format('M d, Y') }}</td>
                <td>
                    <button type="button" class="btn btn-warning btn-sm" onclick="openEditLengthModal({{ $component->id }}, '{{ $component->building_component_name_english }} - {{ $component->length_component_name_english }}', {{ $component->unit_cost }})" title="Edit">
                        <i class="fa fa-pencil"></i>
                    </button>
                    <button type="button" class="btn btn-danger btn-sm" onclick="openDeleteLengthModal({{ $component->id }}, '{{ $component->length_component_name_english }}')" title="Delete">
                        <i class="fa fa-trash-o"></i>
                    </button>
                </td>
            </tr>
            @endforeach
            
            @if($trashedComponents->count() > 0)
            <tr class="bg-light">
                <td colspan="7" class="text-center"><strong><i class="fa fa-trash"></i> Trashed Length Components</strong></td>
            </tr>
            @foreach($trashedComponents as $component)
            <tr class="table-secondary">
                <td>{{ $component->id }}</td>
                <td>
                    <strong>{{ $component->building_component_name_english }}</strong>
                </td>
                <td>
                    <strong>{{ $component->length_component_name_english }}</strong>
                </td>
                <td>-</td>
                <td><span class="badge badge-secondary">{{ number_format($component->unit_cost, 2) }}</span></td>
                <td>{{ \Carbon\Carbon::parse($component->deleted_at)->format('M d, Y H:i') }}</td>
                <td>
                    <button type="button" class="btn btn-success btn-sm" onclick="restoreLengthComponent({{ $component->id }})" title="Restore">
                        <i class="fa fa-undo"></i> Restore
                    </button>
                </td>
            </tr>
            @endforeach
            @endif
        </tbody>
        <tfoot class="bg-light">
            <tr>
                <th colspan="4" class="text-right">Total Unit Cost:</th>
                <th colspan="3">
                    <span class="badge badge-primary" style="font-size: 14px;">
                        {{ number_format($components->sum('unit_cost'), 2) }}
                    </span>
                </th>
            </tr>
        </tfoot>
    </table>
</div>
@else
<div class="alert alert-warning mt-3">
    <i class="fa fa-exclamation-triangle"></i> 
    No length components have been added to this offer yet. Click "Add Length Component" to get started.
</div>
@endif

