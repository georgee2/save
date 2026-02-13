<div class="building-components-section">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="text-primary mb-0">Building Components</h5>
        <button type="button" class="btn btn-primary btn-sm" onclick="openAddBuildingComponentModal()">
            <i class="fa fa-plus"></i> Add Component
        </button>
    </div>
    
    <div class="alert alert-info">
        <i class="fa fa-info-circle"></i> 
        <strong>Note:</strong> Building components are filtered based on the offer type. You can add and manage construction costs for each component.
    </div>
    
    <div id="buildingComponentsListContainer">
        @include('admin::offers.buildingcomponents._list')
    </div>
</div>

<!-- Add Component Modal -->
<div class="modal fade" id="addBuildingComponentModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-plus"></i> Add Building Component</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addBuildingComponentForm">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Building Component <span class="text-danger">*</span></label>
                        <select class="form-control select2-building-component" name="building_component_id" id="offer_building_component_id" required style="width: 100%;">
                            <option value="">Loading...</option>
                        </select>
                        <small class="form-text text-muted">Only components matching the offer type are shown</small>
                    </div>
                    <div class="form-group">
                        <label>Construction Cost <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="construction_cost" id="add_building_construction_cost" step="0.01" min="0" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save"></i> Add Component
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Component Modal -->
<div class="modal fade" id="editBuildingComponentModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-pencil"></i> Edit Building Component</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editBuildingComponentForm">
                @csrf
                <input type="hidden" id="edit_building_component_id" name="component_id">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Building Component</label>
                        <input type="text" class="form-control" id="edit_building_component_name" readonly disabled>
                        <small class="form-text text-muted">Component cannot be changed. Only construction cost can be updated.</small>
                    </div>
                    <div class="form-group">
                        <label>Construction Cost <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="construction_cost" id="edit_building_construction_cost" step="0.01" min="0" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save"></i> Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteBuildingComponentModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="fa fa-trash-o"></i> Confirm Delete</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <i class="fa fa-trash-o fa-5x text-danger mb-3"></i>
                <h5>Are you sure?</h5>
                <p>You want to remove this building component:</p>
                <p><strong id="delete_building_component_name"></strong></p>
                <input type="hidden" id="delete_building_component_id">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" onclick="confirmDeleteBuildingComponent()">
                    <i class="fa fa-trash-o"></i> Delete
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const buildingComponentsBaseUrl = '/admin/offer/{{ $offer->id }}/buildingcomponents';
    
    // Helper function to reload page while preserving current tab
    function reloadWithTab() {
        const activeTab = document.querySelector('.tab-item.active');
        if (activeTab) {
            const tabId = activeTab.getAttribute('data-tab');
            const url = new URL(window.location.href);
            url.searchParams.set('tab', tabId);
            window.location.href = url.toString();
        } else {
            reloadWithTab();
        }
    }
    
    // Initialize Select2 for Building Component
    function initBuildingComponentSelect2() {
        if ($('.select2-building-component').data('select2')) {
            $('.select2-building-component').select2('destroy');
        }
        $('.select2-building-component').select2({
            dropdownParent: $('#addBuildingComponentModal'),
            placeholder: 'Select Building Component',
            allowClear: true,
            width: '100%'
        });
    }

    // Open Add Building Component Modal
    function openAddBuildingComponentModal() {
        $.ajax({
            url: buildingComponentsBaseUrl + '/available',
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    let options = '<option value="">Select Building Component</option>';
                    if (response.components.length > 0) {
                        response.components.forEach(function(component) {
                            options += `<option value="${component.id}">${component.name_english} - ${component.name_arabic}</option>`;
                        });
                    } else {
                        options = '<option value="">No components available</option>';
                    }
                    $('#offer_building_component_id').html(options);
                    initBuildingComponentSelect2();
                    $('#addBuildingComponentModal').modal('show');
                }
            },
            error: function() {
                showBuildingComponentAlert('error', 'Failed to load components');
            }
        });
    }

    // Add Building Component Form Submit
    $('#addBuildingComponentForm').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: buildingComponentsBaseUrl + '/store',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    $('#addBuildingComponentModal').modal('hide');
                    $('#addBuildingComponentForm')[0].reset();
                    reloadWithTab();
                } else {
                    showBuildingComponentAlert('error', response.message);
                }
            },
            error: function(xhr) {
                const message = xhr.responseJSON?.message || 'Failed to add component';
                showBuildingComponentAlert('error', message);
            }
        });
    });

    // Open Edit Building Component Modal
    function openEditBuildingComponentModal(id, name, cost) {
        $('#edit_building_component_id').val(id);
        $('#edit_building_component_name').val(name);
        $('#edit_building_construction_cost').val(cost);
        $('#editBuildingComponentModal').modal('show');
    }

    // Edit Building Component Form Submit
    $('#editBuildingComponentForm').on('submit', function(e) {
        e.preventDefault();
        const componentId = $('#edit_building_component_id').val();
        
        $.ajax({
            url: buildingComponentsBaseUrl + '/update/' + componentId,
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    $('#editBuildingComponentModal').modal('hide');
                    reloadWithTab();
                } else {
                    showBuildingComponentAlert('error', response.message);
                }
            },
            error: function(xhr) {
                const message = xhr.responseJSON?.message || 'Failed to update component';
                showBuildingComponentAlert('error', message);
            }
        });
    });

    // Open Delete Building Component Modal
    function openDeleteBuildingComponentModal(id, name) {
        $('#delete_building_component_id').val(id);
        $('#delete_building_component_name').text(name);
        $('#deleteBuildingComponentModal').modal('show');
    }

    // Confirm Delete Building Component
    function confirmDeleteBuildingComponent() {
        const componentId = $('#delete_building_component_id').val();
        
        $.ajax({
            url: buildingComponentsBaseUrl + '/delete/' + componentId,
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    $('#deleteBuildingComponentModal').modal('hide');
                    reloadWithTab();
                } else {
                    showBuildingComponentAlert('error', response.message);
                }
            },
            error: function(xhr) {
                const message = xhr.responseJSON?.message || 'Failed to delete component';
                showBuildingComponentAlert('error', message);
            }
        });
    }

    // Restore Building Component
    function restoreBuildingComponent(id) {
        if (confirm('Are you sure you want to restore this component?')) {
            $.ajax({
                url: buildingComponentsBaseUrl + '/restore/' + id,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        reloadWithTab();
                    } else {
                        showBuildingComponentAlert('error', response.message);
                    }
                },
                error: function(xhr) {
                    const message = xhr.responseJSON?.message || 'Failed to restore component';
                    showBuildingComponentAlert('error', message);
                }
            });
        }
    }

    // Show Building Component Alert
    function showBuildingComponentAlert(type, message) {
        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
        
        const alertHtml = `
            <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                <i class="fa ${icon}"></i> ${message}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        `;
        
        $('.building-components-section').prepend(alertHtml);
        
        setTimeout(function() {
            $('.building-components-section .alert').fadeOut('slow', function() {
                $(this).remove();
            });
        }, 5000);
    }
</script>
@endpush

