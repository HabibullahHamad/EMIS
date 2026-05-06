@extends('new')

@section('content')
<style>
    
[dir="rtl"] .d-flex {
    flex-direction: row-reverse;
}
.search-row {
    display: flex;
    flex-wrap: nowrap;         /* force one line */
    gap: 8px;
    overflow-x: auto;          /* scroll if needed */
    align-items: flex-end;
}

/* each field block */
.search-row .field {
    display: flex;
    flex-direction: column;
    min-width: 130px;          /* fixed width */
}

/* smaller fields (date) */
.search-row .field.small {
    min-width: 100px;
}

/* inputs */
.search-row input {
    height: 32px;
    padding: 4px 8px;
    font-size: 10px;
}

/* labels */
.search-row label {
    font-size: 11px;
    margin-bottom: 2px;
    color: #555;
}

/* buttons */
.search-row .actions {
    display: flex;
    gap: 5px;
    align-items: flex-end;
    min-width: 140px;
}

</style>
<div class="container-fluid">

<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">

    {{-- LEFT --}}
    <div class="d-flex align-items-center gap-2">

        <a href="{{ route('documents.report') }}" 
           class="btn btn-success btn-sm d-flex align-items-center gap-1">
           <i class="fa fa-file-pdf"></i>
           {{ __('ExportPDF') }}
        </a>

        <a href="{{ route('documents.create') }}" 
           class="btn btn-primary btn-sm d-flex align-items-center gap-1">
            ➕ <span>{{ __('emis.register') }}</span>
        </a>

    </div>

    {{-- RIGHT --}}
    <h5 class="mb-0 fw-semibold text-muted">
        📄 {{ __('emis.title') }}
    </h5>

</div>
{{-- SEARCH --}}
<div class="card p-2 mb-3">

<form method="GET" class="search-row">

    <div class="field">
        <label>{{ __('emis.document_number') }}</label>
        <input type="text" name="number" value="{{ request('number') }}">
    </div>

    <div class="field">
        <label>{{ __('emis.type') }}</label>
        <input type="text" name="type" value="{{ request('type') }}">
    </div>

    <div class="field">
        <label>{{ __('emis.doc_title') }}</label>
        <input type="text" name="title" value="{{ request('title') }}">
    </div>

    <div class="field">
        <label>{{ __('emis.organization') }}</label>
        <input type="text" name="organization" value="{{ request('organization') }}">
    </div>

    <div class="field small">
        <label>{{ __('emis.from') }}</label>
        <input type="date" name="date_from" value="{{ request('date_from') }}">
    </div>

    <div class="field small">
        <label>{{ __('emis.to') }}</label>
        <input type="date" name="date_to" value="{{ request('date_to') }}">
    </div>

    <div class="actions">
        <button class="btn btn-dark btn-sm">
            {{ __('emis.search') }}
        </button>

        <button type="button" class="btn btn-secondary btn-sm"
            onclick="window.location='{{ route('documents.index') }}'">
            {{ __('emis.reset') }}
        </button>
    </div>

</form>

</div>

{{-- TABLE --}}
<div class="card">
<div class="table-responsive">

<table class="table table-bordered table-hover">

<thead class="table-light">
<tr>
    <th>#</th>
   
    <th>{{ __('emis.document_number') }}</th>
    <th>{{ __('emis.doc_title') }}</th>
    <th>{{ __('emis.type')}}</th>
    <th>{{ __('emis.organization') }}</th>
    <th>{{ __('emis.status') }}</th>
    <th>{{ __('emis.date') }}</th>
    <th width="160">{{ __('emis.actions') }}</th>
</tr>
</thead>

<tbody>

@forelse($documents as $doc)
<tr>
    <td>{{ $loop->iteration }}</td>

    <td>{{ $doc->document_number }}</td>

    <td>{{ $doc->title }}</td>
    <td>{{ $doc->type }}</td>

    <td>{{ $doc->organization }}</td>

    <td>
        <span class="badge 
            @if($doc->status=='completed') bg-success
            @elseif($doc->status=='responded') bg-warning
            @elseif($doc->status=='assigned') bg-primary
            @else bg-secondary
            @endif
        ">
            {{ __('emis.status_'.$doc->status) }}
        </span>
    </td>

    <td>{{ \Morilog\Jalali\Jalalian::fromCarbon(\Carbon\Carbon::parse($doc->received_date))->format('Y/m/d') }}</td>

<td class="text-nowrap">

<div class="dropdown">

    <button class="btn btn-sm btn-secondary dropdown-toggle" 
            type="button" 
            data-bs-toggle="dropdown" 
            aria-expanded="false">
        {{ __('emis.actions') }}
    </button>

    <ul class="dropdown-menu">

        <li>
            <a class="dropdown-item" href="{{ route('documents.show', $doc->id) }}">
                👁 {{ __('emis.view') }}
            </a>
        </li>

        <li>
            <a class="dropdown-item" href="{{ route('documents.view', $doc->id) }}">
                📄 {{ __('emis.view_pdf') }}
            </a>
        </li>

        <li>
            <a class="dropdown-item" href="{{ route('documents.edit', $doc->id) }}">
                ✏️ {{ __('emis.edit') }}
            </a>
        </li>

        <li><hr class="dropdown-divider"></li>

        <li>
            <form method="POST" action="{{ route('documents.destroy', $doc->id) }}">
                @csrf
                @method('DELETE')
                <button class="dropdown-item text-danger">
                    🗑 {{ __('emis.delete') }}
                </button>
            </form>
        </li>

    </ul>

</div>

</td>
</tr>
@empty
<tr>
    <td colspan="7" class="text-center">
        {{ __('emis.no_data') }}
    </td>
</tr>
@endforelse

</tbody>

</table>

</div>

<div class="p-2">
    {{ $documents->withQueryString()->links() }}
</div>

</div>

</div>

@endsection