@foreach($Processes as $process)
<div class="modal fade bs-show-process-modal-{{ $process->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title mt-0">
                    <i class="fa fa-cogs"></i> Process Details
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            
            <div class="modal-body">
                <!-- Header Section with Icon -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;">
                            <div class="card-body text-white">
                                <div class="d-flex align-items-center">
                                    @if($process->icon)
                                        <div style="width: 80px; height: 80px; background: white; border-radius: 12px; padding: 8px; margin-right: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
                                            <img src="{{url('/storage' . $process->icon)}}" style="width: 100%; height: 100%; object-fit: contain;" alt="Icon">
                                        </div>
                                    @endif
                                    <div>
                                        <h3 class="mb-2 text-white" style="font-weight: 600;">{{ $process->title_english }}</h3>
                                        <h5 class="mb-0" style="opacity: 0.9;">{{ $process->title_arabic }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Order Badge -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="alert alert-info mb-0">
                            <i class="fa fa-sort-numeric-asc"></i> <strong>Order:</strong> {{ $process->order + 1 }}
                        </div>
                    </div>
                </div>
                
                <!-- Titles Section -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <h6 class="text-uppercase" style="color: #667eea; font-weight: 600; letter-spacing: 1px; margin-bottom: 15px;">
                            <i class="fa fa-info-circle"></i> Basic Information
                        </h6>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div style="padding: 15px; background: #f8f9fa; border-radius: 8px; border-left: 3px solid #667eea;">
                            <label style="font-size: 11px; text-transform: uppercase; color: #6c757d; font-weight: 600; margin-bottom: 5px;">English Title</label>
                            <p style="margin: 0; font-size: 15px; color: #2c3e50; font-weight: 500;">{{ $process->title_english }}</p>
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <div style="padding: 15px; background: #f8f9fa; border-radius: 8px; border-left: 3px solid #764ba2;">
                            <label style="font-size: 11px; text-transform: uppercase; color: #6c757d; font-weight: 600; margin-bottom: 5px;">Arabic Title</label>
                            <p style="margin: 0; font-size: 15px; color: #2c3e50; font-weight: 500;">{{ $process->title_arabic }}</p>
                        </div>
                    </div>
                </div>
                
                <!-- Descriptions Section -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <h6 class="text-uppercase" style="color: #667eea; font-weight: 600; letter-spacing: 1px; margin-bottom: 15px;">
                            <i class="fa fa-align-left"></i> Descriptions
                        </h6>
                    </div>
                    <div class="col-md-12 mb-3">
                        <div style="padding: 20px; background: #f8f9fa; border-radius: 8px; border: 1px solid #e9ecef;">
                            <label style="font-size: 11px; text-transform: uppercase; color: #6c757d; font-weight: 600; margin-bottom: 10px; display: flex; align-items-center;">
                                <span class="badge badge-primary mr-2">EN</span> English Description
                            </label>
                            <p style="margin: 0; line-height: 1.8; color: #495057;">{{ $process->description_english }}</p>
                        </div>
                    </div>
                    
                    <div class="col-md-12 mb-3">
                        <div style="padding: 20px; background: #f8f9fa; border-radius: 8px; border: 1px solid #e9ecef;">
                            <label style="font-size: 11px; text-transform: uppercase; color: #6c757d; font-weight: 600; margin-bottom: 10px; display: flex; align-items: center;">
                                <span class="badge badge-info mr-2">AR</span> Arabic Description
                            </label>
                            <p style="margin: 0; line-height: 1.8; color: #495057; direction: rtl;">{{ $process->description_arabic }}</p>
                        </div>
                    </div>
                </div>
                
                <!-- Images Section -->
                @if($process->icon || $process->image)
                <div class="row mb-4">
                    <div class="col-md-12">
                        <h6 class="text-uppercase" style="color: #667eea; font-weight: 600; letter-spacing: 1px; margin-bottom: 15px;">
                            <i class="fa fa-image"></i> Media & Assets
                        </h6>
                    </div>
                    
                    @if($process->icon)
                    <div class="col-md-6 mb-3">
                        <div style="padding: 20px; background: #f8f9fa; border-radius: 8px; text-align: center; border: 1px solid #e9ecef;">
                            <label style="font-size: 11px; text-transform: uppercase; color: #6c757d; font-weight: 600; margin-bottom: 15px; display: block;">
                                <i class="fa fa-shield"></i> Icon (64x64)
                            </label>
                            <div style="display: inline-block; padding: 15px; background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                                <img src="{{url('/storage' . $process->icon)}}" style="width: 64px; height: 64px; object-fit: contain;" alt="Icon">
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    @if($process->image)
                    <div class="col-md-{{ $process->icon ? '6' : '12' }} mb-3">
                        <div style="padding: 20px; background: #f8f9fa; border-radius: 8px; text-align: center; border: 1px solid #e9ecef;">
                            <label style="font-size: 11px; text-transform: uppercase; color: #6c757d; font-weight: 600; margin-bottom: 15px; display: block;">
                                <i class="fa fa-picture-o"></i> Process Image
                            </label>
                            <div style="display: inline-block; background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); overflow: hidden;">
                                <img src="{{url('/storage' . $process->image)}}" style="max-width: 100%; max-height: 250px; display: block;" alt="Process Image">
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                @endif
                
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
                                <i class="fa fa-calendar-plus-o"></i> Created At
                            </label>
                            <p style="margin: 0; font-size: 14px; color: #1b5e20;">{{ $process->created_at->format('M d, Y - h:i A') }}</p>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div style="padding: 15px; background: #fff3e0; border-radius: 8px; border-left: 3px solid #ff9800;">
                            <label style="font-size: 11px; text-transform: uppercase; color: #e65100; font-weight: 600; margin-bottom: 5px; display: block;">
                                <i class="fa fa-calendar-check-o"></i> Updated At
                            </label>
                            <p style="margin: 0; font-size: 14px; color: #bf360c;">{{ $process->updated_at->format('M d, Y - h:i A') }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer" style="background: #f8f9fa;">
                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">
                    <i class="fa fa-times"></i> Close
                </button>
                <a href="#" data-dismiss="modal" data-toggle="modal" data-target=".bs-edit-process-modal-{{ $process->id }}" class="btn btn-warning waves-effect waves-light">
                    <i class="fa fa-pencil"></i> Edit Process
                </a>
            </div>
        </div>
    </div>
</div>
@endforeach

