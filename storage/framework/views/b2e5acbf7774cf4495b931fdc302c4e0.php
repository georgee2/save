<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo e($subject ?? 'Smart Vision Engineering Consultant'); ?></title>
</head>
<body style="margin:0;padding:0;background-color:#f4f5f7;font-family:Arial,Helvetica,sans-serif;-webkit-font-smoothing:antialiased;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f5f7;">
        <tr>
            <td align="center" style="padding:24px 16px;">
                <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="max-width:600px;width:100%;background-color:#ffffff;border-radius:12px;overflow:hidden;box-shadow:0 2px 12px rgba(0,0,0,0.08);">

                    
                    <tr>
                        <td style="background:linear-gradient(135deg,#19868b 0%,#0d6b6f 100%);padding:28px 32px;text-align:center;">
                            <img src="<?php echo e($message->embed(public_path('pic/logos/logoarfooter.png'))); ?>" alt="SVEC" width="160" style="display:inline-block;max-width:160px;height:auto;margin-bottom:12px;">
                            <p style="margin:0;font-size:14px;color:rgba(255,255,255,0.9);font-weight:600;letter-spacing:0.3px;">
                                Smart Vision Engineering Consultant (SVEC)
                            </p>
                        </td>
                    </tr>

                    
                    <tr>
                        <td style="padding:32px 32px 24px;">
                            <?php echo $__env->yieldContent('content'); ?>
                        </td>
                    </tr>

                    
                    <?php if(isset($whatsapp) && $whatsapp): ?>
                    <tr>
                        <td style="padding:0 32px 24px;text-align:center;">
                            <table role="presentation" cellpadding="0" cellspacing="0" style="margin:0 auto;">
                                <tr>
                                    <td style="background-color:#25d366;border-radius:8px;">
                                        <a href="https://wa.me/<?php echo e(preg_replace('/[^0-9]/', '', $whatsapp)); ?>" target="_blank" style="display:inline-block;padding:12px 28px;color:#ffffff;text-decoration:none;font-size:14px;font-weight:600;">
                                            &#9742; Contact us on WhatsApp
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <?php endif; ?>

                    
                    <tr>
                        <td style="background-color:#19868b;padding:20px 32px;text-align:center;">
                            <p style="margin:0 0 8px;font-size:12px;color:rgba(255,255,255,0.85);">
                                &copy; <?php echo e(date('Y')); ?> Smart Vision Engineering Consultant (SVEC). All rights reserved.
                            </p>
                            <p style="margin:0;font-size:11px;color:rgba(255,255,255,0.65);">
                                <a href="<?php echo e(url('/')); ?>" target="_blank" style="color:rgba(255,255,255,0.85);text-decoration:underline;">Visit our website</a>
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
<?php /**PATH C:\wamp64\www\smartvisionuae\resources\views/emails/layouts/master.blade.php ENDPATH**/ ?>