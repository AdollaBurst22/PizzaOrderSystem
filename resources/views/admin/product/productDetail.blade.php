@extends('admin.layouts.master')

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="card shadow-sm rounded">
                    <div class="card-header-custom bg-light">
                        <a href="{{ route('admin.productList') }}" class="btn btn-secondary btn-sm me-5">
                            <i class="fas fa-arrow-left me-1"></i> Back
                        </a>
                        <h4 class="mb-0 px-5">Product Details</h4>
                    </div>
                    <div class="card-body p-4">
                        <div class="product-image-container">

                            <img class="product-image" id="output" src="{{ asset('admin/products/' . $product->image) }}"
                                alt="Product Image" />
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-4 detail-label">Product Name:</div>
                            <div class="col-md-8 detail-value">{{ $product->name }}</div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-4 detail-label">Category Name:</div>
                            <div class="col-md-8 detail-value">
                                {{ $product->category_name }}
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-4 detail-label">Price:</div>
                            <div class="col-md-8 detail-value">
                                {{ $product->price }} MMK
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-4 detail-label">Stock:</div>
                            <div class="col-md-8 detail-value">
                                {{ $product->stock }} Units
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-4 detail-label">Description:</div>
                            <div class="col-md-8 detail-value text-muted">
                                {{ $product->description }}
                            </div>
                        </div>
                        <div class="mb-2 pt-3">
                            <p class="detail-label">This product is created at
                                {{ $product->created_at->format('h:i A, d F Y') }}.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
