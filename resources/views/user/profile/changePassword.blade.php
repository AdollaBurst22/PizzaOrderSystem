@extends('user.layouts.master')
@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid mt-5 pt-5">

        <!-- Page Heading -->
        <div class="mt-5 mb-5">
            <div class="row">
                <div class="col-8 offset-2">

                    <div class="card">
                        <div class="card-body shadow">
                            <form action="{{ route('user.changePasswordStore') }}" method="post" class="p-3 rounded">
                                @csrf
                                <h3 class="py-2 text-primary fw-bold">Change Your Password</h3>
                                <div class="mb-3">
                                    <label class="form-label">Old Password</label>
                                    <div class="input-group">
                                        <input type="password" name="oldPassword"
                                            class="form-control @error('oldPassword')
                                            is-invalid
                                        @enderror"
                                            placeholder="Enter Old Password..." id="oldPassword">

                                        <button class="btn btn-outline-secondary" type="button"
                                            onclick="togglePassword('oldPassword')">
                                            <i class="fas fa-eye" id="oldPasswordIcon"></i>
                                        </button>
                                        @error('oldPassword')
                                            <small class="invalid-feedback">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">New Password</label>
                                    <div class="input-group">
                                        <input type="password" name="newPassword"
                                            class="form-control @error('newPassword')
                                            is-invalid
                                        @enderror"
                                            placeholder="Enter New Password..." id="newPassword">

                                        <button class="btn btn-outline-secondary" type="button"
                                            onclick="togglePassword('newPassword')">
                                            <i class="fas fa-eye" id="newPasswordIcon"></i>
                                        </button>
                                        @error('newPassword')
                                            <small class="invalid-feedback">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Confirm Password</label>
                                    <div class="input-group">
                                        <input type="password" name="confirmPassword"
                                            class="form-control @error('confirmPassword')
                                            is-invalid
                                        @enderror"
                                            placeholder="Enter Confirm Password..." id="confirmPassword">

                                        <button class="btn btn-outline-secondary" type="button"
                                            onclick="togglePassword('confirmPassword')">
                                            <i class="fas fa-eye" id="confirmPasswordIcon"></i>
                                        </button>
                                        @error('confirmPassword')
                                            <small class="invalid-feedback">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <input type="submit" value="Change" class="btn btn-primary">
                                    <a href="{{ route('user.homePage') }}" class="btn bg-dark text-primary mx-2">Back</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('js-script')
    <script>
        function togglePassword(inputId) {
            const passwordInput = document.getElementById(inputId);
            const icon = document.getElementById(inputId + 'Icon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
@endsection
