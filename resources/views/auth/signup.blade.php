<x-base title="Signup" bodyClass="page-signup">
    <main>
        <div class="container-small page-login">
            <div class="flex" style="gap: 5rem">
                <div class="auth-page-form">
                    <x-logo-image />
                    <h1 class="auth-page-title">Signup</h1>

                    <form action="" method="post">
                        <div class="form-group">
                            <input type="email" placeholder="Your Email" />
                        </div>
                        <div class="form-group">
                            <input type="password" placeholder="Your Password" />
                        </div>
                        <div class="form-group">
                            <input type="password" placeholder="Repeat Password" />
                        </div>
                        <hr />
                        <div class="form-group">
                            <input type="text" placeholder="First Name" />
                        </div>
                        <div class="form-group">
                            <input type="text" placeholder="Last Name" />
                        </div>
                        <div class="form-group">
                            <input type="text" placeholder="Phone" />
                        </div>
                        <button class="btn btn-primary btn-login w-full">Register</button>

                        <x-login-with />
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
