<div class="grid grid-cols-2 gap-1 social-auth-buttons">
    <a href="{{ route('login.oauth', 'google') }}" class="btn btn-default flex justify-center items-center gap-1">
        <img src="/img/google.png" alt="Google logo" style="width: 20px" />
        Google
    </a>
    <a href="{{ route('login.oauth', 'facebook') }}" class="btn btn-default flex justify-center items-center gap-1">
        <img src="/img/facebook.png" alt="Facebook logo" style="width: 20px" />
        Facebook
    </a>
</div>
