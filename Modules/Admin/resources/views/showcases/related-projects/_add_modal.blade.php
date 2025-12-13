<!-- Add Project Modal -->
<div class="modal fade" id="addProjectModal" tabindex="-1" role="dialog" aria-labelledby="addProjectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="addProjectModalLabel">
                    <i class="fa fa-plus-circle"></i> Add Related Project
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addProjectForm">
                    <div class="form-group">
                        <label for="project_id">Select Project <span class="text-danger">*</span></label>
                        <select class="form-control select2" id="project_id" name="project_id" required style="width: 100%;">
                            <option value="">-- Select Project --</option>
                        </select>
                        <small class="form-text text-muted">Only active and available projects are shown</small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fa fa-times"></i> Cancel
                </button>
                <button type="button" class="btn btn-primary" onclick="addProject()">
                    <i class="fa fa-save"></i> Add Project
                </button>
            </div>
        </div>
    </div>
</div>

