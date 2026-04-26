<?php

namespace App\Exports;

use App\Models\AuditLog;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AuditLogsExport implements FromCollection, WithHeadings, WithMapping
{
    public function __construct(public Request $request) {}

    public function collection()
    {
        $query = AuditLog::with('user')->latest();

        if ($this->request->filled('search')) {
            $search = $this->request->search;

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

        if ($this->request->filled('action')) {
            $query->where('action', $this->request->action);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'User',
            'Action',
            'Module',
            'Record ID',
            'IP Address',
            'Date',
        ];
    }

    public function map($log): array
    {
        return [
            optional($log->user)->name ?? 'System',
            $log->action,
            $log->model_type ? class_basename($log->model_type) : '-',
            $log->model_id,
            $log->ip_address,
            optional($log->created_at)->format('Y-m-d H:i'),
        ];
    }
}