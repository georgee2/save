@foreach($Features as $feature)
<div class="modal fade bs-delete-feature-modal-{{ $feature->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('service-feature.delete', ['id' => $feature->id]) }}" method="POST">
                @csrf
                
                <div style="text-align: center;font-size: 25px;" class="modal-body">
                    <br>
                    <p>Are you Sure ?!</p><br><i style="color: #d9534f" class="fa fa-trash-o fa-5x"></i> 
                    <br><br><p>You Want to Delete This Feature</p>
                    <p><strong>{{ $feature->title_english }}</strong></p>
                </div>
                <br>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger waves-effect waves-light"><i class="fa fa-trash-o"></i> Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

