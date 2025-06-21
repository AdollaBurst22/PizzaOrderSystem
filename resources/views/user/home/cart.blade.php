@extends('user.layouts.master')

@section('content')
    <!-- Cart Page Start -->
    <div class="container-fluid py-5 mt-5">
        <div class="container py-5">
            <div class="table-responsive">
                <table class="table" id="productTable">
                    <thead>
                        <tr>
                            <th scope="col">Products</th>
                            <th scope="col">Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Total</th>
                            <th scope="col">Handle</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cartProducts as $cartProduct)
                            <tr>
                                <th scope="row">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('admin/products/' . $cartProduct->product_image) }}"
                                            class="img-fluid me-5 rounded-circle" style="width: 80px; height: 80px;"
                                            alt="">
                                    </div>
                                </th>
                                <td>
                                    <p class="mb-0 mt-4">{{ $cartProduct->product_name }}</p>
                                </td>
                                <td>
                                    <p class="mb-0 mt-4 price">{{ $cartProduct->product_price }} mmk</p>
                                </td>
                                <td>
                                    <div class="input-group quantity mt-4" style="width: 100px;">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-minus rounded-circle bg-light border"
                                                aria-label="Decrease quantity">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                        </div>
                                        <input type="text" class="form-control qty form-control-sm text-center border-0"
                                            value="{{ $cartProduct->quantity }}" data-cart-id="{{ $cartProduct->id }}"
                                            data-product-id="{{ $cartProduct->product_id }}"
                                            data-price="{{ $cartProduct->product_price }}">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-plus rounded-circle bg-light border">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p class="mb-0 mt-4 total">
                                        {{ $cartProduct->product_price * $cartProduct->quantity }}
                                        mmk</p>
                                </td>
                                <td>
                                    <button class="btn btn-md rounded-circle bg-light border mt-4 btn-remove"
                                        data-cart-id="{{ $cartProduct->id }}" aria-label="Remove item">
                                        <i class="fa fa-times text-danger"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="row g-4 justify-content-end">
                <div class="col-8"></div>
                <div class="col-sm-8 col-md-7 col-lg-6 col-xl-4">
                    <div class="bg-light rounded">
                        <div class="p-4">
                            <h1 class="display-6 mb-4">Cart <span class="fw-normal">Total</span></h1>
                            <div class="d-flex justify-content-between mb-4">
                                <h5 class="mb-0 me-4">Subtotal:</h5>
                                <p class="mb-0" id="subtotal">mmk</p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <h5 class="mb-0 me-4">Delivery </h5>
                                <div class="">
                                    <p class="mb-0"> 5000 mmk </p>
                                </div>
                            </div>
                        </div>
                        <div class="py-4 mb-4 border-top border-bottom d-flex justify-content-between">
                            <h5 class="mb-0 ps-4 me-4">Total</h5>
                            <p class="mb-0 pe-4 " id="finalTotal"> mmk</p>
                        </div>
                        <button id="btn-checkout"
                            class="btn border-secondary rounded-pill px-4 py-3 text-primary text-uppercase mb-4 ms-4"
                            @if (count($cartProducts) == 0) disabled @endif type="button">Proceed Checkout</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart Page End -->
@endsection

@section('js-script')
    <script>
        $(document).ready(function() {
            // Function to update totals
            function updateTotals() {
                let subtotal = 0;
                $('.total').each(function() {
                    subtotal += parseInt($(this).text());
                });
                $('#subtotal').text(subtotal + ' mmk');
                $('#finalTotal').text((subtotal + 5000) + ' mmk');
            }

            // Function to save cart state to localStorage
            function saveCartState() {
                const cartState = {};
                $('.qty').each(function() {
                    const cartId = $(this).data('cart-id');
                    cartState[cartId] = {
                        quantity: $(this).val(),
                        price: $(this).data('price')
                    };
                });
                localStorage.setItem('cartState', JSON.stringify(cartState));
            }

            // Function to restore cart state from localStorage
            function restoreCartState() {
                const savedState = localStorage.getItem('cartState');
                if (savedState) {
                    const cartState = JSON.parse(savedState);
                    $('.qty').each(function() {
                        const cartId = $(this).data('cart-id');
                        if (cartState[cartId]) {
                            const quantity = cartState[cartId].quantity;
                            const price = cartState[cartId].price;
                            $(this).val(quantity);
                            $(this).closest('tr').find('.total').text((quantity * price) + ' mmk');
                        }
                    });
                    updateTotals();
                }
            }

            // Initial totals calculation and restore saved state
            restoreCartState();
            updateTotals();

            // Handle quantity changes
            $('.btn-minus, .btn-plus').click(function() {
                const input = $(this).closest('.quantity').find('.qty');
                const currentVal = parseInt(input.val());
                const price = parseInt($(this).closest('tr').find('.price').text());
                const totalElement = $(this).closest('tr').find('.total');

                if ($(this).hasClass('btn-minus')) {
                    if (currentVal > 1) {
                        input.val(currentVal - 1);
                        totalElement.text((currentVal - 1) * price + ' mmk');
                    } else {
                        // Prevent quantity from going below 1
                        input.val(1);
                        totalElement.text(price + ' mmk');
                    }
                } else {
                    input.val(currentVal + 1);
                    totalElement.text((currentVal + 1) * price + ' mmk');
                }

                updateTotals();
                saveCartState();
            });

            // Handle checkout button click
            $('#btn-checkout').click(function() {
                const cartUpdates = [];
                const orderCode = 'ORD-' + Math.floor(10000000 + Math.random() * 90000000);
                $('.qty').each(function() {
                    cartUpdates.push({
                        cartId: $(this).data('cart-id'),
                        quantity: $(this).val(),

                        //Data required for order
                        productId: $(this).data('product-id'),
                        total: $(this).closest('tr').find('.total').text().replace('mmk',
                            ''),
                        status: 0,
                        orderCode: orderCode,
                        finalTotal: $('#finalTotal').text()
                            .replace(
                                'mmk', '')
                    });
                });

                // Update cart quantities in database
                $.ajax({
                    url: '/user/home/cartupdate',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        updates: cartUpdates
                    },
                    success: function(response) {
                        if (response.success) {
                            // Clear localStorage after successful checkout
                            localStorage.removeItem('cartState');
                            window.location.href = '/user/home/payment';
                        } else {
                            alert(response.message || 'Failed to update cart');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Cart update error:', error);
                        alert('Failed to update cart. Please try again.');
                    }
                });
            });


            // Handle remove item
            $('.btn-remove').click(function() {
                const cartId = $(this).data('cart-id');
                const row = $(this).closest('tr');

                $.ajax({
                    url: '/user/home/cartremove/' + cartId,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            row.remove();
                            updateTotals();
                            saveCartState();
                        }
                    }
                });
            });

            // Save cart state before leaving the page
            $(window).on('beforeunload', function() {
                saveCartState();
            });
        });
    </script>
@endsection
