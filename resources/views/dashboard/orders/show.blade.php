@extends('dashboard.master')
@section('title', 'Orders')
@section('Orders', 'active')
@section('content')
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Orders /</span> Orders List </h4>
    <!-- Basic Bootstrap Table -->
    <div class="card">
      <h5 class="card-header">Table Orders</h5>
      <div class="table-responsive text-nowrap">
        <table class="table">
          <thead>
            <tr>
              <th>Orders</th>
              <th>Order request</th>
              <th>Price</th>
              <th>Order time</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody class="table-border-bottom-0">
            @if ($orders->count() > 0)
              @foreach ($orders as $order)
                <tr>
                  <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>{{ $loop->index+1 }}</strong></td>
                  <td>{{ $order->user->name }}</td>
                  <td>{{ $order->total_price }}</td>
                  <td>
                    {{ \Carbon\Carbon::parse($order->booking_date)->format('d M') }}
                    -
                    {{ \Carbon\Carbon::parse($order->booking_time)->format('h:i A') }}
                  </td>
                  <td>
                    @if ($order->status == 'pending')
                      <span class="badge bg-label-warning me-1">Pending</span>
                    @elseif ($order->status == 'approved')
                      <span class="badge bg-label-success me-1">approved</span>
                    @elseif ($order->status == 'shipped')
                      <span class="badge bg-label-info me-1">shipped</span>
                    @endif
                  </td>
                  <td>
                    <div class="dropdown">
                      <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                        <i class="bx bx-dots-vertical-rounded"></i>
                      </button>
                      <div class="dropdown-menu">
                        @if($order->status != 'pending' && $order->status != 'shipped')
                          <form action="{{ route('orders.ship', $order->id) }}" method="POST">
                              @csrf
                              <button type="submit" class="dropdown-item text-primary d-flex align-items-center">
                                  <i class="bx bx-edit-alt me-2"></i> Ship Order
                              </button>
                          </form>
                        @endif
                        <a class="dropdown-item" href="{{ route('orders.viewdetails', $order->id) }}"
                          ><i class="bx bx-trash me-1"></i> View Details</a
                        >
                      </div>
                    </div>
                  </td>
                </tr>
              @endforeach
            @endif  
          </tbody>
        </table>
      </div>
    </div>
    <!--/ Basic Bootstrap Table -->
    <hr class="my-5" />
</div>
<!-- / Content -->
@endsection