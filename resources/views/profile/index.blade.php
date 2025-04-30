<x-app>
    <main>
        <div class="container-small">

            @session('success')
                <div class="container my-large">
                    <div class="success-message">
                        {{ session('success') }}
                    </div>
                </div>
            @endsession

            <h1 class="car-details-page-title">My Profile</h1>
            <form action="{{ route('profile.update') }}" method="POST" class="card p-large my-large">
                @csrf
                @method('PUT')

                <div class="form-group @error('name') has-error @enderror">
                    <label>Name</label>
                    <input type="text" name="name" placeholder="Your Name" value="{{ old('name', $user->name) }}">
                    <p class="error-message">
                        {{ $errors->first('name') }}
                    </p>
                </div>
                <div class="form-group @error('email') has-error @enderror">
                    <label>Email</label>
                    <input type="email" name="email" placeholder="Your Email"
                        value="{{ old('email', $user->email) }}" @disabled($user->isOauthUser())>
                    <p class="error-message">
                        {{ $errors->first('email') }}
                    </p>
                </div>
                <div class="form-group @error('phone') has-error @enderror">
                    <label>Phone</label>
                    <input type="number" name="phone" placeholder="Your Phone"
                        value="{{ old('phone', $user->phone) }}">
                    <p class="error-message">
                        {{ $errors->first('phone') }}
                    </p>
                </div>

                <div class="p-medium">
                    <div class="flex justify-end gap-1">
                        <button type="reset" class="btn btn-default">Reset</button>
                        <button class="btn btn-primary">Update</button>
                    </div>
                </div>
            </form>
            <form action="{{ route('profile.updatePassword') }}" method="POST" class="card p-large my-large">
                @csrf
                @method('PUT')

                <div class="form-group @error('current_password') has-error @enderror">
                    <label>Current Password</label>
                    <input type="password" name="current_password" placeholder="Current Password">
                    <p class="error-message">
                        {{ $errors->first('current_password') }}
                    </p>
                </div>
                <div class="form-group @error('password') has-error @enderror">
                    <label>New Password</label>
                    <input type="password" name="password" placeholder="New Password">
                    <p class="error-message">
                        {{ $errors->first('password') }}
                    </p>
                </div>
                <div class="form-group">
                    <label>Repeat Password</label>
                    <input type="password" name="password_confirmation" placeholder="Repeat Password">
                </div>

                <div class="p-medium">
                    <div class="flex justify-end gap-1">
                        <button class="btn btn-primary">Update Password</button>
                    </div>
                </div>
            </form>
        </div>
    </main>
</x-app>
