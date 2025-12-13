<!-- Add News Modal -->
<div class="modal fade" id="addNewsModal" tabindex="-1" role="dialog" aria-labelledby="addNewsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="addNewsModalLabel">
                    <i class="fa fa-plus-circle"></i> Add Related News
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addNewsForm">
                    <div class="form-group">
                        <label for="new_id">Select News <span class="text-danger">*</span></label>
                        <select class="form-control select2" id="new_id" name="new_id" required style="width: 100%;">
                            <option value="">-- Select News --</option>
                        </select>
                        <small class="form-text text-muted">Only available news are shown</small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fa fa-times"></i> Cancel
                </button>
                <button type="button" class="btn btn-primary" onclick="addNews()">
                    <i class="fa fa-save"></i> Add News
                </button>
            </div>
        </div>
    </div>
</div>

