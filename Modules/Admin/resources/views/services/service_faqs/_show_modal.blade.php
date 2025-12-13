@foreach($ServiceFAQs as $serviceFaq)
<div class="modal fade bs-show-service-faq-modal-{{ $serviceFaq->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title mt-0">
                    <i class="fa fa-question-circle"></i> FAQ Details
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            
            <div class="modal-body">
                <!-- Questions Section -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <h6 class="text-uppercase" style="color: #667eea; font-weight: 600; letter-spacing: 1px; margin-bottom: 15px;">
                            <i class="fa fa-question"></i> Questions
                        </h6>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div style="padding: 15px; background: #f8f9fa; border-radius: 8px; border-left: 3px solid #667eea;">
                            <label style="font-size: 11px; text-transform: uppercase; color: #6c757d; font-weight: 600; margin-bottom: 5px;">English Question</label>
                            <p style="margin: 0; font-size: 15px; color: #2c3e50; font-weight: 500;">{{ $serviceFaq->faq->question_english }}</p>
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <div style="padding: 15px; background: #f8f9fa; border-radius: 8px; border-left: 3px solid #764ba2;">
                            <label style="font-size: 11px; text-transform: uppercase; color: #6c757d; font-weight: 600; margin-bottom: 5px;">Arabic Question</label>
                            <p style="margin: 0; font-size: 15px; color: #2c3e50; font-weight: 500; direction: rtl;">{{ $serviceFaq->faq->question_arabic }}</p>
                        </div>
                    </div>
                </div>
                
                <!-- Answers Section -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <h6 class="text-uppercase" style="color: #667eea; font-weight: 600; letter-spacing: 1px; margin-bottom: 15px;">
                            <i class="fa fa-commenting-o"></i> Answers
                        </h6>
                    </div>
                    <div class="col-md-12 mb-3">
                        <div style="padding: 20px; background: #f8f9fa; border-radius: 8px; border: 1px solid #e9ecef;">
                            <label style="font-size: 11px; text-transform: uppercase; color: #6c757d; font-weight: 600; margin-bottom: 10px; display: flex; align-items: center;">
                                <span class="badge badge-primary mr-2">EN</span> English Answer
                            </label>
                            <p style="margin: 0; line-height: 1.8; color: #495057;">{{ $serviceFaq->faq->answer_english }}</p>
                        </div>
                    </div>
                    
                    <div class="col-md-12 mb-3">
                        <div style="padding: 20px; background: #f8f9fa; border-radius: 8px; border: 1px solid #e9ecef;">
                            <label style="font-size: 11px; text-transform: uppercase; color: #6c757d; font-weight: 600; margin-bottom: 10px; display: flex; align-items: center;">
                                <span class="badge badge-info mr-2">AR</span> Arabic Answer
                            </label>
                            <p style="margin: 0; line-height: 1.8; color: #495057; direction: rtl;">{{ $serviceFaq->faq->answer_arabic }}</p>
                        </div>
                    </div>
                </div>
                
                <!-- Metadata Section -->
                <div class="row">
                    <div class="col-md-12">
                        <h6 class="text-uppercase" style="color: #667eea; font-weight: 600; letter-spacing: 1px; margin-bottom: 15px;">
                            <i class="fa fa-clock-o"></i> Timeline
                        </h6>
                    </div>
                    <div class="col-md-6">
                        <div style="padding: 15px; background: #e8f5e9; border-radius: 8px; border-left: 3px solid #4caf50;">
                            <label style="font-size: 11px; text-transform: uppercase; color: #2e7d32; font-weight: 600; margin-bottom: 5px; display: block;">
                                <i class="fa fa-calendar-plus-o"></i> Added to Service
                            </label>
                            <p style="margin: 0; font-size: 14px; color: #1b5e20;">{{ $serviceFaq->created_at->format('M d, Y - h:i A') }}</p>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div style="padding: 15px; background: #e3f2fd; border-radius: 8px; border-left: 3px solid #2196f3;">
                            <label style="font-size: 11px; text-transform: uppercase; color: #1565c0; font-weight: 600; margin-bottom: 5px; display: block;">
                                <i class="fa fa-hashtag"></i> FAQ ID
                            </label>
                            <p style="margin: 0; font-size: 14px; color: #0d47a1;">{{ $serviceFaq->faq->id }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer" style="background: #f8f9fa;">
                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">
                    <i class="fa fa-times"></i> Close
                </button>
                <a href="{{ route('faq.edit', ['id' => $serviceFaq->faq->id]) }}" class="btn btn-warning waves-effect waves-light" target="_blank">
                    <i class="fa fa-pencil"></i> Edit Original FAQ
                </a>
            </div>
        </div>
    </div>
</div>
@endforeach

