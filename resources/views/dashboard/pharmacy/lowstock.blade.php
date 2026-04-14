@extends('dashboard.master')
@section('title', 'Low Stock Pharmacy')
@section('Pharmacy', 'active')
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
        @if (session('success-update'))
          <div class="alert alert-success">
              {{ session('success-update') }}
          </div>
        @endif
        @if (session('success-delete'))
          <div class="alert alert-danger">
              {{ session('success-delete') }}
          </div>
        @endif
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Pharmacy /</span> Low Stock Medicines</h4>
        </div>
        @if(count($lowStocks)>0)
        <div class="row mb-5">
            @foreach ($lowStocks as $lowStock)
            <!-- Examples -->
            <div class="col-md-6 col-lg-4 mb-3">
                <div class="card h-100">
                <img class="card-img-top" src="{{ asset('storage/' . $lowStock->image) }}" style="height:250px; object-fit:cover;" alt="Card image cap" />
                <div class="card-body">
                    
                    <h5 class="card-title mb-2">{{$lowStock->name}}</h5>
                    <h5 class="card-title mb-2">Price : {{$lowStock->price}} EGP</h5>
                    <h5 class="card-title mb-2">Quantity : {{$lowStock->stock}}</h5>
                    
                    <a href="{{ route('pharmacy.edit', $lowStock->id) }}" class="btn btn-outline-primary">Edit</a>
                    <form action="{{ route('pharmacy.delete', $lowStock->id) }}" method="POST" class="d-inline">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-outline-danger">Delete</button>
                    </form>
                </div>
                </div>
            </div> 
            @endforeach   
        </div>
        @else
        <div class="text-center mt-5">
            <div class="">
                <h5 class="card-title">No low stock medicines found!</h5>
            </div>
        </div>
        @endif
    </div>
<!-- / Content -->
@endsection            

@section('script-ajax-search')
<script>
    $(document).ready(function(){
        $('#search').on('keyup', function(){
            var value = $(this).val();
            $.ajax({
                url: "{{ route('pharmacy.search') }}",
                type: "GET",
                data: {value: value},
                success: function(response){
                    $('.row').html(response);
                }
            });
        });
    });
</script>
@endsection
