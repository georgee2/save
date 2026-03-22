<?php $__env->startSection('content'); ?>

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:24px;">
    <tr>
        <td style="padding:16px 20px;background-color:#f0fafa;border-radius:8px;border-left:4px solid #19868b;">
            <span style="font-size:11px;color:#888;text-transform:uppercase;letter-spacing:0.5px;font-weight:600;">Subject</span><br>
            <span style="font-size:17px;font-weight:700;color:#19868b;"><?php echo e($emailSubject); ?></span>
        </td>
    </tr>
</table>


<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:24px;">
    <tr>
        <td style="font-size:14px;color:#333333;line-height:1.8;"><?php echo nl2br(e($emailBody)); ?></td>
    </tr>
</table>


<?php if(isset($attachmentNames) && count($attachmentNames) > 0): ?>
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:24px;">
    <tr>
        <td style="padding:14px 16px;background-color:#f8f9fc;border-radius:8px;border:1px solid #e3e6f0;">
            <span style="font-size:12px;font-weight:700;color:#5a5c69;text-transform:uppercase;letter-spacing:0.5px;display:block;margin-bottom:10px;">
                &#128206; Attachments (<?php echo e(count($attachmentNames)); ?>)
            </span>
            <?php $__currentLoopData = $attachmentNames; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:6px;">
                <tr>
                    <td style="padding:8px 12px;background-color:#ffffff;border-radius:6px;border:1px solid #e3e6f0;font-size:13px;color:#4a5568;">
                        &#128196; <?php echo e($name); ?>

                    </td>
                </tr>
            </table>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </td>
    </tr>
</table>
<?php endif; ?>


<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-top:28px;">
    <tr>
        <td align="center">
            <table role="presentation" cellpadding="0" cellspacing="0">
                <tr>
                    <td style="padding-right:8px;">
                        <a href="<?php echo e(url('/')); ?>" target="_blank" style="display:inline-block;padding:12px 24px;background-color:#19868b;color:#ffffff;text-decoration:none;border-radius:8px;font-size:13px;font-weight:600;">
                            Visit Our Website
                        </a>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('emails.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\smartvisionuae\resources\views/emails/favourites-direct.blade.php ENDPATH**/ ?>