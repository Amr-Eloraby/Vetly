@extends('dashboard.master')
@section('title', 'Create Clinic')
@section('Clinic', 'active')
@section('content')
  <!-- Content -->

  <div class="container-xxl flex-grow-1 container-p-y">
    @if (session('success-create-clinics'))
          <div class="alert alert-success">
              {{ session('success-create-clinics') }}
          </div>
    @endif
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Clinic /</span> Create Clinic</h4>
    <form action="{{ route('clinic.store') }}" method="POST" enctype="multipart/form-data">
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
                  placeholder="Enter Clinic Name"
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
                <label for="phone" class="form-label">Phone</label>
                <input
                  type="text"
                  class="form-control"
                  id="phone"
                  name="phone"
                  placeholder="Enter Clinic Phone"
                  value="{{old('phone')}}"
                  aria-describedby="defaultFormControlHelp"
                />
                @error('phone')
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
                <label for="address" class="form-label">Address</label>
                <input
                  type="text"
                  class="form-control"
                  id="address"
                  name="address"
                  placeholder="Enter Clinic Address"
                  value="{{old('address')}}"
                  aria-describedby="defaultFormControlHelp"
                />
                @error('address')
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