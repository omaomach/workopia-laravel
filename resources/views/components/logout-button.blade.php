<!-- People find pleasure in different ways. I find it in keeping my mind clear. - Marcus Aurelius -->
<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit" class="text-white ">
        <i class="fa fa-sign-out"></i>
        Logout
    </button>
</form>
