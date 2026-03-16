@extends('dashboard.master')
@section('title', 'Edit Vaccination')
@section('Vaccination', 'active')
@section('content')
<!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        @if (session('success-edit-vaccination'))
            <div class="alert alert-success">{{ session('success-edit-vaccination') }}</div>
        @endif
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Vaccination /</span> Edit Vaccination</h4>
        <form action="{{ route('vaccination.update', $vaccination->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-body">
                    <div>
                        <label for="name" class="form-label">Vaccination Name</label>
                        <input
                        type="text"
                        class="form-control"
                        id="name"
                        name="name"
                        placeholder="Enter Vaccination Name"
                        value="{{old('name', $vaccination->name)}}"
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
                        <label for="animal_type" class="form-label">Animal Type</label>
                        <select name="animal_type" id="animal_type" class="form-control">
                            <option value="">Select Animal Type</option>
                            <option value="Dog" {{old('animal_type', $vaccination->animal_type) == 'Dog' ? 'selected' : ''}} >Dog</option>
                            <option value="Cat" {{old('animal_type', $vaccination->animal_type) == 'Cat' ? 'selected' : ''}}>Cat</option>
                            <option value="Chicken" {{old('animal_type', $vaccination->animal_type) == 'Chicken' ? 'selected' : ''}}>Chicken</option>
                            <option value="Pigeon" {{old('animal_type', $vaccination->animal_type) == 'Pigeon' ? 'selected' : ''}}>Pigeon</option>
                            <option value="Horse" {{old('animal_type', $vaccination->animal_type) == 'Horse' ? 'selected' : ''}}>Horse</option>
                            <option value="Cow" {{old('animal_type', $vaccination->animal_type) == 'Cow' ? 'selected' : ''}}>Cow</option>
                        </select>
                        @error('animal_type')
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
                        <label for="start_age_weeks" class="form-label">Start Age (Weeks)</label>
                        <input
                        type="number"
                        class="form-control"
                        id="start_age_weeks"
                        name="start_age_weeks"
                        placeholder="Enter Start Age (Weeks)"
                        value="{{old('start_age_weeks', $vaccination->start_age_weeks)}}"
                        aria-describedby="defaultFormControlHelp"
                        />
                        @error('start_age_weeks')
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
                        <label for="end_age_weeks" class="form-label">End Age (Weeks)</label>
                        <input
                        type="number"
                        class="form-control"
                        id="end_age_weeks"
                        name="end_age_weeks"
                        placeholder="Enter End Age (Weeks)"
                        value="{{old('end_age_weeks', $vaccination->end_age_weeks)}}"
                        aria-describedby="defaultFormControlHelp"
                        />
                        @error('end_age_weeks')
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
                <div class="">
                    <div class="card-body">
                        <div class="form-check form-switch mb-4">
                            <input type="hidden" name="is_repeatable" {{old('is_repeatable', $vaccination->is_repeatable) == '1' ? 'checked' : ''}} value="0">
                            <input class="form-check-input fs-4 mt-2" {{old('is_repeatable', $vaccination->is_repeatable) == '1' ? 'checked' : ''}} type="checkbox" value="1" id="repeatToggle" name="is_repeatable" />
                            <label class="form-check-label fs-4" for="repeatToggle"
                                >Is Repeatable</label
                            >
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card mb-4" id="repeatField" style="display:none;">
                    <div class="card-body">
                    <div>
                        <label for="repeat_every_weeks">Repeat Every (Weeks)</label>
                        <input type="number" class="form-control" id="repeatfield" name="repeat_every_weeks" placeholder="Enter Repeat Interval (Weeks)" value="{{old('repeat_every_weeks', $vaccination->repeat_every_weeks)}}">
                        @error('repeat_every_weeks')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
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

