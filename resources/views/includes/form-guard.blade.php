{{-- Bot guard fields for public forms. Include this inside every <form> that accepts
     anonymous input, directly after @csrf. Checked server-side by App\Support\FormGuard. --}}
<input type="hidden" name="{{ \App\Support\FormGuard::TIMESTAMP }}" value="{{ \App\Support\FormGuard::signature() }}">
<div style="position:absolute;left:-9999px;opacity:0;height:0;width:0;overflow:hidden;" aria-hidden="true">
    <input type="text" name="{{ \App\Support\FormGuard::HONEYPOT }}" tabindex="-1" autocomplete="off" value="">
</div>
