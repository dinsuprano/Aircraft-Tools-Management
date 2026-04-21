<p class="text-muted">
    {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
</p>

<!-- Button trigger modal -->
<button type="button" class="btn btn-danger mt-2" data-toggle="modal" data-target="#deleteAccountModal">
  {{ __('Delete Account') }}
</button>

<!-- Modal -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1" role="dialog" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-danger">
        <h5 class="modal-title" id="deleteAccountModalLabel">{{ __('Are you sure you want to delete your account?') }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="text-white">&times;</span>
        </button>
      </div>
      <form method="post" action="{{ route('profile.destroy') }}">
          @csrf
          @method('delete')
          <div class="modal-body">
            <p>
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>
            <div class="form-group mt-3">
                <label for="password">{{ __('Password') }}</label>
                <input type="password" class="form-control @error('password', 'userDeletion') is-invalid @enderror" id="password" name="password" placeholder="{{ __('Password') }}">
                @error('password', 'userDeletion')
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
            <button type="submit" class="btn btn-danger">{{ __('Delete Account') }}</button>
          </div>
      </form>
    </div>
  </div>
</div>

@if($errors->userDeletion->isNotEmpty())
    @section('scripts')
    <script>
        $(document).ready(function() {
            $('#deleteAccountModal').modal('show');
        });
    </script>
    @endsection
@endif
