@extends('admin.layouts.master')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-center mb-4">
            <h1 class="h3 mb-0 text-gray-800">Update Payment Method</h1>
        </div>

        <div class="">
            <div class="col-6 offset-3">
                <div class="card">
                    <div class="card-body shadow">
                        <form action="{{ route('superadmin.paymentMethodUpdateStore') }}" method="post" class="p-3 rounded">
                            @csrf

                            <input type="text" name="accountName" value="{{ old('accountName', $method->account_name) }}"
                                class=" form-control @error('accountName') is-invalid @enderror mt-3"
                                placeholder="Account Name...">
                            @error('accountName')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror

                            <input type="text" name="accountType" value="{{ old('accountType', $method->account_type) }}"
                                class=" form-control @error('accountType') is-invalid @enderror mt-3"
                                placeholder="Account Type...">
                            @error('accountType')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror

                            <input type="text" name="accountNumber"
                                value="{{ old('accountNumber', $method->account_number) }}"
                                class=" form-control @error('accountNumber') is-invalid @enderror mt-3"
                                placeholder="Account Number...">
                            @error('accountNumber')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror

                            <input type="hidden" name="methodId" value="{{ $method->id }}">
                            <input type="submit" value="Update" class="btn btn-outline-primary mt-3">
                            <a href="{{ route('superadmin.paymentMethodList') }}"
                                class="btn btn-outline-danger text-danger mt-3">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
