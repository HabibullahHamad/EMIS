@extends('new')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">{{ __('emis.create_employee') }}</h4>
            <a href="{{ route('employees.index') }}" class="btn btn-secondary">
                {{ __('emis.back') }}
            </a>
        </div>

        <div class="card-body">
            <form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">{{ __('emis.employee_code') }}</label>
                        <input type="text" name="employee_code" class="form-control" placeholder="{{ __('emis.employee_code') }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">{{ __('emis.first_name') }}</label>
                        <input type="text" name="first_name" class="form-control" placeholder="{{ __('emis.first_name') }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">{{ __('emis.last_name') }}</label>
                        <input type="text" name="last_name" class="form-control" placeholder="{{ __('emis.last_name') }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">{{ __('emis.email') }}</label>
                        <input type="email" name="email" class="form-control" placeholder="{{ __('emis.email') }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">{{ __('emis.phone') }}</label>
                        <input type="text" name="phone" class="form-control" placeholder="{{ __('emis.phone') }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">{{ __('emis.status') }}</label>
                        <select name="status" class="form-select">
                            <option value="active">{{ __('emis.active') }}</option>
                            <option value="inactive">{{ __('emis.inactive') }}</option>
                        </select>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">{{ __('emis.photo') }}</label>
                        <input type="file" name="photo" class="form-control">
                    </div>

                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-primary">
                            {{ __('emis.save') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection