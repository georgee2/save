@foreach($Blocks as $block)
<div class="modal fade bs-show-block-modal-{{ $block->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title mt-0">
                    <i class="fa fa-cube"></i> Block Details
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            
            <div class="modal-body">
                <!-- Block Type Badge -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="alert alert-dark mb-0">
                            <i class="fa fa-tag"></i> <strong>Block Type:</strong> 
                            @if($block->block_type === 'banner')
                                <span class="badge badge-primary badge-lg"><i class="fa fa-image"></i> Banner</span>
                            @else
                                <span class="badge badge-info badge-lg"><i class="fa fa-file-text-o"></i> Image with Text</span>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Titles Section -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <h6 class="text-uppercase" style="color: #343a40; font-weight: 600; letter-spacing: 1px; margin-bottom: 15px;">
                            <i class="fa fa-info-circle"></i> Basic Information
                        </h6>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div style="padding: 15px; background: #f8f9fa; border-radius: 8px; border-left: 3px solid #343a40;">
                            <label style="font-size: 11px; text-transform: uppercase; color: #6c757d; font-weight: 600; margin-bottom: 5px;">English Title</label>
                            <p style="margin: 0; font-size: 15px; color: #2c3e50; font-weight: 500;">{{ $block->title_english }}</p>
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <div style="padding: 15px; background: #f8f9fa; border-radius: 8px; border-left: 3px solid #6c757d;">
                            <label style="font-size: 11px; text-transform: uppercase; color: #6c757d; font-weight: 600; margin-bottom: 5px;">Arabic Title</label>
                            <p style="margin: 0; font-size: 15px; color: #2c3e50; font-weight: 500;">{{ $block->title_arabic }}</p>
                        </div>
                    </div>
                </div>
                
                <!-- Descriptions Section (Only for image_with_text) -->
                @if($block->block_type === 'image_with_text' && ($block->description_english || $block->description_arabic))
                <div class="row mb-4">
                    <div class="col-md-12">
                        <h6 class="text-uppercase" style="color: #343a40; font-weight: 600; letter-spacing: 1px; margin-bottom: 15px;">
                            <i class="fa fa-align-left"></i> Descriptions
                        </h6>
                    </div>
                    
                    @if($block->description_english)
                    <div class="col-md-12 mb-3">
                        <div style="padding: 20px; background: #f8f9fa; border-radius: 8px; border: 1px solid #e9ecef;">
                            <label style="font-size: 11px; text-transform: uppercase; color: #6c757d; font-weight: 600; margin-bottom: 10px; display: flex; align-items: center;">
                                <span class="badge badge-dark mr-2">EN</span> English Description
                            </label>
                            <p style="margin: 0; line-height: 1.8; color: #495057;">{{ $block->description_english }}</p>
                        </div>
                    </div>
                    @endif
                    
                    @if($block->description_arabic)
                    <div class="col-md-12 mb-3">
                        <div style="padding: 20px; background: #f8f9fa; border-radius: 8px; border: 1px solid #e9ecef;">
                            <label style="font-size: 11px; text-transform: uppercase; color: #6c757d; font-weight: 600; margin-bottom: 10px; display: flex; align-items: center;">
                                <span class="badge badge-secondary mr-2">AR</span> Arabic Description
                            </label>
                            <p style="margin: 0; line-height: 1.8; color: #495057; direction: rtl;">{{ $block->description_arabic }}</p>
                        </div>
                    </div>
                    @endif
                </div>
                @endif
                
                <!-- Image Section -->
                @if($block->image)
                <div class="row mb-4">
                    <div class="col-md-12">
                        <h6 class="text-uppercase" style="color: #343a40; font-weight: 600; letter-spacing: 1px; margin-bottom: 15px;">
                            <i class="fa fa-image"></i> Block Image
                        </h6>
                    </div>
                    
                    <div class="col-md-12 mb-3">
                        <div style="padding: 20px; background: #f8f9fa; border-radius: 8px; text-align: center; border: 1px solid #e9ecef;">
                            <label style="font-size: 11px; text-transform: uppercase; color: #6c757d; font-weight: 600; margin-bottom: 15px; display: block;">
                                <i class="fa fa-picture-o"></i> 
                                @if($block->block_type === 'banner')
                                    Banner Image (1200x400)
                                @else
                                    Content Image (600x400)
                                @endif
                            </label>
                            <div style="display: inline-block; background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); overflow: hidden;">
                                <img src="{{url('/storage' . $block->image)}}" style="max-width: 100%; max-height: 400px; display: block;" alt="Block Image">
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                
                <!-- Metadata Section -->
                <div class="row">
                    <div class="col-md-12">
                        <h6 class="text-uppercase" style="color: #343a40; font-weight: 600; letter-spacing: 1px; margin-bottom: 15px;">
                            <i class="fa fa-clock-o"></i> Timeline
                        </h6>
                    </div>
                    <div class="col-md-6">
                        <div style="padding: 15px; background: #e8f5e9; border-radius: 8px; border-left: 3px solid #4caf50;">
                            <label style="font-size: 11px; text-transform: uppercase; color: #2e7d32; font-weight: 600; margin-bottom: 5px; display: block;">
                                <i class="fa fa-calendar-plus-o"></i> Created At
                            </label>
                            <p style="margin: 0; font-size: 14px; color: #1b5e20;">{{ $block->created_at->format('M d, Y - h:i A') }}</p>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div style="padding: 15px; background: #fff3e0; border-radius: 8px; border-left: 3px solid #ff9800;">
                            <label style="font-size: 11px; text-transform: uppercase; color: #e65100; font-weight: 600; margin-bottom: 5px; display: block;">
                                <i class="fa fa-calendar-check-o"></i> Updated At
                            </label>
                            <p style="margin: 0; font-size: 14px; color: #bf360c;">{{ $block->updated_at->format('M d, Y - h:i A') }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer" style="background: #f8f9fa;">
                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">
                    <i class="fa fa-times"></i> Close
                </button>
                <a href="#" data-dismiss="modal" data-toggle="modal" data-target=".bs-edit-block-modal-{{ $block->id }}" class="btn btn-warning waves-effect waves-light">
                    <i class="fa fa-pencil"></i> Edit Block
                </a>
            </div>
        </div>
    </div>
</div>
@endforeach

