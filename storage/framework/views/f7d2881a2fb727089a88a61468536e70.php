<?php $__env->startSection('content'); ?>

<h1 style="margin:0 0 8px;font-size:22px;font-weight:700;color:#333333;">
    <?php echo e($recipientName ? 'Hi ' . $recipientName . '!' : 'Hi there!'); ?>

</h1>


<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:28px;">
    <tr>
        <td style="font-size:14px;color:#555555;line-height:1.8;">
            <?php echo nl2br(e($emailBody)); ?>

        </td>
    </tr>
</table>


<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:28px;">
    <tr>
        <td style="border-top:2px solid #f0f0f0;"></td>
    </tr>
</table>


<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:24px;">
    <tr>
        <td style="padding:20px;background-color:#f0fafa;border-radius:12px;border:1px solid #e0f0f0;">
            <h3 style="margin:0 0 16px;font-size:16px;font-weight:700;color:#19868b;text-transform:uppercase;letter-spacing:0.5px;">
                &#128222; Get in Touch
            </h3>

            
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:12px;">
                <tr>
                    <td width="36" style="vertical-align:top;">
                        <div style="width:32px;height:32px;background-color:#19868b;border-radius:8px;text-align:center;line-height:32px;">
                            <span style="color:#ffffff;font-size:14px;">&#9993;</span>
                        </div>
                    </td>
                    <td style="vertical-align:middle;padding-left:12px;">
                        <span style="font-size:11px;color:#888;text-transform:uppercase;letter-spacing:0.5px;font-weight:600;">Email Us</span><br>
                        <a href="mailto:care@svec.ae" style="font-size:14px;color:#19868b;text-decoration:none;font-weight:600;">care@svec.ae</a>
                    </td>
                </tr>
            </table>

            
            <?php if($contactInfo->mobile): ?>
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:12px;">
                <tr>
                    <td width="36" style="vertical-align:top;">
                        <div style="width:32px;height:32px;background-color:#19868b;border-radius:8px;text-align:center;line-height:32px;">
                            <span style="color:#ffffff;font-size:14px;">&#128222;</span>
                        </div>
                    </td>
                    <td style="vertical-align:middle;padding-left:12px;">
                        <span style="font-size:11px;color:#888;text-transform:uppercase;letter-spacing:0.5px;font-weight:600;">Call Us</span><br>
                        <a href="tel:<?php echo e($contactInfo->mobile); ?>" style="font-size:14px;color:#333;text-decoration:none;font-weight:600;"><?php echo e($contactInfo->mobile); ?></a>
                    </td>
                </tr>
            </table>
            <?php endif; ?>

            
            <?php if($contactInfo->whatsapp): ?>
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td width="36" style="vertical-align:top;">
                        <div style="width:32px;height:32px;background-color:#25d366;border-radius:8px;text-align:center;line-height:32px;">
                            <span style="color:#ffffff;font-size:14px;">&#9742;</span>
                        </div>
                    </td>
                    <td style="vertical-align:middle;padding-left:12px;">
                        <span style="font-size:11px;color:#888;text-transform:uppercase;letter-spacing:0.5px;font-weight:600;">WhatsApp</span><br>
                        <a href="https://wa.me/<?php echo e(preg_replace('/[^0-9]/', '', $contactInfo->whatsapp)); ?>" target="_blank" style="font-size:14px;color:#25d366;text-decoration:none;font-weight:600;">Contact us on WhatsApp</a>
                    </td>
                </tr>
            </table>
            <?php endif; ?>
        </td>
    </tr>
</table>


<?php if(isset($branches) && $branches->count() > 0): ?>
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:24px;">
    <tr>
        <td>
            <h3 style="margin:0 0 16px;font-size:16px;font-weight:700;color:#19868b;text-transform:uppercase;letter-spacing:0.5px;">
                &#127970; Our Branches
            </h3>
        </td>
    </tr>
</table>

<?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:12px;">
    <tr>
        <td style="padding:14px 16px;background-color:#f8f9fc;border-radius:10px;border:1px solid #e8ecf1;border-left:4px solid #19868b;">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td>
                        <span style="font-size:14px;font-weight:700;color:#1a1a2e;display:block;margin-bottom:4px;">
                            <?php echo e($branch->name_english); ?>

                        </span>
                        <?php if($branch->location_text_english): ?>
                        <span style="font-size:13px;color:#666;line-height:1.5;">
                            &#128205; <?php echo e($branch->location_text_english); ?>

                        </span>
                        <?php endif; ?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>


<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-top:28px;">
    <tr>
        <td align="center">
            <table role="presentation" cellpadding="0" cellspacing="0">
                <tr>
                    <?php if($contactInfo->whatsapp): ?>
                    <td style="padding-right:8px;">
                        <a href="https://wa.me/<?php echo e(preg_replace('/[^0-9]/', '', $contactInfo->whatsapp)); ?>" target="_blank" style="display:inline-block;padding:12px 24px;background-color:#25d366;color:#ffffff;text-decoration:none;border-radius:8px;font-size:13px;font-weight:600;">
                            &#9742; WhatsApp Us
                        </a>
                    </td>
                    <?php endif; ?>
                    <td style="padding-left:8px;">
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

<?php echo $__env->make('emails.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\smartvisionuae\resources\views/emails/contact-confirmation.blade.php ENDPATH**/ ?>