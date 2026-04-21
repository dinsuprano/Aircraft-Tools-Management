<?php

namespace App\Http\Controllers;

use App\Models\BorrowTool;
use Illuminate\Http\Request;

class BorrowController extends Controller
{
    public function index()
    {
        $borrows = BorrowTool::all();
        return view('borrows.index', compact('borrows'));
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
