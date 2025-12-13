<!-- Blocks Tab -->
<div class="tab-pane" id="blocks">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="tab-content-title mb-0">Custom Blocks</h5>
        <button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target=".bs-add-block-modal">
            <i class="fa fa-plus"></i> Add Block
        </button>
    </div>
    
    @if($Blocks->count() > 0)
        <table class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>English Title</th>
                    <th>Arabic Title</th>
                    <th>Block Type</th>
                    <th>#Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($Blocks as $block)
                <tr>
                    <td>{{ $block->id }}</td>
                    <td>{{ $block->title_english }}</td>
                    <td>{{ $block->title_arabic }}</td>
                    <td>
                        @if($block->block_type === 'banner')
                            <span class="badge badge-primary"><i class="fa fa-image"></i> Banner</span>
                        @else
                            <span class="badge badge-info"><i class="fa fa-file-text-o"></i> Image with Text</span>
                        @endif
                    </td>
                    <td>
                        <a style="color:white;" data-toggle="modal" data-target=".bs-show-block-modal-{{ $block->id }}" class="btn btn-primary btn-sm mr-2" title="Show"><i style="color:white;" class="fa fa-eye"></i></a>
                        
                        <a style="color:white;" data-toggle="modal" data-target=".bs-edit-block-modal-{{ $block->id }}" class="btn btn-warning btn-sm mr-2" title="Edit"><i style="color:white;" class="fa fa-pencil"></i></a>
                        
                        <a style="color:white;" data-toggle="modal" data-target=".bs-delete-block-modal-{{ $block->id }}" class="btn btn-danger btn-sm" title="Delete"><i style="color:white;" class="fa fa-trash-o"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="alert alert-info">
            <i class="fa fa-info-circle"></i> No blocks added yet. Click "Add Block" to create one.
        </div>
    @endif
</div>

