@php
    use App\Models\OffersPrices\OfferPrice;
    $offerPrices = OfferPrice::getByOffer($offer->id);
    $trashedPrices = OfferPrice::getTrashedByOffer($offer->id);
@endphp

<div class="prices-section">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="text-primary mb-0">
            <i class="fa fa-money"></i> Prices by Emirate
        </h5>
        <button type="button" class="btn btn-success btn-sm" onclick="openAddPriceModal()">
            <i class="fa fa-plus"></i> Add Price
        </button>
    </div>
    
    <!-- Active Prices -->
    <div id="pricesListContainer">
        @if($offerPrices->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th width="5%">#</th>
                            <th width="20%">Emirate</th>
                            <th width="15%">Price</th>
                            <th width="20%">Notes (EN)</th>
                            <th width="20%">Notes (AR)</th>
                            <th width="10%">Status</th>
                            <th width="10%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($offerPrices as $index => $price)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <strong>{{ $price->emirate_name_en }}</strong>
                                <br><small class="text-muted">{{ $price->emirate_name_ar }}</small>
                            </td>
                            <td>
                                <strong class="text-success">{{ number_format($price->price, 2) }}</strong>
                            </td>
                            <td>{{ $price->notes_english ?: '-' }}</td>
                            <td>{{ $price->notes_arabic ?: '-' }}</td>
                            <td>
                                @if($price->status == 0)
                                    <span class="badge badge-success"><i class="fa fa-check"></i> Active</span>
                                @else
                                    <span class="badge badge-secondary"><i class="fa fa-times"></i> Inactive</span>
                                @endif
                            </td>
                            <td>
                                <button type="button" class="btn btn-warning btn-sm" 
                                        onclick="openEditPriceModal({{ $price->id }}, '{{ $price->emirate_name_en }}', {{ $price->price }}, '{{ addslashes($price->notes_english) }}', '{{ addslashes($price->notes_arabic) }}', {{ $price->status }})"
                                        title="Edit">
                                    <i class="fa fa-pencil"></i>
                                </button>
                                <button type="button" class="btn btn-danger btn-sm" 
                                        onclick="openDeletePriceModal({{ $price->id }}, '{{ $price->emirate_name_en }}')"
                                        title="Delete">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info">
                <i class="fa fa-info-circle"></i> No prices added yet. Click "Add Price" to add prices by emirate.
            </div>
        @endif
    </div>
    
    <!-- Trashed Prices -->
    @if($trashedPrices->count() > 0)
        <div class="mt-4">
            <h6 class="text-danger"><i class="fa fa-trash"></i> Trashed Prices</h6>
            <div class="table-responsive">
                <table class="table table-bordered table-sm">
                    <thead class="thead-dark">
                        <tr>
                            <th>Emirate</th>
                            <th>Price</th>
                            <th>Deleted At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($trashedPrices as $price)
                        <tr>
                            <td>{{ $price->emirate_name_en }}</td>
                            <td>{{ number_format($price->price, 2) }}</td>
                            <td>{{ \Carbon\Carbon::parse($price->deleted_at)->format('M d, Y') }}</td>
                            <td>
                                <button type="button" class="btn btn-success btn-sm" onclick="restorePrice({{ $price->id }})">
                                    <i class="fa fa-undo"></i> Restore
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>

<!-- Add Price Modal -->
<div class="modal fade" id="addPriceModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title"><i class="fa fa-plus"></i> Add Price by Emirate</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addPriceForm">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Emirate <span class="text-danger">*</span></label>
                        <select class="form-control select2-emirate" name="emirate_id" id="emirate_id" required style="width: 100%;">
                            <option value="">Select Emirate</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Price <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="price" id="add_price" step="0.01" min="0" required placeholder="Enter price">
                    </div>
                    <div class="form-group">
                        <label>Notes (English)</label>
                        <input type="text" class="form-control" name="notes_english" id="add_notes_english" maxlength="255" placeholder="Optional notes in English">
                    </div>
                    <div class="form-group">
                        <label>Notes (Arabic)</label>
                        <input type="text" class="form-control" name="notes_arabic" id="add_notes_arabic" maxlength="255" placeholder="Optional notes in Arabic">
                    </div>
                    <div class="form-group">
                        <label>Status <span class="text-danger">*</span></label>
                        <select class="form-control" name="status" id="add_status" required>
                            <option value="0">Active</option>
                            <option value="1">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Add Price</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Price Modal -->
<div class="modal fade" id="editPriceModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title"><i class="fa fa-pencil"></i> Edit Price</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editPriceForm">
                @csrf
                <input type="hidden" name="price_id" id="edit_price_id">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Emirate</label>
                        <input type="text" class="form-control" id="edit_emirate_name" readonly>
                    </div>
                    <div class="form-group">
                        <label>Price <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="price" id="edit_price" step="0.01" min="0" required>
                    </div>
                    <div class="form-group">
                        <label>Notes (English)</label>
                        <input type="text" class="form-control" name="notes_english" id="edit_notes_english" maxlength="255">
                    </div>
                    <div class="form-group">
                        <label>Notes (Arabic)</label>
                        <input type="text" class="form-control" name="notes_arabic" id="edit_notes_arabic" maxlength="255">
                    </div>
                    <div class="form-group">
                        <label>Status <span class="text-danger">*</span></label>
                        <select class="form-control" name="status" id="edit_status" required>
                            <option value="0">Active</option>
                            <option value="1">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning"><i class="fa fa-save"></i> Update Price</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Price Modal -->
<div class="modal fade" id="deletePriceModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="fa fa-trash"></i> Delete Price</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <input type="hidden" id="delete_price_id">
                <i class="fa fa-exclamation-triangle fa-4x text-danger mb-3"></i>
                <h5>Are you sure you want to delete this price?</h5>
                <p class="text-muted">Emirate: <strong id="delete_emirate_name"></strong></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" onclick="confirmDeletePrice()"><i class="fa fa-trash"></i> Delete</button>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    const pricesBaseUrl = '/admin/offer/{{ $offer->id }}/prices';
    
    // Initialize Select2 for Emirate
    function initEmirateSelect2() {
        if ($('.select2-emirate').data('select2')) {
            $('.select2-emirate').select2('destroy');
        }
        $('.select2-emirate').select2({
            dropdownParent: $('#addPriceModal'),
            placeholder: 'Select Emirate',
            allowClear: true,
            width: '100%'
        });
    }

    // Open Add Price Modal
    function openAddPriceModal() {
        // Load available emirates
        $.ajax({
            url: pricesBaseUrl + '/available-emirates',
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    let options = '<option value="">Select Emirate</option>';
                    if (response.emirates.length > 0) {
                        response.emirates.forEach(function(emirate) {
                            options += `<option value="${emirate.id}">${emirate.title_english} - ${emirate.title_arabic}</option>`;
                        });
                    } else {
                        options = '<option value="">No emirates available (all already added)</option>';
                    }
                    $('#emirate_id').html(options);
                    initEmirateSelect2();
                    $('#addPriceModal').modal('show');
                }
            },
            error: function() {
                showPriceAlert('error', 'Failed to load emirates');
            }
        });
    }
    
    // Add Price Form Submit
    $('#addPriceForm').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: pricesBaseUrl + '/store',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    $('#addPriceModal').modal('hide');
                    $('#addPriceForm')[0].reset();
                    location.reload();
                } else {
                    showPriceAlert('error', response.message);
                }
            },
            error: function(xhr) {
                showPriceAlert('error', xhr.responseJSON?.message || 'Failed to add price');
            }
        });
    });
    
    // Open Edit Price Modal
    function openEditPriceModal(id, emirateName, price, notesEn, notesAr, status) {
        $('#edit_price_id').val(id);
        $('#edit_emirate_name').val(emirateName);
        $('#edit_price').val(price);
        $('#edit_notes_english').val(notesEn);
        $('#edit_notes_arabic').val(notesAr);
        $('#edit_status').val(status);
        $('#editPriceModal').modal('show');
    }
    
    // Edit Price Form Submit
    $('#editPriceForm').on('submit', function(e) {
        e.preventDefault();
        const priceId = $('#edit_price_id').val();
        
        $.ajax({
            url: pricesBaseUrl + '/update/' + priceId,
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    $('#editPriceModal').modal('hide');
                    location.reload();
                } else {
                    showPriceAlert('error', response.message);
                }
            },
            error: function(xhr) {
                showPriceAlert('error', xhr.responseJSON?.message || 'Failed to update price');
            }
        });
    });
    
    // Open Delete Price Modal
    function openDeletePriceModal(id, emirateName) {
        $('#delete_price_id').val(id);
        $('#delete_emirate_name').text(emirateName);
        $('#deletePriceModal').modal('show');
    }
    
    // Confirm Delete Price
    function confirmDeletePrice() {
        const priceId = $('#delete_price_id').val();
        
        $.ajax({
            url: pricesBaseUrl + '/delete/' + priceId,
            method: 'POST',
            data: { _token: '{{ csrf_token() }}' },
            success: function(response) {
                if (response.success) {
                    $('#deletePriceModal').modal('hide');
                    location.reload();
                } else {
                    showPriceAlert('error', response.message);
                }
            },
            error: function() {
                showPriceAlert('error', 'Failed to delete price');
            }
        });
    }
    
    // Restore Price
    function restorePrice(id) {
        if (confirm('Are you sure you want to restore this price?')) {
            $.ajax({
                url: pricesBaseUrl + '/restore/' + id,
                method: 'POST',
                data: { _token: '{{ csrf_token() }}' },
                success: function(response) {
                    if (response.success) {
                        location.reload();
                    } else {
                        showPriceAlert('error', response.message);
                    }
                },
                error: function() {
                    showPriceAlert('error', 'Failed to restore price');
                }
            });
        }
    }
    
    // Show Price Alert
    function showPriceAlert(type, message) {
        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
        
        const alertHtml = `
            <div class="alert ${alertClass} alert-dismissible fade show shadow-sm" role="alert" style="border-left: 4px solid ${type === 'success' ? '#28a745' : '#dc3545'}; font-size: 16px; padding: 15px 20px;">
                <i class="fa ${icon}" style="font-size: 20px;"></i> <strong>${type === 'success' ? 'Success!' : 'Error!'}</strong> ${message}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
        `;
        
        $('.prices-section').prepend(alertHtml);
        
        setTimeout(function() {
            $('.prices-section .alert').fadeOut('slow', function() {
                $(this).remove();
            });
        }, 5000);
    }
</script>
@endpush
