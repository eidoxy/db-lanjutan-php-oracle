<?php

namespace App\Http\Controllers\Employees;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class employeesController extends Controller
{
    public function index()
    {
        return view('employees.index');
    }
}
