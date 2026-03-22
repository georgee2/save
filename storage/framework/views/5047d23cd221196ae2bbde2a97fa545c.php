<?php $__env->startSection('content'); ?>

<h1 style="margin:0 0 8px;font-size:22px;font-weight:700;color:#333333;">
    <?php echo e($recipientName ? 'Hi ' . $recipientName . '!' : 'Hi there!'); ?>

</h1>
<p style="margin:0 0 16px;font-size:14px;color:#666666;line-height:1.6;">
    Here are your favourite items from Smart Vision Engineering Consultant. We've put together this list so you can easily revisit them.
</p>

<?php if(isset($favouriteId) && $favouriteId): ?>
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:24px;">
    <tr>
        <td style="padding:12px 16px;background-color:#f0fafa;border-radius:8px;border-left:4px solid #19868b;">
            <span style="font-size:11px;color:#888;text-transform:uppercase;letter-spacing:0.5px;">Reference ID</span><br>
            <span style="font-size:18px;font-weight:700;color:#19868b;letter-spacing:1.5px;font-family:monospace;"><?php echo e($favouriteId); ?></span>
        </td>
    </tr>
</table>
<?php endif; ?>


<?php if($grouped['projects']->count() > 0): ?>
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:20px;">
    <tr>
        <td style="padding:8px 12px;background-color:#e8f5e9;border-radius:6px;font-size:13px;font-weight:700;color:#2e7d32;text-transform:uppercase;letter-spacing:0.3px;">
            Projects (<?php echo e($grouped['projects']->count()); ?>)
        </td>
    </tr>
</table>
<?php $__currentLoopData = $grouped['projects']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fav): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php
    $project = $fav->itemData;
    $projectImg = storage_path('app/public' . $project->main_image);
?>
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:12px;border:1px solid #eee;border-radius:8px;overflow:hidden;">
    <tr>
        <td width="120" style="vertical-align:top;">
            <?php if(file_exists($projectImg)): ?>
            <img src="<?php echo e($message->embed($projectImg)); ?>" alt="<?php echo e($project->title_english); ?>" width="120" style="display:block;width:120px;height:80px;object-fit:cover;">
            <?php else: ?>
            <img src="<?php echo e(url('/storage' . $project->main_image)); ?>" alt="<?php echo e($project->title_english); ?>" width="120" style="display:block;width:120px;height:80px;object-fit:cover;">
            <?php endif; ?>
        </td>
        <td style="vertical-align:top;padding:10px 14px;">
            <a href="<?php echo e(route('projects.show', $project->slug)); ?>" target="_blank" style="display:block;font-size:14px;font-weight:600;color:#333;text-decoration:none;margin-bottom:4px;">
                <?php echo e($project->title_english); ?>

            </a>
            <?php if($project->category): ?>
            <span style="font-size:11px;color:#888;"><?php echo e($project->category->title_english); ?></span>
            <?php endif; ?>
            <?php if($project->emirate): ?>
            <span style="font-size:11px;color:#888;margin-left:8px;"><?php echo e($project->emirate->title_english); ?></span>
            <?php endif; ?>
        </td>
    </tr>
</table>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>


<?php if($grouped['offers']->count() > 0): ?>
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:20px;">
    <tr>
        <td style="padding:8px 12px;background-color:#fff3e0;border-radius:6px;font-size:13px;font-weight:700;color:#e65100;text-transform:uppercase;letter-spacing:0.3px;">
            Offers (<?php echo e($grouped['offers']->count()); ?>)
        </td>
    </tr>
</table>
<?php $__currentLoopData = $grouped['offers']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fav): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php
    $offer = $fav->itemData;
    $offerImg = storage_path('app/public' . $offer->main_image);
