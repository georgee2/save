@php
    $components = \App\Models\ProjectIncomeComponent::getByProject($project->id);
    $trashedComponents = \App\Models\ProjectIncomeComponent::getTrashedByProject($project->id);
@endphp

@if($components->count() > 0 || $trashedComponents->count() > 0)
<div class="table-responsive mt-3">
    <table class="table table-bordered table-striped">
        <thead class="bg-light">
            <tr>
                <th>ID</th>
                <th>Component Name</th>
                <th>Icon</th>
                <th>Number of Units</th>
                <th>Rent Per Year</th>
                <th>Total Annual Income</th>
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
                <td><span class="badge badge-info">{{ number_format($component->number_of_units) }}</span></td>
                <td><span class="badge badge-success">{{ number_format($component->rent_per_year, 2) }}</span></td>
                <td><strong class="text-primary">{{ number_format($component->number_of_units * $component->rent_per_year, 2) }}</strong></td>
                <td>{{ \Carbon\Carbon::parse($component->created_at)->format('M d, Y') }}</td>
                <td>
                    <button type="button" class="btn btn-warning btn-sm" 
                        onclick="openEditIncomeComponentModal({{ $component->id }}, '{{ $component->name_english }}', {{ $component->number_of_units }}, {{ $component->rent_per_year }})" 
                        title="Edit">
                        <i class="fa fa-pencil"></i>
                    </button>
                    <button type="button" class="btn btn-danger btn-sm" 
                        onclick="openDeleteIncomeComponentModal({{ $component->id }}, '{{ $component->name_english }}')" 
                        title="Delete">
                        <i class="fa fa-trash-o"></i>
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot class="bg-light">
            <tr>
                <td colspan="5" class="text-right"><strong>Total Annual Income:</strong></td>
                <td colspan="3">
                    <strong class="text-success" style="font-size: 16px;">
                        {{ number_format($components->sum(function($c) { return $c->number_of_units * $c->rent_per_year; }), 2) }}
                    </strong>
                </td>
            </tr>
        </tfoot>
    </table>
</div>

@if($trashedComponents->count() > 0)
    <hr>
    <h6 class="text-danger mt-3 mb-2"><i class="fa fa-trash-o"></i> Deleted Income Components</h6>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="bg-light">
                <tr>
                    <th>ID</th>
                    <th>Component Name</th>
                    <th>Number of Units</th>
                    <th>Rent Per Year</th>
                    <th>Deleted Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($trashedComponents as $component)
                <tr style="opacity: 0.7;">
                    <td>{{ $component->id }}</td>
                    <td>
                        <strong class="text-danger">{{ $component->name_english }}</strong><br>
                        <small class="text-muted">{{ $component->name_arabic }}</small>
                    </td>
                    <td>{{ number_format($component->number_of_units) }}</td>
                    <td>{{ number_format($component->rent_per_year, 2) }}</td>
                    <td>{{ \Carbon\Carbon::parse($component->deleted_at)->format('M d, Y') }}</td>
                    <td>
                        <button type="button" class="btn btn-success btn-sm" 
                            onclick="restoreIncomeComponent({{ $component->id }})" 
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
    <h6>No Income Components Added Yet</h6>
    <p class="mb-2">Start by adding income components to calculate project revenue.</p>
    <button type="button" class="btn btn-primary btn-sm" onclick="openAddIncomeComponentModal()">
        <i class="fa fa-plus"></i> Add First Component
    </button>
</div>
@endif

