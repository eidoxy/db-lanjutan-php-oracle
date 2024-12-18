@extends('layouts.app')

@section('title', 'Employees')

@section('header', 'Employees Table')

@section('breadcrumb')
  <div class="breadcrumb-item active"><a href="{{ route('employees.index') }}">Employees</a></div>
  <div class="breadcrumb-item">Create</div>
@endsection

@section('content')
  <div class="row d-flex justify-content-center">
      <div class="col-12 col-md-8 col-lg-8">
          <div class="card">
              <div class="card-header">
                  <h4>Create Employee</h4>
              </div>
              <div class="card-body">
                  <form action="{{ route('employees.store') }}" method="POST">
                      @csrf
                      <div class="form-group">
                          <label for="employee_id">Employee ID</label>
                          <input type="number" name="employee_id" class="form-control" required>
                      </div>
                      <div class="row">
                        <div class="col-6 col-md-6 col-lg-6 form-group">
                            <label for="first_name">First Name</label>
                            <input type="text" name="first_name" class="form-control" maxlength="20" required>
                        </div>
                        <div class="col-6 col-md-6 col-lg-6 form-group">
                            <label for="last_name">Last Name</label>
                            <input type="text" name="last_name" class="form-control" maxlength="25" required>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6 col-lg-6 form-group">
                            <label for="email">Email</label>
                            <input type="text" name="email" class="form-control" maxlength="25" required>
                        </div>
                        <div class="col-md-6 col-lg-6 form-group">
                            <label for="phone_number">Phone Number</label>
                            <input type="text" name="phone_number" class="form-control" maxlength="20" required>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6 col-lg-6 form-group">
                            <label for="hire_date">Hire Date</label>
                            <input type="date" name="hire_date" class="form-control" required>
                        </div>
                        <div class="col-md-6 col-lg-6 form-group">
                            <label for="job_id">Job</label>
                            <select name="job_id" class="form-control" required>
                                @foreach($jobs as $job)
                                    <option value="{{ $job->job_id }}">{{ $job->job_title }}</option>
                                @endforeach
                            </select>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6 col-lg-6 form-group">
                            <label for="salary">Salary</label>
                            <input type="number" step="0.01" name="salary" class="form-control" placeholder="1000" required>
                        </div>
                        <div class="col-md-6 col-lg-6 form-group">
                            <label for="commission_pct">Commission PCT</label>
                            <input type="number" step="0.01" name="commission_pct" class="form-control" placeholder="0.1">
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6 col-lg-6 form-group">
                            <label for="manager_id">Manager</label>
                            <select name="manager_id" class="form-control">
                                <option value="">Select Manager</option>
                                @foreach($managers as $manager)
                                    <option value="{{ $manager->employee_id }}">{{ $manager->full_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 col-lg-6 form-group">
                            <label for="department_id">Department</label>
                            <select name="department_id" class="form-control" required>
                                <option value="">Select Department</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->department_id }}">{{ $department->department_name }}</option>
                                @endforeach
                            </select>
                        </div>
                      </div>
                      <div class="gap-4">
                        <button type="submit" class="btn btn-primary col-12 mb-2">Submit</button>
                        <a class="btn btn-danger col-12" href="{{ route('employees.index') }}">Kembali</a>
                      </div>
                  </form>
              </div>
          </div>
      </div>
  </div>
@endsection