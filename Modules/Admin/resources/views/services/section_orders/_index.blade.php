<!-- Section Ordering Tab -->
<div class="tab-pane" id="section-ordering">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="tab-content-title mb-0">
            <i class="fa fa-sort"></i> Section Ordering & Visibility
        </h5>
        <div>
            @if($SectionOrders->count() == 0)
                <form action="{{ route('service-section-order.initialize', ['serviceId' => $Service->id]) }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-success waves-effect waves-light">
                        <i class="fa fa-magic"></i> Initialize Section Orders
                    </button>
                </form>
            @else
                <form action="{{ route('service-section-order.reset', ['serviceId' => $Service->id]) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to reset all section orders to default?');">
                    @csrf
                    <button type="submit" class="btn btn-warning waves-effect waves-light">
                        <i class="fa fa-refresh"></i> Reset to Default
                    </button>
                </form>
            @endif
        </div>
    </div>
    
    @if($SectionOrders->count() > 0)
        <div class="alert alert-info" style="background: #e3f2fd; border-left: 4px solid #2196f3; color: #1565c0;">
            <i class="fa fa-info-circle"></i> <strong>Tip:</strong> Drag and drop sections to reorder them. Toggle visibility using the eye icon. Changes are saved automatically.
        </div>
        
        <div class="card" style="border: 1px solid #e9ecef; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
            <div class="card-body" style="padding: 0;">
                <table class="table table-hover mb-0" style="border-collapse: collapse;">
                    <thead style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                        <tr>
                            <th style="width: 50px; text-align: center; padding: 15px;">
                                <i class="fa fa-arrows-v"></i>
                            </th>
                            <th style="width: 80px; text-align: center;">Order</th>
                            <th>Section Name</th>
                            <th style="width: 150px; text-align: center;">Visibility</th>
                            <th style="width: 120px; text-align: center;">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="sortable-sections">
                        @foreach($SectionOrders as $sectionOrder)
                        <tr draggable="true" data-id="{{ $sectionOrder->id }}" style="cursor: move; transition: all 0.3s ease; border-bottom: 1px solid #f0f0f0;">
                            <td style="text-align: center; padding: 15px;">
                                <i class="fa fa-arrows-v" style="color: #9e9e9e; font-size: 18px;"></i>
                            </td>
                            <td style="text-align: center; font-weight: 600; color: #667eea; font-size: 16px;">
                                {{ $sectionOrder->order }}
                            </td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    @if($sectionOrder->section_type == 'features')
                                        <i class="fa fa-star" style="color: #ff9800; font-size: 20px;"></i>
                                    @elseif($sectionOrder->section_type == 'main_info')
                                        <i class="fa fa-info-circle" style="color: #2196f3; font-size: 20px;"></i>
                                    @elseif($sectionOrder->section_type == 'description')
                                        <i class="fa fa-file-text-o" style="color: #4caf50; font-size: 20px;"></i>
                                    @elseif($sectionOrder->section_type == 'values')
                                        <i class="fa fa-heart" style="color: #e91e63; font-size: 20px;"></i>
                                    @elseif($sectionOrder->section_type == 'process')
                                        <i class="fa fa-cogs" style="color: #9c27b0; font-size: 20px;"></i>
                                    @elseif($sectionOrder->section_type == 'faq')
                                        <i class="fa fa-question-circle" style="color: #00bcd4; font-size: 20px;"></i>
                                    @elseif($sectionOrder->section_type == 'custom_block')
                                        <i class="fa fa-cube" style="color: #795548; font-size: 20px;"></i>
                                    @endif
                                    
                                    <div>
                                        <strong style="font-size: 15px; color: #2c3e50;">{{ $sectionOrder->section_name }}</strong>
                                        @if($sectionOrder->section_type == 'custom_block' && $sectionOrder->block)
                                            <br>
                                            <small style="color: #7f8c8d;">
                                                <i class="fa fa-tag"></i> {{ $sectionOrder->block->title_english }}
                                                <span class="badge badge-{{ $sectionOrder->block->block_type == 'banner' ? 'primary' : 'info' }}" style="margin-left: 5px;">
                                                    {{ ucfirst(str_replace('_', ' ', $sectionOrder->block->block_type)) }}
                                                </span>
                                            </small>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td style="text-align: center;">
                                <form action="{{ route('service-section-order.toggle-visibility', ['id' => $sectionOrder->id]) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @if($sectionOrder->is_visible)
                                        <button type="submit" class="btn btn-success btn-sm waves-effect" style="min-width: 100px;" title="Click to hide">
                                            <i class="fa fa-eye"></i> Visible
                                        </button>
                                    @else
                                        <button type="submit" class="btn btn-secondary btn-sm waves-effect" style="min-width: 100px;" title="Click to show">
                                            <i class="fa fa-eye-slash"></i> Hidden
                                        </button>
                                    @endif
                                </form>
                            </td>
                            <td style="text-align: center;">
                                <span class="badge badge-light" style="font-size: 12px; padding: 6px 12px; color: #667eea; border: 1px solid #667eea;">
                                    <i class="fa fa-arrows"></i> Drag to Reorder
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="mt-3" style="padding: 15px; background: #fff3cd; border-left: 4px solid #ffc107; border-radius: 4px;">
            <h6 style="color: #856404; margin-bottom: 10px;">
                <i class="fa fa-lightbulb-o"></i> <strong>How Section Ordering Works:</strong>
            </h6>
            <ul style="margin: 0; padding-left: 20px; color: #856404;">
                <li>Sections will appear on the frontend in the order specified here</li>
                <li>Hidden sections won't be displayed on the frontend</li>
                <li>Each custom block is treated as a separate section</li>
                <li>Changes are saved automatically when you drag and drop</li>
                <li>You can reset to default order at any time</li>
            </ul>
        </div>
    @else
        <div class="alert alert-warning" style="text-align: center; padding: 40px;">
            <i class="fa fa-exclamation-triangle" style="font-size: 48px; color: #ff9800; margin-bottom: 15px;"></i>
            <h5>Section Ordering Not Initialized</h5>
            <p style="color: #666; margin-bottom: 20px;">
                Click the "Initialize Section Orders" button above to set up section ordering for this service.
            </p>
            <p style="font-size: 13px; color: #999;">
                This will create default ordering for all sections including features, values, processes, FAQs, and custom blocks.
            </p>
        </div>
    @endif
</div>

