<div class="building-components-section">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="text-primary mb-0">Building Components</h5>
        <button type="button" class="btn btn-primary btn-sm" onclick="openAddComponentModal()">
            <i class="fa fa-plus"></i> Add Component
        </button>
    </div>
    
    <div class="alert alert-info">
        <i class="fa fa-info-circle"></i> 
        <strong>Note:</strong> Building components are filtered based on the project type. You can add and manage construction costs for each component.
    </div>
    
    <div id="componentsListContainer">
        <?php echo $__env->make('admin::projects.buildingcomponents._list', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
</div>

<!-- Add Component Modal -->
<div class="modal fade" id="addComponentModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-plus"></i> Add Building Component</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addComponentForm">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Building Component <i class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                        <select class="form-control select2" name="building_component_id" id="building_component_id" required>
                            <option value="">Loading...</option>
                        </select>
                        <small class="form-text text-muted">Only components matching the project type are shown</small>
                    </div>
                    <div class="form-group">
                        <label>Construction Cost <i class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                        <input type="number" class="form-control" name="construction_cost" step="0.01" min="0" required>
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

<!-- Edit Component Modal -->
<div class="modal fade" id="editComponentModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-pencil"></i> Edit Building Component</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editComponentForm">
                <?php echo csrf_field(); ?>
                <input type="hidden" id="edit_component_id" name="component_id">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Building Component</label>
                        <input type="text" class="form-control" id="edit_component_name" readonly disabled>
                        <small class="form-text text-muted">Component cannot be changed. Only construction cost can be updated.</small>
                    </div>
                    <div class="form-group">
                        <label>Construction Cost <i class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                        <input type="number" class="form-control" name="construction_cost" id="edit_construction_cost" step="0.01" min="0" required>
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

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteComponentModal" tabindex="-1" role="dialog">
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
                <p>You want to remove this building component:</p>
                <p><strong id="delete_component_name"></strong></p>
                <input type="hidden" id="delete_component_id">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" onclick="confirmDelete()">
                    <i class="fa fa-trash-o"></i> Delete
                </button>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\wamp64\www\smartvisionuae\Modules/Admin\resources/views/projects/buildingcomponents/_index.blade.php ENDPATH**/ ?>