<style>
    .status-badge {
        display: inline-block;
        padding: 5px 12px;
        border-radius: 50px;
        font-size: 12px;
        font-weight: 600;
        color: #fff;
        min-width: 80px;
        text-align: center;
        transition: all 0.3s ease;
        box-shadow: 0 2px 4px rgba(0,0,0,0.08);
    }

    .status-badge:hover {
        transform: scale(1.06);
        opacity: 0.92;
    }

    .status-active {
        background-color: #6fa77c !important;
    }

    .status-inactive {
        background-color: #e4949c !important;
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
                        <span class="status-badge status-active">{{ __('emis.active') }}</span>
                    @elseif($status === 'inactive')
                        <span class="status-badge status-inactive">{{ __('emis.inactive') }}</span>
                    @else
                        <span class="status-badge status-other">{{ $employee->status ?: __('emis.not_available') }}</span>
                    @endif
                </button>
            </form>
        </td>

        <td class="action-btns">
            <a href="{{ route('employees.show', $employee->id) }}" class="btn btn-sm btn-info" title="{{ __('emis.view') }}">{{ __('emis.view') }}</a>
            <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-sm btn-warning" title="{{ __('emis.edit') }}">{{ __('emis.edit') }}</a>

            <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" style="display:inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('{{ __('emis.delete_employee_confirm') }}')" class="btn btn-sm btn-danger" title="{{ __('emis.delete') }}">{{ __('emis.delete') }}</button>
            </form>

            <a href="{{ route('employees.monitoring', $employee->id) }}"
               class="btn btn-sm btn-primary"
               title="{{ __('emis.monitoring') }}">
                {{ __('emis.monitoring') }}
            </a>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="7" class="text-center">{{ __('emis.no_employees_found') }}</td>
    </tr>
@endforelse
