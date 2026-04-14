@extends('dashboard.master')
@section('title', 'Booking')
@section('Booking', 'active')
@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Booking /</span> Booking List </h4>
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Table Booking</h5>
                <div class="d-flex align-items-center gap-2">
                    <label class="mb-0 text-muted" style="font-size:13px;">Date:</label>
                    <input type="date" id="dateFilter" class="form-control form-control-sm" style="width:170px;"
                        onchange="filterByDate()">
                    <button class="btn btn-sm btn-outline-secondary" onclick="clearFilter()">All</button>
                </div>
            </div>
            <div class="table-responsive text-nowrap">
                <div id="noResultsMsg" class="alert alert-warning m-3 d-none">
                    <i class="bx bx-calendar-x me-2"></i> No bookings found for this day.
                </div>
                <table class="table" id="bookingTable">
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
                    <tbody class="table-border-bottom-0" id="bookingTableBody">
                        @if ($bookings->count() > 0)
                            @foreach ($bookings as $booking)
                                <tr data-date="{{ \Carbon\Carbon::parse($booking->booking_date)->format('Y-m-d') }}">
                                    <td><i class="fab fa-angular fa-lg text-danger me-3"></i>
                                        <strong>{{ $booking->user->name }}</strong>
                                    </td>
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
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <form action="{{ route('booking.confirm', $booking->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit"
                                                        class="dropdown-item text-primary d-flex align-items-center">
                                                        <i class="bx bx-check-circle me-2"></i> confirmed
                                                    </button>
                                                </form>
                                                <form action="{{ route('booking.cancel', $booking->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit"
                                                        class="dropdown-item text-danger d-flex align-items-center">
                                                        <i class="bx bx-x-circle me-2"></i> cancelled
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
        {{ $bookings->render('pagination::bootstrap-5') }}
        <hr class="my-5" />
    </div>
    <!-- / Content -->
@endsection
<script>
    function filterByDate() {
        const selected = document.getElementById('dateFilter').value;
        const rows = document.querySelectorAll('#bookingTableBody tr[data-date]');
        const noMsg = document.getElementById('noResultsMsg');

        let visibleCount = 0;

        rows.forEach(row => {
            const rowDate = row.getAttribute('data-date');
            if (selected === '' || rowDate === selected) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        noMsg.classList.toggle('d-none', visibleCount > 0);
    }

    function clearFilter() {
        document.getElementById('dateFilter').value = '';
        filterByDate();
    }
</script>
