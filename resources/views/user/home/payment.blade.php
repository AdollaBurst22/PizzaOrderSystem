@extends('user.layouts.master')

@section('content')
    <div class="container " style="margin-top: 150px">
        <div class="row">
            <div class="card col-12 shadow-sm">
                <div class="card-body">
                    <div class="row">
                        <div class="col-5">
                            <h5 class="mb-4">Payment methods</h5>

                            @foreach ($paymentMethods as $paymentMethod)
                                <div class="">
                                    <b>Account Name : <span class="ps-3">{{ $paymentMethod->account_name }}</span></b>

                                    <p class="p-0 m-0">Account Number : <span
                                            class="ps-3">{{ $paymentMethod->account_number }}</span></p>

                                    <p class="p-0 m-0">Account Type : <span
                                            class="ps-3">{{ $paymentMethod->account_type }}</span></p>
                                </div>
                                <hr>
                            @endforeach


                        </div>
                        <div class="col">
                            <div class="card shadow-sm">
                                <div class="card-header">
                                    Payment Info
                                </div>
                                <div class="card-body">
                                    <div class="">

                                        <form action="{{ route('user.paymentStore') }}" method="post"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="row mt-4">
                                                <div class="col">
                                                    <input type="text" name="name" id="" readonly
                                                        value="{{ Auth::user()->name }}" class="form-control disabled"
                                                        placeholder="{{ Auth::user()->name }}">
                                                </div>
                                                <div class="col">
                                                    <input type="text" name="phone" id=""
                                                        value="{{ old('phone') }}"
                                                        class="form-control @error('phone')
                                                            is-invalid
                                                        @enderror"
                                                        placeholder="09xxxxxxxx">
                                                    @error('phone')
                                                        <small class="invalid-feedback">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col">
                                                    <input type="text" name="address" id=""
                                                        value="{{ old('address') }}"
                                                        class="form-control @error('address')
                                                            is-invalid
                                                        @enderror"
                                                        placeholder="Address...">
                                                    @error('address')
                                                        <small class="invalid-feedback">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row mt-4">
                                                <div class="col">
                                                    <select name="paymentType" id=""
                                                        class=" form-select @error('paymentType')
                                                            is-invalid
                                                        @enderror">
                                                        <option value="">Choose Payment methods...</option>
                                                        @foreach ($paymentMethods as $paymentMethod)
                                                            <option value="{{ $paymentMethod->account_type }}"
                                                                @selected(old('paymentType') == $paymentMethod->account_type)>
                                                                {{ $paymentMethod->account_type }}</option>
                                                        @endforeach

                                                    </select>
                                                    @error('accountType')
                                                        <small class="invalid-feedback">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col">
                                                    <input type="file" name="payslipImage" id=""
                                                        class="form-control @error('payslipImage')
                                                            is-invalid
                                                        @enderror">
                                                    @error('payslipImage')
                                                        <small class="invalid-feedback">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row mt-4">
                                                <div class="col">
                                                    <input type="hidden" name="orderCode"
                                                        value="{{ $order[0]['orderCode'] }}">
                                                    Order Code : <span
                                                        class="text-success fw-bold">{{ $order[0]['orderCode'] }}</span>
                                                </div>
                                                <div class="col">
                                                    <input type="hidden" name="totalAmount"
                                                        value="{{ $order[0]['finalTotal'] }}">
                                                    Total amt : <span class="text-success fw-bold">
                                                        {{ $order[0]['finalTotal'] }} mmk</span>
                                                </div>
                                            </div>

                                            <div class="row mt-4 mx-2">
                                                <button type="submit" class="btn btn-outline-success w-100"><i
                                                        class="fa-solid fa-cart-shopping me-3"></i> Order
                                                    Now...</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
