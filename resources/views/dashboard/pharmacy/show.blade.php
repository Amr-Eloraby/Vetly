@extends('dashboard.master')
@section('title', 'Show Pharmacy')
@section('Pharmacy', 'active')
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
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Pharmacy /</span> Show All Medicines</h4>
            <input type="text" class="form-control" id="search" placeholder="Search" style="width: 200px;">
        </div>
        @if(count($medicines)>0)
        <div class="row mb-5">
            @foreach ($medicines as $medicine)
            <!-- Examples -->
            <div class="col-md-6 col-lg-4 mb-3">
                <div class="card h-100">
                <img class="card-img-top" src="{{ asset('storage/' . $medicine->image) }}" style="height:250px; object-fit:cover;" alt="Card image cap" />
                <div class="card-body">
                    
                    <h5 class="card-title mb-2">{{$medicine->name}}</h5>
                    <h5 class="card-title mb-2">Price : {{$medicine->price}} EGP</h5>
                    <h5 class="card-title mb-2">Quantity : {{$medicine->stock}}</h5>
                    
                    <a href="{{ route('pharmacy.edit', $medicine->id) }}" class="btn btn-outline-primary">Edit</a>
                    <form action="{{ route('pharmacy.delete', $medicine->id) }}" method="POST" class="d-inline">
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
