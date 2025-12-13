@php
    $specifications = \App\Models\ProjectFloorSpecification::getByFloor($floor->id);
@endphp

<div class="specifications-summary-section">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="text-primary mb-0"><i class="fa fa-list"></i> Floor Specifications</h5>
        <a href="{{ route('project.floor.specification.index', ['projectId' => $project->id, 'floorId' => $floor->id]) }}" class="btn btn-primary btn-sm">
            <i class="fa fa-cog"></i> Manage Specifications
        </a>
    </div>
    
    @if($specifications->count() > 0)
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="bg-light">
                    <tr>
                        <th style="width: 50px;">Icon</th>
                        <th>Specification</th>
                        <th>Value (English)</th>
                        <th>Value (Arabic)</th>
                        <th style="width: 100px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($specifications as $spec)
                    <tr>
                        <td class="text-center">
                            @if($spec->specification_icon)
                                <img src="{{ asset('storage' . $spec->specification_icon) }}" 
                                     style="width: 30px; height: 30px; object-fit: contain;" 
                                     alt="Icon">
                            @else
                                <i class="fa fa-list text-muted"></i>
                            @endif
                        </td>
                        <td>
                            <strong>{{ $spec->specification_title_en }}</strong><br>
                            <small class="text-muted">{{ $spec->specification_title_ar }}</small>
                        </td>
                        <td>{{ $spec->value_english }}</td>
                        <td dir="rtl">{{ $spec->value_arabic }}</td>
                        <td>
                            <a href="{{ route('project.floor.specification.edit', ['projectId' => $project->id, 'floorId' => $floor->id, 'id' => $spec->id]) }}" 
                               class="btn btn-warning btn-sm" title="Edit">
                                <i class="fa fa-pencil"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="alert alert-info mt-3">
            <i class="fa fa-info-circle"></i> 
            <strong>Total Specifications:</strong> {{ $specifications->count() }} specification(s) added to this floor.
        </div>
    @else
        <div class="alert alert-warning text-center">
            <i class="fa fa-exclamation-triangle fa-2x mb-2"></i>
            <h6>No Specifications Added Yet</h6>
            <p class="mb-2">Start by adding specifications to this floor.</p>
            <a href="{{ route('project.floor.specification.create', ['projectId' => $project->id, 'floorId' => $floor->id]) }}" class="btn btn-primary btn-sm">
                <i class="fa fa-plus"></i> Add First Specification
            </a>
        </div>
    @endif
</div>

