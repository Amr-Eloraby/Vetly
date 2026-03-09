@extends('dashboard.master')
@section('title', 'Booking')
@section('Booking', 'active')
@section('content')
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Booking /</span> Booking List </h4>
    <!-- Basic Bootstrap Table -->
    <div class="card">
      <h5 class="card-header">Table Booking</h5>
      <div class="table-responsive text-nowrap">
        <table class="table">
          <thead>
            <tr>
              <th>animal owner</th>
              <th>Clinic</th>
              <th>Service Type</th>
              <th>Booking time</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody class="table-border-bottom-0">
            @if ($bookings->count() > 0)
              @foreach ($bookings as $booking)
                <tr>
                  <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>{{ $booking->user->name }}</strong></td>
                  <td>{{ $booking->clinic->name }}</td>
                  <td>{{ $booking->service_type }}</td>
                  <td>
                    {{ \Carbon\Carbon::parse($booking->booking_date)->format('d M') }}
                    -
                    {{ \Carbon\Carbon::parse($booking->booking_time)->format('h:i A') }}
                  </td>
                  <td>
                    @if ($booking->status == 'pending')
                      <span class="badge bg-label-warning me-1">Pending</span>
                    @elseif ($booking->status == 'confirmed')
                      <span class="badge bg-label-success me-1">Confirmed</span>
                    @elseif ($booking->status == 'cancelled')
                      <span class="badge bg-label-danger me-1">Cancelled</span>
                    @endif
                  </td>
                  <td>
                    <div class="dropdown">
                      <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                        <i class="bx bx-dots-vertical-rounded"></i>
                      </button>
                      <div class="dropdown-menu">
                        <form action="{{ route('booking.confirm', $booking->id) }}" method="POST">
                          @csrf
                          <button type="submit" class="dropdown-item text-primary d-flex align-items-center">
                            <i class="bx bx-edit-alt me-2"></i> confirmed
                          </button>
                        </form>
                        <form action="{{ route('booking.cancel', $booking->id) }}" method="POST">
                          @csrf
                          <button type="submit" class="dropdown-item text-danger d-flex align-items-center">
                            <i class="bx bx-trash me-2"></i> cancelled
                          </button>
                        </form>
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