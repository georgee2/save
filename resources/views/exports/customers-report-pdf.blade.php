<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: 'XB Riyaz', 'DejaVu Sans', sans-serif;
            font-size: 10px;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .header {
            background: #19868b;
            color: #fff;
            padding: 20px 25px;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 20px;
            font-weight: 700;
        }
        .header p {
            margin: 5px 0 0;
            font-size: 11px;
            opacity: 0.85;
        }
        .filters-bar {
            background: #f0fafa;
            border-left: 4px solid #19868b;
            padding: 8px 15px;
            margin: 0 25px 15px;
            font-size: 10px;
            color: #555;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 0 auto;
            font-size: 9px;
        }
        th {
            background: #19868b;
            color: #fff;
            padding: 8px 6px;
            text-align: left;
            font-weight: 700;
            font-size: 9px;
            border: 1px solid #0d6b6f;
        }
        td {
            padding: 6px;
            border: 1px solid #dee2e6;
            vertical-align: top;
        }
        tr:nth-child(even) td {
            background: #f8f9fc;
        }
        .badge {
            display: inline-block;
            padding: 1px 5px;
            border-radius: 3px;
            font-size: 8px;
            font-weight: 600;
            color: #fff;
        }
        .badge-success { background: #1cc88a; }
        .badge-warning { background: #f6c23e; color: #333; }
        .text-muted { color: #999; }
        .footer {
            margin-top: 15px;
            text-align: center;
            font-size: 9px;
            color: #999;
            padding: 10px 25px;
            border-top: 1px solid #e9ecef;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Customers Report</h1>
        <p>Smart Vision Engineering Consultant (SVEC) &mdash; Generated: {{ now()->format('M d, Y - h:i A') }}</p>
    </div>

    @if(!empty($activeFilters))
    <div class="filters-bar">
        <strong>Filters:</strong> {{ implode(' | ', $activeFilters) }}
    </div>
    @endif

    <table>
        <thead>
            <tr>
                <th style="width: 16%;">Name</th>
                <th style="width: 20%;">Email</th>
                <th style="width: 12%;">Phone</th>
                <th style="width: 10%;">Status</th>
                <th style="width: 8%;">Verified</th>
                <th style="width: 16%;">Assigned Agent</th>
                <th style="width: 8%;">ERP ID</th>
                <th style="width: 10%;">Registered</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rows as $row)
            <tr>
                <td>{{ $row['name'] ?: '---' }}</td>
                <td>{{ $row['email'] ?: '---' }}</td>
                <td>{{ $row['phone'] ?: '---' }}</td>
                <td>
                    @if($row['status'] === 'Activated')
                        <span class="badge badge-success">Activated</span>
                    @else
                        <span class="badge badge-warning">Pending</span>
                    @endif
                </td>
                <td>{{ $row['verified'] }}</td>
                <td>{{ $row['agent'] ?: '---' }}</td>
                <td>{{ $row['erp_id'] ?: '---' }}</td>
                <td>{{ $row['created'] ?: '---' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align: center; padding: 20px; color: #999;">No records found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        &copy; {{ date('Y') }} Smart Vision Engineering Consultant (SVEC). Total Records: {{ count($rows) }}
    </div>
</body>
</html>
