@extends('dashboard.master')
@section('title', 'Vetly Dashboard')
@section('Dashboard', 'active')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row mb-4 g-3">
            <div class="col-6 col-lg-3">
                <div class="card h-100">
                    <div class="card-body d-flex align-items-center justify-content-between p-3">
                        <div>
                            <h3 class="mb-0 fw-bold">{{ $orderCount ?? 0 }}</h3>
                            <small class="text-muted">Total Orders</small>
                        </div>
                        <span class="avatar-initial rounded bg-label-primary p-2">
                            <i class="bx bx-cart fs-3"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card h-100">
                    <div class="card-body d-flex align-items-center justify-content-between p-3">
                        <div>
                            <h3 class="mb-0 fw-bold">{{ $bookingCount ?? 0 }}</h3>
                            <small class="text-muted">New Reservations</small>
                        </div>
                        <span class="avatar-initial rounded bg-label-success p-2">
                            <i class="bx bx-calendar fs-3"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card h-100">
                    <div class="card-body d-flex align-items-center justify-content-between p-3">
                        <div>
                            <h3 class="mb-0 fw-bold">{{ $lowStockCount ?? 0 }}</h3>
                            <small class="text-muted">Low Stock Items</small>
                        </div>
                        <span class="avatar-initial rounded bg-label-danger p-2">
                            <i class="bx bx-error fs-3"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card h-100">
                    <div class="card-body d-flex align-items-center justify-content-between p-3">
                        <div>
                            <h3 class="mb-0 fw-bold">{{ $medicineCount ?? 0 }}</h3>
                            <small class="text-muted">Total Medicines</small>
                        </div>
                        <span class="avatar-initial rounded bg-label-info p-2">
                            <i class="bx bx-package fs-3"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="row">
                {{-- Welcome Card --}}
                <div class="col-md-5.5 mb-4">
                    <div class="card">
                        <div class="d-flex align-items-end row">
                            <div class="col-sm-7">
                                <div class="card-body">
                                    <h5 class="card-title text-primary">Welcome back, {{ auth()->user()->name }}! 👋</h5>
                                    <p class="mb-4">
                                        Welcome to <span class="fw-bold">Vetly</span> — your animal health management
                                        platform.
                                        Track bookings, orders, and medications all in one place.
                                    </p>
                                    <a href="{{ route('booking.index') }}" class="btn btn-sm btn-outline-primary">
                                        View Bookings
                                    </a>
                                </div>
                            </div>
                            <div class="col-sm-5 text-center text-sm-left">
                                <div class="card-body pb-0 px-0 px-md-4">
                                    <img src="../assets/img/illustrations/man-with-laptop-light.png" height="140"
                                        alt="View Badge User" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            {{-- Total Revenue --}}
            <div class="col-md-8 mb-4">
                <div class="card">
                    <div class="row row-bordered g-0">
                        <div class="col-md-8">
                            <h5 class="card-header m-0 me-2 pb-3">Total Revenue</h5>
                            <div id="totalRevenueChart" class="px-2"></div>
                        </div>
                        <div class="col-md-4">
                            <div class="card-body">
                                <div class="text-center">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button"
                                            id="growthReportId" data-bs-toggle="dropdown">
                                            2022
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item" href="javascript:void(0);">2021</a>
                                            <a class="dropdown-item" href="javascript:void(0);">2020</a>
                                            <a class="dropdown-item" href="javascript:void(0);">2019</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="growthChart"></div>
                            <div class="text-center fw-semibold pt-3 mb-2">62% Company Growth</div>
                            <div class="d-flex px-xxl-4 px-lg-2 p-4 gap-xxl-3 gap-lg-1 gap-3 justify-content-between">
                                <div class="d-flex">
                                    <div class="me-2">
                                        <span class="badge bg-label-primary p-2"><i
                                                class="bx bx-dollar text-primary"></i></span>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <small>2022</small>
                                        <h6 class="mb-0">$32.5k</h6>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="me-2">
                                        <span class="badge bg-label-info p-2"><i
                                                class="bx bx-wallet text-info"></i></span>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <small>2021</small>
                                        <h6 class="mb-0">$41.2k</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Recent Orders --}}
            <div class="col-md-4 mb-4 order-2">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title m-0">Recent Orders</h5>
                        <a href="{{ route('orders.index') }}" class="text-primary" style="font-size: 13px;">View All</a>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-unstyled mb-0">
                            @forelse($recentOrders as $order)
                                <li class="d-flex align-items-center px-3 py-3" style="border-bottom: 1px solid #f0f0f0;">
                                    <div class="avatar flex-shrink-0 me-3">
                                        <span class="avatar-initial rounded bg-label-primary">
                                            <i class="bx bx-cart"></i>
                                        </span>
                                    </div>
                                    <div class="d-flex w-100 justify-content-between align-items-center">
                                        <a href="{{ route('orders.viewdetails', $order->id) }}">
                                            <h6 class="mb-0" style="font-size: 14px;">New Order From
                                                {{ $order->user->name }}</h6>
                                            <small class="text-muted">{{ $order->created_at->diffForHumans() }}</small>
                                        </a>
                                        @if($order->status == 'pending')
                                            <span class="badge bg-label-warning">New</span>
                                        @elseif($order->status == 'confirmed')
                                            <span class="badge bg-label-success">Confirmed</span>
                                        @elseif($order->status == 'shipped')
                                            <span class="badge bg-label-primary">Shipped</span>
                                        @elseif($order->status == 'cancelled')
                                            <span class="badge bg-label-danger">Cancelled</span>
                                        @endif
                                    </div>
                                </li>
                            @empty
                                <li class="text-center text-muted py-4">No recent orders</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
            <!--/ Recent Orders -->
        </div>
        
    </div>
@endsection
