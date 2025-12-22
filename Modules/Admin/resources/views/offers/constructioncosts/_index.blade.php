<div class="construction-costs-section">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="text-primary mb-0">Construction Costs</h5>
        <button type="button" class="btn btn-primary btn-sm" onclick="openAddConstructionCostModal()">
            <i class="fa fa-plus"></i> Add Construction Cost
        </button>
    </div>
    
    <div class="alert alert-info">
        <i class="fa fa-info-circle"></i> 
        <strong>Note:</strong> Construction costs are based on feasibility study components filtered by offer type. You can assign a Substation Room and/or Pumps Room to each component.
    </div>
    
    <div id="constructionCostsListContainer">
        @include('admin::offers.constructioncosts._list')
    </div>
</div>

<!-- Add Construction Cost Modal -->
<div class="modal fade" id="addConstructionCostModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-plus"></i> Add Construction Cost</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addConstructionCostForm">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Feasibility Study Component <span class="text-danger">*</span></label>
                        <select class="form-control select2-construction-fsc" name="feasibility_study_component_id" id="feasibility_study_component_id_add" required style="width: 100%;">
                            <option value="">Loading...</option>
                        </select>
                        <small class="form-text text-muted">Only active components matching the offer type are shown</small>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Substation Room (Optional)</label>
                            <select class="form-control select2-construction-substation" name="substation_room_id" id="substation_room_id_add" style="width: 100%;">
                                <option value="">Loading...</option>
                            </select>
                            <small class="form-text text-muted">Filtered by offer type</small>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Pumps Room (Optional)</label>
                            <select class="form-control select2-construction-pumps" name="pumps_room_id" id="pumps_room_id_add" style="width: 100%;">
                                <option value="">Loading...</option>
                            </select>
                            <small class="form-text text-muted">Filtered by offer type</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save"></i> Add Construction Cost
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Construction Cost Modal -->
<div class="modal fade" id="editConstructionCostModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-pencil"></i> Edit Construction Cost</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editConstructionCostForm">
                @csrf
                <input type="hidden" id="edit_construction_cost_id" name="cost_id">
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <i class="fa fa-info-circle"></i> You can only update the Substation Room and Pumps Room. The Feasibility Study Component cannot be changed.
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Substation Room (Optional)</label>
                            <select class="form-control select2-construction-substation-edit" name="substation_room_id" id="substation_room_id_edit" style="width: 100%;">
                                <option value="">None</option>
                            </select>
                            <small class="form-text text-muted">Filtered by offer type</small>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Pumps Room (Optional)</label>
                            <select class="form-control select2-construction-pumps-edit" name="pumps_room_id" id="pumps_room_id_edit" style="width: 100%;">
                                <option value="">None</option>
                            </select>
                            <small class="form-text text-muted">Filtered by offer type</small>
                        </div>
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

<!-- Delete Construction Cost Confirmation Modal -->
<div class="modal fade" id="deleteConstructionCostModal" tabindex="-1" role="dialog">
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
                <p>You want to remove this construction cost:</p>
                <p><strong id="delete_construction_cost_name"></strong></p>
                <input type="hidden" id="delete_construction_cost_id">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" onclick="confirmDeleteConstructionCost()">
                    <i class="fa fa-trash-o"></i> Delete
                </button>
            </div>
        </div>
    </div>
</div>

