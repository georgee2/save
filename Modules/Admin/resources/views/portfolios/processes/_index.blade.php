<!-- Portfolio Processes Tab -->
<div class="tab-pane" id="processes">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="tab-content-title mb-0">Portfolio Processes</h5>
        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target=".bs-add-portfolio-process-modal">
            <i class="fa fa-plus"></i> Add Process
        </button>
    </div>
    
    @if($Processes && count($Processes) > 0)
        <div class="alert alert-info">
            <i class="fa fa-info-circle"></i> <strong>Tip:</strong> Drag and drop rows to reorder processes.
        </div>
        
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th width="5%">#</th>
                        <th width="8%">Order</th>
                        <th width="10%">Icon</th>
                        <th width="20%">Title (EN)</th>
                        <th width="20%">Title (AR)</th>
                        <th width="22%">Description (EN)</th>
                        <th width="15%">Actions</th>
                    </tr>
                </thead>
                <tbody id="sortable-portfolio-processes">
                    @foreach($Processes as $process)
                    <tr draggable="true" data-id="{{ $process->id }}">
                        <td>{{ $process->id }}</td>
                        <td>
                            <span class="badge badge-secondary">{{ $process->order }}</span>
                        </td>
                        <td>
                            @if($process->icon)
                                <img src="{{url('/storage' . $process->icon)}}" alt="Icon" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                            @else
                                <span class="text-muted">No icon</span>
                            @endif
                        </td>
                        <td>{{ Str::limit($process->title_english, 40) }}</td>
                        <td>{{ Str::limit($process->title_arabic, 40) }}</td>
                        <td>{{ Str::limit($process->description_english, 60) }}</td>
                        <td>
                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target=".bs-show-portfolio-process-modal-{{ $process->id }}" title="View">
                                <i class="fa fa-eye"></i>
                            </button>
                            
                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target=".bs-edit-portfolio-process-modal-{{ $process->id }}" title="Edit">
                                <i class="fa fa-pencil"></i>
                            </button>
                            
                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target=".bs-delete-portfolio-process-modal-{{ $process->id }}" title="Delete">
                                <i class="fa fa-trash-o"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-info">
            <i class="fa fa-info-circle"></i> No processes added yet. Click "Add Process" to create one.
        </div>
    @endif
</div>


