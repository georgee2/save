@php
    $components = \App\Models\ProjectBuildingComponent::getByProject($project->id);
    $trashedComponents = \App\Models\ProjectBuildingComponent::getTrashedByProject($project->id);
@endphp

@if($components->count() > 0 || $trashedComponents->count() > 0)
<div class="table-responsive mt-3">
    <table class="table table-bordered table-striped">
        <thead class="bg-light">
            <tr>
                <th>ID</th>
                <th>Component Name</th>
                <th>Icon</th>
                <th>Construction Cost</th>
                <th>Added Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($components as $component)
            <tr>
                <td>{{ $component->id }}</td>
                <td>
                    <strong>{{ $component->name_english }}</strong><br>
                    <small class="text-muted">{{ $component->name_arabic }}</small>
                </td>
                <td>
                    @if($component->icon)
                        <img style="width:40px; height: 40px; object-fit: contain;" src="{{url('/storage'.$component->icon)}}" alt="Icon">
                    @else
                        <span class="text-muted">N/A</span>
                    @endif
                </td>
                <td><span class="badge badge-success">{{ number_format($component->construction_cost, 2) }}</span></td>
                <td>{{ \Carbon\Carbon::parse($component->created_at)->format('M d, Y') }}</td>
                <td>
                    <button type="button" class="btn btn-warning btn-sm" onclick="openEditModal({{ $component->id }}, '{{ $component->name_english }} - {{ $component->name_arabic }}', {{ $component->construction_cost }})" title="Edit">
                        <i class="fa fa-pencil"></i>
                    </button>
                    <button type="button" class="btn btn-danger btn-sm" onclick="openDeleteModal({{ $component->id }}, '{{ $component->name_english }}')" title="Delete">
                        <i class="fa fa-trash-o"></i>
                    </button>
                </td>
            </tr>
            @endforeach
            
            @if($trashedComponents->count() > 0)
            <tr class="bg-light">
                <td colspan="6" class="text-center"><strong><i class="fa fa-trash"></i> Trashed Components</strong></td>
            </tr>
            @foreach($trashedComponents as $component)
            <tr class="table-secondary">
                <td>{{ $component->id }}</td>
                <td>
                    <strong>{{ $component->name_english }}</strong><br>
                    <small class="text-muted">{{ $component->name_arabic }}</small>
                </td>
                <td>-</td>
                <td><span class="badge badge-secondary">{{ number_format($component->construction_cost, 2) }}</span></td>
                <td>{{ \Carbon\Carbon::parse($component->deleted_at)->format('M d, Y H:i') }}</td>
                <td>
                    <button type="button" class="btn btn-success btn-sm" onclick="restoreComponent({{ $component->id }})" title="Restore">
                        <i class="fa fa-undo"></i> Restore
                    </button>
                </td>
            </tr>
            @endforeach
            @endif
        </tbody>
        <tfoot class="bg-light">
            <tr>
                <th colspan="3" class="text-right">Total Construction Cost:</th>
                <th colspan="3">
                    <span class="badge badge-primary" style="font-size: 14px;">
                        {{ number_format($components->sum('construction_cost'), 2) }}
                    </span>
                </th>
            </tr>
        </tfoot>
    </table>
</div>
@else
<div class="alert alert-warning mt-3">
    <i class="fa fa-exclamation-triangle"></i> 
    No building components have been added to this project yet. Click "Add Component" to get started.
</div>
@endif

