@extends('admin.layouts.master')

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="card shadow-sm rounded">
                    <div class="card-header-custom bg-light">
                        <a href="{{ route('superadmin.adminList') }}" class="btn btn-secondary btn-sm me-5">
                            <i class="fas fa-arrow-left me-1"></i> Back
                        </a>
                        <h4 class="mb-0 px-5">Admin Account Details</h4>
                    </div>
                    <div class="card-body p-4">
                        <div class="product-image-container">

                            <img class="product-image" id="output"
                                src="{{ asset($admin->profile != null ? 'admin/profileImages/' . $admin->profile : 'admin/profileImages/no image.webp') }}"
                                alt="Profile Image" />
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-4 detail-label">Name:</div>
                            <div class="col-md-8 detail-value">{{ $admin->name != null ? $admin->name : '-' }}</div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-4 detail-label">Nickname:</div>
                            <div class="col-md-8 detail-value">
                                {{ $admin->nickname != null ? $admin->nickname : '-' }}
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-4 detail-label">Email:</div>
                            <div class="col-md-8 detail-value">
                                {{ $admin->email != null ? $admin->email : '-' }}
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-4 detail-label">Address:</div>
                            <div class="col-md-8 detail-value">
                                {{ $admin->address != null ? $admin->address : '-' }}
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-4 detail-label">Phone:</div>
                            <div class="col-md-8 detail-value">
                                {{ $admin->phone != null ? $admin->phone : '-' }}
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-4 detail-label">Role:</div>
                            <div class="col-md-8 detail-value">
                                {{ $admin->role != null ? $admin->role : '-' }}
                            </div>
                        </div>
                        <div class="mb-2 pt-3">
                            <p class="detail-label">This Account is created at
                                {{ $admin->created_at->format('h:i A, d F Y') }}.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
