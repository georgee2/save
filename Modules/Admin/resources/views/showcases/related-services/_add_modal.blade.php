<!-- Add Service Modal -->
<div class="modal fade" id="addServiceModal" tabindex="-1" role="dialog" aria-labelledby="addServiceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="addServiceModalLabel">
                    <i class="fa fa-plus-circle"></i> Add Related Service
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addServiceForm">
                    <div class="form-group">
                        <label for="service_id">Select Service <span class="text-danger">*</span></label>
                        <select class="form-control select2" id="service_id" name="service_id" required style="width: 100%;">
                            <option value="">-- Select Service --</option>
                        </select>
                        <small class="form-text text-muted">Only active and available services are shown</small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fa fa-times"></i> Cancel
                </button>
                <button type="button" class="btn btn-primary" onclick="addService()">
                    <i class="fa fa-save"></i> Add Service
                </button>
            </div>
        </div>
    </div>
</div>


