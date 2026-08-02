@extends('admin::layouts.master')
@section('title', 'View Customer - ' . ($customer->name ?: $customer->email))
@section('css')
<style>
    .border-left-primary { border-left: 4px solid #4e73df !important; }
    .border-left-success { border-left: 4px solid #1cc88a !important; }
    .border-left-info { border-left: 4px solid #36b9cc !important; }
    .border-left-warning { border-left: 4px solid #f6c23e !important; }
    .border-left-danger { border-left: 4px solid #e74a3b !important; }
    .text-gray-300 { color: #dddfeb !important; }
    .text-gray-800 { color: #5a5c69 !important; }
    .shadow-sm { box-shadow: 0 0.125rem 0.25rem 0 rgba(58,59,69,.2) !important; }
    .text-xs { font-size: .7rem; font-weight: 700; letter-spacing: .5px; }
    .card { transition: box-shadow .3s ease; }
    .card:hover { box-shadow: 0 .5rem 1rem 0 rgba(58,59,69,.3) !important; }
    .section-title { font-size: 18px; font-weight: 600; margin-bottom: 15px; }

    .agent-box { background: linear-gradient(135deg, #f8f9fc 0%, #eef1f8 100%); border: 1px solid #e3e6f0; border-radius: 10px; padding: 25px; position: relative; overflow: hidden; }
    .agent-box::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(90deg, #4e73df, #1cc88a, #36b9cc); }
    .agent-box .agent-avatar { width: 70px; height: 70px; border-radius: 50%; background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); display: flex; align-items: center; justify-content: center; color: #fff; font-size: 28px; flex-shrink: 0; box-shadow: 0 4px 15px rgba(78, 115, 223, 0.3); }
    .agent-box .agent-detail-label { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; color: #858796; margin-bottom: 3px; }
    .agent-box .agent-detail-value { font-size: 15px; font-weight: 600; color: #2d3748; }
    .agent-no-assigned { background: linear-gradient(135deg, #fff9e6 0%, #fff3cd 100%); border: 1px dashed #f6c23e; border-radius: 10px; padding: 30px; text-align: center; }
    .agent-no-assigned .icon-circle { width: 80px; height: 80px; border-radius: 50%; background: #fff; display: inline-flex; align-items: center; justify-content: center; font-size: 35px; color: #f6c23e; margin-bottom: 15px; box-shadow: 0 4px 15px rgba(246, 194, 62, 0.2); }

    .assign-modal-icon { width: 90px; height: 90px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 38px; margin-bottom: 15px; box-shadow: 0 6px 20px rgba(0,0,0,0.1); }
    .assign-modal-icon.assign { background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); color: #fff; }
    .assign-modal-icon.unassign { background: linear-gradient(135deg, #e74a3b 0%, #be2617 100%); color: #fff; }
    .assign-modal-select { border: 2px solid #d1d3e2; border-radius: 8px; padding: 12px 15px; font-size: 15px; font-weight: 600; color: #2d3748; transition: all 0.3s ease; background-color: #fff; height: auto !important; cursor: pointer; width: 100%; }
    .assign-modal-select:focus { border-color: #4e73df; box-shadow: 0 0 0 3px rgba(78, 115, 223, 0.15); background-color: #fff; outline: none; }

    .timeline-section { position: relative; padding: 0; }
    .timeline-section::before { content: ''; position: absolute; left: 28px; top: 0; bottom: 0; width: 3px; background: linear-gradient(180deg, #4e73df 0%, #e9ecef 100%); border-radius: 3px; }
    .timeline-item { position: relative; padding-left: 65px; padding-bottom: 30px; }
    .timeline-item:last-child { padding-bottom: 0; }
    .timeline-dot { position: absolute; left: 18px; top: 2px; width: 24px; height: 24px; border-radius: 50%; background: #4e73df; border: 3px solid #fff; box-shadow: 0 2px 8px rgba(78, 115, 223, 0.3); display: flex; align-items: center; justify-content: center; }
    .timeline-dot i { font-size: 10px; color: #fff; }
    .timeline-card { background: #fff; border: 1px solid #e3e6f0; border-radius: 10px; padding: 18px 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.04); transition: box-shadow 0.3s ease; }
    .timeline-card:hover { box-shadow: 0 4px 16px rgba(0,0,0,0.08); }
    .timeline-card-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 10px; }
    .timeline-author { display: flex; align-items: center; gap: 10px; }
    .timeline-author-avatar { width: 36px; height: 36px; border-radius: 50%; background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); display: flex; align-items: center; justify-content: center; color: #fff; font-size: 14px; font-weight: 700; flex-shrink: 0; }
    .timeline-author-name { font-weight: 600; color: #2d3748; font-size: 14px; }
    .timeline-date { font-size: 12px; color: #858796; }
    .timeline-body { color: #4a5568; font-size: 14px; line-height: 1.6; white-space: pre-wrap; word-break: break-word; }
    .timeline-delete-btn { background: none; border: none; color: #ccc; font-size: 14px; cursor: pointer; padding: 2px 6px; border-radius: 4px; transition: all 0.2s ease; }
    .timeline-delete-btn:hover { color: #e74a3b; background: #fdf2f2; }
    .comment-form-box { background: linear-gradient(135deg, #f8f9fc 0%, #eef1f8 100%); border: 1px solid #e3e6f0; border-radius: 10px; padding: 20px; position: relative; overflow: hidden; }
    .comment-form-box::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, #4e73df, #36b9cc); }
    .comment-textarea { border: 2px solid #d1d3e2; border-radius: 8px; padding: 12px 15px; font-size: 14px; color: #2d3748; resize: vertical; min-height: 80px; transition: all 0.3s ease; width: 100%; }
    .comment-textarea:focus { border-color: #4e73df; box-shadow: 0 0 0 3px rgba(78, 115, 223, 0.15); outline: none; }
    .timeline-empty { text-align: center; padding: 30px 20px; color: #858796; }
    .timeline-empty i { font-size: 40px; color: #dee2e6; margin-bottom: 10px; display: block; }
    .edit-input { border: 2px solid #d1d3e2; border-radius: 8px; padding: 10px 15px; font-size: 14px; font-weight: 600; color: #2d3748; transition: all 0.3s ease; background-color: #fff; width: 100%; }
    .edit-input:focus { border-color: #4e73df; box-shadow: 0 0 0 3px rgba(78, 115, 223, 0.15); outline: none; }
    .email-action-card { background: linear-gradient(135deg, #f8f9fc 0%, #eef1f8 100%); border: 1px solid #e3e6f0; border-radius: 10px; padding: 25px; text-align: center; transition: box-shadow 0.3s ease; height: 100%; position: relative; overflow: hidden; }
    .email-action-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, #4e73df, #224abe); }
    .email-action-card:hover { box-shadow: 0 4px 16px rgba(0,0,0,0.08); }
    .email-action-icon { width: 60px; height: 60px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 24px; margin-bottom: 12px; background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); color: #fff; }
    .email-log-item { border: 1px solid #e3e6f0; border-radius: 10px; padding: 18px 20px; margin-bottom: 15px; background: #fff; transition: box-shadow 0.3s; }
    .email-log-item:hover { box-shadow: 0 4px 16px rgba(0,0,0,0.06); }
    .email-log-badge { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; background: #e8eaf6; color: #4e73df; }
    .email-log-badge.status-sent { background: #e8f5e9; color: #1cc88a; }
    .email-log-badge.status-queued { background: #eef1f8; color: #858796; }
    .email-log-badge.status-failed { background: #fdecea; color: #e74a3b; }
    .email-attachment-tag { display: inline-flex; align-items: center; gap: 4px; padding: 3px 10px; background: #f8f9fc; border: 1px solid #e3e6f0; border-radius: 5px; font-size: 12px; color: #5a5c69; margin-right: 5px; margin-top: 5px; }
</style>
@endsection
@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">

        <nav class="breadcrumbs">
            <a href="{{route('CRM')}}" class="breadcrumbs__item"><i class="fa fa-home"></i> Dashboard</a>
            <a href="{{route('crm-customers.index')}}" class="breadcrumbs__item"><i class="fa fa-users"></i> Customers List</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-eye"></i> View Customer</a>
        </nav>

        <div class="col-12 mx-auto">
            <hr>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert" style="border-left: 4px solid #28a745; font-size: 16px; padding: 15px 20px;">
                    <i class="fa fa-check-circle" style="font-size: 20px;"></i> <strong>Success!</strong> {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert" style="border-left: 4px solid #e74a3b; font-size: 16px; padding: 15px 20px;">
                    <i class="fa fa-exclamation-circle" style="font-size: 20px;"></i> <strong>Error!</strong> {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
            @endif

            <div class="card m-b-20">
                <div class="card-body">
                    <div class="title d-flex justify-content-between">
                        <h4 class="mt-0 mb-0 header-title align-self-center text-capitalize">
                            <i class="fa fa-user text-primary"></i> Customer Details
                        </h4>
                        <div class="buttons">
                            <a href="{{ route('crm-customers.index') }}" class="mr-2">
                                <button class="btn btn-new"><i class="fa fa-list"></i> Customers List</button>
                            </a>
                            <button class="btn btn-primary" onclick="window.history.back()">
                                <i class="fa fa-angle-left"></i> Back
                            </button>
                        </div>
                    </div>
                    <hr>

                    {{-- Info Cards --}}
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card border-left-primary shadow-sm h-100 py-2">
                                <div class="card-body">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Name</div>
                                    <div class="h6 mb-0 font-weight-bold text-gray-800">{{ $customer->name ?: '---' }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card border-left-{{ $customer->password_set_at ? 'success' : 'warning' }} shadow-sm h-100 py-2">
                                <div class="card-body">
                                    <div class="text-xs font-weight-bold text-{{ $customer->password_set_at ? 'success' : 'warning' }} text-uppercase mb-1">Account Status</div>
                                    <div class="h6 mb-0">
                                        @if($customer->password_set_at)
                                            <span class="badge badge-success" style="font-size: 13px; padding: 7px 11px;"><i class="fa fa-check-circle"></i> Activated</span>
                                        @else
                                            <span class="badge badge-warning" style="font-size: 13px; padding: 7px 11px;"><i class="fa fa-hourglass-half"></i> Pending Activation</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card border-left-info shadow-sm h-100 py-2">
                                <div class="card-body">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">ERP Link</div>
                                    <div class="h6 mb-0 font-weight-bold text-gray-800">
                                        @if($customer->erp_customer_id)
                                            <span class="badge badge-success"><i class="fa fa-check-circle"></i> Linked</span>
                                            <code class="d-inline-block mt-1">{{ $customer->erp_customer_id }}</code>
                                        @else
                                            <span class="badge badge-secondary"><i class="fa fa-unlink"></i> Not linked</span>
                                        @endif
                                    </div>
                                    @if($customer->synced_at)
                                        <div class="text-xs text-muted mt-1">Last synced: {{ \Carbon\Carbon::parse($customer->synced_at)->format('M d, Y h:i A') }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card border-left-warning shadow-sm h-100 py-2">
                                <div class="card-body">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Projects</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $projectCount }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Favourites (account-linked wishlist) --}}
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h5 class="section-title text-primary">
                                <i class="fa fa-heart"></i> Favourites
                                <span class="badge badge-secondary">{{ $favTotal }}</span>
                            </h5>
                        </div>
                        @if($favTotal > 0)
                        <div class="col-md-12">
                            <ul class="list-group mb-2">
                                @foreach(['projects' => 'Project', 'offers' => 'Offer', 'interiors' => 'Interior'] as $favKey => $favLabel)
                                    @foreach($favGrouped[$favKey] as $fav)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>
                                            <span class="badge badge-info">{{ $favLabel }}</span>
                                            {{ $fav->itemData->title_english ?? ('#' . $fav->item_id) }}
                                        </span>
                                    </li>
                                    @endforeach
                                @endforeach
                            </ul>
                            @if($favToken)
                            <a href="{{ route('crm-favourites.show', ['sessionId' => $favToken]) }}" class="btn btn-sm btn-outline-primary">
                                <i class="fa fa-external-link-alt"></i> Manage in Favourites console
                            </a>
                            @endif
                        </div>
                        @else
                        <div class="col-md-12"><p class="text-muted mb-0">This customer has no favourites yet.</p></div>
                        @endif
                    </div>

                    {{-- Contact Information --}}
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="section-title text-primary"><i class="fa fa-address-card"></i> Contact Information</h5>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="card border-left-primary shadow-sm h-100 py-2">
                                <div class="card-body">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Email</div>
                                    <div class="h6 mb-0 font-weight-bold text-gray-800">
                                        <a href="mailto:{{ $customer->email }}">{{ $customer->email }}</a>
                                        @if($customer->email_verified_at)
                                            <span class="badge badge-info ml-1" style="font-size: 10px;">Verified</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-left-success shadow-sm h-100 py-2">
                                <div class="card-body">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Phone</div>
                                    <div class="h6 mb-0 font-weight-bold text-gray-800">{{ $customer->phone ?: '---' }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-left-info shadow-sm h-100 py-2">
                                <div class="card-body">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Preferred Language</div>
                                    <div class="h6 mb-0 font-weight-bold text-gray-800">{{ strtoupper($customer->preferred_locale ?? 'EN') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    {{-- Assigned Agent --}}
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <h5 class="section-title text-primary"><i class="fa fa-user-secret"></i> Assigned Agent</h5>
                        </div>
                    </div>

                    @if($assignedAgent)
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="agent-box">
                                <div class="d-flex align-items-start" style="gap: 25px;">
                                    <div class="agent-avatar">{{ strtoupper(substr($assignedAgent->full_name_en, 0, 1)) }}</div>
                                    <div style="flex: 1; min-width: 0;">
                                        <div class="row">
                                            <div class="col-md-3 mb-3">
                                                <div class="agent-detail-label">Full Name (English)</div>
                                                <div class="agent-detail-value">{{ $assignedAgent->full_name_en }}</div>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <div class="agent-detail-label">Full Name (Arabic)</div>
                                                <div class="agent-detail-value" dir="rtl">{{ $assignedAgent->full_name_ar }}</div>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <div class="agent-detail-label">Job Title</div>
                                                <div class="agent-detail-value"><span class="badge badge-info" style="font-size: 13px; padding: 5px 10px;">{{ $assignedAgent->job_title_english }}</span></div>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <div class="agent-detail-label">Rank</div>
                                                <div class="agent-detail-value"><span class="badge badge-primary" style="font-size: 13px; padding: 5px 10px;">{{ $assignedAgent->rank_english }}</span></div>
                                            </div>
                                        </div>
                                        <div class="d-flex" style="gap: 10px; margin-top: 5px;">
                                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#assignAgentModal">
                                                <i class="fa fa-refresh"></i> Change Agent
                                            </button>
                                            <button type="button" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#unassignAgentModal">
                                                <i class="fa fa-user-times"></i> Unassign
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="agent-no-assigned">
                                <div class="icon-circle"><i class="fa fa-user-plus"></i></div>
                                <h5 style="font-weight: 600; color: #5a5c69; margin-bottom: 8px;">No Agent Assigned</h5>
                                <p style="color: #858796; margin-bottom: 20px;">This customer does not have a sales agent yet.</p>
                                <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#assignAgentModal">
                                    <i class="fa fa-user-plus"></i> Assign Agent Now
                                </button>
                            </div>
                        </div>
                    </div>
                    @endif

                    <hr>

                    {{-- Email Actions --}}
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <h5 class="section-title text-primary"><i class="fa fa-envelope"></i> Email Actions</h5>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-8 offset-md-2">
                            <div class="email-action-card">
                                <div class="email-action-icon"><i class="fa fa-paper-plane"></i></div>
                                <h6 style="font-weight: 700; color: #2d3748; margin-bottom: 5px;">Send Direct Email</h6>
                                <p style="color: #858796; font-size: 13px; margin-bottom: 15px;">
                                    Send a custom email with attachments to <strong>{{ $customer->email }}</strong>
                                </p>
                                <button type="button" class="btn btn-dark btn-sm" data-toggle="modal" data-target="#sendEmailModal">
                                    <i class="fa fa-paper-plane"></i> Compose Email
                                </button>
                            </div>
                        </div>
                    </div>
                    @if($assignedAgent)
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="alert alert-info mb-0" style="font-size: 13px;">
                                <i class="fa fa-info-circle"></i> Emails will be sent from <strong>care@svec.ae</strong> with <strong>{{ $assignedAgent->full_name_en }}</strong> ({{ $assignedAgent->user_email }}) on CC.
                            </div>
                        </div>
                    </div>
                    @endif

                    <hr>

                    {{-- Registration meta --}}
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Registered:</strong>
                            <p class="text-muted">{{ \Carbon\Carbon::parse($customer->created_at)->format('M d, Y - h:i A') }}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>Source:</strong>
                            <p class="text-muted">{{ ucfirst($customer->source ?? 'website') }}</p>
                        </div>
                    </div>

                    <hr>

                    {{-- Email Log --}}
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <h5 class="section-title text-primary">
                                <i class="fa fa-envelope-o"></i> Email Log
                                <span class="badge badge-secondary ml-1">{{ $emailLogs->total() }}</span>
                            </h5>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-12">
                            @if($emailLogs->total() > 0)
                                @foreach($emailLogs as $log)
                                <div class="email-log-item">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div class="d-flex align-items-center" style="gap: 10px;">
                                            <div class="timeline-author-avatar" style="width: 32px; height: 32px; font-size: 12px;">
                                                {{ strtoupper(substr($log->sender->name ?? 'U', 0, 1)) }}
                                            </div>
                                            <div>
                                                <span style="font-weight: 600; color: #2d3748; font-size: 14px;">{{ $log->sender->name ?? 'Unknown' }}</span>
                                                <span class="email-log-badge">{{ $log->type }}</span>
                                                <span class="email-log-badge status-{{ $log->status ?? 'sent' }}">{{ $log->status ?? 'sent' }}</span>
                                            </div>
                                        </div>
                                        <span style="font-size: 12px; color: #858796;">
                                            <i class="fa fa-clock-o"></i> {{ \Carbon\Carbon::parse($log->created_at)->format('M d, Y - h:i A') }}
                                        </span>
                                    </div>
                                    <div style="margin-left: 42px;">
                                        <div style="font-size: 13px; color: #5a5c69; margin-bottom: 5px;">
                                            <strong>To:</strong> {{ $log->to_email }}
                                            @if($log->cc_email)<span style="margin-left: 12px;"><strong>CC:</strong> {{ $log->cc_email }}</span>@endif
                                        </div>
                                        <div style="font-size: 14px; font-weight: 600; color: #2d3748; margin-bottom: 5px;">{{ $log->subject }}</div>
                                        @if($log->body)
                                        <div style="font-size: 13px; color: #4a5568; line-height: 1.5; white-space: pre-wrap; max-height: 80px; overflow-y: auto; background: #f8f9fc; border-radius: 6px; padding: 8px 12px;">{{ \Illuminate\Support\Str::limit($log->body, 300) }}</div>
                                        @endif
                                        @if($log->attachments && count($log->attachments) > 0)
                                        <div style="margin-top: 8px;">
                                            @foreach($log->attachments as $attachment)
                                            <span class="email-attachment-tag"><i class="fa fa-paperclip"></i> {{ $attachment }}</span>
                                            @endforeach
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                                @if($emailLogs->hasPages())
                                <div class="mt-3">
                                    {{ $emailLogs->appends(request()->except('emails_page'))->links('admin::pagination.admin') }}
                                </div>
                                @endif
                            @else
                            <div class="timeline-empty">
                                <i class="fa fa-envelope-o"></i>
                                <p>No emails have been sent to this customer yet.</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <hr>

                    {{-- Follow-up Comments --}}
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <h5 class="section-title text-primary">
                                <i class="fa fa-comments"></i> Follow-up Comments
                                <span class="badge badge-secondary ml-1">{{ $comments->total() }}</span>
                            </h5>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="comment-form-box">
                                <form action="{{ route('crm-customers.store-comment', ['id' => $customer->id]) }}" method="POST">
                                    @csrf
                                    <div class="d-flex align-items-start" style="gap: 15px;">
                                        <div class="timeline-author-avatar" style="margin-top: 2px;">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                                        <div style="flex: 1;">
                                            <textarea class="comment-textarea" name="comment" placeholder="Write a follow-up comment..." required>{{ old('comment') }}</textarea>
                                            @error('comment')<span class="text-danger mt-1" style="font-size: 13px;">{{ $message }}</span>@enderror
                                            <div class="d-flex justify-content-end mt-2">
                                                <button type="submit" class="btn btn-dark btn-sm"><i class="fa fa-paper-plane"></i> Add Comment</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            @if($comments->total() > 0)
                            <div class="timeline-section">
                                @foreach($comments as $comment)
                                <div class="timeline-item">
                                    <div class="timeline-dot"><i class="fa fa-comment"></i></div>
                                    <div class="timeline-card">
                                        <div class="timeline-card-header">
                                            <div class="timeline-author">
                                                <div class="timeline-author-avatar">{{ strtoupper(substr($comment->author->name ?? 'U', 0, 1)) }}</div>
                                                <div>
                                                    <div class="timeline-author-name">{{ $comment->author->name ?? 'Unknown User' }}</div>
                                                    <div class="timeline-date">
                                                        <i class="fa fa-clock-o"></i>
                                                        {{ \Carbon\Carbon::parse($comment->created_at)->format('M d, Y - h:i A') }}
                                                        <span style="color: #b7b9cc; margin: 0 5px;">&middot;</span>
                                                        {{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="button" class="timeline-delete-btn" data-toggle="modal" data-target="#deleteCommentModal{{ $comment->id }}" title="Delete comment">
                                                <i class="fa fa-trash-o"></i>
                                            </button>
                                        </div>
                                        <div class="timeline-body">{{ $comment->comment }}</div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @if($comments->hasPages())
                            <div class="mt-3">
                                {{ $comments->appends(request()->except('comments_page'))->links('admin::pagination.admin') }}
                            </div>
                            @endif
                            @else
                            <div class="timeline-empty">
                                <i class="fa fa-comments-o"></i>
                                <p>No follow-up comments yet. Add the first comment above.</p>
                            </div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

{{-- Send Direct Email Modal --}}
<div class="modal fade" id="sendEmailModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="border: none; border-radius: 12px; overflow: hidden;">
            <form action="{{ route('crm-customers.send-email', ['id' => $customer->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body" style="padding: 35px 30px 10px;">
                    <div class="text-center mb-4">
                        <div class="assign-modal-icon assign"><i class="fa fa-paper-plane"></i></div>
                        <h4 style="font-weight: 700; color: #2d3748; margin-bottom: 5px;">Send Direct Email</h4>
                        <p style="color: #858796; font-size: 14px;">
                            From <strong>care@svec.ae</strong> to <strong>{{ $customer->email }}</strong>
                            @if($assignedAgent) &middot; CC: {{ $assignedAgent->user_email }} @endif
                        </p>
                    </div>
                    <div class="form-group mb-3">
                        <label style="font-weight: 600; color: #5a5c69; font-size: 13px;"><i class="fa fa-bookmark"></i> Subject <span class="text-danger">*</span></label>
                        <input type="text" class="edit-input" name="subject" required placeholder="Enter email subject" value="{{ old('subject') }}">
                    </div>
                    <div class="form-group mb-3">
                        <label style="font-weight: 600; color: #5a5c69; font-size: 13px;"><i class="fa fa-pencil-square-o"></i> Message <span class="text-danger">*</span></label>
                        <textarea class="comment-textarea" name="body" required placeholder="Write your email message..." style="min-height: 150px;">{{ old('body') }}</textarea>
                    </div>
                    <div class="form-group mb-3">
                        <label style="font-weight: 600; color: #5a5c69; font-size: 13px;"><i class="fa fa-paperclip"></i> Attachments <span style="color: #adb5bd; font-weight: 400;">(optional, up to 5 files, 10MB each)</span></label>
                        <div class="row" id="attachmentRows">
                            <div class="col-md-6 mb-2">
                                <input type="file" class="dropify" name="attachments[]" data-max-file-size="10M" data-height="100">
                            </div>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-secondary mt-1" id="addAttachmentBtn" style="font-size: 12px;">
                            <i class="fa fa-plus"></i> Add Another File
                        </button>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #f0f0f0; justify-content: center; padding: 15px 30px 25px;">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal" style="min-width: 120px;">Cancel</button>
                    <button type="submit" class="btn btn-dark waves-effect waves-light" style="min-width: 120px;"><i class="fa fa-paper-plane"></i> Send Email</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Delete Comment Modals --}}
@foreach($comments as $comment)
<div class="modal fade" id="deleteCommentModal{{ $comment->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border: none; border-radius: 12px; overflow: hidden;">
            <form action="{{ route('crm-customers.delete-comment', ['id' => $comment->id]) }}" method="POST">
                @csrf
                <div class="modal-body text-center" style="padding: 40px 30px 20px;">
                    <div class="assign-modal-icon unassign"><i class="fa fa-trash-o"></i></div>
                    <h4 style="font-weight: 700; color: #2d3748; margin-bottom: 8px;">Delete Comment?</h4>
                    <p style="color: #858796; font-size: 14px; margin-bottom: 5px;">This action cannot be undone</p>
                    <div style="background: #f8f9fc; border-radius: 8px; padding: 12px 15px; margin-top: 15px; text-align: left; max-height: 100px; overflow-y: auto;">
                        <small style="color: #4a5568;">{{ \Illuminate\Support\Str::limit($comment->comment, 150) }}</small>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #f0f0f0; justify-content: center; padding: 15px 30px 25px;">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal" style="min-width: 120px;">Cancel</button>
                    <button type="submit" class="btn btn-danger waves-effect waves-light" style="min-width: 120px;"><i class="fa fa-trash-o"></i> Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

{{-- Assign Agent Modal --}}
<div class="modal fade" id="assignAgentModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border: none; border-radius: 12px; overflow: hidden;">
            <form action="{{ route('crm-customers.assign-agent', ['id' => $customer->id]) }}" method="POST">
                @csrf
                <div class="modal-body text-center" style="padding: 40px 30px 10px;">
                    <div class="assign-modal-icon assign"><i class="fa fa-user-plus"></i></div>
                    <h4 style="font-weight: 700; color: #2d3748; margin-bottom: 5px;">{{ $assignedAgent ? 'Change Agent' : 'Assign Agent' }}</h4>
                    <p style="color: #858796; font-size: 14px; margin-bottom: 25px;">Select a sales agent for this customer</p>
                    <div class="text-left" style="margin-bottom: 10px;">
                        <label style="font-weight: 600; color: #5a5c69; font-size: 13px; margin-bottom: 8px;"><i class="fa fa-user-secret"></i> Sales Agent <span class="text-danger">*</span></label>
                        <select class="form-control assign-modal-select" name="assigned_agent_id" required>
                            <option selected disabled value="">-- Choose Agent --</option>
                            @foreach($agents as $agent)
                                <option value="{{ $agent->id }}" {{ ($assignedAgent && $assignedAgent->id == $agent->id) ? 'selected' : '' }}>
                                    {{ $agent->full_name_en }} — {{ $agent->full_name_ar }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #f0f0f0; justify-content: center; padding: 15px 30px 25px;">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal" style="min-width: 120px;">Cancel</button>
                    <button type="submit" class="btn btn-dark waves-effect waves-light" style="min-width: 120px;"><i class="fa fa-check"></i> Assign</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Unassign Confirmation Modal --}}
@if($assignedAgent)
<div class="modal fade" id="unassignAgentModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border: none; border-radius: 12px; overflow: hidden;">
            <form action="{{ route('crm-customers.unassign-agent', ['id' => $customer->id]) }}" method="POST">
                @csrf
                <div class="modal-body text-center" style="padding: 40px 30px 20px;">
                    <div class="assign-modal-icon unassign"><i class="fa fa-user-times"></i></div>
                    <h4 style="font-weight: 700; color: #2d3748; margin-bottom: 8px;">Unassign Agent?</h4>
                    <p style="color: #858796; font-size: 15px; margin-bottom: 5px;">You are about to remove the assigned agent</p>
                    <p style="font-size: 18px; font-weight: 600; color: #e74a3b;">{{ $assignedAgent->full_name_en }}</p>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #f0f0f0; justify-content: center; padding: 15px 30px 25px;">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal" style="min-width: 120px;">Cancel</button>
                    <button type="submit" class="btn btn-danger waves-effect waves-light" style="min-width: 120px;"><i class="fa fa-user-times"></i> Unassign</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

@endsection

@section('js')
<script src="{{ asset('/js/dropify.min.js') }}"></script>
<script>
    function initDropify() {
        $('.dropify').dropify({
            messages: {
                'default': 'Drag & drop a file or click',
                'replace': 'Drag & drop or click to replace',
                'remove':  'Remove',
                'error':   'Oops, something went wrong.'
            }
        });
    }
    initDropify();

    var attachmentCount = 1;
    $('#addAttachmentBtn').on('click', function () {
        if (attachmentCount >= 5) {
            alert('Maximum 5 attachments allowed.');
            return;
        }
        attachmentCount++;
        var html = '<div class="col-md-6 mb-2">' +
                   '<input type="file" class="dropify" name="attachments[]" data-max-file-size="10M" data-height="100">' +
                   '</div>';
        $('#attachmentRows').append(html);
        initDropify();
        if (attachmentCount >= 5) {
            $(this).hide();
        }
    });
</script>
@endsection
