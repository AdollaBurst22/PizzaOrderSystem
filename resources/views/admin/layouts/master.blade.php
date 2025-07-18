<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>POS Admin Dashboard</title>

    <!-- Custom fonts for this template-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">


    <!-- Custom styles for this template-->
    <link href="{{ asset('admin/css/sb-admin-2.css') }}" rel="stylesheet">
    <!--Custom Product detail page Css -->
    <link rel="stylesheet" href="{{ asset('admin/css/productDetail.css') }}">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Nyein's POS</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin#mainDashboard') }}"><i
                        class="fas fa-fw fa-table"></i><span>Dashboard </span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin#categoryList') }}"><i
                        class="fa-solid fa-circle-plus"></i></i><span>Category </span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.productCreate') }}"><i
                        class="fa-solid fa-plus"></i></i><span>Add Products </span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.productList') }}"><i
                        class="fa-solid fa-layer-group"></i><span>Product List </span></a>
            </li>

            @if (Auth::user()->role == 'superadmin')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('superadmin.paymentMethodList') }}"><i
                            class="fa-solid fa-credit-card"></i></i><span>Payment Method
                        </span></a>
                </li>
            @endif
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.saleList') }}"><i class="fa-solid fa-list"></i><span>Sale
                        Information </span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.orderList') }}"><i
                        class="fa-solid fa-cart-shopping"></i><span>Order Board
                    </span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.passwordChange') }}"><i
                        class="fa-solid fa-lock"></i></i></i><span>Change Password
                    </span></a>
            </li>

            <li class="nav-item">
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <span class="nav-link">
                        <button type="submit" class="btn bg-dark text-white"><i
                                class="fa-solid fa-right-from-bracket"></i> Logout</button>
                    </span>
                </form>
            </li>
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">



                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">


                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span
                                    class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name != null ? (Auth::user()->nickname != null ? Auth::user()->name . ' (' . Auth::user()->nickname . ')' : Auth::user()->name) : Auth::user()->nickname }}</span>
                                <img class="img-profile rounded-circle"
                                    src="{{ asset(Auth::user()->profile != null ? 'admin/profileImages/' . Auth::user()->profile : 'user/img/avatar.jpg') }}">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="{{ route('admin.profileUpdate') }}">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                @if (Auth::user()->role == 'superadmin')
                                    <a class="dropdown-item" href="{{ route('superadmin.newAdminCreate') }}">
                                        <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Add New Admin Account
                                    </a>
                                    <a class="dropdown-item"
                                        href="{{ route('superadmin.accountList', ['accountType' => 'admin']) }}">
                                        <i class="fas fa-users fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Admin List
                                    </a>

                                    <a class="dropdown-item"
                                        href="{{ route('superadmin.accountList', ['accountType' => 'user']) }}">
                                        <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                        User List
                                    </a>
                                @endif

                                <a class="dropdown-item" href="{{ route('admin.passwordChange') }}">
                                    <i class="fa-solid fa-lock fa-sm fa-fw mr-2 text-gray-400"></i></i></i>
                                    Change Password
                                </a>
                                <div class="dropdown-divider"></div>
                                <span class="dropdown-item" data-toggle="modal" data-target="#logoutModal">
                                    <form action="{{ route('logout') }}" method="post">
                                        @csrf
                                        <input type="submit" class="btn btn-dark text-white w-100" value="Logout">
                                    </form>
                                </span>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                @yield('content')


                <!-- Bootstrap core JavaScript-->
                <script src="{{ asset('admin/vendor/jquery/jquery.min.js') }}"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
                    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
                    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
                <script src="{{ asset('admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

                <!-- Core plugin JavaScript-->
                <script src="{{ asset('admin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

                <!-- Custom scripts for all pages-->
                <script src="{{ asset('admin/js/sb-admin-2.min.js') }}"></script>


                <script src="{{ asset('admin/vendor/chart.js/Chart.min.js') }}"></script>

                <!-- Page level custom scripts -->
                <script src="{{ asset('admin/js/demo/chart-area-demo.js') }}"></script>
                <script src="{{ asset('admin/js/demo/chart-pie-demo.js') }}"></script>

                <!--Sweet Alert-->
                @include('sweetalert::alert')
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                @yield('js-script')
                <script>
                    function loadFile(event) {
                        var reader = new FileReader();
                        reader.onload = function() {
                            var output = document.getElementById('output');
                            output.src = reader.result;
                        }
                        reader.readAsDataURL(event.target.files[0]);
                    }
                </script>
</body>

</html>
