@extends('admin.layouts.master')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="">
            <div class="row">
                <div class="col-8 offset-2">

                    <div class="card">
                        <div class="card-body shadow">
                            <form action="{{ route('admin.passwordChangeStore') }}" method="post" class="p-3 rounded">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Old Password</label>
                                    <div class="d-flex align-items-start">
                                        <div class="w-100">
                                            <input type="password" name="oldPassword" id="oldPassword"
                                                class="form-control @error('oldPassword') is-invalid @enderror"
                                                placeholder="Enter Your Password...">
                                            @error('oldPassword')
                                                <small class="invalid-feedback">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <button type="button" class="btn btn-outline-secondary ms-2 toggle-password"
                                            data-target="oldPassword">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">New Password</label>
                                    <div class="d-flex align-items-start">
                                        <div class="w-100">
                                            <input type="password" name="newPassword" id="newPassword"
                                                class="form-control @error('newPassword') is-invalid @enderror"
                                                placeholder="Enter New Password...">
                                            @error('newPassword')
                                                <small class="invalid-feedback">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <button type="button" class="btn btn-outline-secondary ms-2 toggle-password"
                                            data-target="newPassword">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Confirm Password</label>
                                    <div class="d-flex align-items-start">
                                        <div class="w-100">
                                            <input type="password" name="confirmPassword" id="confirmPassword"
                                                class="form-control @error('confirmPassword') is-invalid @enderror"
                                                placeholder="Confirm Your New Password...">
                                            @error('confirmPassword')
                                                <small class="invalid-feedback">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <button type="button" class="btn btn-outline-secondary ms-2 toggle-password"
                                            data-target="confirmPassword">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>


                                <div class="">
                                    <input type="submit" value="Change" class="btn bg-primary text-white">
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
        document.addEventListener('DOMContentLoaded', function() {
            const toggleButtons = document.querySelectorAll('.toggle-password');

            toggleButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const targetId = this.getAttribute('data-target');
                    const passwordInput = document.getElementById(targetId);
                    const icon = this.querySelector('i');

                    if (passwordInput.type === 'password') {
                        passwordInput.type = 'text';
                        icon.classList.remove('fa-eye');
                        icon.classList.add('fa-eye-slash');
                    } else {
                        passwordInput.type = 'password';
                        icon.classList.remove('fa-eye-slash');
                        icon.classList.add('fa-eye');
                    }
                });
            });
        });
    </script>
@endsection
