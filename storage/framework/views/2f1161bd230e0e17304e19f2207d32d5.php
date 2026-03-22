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
        .badge-primary { background: #4e73df; }
        .badge-warning { background: #f6c23e; color: #333; }
        .badge-success { background: #1cc88a; }
        .text-muted { color: #999; }
        .footer {
            margin-top: 15px;
            text-align: center;
            font-size: 9px;
            color: #999;
            padding: 10px 25px;
            border-top: 1px solid #e9ecef;
        }
        .rtl { direction: rtl; text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Favourites Report</h1>
        <p>Smart Vision Engineering Consultant (SVEC) &mdash; Generated: <?php echo e(now()->format('M d, Y - h:i A')); ?></p>
    </div>

    <?php if(!empty($activeFilters)): ?>
    <div class="filters-bar">
        <strong>Filters:</strong> <?php echo e(implode(' | ', $activeFilters)); ?>

    </div>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th style="width: 8%;">Ref ID</th>
                <th style="width: 12%;">Name</th>
                <th style="width: 14%;">Email</th>
                <th style="width: 10%;">Mobile</th>
                <th style="width: 8%;">Types</th>
                <th style="width: 14%;">Project Codes</th>
                <th style="width: 14%;">Offer Codes</th>
                <th style="width: 8%;">Interior IDs</th>
                <th style="width: 12%;">Sales Agent</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td><strong><?php echo e($row['ref_id']); ?></strong></td>
                <td><?php echo e($row['name'] ?: '---'); ?></td>
                <td><?php echo e($row['email'] ?: '---'); ?></td>
                <td><?php echo e($row['mobile'] ?: '---'); ?></td>
                <td>
                    <?php $__currentLoopData = explode(', ', $row['types']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(trim($type) === 'Project'): ?>
                            <span class="badge badge-primary">Project</span>
                        <?php elseif(trim($type) === 'Offer'): ?>
                            <span class="badge badge-warning">Offer</span>
                        <?php elseif(trim($type) === 'Interior'): ?>
                            <span class="badge badge-success">Interior</span>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </td>
                <td><?php echo e($row['project_codes'] ?: '---'); ?></td>
                <td><?php echo e($row['offer_codes'] ?: '---'); ?></td>
                <td><?php echo e($row['interior_ids'] ?: '---'); ?></td>
                <td><?php echo e($row['agent'] ?: '---'); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="9" style="text-align: center; padding: 20px; color: #999;">No records found.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="footer">
        &copy; <?php echo e(date('Y')); ?> Smart Vision Engineering Consultant (SVEC). Total Records: <?php echo e(count($rows)); ?>

    </div>
</body>
</html>
<?php /**PATH C:\wamp64\www\smartvisionuae\resources\views/exports/favourites-report-pdf.blade.php ENDPATH**/ ?>