<?php $__env->startSection('content'); ?>

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:20px;">
    <tr>
        <td style="font-size:16px;color:#333;font-weight:700;">
            Dear <?php echo e($recipientName); ?>,
        </td>
    </tr>
</table>


<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:24px;">
    <tr>
        <td style="padding:12px 16px;background-color:#f0fafa;border-radius:8px;border-left:4px solid #19868b;">
            <span style="font-size:11px;color:#888;text-transform:uppercase;letter-spacing:0.5px;font-weight:600;">In reply to</span><br>
            <span style="font-size:14px;font-weight:600;color:#19868b;"><?php echo e($originalSubject); ?></span>
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


<?php if(isset($externalLinks) && count($externalLinks) > 0): ?>
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:24px;">
    <tr>
        <td style="padding:14px 16px;background-color:#f0fafa;border-radius:8px;border:1px solid #d1ecee;">
            <span style="font-size:12px;font-weight:700;color:#19868b;text-transform:uppercase;letter-spacing:0.5px;display:block;margin-bottom:10px;">
                &#128279; Useful Links
            </span>
            <?php $__currentLoopData = $externalLinks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:6px;">
                <tr>
                    <td style="padding:10px 14px;background-color:#ffffff;border-radius:6px;border:1px solid #d1ecee;">
                        <a href="<?php echo e($link['url']); ?>" target="_blank" style="color:#19868b;text-decoration:none;font-size:13px;font-weight:600;">
                            &#10148; <?php echo e($link['title'] ?: $link['url']); ?>

                        </a>
                        <?php if($link['title']): ?>
                        <div style="font-size:11px;color:#888;margin-top:2px;word-break:break-all;"><?php echo e($link['url']); ?></div>
                        <?php endif; ?>
                    </td>
                </tr>
            </table>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </td>
    </tr>
</table>
<?php endif; ?>


<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:24px;border-top:1px solid #e3e6f0;padding-top:16px;">
    <tr>
        <td style="padding-top:16px;font-size:13px;color:#666;line-height:1.6;">
            Best Regards,<br>
            <strong style="color:#19868b;">Smart Vision Engineering Consultant</strong><br>
            <span style="font-size:12px;color:#888;">&#9993; care@svec.ae</span>
        </td>
    </tr>
</table>


<table role="presentation" width="100%" cellpadding="0" cellspacing="0">
    <tr>
        <td align="center">
            <a href="<?php echo e(url('/')); ?>" target="_blank" style="display:inline-block;padding:12px 24px;background-color:#19868b;color:#ffffff;text-decoration:none;border-radius:8px;font-size:13px;font-weight:600;">
                Visit Our Website
            </a>
        </td>
    </tr>
</table>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('emails.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\smartvisionuae\resources\views/emails/contact-us-reply.blade.php ENDPATH**/ ?>