<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class EmployeeAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'Employee Admin');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $query->latest();

        $employeeAdmins = $query->paginate(10);
        $employeeAdmins->appends($request->all());

        return view('admin.employee_admins.index', compact('employeeAdmins'));
    }

    public function toggleApproval(User $user)
    {
        if ($user->role !== 'Employee Admin') {
            abort(403, 'You can only modify Employee Admins.');
        }

        $user->is_approved = !$user->is_approved;
        $user->save();

        $status = $user->is_approved ? 'approved' : 'revoked';
        return back()->with('success', "Access for {$user->name} has been {$status}.");
    }

    public function destroy(User $user)
    {
        if ($user->role !== 'Employee Admin') {
            abort(403, 'You can only delete Employee Admins.');
        }

        $user->delete();
        
        return back()->with('success', 'Application deleted successfully.');
    }
}
