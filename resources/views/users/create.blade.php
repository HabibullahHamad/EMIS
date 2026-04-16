@extends('new')

@section('content')

<style>
    .form-card {
        background: #fff;
        border-radius: 12px;
        padding: 18px;
        box-shadow: 0 1px 8px rgba(0,0,0,0.08);
    }

    .form-label {
        font-size: 13px;
        font-weight: 600;
    }

    .section-title {
        font-size: 14px;
        font-weight: 700;
        margin-bottom: 10px;
        color: #334155;
    }
</style>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <h5 class="mb-0">{{ __('emis.create_users') }}</h5>
        <a href="{{ route('users.index') }}" class="btn btn-sm btn-secondary">
            {{ __('emis.back') }}
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger py-2">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li style="font-size:13px;">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="form-card">
        <form action="{{ route('users.store') }}" method="POST">
            @csrf

            <div class="section-title">{{ __('emis.create_users') }}</div>

            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">{{ __('emis.name') }}</label>
                    <input
                        type="text"
                        name="name"
                        class="form-control"
                        value="{{ old('name') }}"
                        required
                    >
                </div>

                <div class="col-md-4">
                    <label class="form-label">{{ __('emis.email') }}</label>
                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        value="{{ old('email') }}"
                        required
                    >
                </div>

                <div class="col-md-4">
                    <label class="form-label">{{ __('emis.roles') }}</label>
                <select name="role_id" class="form-select form-select-sm">
             <option value="">{{ __('emis.all') }} {{ __('emis.roles') }}</option>
           @foreach($roles ?? [] as $role)
             <option value="{{ $role->id }}" {{ request('role_id') == $role->id ? 'selected' : '' }}>
            {{ $role->display_name ?? $role->name }}
             </option>
            @endforeach
               </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">{{ __('emis.password') }}</label>
                    <input
                        type="password"
                        name="password"
                        class="form-control"
                        required >
                </div>

                <div class="col-md-6">
                    <label class="form-label">{{ __('emis.password_confirmation') }}</label>
                    <input
                        type="password"
                        name="password_confirmation"
                        class="form-control"
                        required
                    >
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    {{ __('emis.save') }}
                </button>

                <a href="{{ route('users.index') }}" class="btn btn-secondary">
                    {{ __('emis.cancel') }}
                </a>
            </div>
        </form>
    </div>
</div>

@endsection