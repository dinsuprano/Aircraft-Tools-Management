<?php

namespace App\Http\Controllers;

use App\Models\Tool;
use Illuminate\Http\Request;

class ToolController extends Controller
{
    public function index()
    {
        $tools = Tool::all();
        return view('tools.index', compact('tools'));
    }

    public function create()
    {
        return view('tools.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'barcode' => 'required|unique:tools',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string',
            'price' => 'nullable|numeric',
            'quantity' => 'nullable|integer',
            'status' => 'nullable|string'
        ]);

        $validated['available_quantity'] = $validated['quantity'] ?? 0;

        Tool::create($validated);

        return redirect()->route('tools.index')->with('success', 'Tool created successfully.');
    }

    public function edit(Tool $tool)
    {
        return view('tools.edit', compact('tool'));
    }

    public function update(Request $request, Tool $tool)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string',
            'price' => 'nullable|numeric',
            'quantity' => 'nullable|integer',
            'status' => 'nullable|string'
        ]);

        $tool->update($validated);

        return redirect()->route('tools.index')->with('success', 'Tool updated successfully.');
    }

    public function destroy(Tool $tool)
    {
        $tool->delete();
        return redirect()->route('tools.index')->with('success', 'Tool deleted successfully.');
    }
}
