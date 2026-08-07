{{-- Single hidden POST form backing every logout link. Included once per page; the links
     themselves submit it. Logout is a state change, so it must not be reachable by GET. --}}
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
    @csrf
</form>
