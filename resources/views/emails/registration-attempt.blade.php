@extends('emails.layouts.master')

@section('content')
<h1 style="margin:0 0 8px;font-size:22px;font-weight:700;color:#333333;">
    {{ $recipientName ? 'Hi ' . $recipientName . '!' : 'Hi there!' }}
</h1>

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:24px;">
    <tr>
        <td style="font-size:14px;color:#555555;line-height:1.8;">
            Someone just tried to create a Smart Vision account with this email address, but
            you already have one. We have not created a second account and nothing has changed.
        </td>
    </tr>
</table>

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:24px;">
    <tr>
        <td style="font-size:14px;color:#555555;line-height:1.8;">
            <strong>If this was you</strong> and you were trying to get back in, sign in below,
            or reset your password if you have forgotten it.
        </td>
    </tr>
</table>

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:24px;">
    <tr>
        <td align="center">
            <a href="{{ $loginUrl }}" target="_blank" style="display:inline-block;padding:14px 32px;background-color:#19868b;color:#ffffff;text-decoration:none;border-radius:8px;font-size:15px;font-weight:600;">
                Sign in
            </a>
        </td>
    </tr>
</table>

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:8px;">
    <tr>
        <td align="center" style="font-size:13px;color:#888888;line-height:1.6;">
            Forgotten your password?
            <a href="{{ $resetUrl }}" target="_blank" style="color:#19868b;">Reset it here</a>.
        </td>
    </tr>
</table>

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-top:20px;">
    <tr>
        <td style="font-size:12px;color:#999999;line-height:1.6;">
            If this was not you, you can safely ignore this email - no account was created and
            no changes were made.
        </td>
    </tr>
</table>
@endsection
