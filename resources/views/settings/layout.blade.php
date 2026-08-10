@extends('new')

@section(
    'page_title',
    __('emis.settings_center')
)

@section('content')

@php
    $currentLocale = app()->getLocale();

    $isRtl = in_array(
        $currentLocale,
        ['ps', 'fa'],
        true
    );
@endphp

<div
    class="settings-page"
    dir="{{ $isRtl ? 'rtl' : 'ltr' }}"
>

    {{-- =========================================================
         SETTINGS HEADER
         ========================================================= --}}

    <div class="settings-main-header">

        <div class="settings-main-header__icon">
            <i class="fa-solid fa-gear"></i>
        </div>

        <div class="settings-main-header__content">

            <h1 class="settings-main-title">
                {{ __('emis.settings_center') }}
            </h1>

            <p class="settings-main-description">
                {{ __('emis.settings_center_description') }}
            </p>

        </div>

    </div>


    {{-- =========================================================
         SETTINGS SHELL
         ========================================================= --}}

    <div class="settings-shell">

        {{-- Settings Navigation --}}
        <aside class="settings-sidebar">

            @include(
                'settings.partials.navigation'
            )

        </aside>


        {{-- Selected Settings Page --}}
        <main class="settings-content">

            {{-- Success message --}}
            @if(session('success'))

                <div
                    class="settings-alert
                           settings-alert-success"
                    role="alert"
                >

                    <div class="settings-alert-icon">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>

                    <div>
                        {{ session('success') }}
                    </div>

                </div>

            @endif


            {{-- Error message --}}
            @if(session('error'))

                <div
                    class="settings-alert
                           settings-alert-error"
                    role="alert"
                >

                    <div class="settings-alert-icon">
                        <i class="fa-solid fa-circle-exclamation"></i>
                    </div>

                    <div>
                        {{ session('error') }}
                    </div>

                </div>

            @endif


            {{-- Validation errors --}}
            @if($errors->any())

                @include(
                    'settings.partials.validation-errors'
                )

            @endif


            {{-- Section-specific page --}}
            @yield('settings-content')

        </main>

    </div>

</div>

@endsection


@push('styles')

<style>

    /*
    |--------------------------------------------------------------------------
    | Settings Center
    |--------------------------------------------------------------------------
    */

    .settings-page {
        width: 100%;
        max-width: 1500px;
        margin-inline: auto;
        padding: 4px 2px 30px;
    }


    /*
    |--------------------------------------------------------------------------
    | Main Header
    |--------------------------------------------------------------------------
    */

    .settings-main-header {
        display: flex;
        align-items: center;
        gap: 14px;

        margin-bottom: 20px;
        padding: 18px 20px;

        background: #ffffff;

        border: 1px solid #e5eaf1;
        border-radius: 14px;

        box-shadow:
            0 3px 12px
            rgba(15, 23, 42, 0.04);
    }

    .settings-main-header__icon {
        width: 46px;
        height: 46px;

        flex: 0 0 46px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 12px;

        background: #edf4ff;
        color: #173d7a;

        font-size: 20px;
    }

    .settings-main-header__content {
        min-width: 0;
    }

    .settings-main-title {
        margin: 0;

        font-size: 22px;
        font-weight: 700;

        color: #172033;
    }

    .settings-main-description {
        margin: 4px 0 0;

        color: #697586;

        font-size: 13px;
        line-height: 1.6;
    }


    /*
    |--------------------------------------------------------------------------
    | Two Column Layout
    |--------------------------------------------------------------------------
    */

    .settings-shell {
        display: grid;

        grid-template-columns:
            250px
            minmax(0, 1fr);

        gap: 20px;

        align-items: start;
    }


    /*
    |--------------------------------------------------------------------------
    | Internal Settings Navigation
    |--------------------------------------------------------------------------
    */

    .settings-sidebar {
        position: sticky;
        top: 18px;

        min-width: 0;

        background: #ffffff;

        border:
            1px solid
            #e5eaf1;

        border-radius: 14px;

        overflow: hidden;

        box-shadow:
            0 3px 12px
            rgba(15, 23, 42, 0.04);
    }


    /*
    |--------------------------------------------------------------------------
    | Main Settings Content
    |--------------------------------------------------------------------------
    */

    .settings-content {
        min-width: 0;

        background: #ffffff;

        border:
            1px solid
            #e5eaf1;

        border-radius: 14px;

        padding: 22px;

        box-shadow:
            0 3px 12px
            rgba(15, 23, 42, 0.04);
    }


    /*
    |--------------------------------------------------------------------------
    | Alert Messages
    |--------------------------------------------------------------------------
    */

    .settings-alert {
        display: flex;
        align-items: flex-start;

        gap: 10px;

        margin-bottom: 18px;
        padding: 12px 14px;

        border-radius: 10px;

        font-size: 13px;
        line-height: 1.6;
    }

    .settings-alert-icon {
        flex: 0 0 auto;

        margin-top: 1px;
    }

    .settings-alert-success {
        color: #166534;

        background: #f0fdf4;

        border:
            1px solid
            #bbf7d0;
    }

    .settings-alert-error {
        color: #991b1b;

        background: #fef2f2;

        border:
            1px solid
            #fecaca;
    }


    /*
    |--------------------------------------------------------------------------
    | Generic Settings Card
    |--------------------------------------------------------------------------
    */

    .settings-card {
        border:
            1px solid
            #e7ebf0;

        border-radius: 12px;

        background: #ffffff;

        overflow: hidden;
    }

    .settings-card + .settings-card {
        margin-top: 18px;
    }

    .settings-card-header {
        padding: 16px 18px;

        border-bottom:
            1px solid
            #edf0f4;

        background: #fafbfd;
    }

    .settings-card-title {
        margin: 0;

        color: #172033;

        font-size: 16px;
        font-weight: 700;
    }

    .settings-card-description {
        margin:
            5px
            0
            0;

        color: #718096;

        font-size: 12.5px;

        line-height: 1.6;
    }

    .settings-card-body {
        padding: 20px;
    }


    /*
    |--------------------------------------------------------------------------
    | Responsive
    |--------------------------------------------------------------------------
    */

    @media (max-width: 1100px) {

        .settings-shell {
            grid-template-columns:
                220px
                minmax(0, 1fr);

            gap: 16px;
        }

    }

    @media (max-width: 900px) {

        .settings-shell {
            grid-template-columns: 1fr;
        }

        .settings-sidebar {
            position: static;
        }

    }

    @media (max-width: 576px) {

        .settings-page {
            padding-bottom: 20px;
        }

        .settings-main-header {
            padding: 14px;
        }

        .settings-main-header__icon {
            width: 40px;
            height: 40px;

            flex-basis: 40px;

            font-size: 17px;
        }

        .settings-main-title {
            font-size: 18px;
        }

        .settings-content {
            padding: 14px;
        }

        .settings-card-body {
            padding: 15px;
        }

    }

</style>

@endpush


@push('scripts')

<script>
    document.addEventListener(
        'DOMContentLoaded',
        function () {

            /*
             * Reserved for shared Settings Center
             * JavaScript behavior.
             *
             * Individual Settings sections may add
             * their own scripts using @push('scripts').
             */

        }
    );
</script>

@endpush