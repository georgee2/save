<!-- Delete Project Modal -->
<div class="modal fade" id="deleteProjectModal" tabindex="-1" role="dialog" aria-labelledby="deleteProjectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteProjectModalLabel">
                    <i class="fa fa-trash"></i> Remove Project
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center py-4">
                <i class="fa fa-exclamation-triangle fa-4x text-warning mb-3"></i>
                <h5>Are you sure?</h5>
                <p class="mb-0">You want to remove the project:</p>
                <p class="font-weight-bold text-primary" id="project-name-display"></p>
                <p class="text-muted small">This will only remove the relation, not delete the project itself.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fa fa-times"></i> Cancel
                </button>
                <button type="button" class="btn btn-danger" onclick="confirmDeleteProject()">
                    <i class="fa fa-trash"></i> Remove
                </button>
            </div>
        </div>
    </div>
</div>

