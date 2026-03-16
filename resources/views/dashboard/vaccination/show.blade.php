@extends('dashboard.master')
@section('title', 'Show Vaccination')
@section('Vaccination', 'active')
@section('content')
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    @if (session('success-delete-vaccination'))
        <div class="alert alert-success">{{ session('success-delete-vaccination') }}</div>
    @endif
    @if (session('success-update-vaccination'))
        <div class="alert alert-success">{{ session('success-update-vaccination') }}</div>
    @endif
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Vaccination /</span> Show Vaccination </h4>
    <!-- Basic Bootstrap Table -->
    <div class="card">
      <h5 class="card-header">Table Vaccination</h5>
      <div class="table-responsive text-nowrap">
        <table class="table">
          <thead>
            <tr>
              <th>Vaccine Name</th>
              <th>Animal Type</th>
              <th>Age (weeks)</th>
              <th>Is Repeatable</th>
              <th>Repeat Every (weeks)</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody class="table-border-bottom-0">
            @if ($vaccinations->count() > 0)
              @foreach ($vaccinations as $vaccination)
                <tr>
                  <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>{{ $vaccination->name }}</strong></td>
                  <td>{{ $vaccination->animal_type }}</td>
                  <td>{{ $vaccination->start_age_weeks }} - {{ $vaccination->end_age_weeks }}</td>
                  <td>
                    @if ($vaccination->is_repeatable == 1)
                      <span class="badge bg-label-success me-1">Yes</span>
                    @else
                      <span class="badge bg-label-danger me-1">No</span>
                    @endif
                  </td>
                  <td>
                    @if ($vaccination->is_repeatable == 1)
                      {{ $vaccination->repeat_every_weeks }}
                    @else
                      <span class="badge bg-label-warning me-1">Once</span>
                    @endif
                  </td>
                  <td>
                    <div class="dropdown">
                      <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                        <i class="bx bx-dots-vertical-rounded"></i>
                      </button>
                      <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('vaccination.edit', $vaccination->id) }}"><i class="bx bx-edit-alt me-2"></i> Edit</a>
                        <form action="{{ route('vaccination.delete', $vaccination->id) }}" method="POST">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="dropdown-item text-danger d-flex align-items-center">
                            <i class="bx bx-trash me-2"></i> Delete
                          </button>
                        </form>
                      </div>
                    </div>
                  </td>
                </tr>
              @endforeach
            @endif  
          </tbody>
        </table>
      </div>
    </div>
    {{ $vaccinations->render('pagination::bootstrap-5') }}
    <!--/ Basic Bootstrap Table -->
    <hr class="my-5" />
</div>
<!-- / Content -->
@endsection