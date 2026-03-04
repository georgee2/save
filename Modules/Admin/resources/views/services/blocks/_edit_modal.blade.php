@foreach($Blocks as $block)
<div class="modal fade bs-edit-block-modal-{{ $block->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('service-block.update', ['id' => $block->id]) }}" method="POST" enctype="multipart/form-data" class="edit-block-form" data-block-type="{{ $block->block_type }}">
                @csrf
                
                <div class="modal-header">
                    <h5 class="modal-title mt-0">Edit Block</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                
                <div class="modal-body">
                    <div class="row">
                        <!-- Block Type Selection -->
                        <div class="form-group col-md-12">
                            <label>Block Type <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                            <select class="form-control edit-block-type" name="block_type" required>
                                <option value="">Select Block Type</option>
                                <option value="banner" {{ $block->block_type === 'banner' ? 'selected' : '' }}>Banner (Full Width Image)</option>
                                <option value="image_with_text" {{ $block->block_type === 'image_with_text' ? 'selected' : '' }}>Image with Text</option>
                            </select>
                            <small class="text-muted">Choose the type of block to display</small>
                        </div>
                        
                        <div class="form-group col-md-6">
                            <label>English Title <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                            <input type="text" class="form-control" name="title_english" value="{{ $block->title_english }}" required>
                        </div>
                        
                        <div class="form-group col-md-6">
                            <label>Arabic Title <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i> <button type="button" class="auto-translate-btn" data-translate-source="title_english" data-translate-target="title_arabic"><i class="fa fa-language"></i> Auto</button></label>
                            <input type="text" class="form-control" name="title_arabic" value="{{ $block->title_arabic }}" required>
                        </div>
                        
                        <!-- Description Fields -->
                        <div class="form-group col-md-12 description-field" style="display: {{ $block->block_type === 'image_with_text' ? 'block' : 'none' }};">
                            <label>English Description <span class="required-indicator" style="display:{{ $block->block_type === 'image_with_text' ? 'inline' : 'none' }};"><i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></span> <small class="text-muted">(Max 1500 characters)</small></label>
                            <textarea class="form-control block-desc-counter" name="description_english" rows="4" maxlength="1500" {{ $block->block_type === 'image_with_text' ? 'required' : '' }}>{{ $block->description_english }}</textarea>
                            <small class="text-muted"><span class="char-count-en">{{ strlen($block->description_english ?? '') }}</span>/1500 characters</small>
                        </div>
                        
                        <div class="form-group col-md-12 description-field" style="display: {{ $block->block_type === 'image_with_text' ? 'block' : 'none' }};">
                            <label>Arabic Description <span class="required-indicator" style="display:{{ $block->block_type === 'image_with_text' ? 'inline' : 'none' }};"><i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></span> <small class="text-muted">(Max 1500 characters)</small> <button type="button" class="auto-translate-btn" data-translate-source="description_english" data-translate-target="description_arabic"><i class="fa fa-language"></i> Auto</button></label>
                            <textarea class="form-control block-desc-counter" name="description_arabic" rows="4" maxlength="1500" {{ $block->block_type === 'image_with_text' ? 'required' : '' }}>{{ $block->description_arabic }}</textarea>
                            <small class="text-muted"><span class="char-count-ar">{{ strlen($block->description_arabic ?? '') }}</span>/1500 characters</small>
                        </div>
                        
                        <!-- Image Field -->
                        <div class="form-group col-md-12 image-field">
                            <label>Block Image <span class="image-required-indicator"></span></label>
                            @if($block->image)
                                <input type="file" class="form-control dropify" name="image" accept="image/*" data-default-file="{{url('/storage' . $block->image)}}" data-max-file-size="2M">
                            @else
                                <input type="file" class="form-control dropify" name="image" accept="image/*" data-max-file-size="2M">
                            @endif
                            <small class="text-muted image-size-hint">
                                @if($block->block_type === 'banner')
                                    Recommended size: 1200x400px
                                @else
                                    Recommended size: 600x400px
                                @endif
                            </small>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning waves-effect waves-light">Update Block</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

