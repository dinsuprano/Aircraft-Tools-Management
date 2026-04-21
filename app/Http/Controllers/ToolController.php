<?php

namespace App\Http\Controllers;

use App\Models\Tool;
use Illuminate\Http\Request;

class ToolController extends Controller
{
    public function index()
    {
        $tools = Tool::latest()->paginate(10);
        return view('tools.index', compact('tools'));
    }

    public function create()
    {
        // Generate a random 13-digit barcode (e.g., 8285337507167)
        $barcode = mt_rand(100000, 999999) . mt_rand(1000000, 9999999);
        return view('tools.create', compact('barcode'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'barcode' => 'required|unique:tools',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string',
            'price' => 'nullable|numeric',
            'quantity_to_add' => 'required|integer|min:1',
            'status' => 'nullable|string'
        ]);

        $quantity = $validated['quantity_to_add'];
        unset($validated['quantity_to_add']);
        
        $validated['status'] = $validated['status'] ?? 'Available';

        for ($i = 0; $i < $quantity; $i++) {
            // Generate a unique barcode for each subsequent item
            if ($i > 0) {
                $validated['barcode'] = mt_rand(100000, 999999) . mt_rand(1000000, 9999999);
                // Ensure unique
                while (Tool::where('barcode', $validated['barcode'])->exists()) {
                    $validated['barcode'] = mt_rand(100000, 999999) . mt_rand(1000000, 9999999);
                }
            }
            Tool::create($validated);
        }

        return redirect()->route('tools.index')->with('success', $quantity . ' Tool(s) created successfully.');
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

    public function printBarcode(Tool $tool)
    {
        $tool->increment('print_count');
        
        $generator = new \Picqer\Barcode\BarcodeGeneratorSVG();
        $barcodeSvg = $generator->getBarcode($tool->barcode, $generator::TYPE_CODE_128);

        return view('tools.print', compact('tool', 'barcodeSvg'));
    }
}
