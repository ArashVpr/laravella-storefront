<x-base title="Forgot Password" bodyClass="page-login">
    <main>
        <div class="container-small page-login">
            <div class="flex" style="gap: 5rem">
                <div class="auth-page-form">
                    <x-logo-image />

                    @session('success')
                        <div class="my-large">
                            <div class="success-message">
                                {{ session('success') }}
                            </div>
                        </div>
                    @endsession
                    <h1 class="auth-page-title">Request password reset</h1>

                    <form action="{{ route('password.email') }}" method="POST">
                        @csrf
                        <div class="form-group @error('email') has-error @enderror">
                            <input type="email" placeholder="Your Email" name="email" value="{{ old('name') }}" />
                            <div class="error-message">
                                {{ $errors->first('email') }}
                            </div>
                        </div>
                        <button class="btn btn-primary btn-login w-full">Request password reset</button>

                        <div class="login-text-dont-have-account">
                            Already have an account? -
                            <a href="/login"> Click here to login </a>
                        </div>
                    </form>
                </div>
                <div class="auth-page-image">
                    <img src="/img/car-png-39071.png" alt="" class="img-responsive" />
                </div>
            </div>
        </div>
    </main>
</x-base>
