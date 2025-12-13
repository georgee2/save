<!-- Values Tab -->
<div class="tab-pane" id="values">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="tab-content-title mb-0">Service Values</h5>
        <button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target=".bs-add-value-modal">
            <i class="fa fa-plus"></i> Add Value
        </button>
    </div>
    
    @if($Values->count() > 0)
        <table class="table table-striped table-bordered dt-responsive nowrap " style="border-collapse: collapse; border-spacing: 0; width: 100%;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>English Title</th>
                    <th>Arabic Title</th>
                    <th>#Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($Values as $value)
                <tr>
                    <td>{{ $value->id }}</td>
                    <td>{{ $value->title_english }}</td>
                    <td>{{ $value->title_arabic }}</td>
                    <td>
                        <a style="color:white;" data-toggle="modal" data-target=".bs-show-value-modal-{{ $value->id }}" class="btn btn-primary btn-sm mr-2" title="Show"><i style="color:white;" class="fa fa-eye"></i></a>
                        
                        <a style="color:white;" data-toggle="modal" data-target=".bs-edit-value-modal-{{ $value->id }}" class="btn btn-warning btn-sm mr-2" title="Edit"><i style="color:white;" class="fa fa-pencil"></i></a>
                        
                        <a style="color:white;" data-toggle="modal" data-target=".bs-delete-value-modal-{{ $value->id }}" class="btn btn-danger btn-sm" title="Delete"><i style="color:white;" class="fa fa-trash-o"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="alert alert-info">
            <i class="fa fa-info-circle"></i> No values added yet. Click "Add Value" to create one.
        </div>
    @endif
</div>

