<x-base title="Login" bodyClass="page-login">
    <main>
        <div class="container-small page-login">
            <div class="flex" style="gap: 5rem">
                <div class="auth-page-form">
                    <x-logo-image />
                    <h1 class="auth-page-title">Login</h1>
                    
                    {{ session('error') }}

                    <form action="{{ route('login.store') }}" method="POST">
                        @csrf
                        <div class="form-group @error('email') has-error @enderror">
                            <input type="email" placeholder="Your Email" name="email" value="{{ old('name') }}" />
                            <div class="error-message">
                                {{ $errors->first('email') }}
                            </div>
                        </div>
                        <div class="form-group @error('password') has-error @enderror">
                            <input type="password" placeholder="Your Password" name="password" />
                            <div class="error-message">
                                {{ $errors->first('password') }}
                            </div>
                        </div>
                        <div class="text-right mb-medium">
                            <a href="{{ route('password.forgot') }}" class="auth-page-password-reset">Forgot Password
                                ?</a>
                        </div>

                        <button class="btn btn-primary btn-login w-full">Login</button>
                        <x-login-with />
                        <div class="login-text-dont-have-account">
                            Don't have an account? -
                            <a href="/signup"> Click here to create one</a>
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
