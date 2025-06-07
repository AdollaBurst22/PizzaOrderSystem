@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-6 offset-3 card p-3 shadow-sm rounded">

                <div class=" d-flex justify-content-end">
                    <a href="{{ route('superadmin.accountList', ['accountType' => 'admin']) }}"
                        class=" btn bg-danger my-2 w-50 rounded shadow-sm text-white"> <i class="fa-solid fa-users"></i> Admin
                        List</a>
                </div>

                <div class="card-title bg-dark text-white p-3 h5">New Admin Account</div>

                <form action="{{ route('superadmin.newAdminStore') }}" method="post">
                    @csrf

                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" value="{{ old('name') }}"
                                class="form-control
                            @error('name')
                                is-invalid
                            @enderror"
                                placeholder="Enter Name...">
                            @error('name')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="text" name="email" value="{{ old('email') }}"
                                class="form-control
                            @error('email')
                                is-invalid
                            @enderror"
                                placeholder="Enter Email...">
                            @error('email')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <div class="d-flex align-items-start">
                                <div class="w-100">
                                    <input type="password" name="password" id="password" value=""
                                        class="form-control @error('password')
                                        is-invalid
                                    @enderror"
                                        placeholder="Enter Password...">
                                    @error('password')
                                        <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>
                                <button type="button" class="btn btn-outline-secondary ms-2 toggle-password"
                                    data-target="password">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Confirm Password</label>
                            <div class="d-flex align-items-start">
                                <div class="w-100">
                                    <input type="password" name="confirmPassword" id="confirmPassword" value=""
                                        class="form-control @error('confirmPassword')
                                        is-invalid
                                    @enderror"
                                        placeholder="Enter Confirm Password...">
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

                        <div class="mb-3">
                            <input type="submit" value="Create Account" class=" btn btn-primary w-100 rounded shadow-sm">
                        </div>
                    </div>
                </form>


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
