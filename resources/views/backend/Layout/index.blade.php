<!DOCTYPE html>
<html lang="en">
@include('backend.Layout.header')

<body class="hold-transition sidebar-mini">
    @if (session('alert'))
        <script>
            var mess = '{{ session('alert') }}'
            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: mess,
            })
        </script>
    @endif
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ route('admin.admin') }}" class="nav-link">Home</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Contact</a>
                </li>
                <ul class="navbar-nav ms-auto d-flex flex-row">
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li class="px-4 nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        @if (Auth::user()->role === 'ADC')
                            <a class="nav-link" href="{{ route('index') }}">
                                {{ __('Shop') }}
                            </a>
                        @endif
                        <a class="nav-link" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        @csrf
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    @endguest
                </ul>
            </ul>
        </nav>


        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- Navbar Search -->
            <li class="nav-item">
                <div class="navbar-search-block">
                    <form class="form-inline">
                        <div class="input-group input-group-sm">
                            <input class="form-control form-control-navbar" type="search" placeholder="Search"
                                aria-label="Search">
                            <div class="input-group-append">
                                <button class="btn btn-navbar" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </li>

            <!-- Messages Dropdown Menu -->

            <!-- Main Sidebar Container -->
            <aside class="main-sidebar sidebar-dark-primary elevation-4">
                <!-- Brand Logo -->
                <a href="{{ route('admin.admin') }}" class="brand-link">
                    <img src="{{ asset('/logo.jpg') }}" alt="ApCake Logo" class="brand-image img-circle elevation-3"
                        style="opacity: .8">
                    <span class="brand-text font-weight-light">ApCake</span>
                </a>

                <!-- Sidebar -->
                <div class="sidebar">
                    <!-- Sidebar Menu -->
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                            data-accordion="false">
                            {{-- <li class="nav-item">
                                <a href="{{ route('admin') }}" class="nav-link">
                                    <i class="nav-icon fas fa-th"></i>
                                    <p>Dashboard</p>
                                </a>
                            </li> --}}
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-copy"></i>
                                    <p> Product
                                        <i class="fas fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('admin.addCategory') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Add Category</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('admin.showCategory') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Show Category</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('admin.addProduct') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Add Product</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('admin.showProduct') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Show Product</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.users') }}" class="nav-link">
                                    <i class="nav-icon fas fa-users"></i>
                                    <p>Users</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.blog') }}" class="nav-link">
                                    <i class="nav-icon fas fa-sharp fa-file"></i>
                                    <p>Blog</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.invoice') }}" class="nav-link">
                                    <i class="nav-icon fas fa-sharp fa-file-invoice"></i>
                                    <p>Invoice</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.order') }}" class="nav-link">
                                    <i class="nav-icon fas fa-sharp fa-file-order"></i>
                                    <p>order</p>
                                </a>
                            </li>
                        </ul>
                    </nav>
                    <!-- /.sidebar-menu -->
                </div>
                <!-- /.sidebar -->
            </aside>
        </ul>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">

                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('admin.admin') }}">Main</a></li>
                                <li class="breadcrumb-item active"><a href="#">Category</a> </li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <div class="content">

                <div class="container-fluid">

                    @include('backend.Layout.alert')

                    <div class="row">

                        <div class="col-lg-12">
                            <div class="card card-success mt-3">
                                <div class="card-header">
                                    <h3 class="card-title">{{ $title }}</h3>
                                </div>
                                @yield('content')

                            </div>
                        </div>
                    </div>
                    <!-- /.col-md-6 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    @include('backend.Layout.footer')
    </ul>

</body>

</html>
