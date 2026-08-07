@extends('emails.layouts.master')

@section('content')
<h1 style="margin:0 0 8px;font-size:22px;font-weight:700;color:#333333;">
    {{ $recipientName ? 'Hi ' . $recipientName . '!' : 'Hi there!' }}
</h1>

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:24px;">
    <tr>
        <td style="font-size:14px;color:#555555;line-height:1.8;">
            Someone asked to change the email address on your Smart Vision account to
            <strong>{{ $newEmail }}</strong>. We have sent a confirmation link to that address.
            Until it is confirmed, this address stays in control of the account.
        </td>
    </tr>
</table>

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:24px;">
    <tr>
        <td style="font-size:14px;color:#555555;line-height:1.8;">
            <strong>If this was you</strong>, no action is needed here - just confirm from the
            new address.
        </td>
    </tr>
</table>

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-top:20px;">
    <tr>
        <td style="font-size:13px;color:#a94442;line-height:1.6;background-color:#fdf3f2;padding:14px;border-radius:6px;">
            <strong>If this was not you</strong>, someone may have access to your account.
            Change your password immediately - that cancels this pending change and signs out
            every other device - and contact us at care@svec.ae.
        </td>
    </tr>
</table>
@endsection
