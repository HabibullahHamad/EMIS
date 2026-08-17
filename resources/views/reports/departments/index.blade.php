@extends('new')

@section('page_title', 'Department Report Builder')

@section('content')

<div class="container-fluid">

    <form method="POST" action="{{ route('department.reports.preview') }}">
        @csrf

        <div class="row">

            {{-- LEFT SIDE --}}
            <div class="col-md-4">

                <div class="card shadow-sm border-0 rounded-4 mb-3">
                    <div class="card-header bg-primary text-white rounded-top-4">
                        <strong>
                            <i class="fa fa-file-alt"></i>
                            Report Information
                        </strong>
                    </div>

                    <div class="card-body">

                        <div class="mb-3">
                            <label class="form-label">Report Title</label>
                            <input type="text" name="title" class="form-control"
                                   placeholder="د ریاستونو راپور" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Subtitle</label>
                            <input type="text" name="subtitle" class="form-control"
                                   placeholder="National Budget Directorate">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Report Date</label>
                            <input type="date" name="report_date" class="form-control"
                                   value="{{ date('Y-m-d') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Prepared By</label>
                            <input type="text" name="prepared_by" class="form-control"
                                   value="{{ auth()->user()->name ?? '' }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Report Orientation</label>
                            <select name="orientation" class="form-select">
                                <option value="landscape">Landscape</option>
                                <option value="portrait">Portrait</option>
                            </select>
                        </div>

                    </div>
                </div>

                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-header bg-dark text-white rounded-top-4">
                        <strong>
                            <i class="fa fa-filter"></i>
                            Filters
                        </strong>
                    </div>

                    <div class="card-body">

                        <div class="mb-3">
                            <label class="form-label">Department Type</label>
                            <select name="type" class="form-select">
                                <option value="">All Types</option>
                                <option value="general_directorate">General Directorate</option>
                                <option value="directorate">Directorate</option>
                                <option value="department">{{ __('emis.department') }}</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ __('emis.status') }}</label>
                            <select name="status" class="form-select">
                                <option value="">{{ __('emis.all_statuses') }}</option>
                                <option value="1">{{ __('emis.active') }}</option>
                                <option value="0">{{ __('emis.inactive') }}</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Parent Department</label>
                            <select name="parent_id" class="form-select">
                                <option value="">All Parents</option>
                                @foreach($parents as $parent)
                                    <option value="{{ $parent->id }}">
                                        {{ $parent->name_ps ?? $parent->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                </div>

            </div>

            {{-- RIGHT SIDE --}}
            <div class="col-md-8">

                <div class="card shadow-sm border-0 rounded-4 mb-3">
                    <div class="card-header bg-success text-white rounded-top-4 d-flex justify-content-between">
                        <strong>
                            <i class="fa fa-table-columns"></i>
                            Select Report Fields
                        </strong>

                        <div>
                            <button type="button" class="btn btn-sm btn-light" onclick="checkAllFields()">
                                Select All
                            </button>
                            <button type="button" class="btn btn-sm btn-warning" onclick="uncheckAllFields()">
                                Clear
                            </button>
                        </div>
                    </div>

                    <div class="card-body">

                        <div class="row">
                            @foreach($fields as $key => $label)
                                <div class="col-md-4 mb-3">
                                    <label class="field-card">
                                        <input type="checkbox" name="fields[]" value="{{ $key }}" checked>
                                        <span>
                                            <i class="fa fa-check-circle"></i>
                                            {{ $label }}
                                        </span>
                                    </label>
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>

                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-header bg-info text-white rounded-top-4">
                        <strong>
                            <i class="fa fa-gear"></i>
                            Report Options
                        </strong>
                    </div>

                    <div class="card-body">

                        <div class="row">

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Show Logo</label>
                                <select name="show_logo" class="form-select">
                                    <option value="1">{{ __('emis.yes') }}</option>
                                    <option value="0">{{ __('emis.no') }}</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Show Prepared By</label>
                                <select name="show_prepared_by" class="form-select">
                                    <option value="1">{{ __('emis.yes') }}</option>
                                    <option value="0">{{ __('emis.no') }}</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Show Date</label>
                                <select name="show_date" class="form-select">
                                    <option value="1">{{ __('emis.yes') }}</option>
                                    <option value="0">{{ __('emis.no') }}</option>
                                </select>
                            </div>

                        </div>

                        <hr>

                        <div class="d-flex justify-content-end gap-2">
                            <button class="btn btn-primary">
                                <i class="fa fa-eye"></i>
                                Preview Report
                            </button>

                            <button formaction="{{ route('department.reports.exportPdf') }}"
                                    class="btn btn-danger">
                                <i class="fa fa-file-pdf"></i>
                                Export PDF
                            </button>
                        </div>

                    </div>
                </div>

            </div>

        </div>

    </form>

</div>

<style>
    .field-card {
        display: block;
        border: 1px solid #d9e2ec;
        border-radius: 12px;
        padding: 12px;
        cursor: pointer;
        background: #fff;
        transition: .2s;
        min-height: 48px;
    }

    .field-card:hover {
        background: #f0f7ff;
        border-color: #0d6efd;
    }

    .field-card input {
        margin-left: 8px;
    }

    .field-card span {
        font-weight: 600;
        font-size: 13px;
    }
</style>

<script>
function checkAllFields() {
    document.querySelectorAll('input[name="fields[]"]').forEach(el => el.checked = true);
}

function uncheckAllFields() {
    document.querySelectorAll('input[name="fields[]"]').forEach(el => el.checked = false);
}
</script>

@endsection