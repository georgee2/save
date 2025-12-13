@extends('admin::layouts.master')
@section('title', 'Currencies List')
@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        <nav class="breadcrumbs">
            <a href="{{route('Basicdata')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-money"></i> Currencies List</a> 
        </nav>
        <div class="col-12 mx-auto">
            <hr>
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert" style="border-left: 4px solid #28a745; font-size: 16px; padding: 15px 20px;">
                    <i class="fa fa-check-circle" style="font-size: 20px;"></i> <strong>Success!</strong> {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
            @endif
            <div class="card m-b-20">
                <div class="card-body">
                    <div class="title d-flex justify-content-between">
                        <h4 class="mt-0 mb-0 header-title align-self-center text-capitalize">Currencies List</h4>
                        <div class="buttons">
                            <a href="{{ route('currency.create') }}" class="mr-2"><button class="btn btn-new"><i class="fa fa-plus"></i> Add New Currency</button></a>
                            <a href="{{ route('currency.trashed') }}" class="mr-2"><button class="btn btn-danger"><i class="fa fa-trash"></i> Trashed Currencies</button></a>
                            <button class="btn btn-primary" onclick="window.history.back()"><i class="fa fa-angle-left"></i> Back</button>
                        </div>
                    </div>
                    <hr>
                    @if(count($currencies) > 0)
                        <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name (English)</th>
                                    <th>Name (Arabic)</th>
                                    <th>Abbreviation</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>#Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($currencies as $currency)
                            <tr>
                                <td>{{ $currency->id }}</td>
                                <td>{{ $currency->name_english }}</td>
                                <td>{{ $currency->name_arabic }}</td>
                                <td><span class="badge badge-info">{{ $currency->abbreviation }}</span></td>
                                <td>
                                    @if($currency->status == 0)
                                        <span class="badge badge-success"><i class="fa fa-check-circle"></i> Active</span>
                                    @else
                                        <span class="badge badge-warning"><i class="fa fa-times-circle"></i> Inactive</span>
                                    @endif
                                </td>
                                <td>{{ \Carbon\Carbon::parse($currency->created_at)->format('M d, Y') }}</td>
                                <td>
                                    <a href="{{ route('currency.edit', ['id' => $currency->id]) }}" class="btn btn-warning btn-sm mr-2" title="Edit"><i class="fa fa-pencil"></i></a>
                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{ $currency->id }}" title="Delete"><i class="fa fa-trash-o"></i></button>
                                    <div class="modal fade" id="deleteModal{{ $currency->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <form action="{{ route('currency.delete', ['id' => $currency->id]) }}" method="POST">
                                                    @csrf
                                                    <div style="text-align: center;font-size: 25px;" class="modal-body">
                                                        <br><p>Are you Sure ?!</p><br><i style="color: #d9534f" class="fa fa-trash-o fa-5x"></i> 
                                                        <br><br><p>You Want to Delete This Currency</p><p><strong>{{ $currency->name_english }}</strong></p>
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
                    @else
                        <div class="alert alert-info">
                            <i class="fa fa-info-circle"></i> No currencies found. Click "Add New Currency" to create your first currency.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

