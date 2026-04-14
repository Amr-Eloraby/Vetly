@extends('dashboard.master')
@section('title', 'Orders')
@section('Orders', 'active')
@section('content')
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Orders /</span> Orders List </h4>
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Table Orders</h5>
        <div class="d-flex align-items-center gap-2">
          <label class="mb-0 text-muted" style="font-size:13px;">Status:</label>
          <select id="statusFilter" class="form-select form-select-sm" style="width:150px;" onchange="filterOrders()">
            <option value="all">All</option>
            <option value="pending">Pending</option>
            <option value="approved">Approved</option>
            <option value="shipped">Shipped</option>
          </select>
        </div>
      </div>
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
          <tbody class="table-border-bottom-0" id="ordersTableBody">
            @if ($orders->count() > 0)
              @foreach ($orders as $order)
                <tr data-status="{{ $order->status }}">
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
                                  <i class="bx bx-car me-1"></i> Ship Order
                              </button>
                          </form>
                        @endif
                        <a class="dropdown-item" href="{{ route('orders.viewdetails', $order->id) }}"
                          ><i class="bx bx-detail me-1"></i> View Details</a
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
    <hr class="my-5" />
</div>
<!-- / Content -->
@endsection
<script>
  function filterOrders() {
    const filter = document.getElementById('statusFilter').value;
    const rows   = document.querySelectorAll('#ordersTableBody tr[data-status]');

    rows.forEach(row => {
      const status = row.getAttribute('data-status');
      row.style.display = (filter === 'all' || status === filter) ? '' : 'none';
    });
  }
</script>
