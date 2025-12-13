<div class="modal fade bs-add-service-faq-modal" tabindex="-1" role="dialog" aria-labelledby="addServiceFaqModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('service-faq.store') }}" method="POST">
                @csrf
                <input type="hidden" name="service_id" value="{{ $Service->id }}">
                
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="addServiceFaqModalLabel">Add FAQ to Service</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                
                <div class="modal-body">
                    <div class="row">
                        <!-- FAQ Selection -->
                        <div class="form-group col-md-12">
                            <label>Select FAQ <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                            <select class="form-control select2" name="faq_id" id="faq-select" required style="width: 100%;">
                                <option value="">-- Select FAQ --</option>
                                @foreach($AllFAQs as $faq)
                                    <option value="{{ $faq->id }}" 
                                            data-question-en="{{ $faq->question_english }}"
                                            data-question-ar="{{ $faq->question_arabic }}"
                                            data-answer-en="{{ $faq->answer_english }}"
                                            data-answer-ar="{{ $faq->answer_arabic }}">
                                        {{ \Illuminate\Support\Str::limit($faq->question_english, 80) }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted">Choose an existing FAQ from the list</small>
                        </div>
                        
                        <!-- FAQ Preview -->
                        <div class="col-md-12" id="faq-preview" style="display: none;">
                            <div class="card" style="background: #f8f9fa; border: 1px solid #dee2e6;">
                                <div class="card-body">
                                    <h6 class="text-uppercase" style="color: #495057; font-weight: 600; margin-bottom: 15px;">
                                        <i class="fa fa-eye"></i> FAQ Preview
                                    </h6>
                                    
                                    <div class="mb-3">
                                        <label style="font-size: 11px; text-transform: uppercase; color: #6c757d; font-weight: 600;">Question (English)</label>
                                        <p id="preview-question-en" style="margin: 0; color: #2c3e50;"></p>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label style="font-size: 11px; text-transform: uppercase; color: #6c757d; font-weight: 600;">Question (Arabic)</label>
                                        <p id="preview-question-ar" style="margin: 0; color: #2c3e50; direction: rtl;"></p>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label style="font-size: 11px; text-transform: uppercase; color: #6c757d; font-weight: 600;">Answer (English)</label>
                                        <p id="preview-answer-en" style="margin: 0; color: #495057; line-height: 1.6;"></p>
                                    </div>
                                    
                                    <div class="mb-0">
                                        <label style="font-size: 11px; text-transform: uppercase; color: #6c757d; font-weight: 600;">Answer (Arabic)</label>
                                        <p id="preview-answer-ar" style="margin: 0; color: #495057; line-height: 1.6; direction: rtl;"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Add FAQ</button>
                </div>
            </form>
        </div>
    </div>
</div>

