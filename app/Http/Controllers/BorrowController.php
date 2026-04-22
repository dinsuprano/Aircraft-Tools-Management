<?php

namespace App\Http\Controllers;

use App\Models\BorrowTool;
use Illuminate\Http\Request;

class BorrowController extends Controller
{
    public function index(Request $request)
    {
        $query = BorrowTool::with(['tool', 'employee']);

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('employee', function ($q2) use ($search) {
                    $q2->where('name', 'like', "%{$search}%");
                })
                ->orWhereHas('tool', function ($q2) use ($search) {
                    $q2->where('name', 'like', "%{$search}%");
                })
                ->orWhere('barcode', 'like', "%{$search}%");
            });
        }

        if ($request->has('sort') && in_array($request->sort, ['barcode', 'check_out_date', 'actual_date_returned', 'status'])) {
            $direction = $request->direction === 'desc' ? 'desc' : 'asc';
            $query->orderBy($request->sort, $direction);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $borrows = $query->paginate(10);
        $borrows->appends($request->all());

        return view('borrows.index', compact('borrows'));
    }

    public function create()
    {
        $tools = \App\Models\Tool::where('status', 'Available')->get();
        $employees = \App\Models\Employee::all();
        return view('borrows.create', compact('tools', 'employees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'barcode' => 'required|exists:tools,barcode',
            'employee_id' => 'required|exists:employees,id',
            'check_out_date' => 'required|date',
            'status' => 'nullable|string'
        ]);

        $validated['status'] = $validated['status'] ?? 'Checked Out';

        $tool = \App\Models\Tool::where('barcode', $validated['barcode'])->first();
        
        if ($tool->status !== 'Available') {
            return back()->withErrors(['barcode' => 'This tool is currently out of stock or already checked out.']);
        }

        BorrowTool::create($validated);
        
        $tool->update(['status' => 'Not Available']);

        return redirect()->route('borrows.index')->with('success', 'Tool checked out successfully.');
    }

    public function show(string $id)
    {
        // To be implemented
    }

    public function edit(BorrowTool $borrow)
    {
        return view('borrows.edit', compact('borrow'));
    }

    public function update(Request $request, BorrowTool $borrow)
    {
        $validated = $request->validate([
            'check_in_date' => 'nullable|date',
            'actual_date_returned' => 'required|date',
            'status' => 'required|string'
        ]);

        $borrow->update($validated);

        if ($validated['status'] == 'Returned') {
            $tool = \App\Models\Tool::where('barcode', $borrow->barcode)->first();
            if ($tool) {
                $tool->update(['status' => 'Available']);
            }
        }

        return redirect()->route('borrows.index')->with('success', 'Tool checked in successfully.');
    }

    public function destroy(BorrowTool $borrow)
    {
        if ($borrow->status != 'Returned') {
            $tool = \App\Models\Tool::where('barcode', $borrow->barcode)->first();
            if ($tool) {
                $tool->update(['status' => 'Available']);
            }
        }
        $borrow->delete();

        return redirect()->route('borrows.index')->with('success', 'Borrow log deleted successfully.');
    }
}
