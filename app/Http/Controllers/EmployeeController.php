<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::all();
        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        // To be implemented
    }

    public function store(Request $request)
    {
        // To be implemented
    }

    public function show(string $id)
    {
        // To be implemented
    }

    public function edit(string $id)
    {
        // To be implemented
    }

    public function update(Request $request, string $id)
    {
        // To be implemented
    }

    public function destroy(string $id)
    {
        // To be implemented
    }
}
