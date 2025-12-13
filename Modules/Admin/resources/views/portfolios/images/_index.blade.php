<!-- Portfolio Gallery Section -->
<div class="card mt-4">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">
            <i class="fas fa-images"></i> Portfolio Gallery
            <span class="badge badge-light text-primary ml-2" id="gallery-count">0</span>
        </h5>
    </div>
    <div class="card-body">
        @if($errors->all())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('portfolio-image.store', $portfolio->id) }}" enctype="multipart/form-data" method="POST">
            @csrf
            
            <div class="form-group">
                <label class="font-weight-bold">
                    Gallery Images 
                    <small class="text-muted">(Width: 1200px - Height: 800px)</small>
                </label>
                <div class="images mb-3"></div>
                <small class="form-text text-muted">
                    <i class="fas fa-info-circle"></i> 
                    You can upload multiple images. Drag and drop to reorder. Click the X to remove an image.
                </small>
            </div>

            <div class="form-group">
                <button class="btn btn-primary" type="submit">
                     Save Gallery
                </button>
                <button class="btn btn-secondary" type="button" onclick="location.reload()">
                    Reset
                </button>
            </div>
        </form>
    </div>
</div>


