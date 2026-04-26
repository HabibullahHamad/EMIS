<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Exports\EmployeesExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\User;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $query = Employee::query();

        if ($request->search) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', '%' . $search . '%')
                  ->orWhere('employee_code', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('phone', 'like', '%' . $search . '%');
            });
        }

        if ($request->status) {
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
// create method 
public function create()
{
    $users = User::doesntHave('employee')->orderBy('name')->get();

    return view('employees.create', compact('users'));
}
       
// logs capturing for create method



// end method  for creat 
   
    public function store(Request $request)
    {
    
     $request->validate([
    'user_id'        => 'nullable|exists:users,id',
    'employee_code'  => 'required|unique:employees,employee_code',
    'first_name'     => 'required|string|max:100',
    'last_name'      => 'required|string|max:100',
    'email'          => 'nullable|email',
    'phone'          => 'nullable|string|max:30',
    'photo'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    'status'         => 'required|string',
]);
$employee = Employee::create([
        'employee_code' => $request->employee_code,
        'first_name' => $request->first_name,
        'last_name' => $request->last_name,
        'full_name' => trim($request->first_name . ' ' . $request->last_name),
        'email' => $request->email,
        'phone' => $request->phone,
        'department_id' => $request->department_id,
        'position_id' => $request->position_id,
        'status' => $request->status ?? 'active',
    ]);

    audit_log('created', $employee, null, $employee->toArray());

    return redirect()->route('employees.index')
        ->with('success', 'Employee created successfully.');

// 
        // end 

        $data = $request->all();
        $data['full_name'] = trim($request->first_name . ' ' . $request->last_name);
        $data['status'] = strtolower($request->status);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('employees', 'public');
        }

        Employee::create($data);

       
            return redirect()->route('employees.index')
    ->with('success', __('messages.employee_created'));
    }

// logs

// end


    public function show(Employee $employee)
    {
        return view('employees.show', compact('employee'));
    }
// edit method for rmployeee
public function edit(Employee $employee)
{
    $users = User::whereDoesntHave('employee')
        ->orWhere('id', $employee->user_id)
        ->orderBy('name')
        ->get();

    return view('employees.edit', compact('employee', 'users'));
}

// end of method
  

    public function update(Request $request, Employee $employee)
    {
     $request->validate([
                
    'user_id'        => 'nullable|exists:users,id',
    'employee_code'  => 'required|unique:employees,employee_code',
    'first_name'     => 'required|string|max:100',
    'last_name'      => 'required|string|max:100',
    'email'          => 'nullable|email',
    'phone'          => 'nullable|string|max:30',
    'photo'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    'status'         => 'required|string',
]);

// logs/////////////////////////////////////////////////////////////////////////////////////

{
    $oldValues = $employee->getOriginal();

    $employee->update([
        'employee_code' => $request->employee_code,
        'first_name' => $request->first_name,
        'last_name' => $request->last_name,
        'full_name' => trim($request->first_name . ' ' . $request->last_name),
        'email' => $request->email,
        'phone' => $request->phone,
        'department_id' => $request->department_id,
        'position_id' => $request->position_id,
        'status' => $request->status ?? 'active',
    ]);

    audit_log('updated', $employee, $oldValues, $employee->getChanges());

    return redirect()->route('employees.index')
        ->with('success', 'Employee updated successfully.');
}



// end logs/////////////////////////////////////////////////////////////////////////////////////
        $data = $request->all();
        $data['full_name'] = trim($request->first_name . ' ' . $request->last_name);
        $data['status'] = strtolower($request->status);

        if ($request->hasFile('photo')) {
            if ($employee->photo && Storage::disk('public')->exists($employee->photo)) {
                Storage::disk('public')->delete($employee->photo);
            }

            $data['photo'] = $request->file('photo')->store('employees', 'public');
        }
// employee update messege 
        $employee->update($data);

        return redirect()->route('employees.index')
          
           
             ->with('success', __('messages.employee_updated'));
            
    }


    // employee delete messege 


    public function destroy(Employee $employee)
    {
        if ($employee->photo && Storage::disk('public')->exists($employee->photo)) {
            Storage::disk('public')->delete($employee->photo);
        }

// logs ////////////////////////////////////////////////////
$oldValues = $employee->toArray();

audit_log('deleted', $employee, $oldValues, null);
// end logs ////////////////////////////////////////////////////
$employee->delete();

        return redirect()->route('employees.index')
              
                 ->with('success', __('messages.employee_deleted'));
    }
    
// employee status updat messeage 
    public function toggleStatus(Employee $employee)
    {
        $employee->status = strtolower($employee->status) === 'active' ? 'inactive' : 'active';
        $employee->save();

        return redirect()->route('employees.index')
            
                  ->with('success', __('messages.employee_stutus'));
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(
            new EmployeesExport($request),
            'EMIS-EMP_report.xlsx'
        );
    }

  public function exportPdf(Request $request)
{
    $query = Employee::query();

    if ($request->search) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('full_name', 'like', '%' . $search . '%')
              ->orWhere('employee_code', 'like', '%' . $search . '%')
              ->orWhere('email', 'like', '%' . $search . '%')
              ->orWhere('phone', 'like', '%' . $search . '%');
        });
    }

    if ($request->status) {
        $query->whereRaw('LOWER(status) = ?', [strtolower($request->status)]);
    }

    $employees = $query->latest()->get();

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

    return view('employees.monitoring', compact('employee', 'taskStats'));
}

}