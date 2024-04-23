<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Employee\{StoreRequest, UpdateRequest};
use App\Models\Employee;
use App\Models\Company;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::orderBy('created_at', 'desc')
            ->with('company')
            ->paginate(30);
        return Inertia::render('Employees/Index', compact('employees'));
    }

    public function create()
    {
        $companies = Company::orderBy('created_at', 'desc')->get();
        return Inertia::render('Employees/Create', compact('companies'));
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        Employee::create($data);
        return redirect()->route('employees.index')->with('success', 'Employee created successfully.');
    }

    public function show(Employee $employee)
    {
        $companies = Company::orderBy('created_at', 'desc')->get();
        return Inertia::render('Employees/Show', compact('employee', 'companies'));
    }

    public function edit(Employee $employee)
    {
        $companies = Company::orderBy('created_at', 'desc')->get();
        return Inertia::render('Employees/Edit', compact('employee', 'companies'));
    }

    public function update(UpdateRequest $request, Employee $employee)
    {
        $data = $request->validated();

        $employee->update($data);
        return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
    }
}
