@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <!-- Alert Message to click the order_code to see order details! -->
        <div class="alert alert-warning alert-dismissible fade show w-50" role="alert">
            <strong><i class="fa-solid fa-triangle-exclamation"></i> Click the order_code to see order details.!</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class=" d-flex justify-content-between my-2">
            <div class="row">
                <button class=" btn btn-secondary rounded shadow-sm"> <i class="fa-solid fa-database"></i>
                    Order Count ( {{ $totalOrders }} ) </button>
                <a href="{{ route('admin.orderList') }}" class="mx-3 btn btn-outline-primary  rounded shadow-sm">All
                    Orders</a>

                <div class="text-dark">
                    <select name="filter" id="filter" class="form-control">
                        <option value="">Filter</option>
                        <option value="0" {{ request('filter') == '0' ? 'selected' : '' }}>Pending</option>
                        <option value="1" {{ request('filter') == '1' ? 'selected' : '' }}>Delivered</option>
                        <option value="2" {{ request('filter') == '2' ? 'selected' : '' }}>Rejected</option>

                    </select>
                </div>


            </div>
            <div class="">
                <form action="{{ route('admin.orderList') }}" method="get">
                    @csrf
                    <div class="input-group">
                        <input type="text" name="searchKey" value="{{ request('searchKey') }}" class=" form-control"
                            placeholder="Enter Search Key...">
                        <button type="submit" class=" btn bg-dark text-white"> <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <table class="table table-hover shadow-sm ">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>Date</th>
                            <th>Order Code</th>
                            <th>Customer Name</th>
                            <th>Order Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($orders as $order)
                            <tr>
                                <td class="text-dark">{{ $order->created_at->format('j-F-Y') }}</td>
                                <td><a href="{{ route('admin.orderDetails', ['orderCode' => $order->order_code]) }}"
                                        class="text-primary"><strong>{{ $order->order_code }}</strong></a>
                                </td>
                                <td class="text-dark">
                                    {{ $order->user_name != null ? $order->user_name : $order->user_nickname }}</td>
                                <td class="text-dark" style="width: 15%">
                                    <select name="status" class="form-control text-dark status-select"
                                        data-order-code="{{ $order->order_code }}">
                                        <option value="0" {{ $order->order_status == 0 ? 'selected' : '' }}
                                            class="text-dark">
                                            Pending
                                        </option>

                                        @if ($order->count <= $order->product_stock)
                                            <option value="1" {{ $order->order_status == 1 ? 'selected' : '' }}
                                                class="text-dark">
                                                Delivered
                                            </option>
                                        @endif

                                        <option value="2" {{ $order->order_status == 2 ? 'selected' : '' }}
                                            class="text-dark">
                                            Rejected
                                        </option>
                                    </select>
                                </td>
                                @if ($order->order_status == 0)
                                    <td>
                                        <i
                                            class="fa-solid fa-spinner text-white btn-warning rounded-circle p-2 shadow-sm"></i>
                                    </td>
                                @elseif ($order->order_status == 1)
                                    <td>
                                        <i
                                            class="fa-solid fa-circle-check text-white btn-success rounded-circle p-2 shadow-sm"></i>
                                    </td>
                                @else
                                    <td>
                                        <i
                                            class="fa-solid fa-circle-xmark text-white btn-danger rounded-circle p-2 shadow-sm"></i>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                        @if (count($orders) == 0)
                            <tr>
                                <td colspan="7">
                                    <h5 class="text-muted text-center">There is no order.</h5>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                <span class="d-fles justify-content-end">{{ $orders->links() }}</span>


            </div>
        </div>
    </div>
@endsection
@section('js-script')
    <script>
        document.getElementById('filter').addEventListener('change', function() {
            const selected = this.value;
            let url = "{{ route('admin.orderList') }}";
            if (selected !== '') {
                url += '?filter=' + selected;
            }
            window.location.href = url;
        });

        // AJAX for updating order status
        $(document).ready(function() {
            $('.status-select').on('change', function() {
                const orderCode = $(this).data('order-code');
                const newStatus = $(this).val();


                $.ajax({
                    url: '/admin/order/statusupdate',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        order_code: orderCode,
                        status: newStatus
                    },
                    success: function(response) {
                        if (response.success) {
                            window.location.reload();
                        } else {
                            alert(response.message || 'Status update failed.');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', error);
                        alert('Something went wrong. Please try again.');
                    }
                });

            });
        });
    </script>
@endsection
