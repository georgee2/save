@php
    $floors = \App\Models\ProjectFloor::getByProject($project->id);
@endphp

<div class="floors-summary-section">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="text-primary mb-0"><i class="fa fa-layer-group"></i> Project Floors</h5>
        <a href="{{ route('project.floor.index', ['projectId' => $project->id]) }}" class="btn btn-primary btn-sm">
            <i class="fa fa-list"></i> Manage Floors
        </a>
    </div>
    
    @if($floors->count() > 0)
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="bg-light">
                    <tr>
                        <th style="width: 60px;">Icon</th>
                        <th>Floor Component</th>
                        <th>Building Component</th>
                        <th>Area (SqFt)</th>
                        <th>Area (SqM)</th>
                        <th>Count</th>
                        <th>Images</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($floors as $floor)
                    <tr>
                        <td class="text-center">
                            @if($floor->floor_component_icon)
                                <img src="{{ asset('storage' . $floor->floor_component_icon) }}" 
                                     style="width: 40px; height: 40px; object-fit: contain;" 
                                     alt="Floor Icon">
                            @else
                                <i class="fa fa-layer-group fa-2x text-muted"></i>
                            @endif
                        </td>
                        <td>
                            <strong>{{ $floor->floor_component_name_en }}</strong><br>
                            <small class="text-muted">{{ $floor->floor_component_name_ar }}</small>
                        </td>
                        <td>
                            <span class="badge badge-primary">{{ $floor->building_component_name_en }}</span>
                        </td>
                        <td>{{ number_format($floor->sqft, 2) }} ft²</td>
                        <td>{{ number_format($floor->sqm, 2) }} m²</td>
                        <td>
                            <span class="badge badge-success">{{ $floor->count }}</span>
                        </td>
                        <td>
                            <div style="display: flex; gap: 5px;">
                                @if($floor->image_2d)
                                    <img src="{{ asset('storage' . $floor->image_2d) }}" 
                                         style="width: 40px; height: 40px; object-fit: cover; border-radius: 4px; cursor: pointer;" 
                                         onclick="openLightbox('{{ asset('storage' . $floor->image_2d) }}')" 
                                         title="2D Image">
                                @endif
                                @if($floor->image_3d)
                                    <img src="{{ asset('storage' . $floor->image_3d) }}" 
                                         style="width: 40px; height: 40px; object-fit: cover; border-radius: 4px; cursor: pointer;" 
                                         onclick="openLightbox('{{ asset('storage' . $floor->image_3d) }}')" 
                                         title="3D Image">
                                @endif
                            </div>
                        </td>
                        <td>
                            <a href="{{ route('project.floor.show', ['projectId' => $project->id, 'id' => $floor->id]) }}" 
                               class="btn btn-info btn-sm" title="View">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a href="{{ route('project.floor.edit', ['projectId' => $project->id, 'id' => $floor->id]) }}" 
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
            <strong>Total Floors:</strong> {{ $floors->count() }} floor component(s) added to this project.
        </div>
    @else
        <div class="alert alert-warning text-center">
            <i class="fa fa-exclamation-triangle fa-2x mb-2"></i>
            <h6>No Floors Added Yet</h6>
            <p class="mb-2">Start by adding floors to this project.</p>
            <a href="{{ route('project.floor.create', ['projectId' => $project->id]) }}" class="btn btn-primary btn-sm">
                <i class="fa fa-plus"></i> Add First Floor
            </a>
        </div>
    @endif
</div>