?>
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:12px;border:1px solid #eee;border-radius:8px;overflow:hidden;">
    <tr>
        <td width="120" style="vertical-align:top;">
            <?php if(file_exists($offerImg)): ?>
            <img src="<?php echo e($message->embed($offerImg)); ?>" alt="<?php echo e($offer->title_english); ?>" width="120" style="display:block;width:120px;height:80px;object-fit:cover;">
            <?php else: ?>
            <img src="<?php echo e(url('/storage' . $offer->main_image)); ?>" alt="<?php echo e($offer->title_english); ?>" width="120" style="display:block;width:120px;height:80px;object-fit:cover;">
            <?php endif; ?>
        </td>
        <td style="vertical-align:top;padding:10px 14px;">
            <a href="<?php echo e(route('offers.show', $offer->slug)); ?>" target="_blank" style="display:block;font-size:14px;font-weight:600;color:#333;text-decoration:none;margin-bottom:4px;">
                <?php echo e($offer->title_english); ?>

            </a>
            <?php if($offer->category): ?>
            <span style="font-size:11px;color:#888;"><?php echo e($offer->category->title_english); ?></span>
            <?php endif; ?>
            <?php if($fav->price): ?>
            <span style="display:block;font-size:14px;font-weight:700;color:#19868b;margin-top:2px;">
                <?php echo e(number_format($fav->price)); ?> <?php echo e($offer->currency ? $offer->currency->code : 'AED'); ?>

            </span>
            <?php endif; ?>
        </td>
    </tr>
</table>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>


<?php if($grouped['interiors']->count() > 0): ?>
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:20px;">
    <tr>
        <td style="padding:8px 12px;background-color:#e3f2fd;border-radius:6px;font-size:13px;font-weight:700;color:#1565c0;text-transform:uppercase;letter-spacing:0.3px;">
            Interior Designs (<?php echo e($grouped['interiors']->count()); ?>)
        </td>
    </tr>
</table>
<?php $__currentLoopData = $grouped['interiors']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fav): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php
    $interior = $fav->itemData;
    $interiorImg = storage_path('app/public' . $interior->image);
?>
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:12px;border:1px solid #eee;border-radius:8px;overflow:hidden;">
    <tr>
        <td width="120" style="vertical-align:top;">
            <?php if(file_exists($interiorImg)): ?>
            <img src="<?php echo e($message->embed($interiorImg)); ?>" alt="<?php echo e($interior->title_english); ?>" width="120" style="display:block;width:120px;height:80px;object-fit:cover;">
            <?php else: ?>
            <img src="<?php echo e(url('/storage' . $interior->image)); ?>" alt="<?php echo e($interior->title_english); ?>" width="120" style="display:block;width:120px;height:80px;object-fit:cover;">
            <?php endif; ?>
        </td>
        <td style="vertical-align:top;padding:10px 14px;">
            <span style="display:block;font-size:14px;font-weight:600;color:#333;margin-bottom:4px;">
                <?php echo e($interior->title_english); ?>

            </span>
            <?php if($interior->category): ?>
            <span style="font-size:11px;color:#888;"><?php echo e($interior->category->title_english); ?></span>
            <?php endif; ?>
            <?php if($interior->projectStyle): ?>
            <span style="font-size:11px;color:#888;margin-left:8px;"><?php echo e($interior->projectStyle->title_english); ?></span>
            <?php endif; ?>
        </td>
    </tr>
</table>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>


<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-top:24px;margin-bottom:24px;">
    <tr>
        <td style="padding:14px 16px;background-color:#fff8e1;border-radius:8px;border-left:4px solid #f9a825;">
            <span style="font-size:13px;color:#795548;line-height:1.5;">
                &#9200; <strong>Please note:</strong> Your favourites list will reset after 30 days. Contact our sales team before then to save your selections permanently.
            </span>
        </td>
    </tr>
</table>


<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-top:28px;">
    <tr>
        <td align="center">
            <table role="presentation" cellpadding="0" cellspacing="0">
                <tr>
                    <td style="padding-right:8px;">
                        <a href="<?php echo e($shareUrl); ?>" target="_blank" style="display:inline-block;padding:12px 24px;background-color:#19868b;color:#ffffff;text-decoration:none;border-radius:8px;font-size:13px;font-weight:600;">
                            View All Favourites
                        </a>
                    </td>
                    <td style="padding-left:8px;">
                        <a href="<?php echo e(url('/')); ?>" target="_blank" style="display:inline-block;padding:12px 24px;background-color:#ffffff;color:#19868b;text-decoration:none;border-radius:8px;font-size:13px;font-weight:600;border:2px solid #19868b;">
                            Visit Our Website
                        </a>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('emails.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\smartvisionuae\resources\views/emails/favourites.blade.php ENDPATH**/ ?>