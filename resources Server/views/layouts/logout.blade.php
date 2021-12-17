<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
    <button type="submit" class="btn btn-danger btn-sml btn-round" href="#"><i class="pe-7s-close"></i> Logout</button>
</form>
