@forelse ($clinics as $clinic)
<div class="col-md-6 col-lg-4 mb-3">
    <div class="card h-100">
        <img class="card-img-top"
             src="{{ asset('storage/' . $clinic->image) }}"
             style="height:250px; object-fit:cover;" />

        <div class="card-body">
            <h5 class="mb-2">{{ $clinic->name }}</h5>
            <p>Address: {{ $clinic->address }}</p>
            <p>Phone: {{ $clinic->phone }}</p>

            <a href="{{ route('clinic.edit', $clinic->id) }}"
               class="btn btn-outline-primary">Edit</a>

            <form action="{{ route('clinic.delete', $clinic->id) }}"
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