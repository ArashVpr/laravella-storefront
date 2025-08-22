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
                            <div class="demo-credential-tag mb-small">
                                <span class="demo-label">Demo Email:</span>
                                <span class="demo-value">hanna.keeling@example.org</span>
                            </div>
                        </div>
                        <div class="form-group @error('password') has-error @enderror">
                            <input type="password" placeholder="Your Password" name="password" />
                            <div class="error-message">
                                {{ $errors->first('password') }}
                            </div>
                            <div class="demo-credential-tag mb-small">
                                <span class="demo-label">Demo Password:</span>
                                <span class="demo-value">password</span>
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
                    <img src="/img/car-png-39071.png" alt="Orange Range Rover SUV" class="img-responsive" />
                </div>
            </div>
        </div>
    </main>
    <style>
        .demo-credential-tag {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: #f3f4f6;
            border-radius: 6px;
            padding: 0.25rem 0.75rem;
            font-size: 0.95rem;
            color: #374151;
            margin-top: 0.25rem;
        }

        .demo-label {
            font-weight: 600;
            color: #6c6c6c;
        }

        .demo-value {
            font-family: monospace;
            background: #eaeaea;
            padding: 0.15rem 0.5rem;
            border-radius: 4px;
            color: #333;
        }
    </style>
</x-base>
