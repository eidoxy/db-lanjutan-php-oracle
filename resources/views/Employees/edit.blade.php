@php
    use Carbon\Carbon;
@endphp

@extends('layouts.app')

@section('title', 'Employees')

@section('header', 'Edit Employee')

@section('breadcrumb')
  <div class="breadcrumb-item active"><a href="{{ route('employees.index') }}">Employees</a></div>
  <div class="breadcrumb-item">Edit</div>
@endsection

@section('content')
    <div class="row d-flex justify-content-center">
        <div class="col-12 col-md-8 col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4>Edit Employee</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('employees.update', ['employee_id' => $employee->employee_id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="employee_id">Employee ID</label>
                            <input type="number" name="employee_id" class="form-control" value="{{ $employee->employee_id }}" required readonly>
                        </div>
                        <div class="row">
                            <div class="col-6 col-md-6 col-lg-6 form-group">
                                <label for="first_name">First Name</label>
                                <input type="text" name="first_name" class="form-control" maxlength="20" value="{{ $employee->first_name }}" disabled required>
                            </div>
                            <div class="col-6 col-md-6 col-lg-6 form-group">
                                <label for="last_name">Last Name</label>
                                <input type="text" name="last_name" class="form-control" maxlength="25" value="{{ $employee->last_name }}" disabled required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-lg-6 form-group">
                                <label for="email">Email</label>
                                <input type="text" name="email" class="form-control" maxlength="25" value="{{ $employee->email }}" disabled required>
                            </div>
                            <div class="col-md-6 col-lg-6 form-group">
                                <label for="phone_number">Phone Number</label>
                                <input type="text" name="phone_number" class="form-control" maxlength="20" value="{{ $employee->phone_number }}" disabled required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-lg-6 form-group">
                                <label for="hire_date">Hire Date</label>
                                <input type="text" name="hire_date" class="form-control" value="{{ Carbon::parse($employee->hire_date)->format('Y-M-d') }}" disabled required>
                            </div>
                            <div class="col-md-6 col-lg-6 form-group">
                                <label for="job_id">Job ID</label>
                                <input type="text" name="job_id" class="form-control" value="{{ $employee_job->job_title }}" disabled required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-lg-6 form-group">
                                <label for="salary">Salary</label>
                                <input type="number" step="0.01" name="salary" class="form-control" placeholder="1000" value="{{ $employee->salary }}" required>
                            </div>
                            <div class="col-md-6 col-lg-6 form-group">
                                <label for="commission_pct">Commission PCT</label>
                                <input type="number" step="0.01" name="commission_pct" class="form-control" placeholder="0.1" value="{{ $employee->commission_pct }}" disabled required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-lg-6 form-group">
                                <label for="manager_id">Manager</label>
                                <select name="manager_id" class="form-control">
                                    <option value="">Select Manager</option>
                                    @foreach($managers as $manager)
                                        <option value="{{ $manager->employee_id }}" {{ $employee->manager_id == $manager->employee_id ? 'selected' : '' }}>{{ $manager->full_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 col-lg-6 form-group">
                                <label for="department_id">Department</label>
                                <input type="text" name="department_id" class="form-control" value="{{ $employee_department->department_name }}" disabled required>
                            </div>
                        </div>
                        <div class="gap-4">
                            <button type="submit" class="btn btn-warning col-12 mb-2">Update</button>
                            <a class="btn btn-danger col-12" href="{{ route('employees.index') }}">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection