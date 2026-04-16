@extends('new')

@section('content')

<style>
    .page-card {
        background: #fff;
        border-radius: 12px;
        padding: 16px;
        box-shadow: 0 1px 8px rgba(0,0,0,0.08);
    }

    .table-emis {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
        box-shadow: 0 0 5px rgba(173, 216, 230, 0.7);
    }

    .table-emis thead {
        background-color: #074582;
        color: #fff;
    }

    .table-emis thead th {
        padding: 8px 10px;
        text-align: right;
        font-weight: 700;
        border-bottom: 2px solid #dee2e6;
    }

    .table-emis tbody td {
        padding: 8px 10px;
        text-align: right;
        vertical-align: middle;
    }

    .table-emis tbody tr:nth-child(even) {
        background: #fff;
    }

    .table-emis tbody tr:hover {
        background: #f4f5f7;
    }

    .tb {
        background-color: #074582;
        padding: 4px 10px;
        border-radius: 6px;
        color: #fff;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-right: 4px;
    }

    .tb:hover {
        color: #fff;
        background: #0b5aa5;
    }

    .role-badge {
        display: inline-block;
        padding: 3px 8px;
        border-radius: 999px;
        background: #e9f2ff;
        color: #074582;
        font-size: 12px;
        font-weight: 600;
    }

    .custom-pagination .page-link {
        color: #0d6efd;
        border-radius: 6px;
        padding: 3px 10px;
        margin-top: 6px;
    }

    .custom-pagination .page-item.active .page-link {
        background-color: #0d6efd;
        border-color: #0d6efd;
        color: #fff !important;
    }

    .custom-pagination .page-link:hover {
        background-color: #e9f0ff;
    }
</style>

<div class="container-fluid">
    <div class="page-card">
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
            <h5 class="mb-0">{{ __('emis.user_management') }}</h5>

            @if(auth()->user()->canAccess('users.create'))
                <a href="{{ route('users.create') }}" class="tb" title="{{ __('emis.create') }}">
                    <i class="fa fa-plus"></i>
                </a>
            @endif
        </div>

        <form method="GET" action="{{ route('users.index') }}" class="row g-2 mb-3">
            <div class="col-md-4">
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       class="form-control"
                       placeholder="{{ __('emis.search') }}">
            </div>

            <div class="col-md-3">
                <select name="role_id" class="form-select form-select-sm">
                    <option value="">{{ __('emis.all') }} {{ __('emis.roles') }}</option>
                    @foreach($roles ?? [] as $role)
                        <option value="{{ $role->id }}" {{ request('role_id') == $role->id ? 'selected' : '' }}>
                            {{ $role->display_name ?? $role->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fa fa-search"></i> {{ __('emis.search') }}
                </button>
            </div>

            <div class="col-md-2">
                <a href="{{ route('users.index') }}" class="btn btn-secondary w-100">
                    {{ __('emis.cancel') }}
                </a>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table-emis">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ __('emis.name') }}</th>
                        <th>{{ __('emis.email') }}</th>
                        <th>{{ __('emis.roles') }}</th>
                        <th>{{ __('emis.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>
                                {{ $loop->iteration + (($users->currentPage() - 1) * $users->perPage()) }}
                            </td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="role-badge">
                                    {{ $user->role->display_name ?? $user->role->name ?? '-' }}
                                </span>
                     <td>
    {{-- VIEW --}}
    @if(auth()->user()->canAccess('users.view'))
        <a href="{{ route('users.show', $user->id) }}"
           class="text-info me-2"
           title="{{ __('emis.view') }}">
            <i class="fa-solid fa-eye"></i>
        </a>
    @endif

    {{-- EDIT --}}
    @if(auth()->user()->canAccess('users.edit'))
        <a href="{{ route('users.edit', $user->id) }}"
           class="text-warning me-2"
           title="{{ __('emis.edit') }}">
            <i class="fa-solid fa-pen"></i>
        </a>
    @endif

    {{-- DELETE --}}
    @if(auth()->user()->canAccess('users.delete'))
        |
        <form action="{{ route('users.destroy', $user->id) }}"
              method="POST"
              class="d-inline delete-form">
            @csrf
            @method('DELETE')

            <a href="javascript:void(0)"
               class="text-danger delete-btn"
               title="{{ __('emis.delete') }}">
                <i class="fa-solid fa-trash"></i>
            </a>
        </form>
    @endif
</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">
                                {{ __('emis.no_data_found') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users instanceof \Illuminate\Contracts\Pagination\Paginator || $users instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator)
            @if($users->hasPages())
                <nav>
                    <ul class="pagination justify-content-center custom-pagination">
                        @if($users->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link">«</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $users->previousPageUrl() }}">«</a>
                            </li>
                        @endif

                        @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                            @if ($page == $users->currentPage())
                                <li class="page-item active">
                                    <span class="page-link">{{ $page }}</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endif
                        @endforeach

                        @if($users->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $users->nextPageUrl() }}">»</a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <span class="page-link">»</span>
                            </li>
                        @endif
                    </ul>
                </nav>
            @endif
        @endif
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('click', function (e) {
    const btn = e.target.closest('.delete-btn');
    if (!btn) return;

    const form = btn.closest('form');
    const row = btn.closest('tr');

    Swal.fire({
        title: "{{ __('emis.are_you_sure') }}",
        text: "{{ __('emis.cannot_undo') }}",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: "{{ __('emis.yes_delete') }}",
        cancelButtonText: "{{ __('emis.cancel') }}"
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: new FormData(form)
            })
            .then(res => {
                if (!res.ok) throw new Error('Delete failed');
                row.remove();

                Swal.fire(
                    "{{ __('emis.success') }}",
                    "{{ __('emis.record_deleted') }}",
                    'success'
                );
            })
            .catch(() => {
                Swal.fire(
                    "{{ __('emis.error') }}",
                    "{{ __('emis.something_went_wrong') }}",
                    'error'
                );
            });
        }
    });
});
</script>

@endsection