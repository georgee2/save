@php
    $costs = \App\Models\ProjectConstructionCost::getByProject($project->id);
    $trashedCosts = \App\Models\ProjectConstructionCost::getTrashedByProject($project->id);
@endphp

@if($costs->count() > 0 || $trashedCosts->count() > 0)
<div class="table-responsive mt-3">
    <table class="table table-bordered table-striped">
        <thead class="bg-light">
            <tr>
                <th>ID</th>
                <th>Feasibility Study Component</th>
                <th>Target</th>
                <th>Substation Room</th>
                <th>Pumps Room</th>
                <th>Total Cost</th>
                <th>Added Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($costs as $cost)
            <tr>
                <td>{{ $cost->id }}</td>
                <td>
                    <strong>{{ $cost->fsc_header_english }}</strong><br>
                    <small class="text-muted">{{ $cost->fsc_header_arabic }}</small><br>
                    <span class="badge badge-secondary">{{ $cost->fsc_title_english }}</span>
                </td>
                <td>
                    @if($cost->fsc_target == 'Building Components')
                        <span class="badge badge-info"><i class="fa fa-cube"></i> {{ $cost->fsc_target }}</span>
                    @elseif($cost->fsc_target == 'Income Components')
                        <span class="badge badge-success"><i class="fa fa-dollar"></i> {{ $cost->fsc_target }}</span>
                    @else
                        <span class="badge badge-warning"><i class="mdi mdi-ruler"></i> {{ $cost->fsc_target }}</span>
                    @endif
                </td>
                <td>
                    @if($cost->substation_name_english)
                        <strong>{{ $cost->substation_name_english }}</strong><br>
                        <small class="text-muted">{{ $cost->substation_name_arabic }}</small><br>
                        <span class="badge badge-primary">{{ number_format($cost->substation_price, 2) }}</span>
                    @else
                        <span class="text-muted">N/A</span>
                    @endif
                </td>
                <td>
                    @if($cost->pumps_name_english)
                        <strong>{{ $cost->pumps_name_english }}</strong><br>
                        <small class="text-muted">{{ $cost->pumps_name_arabic }}</small><br>
                        <span class="badge badge-primary">{{ number_format($cost->pumps_price, 2) }}</span>
                    @else
                        <span class="text-muted">N/A</span>
                    @endif
                </td>
                <td>
                    <span class="badge badge-success" style="font-size: 14px;">
                        {{ number_format(($cost->substation_price ?? 0) + ($cost->pumps_price ?? 0), 2) }}
                    </span>
                </td>
                <td>{{ \Carbon\Carbon::parse($cost->created_at)->format('M d, Y') }}</td>
                <td>
                    <button type="button" class="btn btn-warning btn-sm" onclick="openEditConstructionCostModal({{ $cost->id }}, {{ $cost->substation_room_id ?? 'null' }}, {{ $cost->pumps_room_id ?? 'null' }})" title="Edit">
                        <i class="fa fa-pencil"></i>
                    </button>
                    <button type="button" class="btn btn-danger btn-sm" onclick="openDeleteConstructionCostModal({{ $cost->id }}, '{{ $cost->fsc_header_english }}')" title="Delete">
                        <i class="fa fa-trash-o"></i>
                    </button>
                </td>
            </tr>
            @endforeach
            
            @if($trashedCosts->count() > 0)
            <tr class="bg-light">
                <td colspan="8" class="text-center"><strong><i class="fa fa-trash"></i> Trashed Construction Costs</strong></td>
            </tr>
            @foreach($trashedCosts as $cost)
            <tr class="table-secondary">
                <td>{{ $cost->id }}</td>
                <td>
                    <strong>{{ $cost->fsc_header_english }}</strong>
                </td>
                <td>-</td>
                <td>
                    @if($cost->substation_name_english)
                        {{ $cost->substation_name_english }}
                    @else
                        <span class="text-muted">N/A</span>
                    @endif
                </td>
                <td>
                    @if($cost->pumps_name_english)
                        {{ $cost->pumps_name_english }}
                    @else
                        <span class="text-muted">N/A</span>
                    @endif
                </td>
                <td>-</td>
                <td>{{ \Carbon\Carbon::parse($cost->deleted_at)->format('M d, Y H:i') }}</td>
                <td>
                    <button type="button" class="btn btn-success btn-sm" onclick="restoreConstructionCost({{ $cost->id }})" title="Restore">
                        <i class="fa fa-undo"></i> Restore
                    </button>
                </td>
            </tr>
            @endforeach
            @endif
        </tbody>
        <tfoot class="bg-light">
            <tr>
                <th colspan="5" class="text-right">Total Construction Cost:</th>
                <th colspan="3">
                    <span class="badge badge-primary" style="font-size: 14px;">
                        {{ number_format($costs->sum(function($cost) { return ($cost->substation_price ?? 0) + ($cost->pumps_price ?? 0); }), 2) }}
                    </span>
                </th>
            </tr>
        </tfoot>
    </table>
</div>
@else
<div class="alert alert-warning mt-3">
    <i class="fa fa-exclamation-triangle"></i> 
    No construction costs have been added to this project yet. Click "Add Construction Cost" to get started.
</div>
@endif

