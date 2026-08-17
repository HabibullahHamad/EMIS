@php
    /*
    |--------------------------------------------------------------------------
    | Safe translation helper
    |--------------------------------------------------------------------------
    */

    $settingsTranslate = function (
        ?string $key,
        string $fallback = ''
    ): string {
        if (!$key) {
            return $fallback;
        }

        $translated = __($key);

        return $translated === $key
            ? $fallback
            : $translated;
    };

    /*
    |--------------------------------------------------------------------------
    | Header values
    |--------------------------------------------------------------------------
    |
    | Expected variables:
    |
    | $pageTitle
    | $pageDescription
    | $pageIcon
    | $pageBadge
    |
    */

    $resolvedTitle = isset($pageTitle)
        ? $settingsTranslate(
            $pageTitle,
            $pageTitle
        )
        : 'Settings';

    $resolvedDescription =
        isset($pageDescription)
            ? $settingsTranslate(
                $pageDescription,
                ''
            )
            : '';

    $resolvedIcon =
        $pageIcon
        ?? 'fa-solid fa-gear';

    $resolvedBadge =
        $pageBadge
        ?? null;
@endphp


<div class="settings-page-header">

    <div class="settings-page-header__main">

        <div class="settings-page-header__icon">
            <i class="{{ $resolvedIcon }}"></i>
        </div>

        <div class="settings-page-header__content">

            <div class="settings-page-header__title-row">

                <h2 class="settings-page-header__title">
                    {{ $resolvedTitle }}
                </h2>

                @if($resolvedBadge)

                    <span class="settings-page-header__badge">
                        {{ $resolvedBadge }}
                    </span>

                @endif

            </div>

            @if($resolvedDescription !== '')

                <p class="settings-page-header__description">
                    {{ $resolvedDescription }}
                </p>

            @endif

        </div>

    </div>


    @isset($pageActions)

        <div class="settings-page-header__actions">
            {!! $pageActions !!}
        </div>

    @endisset

</div>


@once

    @push('styles')

        <style>

            /*
            |--------------------------------------------------------------------------
            | Settings Page Header
            |--------------------------------------------------------------------------
            */

            .settings-page-header {
                display: flex;
                align-items: flex-start;
                justify-content: space-between;

                gap: 16px;

                margin-bottom: 20px;
                padding-bottom: 18px;

                border-bottom:
                    1px solid
                    #edf0f4;
            }

            .settings-page-header__main {
                display: flex;
                align-items: flex-start;

                gap: 12px;

                min-width: 0;
            }

            .settings-page-header__icon {
                width: 42px;
                height: 42px;

                flex: 0 0 42px;

                display: flex;
                align-items: center;
                justify-content: center;

                color: #173d7a;

                background: #edf4ff;

                border-radius: 10px;

                font-size: 17px;
            }

            .settings-page-header__content {
                min-width: 0;
            }

            .settings-page-header__title-row {
                display: flex;
                align-items: center;

                gap: 8px;

                flex-wrap: wrap;
            }

            .settings-page-header__title {
                margin: 0;

                color: #172033;

                font-size: 19px;
                font-weight: 700;

                line-height: 1.35;
            }

            .settings-page-header__description {
                max-width: 760px;

                margin:
                    5px
                    0
                    0;

                color: #718096;

                font-size: 12.5px;

                line-height: 1.7;
            }

            .settings-page-header__badge {
                display: inline-flex;
                align-items: center;

                min-height: 22px;

                padding:
                    3px
                    8px;

                color: #173d7a;

                background: #edf4ff;

                border:
                    1px solid
                    #d6e4fa;

                border-radius: 20px;

                font-size: 9.5px;
                font-weight: 700;
            }

            .settings-page-header__actions {
                display: flex;
                align-items: center;

                gap: 8px;

                flex: 0 0 auto;
            }


            /*
            |--------------------------------------------------------------------------
            | Responsive
            |--------------------------------------------------------------------------
            */

            @media (max-width: 700px) {

                .settings-page-header {
                    flex-direction: column;
                }

                .settings-page-header__actions {
                    width: 100%;
                }

            }

        </style>

    @endpush

@endonce