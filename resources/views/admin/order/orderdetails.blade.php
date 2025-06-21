@extends('admin.layouts.master')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">


        <a href="{{ route('admin.orderList') }}" class=" text-black m-3"> <i class="fa-solid fa-arrow-left-long"></i> Back</a>

        <!-- DataTales Example -->


        <div class="row">
            <div class="card col-5 shadow-sm m-4 col">
                <div class="card-header bg-white mb-0 pb-0">
                    <h4 class="text-primary"><strong>Order Information</strong></h4>
                </div>
                <div class="card-body text-dark">

                    <div class="row mb-3">
                        <div class="col-5">Customer Name :</div>
                        <div class="col-7">{{ $order[0]['user_name'] }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5">Registered Phone :</div>
                        <div class="col-7">
                            {{ $order[0]['user_phone'] }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5">Registered Email :</div>
                        <div class="col-7">
                            {{ $order[0]['user_email'] }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5">Registered Addr :</div>
                        <div class="col-7">
                            {{ $order[0]['user_address'] }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5">Order Code :</div>
                        <div class="col-7" id="orderCode">{{ $order[0]['order_code'] }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5">Order Date :</div>
                        <div class="col-7">{{ $order[0]['created_at']->format('j-F-Y') }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5">Total Price :</div>
                        <div class="col-7">
                            {{ $payment->total_amount }} mmk<br>
                            <small class=" text-danger ms-1">( Contain Delivery Charges )</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card col-5 shadow-sm m-4 col">
                <div class="card-header bg-white mb-0 pb-0">
                    <h4 class="text-primary"><strong>Delivery Information</strong></h4>
                </div>
                <div class="card-body text-dark">
                    <div class="row mb-3">
                        <div class="col-5">Contact Phone :</div>
                        <div class="col-7">{{ $payment->phone }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5">Delivery Address :</div>
                        <div class="col-7">{{ $payment->address }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5">Payment Method :</div>
                        <div class="col-7">{{ $payment->payment_method }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5">Purchase Date :</div>
                        <div class="col-7">{{ $payment->created_at->format('j-F-Y') }}</div>
                    </div>
                    <div class="row mb-3">
                        <img style="width: 150px" src="{{ asset('payslipImages/' . $payment->payslip_image) }}"
                            class=" img-thumbnail">
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="d-flex justify-content-between">
                    <div class="">
                        <h4 class="m-0 font-weight-bold text-primary">Order Board</h4>
                    </div>
                </div>
            </div>
            <div class="card-body text-dark">
                <div class="table-responsive">
                    <table class="table table-hover shadow-sm " id="productTable">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th class="col-2">Image</th>
                                <th>Name</th>
                                <th>Order Count</th>
                                <th>Available Stock</th>
                                <th>Product Price (each)</th>
                                <th>Total Price</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($order as $item)
                                <tr class="text-dark">
                                    <input type="hidden" class="productId" value="">
                                    <input type="hidden" class="productOrderCount" value="">

                                    <td>
                                        <img src="{{ asset('admin/products/' . $item->product_image) }}"
                                            class=" w-50 img-thumbnail">
                                    </td>
                                    <td>{{ $item->product_name }}</td>
                                    <td>{{ $item->count }} @if ($item->count > $item->product_stock)
                                            <small class="text-danger">( Out Of Stock )</small>
                                        @endif
                                    </td>
                                    <td>{{ $item->product_stock }}</td>
                                    <td>{{ $item->product_price }} mmk</td>
                                    <td>{{ $item->total_price }} mmk</td>
                                </tr>
                            @endforeach


                        </tbody>

                    </table>

                </div>
            </div>
            <div class="card-footer d-flex justify-content-end">
                <div class="">
                    <button type="button" id="btn-order-confirm" class="btn btn-success rounded shadow-sm"
                        @if (!$stockStatus || $order[0]->status == 1) disabled @endif>
                        Confirm
                    </button>

                    <input type="button" id="btn-order-reject" class="btn btn-danger rounded shadow-sm" value="Reject">
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
@endsection
@section('js-script')
    <script>
        //Handle order rejection
        $(document).ready(function() {

            $('#btn-order-reject').click(function() {
                var orderCode = $('#orderCode').text();
                $.ajax({
                    url: '/admin/order/reject',
                    type: 'GET',
                    data: {
                        orderCode: orderCode
                    },
                    success: function(response) {
                        window.location.href = '/admin/order/list';
                    }
                });
            });

            //Handle order Confirmation
            $('#btn-order-confirm').click(function() {
                var orderCode = $('#orderCode').text();
                $.ajax({
                    url: '/admin/order/confirm',
                    type: 'GET',
                    data: {
                        orderCode: orderCode
                    },
                    success: function(response) {

                        if (response.success) {
                            $('#btn-order-confirm').prop('disabled',
                                true); // Disable after confirmation

                            window.location.reload();
                        } else {
                            alert('Something went wrong.');
                        }
                    }
                });
            });
        });
    </script>
@endsection
