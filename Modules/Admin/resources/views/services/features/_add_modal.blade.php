<div class="modal fade bs-add-feature-modal" tabindex="-1" role="dialog" aria-labelledby="addFeatureModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('service-feature.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="service_id" value="{{ $Service->id }}">
                
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="addFeatureModalLabel">Add New Feature</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>English Title <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                            <input type="text" class="form-control" name="title_english" required>
                        </div>
                        
                        <div class="form-group col-md-6">
                            <label>Arabic Title <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                            <input type="text" class="form-control" name="title_arabic" required>
                        </div>
                        
                        <div class="form-group col-md-12">
                            <label>English Description <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i> <small class="text-muted">(Max 500 characters)</small></label>
                            <textarea class="form-control feature-desc-counter" name="description_english" rows="3" maxlength="500" required></textarea>
                            <small class="text-muted"><span class="char-count-en">0</span>/500 characters</small>
                        </div>
                        
                        <div class="form-group col-md-12">
                            <label>Arabic Description <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i> <small class="text-muted">(Max 500 characters)</small></label>
                            <textarea class="form-control feature-desc-counter" name="description_arabic" rows="3" maxlength="500" required></textarea>
                            <small class="text-muted"><span class="char-count-ar">0</span>/500 characters</small>
                        </div>
                        
                        <div class="form-group col-md-6">
                            <label>Icon <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i> (64x64px)</label>
                            <input type="file" class="form-control dropify" name="icon" accept="image/*" data-max-file-size="2M" required>
                        </div>
                        
                        <div class="form-group col-md-6">
                            <label>Feature Image</label>
                            <input type="file" class="form-control dropify" name="image" accept="image/*" data-max-file-size="2M">
                            <small class="text-info d-block mt-1">
                                <i class="mdi mdi-information-outline"></i> 
                                Recommended: <strong>600x220px</strong> (or wider). Image will be auto-cropped to fit the card.
                            </small>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Add Feature</button>
                </div>
            </form>
        </div>
    </div>
</div>

