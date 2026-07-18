@extends('admin::layouts.master')
@section('title', 'Customers List')

@section('css')
<style>
    .filter-toggle-btn {
        background: linear-gradient(135deg, #19868b 0%, #0d6b6f 100%);
        border: none;
        color: white;
        padding: 10px 20px;
        border-radius: 6px;
        transition: all 0.3s ease;
    }
    .filter-toggle-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(25, 134, 139, 0.3);
        color: white;
    }
    .filter-toggle-btn i { transition: transform 0.3s ease; }
    .filter-toggle-btn.active i { transform: rotate(180deg); }
    .filter-panel {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
        border: 1px solid #e9ecef;
        display: none;
    }
    .filter-panel.show { display: block; animation: slideDown 0.3s ease; }
    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .filter-panel .form-group label { font-weight: 600; color: #495057; font-size: 13px; margin-bottom: 5px; }
    .filter-actions { display: flex; gap: 10px; align-items: flex-end; }
    .active-filters { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 15px; }
    .active-filter-tag {
        background: #19868b; color: white; padding: 5px 12px;
        border-radius: 20px; font-size: 12px; display: inline-flex; align-items: center; gap: 8px;
    }
    .active-filter-tag .remove-filter { cursor: pointer; opacity: 0.8; }
    .active-filter-tag .remove-filter:hover { opacity: 1; }
    .cust-avatar {
        width: 38px; height: 38px; border-radius: 50%;
        background: linear-gradient(135deg, #19868b 0%, #0d6b6f 100%);
        display: inline-flex; align-items: center; justify-content: center;
        color: #fff; font-weight: 700; font-size: 14px;
    }
    .pagination-wrapper {
        display: flex; justify-content: space-between; align-items: center;
        margin-top: 20px; padding-top: 20px; border-top: 1px solid #e9ecef;
    }
    .pagination-info { color: #6c757d; font-size: 14px; }
    .pagination-wrapper .pagination { margin: 0; display: flex; gap: 5px; flex-wrap: wrap; }
    .pagination-wrapper .pagination .page-item .page-link {
        border-radius: 6px; padding: 8px 14px; font-size: 14px; color: #495057;
        border: 1px solid #dee2e6; transition: all 0.2s ease; display: flex; align-items: center; gap: 5px;
    }
    .pagination-wrapper .pagination .page-item .page-link:hover { background: #19868b; border-color: #19868b; color: white; }
    .pagination-wrapper .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #19868b 0%, #0d6b6f 100%); border-color: #19868b; color: white; font-weight: 600;
    }
    .pagination-wrapper .pagination .page-item.disabled .page-link { background: #f8f9fa; color: #adb5bd; cursor: not-allowed; }
    .live-search-container { position: relative; margin-bottom: 20px; }
    .live-search-input-wrapper { position: relative; }
    .live-search-input-wrapper i.search-icon { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #19868b; font-size: 18px; }
    .live-search-input-wrapper i.clear-icon { position: absolute; right: 15px; top: 50%; transform: translateY(-50%); color: #adb5bd; font-size: 16px; cursor: pointer; display: none; }
    .live-search-input-wrapper i.clear-icon:hover { color: #dc3545; }
    .live-search-input-wrapper i.clear-icon.show { display: block; }
    .live-search-input { width: 100%; padding: 12px 45px; font-size: 15px; border: 2px solid #e9ecef; border-radius: 8px; transition: all 0.3s ease; }
    .live-search-input:focus { border-color: #19868b; box-shadow: 0 0 0 3px rgba(25, 134, 139, 0.15); outline: none; }
    .live-search-input::placeholder { color: #adb5bd; }
    .live-search-results {
        position: absolute; top: 100%; left: 0; right: 0; background: #fff;
        border: 1px solid #e9ecef; border-radius: 8px; box-shadow: 0 10px 40px rgba(0,0,0,0.15);
        max-height: 400px; overflow-y: auto; z-index: 1000; display: none; margin-top: 5px;
    }
    .live-search-results.show { display: block; animation: fadeInDown 0.2s ease; }
    @keyframes fadeInDown {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .live-search-item {
        padding: 12px 15px; border-bottom: 1px solid #f0f0f0; cursor: pointer;
        transition: all 0.2s ease; display: flex; align-items: center; gap: 12px; color: inherit; text-decoration: none;
    }
    .live-search-item:last-child { border-bottom: none; }
    .live-search-item:hover { background: #f8f9fa; text-decoration: none; color: inherit; }
    .live-search-item-icon {
        width: 40px; height: 40px; background: linear-gradient(135deg, #19868b 0%, #0d6b6f 100%);
        border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 16px; flex-shrink: 0;
    }
    .live-search-item-content { flex: 1; min-width: 0; }
    .live-search-item-title { font-weight: 600; color: #2c3e50; font-size: 14px; margin-bottom: 3px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .live-search-item-meta { font-size: 12px; color: #6c757d; display: flex; gap: 10px; flex-wrap: wrap; }
    .live-search-item-meta span { display: inline-flex; align-items: center; gap: 4px; }
    .live-search-item-badges { display: flex; gap: 5px; flex-shrink: 0; }
    .live-search-no-results { padding: 30px 15px; text-align: center; color: #6c757d; }
    .live-search-no-results i { font-size: 40px; color: #dee2e6; margin-bottom: 10px; }
    .live-search-loading { padding: 20px 15px; text-align: center; color: #6c757d; }
    .live-search-loading i { animation: spin 1s linear infinite; }
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    .highlight { background-color: #fff3cd; padding: 1px 2px; border-radius: 2px; }
</style>
@endsection

@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">

        <nav class="breadcrumbs">
            <a href="{{route('CRM')}}" class="breadcrumbs__item"><i class="fa fa-home"></i> Dashboard</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-users"></i> Customers List</a>
        </nav>

        <div class="col-lg-12">
            <hr>

            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <h4 class="mt-0 header-title align-self-center">
                            <i class="fa fa-users text-primary"></i> Registered Customers
                            <span class="badge badge-secondary ml-2">{{ $totalCount }} Total</span>
                        </h4>
                        <div class="buttons">
                            <a href="{{ route('crm-customers.export-report', array_merge(request()->query(), ['format' => 'excel'])) }}" class="btn btn-success mr-1" title="Export Excel">
                                <i class="fa fa-file-excel-o"></i> Excel
                            </a>
                            <a href="{{ route('crm-customers.export-report', array_merge(request()->query(), ['format' => 'pdf'])) }}" class="btn btn-danger mr-1" title="Export PDF">
                                <i class="fa fa-file-pdf-o"></i> PDF
                            </a>
                            <button type="button" class="btn filter-toggle-btn mr-2" id="filterToggleBtn">
                                <i class="fa fa-filter"></i> Filters
                            </button>
                            <button class="btn btn-primary" onclick="window.history.back()">
                                <i class="fa fa-angle-left"></i> Back
                            </button>
                        </div>
                    </div>

                    <!-- Live Search -->
                    <div class="live-search-container">
                        <div class="live-search-input-wrapper">
                            <i class="fa fa-search search-icon"></i>
                            <input type="text" class="live-search-input" id="liveSearchInput" placeholder="Quick search by name, email or phone..." autocomplete="off">
                            <i class="fa fa-times clear-icon" id="clearSearch"></i>
                        </div>
                        <div class="live-search-results" id="liveSearchResults"></div>
                    </div>

                    <!-- Filter Panel -->
                    <div class="filter-panel" id="filterPanel">
                        <form action="{{ route('crm-customers.index') }}" method="GET" id="filterForm">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><i class="fa fa-user"></i> Name</label>
                                        <input type="text" class="form-control" name="name" value="{{ request('name') }}" placeholder="Search name...">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><i class="fa fa-envelope"></i> Email</label>
                                        <input type="text" class="form-control" name="email" value="{{ request('email') }}" placeholder="Search email...">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label><i class="fa fa-phone"></i> Phone</label>
                                        <input type="text" class="form-control" name="phone" value="{{ request('phone') }}" placeholder="Search phone...">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label><i class="fa fa-check-circle"></i> Status</label>
                                        <select class="form-control" name="status">
                                            <option value="">All Statuses</option>
                                            <option value="activated" {{ request('status') === 'activated' ? 'selected' : '' }}>Activated</option>
                                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label><i class="fa fa-at"></i> Verified</label>
                                        <select class="form-control" name="verified">
                                            <option value="">All</option>
                                            <option value="yes" {{ request('verified') === 'yes' ? 'selected' : '' }}>Verified</option>
                                            <option value="no" {{ request('verified') === 'no' ? 'selected' : '' }}>Not Verified</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label><i class="fa fa-plug"></i> ERP Sync</label>
                                        <select class="form-control" name="erp_sync">
                                            <option value="">All</option>
                                            <option value="linked" {{ request('erp_sync') === 'linked' ? 'selected' : '' }}>Linked</option>
                                            <option value="not_linked" {{ request('erp_sync') === 'not_linked' ? 'selected' : '' }}>Not linked</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label><i class="fa fa-user-secret"></i> Agent</label>
                                        <select class="form-control" name="agent">
                                            <option value="">All Agents</option>
                                            <option value="unassigned" {{ request('agent') === 'unassigned' ? 'selected' : '' }}>Unassigned</option>
                                            @foreach($agentsList as $agentItem)
                                                <option value="{{ $agentItem->id }}" {{ request('agent') == $agentItem->id ? 'selected' : '' }}>{{ $agentItem->full_name_en }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><i class="fa fa-calendar"></i> Date From</label>
                                        <input type="date" class="form-control" name="date_from" value="{{ request('date_from') }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><i class="fa fa-calendar"></i> Date To</label>
                                        <input type="date" class="form-control" name="date_to" value="{{ request('date_to') }}">
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <div class="filter-actions">
                                            <button type="submit" class="btn btn-success btn-block">
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <div class="filter-actions">
                                            <a href="{{ route('crm-customers.index') }}" class="btn btn-secondary btn-block">
                                                <i class="fa fa-times"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Active Filters Display -->
                    @if(request()->hasAny(['name', 'email', 'phone', 'status', 'verified', 'erp_sync', 'agent', 'date_from', 'date_to']))
                    <div class="active-filters">
                        <span class="text-muted mr-2"><i class="fa fa-filter"></i> Active Filters:</span>
                        @if(request('name'))
                            <span class="active-filter-tag">Name: {{ request('name') }}
                                <a href="{{ request()->fullUrlWithQuery(['name' => null]) }}" class="remove-filter text-white"><i class="fa fa-times"></i></a></span>
                        @endif
                        @if(request('email'))
                            <span class="active-filter-tag">Email: {{ request('email') }}
                                <a href="{{ request()->fullUrlWithQuery(['email' => null]) }}" class="remove-filter text-white"><i class="fa fa-times"></i></a></span>
                        @endif
                        @if(request('phone'))
                            <span class="active-filter-tag">Phone: {{ request('phone') }}
                                <a href="{{ request()->fullUrlWithQuery(['phone' => null]) }}" class="remove-filter text-white"><i class="fa fa-times"></i></a></span>
                        @endif
                        @if(request('status'))
                            <span class="active-filter-tag">Status: {{ ucfirst(request('status')) }}
                                <a href="{{ request()->fullUrlWithQuery(['status' => null]) }}" class="remove-filter text-white"><i class="fa fa-times"></i></a></span>
                        @endif
                        @if(request('verified'))
                            <span class="active-filter-tag">Verified: {{ request('verified') === 'yes' ? 'Yes' : 'No' }}
                                <a href="{{ request()->fullUrlWithQuery(['verified' => null]) }}" class="remove-filter text-white"><i class="fa fa-times"></i></a></span>
                        @endif
                        @if(request('erp_sync'))
                            <span class="active-filter-tag">ERP: {{ request('erp_sync') === 'linked' ? 'Linked' : 'Not linked' }}
                                <a href="{{ request()->fullUrlWithQuery(['erp_sync' => null]) }}" class="remove-filter text-white"><i class="fa fa-times"></i></a></span>
                        @endif
                        @if(request('agent'))
                            <span class="active-filter-tag">Agent: {{ request('agent') === 'unassigned' ? 'Unassigned' : ($agentsList->firstWhere('id', request('agent'))->full_name_en ?? request('agent')) }}
                                <a href="{{ request()->fullUrlWithQuery(['agent' => null]) }}" class="remove-filter text-white"><i class="fa fa-times"></i></a></span>
                        @endif
                        @if(request('date_from'))
                            <span class="active-filter-tag">From: {{ request('date_from') }}
                                <a href="{{ request()->fullUrlWithQuery(['date_from' => null]) }}" class="remove-filter text-white"><i class="fa fa-times"></i></a></span>
                        @endif
                        @if(request('date_to'))
                            <span class="active-filter-tag">To: {{ request('date_to') }}
                                <a href="{{ request()->fullUrlWithQuery(['date_to' => null]) }}" class="remove-filter text-white"><i class="fa fa-times"></i></a></span>
                        @endif
                    </div>
                    @endif

                    <hr>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Customer</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Assigned Agent</th>
                                    <th>Status</th>
                                    <th>Verified</th>
                                    <th>ERP</th>
                                    <th>Registered</th>
                                    <th>#Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($customers as $customer)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center" style="gap:10px;">
                                            <span class="cust-avatar">{{ strtoupper(substr($customer->name ?: $customer->email, 0, 1)) }}</span>
                                            <span>{{ $customer->name ?: '---' }}</span>
                                        </div>
                                    </td>
                                    <td><a href="mailto:{{ $customer->email }}">{{ $customer->email }}</a></td>
                                    <td>{{ $customer->phone ?: '---' }}</td>
                                    <td>
                                        @if($customer->agent_name)
                                            <span class="badge badge-dark" style="font-size: 12px;"><i class="fa fa-user-secret"></i> {{ $customer->agent_name }}</span>
                                        @else
                                            <span class="text-muted">---</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($customer->password_set_at)
                                            <span class="badge badge-success" style="font-size: 12px;"><i class="fa fa-check-circle"></i> Activated</span>
                                        @else
                                            <span class="badge badge-warning" style="font-size: 12px;"><i class="fa fa-hourglass-half"></i> Pending</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($customer->email_verified_at)
                                            <span class="badge badge-info"><i class="fa fa-check"></i> Yes</span>
                                        @else
                                            <span class="text-muted">No</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($customer->erp_customer_id)
                                            <span class="badge badge-primary" style="font-size: 11px;">{{ $customer->erp_customer_id }}</span>
                                        @else
                                            <span class="text-muted" title="Not linked to ERP">---</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small>{{ \Carbon\Carbon::parse($customer->created_at)->format('M d, Y') }}</small>
                                        <br><small class="text-muted">{{ \Carbon\Carbon::parse($customer->created_at)->format('h:i A') }}</small>
                                    </td>
                                    <td>
                                        <a href="{{ route('crm-customers.show', ['id' => $customer->id]) }}" class="btn btn-info btn-sm" title="View Details">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center py-4">
                                        <i class="fa fa-users fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">No customers found matching your criteria.</p>
                                        @if(request()->hasAny(['name', 'email', 'phone', 'status', 'verified', 'erp_sync', 'agent', 'date_from', 'date_to']))
                                            <a href="{{ route('crm-customers.index') }}" class="btn btn-sm btn-primary">Clear Filters</a>
                                        @endif
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($customers->hasPages())
                    <div class="pagination-wrapper">
                        <div class="pagination-info">
                            Showing {{ $customers->firstItem() }} to {{ $customers->lastItem() }} of {{ $customers->total() }} customers
                        </div>
                        <div>
                            {{ $customers->links('admin::pagination.admin') }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    var filterToggleBtn = document.getElementById('filterToggleBtn');
    var filterPanel = document.getElementById('filterPanel');

    @if(request()->hasAny(['name', 'email', 'phone', 'status', 'verified', 'erp_sync', 'agent', 'date_from', 'date_to']))
        filterPanel.classList.add('show');
        filterToggleBtn.classList.add('active');
    @endif

    filterToggleBtn.addEventListener('click', function() {
        filterPanel.classList.toggle('show');
        this.classList.toggle('active');
    });

    var liveSearchInput = document.getElementById('liveSearchInput');
    var liveSearchResults = document.getElementById('liveSearchResults');
    var clearSearchBtn = document.getElementById('clearSearch');
    var searchTimeout = null;

    liveSearchInput.addEventListener('input', function() {
        var query = this.value.trim();

        if (query.length > 0) {
            clearSearchBtn.classList.add('show');
        } else {
            clearSearchBtn.classList.remove('show');
            liveSearchResults.classList.remove('show');
            return;
        }

        if (searchTimeout) clearTimeout(searchTimeout);

        if (query.length >= 1) {
            liveSearchResults.innerHTML = '<div class="live-search-loading"><i class="fa fa-spinner"></i> Searching...</div>';
            liveSearchResults.classList.add('show');
        }

        searchTimeout = setTimeout(function() {
            if (query.length >= 1) performLiveSearch(query);
        }, 300);
    });

    clearSearchBtn.addEventListener('click', function() {
        liveSearchInput.value = '';
        liveSearchResults.classList.remove('show');
        this.classList.remove('show');
        liveSearchInput.focus();
    });

    document.addEventListener('click', function(e) {
        if (!liveSearchInput.contains(e.target) && !liveSearchResults.contains(e.target)) {
            liveSearchResults.classList.remove('show');
        }
    });

    liveSearchInput.addEventListener('focus', function() {
        if (this.value.trim().length >= 1 && liveSearchResults.innerHTML.trim() !== '') {
            liveSearchResults.classList.add('show');
        }
    });

    function performLiveSearch(query) {
        fetch('{{ route("crm-customers.live-search") }}?q=' + encodeURIComponent(query), {
            method: 'GET',
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        })
        .then(function(r) { return r.json(); })
        .then(function(data) {
            if (data.length === 0) {
                liveSearchResults.innerHTML = '<div class="live-search-no-results"><i class="fa fa-search"></i><p class="mb-0">No customers found for "<strong>' + escapeHtml(query) + '</strong>"</p></div>';
            } else {
                var html = '';
                data.forEach(function(item) {
                    var nameText = item.name || '---';
                    var emailText = item.email || '---';
                    var phoneText = item.phone || '---';

                    html += '<a href="{{ url("crm/customers/show") }}/' + item.id + '" class="live-search-item">'
                        + '<div class="live-search-item-icon"><i class="fa fa-user"></i></div>'
                        + '<div class="live-search-item-content">'
                        + '<div class="live-search-item-title">' + highlightMatch(nameText, query) + '</div>'
                        + '<div class="live-search-item-meta">'
                        + '<span><i class="fa fa-envelope"></i> ' + highlightMatch(emailText, query) + '</span>'
                        + '<span><i class="fa fa-phone"></i> ' + highlightMatch(phoneText, query) + '</span>'
                        + '</div>'
                        + '</div>'
                        + '<div class="live-search-item-badges">'
                        + '<span class="badge badge-' + item.status_class + '" style="font-size:10px;">' + item.status_label + '</span>'
                        + '</div>'
                        + '</a>';
                });
                liveSearchResults.innerHTML = html;
            }
            liveSearchResults.classList.add('show');
        })
        .catch(function() {
            liveSearchResults.innerHTML = '<div class="live-search-no-results"><i class="fa fa-exclamation-triangle"></i><p class="mb-0">Error searching. Please try again.</p></div>';
            liveSearchResults.classList.add('show');
        });
    }

    function highlightMatch(text, query) {
        if (!text || !query) return escapeHtml(text || '');
        var escaped = escapeHtml(text);
        var escapedQ = escapeHtml(query).replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
        return escaped.replace(new RegExp('(' + escapedQ + ')', 'gi'), '<span class="highlight">$1</span>');
    }

    function escapeHtml(text) {
        if (!text) return '';
        var div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    liveSearchInput.addEventListener('keydown', function(e) {
        var items = liveSearchResults.querySelectorAll('.live-search-item');
        var active = liveSearchResults.querySelector('.live-search-item.active');

        if (e.key === 'ArrowDown') {
            e.preventDefault();
            if (!active && items.length > 0) {
                items[0].classList.add('active');
                items[0].style.background = '#e9ecef';
            } else if (active) {
                var next = active.nextElementSibling;
                if (next && next.classList.contains('live-search-item')) {
                    active.classList.remove('active'); active.style.background = '';
                    next.classList.add('active'); next.style.background = '#e9ecef';
                    next.scrollIntoView({ block: 'nearest' });
                }
            }
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            if (active) {
                var prev = active.previousElementSibling;
                if (prev && prev.classList.contains('live-search-item')) {
                    active.classList.remove('active'); active.style.background = '';
                    prev.classList.add('active'); prev.style.background = '#e9ecef';
                    prev.scrollIntoView({ block: 'nearest' });
                }
            }
        } else if (e.key === 'Enter') {
            e.preventDefault();
            if (active) window.location.href = active.href;
        } else if (e.key === 'Escape') {
            liveSearchResults.classList.remove('show');
        }
    });
</script>
@endsection
