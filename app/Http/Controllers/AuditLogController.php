<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function index(Request $request)
{
    $query = \App\Models\AuditLog::with('user')->latest();

    if ($request->filled('search')) {
        $search = $request->search;

        $query->where(function ($q) use ($search) {
            $q->where('action', 'like', "%{$search}%")
              ->orWhere('model_type', 'like', "%{$search}%")
              ->orWhere('ip_address', 'like', "%{$search}%")
              ->orWhereHas('user', function ($u) use ($search) {
                  $u->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
              });
        });
    }

    if ($request->filled('action')) {
        $query->where('action', $request->action);
    }

    $auditLogs = $query->paginate(15)->withQueryString();

    $stats = [
        'total' => \App\Models\AuditLog::count(),
        'created' => \App\Models\AuditLog::where('action', 'created')->count(),
        'updated' => \App\Models\AuditLog::where('action', 'updated')->count(),
        'deleted' => \App\Models\AuditLog::where('action', 'deleted')->count(),
        'today' => \App\Models\AuditLog::whereDate('created_at', today())->count(),
        'login' => \App\Models\AuditLog::where('action', 'login')->count(),
    ];

    return view('audit.index', compact('auditLogs', 'stats'));
}

    public function show(AuditLog $auditLog)
    {
        $auditLog->load('user');

        return view('audit.show', compact('auditLog'));
    }
    public function exportCsv(Request $request)
{
    $logs = $this->auditReportQuery($request)->get();

    $filename = 'EMIS-Audit-Logs-Report.csv';

    return response()->stream(function () use ($logs) {
        $file = fopen('php://output', 'w');

        fputcsv($file, ['User', 'Action', 'Module', 'Record ID', 'IP Address', 'Date']);

        foreach ($logs as $log) {
            fputcsv($file, [
                optional($log->user)->name ?? 'System',
                $log->action,
                $log->model_type ? class_basename($log->model_type) : '-',
                $log->model_id,
                $log->ip_address,
                optional($log->created_at)->format('Y-m-d H:i'),
            ]);
        }

        fclose($file);
    }, 200, [
        'Content-Type' => 'text/csv',
        'Content-Disposition' => "attachment; filename={$filename}",
    ]);
}

public function exportPdf(Request $request)
{
    $logs = $this->auditReportQuery($request)->get();

    $html = view('reports.audit_pdf', compact('logs'))->render();

    $mpdf = new \Mpdf\Mpdf([
        'mode' => 'utf-8',
        'format' => 'A4-L',
        'default_font' => 'dejavusans',
        'autoScriptToLang' => true,
        'autoLangToFont' => true,
    ]);

    $mpdf->WriteHTML($html);

    return response($mpdf->Output('EMIS-Audit-Logs-Report.pdf', 'S'), 200, [
        'Content-Type' => 'application/pdf',
        'Content-Disposition' => 'attachment; filename="EMIS-Audit-Logs-Report.pdf"',
    ]);
}

private function auditReportQuery(Request $request)
{
    $query = \App\Models\AuditLog::with('user')->latest();

    if ($request->filled('search')) {
        $search = $request->search;

        $query->where(function ($q) use ($search) {
            $q->where('action', 'like', "%{$search}%")
              ->orWhere('model_type', 'like', "%{$search}%")
              ->orWhere('ip_address', 'like', "%{$search}%")
              ->orWhereHas('user', function ($u) use ($search) {
                  $u->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
              });
        });
    }

    if ($request->filled('action')) {
        $query->where('action', $request->action);
    }

    return $query;
}
public function exportExcel(Request $request)
{
    return \Maatwebsite\Excel\Facades\Excel::download(
        new \App\Exports\AuditLogsExport($request),
        'EMIS-Audit-Logs-Report.xlsx'
    );
}
}