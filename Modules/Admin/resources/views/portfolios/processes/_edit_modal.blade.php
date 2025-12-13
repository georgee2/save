@foreach($Processes as $process)
<div class="modal fade bs-edit-portfolio-process-modal-{{ $process->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('portfolio-process.update', ['id' => $process->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="modal-header">
                    <h5 class="modal-title mt-0">Edit Process</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>English Title <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i> <small class="text-muted">(Max 6 words)</small></label>
                            <input type="text" class="form-control edit-title-english" name="title_english" value="{{ $process->title_english }}" data-process-id="{{ $process->id }}" required>
                            <small class="text-muted"><span id="edit-word-count-en-{{ $process->id }}">0</span>/6 words</small>
                        </div>
                        
                        <div class="form-group col-md-6">
                            <label>Arabic Title <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i> <small class="text-muted">(Max 6 words)</small></label>
                            <input type="text" class="form-control edit-title-arabic" name="title_arabic" value="{{ $process->title_arabic }}" data-process-id="{{ $process->id }}" required>
                            <small class="text-muted"><span id="edit-word-count-ar-{{ $process->id }}">0</span>/6 words</small>
                        </div>
                        
                        <div class="form-group col-md-12">
                            <label>English Description <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i> <small class="text-muted">(Max 1500 characters)</small></label>
                            <textarea class="form-control portfolio-process-desc-counter" name="description_english" rows="4" maxlength="1500" required>{{ $process->description_english }}</textarea>
                            <small class="text-muted"><span class="char-count-en">{{ strlen($process->description_english) }}</span>/1500 characters</small>
                        </div>
                        
                        <div class="form-group col-md-12">
                            <label>Arabic Description <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i> <small class="text-muted">(Max 1500 characters)</small></label>
                            <textarea class="form-control portfolio-process-desc-counter" name="description_arabic" rows="4" maxlength="1500" required>{{ $process->description_arabic }}</textarea>
                            <small class="text-muted"><span class="char-count-ar">{{ strlen($process->description_arabic) }}</span>/1500 characters</small>
                        </div>
                        
                        <div class="form-group col-md-6">
                            <label>Icon (100x100px - Will be converted to WebP)</label>
                            @if($process->icon)
                                <input type="file" class="form-control dropify" name="icon" accept="image/*" data-default-file="{{url('/storage' . $process->icon)}}" data-max-file-size="2M">
                            @else
                                <input type="file" class="form-control dropify" name="icon" accept="image/*" data-max-file-size="2M">
                            @endif
                        </div>
                        
                        <div class="form-group col-md-6">
                            <label>Process Image (600x600px - Will be converted to WebP)</label>
                            @if($process->image)
                                <input type="file" class="form-control dropify" name="image" accept="image/*" data-default-file="{{url('/storage' . $process->image)}}" data-max-file-size="5M">
                            @else
                                <input type="file" class="form-control dropify" name="image" accept="image/*" data-max-file-size="5M">
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning waves-effect waves-light">Update Process</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach


