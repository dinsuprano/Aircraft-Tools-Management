<?php

namespace App\Http\Controllers;

use App\Models\Maintenance;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    public function index()
    {
        $maintenances = Maintenance::all();
        return view('maintenance.index', compact('maintenances'));
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
