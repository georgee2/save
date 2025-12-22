<div class="income-components-section">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="text-primary mb-0"><i class="fa fa-dollar"></i> Income Components</h5>
        <button type="button" class="btn btn-primary btn-sm" onclick="openAddIncomeComponentModal()">
            <i class="fa fa-plus"></i> Add Component
        </button>
    </div>
    
    <div class="alert alert-info">
        <i class="fa fa-info-circle"></i> 
        <strong>Note:</strong> Income components are filtered based on the offer type. Add number of units and rent per year for each component.
    </div>
    
    <div id="incomeComponentsListContainer">
        @include('admin::offers.incomecomponents._list')
    </div>
</div>

<!-- Add Component Modal -->
<div class="modal fade" id="addIncomeComponentModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-plus"></i> Add Income Component</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addIncomeComponentForm">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Income Component <span class="text-danger">*</span></label>
                        <select class="form-control select2-income" name="income_component_id" id="income_component_id" required style="width: 100%;">
                            <option value="">Loading...</option>
                        </select>
                        <small class="form-text text-muted">Only components matching the offer type are shown</small>
                    </div>
                    <div class="form-group">
                        <label>Number of Units <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="number_of_units" min="1" required>
                        <small class="form-text text-muted">Enter the number of units</small>
                    </div>
                    <div class="form-group">
                        <label>Rent Per Year <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="rent_per_year" step="0.01" min="0" required>
                        <small class="form-text text-muted">Enter the annual rent amount</small>
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
<div class="modal fade" id="editIncomeComponentModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-pencil"></i> Edit Income Component</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editIncomeComponentForm">
                @csrf
                <input type="hidden" id="edit_income_component_id" name="component_id">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Income Component</label>
                        <input type="text" class="form-control" id="edit_income_component_name" readonly disabled>
                        <small class="form-text text-muted">Component cannot be changed. Only units and rent can be updated.</small>
                    </div>
                    <div class="form-group">
                        <label>Number of Units <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="number_of_units" id="edit_income_number_of_units" min="1" required>
                    </div>
                    <div class="form-group">
                        <label>Rent Per Year <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="rent_per_year" id="edit_income_rent_per_year" step="0.01" min="0" required>
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
<div class="modal fade" id="deleteIncomeComponentModal" tabindex="-1" role="dialog">
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
                <p>You want to remove this income component:</p>
                <p><strong id="delete_income_component_name"></strong></p>
                <input type="hidden" id="delete_income_component_id">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" onclick="confirmDeleteIncomeComponent()">
                    <i class="fa fa-trash-o"></i> Delete
                </button>
            </div>
        </div>
    </div>
</div>

