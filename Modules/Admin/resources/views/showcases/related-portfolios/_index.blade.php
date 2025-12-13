<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Related Portfolios</h5>
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addPortfolioModal">
                <i class="fa fa-plus"></i> Add Portfolio
            </button>
        </div>
        
        <div id="portfolios-list">
            @if($showcase->portfolios->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th width="80">ID</th>
                                <th>Portfolio Name (English)</th>
                                <th>Portfolio Name (Arabic)</th>
                                <th>Added Date</th>
                                <th width="150" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="portfolios-table-body">
                            @foreach($showcase->portfolios as $portfolio)
                            <tr id="portfolio-row-{{ $portfolio->pivot->id }}">
                                <td>{{ $portfolio->id }}</td>
                                <td>{{ $portfolio->title_english }}</td>
                                <td>{{ $portfolio->title_arabic }}</td>
                                <td>{{ $portfolio->pivot->created_at->format('M d, Y') }}</td>
                                <td class="text-center">
                                    <a href="{{ route('portfolio.show', ['id' => $portfolio->id]) }}" 
                                       class="btn btn-info btn-sm mr-1" 
                                       title="View Portfolio Details"
                                       target="_blank">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <button type="button" class="btn btn-danger btn-sm" 
                                            onclick="deletePortfolio({{ $portfolio->pivot->id }}, '{{ $portfolio->title_english }}')"
                                            title="Remove Portfolio">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info text-center" id="no-portfolios-message">
                    <i class="fa fa-info-circle"></i> No portfolios added yet. Click "Add Portfolio" to get started.
                </div>
            @endif
        </div>
    </div>
</div>

@include('admin::showcases.related-portfolios._add_modal')
@include('admin::showcases.related-portfolios._delete_modal')

