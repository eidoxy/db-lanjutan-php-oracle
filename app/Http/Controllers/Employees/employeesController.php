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
                e.email,
                e.phone_number,
                e.hire_date,
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

        return view('employees.create', compact('managers', 'departments'));
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

        return view('employees.edit', compact('employee', 'managers', 'departments'));
    }
}
