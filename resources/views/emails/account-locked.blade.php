@extends('emails.layouts.master')

@section('content')
<h1 style="margin:0 0 8px;font-size:22px;font-weight:700;color:#333333;">
    {{ $recipientName ? 'Hi ' . $recipientName . '!' : 'Hi there!' }}
</h1>

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:24px;">
    <tr>
        <td style="font-size:14px;color:#555555;line-height:1.8;">
            There have been a lot of failed sign-in attempts on your account, so we have locked
            it for {{ $minutes }} minutes as a precaution. You do not need to do anything - it
            will unlock on its own.
        </td>
    </tr>
</table>

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:24px;">
    <tr>
        <td style="font-size:14px;color:#555555;line-height:1.8;">
            <strong>If this was you</strong> and you have simply forgotten your password, you can
            reset it once the lock expires.
        </td>
    </tr>
</table>

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:24px;">
    <tr>
        <td align="center">
            <a href="{{ $resetUrl }}" target="_blank" style="display:inline-block;padding:14px 32px;background-color:#19868b;color:#ffffff;text-decoration:none;border-radius:8px;font-size:15px;font-weight:600;">
                Reset my password
            </a>
        </td>
    </tr>
</table>

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-top:20px;">
    <tr>
        <td style="font-size:12px;color:#999999;line-height:1.6;">
            <strong>If this was not you</strong>, someone may be trying to guess your password.
            Your account is safe - they did not get in - but we recommend changing your password
            to something you have not used anywhere else once the lock expires.
        </td>
    </tr>
</table>
@endsection
