<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Exports\EmployeesExport;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $query = Employee::query();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('employee_code', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->whereRaw('LOWER(status) = ?', [strtolower($request->status)]);
        }

        $employees = $query->latest()->paginate(8)->withQueryString();

        $stats = [
            'total' => Employee::count(),
            'active' => Employee::whereRaw('LOWER(status) = ?', ['active'])->count(),
            'inactive' => Employee::whereRaw('LOWER(status) = ?', ['inactive'])->count(),
        ];

        if ($request->ajax()) {
            return view('employees.partials.rows', compact('employees'))->render();
        }

        return view('employees.index', compact('employees', 'stats'));
    }

    public function create()
    {
        $users = User::doesntHave('employee')->orderBy('name')->get();

        return view('employees.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'employee_code' => 'required|unique:employees,employee_code',
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'nullable|email|unique:employees,email',
            'phone' => 'nullable|string|max:30',
            'department_id' => 'nullable|exists:departments,id',
            'position_id' => 'nullable|exists:positions,id',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'required|string',
        ]);

        $photoPath = null;

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('employees', 'public');
        }

        $employee = Employee::create([
            'user_id' => $request->user_id,
            'employee_code' => $request->employee_code,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'full_name' => trim($request->first_name . ' ' . $request->last_name),
            'email' => $request->email,
            'phone' => $request->phone,
            'department_id' => $request->department_id,
            'position_id' => $request->position_id,
            'photo' => $photoPath,
            'status' => strtolower($request->status),
        ]);

        if (function_exists('audit_log')) {
            audit_log('created', $employee, null, $employee->toArray());
        }

        return redirect()->route('employees.index')
            ->with('success', __('messages.employee_created') ?? 'Employee created successfully.');
    }

    public function show(Employee $employee)
    {
        if (function_exists('audit_log')) {
            audit_log('viewed', $employee, null, $employee->toArray());
        }

        return view('employees.show', compact('employee'));
    }

    public function edit(Employee $employee)
    {
        $users = User::whereDoesntHave('employee')
            ->orWhere('id', $employee->user_id)
            ->orderBy('name')
            ->get();

        if (function_exists('audit_log')) {
            audit_log('edit_opened', $employee, null, $employee->toArray());
        }

        return view('employees.edit', compact('employee', 'users'));
    }

    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'employee_code' => 'required|unique:employees,employee_code,' . $employee->id,
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'nullable|email|unique:employees,email,' . $employee->id,
            'phone' => 'nullable|string|max:30',
            'department_id' => 'nullable|exists:departments,id',
            'position_id' => 'nullable|exists:positions,id',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'required|string',
        ]);

        $oldValues = $employee->getOriginal();

        $photoPath = $employee->photo;

        if ($request->hasFile('photo')) {
            if ($employee->photo && Storage::disk('public')->exists($employee->photo)) {
                Storage::disk('public')->delete($employee->photo);
            }

            $photoPath = $request->file('photo')->store('employees', 'public');
        }

        $employee->update([
            'user_id' => $request->user_id,
            'employee_code' => $request->employee_code,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'full_name' => trim($request->first_name . ' ' . $request->last_name),
            'email' => $request->email,
            'phone' => $request->phone,
            'department_id' => $request->department_id,
            'position_id' => $request->position_id,
            'photo' => $photoPath,
            'status' => strtolower($request->status),
        ]);

        if (function_exists('audit_log')) {
            audit_log('updated', $employee, $oldValues, $employee->getChanges());
        }

        return redirect()->route('employees.index')
            ->with('success', __('messages.employee_updated') ?? 'Employee updated successfully.');
    }

    public function destroy(Employee $employee)
    {
        $oldValues = $employee->toArray();

        if (function_exists('audit_log')) {
            audit_log('deleted', $employee, $oldValues, null);
        }

        if ($employee->photo && Storage::disk('public')->exists($employee->photo)) {
            Storage::disk('public')->delete($employee->photo);
        }

        $employee->delete();

        return redirect()->route('employees.index')
            ->with('success', __('messages.employee_deleted') ?? 'Employee deleted successfully.');
    }

    public function toggleStatus(Employee $employee)
    {
        $oldValues = $employee->getOriginal();

        $employee->status = strtolower($employee->status) === 'active' ? 'inactive' : 'active';
        $employee->save();

        if (function_exists('audit_log')) {
            audit_log('status_changed', $employee, $oldValues, $employee->getChanges());
        }

        return redirect()->route('employees.index')
            ->with('success', __('messages.employee_status') ?? 'Employee status updated successfully.');
    }

    public function exportExcel(Request $request)
    {
        if (function_exists('audit_log')) {
            audit_log('exported_excel', null, null, [
                'module' => 'employees',
                'filters' => $request->all(),
            ]);
        }

        return Excel::download(
            new EmployeesExport($request),
            'EMIS-EMP_report.xlsx'
        );
    }

    public function exportPdf(Request $request)
    {
        $query = Employee::query();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('employee_code', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->whereRaw('LOWER(status) = ?', [strtolower($request->status)]);
        }

        $employees = $query->latest()->get();

        if (function_exists('audit_log')) {
            audit_log('exported_pdf', null, null, [
                'module' => 'employees',
                'filters' => $request->all(),
                'total_records' => $employees->count(),
            ]);
        }

        $html = view('employees.report_pdf', compact('employees'))->render();

        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4-L',
            'default_font' => 'dejavusans',
            'autoScriptToLang' => true,
            'autoLangToFont' => true,
        ]);

        $mpdf->WriteHTML($html);

        return response($mpdf->Output('EMIS-EMP_report.pdf', 'S'), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="EMIS-EMP_report.pdf"',
        ]);
    }

    public function monitoring(Employee $employee)
    {
        $taskStats = [
            'total' => $employee->tasks()->count(),
            'completed' => $employee->tasks()->where('status', 'completed')->count(),
            'pending' => $employee->tasks()->where('status', 'pending')->count(),
            'in_progress' => $employee->tasks()->where('status', 'in_progress')->count(),
        ];

        if (function_exists('audit_log')) {
            audit_log('monitoring_viewed', $employee, null, [
                'employee' => $employee->toArray(),
                'task_stats' => $taskStats,
            ]);
        }

        return view('employees.monitoring', compact('employee', 'taskStats'));
    }
}