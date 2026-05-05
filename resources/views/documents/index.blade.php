@extends('new')

@section('content')
<style>
    
[dir="rtl"] .d-flex {
    flex-direction: row-reverse;
}

</style>
<div class="container-fluid">

<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">

    {{-- LEFT --}}
    <div class="d-flex align-items-center gap-2">

        <a href="{{ route('documents.report') }}" 
           class="btn btn-success btn-sm d-flex align-items-center gap-1">
           <i class="fa fa-file-pdf"></i>
           {{ __('emis.export') }}
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
<div class="card p-3 mb-3"> 
        
<form method="GET" class="row g-2">

    <div class="col-md-2">
        <label class="form-label">{{ __('emis.document_number') }}</label>
        <input type="text" name="number" value="{{ request('number') }}" class="form-control">
    </div>

    <div class="col-md-2">
        <label class="form-label">{{ __('emis.doc_title') }}</label>
        <input type="text" name="title" value="{{ request('title') }}" class="form-control">
    </div>

    <div class="col-md-2">
        <label class="form-label">{{ __('emis.organization') }}</label>
        <input type="text" name="organization" value="{{ request('organization') }}" class="form-control">
    </div>

    <div class="col-md-2">
        <label class="form-label">{{ __('emis.from') }}</label>
        <input type="date" name="date_from" value="{{ request('date_from') }}" class="form-control">
    </div>

    <div class="col-md-2">
        <label class="form-label">{{ __('emis.to') }}</label>
        <input type="date" name="date_to" value="{{ request('date_to') }}" class="form-control">
    </div>

    <div class="col-md-2 d-grid">
        <button class="btn btn-dark">
            {{ __('emis.search') }}
        </button>
    </div>

    <div class="col-md-2 d-grid">
        <button type="button" class="btn btn-secondary" onclick="window.location='{{ route('documents.index') }}'">
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

    <td>{{ $doc->received_date }}</td>

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