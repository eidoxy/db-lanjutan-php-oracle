<?php

namespace App\Http\Controllers\Employees;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class employeesController extends Controller
{
    public function index()
    {
        $sql = "
            SELECT
                e.employee_id,
                e.first_name || ' ' || e.last_name AS full_name,
                e.first_name,
                e.last_name,
                e.email,
                e.phone_number,
                e.hire_date,
                e.job_id,
                j.job_title,
                e.salary,
                e.commission_pct,
                m.first_name || ' ' || m.last_name AS manager_name,
                d.department_name
            FROM
                employees e
            JOIN
                jobs j ON e.job_id = j.job_id
            JOIN
                departments d ON e.department_id = d.department_id
            LEFT JOIN
                employees m ON e.manager_id = m.employee_id
            ORDER BY
                e.employee_id DESC
        ";

        $employees = DB::connection()->select($sql);

        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        $managers = DB::table('employees')
        ->select(DB::raw("employee_id, first_name || ' ' || last_name AS full_name"))
        ->get();

        $departments = DB::table('departments')
        ->select('department_id', 'department_name')
        ->get();

        $jobs = DB::table('jobs')
        ->select('job_id', 'job_title')
        ->get();

        return view('employees.create', compact('managers', 'departments', 'jobs'));
    }

    public function store(Request $request)
    {
        $sql = "
            BEGIN
                manage_employees(
                    v_employee_id => :employee_id,
                    v_first_name => :first_name,
                    v_last_name => :last_name,
                    v_email => :email,
                    v_phone_number => :phone_number,
                    v_hire_date => TO_DATE(:hire_date, 'YYYY-MM-DD'),
                    v_job_id => :job_id,
                    v_salary => :salary,
                    v_commission_pct => :commission_pct,
                    v_manager_id => :manager_id,
                    v_department_id => :department_id,
                    v_operation => 'INSERT'
                );
            END;
        ";

        DB::connection()->statement($sql, [
            'employee_id' => $request->employee_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'hire_date' => $request->hire_date,
            'job_id' => $request->job_id,
            'salary' => $request->salary,
            'commission_pct' => $request->commission_pct,
            'manager_id' => $request->manager_id,
            'department_id' => $request->department_id,
        ]);

        return redirect()->route('employees.index')->with('success', 'Employee created successfully.');
    }

    public function edit($employee_id)
    {
        $employee = DB::table('employees')
        ->where('employee_id', $employee_id)
        ->first();

        $managers = DB::table('employees')
        ->select(DB::raw("employee_id, first_name || ' ' || last_name AS full_name"))
        ->get();

        $departments = DB::table('departments')
        ->select('department_id', 'department_name')
        ->get();

        $jobs = DB::table('jobs')
        ->select('job_id', 'job_title')
        ->get();

        $employee_job = DB::table('jobs')
        ->where('job_id', $employee->job_id)
        ->first();

        $employee_department = DB::table('departments')
        ->where('department_id', $employee->department_id)
        ->first();

        return view('employees.edit', compact('employee', 'managers', 'departments', 'employee_job', 'jobs', 'employee_department'));
    }

    public function update(Request $request)
    {
        $sql = "
            BEGIN
                manage_employees(
                    v_employee_id => :employee_id,
                    v_salary => :salary,
                    v_manager_id => :manager_id,
                    v_operation => 'UPDATE'
                );
            END;
        ";

        DB::connection()->statement($sql, [
            'employee_id' => $request->employee_id,
            'salary' => $request->salary,
            'manager_id' => $request->manager_id,
        ]);

        return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
    }

    public function destroy($first_name, $last_name, $job_id)
    {
        $sql = "
            BEGIN
                manage_employees(
                    v_first_name => :first_name,
                    v_last_name => :last_name,
                    v_job_id => :job_id,
                    v_operation => 'DELETE'
                );
            END;
        ";

        DB::connection()->statement($sql, [
            'first_name' => $first_name,
            'last_name' => $last_name,
            'job_id' => $job_id,
        ]);

        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
    }
}
