@extends('emails.layouts.master')

@section('content')
<h1 style="margin:0 0 8px;font-size:22px;font-weight:700;color:#333333;">
    {{ $recipientName ? 'Hi ' . $recipientName . '!' : 'Hi there!' }}
</h1>

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:24px;">
    <tr>
        <td style="font-size:14px;color:#555555;line-height:1.8;">
            Welcome to Smart Vision Engineering Consultant (SVEC). Your account has been created.
            Please set your password to activate your account and access your customer portal.
        </td>
    </tr>
</table>

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:24px;">
    <tr>
        <td align="center">
            <a href="{{ $actionUrl }}" target="_blank" style="display:inline-block;padding:14px 32px;background-color:#19868b;color:#ffffff;text-decoration:none;border-radius:8px;font-size:15px;font-weight:600;">
                Set my password
            </a>
        </td>
    </tr>
</table>

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:8px;">
    <tr>
        <td style="font-size:12px;color:#888888;line-height:1.6;">
            If the button does not work, copy and paste this link into your browser:
        </td>
    </tr>
    <tr>
        <td style="font-size:12px;color:#19868b;word-break:break-all;padding-top:6px;">
            {{ $actionUrl }}
        </td>
    </tr>
</table>

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-top:20px;">
    <tr>
        <td style="font-size:12px;color:#999999;line-height:1.6;">
            If you did not request this account, you can safely ignore this email.
        </td>
    </tr>
</table>
@endsection
