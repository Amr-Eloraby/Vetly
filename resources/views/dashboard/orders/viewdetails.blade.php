@extends('dashboard.master')
@section('title')
View Details Orders #{{ $order->id }}
@endsection
@section('Orders', 'active')
@section('content')
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Orders /</span> Orders Details </h4>
    <div class="card">
      <h5 class="card-header">Orders Items</h5>
      <div class="table-responsive text-nowrap">
        <table class="table">
          <thead>
            <tr>
              <th>Item</th>
              <th>Order Request</th>
              <th>Medicine Name</th>
              <th>Quantity</th>
              <th>Price</th>
              <th>Total</th>
            </tr>
          </thead>
          <tbody class="table-border-bottom-0">
            @if ($orderItem->count() > 0)
              @foreach ($orderItem as $item)
                <tr>
                    <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>{{ $item->id }}</strong></td>
                    <td>{{ $order->user->name }}</td>
                    <td>{{ $item->medicine->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->price }}</td>
                    <td>{{ $item->quantity * $item->price }}</td>
                </tr>
              @endforeach
            @endif
          </tbody>
          <tfoot>
            <tr>
                <td colspan="5" class="text-end fw-bold">Grand Total:</td>
                <td class="fw-bold">{{ $order->total_price }}</td>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
    @if($order->status == 'pending')
        <div class="text-end mt-4">
            <form action="{{ route('orders.confirm', $order->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success">
                    Confirm Order
                </button>
            </form>
        </div>
    @endif
    <hr class="my-5" />
</div>
<!-- / Content -->
@endsection