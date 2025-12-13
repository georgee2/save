<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Related Services</h5>
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addServiceModal">
                <i class="fa fa-plus"></i> Add Service
            </button>
        </div>
        
        <div id="services-list">
            @if($showcase->services->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th width="80">ID</th>
                                <th>Service Name (English)</th>
                                <th>Service Name (Arabic)</th>
                                <th>Added Date</th>
                                <th width="150" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="services-table-body">
                            @foreach($showcase->services as $service)
                            <tr id="service-row-{{ $service->pivot->id }}">
                                <td>{{ $service->id }}</td>
                                <td>{{ $service->title_english }}</td>
                                <td>{{ $service->title_arabic }}</td>
                                <td>{{ $service->pivot->created_at->format('M d, Y') }}</td>
                                <td class="text-center">
                                    <a href="{{ route('service.show', ['id' => $service->id]) }}" 
                                       class="btn btn-info btn-sm mr-1" 
                                       title="View Service Details"
                                       target="_blank">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <button type="button" class="btn btn-danger btn-sm" 
                                            onclick="deleteService({{ $service->pivot->id }}, '{{ $service->title_english }}')"
                                            title="Remove Service">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info text-center" id="no-services-message">
                    <i class="fa fa-info-circle"></i> No services added yet. Click "Add Service" to get started.
                </div>
            @endif
        </div>
    </div>
</div>

@include('admin::showcases.related-services._add_modal')
@include('admin::showcases.related-services._delete_modal')



