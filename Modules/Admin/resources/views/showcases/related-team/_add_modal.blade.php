<!-- Add Team Member Modal -->
<div class="modal fade" id="addTeamModal" tabindex="-1" role="dialog" aria-labelledby="addTeamModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="addTeamModalLabel">
                    <i class="fa fa-plus-circle"></i> Add Related Team Member
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addTeamForm">
                    <div class="form-group">
                        <label for="team_id">Select Team Member <span class="text-danger">*</span></label>
                        <select class="form-control select2" id="team_id" name="team_id" required style="width: 100%;">
                            <option value="">-- Select Team Member --</option>
                        </select>
                        <small class="form-text text-muted">Only available team members are shown</small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fa fa-times"></i> Cancel
                </button>
                <button type="button" class="btn btn-primary" onclick="addTeamMember()">
                    <i class="fa fa-save"></i> Add Team Member
                </button>
            </div>
        </div>
    </div>
</div>

