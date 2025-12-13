<div class="floor-amenities-section">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="text-primary mb-0"><i class="fa fa-star"></i> Floor Amenities</h5>
        <button type="button" class="btn btn-primary btn-sm" onclick="openAddAmenityModal()">
            <i class="fa fa-plus"></i> Add Amenity
        </button>
    </div>
    
    <div class="alert alert-info">
        <i class="fa fa-info-circle"></i> 
        <strong>Note:</strong> Add amenities available in this floor. Each amenity can only be added once.
    </div>
    
    <div id="amenitiesListContainer">
        @include('admin::projects.floors.amenities._list')
    </div>
</div>

<!-- Add Amenity Modal -->
<div class="modal fade" id="addAmenityModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-plus"></i> Add Amenity</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addAmenityForm">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Amenity <i class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                        <select class="form-control" name="amenity_id" id="amenity_id" required>
                            <option value="">Loading...</option>
                        </select>
                        <small class="form-text text-muted">Select an amenity to add</small>
                    </div>
                    <div id="amenity-preview" style="display: none; padding: 10px; background: #f8f9fa; border-radius: 6px; margin-top: 10px;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <img id="amenity-preview-icon" src="" alt="Icon" style="width: 40px; height: 40px; object-fit: contain;">
                            <div>
                                <div id="amenity-preview-name-en" style="font-weight: 600;"></div>
                                <small id="amenity-preview-name-ar" class="text-muted"></small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save"></i> Add Amenity
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteAmenityModal" tabindex="-1" role="dialog">
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
                <p>You want to remove this amenity:</p>
                <p><strong id="delete_amenity_name"></strong></p>
                <input type="hidden" id="delete_amenity_id">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" onclick="confirmDeleteAmenity()">
                    <i class="fa fa-trash-o"></i> Delete
                </button>
            </div>
        </div>
    </div>
</div>

