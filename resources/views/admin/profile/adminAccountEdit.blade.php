@extends('admin.layouts.master')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">


        <!-- DataTales Example -->
        <div class="card shadow mb-4 col">
            <div class="card-header py-3">
                <div class="">
                    <div class="d-flex justify-content-between">

                        <h6 class="m-0 font-weight-bold text-primary">
                            {{ $admin->name != null ? ($admin->nickname != null ? $admin->name . ' (' . $admin->nickname . ')' : $admin->name) : $admin->nickname }}
                            =><span class="text-danger"> {{ $admin->role }}</span>
                        </h6>
                        <a href="{{ route('superadmin.adminList') }}" class="btn btn-secondary btn-sm me-5">
                            <i class="fas fa-arrow-left me-1"></i> Back
                        </a>
                    </div>
                </div>
            </div>
            <form action="{{ route('superadmin.adminAccountUpdateStore', $admin->id) }}" method="post"
                enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-3">

                            <img class="img-profile img-thumbnail" id="output"
                                src="{{ asset($admin->profile != null ? 'admin/profileImages/' . $admin->profile : 'admin/profileImages/no image.webp') }}">

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
                                            placeholder="Name..." value="{{ old('name', $admin->name) }}">
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
                                            value="{{ old('nickname', $admin->nickname) }}" placeholder="Nickname...">
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
                                            value="{{ old('email', $admin->email) }}" placeholder="xxxxxx@gmail.com">
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
                                            value="{{ old('phone', $admin->phone) }}" placeholder="Phone Number">
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
                                    value="{{ old('address', $admin->address) }}"
                                    placeholder="No.xx, xxx Street, xxx Ward, xxxx Township ">
                                @error('address')
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
