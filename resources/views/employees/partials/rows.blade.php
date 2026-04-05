@forelse($employees as $employee)
    <tr>
        <td>{{ $employee->id }}</td>
        <td>
            <img src="{{ $employee->photo_url }}" class="employee-photo" alt="photo">
        </td>
        <td>{{ $employee->employee_code }}</td>
        <td>{{ $employee->full_name }}</td>
        <td>{{ $employee->email ?? '-' }}</td>
        <td>{{ $employee->phone ?? '-' }}</td>
        <td>
            @if($employee->status == 'active')
                <span class="badge bg-success">Active</span>
            @else
                <span class="badge bg-secondary">{{ ucfirst($employee->status) }}</span>
            @endif
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