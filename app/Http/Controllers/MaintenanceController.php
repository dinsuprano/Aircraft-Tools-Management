<?php

namespace App\Http\Controllers;

use App\Models\Maintenance;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    public function index()
    {
        $maintenances = Maintenance::with('tool')->orderBy('created_at', 'desc')->paginate(10);
        return view('maintenance.index', compact('maintenances'));
    }

    public function create()
    {
        $tools = \App\Models\Tool::where('status', 'Available')->get();
        return view('maintenance.create', compact('tools'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'barcode' => 'required|exists:tools,barcode',
            'problem' => 'required|string',
            'date_report' => 'required|date'
        ]);

        $tool = \App\Models\Tool::where('barcode', $validated['barcode'])->first();
        
        if ($tool->status !== 'Available') {
            return back()->withErrors(['barcode' => 'This tool is currently out of stock or already under maintenance.']);
        }

        Maintenance::create($validated);
        
        $tool->update(['status' => 'Maintenance']);

        return redirect()->route('maintenance.index')->with('success', 'Tool reported for maintenance.');
    }

    public function show(string $id)
    {
        // To be implemented
    }

    public function edit(Maintenance $maintenance)
    {
        return view('maintenance.edit', compact('maintenance'));
    }

    public function update(Request $request, Maintenance $maintenance)
    {
        $validated = $request->validate([
            'solution' => 'required|string',
            'date_released' => 'required|date'
        ]);

        $maintenance->update($validated);

        // Tool is released, increment quantity
        $tool = \App\Models\Tool::where('barcode', $maintenance->barcode)->first();
        if ($tool) {
            $tool->update(['status' => 'Available']);
        }

        return redirect()->route('maintenance.index')->with('success', 'Maintenance completed and tool released.');
    }

    public function destroy(Maintenance $maintenance)
    {
        if (empty($maintenance->date_released)) {
            // If deleted before release, restore the tool quantity
            $tool = \App\Models\Tool::where('barcode', $maintenance->barcode)->first();
            if ($tool) {
                $tool->update(['status' => 'Available']);
            }
        }
        $maintenance->delete();

        return redirect()->route('maintenance.index')->with('success', 'Maintenance log deleted successfully.');
    }
}
