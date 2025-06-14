@extends('user.layouts.master')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid mt-5 pt-5">


        <!-- DataTales Example -->
        <div class="card shadow mb-4 col mt-5">
            <div class="card-header py-3">
                <div class="">
                    <div class="">
                        <h6 class="m-0 font-weight-bold text-primary">My Profile
                        </h6>
                    </div>
                </div>
            </div>
            <form action="{{ route('user.profileEditStore') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-3">

                            <img class="img-profile img-thumbnail mb-3" id="output"
                                src="{{ asset(Auth::user()->profile !== null ? 'user/profileImages/' . Auth::user()->profile : 'user/img/avatar.jpg') }}">


                            <input type="file" accept="image/*" name="image" id="" class="form-control mt-1 "
                                onchange="loadFile(event)">

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
                                            class="form-control @error('nickname')
                                            is-invalid
                                        @enderror""
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
                                        <input type="email" name="email"
                                            class="form-control
                                        @error('email')
                                            is-invalid
                                        @enderror""
                                            value="{{ old('email', Auth::user()->email) }}"
                                            placeholder="xxxxxxxx@gmail.com">
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
                                            class="form-control
                                        @error('phone')
                                            is-invalid
                                        @enderror""
                                            value="{{ old('phone', Auth::user()->phone) }}" placeholder="09xxxxxxxxx">
                                        @error('phone')
                                            <small class="invalid-feedback">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">
                                            Address</label>
                                        <input type="text" name="address"
                                            class="form-control
                                        @error('address')
                                            is-invalid
                                        @enderror""
                                            value="{{ old('address', Auth::user()->address) }}"
                                            placeholder="Enter your address...">
                                        @error('address')
                                            <small class="invalid-feedback">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <input type="submit" value="Update" class="btn btn-primary mt-3">
                            <a href="{{ route('user.homePage') }}" class="btn btn-danger mt-3">Back</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>

    </div>
    <!-- /.container-fluid -->
@endsection
