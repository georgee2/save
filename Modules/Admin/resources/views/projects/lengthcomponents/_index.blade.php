<div class="length-components-section">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="text-primary mb-0">Length Components</h5>
        <button type="button" class="btn btn-primary btn-sm" onclick="openAddLengthComponentModal()">
            <i class="fa fa-plus"></i> Add Length Component
        </button>
    </div>
    
    <div class="alert alert-info">
        <i class="fa fa-info-circle"></i> 
        <strong>Note:</strong> Length components are filtered based on the project type and building components marked as "Is Length". You can add and manage unit costs for each length component.
    </div>
    
    <div id="lengthComponentsListContainer">
        @include('admin::projects.lengthcomponents._list')
    </div>
</div>

<!-- Add Length Component Modal -->
<div class="modal fade" id="addLengthComponentModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-plus"></i> Add Length Component</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addLengthComponentForm">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Building Component (Length) <i class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                        <select class="form-control select2" name="building_component_id" id="building_component_id_add" required>
                            <option value="">Loading...</option>
                        </select>
                        <small class="form-text text-muted">Only length building components matching the project type are shown</small>
                    </div>
                    <div class="form-group">
                        <label>Length Component <i class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                        <select class="form-control select2" name="length_component_id" id="length_component_id_add" required disabled>
                            <option value="">Select Building Component First</option>
                        </select>
                        <small class="form-text text-muted">Length components are filtered by the selected building component</small>
                    </div>
                    <div class="form-group">
                        <label>Unit Cost <i class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                        <input type="number" class="form-control" name="unit_cost" step="0.01" min="0" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save"></i> Add Component
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Length Component Modal -->
<div class="modal fade" id="editLengthComponentModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-pencil"></i> Edit Length Component</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editLengthComponentForm">
                @csrf
                <input type="hidden" id="edit_length_component_id" name="component_id">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Length Component</label>
                        <input type="text" class="form-control" id="edit_length_component_name" readonly disabled>
                        <small class="form-text text-muted">Component cannot be changed. Only unit cost can be updated.</small>
                    </div>
                    <div class="form-group">
                        <label>Unit Cost <i class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                        <input type="number" class="form-control" name="unit_cost" id="edit_length_unit_cost" step="0.01" min="0" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save"></i> Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Length Component Confirmation Modal -->
<div class="modal fade" id="deleteLengthComponentModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="fa fa-trash-o"></i> Confirm Delete</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <i class="fa fa-trash-o fa-5x text-danger mb-3"></i>
                <h5>Are you sure?</h5>
                <p>You want to remove this length component:</p>
                <p><strong id="delete_length_component_name"></strong></p>
                <input type="hidden" id="delete_length_component_id">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" onclick="confirmDeleteLengthComponent()">
                    <i class="fa fa-trash-o"></i> Delete
                </button>
            </div>
        </div>
    </div>
</div>

