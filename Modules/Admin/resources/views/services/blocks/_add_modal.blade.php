<div class="modal fade bs-add-block-modal" tabindex="-1" role="dialog" aria-labelledby="addBlockModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('service-block.store') }}" method="POST" enctype="multipart/form-data" id="add-block-form">
                @csrf
                <input type="hidden" name="service_id" value="{{ $Service->id }}">
                
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="addBlockModalLabel">Add New Block</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                
                <div class="modal-body">
                    <div class="row">
                        <!-- Block Type Selection -->
                        <div class="form-group col-md-12">
                            <label>Block Type <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                            <select class="form-control" name="block_type" id="add-block-type" required>
                                <option value="">Select Block Type</option>
                                <option value="banner">Banner (Full Width Image)</option>
                                <option value="image_with_text">Image with Text</option>
                            </select>
                            <small class="text-muted">Choose the type of block to display</small>
                        </div>
                        
                        <div class="form-group col-md-6">
                            <label>English Title <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                            <input type="text" class="form-control" name="title_english" required>
                        </div>
                        
                        <div class="form-group col-md-6">
                            <label>Arabic Title <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i> <button type="button" class="auto-translate-btn" data-translate-source="title_english" data-translate-target="title_arabic"><i class="fa fa-language"></i> Auto</button></label>
                            <input type="text" class="form-control" name="title_arabic" required>
                        </div>
                        
                        <!-- Description Fields (Hidden by default, shown for image_with_text) -->
                        <div class="form-group col-md-12 description-field" style="display: none;">
                            <label>English Description <span class="required-indicator" style="display:none;"><i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></span> <small class="text-muted">(Max 1500 characters)</small></label>
                            <textarea class="form-control block-desc-counter" name="description_english" rows="4" maxlength="1500"></textarea>
                            <small class="text-muted"><span class="char-count-en">0</span>/1500 characters</small>
                        </div>
                        
                        <div class="form-group col-md-12 description-field" style="display: none;">
                            <label>Arabic Description <span class="required-indicator" style="display:none;"><i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></span> <small class="text-muted">(Max 1500 characters)</small> <button type="button" class="auto-translate-btn" data-translate-source="description_english" data-translate-target="description_arabic"><i class="fa fa-language"></i> Auto</button></label>
                            <textarea class="form-control block-desc-counter" name="description_arabic" rows="4" maxlength="1500"></textarea>
                            <small class="text-muted"><span class="char-count-ar">0</span>/1500 characters</small>
                        </div>
                        
                        <!-- Image Field -->
                        <div class="form-group col-md-12 image-field" style="display: none;">
                            <label>Block Image <span class="image-required-indicator" style="display:none;"><i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></span></label>
                            <input type="file" class="form-control dropify" name="image" accept="image/*" data-max-file-size="2M" id="add-block-image">
                            <small class="text-muted image-size-hint"></small>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Add Block</button>
                </div>
            </form>
        </div>
    </div>
</div>

