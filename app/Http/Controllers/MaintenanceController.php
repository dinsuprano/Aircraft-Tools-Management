<?php

namespace App\Http\Controllers;

use App\Models\Maintenance;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    public function index()
    {
        $maintenances = Maintenance::with('tool')->orderBy('created_at', 'desc')->get();
        return view('maintenance.index', compact('maintenances'));
    }

    public function create()
    {
        $tools = \App\Models\Tool::where('available_quantity', '>', 0)->get();
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
        
        if ($tool->available_quantity <= 0) {
            return back()->withErrors(['barcode' => 'This tool is currently out of stock or already under maintenance.']);
        }

        Maintenance::create($validated);
        
        $tool->decrement('available_quantity');

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
            $tool->increment('available_quantity');
        }

        return redirect()->route('maintenance.index')->with('success', 'Maintenance completed and tool released.');
    }

    public function destroy(Maintenance $maintenance)
    {
        if (empty($maintenance->date_released)) {
            // If deleted before release, restore the tool quantity
            $tool = \App\Models\Tool::where('barcode', $maintenance->barcode)->first();
            if ($tool) {
                $tool->increment('available_quantity');
            }
        }
        $maintenance->delete();

        return redirect()->route('maintenance.index')->with('success', 'Maintenance log deleted successfully.');
    }
}
