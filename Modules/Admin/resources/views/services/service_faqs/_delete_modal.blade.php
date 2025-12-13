@foreach($ServiceFAQs as $serviceFaq)
<div class="modal fade bs-delete-service-faq-modal-{{ $serviceFaq->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('service-faq.delete', ['id' => $serviceFaq->id]) }}" method="POST">
                @csrf
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title mt-0">
                        <i class="fa fa-trash-o"></i> Remove FAQ from Service
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                
                <div class="modal-body text-center py-4">
                    <i class="fa fa-exclamation-triangle text-warning" style="font-size: 64px; margin-bottom: 20px;"></i>
                    <h5 class="mb-3">Are you sure?</h5>
                    <p class="text-muted mb-2">This will remove the following FAQ from this service:</p>
                    <div class="alert alert-light" style="border: 1px solid #dee2e6; margin-top: 15px;">
                        <strong>{{ \Illuminate\Support\Str::limit($serviceFaq->faq->question_english, 100) }}</strong>
                    </div>
                    <p class="text-muted" style="font-size: 13px;">
                        <i class="fa fa-info-circle"></i> Note: This will only remove the FAQ from this service. The original FAQ will remain in the FAQ database.
                    </p>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">
                        <i class="fa fa-times"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-danger waves-effect waves-light">
                        <i class="fa fa-trash-o"></i> Remove FAQ
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

