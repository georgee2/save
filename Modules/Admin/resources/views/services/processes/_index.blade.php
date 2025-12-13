<!-- Processes Tab -->
<div class="tab-pane" id="processes">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="tab-content-title mb-0">Service Processes</h5>
        <button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target=".bs-add-process-modal">
            <i class="fa fa-plus"></i> Add Process
        </button>
    </div>
    
    @if($Processes->count() > 0)
        <div class="alert alert-info mb-3">
            <i class="fa fa-info-circle"></i> <strong>Drag & Drop</strong> to reorder processes
        </div>
        
        <table class="table table-striped table-bordered dt-responsive nowrap" id="processes-table" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
            <thead>
                <tr>
                    <th style="width: 50px;"><i class="fa fa-arrows-v"></i> Order</th>
                    <th>ID</th>
                    <th>English Title</th>
                    <th>Arabic Title</th>
                    <th>#Actions</th>
                </tr>
            </thead>
            <tbody id="sortable-processes">
                @foreach($Processes as $process)
                <tr data-id="{{ $process->id }}" style="cursor: move;">
                    <td class="text-center">
                        <i class="fa fa-arrows-v text-muted" style="font-size: 18px;"></i>
                    </td>
                    <td>{{ $process->id }}</td>
                    <td>{{ $process->title_english }}</td>
                    <td>{{ $process->title_arabic }}</td>
                    <td>
                        <a style="color:white;" data-toggle="modal" data-target=".bs-show-process-modal-{{ $process->id }}" class="btn btn-primary btn-sm mr-2" title="Show"><i style="color:white;" class="fa fa-eye"></i></a>
                        
                        <a style="color:white;" data-toggle="modal" data-target=".bs-edit-process-modal-{{ $process->id }}" class="btn btn-warning btn-sm mr-2" title="Edit"><i style="color:white;" class="fa fa-pencil"></i></a>
                        
                        <a style="color:white;" data-toggle="modal" data-target=".bs-delete-process-modal-{{ $process->id }}" class="btn btn-danger btn-sm" title="Delete"><i style="color:white;" class="fa fa-trash-o"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="alert alert-info">
            <i class="fa fa-info-circle"></i> No processes added yet. Click "Add Process" to create one.
        </div>
    @endif
</div>

