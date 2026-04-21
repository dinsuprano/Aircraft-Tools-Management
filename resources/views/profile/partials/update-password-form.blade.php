<form method="post" action="{{ route('password.update') }}">
    @csrf
    @method('put')

    <div class="form-group">
        <label for="update_password_current_password">{{ __('Current Password') }}</label>
        <input type="password" class="form-control @error('current_password', 'updatePassword') is-invalid @enderror" id="update_password_current_password" name="current_password" autocomplete="current-password">
        @error('current_password', 'updatePassword')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group">
        <label for="update_password_password">{{ __('New Password') }}</label>
        <input type="password" class="form-control @error('password', 'updatePassword') is-invalid @enderror" id="update_password_password" name="password" autocomplete="new-password">
        @error('password', 'updatePassword')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group">
        <label for="update_password_password_confirmation">{{ __('Confirm Password') }}</label>
        <input type="password" class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror" id="update_password_password_confirmation" name="password_confirmation" autocomplete="new-password">
        @error('password_confirmation', 'updatePassword')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group mb-0 mt-4">
        <button type="submit" class="btn btn-warning">{{ __('Update Password') }}</button>

        @if (session('status') === 'password-updated')
            <span class="text-success ml-3 font-weight-bold"><i class="fas fa-check-circle"></i> {{ __('Password updated successfully.') }}</span>
        @endif
    </div>
</form>
