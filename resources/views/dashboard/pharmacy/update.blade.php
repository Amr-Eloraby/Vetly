@extends('dashboard.master')
@section('title', 'Update Pharmacy')
@section('Pharmacy', 'active')
@section('content')
  <!-- Content -->

  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Pharmacy /</span> Update Pharmacy</h4>
    <form action="{{ route('pharmacy.update', $medicine->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
      <div class="row">
        <div class="col-md-6">
          <div class="card mb-4">
            <div class="card-body">
              <div>
                <label for="name" class="form-label">Name</label>
              <input
                type="text"
                class="form-control"
                id="name"
                name="name"
                placeholder="Medicine Name"
                aria-describedby="defaultFormControlHelp"
                value="{{$medicine->name}}"
              />
              <div id="defaultFormControlHelp" class="form-text">
                We'll never share your details with anyone else.
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card mb-4">
          <div class="card-body">
            <div>
              <label for="price" class="form-label">Price</label>
              <input
                type="text"
                class="form-control"
                id="price"
                placeholder="100.00 EGP"
                name="price"
                aria-describedby="defaultFormControlHelp"
                value="{{$medicine->price}}"
              />
              <div id="defaultFormControlHelp" class="form-text">
                We'll never share your details with anyone else.
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card mb-4">
          <div class="card-body">
            <div>
              <label for="stock" class="form-label">Quantity</label>
              <input
                type="text"
                class="form-control"
                id="stock"
                placeholder=" 20 pcs"
                name="stock"
                aria-describedby="defaultFormControlHelp"
                value="{{$medicine->stock}}"
              />
              <div id="defaultFormControlHelp" class="form-text">
                We'll never share your details with anyone else.
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card mb-4">
          <div class="card-body">
            <div>
              <div >
                <label for="image" class="form-label">Image</label>
                <input class="form-control" type="file" id="image" name="image" />
              </div>
              <div id="defaultFormControlHelp" class="form-text">
                We'll never share your details with anyone else.
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-2 d-flex justify-content-center mt-4 w-100">
          <div class="card-body">
            <div class="col-12 text-center">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </div>
      </div>
    </form>
    </div>
  </div>
  <!-- / Content -->
@endsection