@extends('admin::layouts.master')
@section('title', 'Menu Settings')

@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Admin')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a href="{{route('admin.menu.index')}}" class="breadcrumbs__item"><i class="fa fa-bars"></i> Menus</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-cog"></i> Settings</a>
        </nav>

        <div class="col-lg-12">
            <hr>
            
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <h4 class="mt-0 header-title"><i class="fa fa-cog"></i> Menu Settings</h4>
                        </div>
                        <div class="col-sm-6 text-right">
                            <a href="{{ route('admin.menu.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fa fa-arrow-left"></i> Back to Menus
                            </a>
                        </div>
                    </div>
                    <hr>
                    
                    <form action="{{ route('admin.menu.settings.update') }}" method="POST">
                        @csrf
                        
                        @foreach($groupedSettings as $group => $settings)
                        <div class="mb-4">
                            <h5 class="text-uppercase text-muted mb-3">
                                <i class="fa fa-folder"></i> {{ ucfirst($group) }} Settings
                            </h5>
                            
                            <div class="row">
                                @foreach($settings as $setting)
                                <div class="form-group col-md-6">
                                    <label>
                                        {{ $setting->getLabel() ?? $setting->key }}
                                        @if($setting->is_system)
                                        <span class="badge badge-secondary"><i class="fa fa-lock"></i> System</span>
                                        @endif
                                    </label>
                                    
                                    @if($setting->type === 'boolean')
                                    <select class="form-control" name="settings[{{ $setting->key }}]">
                                        <option value="true" {{ $setting->value === 'true' ? 'selected' : '' }}>Yes</option>
                                        <option value="false" {{ $setting->value === 'false' ? 'selected' : '' }}>No</option>
                                    </select>
                                    @elseif($setting->type === 'integer')
                                    <input type="number" class="form-control" name="settings[{{ $setting->key }}]" value="{{ $setting->value }}">
                                    @else
                                    <input type="text" class="form-control" name="settings[{{ $setting->key }}]" value="{{ $setting->value }}">
                                    @endif
                                    
                                    @if($setting->getDescription())
                                    <small class="text-muted">{{ $setting->getDescription() }}</small>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                        
                        <hr>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-save"></i> Save Settings
                            </button>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
