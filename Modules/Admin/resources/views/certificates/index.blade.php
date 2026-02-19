@extends('admin::layouts.master')
@section('title', 'Certificates List')
@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Admin')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-certificate"></i> Certificates List</a> 
        </nav>

        <div class="col-lg-12">
            <hr>
            
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert" style="border-left: 4px solid #28a745; font-size: 16px; padding: 15px 20px;">
                    <i class="fa fa-check-circle" style="font-size: 20px;"></i> <strong>Success!</strong> {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert" style="border-left: 4px solid #dc3545; font-size: 16px; padding: 15px 20px;">
                    <i class="fa fa-exclamation-circle" style="font-size: 20px;"></i> <strong>Error!</strong>
                    <ul class="mb-0" style="margin-top: 10px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="mt-0 header-title align-self-center">Certificates List</h4>
                        <div class="buttons">
                            <a href="{{ route('certificate.create') }}" class="mr-2">
                                <button class="btn btn-new"><i class="fa fa-plus"></i> Add New Certificate</button>
                            </a>
                            <a href="{{ route('certificate.trashed') }}" class="mr-2">
                                <button class="btn btn-danger"><i class="fa fa-trash"></i> Trashed Certificates</button>
                            </a>
                            <button class="btn btn-primary" onclick="window.history.back()">
                                <i class="fa fa-angle-left"></i> Back
                            </button>
                        </div>
                    </div>
                    <hr>
                    
                    <div class="alert alert-info mb-3">
                        <i class="fa fa-info-circle mr-2"></i>
                        <strong>Tip:</strong> Drag and drop rows to reorder certificates. The order will be saved automatically.
                    </div>
                    
                    <table class="table table-striped table-bordered dt-responsive" style="width: 100%;">
                        <thead>
                            <tr>
                                <th style="width: 50px;">#</th>
                                <th style="width: 100px;">Image</th>
                                <th>Name (English)</th>
                                <th>Name (Arabic)</th>
                                <th>Bio (English)</th>
                                <th style="width: 100px;">Status</th>
                                <th style="width: 150px;">#Actions</th>
                            </tr>
                        </thead>
                        <tbody id="certificates-sortable">
                            @foreach($certificates as $index => $certificate)
                            <tr data-id="{{ $certificate->id }}">
                                <td class="text-center">
                                    <i class="fa fa-arrows-v text-muted" style="cursor: grab;"></i>
                                    <span class="ml-2 badge badge-secondary">{{ $certificate->ordering ?? ($index + 1) }}</span>
                                </td>
                                <td>
                                    @if($certificate->image)
                                        <a data-lightbox="{{url('/storage'.$certificate->image)}}" href="{{url('/storage'.$certificate->image)}}">
                                            <img style="width:60px; height: 60px; object-fit: contain; border-radius: 8px;" src="{{url('/storage'.$certificate->image)}}" alt="Certificate">
                                        </a>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td>{{ $certificate->name_english }}</td>
                                <td>{{ $certificate->name_arabic }}</td>
                                <td>{{ Str::limit($certificate->bio_english, 50) }}</td>
                                <td class="text-center">
                                    @if($certificate->publish_status == 1)
                                        <span class="badge badge-success"><i class="fa fa-check"></i> Published</span>
                                    @else
                                        <span class="badge badge-secondary"><i class="fa fa-eye-slash"></i> Not Published</span>
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ route('certificate.toggle-status', ['id' => $certificate->id]) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-{{ $certificate->publish_status == 1 ? 'success' : 'secondary' }} btn-sm mr-1" title="{{ $certificate->publish_status == 1 ? 'Unpublish' : 'Publish' }}">
                                            <i class="fa fa-{{ $certificate->publish_status == 1 ? 'eye' : 'eye-slash' }}"></i>
                                        </button>
                                    </form>
                                    <a href="{{ route('certificate.edit', ['id' => $certificate->id]) }}" class="btn btn-warning btn-sm mr-1" title="Edit">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{ $certificate->id }}" title="Delete">
                                        <i class="fa fa-trash-o"></i>
                                    </button>
                                    
                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteModal{{ $certificate->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <form action="{{ route('certificate.delete', ['id' => $certificate->id]) }}" method="POST">
                                                    @csrf
                                                    <div style="text-align: center;font-size: 25px;" class="modal-body">
                                                        <br>
                                                        <p>Are you Sure ?!</p><br><i style="color: #d9534f" class="fa fa-trash-o fa-5x"></i> 
                                                        <br><br><p>You Want to Delete This Certificate</p>
                                                        <p><strong>{{ $certificate->name_english }}</strong></p>
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
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if(count($certificates) == 0)
                    <div class="text-center text-muted py-4">
                        <i class="fa fa-certificate fa-3x mb-3"></i>
                        <p>No certificates found. <a href="{{ route('certificate.create') }}">Add one now</a>.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
$(document).ready(function() {
    var certificatesSortable = document.getElementById('certificates-sortable');
    if (certificatesSortable) {
        new Sortable(certificatesSortable, {
            animation: 150,
            handle: '.fa-arrows-v',
            ghostClass: 'bg-light',
            onEnd: function(evt) {
                updateOrder();
            }
        });
    }
    
    function updateOrder() {
        var orders = [];
        $('#certificates-sortable tr').each(function(index) {
            orders.push({
                id: $(this).data('id'),
                order: index + 1
            });
            $(this).find('.badge-secondary').text(index + 1);
        });
        
        $.ajax({
            url: '{{ route("certificate.update-order") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                orders: orders
            },
            success: function(response) {
                if (response.success) {
                    var notification = $('<div class="alert alert-success alert-dismissible fade show position-fixed" style="top: 20px; right: 20px; z-index: 9999; min-width: 250px;"><i class="fa fa-check-circle mr-2"></i>Order updated successfully!<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                    $('body').append(notification);
                    setTimeout(function() {
                        notification.fadeOut(function() {
                            $(this).remove();
                        });
                    }, 2000);
                }
            },
            error: function(xhr) {
                alert('Error updating order. Please try again.');
            }
        });
    }
});
</script>
@endsection
