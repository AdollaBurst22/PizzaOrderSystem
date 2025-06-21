@extends('user.layouts.master')

@section('content')
    <div class="container " style="margin-top: 150px">
        <div class="row">
            <table class="table table-hover shadow-sm ">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>Date</th>
                        <th>Order Code</th>
                        <th>Order Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y') }}</td>
                            <td>{{ $order->order_code }}</td>

                            @if ($order->status == 0)
                                <td>
                                    <i
                                        class="fa-solid fa-spinner text-white btn-warning rounded-circle p-2 shadow-sm"></i><span
                                        class="text-warning ms-3">Waiting</span>
                                </td>
                            @elseif ($order->status == 1)
                                <td>
                                    <i
                                        class="fa-solid fa-circle-check text-white btn-success rounded-circle p-2 shadow-sm"></i><span
                                        class="text-success ms-3">Delivered</span>
                                </td>
                            @else
                                <td>
                                    <i
                                        class="fa-solid fa-circle-xmark text-white btn-danger rounded-circle p-2 shadow-sm"></i><span
                                        class="text-danger ms-3">Rejected</span>
                                </td>
                            @endif
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
@endsection
