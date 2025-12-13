<!-- Add Portfolio Modal -->
<div class="modal fade" id="addPortfolioModal" tabindex="-1" role="dialog" aria-labelledby="addPortfolioModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="addPortfolioModalLabel">
                    <i class="fa fa-plus-circle"></i> Add Related Portfolio
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addPortfolioForm">
                    <div class="form-group">
                        <label for="portfolio_id">Select Portfolio <span class="text-danger">*</span></label>
                        <select class="form-control select2" id="portfolio_id" name="portfolio_id" required style="width: 100%;">
                            <option value="">-- Select Portfolio --</option>
                        </select>
                        <small class="form-text text-muted">Only available portfolios are shown</small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fa fa-times"></i> Cancel
                </button>
                <button type="button" class="btn btn-primary" onclick="addPortfolio()">
                    <i class="fa fa-save"></i> Add Portfolio
                </button>
            </div>
        </div>
    </div>
</div>

