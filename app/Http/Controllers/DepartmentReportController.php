<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;


class DepartmentReportController extends Controller
{
    private array $allowedFields = [
        'id' => 'ID',
        'name' => 'English Name',
        'name_ps' => 'Pashto Name',
        'name_fa' => 'Dari Name',
        'code' => 'Code',
        'type' => 'Type',
        'level' => 'Level',
        'parent' => 'Parent Department',
        'status' => 'Status',
        'created_at' => 'Created Date',
    ];

    public function index()
    {
        $fields = $this->allowedFields;
        $parents = Department::orderBy('name')->get();

        return view('reports.departments.index', compact('fields', 'parents'));
    }

    public function preview(Request $request)
    {
        $data = $this->generateReport($request);

        return view('reports.departments.preview', $data);
    }
// pdf export 

public function exportPdf(Request $request)
{
    $data = $this->generateReport($request);

    $html = view('reports.departments.pdf', $data)->render();

    $mpdf = new \Mpdf\Mpdf([
        'mode' => 'utf-8',
        'format' => 'A4-L',
        'default_font' => 'dejavusans',
        'autoScriptToLang' => true,
        'autoLangToFont' => true,
        'margin_top' => 12,
        'margin_bottom' => 12,
        'margin_left' => 10,
        'margin_right' => 10,
    ]);

    $mpdf->SetDirectionality('rtl');
    $mpdf->WriteHTML($html);

    return response($mpdf->Output('department-report.pdf', 'S'))
        ->header('Content-Type', 'application/pdf');
}



    // end export
    private function generateReport(Request $request): array
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'report_date' => 'nullable|string|max:50',
            'prepared_by' => 'nullable|string|max:255',
            'orientation' => 'nullable|in:portrait,landscape',

            'fields' => 'required|array|min:1',
            'fields.*' => 'string',

            'type' => 'nullable|in:general_directorate,directorate,department',
            'status' => 'nullable|in:0,1',
            'parent_id' => 'nullable|exists:departments,id',

            'show_logo' => 'nullable|in:0,1',
            'show_prepared_by' => 'nullable|in:0,1',
            'show_date' => 'nullable|in:0,1',
        ]);

        $selectedFields = array_values(array_intersect(
            $request->fields,
            array_keys($this->allowedFields)
        ));

        $query = Department::with('parent')->latest();

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('parent_id')) {
            $query->where('parent_id', $request->parent_id);
        }

        $departments = $query->get();

        return [
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'report_date' => $request->report_date ?? now()->format('Y-m-d'),
            'prepared_by' => $request->prepared_by ?? auth()->user()?->name,
            'orientation' => $request->orientation ?? 'landscape',

            'show_logo' => (int) ($request->show_logo ?? 1),
            'show_prepared_by' => (int) ($request->show_prepared_by ?? 1),
            'show_date' => (int) ($request->show_date ?? 1),

            'fields' => $selectedFields,
            'fieldLabels' => $this->allowedFields,
            'departments' => $departments,
        ];
    }
}