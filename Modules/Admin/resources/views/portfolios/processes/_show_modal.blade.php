@foreach($Processes as $process)
<div class="modal fade bs-show-portfolio-process-modal-{{ $process->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Process Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <h6 class="text-muted">PROCESS INFORMATION</h6>
                        <hr>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <strong>English Title:</strong>
                        <p>{{ $process->title_english }}</p>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <strong>Arabic Title:</strong>
                        <p>{{ $process->title_arabic }}</p>
                    </div>
                    
                    <div class="col-md-12 mb-3">
                        <strong>English Description:</strong>
                        <p style="background: #f8f9fa; padding: 10px; border-radius: 4px;">{{ $process->description_english }}</p>
                    </div>
                    
                    <div class="col-md-12 mb-3">
                        <strong>Arabic Description:</strong>
                        <p style="background: #f8f9fa; padding: 10px; border-radius: 4px;">{{ $process->description_arabic }}</p>
                    </div>
                    
                    <div class="col-md-12 mb-3">
                        <h6 class="text-muted">IMAGES</h6>
                        <hr>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <strong>Icon:</strong><br>
                        @if($process->icon)
                            <img src="{{url('/storage' . $process->icon)}}" alt="Icon" style="max-width: 100px; max-height: 100px; border-radius: 4px; margin-top: 10px;">
                        @else
                            <p class="text-muted">No icon</p>
                        @endif
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <strong>Process Image:</strong><br>
                        @if($process->image)
                            <img src="{{url('/storage' . $process->image)}}" alt="Process Image" style="max-width: 200px; max-height: 200px; border-radius: 4px; margin-top: 10px;">
                        @else
                            <p class="text-muted">No image</p>
                        @endif
                    </div>
                    
                    <div class="col-md-12">
                        <h6 class="text-muted">METADATA</h6>
                        <hr>
                    </div>
                    
                    <div class="col-md-6 mb-2">
                        <strong>Order:</strong>
                        <p>{{ $process->order }}</p>
                    </div>
                    
                    <div class="col-md-6 mb-2">
                        <strong>Created At:</strong>
                        <p>{{ $process->created_at }}</p>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endforeach


