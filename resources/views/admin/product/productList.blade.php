@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <div class=" d-flex justify-content-between my-2">
            <div class="">
                <button class=" btn btn-secondary rounded shadow-sm"> <i class="fa-solid fa-database"></i>
                    Product Count ( {{ $totalProducts }} ) </button>
                <a href="{{ route('admin.productList') }}" class=" btn btn-outline-primary  rounded shadow-sm">All
                    Products</a>
                <a href="{{ route('admin.productList', 'lowAmount') }}" class=" btn btn-outline-danger  rounded shadow-sm">Low
                    Amount Product List</a>
            </div>
            <div class="">
                <form action="{{ route('admin.productList') }}" method="get">

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
                            <th>Image</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Category</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>

                        @if (count($products) != 0)
                            @foreach ($products as $product)
                                <tr>
                                    <td> <img src="{{ asset('admin/products/' . $product->image) }}"
                                            class=" img-thumbnail rounded shadow-sm" style="width:50px;height:50px"
                                            alt="product_image">
                                    </td>
                                    <td>{{ $product->name }}</td>
                                    <td> {{ $product->price }}mmk</td>
                                    <td class="col-2">
                                        <button type="button" class="btn btn-secondary position-relative">
                                            {{ $product->stock }}

                                            @if ($product->stock == 0)
                                                <span
                                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                                    Out Of stock
                                                </span>
                                            @elseif ($product->stock <= 3)
                                                <span
                                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                                    Low amt stock
                                                </span>
                                            @endif

                                        </button>
                                    </td>
                                    <td>{{ $product->category_name }}</td>
                                    <td>

                                        <a href="{{ route('admin.productDetail', ['productId' => $product->id]) }}"
                                            class="btn btn-sm btn-outline-primary"> <i class="fa-solid fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.productUpdate', $product->id) }}"
                                            class="btn btn-sm btn-outline-secondary"> <i
                                                class="fa-solid fa-pen-to-square"></i> </a>
                                        <button type="button" onclick="deleteProduct({{ $product->id }})"
                                            class="btn btn-sm btn-outline-danger"> <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </td>

                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7">
                                    <h5 class="text-muted text-center">There is no products</h5>
                                </td>
                            </tr>
                        @endif

                    </tbody>
                </table>
                <span class="d-fles justify-content-end">{{ $products->links() }}</span>


            </div>
        </div>
    </div>
@endsection

@section('js-script')
    <script>
        function deleteProduct($productId) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Deleted!",
                        text: "Your file has been deleted.",
                        icon: "success"
                    });
                    setInterval(() => {
                        location.href = '/admin/product/delete/' + $productId
                    }, 1000);
                }
            });
        }
    </script>
@endsection
