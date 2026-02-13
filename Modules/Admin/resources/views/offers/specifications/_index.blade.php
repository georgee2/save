<div class="specifications-section">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="text-primary mb-0"><i class="fa fa-list-alt"></i> Offer Specifications</h5>
        <div class="btn-group">
            <button type="button" class="btn btn-primary btn-sm" onclick="openAddSpecificationModal()">
                <i class="fa fa-plus"></i> Add Specification
            </button>
            <button type="button" class="btn btn-success btn-sm" onclick="openBulkAddSpecificationModal()">
                <i class="fa fa-plus-square"></i> Bulk Add
            </button>
        </div>
    </div>
    
    <div class="alert alert-info">
        <i class="fa fa-info-circle"></i> 
        <strong>Note:</strong> Specifications are filtered based on the offer type. Add values in English and Arabic for each specification.
    </div>
    
    <div id="specificationsListContainer">
        @include('admin::offers.specifications._list')
    </div>
</div>

<!-- Add Specification Modal -->
<div class="modal fade" id="addSpecificationModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-plus"></i> Add Specification</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addSpecificationForm">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Specification <span class="text-danger">*</span></label>
                        <select class="form-control select2-specification" name="specification_id" id="specification_id" required style="width: 100%;">
                            <option value="">Loading...</option>
                        </select>
                        <small class="form-text text-muted">Only specifications matching the offer type are shown</small>
                    </div>
                    <div class="form-group">
                        <label>Value (English) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="value_english" required>
                        <small class="form-text text-muted">Enter the value in English</small>
                    </div>
                    <div class="form-group">
                        <label>Value (Arabic) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="value_arabic" dir="rtl" required>
                        <small class="form-text text-muted">أدخل القيمة بالعربية</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save"></i> Add Specification
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Specification Modal -->
<div class="modal fade" id="editSpecificationModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-pencil"></i> Edit Specification</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editSpecificationForm">
                @csrf
                <input type="hidden" id="edit_specification_id" name="specification_id">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Specification</label>
                        <input type="text" class="form-control" id="edit_specification_name" readonly disabled>
                        <small class="form-text text-muted">Specification cannot be changed. Only values can be updated.</small>
                    </div>
                    <div class="form-group">
                        <label>Value (English) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="value_english" id="edit_value_english" required>
                    </div>
                    <div class="form-group">
                        <label>Value (Arabic) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="value_arabic" id="edit_value_arabic" dir="rtl" required>
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
<div class="modal fade" id="deleteSpecificationModal" tabindex="-1" role="dialog">
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
                <p>You want to remove this specification:</p>
                <p><strong id="delete_specification_name"></strong></p>
                <input type="hidden" id="delete_specification_id">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" onclick="confirmDeleteSpecification()">
                    <i class="fa fa-trash-o"></i> Delete
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Bulk Add Specifications Modal -->
<div class="modal fade" id="bulkAddSpecificationModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title"><i class="fa fa-plus-square"></i> Bulk Add Specifications</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="bulkAddSpecificationForm">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="fa fa-info-circle"></i> 
                        <strong>Tip:</strong> Add multiple specifications at once. Click "Add Row" to add more specifications.
                    </div>
                    
                    <div id="bulkSpecificationsContainer">
                        <!-- Dynamic rows will be added here -->
                    </div>
                    
                    <div class="text-center mt-3">
                        <button type="button" class="btn btn-outline-success btn-sm" onclick="addBulkSpecificationRow()">
                            <i class="fa fa-plus"></i> Add Row
                        </button>
                    </div>
                </div>
                <div class="modal-footer">
                    <span class="mr-auto text-muted" id="bulkRowCount">0 specifications</span>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success" id="bulkAddSubmitBtn">
                        <i class="fa fa-save"></i> Add All Specifications
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Force Delete Specification Modal -->
<div class="modal fade" id="forceDeleteSpecificationModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title"><i class="fa fa-times-circle"></i> Permanent Delete</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <i class="fa fa-exclamation-triangle fa-5x text-warning mb-3"></i>
                <h5 class="text-danger">Warning: This action cannot be undone!</h5>
                <p>You are about to <strong>permanently delete</strong> this specification:</p>
                <p><strong id="force_delete_specification_name" class="text-danger"></strong></p>
                <p class="text-muted small">This will remove the record from the database permanently.</p>
                <input type="hidden" id="force_delete_specification_id">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-dark" onclick="confirmForceDeleteSpecification()">
                    <i class="fa fa-times-circle"></i> Permanently Delete
                </button>
            </div>
        </div>
    </div>
</div>

