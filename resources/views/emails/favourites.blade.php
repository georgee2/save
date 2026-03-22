@extends('emails.layouts.master')

@section('content')
{{-- Greeting --}}
<h1 style="margin:0 0 8px;font-size:22px;font-weight:700;color:#333333;">
    {{ $recipientName ? 'Hi ' . $recipientName . '!' : 'Hi there!' }}
</h1>
<p style="margin:0 0 16px;font-size:14px;color:#666666;line-height:1.6;">
    Here are your favourite items from Smart Vision Engineering Consultant. We've put together this list so you can easily revisit them.
</p>

@if(isset($favouriteId) && $favouriteId)
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:24px;">
    <tr>
        <td style="padding:12px 16px;background-color:#f0fafa;border-radius:8px;border-left:4px solid #19868b;">
            <span style="font-size:11px;color:#888;text-transform:uppercase;letter-spacing:0.5px;">Reference ID</span><br>
            <span style="font-size:18px;font-weight:700;color:#19868b;letter-spacing:1.5px;font-family:monospace;">{{ $favouriteId }}</span>
        </td>
    </tr>
</table>
@endif

{{-- Projects --}}
@if($grouped['projects']->count() > 0)
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:20px;">
    <tr>
        <td style="padding:8px 12px;background-color:#e8f5e9;border-radius:6px;font-size:13px;font-weight:700;color:#2e7d32;text-transform:uppercase;letter-spacing:0.3px;">
            Projects ({{ $grouped['projects']->count() }})
        </td>
    </tr>
</table>
@foreach($grouped['projects'] as $fav)
@php
    $project = $fav->itemData;
    $projectImg = storage_path('app/public' . $project->main_image);
@endphp
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:12px;border:1px solid #eee;border-radius:8px;overflow:hidden;">
    <tr>
        <td width="120" style="vertical-align:top;">
            @if(file_exists($projectImg))
            <img src="{{ $message->embed($projectImg) }}" alt="{{ $project->title_english }}" width="120" style="display:block;width:120px;height:80px;object-fit:cover;">
            @else
            <img src="{{ url('/storage' . $project->main_image) }}" alt="{{ $project->title_english }}" width="120" style="display:block;width:120px;height:80px;object-fit:cover;">
            @endif
        </td>
        <td style="vertical-align:top;padding:10px 14px;">
            <a href="{{ route('projects.show', $project->slug) }}" target="_blank" style="display:block;font-size:14px;font-weight:600;color:#333;text-decoration:none;margin-bottom:4px;">
                {{ $project->title_english }}
            </a>
            @if($project->category)
            <span style="font-size:11px;color:#888;">{{ $project->category->title_english }}</span>
            @endif
            @if($project->emirate)
            <span style="font-size:11px;color:#888;margin-left:8px;">{{ $project->emirate->title_english }}</span>
            @endif
        </td>
    </tr>
</table>
@endforeach
@endif

{{-- Offers --}}
@if($grouped['offers']->count() > 0)
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:20px;">
    <tr>
        <td style="padding:8px 12px;background-color:#fff3e0;border-radius:6px;font-size:13px;font-weight:700;color:#e65100;text-transform:uppercase;letter-spacing:0.3px;">
            Offers ({{ $grouped['offers']->count() }})
        </td>
    </tr>
</table>
@foreach($grouped['offers'] as $fav)
@php
    $offer = $fav->itemData;
    $offerImg = storage_path('app/public' . $offer->main_image);
