<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Related News</h5>
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addNewsModal">
                <i class="fa fa-plus"></i> Add News
            </button>
        </div>
        
        <div id="news-list">
            @if($showcase->news->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th width="80">ID</th>
                                <th>News Title (English)</th>
                                <th>News Title (Arabic)</th>
                                <th>Added Date</th>
                                <th width="150" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="news-table-body">
                            @foreach($showcase->news as $newsItem)
                            <tr id="news-row-{{ $newsItem->pivot->id }}">
                                <td>{{ $newsItem->id }}</td>
                                <td>{{ $newsItem->title_english }}</td>
                                <td>{{ $newsItem->title_arabic }}</td>
                                <td>{{ $newsItem->pivot->created_at->format('M d, Y') }}</td>
                                <td class="text-center">
                                    <a href="{{ route('news-back.edit', ['id' => $newsItem->id]) }}" 
                                       class="btn btn-info btn-sm mr-1" 
                                       title="Edit News"
                                       target="_blank">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-danger btn-sm" 
                                            onclick="deleteNews({{ $newsItem->pivot->id }}, '{{ $newsItem->title_english }}')"
                                            title="Remove News">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info text-center" id="no-news-message">
                    <i class="fa fa-info-circle"></i> No news added yet. Click "Add News" to get started.
                </div>
            @endif
        </div>
    </div>
</div>

@include('admin::showcases.related-news._add_modal')
@include('admin::showcases.related-news._delete_modal')

