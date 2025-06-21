@extends('user.layouts.master')

@section('content')
    <!-- Fruits Shop Start-->
    <div class="container-fluid fruite py-5 mt-5">
        <!-- Alert Message for entering to admin side through uri (user don't have access to admin side) -->
        @if (session('error'))
            <div class="container mt-3">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif
        <div class="container py-5">
            <div class="tab-class text-center">
                <div class="row g-4">
                    <div class="col-lg-4 text-start">
                        <h1>Our Products</h1>
                    </div>
                    <div class="col-lg-8 text-end">
                        <ul class="nav nav-pills d-inline-flex text-center mb-5">
                            <li class="nav-item d-flex">
                                <a class="d-flex m-2 py-2 bg-light rounded-pill nav-link  @if (!request('categoryId')) active @endif"
                                    href="{{ url('user/home') }}">
                                    All Products
                                </a>
                                @foreach ($categories as $category)
                                    <a class="d-flex m-2 py-2 bg-light rounded-pill nav-link @if (request('categoryId') == $category->id) active @endif"
                                        href="{{ url('user/home?categoryId=' . $category->id) }}">
                                        {{ $category->name }}
                                    </a>
                                @endforeach
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="tab-content">
                    <div id="tab-1" class="tab-pane fade show active">
                        <div class="row g-4">
                            <div class="col-3">
                                <div class="form">
                                    <form action="{{ route('user.homePage') }}" method="get">
                                        @csrf
                                        <div class="input-group">
                                            <input type="text" name="searchKey" value="{{ request('searchKey') }}"
                                                class="form-control" placeholder="Enter Search Key...">
                                            <button type="submit" class="btn btn-outline-primary"> <i
                                                    class="fa-solid fa-magnifying-glass"></i> </button>
                                        </div>
                                    </form>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-12">
                                        <form action="{{ route('user.homePage') }}" method="get">
                                            @csrf
                                            <input type="text" name="minPrice" value="{{ request('minPrice') }}"
                                                placeholder="Minimum Price..." class="form-control my-2">
                                            <input type="text" name="maxPrice" value="{{ request('maxPrice') }}"
                                                placeholder="Maximun Price..." class="form-control my-2">
                                            <input type="submit" value="Search" class="btn btn-success my-2 w-100">
                                        </form>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <form action="{{ route('user.homePage') }}" method="get">
                                            <select name="sortingType" class="form-control w-100 bg-white mt-3">
                                                <option value="">Sort By</option>
                                                <option value="asc" @if (request('sortingType') == 'asc') selected @endif>
                                                    Price: Low to High</option>
                                                <option value="desc" @if (request('sortingType') == 'desc') selected @endif>
                                                    Price: High to Low</option>
                                                <option value="nameAsc" @if (request('sortingType') == 'nameAsc') selected @endif>
                                                    Name: A to Z</option>
                                                <option value="nameDesc" @if (request('sortingType') == 'nameDesc') selected @endif>
                                                    Name: Z to A</option>
                                                <option value="dateAsc" @if (request('sortingType') == 'dateAsc') selected @endif>
                                                    Date: Oldest to Newest</option>
                                                <option value="dateDesc" @if (request('sortingType') == 'dateDesc') selected @endif>
                                                    Date: Newest to Oldest</option>
                                            </select>
                                            <input type="submit" value="Sort" class="btn btn-success my-3 w-100">
                                        </form>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <a href="{{ route('user.homePage') }}" type="button"
                                        class="btn btn-danger text-white w-100">Clear
                                        Filter</a>
                                </div>
                            </div>


                            @if (count($products) != 0)
                                @foreach ($products as $product)
                                    <div class="col-3">
                                        <div class="rounded position-relative fruite-item">
                                            <div class="fruite-img">
                                                <a href="{{ route('user.productDetails', $product->id) }}"><img
                                                        src="{{ asset('admin/products/' . $product->image) }}"
                                                        style="height: 200px" class="img-fluid w-100 rounded-top"
                                                        alt=""></a>
                                            </div>
                                            <div class="text-white bg-secondary px-3 py-1 rounded position-absolute"
                                                style="top: 10px; left: 10px;">{{ $product->category_name }}</div>
                                            <div class="p-3 border border-secondary border-top-0 rounded-bottom">
                                                <h5 class="text-start">{{ $product->name }}</h5>
                                                <p class="fs-6 text-start">
                                                    {{ Str::words($product->description, 10, '...') }}
                                                </p>

                                                <p class="text-dark fs-6 fw-bold mb-1 text-start">{{ $product->price }} mmk
                                                </p>
                                                <div class="text-start">
                                                    <form action="{{ route('user.cartStore') }}" method="post">
                                                        @csrf
                                                        <input type="hidden" name="productId" value="{{ $product->id }}">
                                                        <input type="hidden" name="userId"
                                                            value="{{ Auth::user()->id }}">
                                                        <input type="hidden" name="count" value="1">

                                                        <button type="submit"
                                                            class="btn border border-secondary rounded-pill px-3 mt-2 fs-6 text-primary"><i
                                                                class="fa fa-shopping-bag me-2 text-primary"></i> Add to
                                                            cart</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="col-9 text-center">
                                    <h3 class="text-muted">There is no products!</h3>
                                </div>
                            @endif


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Fruits Shop End-->
@endsection
