@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <!-- Alert Message to click the order_code to see order details! -->
        <div class="alert alert-warning alert-dismissible fade show w-50" role="alert">
            <strong><i class="fa-solid fa-triangle-exclamation"></i> Click the order_code to see sale details.!</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class=" d-flex justify-content-between my-2">
            <div class="row">
                <button class=" btn btn-secondary rounded shadow-sm"> <i class="fa-solid fa-database"></i>
                    Sale Count ( {{ $totalSales }} ) </button>
                <a href="{{ route('admin.saleList') }}" class="mx-3 btn btn-outline-primary  rounded shadow-sm">All
                    Sales</a>


            </div>
            <div class="">
                <form action="{{ route('admin.saleList') }}" method="get">
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
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($sales as $sale)
                            <tr>
                                <td class="text-dark">
                                    {{ $sale->created_at->format('j-F-Y') }}
                                </td>
                                <td><a href="{{ route('admin.saleDetails', ['orderCode' => $sale->order_code]) }}"
                                        class="text-primary"><strong>{{ $sale->order_code }}</strong></a>
                                </td>
                                <td class="text-dark">
                                    {{ $sale->user_name != null ? $sale->user_name : $sale->user_nickname }}
                                </td>
                                <td class="text-dark">Delivered <i
                                        class="fa-solid fa-circle-check text-white btn-success rounded-circle m-2 p-2 shadow-sm"></i>
                                </td>

                            </tr>
                        @endforeach
                        @if (count($sales) == 0)
                            <tr>
                                <td colspan="7">
                                    <h5 class="text-muted text-center">There is no sale.</h5>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                <span class="d-fles justify-content-end">{{ $sales->links() }}</span>


            </div>
        </div>
    </div>
@endsection
