@extends('dashboard.master')
@section('title', 'Show Clinics')
@section('Clinic', 'active')
@section('search')
    <div class="navbar-nav align-items-center">
        <div class="nav-item d-flex align-items-center">
            <i class="bx bx-search fs-4 lh-0"></i>
            <input type="text" class="form-control border-0 shadow-none" id="search" placeholder="Search by name or phone"
                aria-label="Search..." />
        </div>
    </div>
@endsection
@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        @if (session('success-update-clinics'))
            <div class="alert alert-success">
                {{ session('success-update-clinics') }}
            </div>
        @endif
        @if (session('success-delete-clinics'))
            <div class="alert alert-danger">
                {{ session('success-delete-clinics') }}
            </div>
        @endif
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Clinics /</span> Show All Clinics</h4>
        </div>
        @if (count($clinics) > 0)
            <div class="row mb-5">
                @foreach ($clinics as $clinic)
                    <!-- Examples -->
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="card h-100">
                            <img class="card-img-top" src="{{ asset('storage/' . $clinic->image) }}"
                                style="height:250px; object-fit:cover;" alt="Card image cap" />
                            <div class="card-body">
                                <h5 class="card-title mb-2">{{ $clinic->name }}</h5>
                                <h5 class="card-title mb-2">Address : {{ $clinic->address }}</h5>
                                <h5 class="card-title mb-2">Phone : {{ $clinic->phone }}</h5>

                                <a href="{{ route('clinic.edit', $clinic->id) }}" class="btn btn-outline-primary">Edit</a>
                                <form action="{{ route('clinic.delete', $clinic->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
    <!-- / Content -->
@endsection
@section('script-ajax-search')
    <script>
        $(document).ready(function() {
            $('#search').on('keyup', function() {
                var value = $(this).val();
                $.ajax({
                    url: "{{ route('clinic.search') }}",
                    type: "GET",
                    data: {
                        value: value
                    },
                    success: function(response) {
                        $('.row').html(response);
                    }
                });
            });
        });
    </script>
@endsection
