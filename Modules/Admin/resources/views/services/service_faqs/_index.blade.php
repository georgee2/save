<!-- Service FAQs Tab -->
<div class="tab-pane" id="service-faqs">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="tab-content-title mb-0">Service FAQs</h5>
        <button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target=".bs-add-service-faq-modal">
            <i class="fa fa-plus"></i> Add FAQ to Service
        </button>
    </div>
    
    @if($ServiceFAQs->count() > 0)
        <table class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Question (English)</th>
                    <th>Question (Arabic)</th>
                    <th>Added At</th>
                    <th>#Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ServiceFAQs as $serviceFaq)
                <tr>
                    <td>{{ $serviceFaq->faq->id }}</td>
                    <td>{{ \Illuminate\Support\Str::limit($serviceFaq->faq->question_english, 60) }}</td>
                    <td>{{ \Illuminate\Support\Str::limit($serviceFaq->faq->question_arabic, 60) }}</td>
                    <td>{{ $serviceFaq->created_at->format('M d, Y') }}</td>
                    <td>
                        <a style="color:white;" data-toggle="modal" data-target=".bs-show-service-faq-modal-{{ $serviceFaq->id }}" class="btn btn-primary btn-sm mr-2" title="Show"><i style="color:white;" class="fa fa-eye"></i></a>
                        
                        <a style="color:white;" data-toggle="modal" data-target=".bs-delete-service-faq-modal-{{ $serviceFaq->id }}" class="btn btn-danger btn-sm" title="Remove"><i style="color:white;" class="fa fa-trash-o"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="alert alert-info">
            <i class="fa fa-info-circle"></i> No FAQs added to this service yet. Click "Add FAQ to Service" to add one.
        </div>
    @endif
</div>

