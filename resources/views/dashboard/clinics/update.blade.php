@extends('dashboard.master')
@section('title', 'Update Clinic')
@section('Clinic', 'active')
@section('content')
  <!-- Content -->

  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Clinic /</span> Update Clinic</h4>
    <form action="{{ route('clinic.update', $clinic->id) }}" method="POST" enctype="multipart/form-data">
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
                placeholder="Clinic Name"
                aria-describedby="defaultFormControlHelp"
                value="{{$clinic->name}}"
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
              <label for="phone" class="form-label">Phone</label>
              <input
                type="text"
                class="form-control"
                id="phone"
                placeholder="Clinic Phone"
                name="phone"
                aria-describedby="defaultFormControlHelp"
                value="{{$clinic->phone}}"
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
              <label for="address" class="form-label">Address</label>
              <input
                type="text"
                class="form-control"
                id="address"
                placeholder="Clinic Address"
                name="address"
                aria-describedby="defaultFormControlHelp"
                value="{{$clinic->address}}"
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
    </div>
  </div>
  <!-- / Content -->
@endsection