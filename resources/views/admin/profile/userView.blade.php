@extends('admin.layouts.master')

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="card shadow-sm rounded">
                    <div class="card-header-custom bg-light">
                        <a href="{{ route('superadmin.accountList', ['accountType' => 'user']) }}"
                            class="btn btn-secondary btn-sm me-5">
                            <i class="fas fa-arrow-left me-1"></i> Back
                        </a>
                        <h4 class="mb-0 px-5">Admin Account Details</h4>
                    </div>
                    <div class="card-body p-4">
                        <div class="product-image-container">

                            <img class="product-image" id="output"
                                src="{{ $account->profile != null && file_exists(public_path('admin/profileImages/' . $account->profile)) ? asset('admin/profileImages/' . $account->profile) : asset('admin/profileImages/no image.webp') }}"
                                alt="Profile Image" />
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-4 detail-label">Name:</div>
                            <div class="col-md-8 detail-value">{{ $account->name != null ? $account->name : '-' }}</div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-4 detail-label">Nickname:</div>
                            <div class="col-md-8 detail-value">
                                {{ $account->nickname != null ? $account->nickname : '-' }}
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-4 detail-label">Email:</div>
                            <div class="col-md-8 detail-value">
                                {{ $account->email != null ? $account->email : '-' }}
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-4 detail-label">Address:</div>
                            <div class="col-md-8 detail-value">
                                {{ $account->address != null ? $account->address : '-' }}
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-4 detail-label">Phone:</div>
                            <div class="col-md-8 detail-value">
                                {{ $account->phone != null ? $account->phone : '-' }}
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-4 detail-label">Role:</div>
                            <div class="col-md-8 detail-value">
                                {{ $account->role != null ? $account->role : '-' }}
                            </div>
                        </div>
                        <div class="mb-2 pt-3">
                            <p class="detail-label">This Account is created at
                                {{ $account->created_at->format('h:i A, d F Y') }}.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
