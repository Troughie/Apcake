@extends('backend.Layout.index')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="col-lg-12">
                <div class="card mt-3">
                    <div class="card-header">
                        <h1 class="card-title">Quản lí sản phẩm</h1>
                    </div>
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>
                        <div class="info-box-content">
                            <a href="{{ route('admin.showCategory') }}">
                                <button class=" btn btn-info btn-bg"><i class="fa fa-list" aria-hidden="true">
                                    </i> Danh mục {{count($category2)}} sản phẩm
                                </button>
                            </a>
                        </div>
                        <div class="info-box-content">
                            <a href="{{ route('admin.showCategory') }}">
                                <button class=" btn btn-primary btn-bg"><i class="fa fa-plus" aria-hidden="true">
                                    </i> Thêm Danh mục
                                </button>
                            </a>
                        </div>
                        <div class="info-box-content">
                            <a href="{{ route('admin.showProduct') }}">
                                <button class=" btn btn-danger btn-bg"><i class="fa fa-list" aria-hidden="true">
                                    </i> Danh sách {{count($product2)}} sản phẩm
                                </button>                              
                            </a>
                            
                        </div>
                        <div class="info-box-content">
                            <a href="{{ route('admin.addProduct') }}">
                                <button class=" btn btn-warning btn-bg"><i class="fa fa-plus" aria-hidden="true">
                                    </i> Thêm Sản phẩm
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card mt-3">
                    <div class="card-header">
                        <h1 class="card-title">Quản lí đơn hàng</h1>
                    </div>
                    <div class="info-box">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-shopping-cart"></i></span>
                        <div class="info-box-content">
                            <a href="{{ route('admin.order') }}">
                                <button class=" btn btn-warning btn-bg"><i class="fa fa-list-alt" aria-hidden="true">
                                    </i> Tổng đơn hàng: {{ count($order2) }}
                                </button>
                            </a>
                        </div>
                        <div class="info-box-content">
                            <a href="{{ route('admin.orderDday') }}">
                                <button class=" btn btn-primary btn-bg"><i class="fa fa-check-square" aria-hidden="true">
                                    </i> Đơn hàng trong ngày: {{ count($orderDay) }}
                                </button>
                            </a>
                        </div>
                        <div class="info-box-content">
                            <a href="{{ route('admin.orderMonth') }}">
                                <button class=" btn btn-info btn-bg"><i class="fa fa-list" aria-hidden="true">
                                    </i> Đơn hàng trong tháng : {{ count($orderMonth) }}
                                </button>
                            </a>
                        </div>
                        <div class="info-box-content">
                            <a href="#">
                           <span class="btn btn-success">
                            <i class="fa-solid fa-dollar-sign" aria-hidden="true">
                            </i> Tổng doanh thu : {{number_format ($totalAvenue).' Vnd' }}
                           </span>
                        </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card mt-3">
                    <div class="card-header">
                        <h1 class="card-title">Quản lí Người dùng</h1>
                    </div>
                    <div class="info-box">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-users"></i></span>
                        <div class="info-box-content">
                            <a href="{{ route('admin.users') }}">
                                <button class=" btn btn-success btn-bg"><i class="fa fa-user" aria-hidden="true">
                                    </i> Danh sách người dùng
                                </button>
                            </a>
                        </div>
                        
                        <div class="info-box-content">
                            <a href="{{ route('admin.promotion') }}">
                                <button class=" btn btn-info btn-bg"><i class="fa fa-gift" aria-hidden="true">
                                    </i> Quản lí Coupon
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card mt-3">
                    <div class="card-header">
                        <h1 class="card-title">Quản lí Comment</h1>
                    </div>
                    <div class="info-box">
                        <span class="info-box-icon bg-primary elevation-1"><i class="fa fa-comments"
                                aria-hidden="true"></i></span>
                       
                        <div class="info-box-content">
                            <a href="{{ route('admin.comment') }}">
                                <button class=" btn btn-danger btn-bg"><i class="fa fa-check-square" aria-hidden="true">
                                    </i> Quản lí Comment
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
@endsection
