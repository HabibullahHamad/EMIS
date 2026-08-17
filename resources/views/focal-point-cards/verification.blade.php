<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ in_array(app()->getLocale(), ['ps','fa'], true) ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('emis.card_verification') }}</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/all.min.css') }}">
    <style>
        body{min-height:100vh;margin:0;display:grid;place-items:center;padding:20px;background:#edf2f7;font-family:Tahoma,Arial,sans-serif;color:#172033}.verify-card{width:min(100%,620px);background:#fff;border:1px solid #dce4ee;border-radius:18px;box-shadow:0 18px 48px rgba(24,52,86,.13);overflow:hidden}.verify-head{padding:24px;text-align:center;color:#fff;background:#173f73}.verify-icon{display:grid;place-items:center;width:64px;height:64px;margin:0 auto 10px;border-radius:50%;background:rgba(255,255,255,.16);font-size:28px}.verify-body{padding:26px}.verify-row{display:flex;justify-content:space-between;gap:20px;padding:11px 0;border-bottom:1px solid #edf0f4}.verify-row:last-child{border:0}.verify-label{color:#68768b;font-size:13px}.verify-value{font-weight:700;text-align:end}.valid{color:#16845b}.invalid{color:#c33d4a}
    </style>
</head>
<body>
<main class="verify-card">
    <header class="verify-head"><div class="verify-icon"><i class="fa-solid {{ $card->is_valid ? 'fa-circle-check' : 'fa-circle-xmark' }}"></i></div><h1 class="h4 mb-1">{{ __('emis.card_verification') }}</h1><div class="{{ $card->is_valid ? 'valid' : 'invalid' }} bg-white rounded-pill d-inline-block px-3 py-1 fw-bold">{{ $card->is_valid ? __('emis.valid_card') : __('emis.invalid_card') }}</div></header>
    <section class="verify-body">
        @foreach([
            __('emis.card_number') => $card->card_number,
            __('emis.full_name') => $card->focalPoint?->display_name,
            __('emis.father_name') => $card->focalPoint?->father_name,
            __('emis.job_title') => $card->focalPoint?->job_title,
            __('emis.budget_entity') => $card->focalPoint?->budgetEntity?->display_name,
            __('emis.fiscal_year') => $card->fiscal_year,
            __('emis.issue_date') => optional($card->issue_date)->format('Y-m-d'),
            __('emis.expiry_date') => optional($card->expiry_date)->format('Y-m-d'),
            __('emis.status') => __('emis.' . $card->card_status),
            __('emis.verification_code') => $card->verification_uuid,
        ] as $label => $value)
            <div class="verify-row"><span class="verify-label">{{ $label }}</span><span class="verify-value">{{ filled($value) ? $value : '—' }}</span></div>
        @endforeach
    </section>
</main>
</body></html>
