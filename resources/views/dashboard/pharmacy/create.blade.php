@extends('dashboard.master')
@section('title', 'Create Pharmacy')
@section('Pharmacy', 'active')
@section('content')
  <!-- Content -->

  <div class="container-xxl flex-grow-1 container-p-y">
    @if (session('success'))
          <div class="alert alert-success">
              {{ session('success') }}
          </div>
    @endif
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Pharmacy /</span> Create Pharmacy</h4>
    <form action="{{ route('pharmacy.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
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
                  placeholder="Enter Pharmacy Name"
                  value="{{old('name')}}"
                  aria-describedby="defaultFormControlHelp"
                />
                @error('name')
                  <div class="alert alert-danger">{{ $message }}</div>
                @enderror
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
                  name="price"
                  placeholder="Enter Pharmacy Price"
                  value="{{old('price')}}"
                  aria-describedby="defaultFormControlHelp"
                />
                @error('price')
                  <div class="alert alert-danger">{{ $message }}</div>
                @enderror
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
                  name="stock"
                  placeholder="Enter Pharmacy Quantity"
                  value="{{old('stock')}}"
                  aria-describedby="defaultFormControlHelp"
                />
                @error('stock')
                  <div class="alert alert-danger">{{ $message }}</div>
                @enderror
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
                  <input class="form-control" value="{{old('image')}}" type="file" id="image" name="image" />
                  @error('image')
                    <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
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
      </div>
    </form>
  </div>
  <!-- / Content -->
@endsection