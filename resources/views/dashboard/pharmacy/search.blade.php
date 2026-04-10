@forelse ($medicines as $medicine)
<div class="col-md-6 col-lg-4 mb-3">
    <div class="card h-100">
        <img class="card-img-top"
             src="{{ asset('storage/' . $medicine->image) }}"
             style="height:250px; object-fit:cover;" />

        <div class="card-body">
            <h5 class="mb-2">{{ $medicine->name }}</h5>
            <p>Price: {{ $medicine->price }} EGP</p>
            <p>Quantity: {{ $medicine->stock }}</p>

            <a href="{{ route('pharmacy.edit', $medicine->id) }}"
               class="btn btn-outline-primary">Edit</a>

            <form action="{{ route('pharmacy.delete', $medicine->id) }}"
                  method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button class="btn btn-outline-danger">Delete</button>
            </form>
        </div>
    </div>
</div>
@empty
<div class="col-12 text-center">
    <h5>No results found</h5>
</div>
@endforelse