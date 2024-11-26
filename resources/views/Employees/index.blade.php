@php
    use Carbon\Carbon;
@endphp

@extends('layouts.app')

@section('title', 'Employees')

@section('header', 'Employees Table')

@section('breadcrumb')
  <div class="breadcrumb-item active"><a href="#">Employees</a></div>
@endsection

@section('content')
  <div class="col-12 col-md-12 col-lg-12">
    <div class="card">
      <div class="card-header">
        <h4>Data Employees</h4>
        <div class="card-header-action">
          <a href="{{ route('employees.create') }}" class="btn btn-primary px-5">Tambah <i class="fas fa-plus"></i></a>
        </div>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-striped table-md">
            <tbody>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Hire Date</th>
                <th>Job</th>
                <th>Salary</th>
                <th>Commision</th>
                <th>Manager</th>
                <th>Departmen</th>
                <th>Action</th>
              </tr>
              @foreach($employees as $emp)
                <tr>
                  <td>{{ $emp->employee_id }}</td>
                  <td>{{ $emp->full_name }}</td>
                  <td>{{ $emp->email }}</td>
                  <td>{{ $emp->phone_number }}</td>
                  <td>{{ Carbon::parse($emp->hire_date)->format('Y-M-d') }}</td>
                  <td>{{ $emp->job_title }}</td>
                  <td>{{ $emp->salary }}</td>
                  <td>{{ $emp->commission_pct == NULL ? '0' : $emp->commission_pct }}</td>
                  <td>{{ $emp->manager_name == NULL ? 'NULL' : $emp->manager_name }}</td>
                  <td>{{ $emp->department_name }}</td>
                  <td>
                    <a href="{{ route('employees.edit', ['employee_id' => $emp->employee_id]) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('employees.destroy', ['first_name' => $emp->first_name, 'last_name' => $emp->last_name, 'job_id' => $emp->job_id]) }}" method="POST" class="d-inline">
                      @csrf
                      @method('DELETE')
                      <button class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
      <div class="card-footer text-right">
        <nav class="d-inline-block">
          <ul class="pagination mb-0">
            <li class="page-item disabled">
              <a class="page-link" href="#" tabindex="-1"><i class="fas fa-chevron-left"></i></a>
            </li>
            <li class="page-item active"><a class="page-link" href="#">1 <span class="sr-only">(current)</span></a></li>
            <li class="page-item">
              <a class="page-link" href="#">2</a>
            </li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item">
              <a class="page-link" href="#"><i class="fas fa-chevron-right"></i></a>
            </li>
          </ul>
        </nav>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
  <script src="{{ asset('assets/modules/jquery-ui.min.js') }}"></script>
  <script src="{{ asset('assets/js/components-table.js') }}"></script>
@endpush