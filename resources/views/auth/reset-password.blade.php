<x-base title="Reset Password" bodyClass="page-login">
    <main>
        <div class="container-small page-login">
            <div class="flex" style="gap: 5rem">
                <div class="auth-page-form">
                    <x-logo-image />

                    {{-- @session('success')
                        <div class="my-large">
                            <div class="success-message">
                                {{ session('success') }}
                            </div>
                        </div>
                    @endsession --}}
                    <div> {{ $errors->first('token') }}</div>
                    <h1 class="auth-page-title">Reset Your Password</h1>

                    <form action="{{ route('password.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="token" value="{{ request('token') }}" />

                        <div class="form-group @error('email') has-error @enderror">
                            <input type="email" placeholder="Your Email" name="email" value="{{ request('email') }}"
                                readonly />
                        </div>
                        <div class="form-group @error('password') has-error @enderror">
                            <input type="password" placeholder="New Password" name="password" />
                            <div class="error-message">
                                {{ $errors->first('password') }}
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="password" placeholder="Confirm New Password" name="password_confirmation" />
                        </div>
                        <button class="btn btn-primary btn-login w-full">Reset Password</button>
                    </form>
                </div>
                <div class="auth-page-image">
                    <img src="/img/car-png-39071.png" alt="" class="img-responsive" />
                </div>
            </div>
        </div>
    </main>
</x-base>
