@foreach($Values as $value)
<div class="modal fade bs-edit-value-modal-{{ $value->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('service-value.update', ['id' => $value->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="modal-header">
                    <h5 class="modal-title mt-0">Edit Value</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>English Title <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                            <input type="text" class="form-control" name="title_english" value="{{ $value->title_english }}" required>
                        </div>
                        
                        <div class="form-group col-md-6">
                            <label>Arabic Title <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i></label>
                            <input type="text" class="form-control" name="title_arabic" value="{{ $value->title_arabic }}" required>
                        </div>
                        
                        <div class="form-group col-md-12">
                            <label>English Description <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i> <small class="text-muted">(Max 1000 characters)</small></label>
                            <textarea class="form-control value-desc-counter" name="description_english" rows="4" maxlength="1000" required>{{ $value->description_english }}</textarea>
                            <small class="text-muted"><span class="char-count-en">{{ strlen($value->description_english) }}</span>/1000 characters</small>
                        </div>
                        
                        <div class="form-group col-md-12">
                            <label>Arabic Description <i title="Required" class="mdi mdi-18px mdi-alert-octagon text-danger"></i> <small class="text-muted">(Max 1000 characters)</small></label>
                            <textarea class="form-control value-desc-counter" name="description_arabic" rows="4" maxlength="1000" required>{{ $value->description_arabic }}</textarea>
                            <small class="text-muted"><span class="char-count-ar">{{ strlen($value->description_arabic) }}</span>/1000 characters</small>
                        </div>
                        
                        <div class="form-group col-md-6">
                            <label>Icon (64x64px)</label>
                            @if($value->icon)
                                <input type="file" class="form-control dropify" name="icon" accept="image/*" data-default-file="{{url('/storage' . $value->icon)}}" data-max-file-size="2M">
                            @else
                                <input type="file" class="form-control dropify" name="icon" accept="image/*" data-max-file-size="2M">
                            @endif
                        </div>
                        
                        <div class="form-group col-md-6">
                            <label>Value Image (400x300px)</label>
                            @if($value->image)
                                <input type="file" class="form-control dropify" name="image" accept="image/*" data-default-file="{{url('/storage' . $value->image)}}" data-max-file-size="2M">
                            @else
                                <input type="file" class="form-control dropify" name="image" accept="image/*" data-max-file-size="2M">
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning waves-effect waves-light">Update Value</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