@endphp
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:12px;border:1px solid #eee;border-radius:8px;overflow:hidden;">
    <tr>
        <td width="120" style="vertical-align:top;">
            @if(file_exists($offerImg))
            <img src="{{ $message->embed($offerImg) }}" alt="{{ $offer->title_english }}" width="120" style="display:block;width:120px;height:80px;object-fit:cover;">
            @else
            <img src="{{ url('/storage' . $offer->main_image) }}" alt="{{ $offer->title_english }}" width="120" style="display:block;width:120px;height:80px;object-fit:cover;">
            @endif
        </td>
        <td style="vertical-align:top;padding:10px 14px;">
            <a href="{{ route('offers.show', $offer->slug) }}" target="_blank" style="display:block;font-size:14px;font-weight:600;color:#333;text-decoration:none;margin-bottom:4px;">
                {{ $offer->title_english }}
            </a>
            @if($offer->category)
            <span style="font-size:11px;color:#888;">{{ $offer->category->title_english }}</span>
            @endif
            @if($fav->price)
            <span style="display:block;font-size:14px;font-weight:700;color:#19868b;margin-top:2px;">
                {{ number_format($fav->price) }} {{ $offer->currency ? $offer->currency->code : 'AED' }}
            </span>
            @endif
        </td>
    </tr>
</table>
@endforeach
@endif

{{-- Interior Designs --}}
@if($grouped['interiors']->count() > 0)
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:20px;">
    <tr>
        <td style="padding:8px 12px;background-color:#e3f2fd;border-radius:6px;font-size:13px;font-weight:700;color:#1565c0;text-transform:uppercase;letter-spacing:0.3px;">
            Interior Designs ({{ $grouped['interiors']->count() }})
        </td>
    </tr>
</table>
@foreach($grouped['interiors'] as $fav)
@php
    $interior = $fav->itemData;
    $interiorImg = storage_path('app/public' . $interior->image);
@endphp
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:12px;border:1px solid #eee;border-radius:8px;overflow:hidden;">
    <tr>
        <td width="120" style="vertical-align:top;">
            @if(file_exists($interiorImg))
            <img src="{{ $message->embed($interiorImg) }}" alt="{{ $interior->title_english }}" width="120" style="display:block;width:120px;height:80px;object-fit:cover;">
            @else
            <img src="{{ url('/storage' . $interior->image) }}" alt="{{ $interior->title_english }}" width="120" style="display:block;width:120px;height:80px;object-fit:cover;">
            @endif
        </td>
        <td style="vertical-align:top;padding:10px 14px;">
            <span style="display:block;font-size:14px;font-weight:600;color:#333;margin-bottom:4px;">
                {{ $interior->title_english }}
            </span>
            @if($interior->category)
            <span style="font-size:11px;color:#888;">{{ $interior->category->title_english }}</span>
            @endif
            @if($interior->projectStyle)
            <span style="font-size:11px;color:#888;margin-left:8px;">{{ $interior->projectStyle->title_english }}</span>
            @endif
        </td>
    </tr>
</table>
@endforeach
@endif

{{-- Expiry Notice --}}
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-top:24px;margin-bottom:24px;">
    <tr>
        <td style="padding:14px 16px;background-color:#fff8e1;border-radius:8px;border-left:4px solid #f9a825;">
            <span style="font-size:13px;color:#795548;line-height:1.5;">
                &#9200; <strong>Please note:</strong> Your favourites list will reset after 30 days. Contact our sales team before then to save your selections permanently.
            </span>
        </td>
    </tr>
</table>

{{-- Action Buttons --}}
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-top:28px;">
    <tr>
        <td align="center">
            <table role="presentation" cellpadding="0" cellspacing="0">
                <tr>
                    <td style="padding-right:8px;">
                        <a href="{{ $shareUrl }}" target="_blank" style="display:inline-block;padding:12px 24px;background-color:#19868b;color:#ffffff;text-decoration:none;border-radius:8px;font-size:13px;font-weight:600;">
                            View All Favourites
                        </a>
                    </td>
                    <td style="padding-left:8px;">
                        <a href="{{ url('/') }}" target="_blank" style="display:inline-block;padding:12px 24px;background-color:#ffffff;color:#19868b;text-decoration:none;border-radius:8px;font-size:13px;font-weight:600;border:2px solid #19868b;">
                            Visit Our Website
                        </a>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
@endsection
