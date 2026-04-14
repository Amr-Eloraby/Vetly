@extends('dashboard.master')
@section('title', 'Vetly Dashboard')
@section('Dashboard', 'active')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row mb-4 g-3">
            <a class="col-6 col-lg-3" href="{{ route('orders.index') }}">
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
            </a>
            <a class="col-6 col-lg-3" href="{{ route('booking.index') }}">
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
            </a>
            <div class="col-6 col-lg-3">
                <a class="card h-100" href="{{ route('pharmacy.lowstock') }}">
                    <div class="card-body d-flex align-items-center justify-content-between p-3">
                        <div>
                            <h3 class="mb-0 fw-bold">{{ $lowStockCount ?? 0 }}</h3>
                            <small class="text-muted">Low Stock Items</small>
                        </div>
                        <span class="avatar-initial rounded bg-label-danger p-2">
                            <i class="bx bx-error fs-3"></i>
                        </span>
                    </div>
                </a>
            </div>
            <a class="col-6 col-lg-3" href="{{ route('pharmacy.show') }}">
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
            </a>
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
        <div class="row align-items-stretch">
            {{-- Charts Card --}}
            <div class="col-md-8 mb-4 d-flex flex-column">
                <div class="card w-100 h-100">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs" id="chartTabs">
                            <li class="nav-item">
                                <a class="nav-link active" href="#" onclick="showChart('bookings', this)">
                                    <i class="bx bx-calendar me-1"></i> Bookings
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" onclick="showChart('orders', this)">
                                    <i class="bx bx-cart me-1"></i> Orders Status
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" onclick="showChart('medicines', this)">
                                    <i class="bx bx-package me-1"></i> Top Medicines
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" onclick="showChart('weekly', this)">
                                    <i class="bx bx-trending-up me-1"></i> Weekly
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body d-flex align-items-center justify-content-center">
                        <canvas id="bookingsChart"  height="120" style="width:100%;"></canvas>
                        <canvas id="ordersChart"    height="120" style="width:100%; display:none;"></canvas>
                        <canvas id="medicinesChart" height="120" style="width:100%; display:none;"></canvas>
                        <canvas id="weeklyChart"    height="120" style="width:100%; display:none;"></canvas>
                    </div>
                </div>
            </div>
            {{-- Recent Orders --}}
            <div class="col-md-4 mb-4 d-flex flex-column">
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

    {{-- Charts Script --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Chart 1 - Monthly Bookings (Blue)
        new Chart(document.getElementById('bookingsChart'), {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Bookings',
                    data: [12, 19, 8, 25, 15, 10],
                    backgroundColor: 'rgba(105, 108, 255, 0.2)',
                    borderColor: '#696cff',
                    borderWidth: 2,
                    borderRadius: 6,
                }]
            },
            options: {
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true } }
            }
        });

        // Chart 2 - Orders Status (Donut)
        new Chart(document.getElementById('ordersChart'), {
            type: 'doughnut',
            data: {
                labels: ['Pending', 'Confirmed', 'Shipped', 'Cancelled'],
                datasets: [{
                    data: [30, 25, 20, 10],
                    backgroundColor: ['#FFB547', '#71DD37', '#03C3EC', '#FF4C51'],
                    borderWidth: 0,
                }]
            },
            options: {
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 24,
                            boxWidth: 12,
                        }
                    }
                },
                cutout: '70%',
                layout: {
                    padding: {
                        top: 16,
                        bottom: 16
                    }
                }
            }
        });

        // Chart 3 - Top Medicines (Green)
        new Chart(document.getElementById('medicinesChart'), {
            type: 'bar',
            data: {
                labels: ['Amoxicillin', 'Paracetamol', 'Ibuprofen', 'Vitamin C', 'Zinc'],
                datasets: [{
                    label: 'Qty Ordered',
                    data: [50, 40, 30, 25, 15],
                    backgroundColor: 'rgba(113, 221, 55, 0.2)',
                    borderColor: '#71DD37',
                    borderWidth: 2,
                    borderRadius: 6,
                }]
            },
            options: {
                indexAxis: 'y',
                plugins: { legend: { display: false } },
                scales: { x: { beginAtZero: true } }
            }
        });

        // Chart 4 - Weekly Activity (Purple + Cyan)
        new Chart(document.getElementById('weeklyChart'), {
            type: 'line',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [
                    {
                        label: 'Orders',
                        data: [5, 8, 6, 10, 7, 4, 9],
                        borderColor: '#696cff',
                        backgroundColor: 'rgba(105, 108, 255, 0.1)',
                        tension: 0.4, fill: true, pointRadius: 4,
                    },
                    {
                        label: 'Bookings',
                        data: [3, 6, 4, 8, 5, 3, 7],
                        borderColor: '#03C3EC',
                        backgroundColor: 'rgba(3, 195, 236, 0.1)',
                        tension: 0.4, fill: true, pointRadius: 4,
                    }
                ]
            },
            options: {
                plugins: { legend: { position: 'bottom' } },
                scales: { y: { beginAtZero: true } }
            }
        });

        function showChart(name, el) {
            event.preventDefault();
            ['bookings', 'orders', 'medicines', 'weekly'].forEach(function(c) {
                document.getElementById(c + 'Chart').style.display = 'none';
            });
            document.getElementById(name + 'Chart').style.display = 'block';
            document.querySelectorAll('#chartTabs .nav-link').forEach(function(a) {
                a.classList.remove('active');
            });
            el.classList.add('active');
        }
    </script>

@endsection