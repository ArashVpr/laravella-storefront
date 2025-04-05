@extends('layouts.base', ['cssClass' => 'page-login'])

@section('title', 'Login')

@section('childContent')
<main>
    <div class="container-small page-login">
      <div class="flex" style="gap: 5rem">
        <div class="auth-page-form">
          <x-logo-image />

          <h1 class="auth-page-title">Login</h1>

          <form action="" method="post">
            <div class="form-group">
              <input type="email" placeholder="Your Email" />
            </div>
            <div class="form-group">
              <input type="password" placeholder="Your Password" />
            </div>
            <div class="text-right mb-medium">
              <a href="/password-reset.html" class="auth-page-password-reset"
                >Reset Password</a
              >
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
@endsection
