@extends('admin.layouts.master')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">


        <!-- DataTales Example -->
        <div class="card shadow mb-4 col">
            <div class="card-header py-3">
                <div class="">
                    <div class="">
                        <h6 class="m-0 font-weight-bold text-primary">
                            {{ Auth::user()->name != null ? (Auth::user()->nickname != null ? Auth::user()->name . ' (' . Auth::user()->nickname . ')' : Auth::user()->name) : Auth::user()->nickname }}
                            =><span class="text-danger"> {{ Auth::user()->role }}</span>
                        </h6>
                    </div>
                </div>
            </div>
            <form action="{{ route('admin.profileUpdateStore') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-3">

                            <img class="img-profile img-thumbnail" id="output"
                                src="{{ asset(Auth::user()->profile != null ? 'admin/profileImages/' . Auth::user()->profile : 'admin/profileImages/no image.webp') }}">


                            <input type="file" accept="image/*" onchange="loadFile(event)" name="image" id=""
                                class="form-control mt-1 @error('image')
                                    is-invalid
                                @enderror">
                            @error('image')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror

                        </div>
                        <div class="col">

                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">
                                            Name</label>
                                        <input type="text" name="name"
                                            class="form-control
                                            @error('name')
                                            is-invalid
                                            @enderror"
                                            placeholder="Name..." value="{{ old('name', Auth::user()->name) }}">
                                        @error('name')
                                            <small class="invalid-feedback">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">
                                            Nickname</label>
                                        <input type="text" name="nickname"
                                            class="form-control
                                            @error('nickname')
                                            is-invalid
                                            @enderror"
                                            value="{{ old('nickname', Auth::user()->nickname) }}" placeholder="Nickname...">
                                        @error('nickname')
                                            <small class="invalid-feedback">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">
                                            Email</label>
                                        <input type="text" name="email"
                                            class="form-control @error('email')
                                    is-invalid
                                @enderror"
                                            value="{{ old('email', Auth::user()->email) }}" placeholder="xxxxxx@gmail.com">
                                        @error('email')
                                            <small class="invalid-feedback">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">
                                            Phone</label>
                                        <input type="text" name="phone"
                                            class="form-control @error('phone')
                                    is-invalid
                                @enderror"
                                            value="{{ old('phone', Auth::user()->phone) }}" placeholder="Phone Number">
                                        @error('phone')
                                            <small class="invalid-feedback">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">
                                    Address</label>
                                <input type="text" name="address"
                                    class="form-control @error('address')
                                    is-invalid
                                @enderror"
                                    value="{{ old('address', Auth::user()->address) }}"
                                    placeholder="No.xx, xxx Street, xxx Ward, xxxx Township ">
                                @error('address')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <a href="{{ route('admin.passwordChange') }}">Change Password</a>
                            </div>

                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">
                                    Password</label>
                                <div class="position-relative">
                                    <input type="password" name="password" id="password"
                                        class="form-control @error('password')
                                        is-invalid
                                    @enderror"
                                        placeholder="Enter Password...">
                                    <span class="toggle-password"
                                        style="cursor: pointer; position: absolute; right: 10px; top: 50%; transform: translateY(-50%); z-index: 10;">
                                        <i class="fas fa-eye"></i>
                                    </span>
                                </div>
                                @error('password')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">
                                    Confirm Password</label>
                                <div class="position-relative">
                                    <input type="password" name="confirmPassword" id="confirmPassword"
                                        class="form-control @error('confirmPassword')
                                        is-invalid
                                    @enderror"
                                        placeholder="Enter Confirm Password...">
                                    <span class="toggle-password"
                                        style="cursor: pointer; position: absolute; right: 10px; top: 50%; transform: translateY(-50%); z-index: 10;">
                                        <i class="fas fa-eye"></i>
                                    </span>
                                </div>
                                @error('confirmPassword')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                @enderror
                            </div>

                            <input type="submit" value="Update" class="btn btn-primary mt-3">
                        </div>
                    </div>
                </div>
            </form>
        </div>

    </div>
    <!-- /.container-fluid -->
@endsection

@section('script')
    <script>
        document.querySelectorAll('.toggle-password').forEach(function(toggle) {
            toggle.addEventListener('click', function() {
                const input = this.previousElementSibling;
                const icon = this.querySelector('i');

                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        });
    </script>
@endsection
