<style>
    .status-badge {
    display: inline-block;
    padding: 2px 10px;
    border-radius: 50px;
    font-size: 12px;
    font-weight: 600;
    color: #fff;
    min-width: 85px;
    text-align: center;
    transition: all 0.3s ease;
    box-shadow: 0 2px 4px rgba(0,0,0,0.08);
}

.status-badge:hover {
    transform: scale(1.06);
    opacity: 0.92;
}

.status-active {
    background: linear-gradient(135deg, #198754, #20c997);
}

.status-inactive {
    background: linear-gradient(135deg, #dc3545, #ff6b6b);
}

.status-other {
    background: linear-gradient(135deg, #6c757d, #9aa0a6);
}
.status-badge {
    display: inline-block;
    padding: 5px 12px;
    border-radius: 50px;   /* 👈 makes it fully rounded */
    font-size: 12px;
    font-weight: 600;
    color: #fff;
    min-width: 80px;
    text-align: center;
}

/* Colors */
.status-active {
    background-color: #28a745 !important;
}

.status-inactive {
    background-color: #dc3545 !important;
}

.status-other {
    background-color: #6c757d !important;
}

</style>
@forelse($employees as $employee)
    <tr>
        <td>{{ $employee->id }}</td>
        <td>{{ $employee->employee_code }}</td>
        <td>{{ $employee->full_name }}</td>
        <td>{{ $employee->email ?? '-' }}</td>
        <td>{{ $employee->phone ?? '-' }}</td>

        <td>
    @php
        $status = strtolower(trim($employee->status ?? ''));
    @endphp

    <form action="{{ route('employees.toggleStatus', $employee->id) }}" method="POST" style="display:inline-block;">
        @csrf
        @method('PATCH')

        <button type="submit" class="border-0 bg-transparent p-0">
            @if($status === 'active')
                <span class="status-badge status-active">Active</span>
            @elseif($status === 'inactive')
                <span class="status-badge status-inactive">Inactive</span>
            @else
                <span class="status-badge status-other">{{ $employee->status ?: 'N/A' }}</span>
            @endif
        </button>
        
    </form>
</td>

        <td>
            <img src="{{ $employee->photo_url }}" class="employee-photo" alt="photo">
        </td>

        <td class="action-btns">
            <a href="{{ route('employees.show', $employee->id) }}" class="btn btn-sm btn-info" title="View">👁</a>
            <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-sm btn-warning" title="Edit">✏️</a>

            <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" style="display:inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Delete this employee?')" class="btn btn-sm btn-danger" title="Delete">🗑</button>
            </form>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="8" class="text-center">No employees found.</td>
    </tr>
@endforelse