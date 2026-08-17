@extends('settings.layout')

@section('settings-content')

@php
    $safeValue = function (
        mixed $value,
        string $fallback = 'Not configured'
    ): string {
        if (
            $value === null ||
            $value === ''
        ) {
            return $fallback;
        }

        return is_scalar($value)
            ? (string) $value
            : $fallback;
    };

    $logoPath =
        $organizationInfo['logo']
        ?? null;

    $logoUrl = null;

    if (
        is_string($logoPath) &&
        trim($logoPath) !== ''
    ) {
        $logoUrl = str_starts_with(
            $logoPath,
            'http://'
        ) || str_starts_with(
            $logoPath,
            'https://'
        )
            ? $logoPath
            : asset(
                str_starts_with(
                    $logoPath,
                    'storage/'
                )
                    ? $logoPath
                    : 'storage/'
                        . ltrim($logoPath, '/')
            );
    }

    $registeredSectionCount =
        count($sections ?? []);
@endphp

@include('settings.partials.page-header', [
    'pageTitle' => 'About System',
    'pageDescription' =>
        'View safe application, organization, version, and regional configuration information.',
    'pageIcon' => 'fa-solid fa-circle-info',
])

<div class="about-system">

    <section class="about-system-hero">

        <div class="about-system-hero__identity">

            <div class="about-system-logo">

                @if($logoUrl)

                    <img
                        src="{{ $logoUrl }}"
                        alt="{{ $safeValue(
                            $system['short_name'] ?? null,
                            'EMIS'
                        ) }}"
                    >

                @else

                    <i class="fa-solid fa-building-columns"></i>

                @endif

            </div>

            <div>

                <span class="about-system-eyebrow">
                    Executive Management Information System
                </span>

                <h2>
                    {{
                        $safeValue(
                            $system['name'] ?? null,
                            'EMIS'
                        )
                    }}
                </h2>

                @if(!empty($system['description']))

                    <p>
                        {{ $system['description'] }}
                    </p>

                @else

                    <p>
                        A secure platform for executive management,
                        correspondence, workflows, focal points and reporting.
                    </p>

                @endif

            </div>

        </div>

        <div class="about-system-version">
            <span>Settings Registry</span>

            <strong>
                Version
                {{
                    $safeValue(
                        $system['settings_version'] ?? null,
                        '1'
                    )
                }}
            </strong>
        </div>

    </section>


    <div class="about-system-grid">

        <section class="about-system-card">

            <div class="about-system-card__header">

                <div class="about-system-card__icon">
                    <i class="fa-solid fa-laptop-code"></i>
                </div>

                <div>
                    <h3>Application Information</h3>
                    <p>Safe runtime and framework information</p>
                </div>

            </div>

            <dl class="about-system-list">

                <div>
                    <dt>System name</dt>
                    <dd>
                        {{
                            $safeValue(
                                $system['name'] ?? null
                            )
                        }}
                    </dd>
                </div>

                <div>
                    <dt>Short name</dt>
                    <dd>
                        {{
                            $safeValue(
                                $system['short_name'] ?? null,
                                'EMIS'
                            )
                        }}
                    </dd>
                </div>

                <div>
                    <dt>Environment</dt>
                    <dd>
                        <span class="about-system-badge">
                            {{
                                ucfirst(
                                    $safeValue(
                                        $system['environment'] ?? null,
                                        'Unknown'
                                    )
                                )
                            }}
                        </span>
                    </dd>
                </div>

                <div>
                    <dt>Laravel version</dt>
                    <dd>
                        {{
                            $safeValue(
                                $system['laravel_version'] ?? null
                            )
                        }}
                    </dd>
                </div>

                <div>
                    <dt>PHP version</dt>
                    <dd>
                        {{
                            $safeValue(
                                $system['php_version'] ?? null
                            )
                        }}
                    </dd>
                </div>

                <div>
                    <dt>Registered sections</dt>
                    <dd>
                        {{ $registeredSectionCount }}
                    </dd>
                </div>

            </dl>

        </section>


        <section class="about-system-card">

            <div class="about-system-card__header">

                <div class="about-system-card__icon">
                    <i class="fa-solid fa-building-columns"></i>
                </div>

                <div>
                    <h3>Organization Profile</h3>
                    <p>Official organization information</p>
                </div>

            </div>

            <dl class="about-system-list">

                <div>
                    <dt>Official name</dt>
                    <dd>
                        {{
                            $safeValue(
                                $organizationInfo['official_name']
                                ?? null
                            )
                        }}
                    </dd>
                </div>

                <div>
                    <dt>Organization code</dt>
                    <dd>
                        {{
                            $safeValue(
                                $organizationInfo['organization_code']
                                ?? null
                            )
                        }}
                    </dd>
                </div>

                <div>
                    <dt>Organization type</dt>
                    <dd>
                        {{
                            str(
                                $safeValue(
                                    $organizationInfo['organization_type']
                                    ?? null
                                )
                            )
                                ->replace('_', ' ')
                                ->title()
                        }}
                    </dd>
                </div>

                <div>
                    <dt>Official email</dt>
                    <dd>
                        {{
                            $safeValue(
                                $organizationInfo['official_email']
                                ?? null
                            )
                        }}
                    </dd>
                </div>

                <div>
                    <dt>Official phone</dt>
                    <dd>
                        {{
                            $safeValue(
                                $organizationInfo['official_phone']
                                ?? null
                            )
                        }}
                    </dd>
                </div>

                <div>
                    <dt>Website</dt>
                    <dd>
                        @if(!empty($organizationInfo['website']))

                            <a
                                href="{{ $organizationInfo['website'] }}"
                                target="_blank"
                                rel="noopener noreferrer"
                            >
                                {{ $organizationInfo['website'] }}
                            </a>

                        @else

                            Not configured

                        @endif
                    </dd>
                </div>

            </dl>

        </section>


        <section class="about-system-card">

            <div class="about-system-card__header">

                <div class="about-system-card__icon">
                    <i class="fa-solid fa-language"></i>
                </div>

                <div>
                    <h3>Regional Configuration</h3>
                    <p>Language, timezone and calendar preferences</p>
                </div>

            </div>

            <dl class="about-system-list">

                <div>
                    <dt>Default locale</dt>
                    <dd>
                        {{
                            strtoupper(
                                $safeValue(
                                    $system['default_locale'] ?? null,
                                    'EN'
                                )
                            )
                        }}
                    </dd>
                </div>

                <div>
                    <dt>Timezone</dt>
                    <dd>
                        {{
                            $safeValue(
                                $system['timezone'] ?? null,
                                'UTC'
                            )
                        }}
                    </dd>
                </div>

                <div>
                    <dt>Calendar</dt>
                    <dd>
                        {{
                            str(
                                $safeValue(
                                    $system['calendar_type'] ?? null,
                                    'Gregorian'
                                )
                            )
                                ->replace('_', ' ')
                                ->title()
                        }}
                    </dd>
                </div>

            </dl>

        </section>


        <section class="about-system-card about-system-card--security">

            <div class="about-system-card__header">

                <div class="about-system-card__icon">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>

                <div>
                    <h3>Security Notice</h3>
                    <p>Protected information is intentionally hidden</p>
                </div>

            </div>

            <div class="about-system-notice">

                <i class="fa-solid fa-circle-check"></i>

                <p>
                    Database credentials, application keys, mail passwords
                    and server secrets are never displayed or editable on
                    this page.
                </p>

            </div>

            @if(!empty($organizationInfo['address']))

                <div class="about-system-address">

                    <strong>Official address</strong>

                    <p>
                        {{ $organizationInfo['address'] }}
                    </p>

                </div>

            @endif

        </section>

    </div>

</div>

@endsection


@push('styles')

<style>
    .about-system {
        display: grid;
        gap: 16px;
    }

    .about-system-hero {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 20px;

        padding: 22px;

        color: #ffffff;
        background:
            linear-gradient(
                135deg,
                #102f61,
                #1e5799
            );

        border-radius: 12px;

        box-shadow:
            0 8px 22px
            rgba(23, 61, 122, 0.17);
    }

    .about-system-hero__identity {
        display: flex;
        align-items: center;

        gap: 16px;

        min-width: 0;
    }

    .about-system-logo {
        width: 70px;
        height: 70px;

        flex: 0 0 70px;

        display: flex;
        align-items: center;
        justify-content: center;

        overflow: hidden;

        color: #173d7a;
        background: #ffffff;

        border-radius: 13px;

        font-size: 28px;
    }

    .about-system-logo img {
        width: 100%;
        height: 100%;

        padding: 7px;

        object-fit: contain;
    }

    .about-system-eyebrow {
        color: #cdddf4;

        font-size: 10px;
        font-weight: 700;

        letter-spacing: 0.04em;
        text-transform: uppercase;
    }

    .about-system-hero h2 {
        margin: 4px 0 0;

        font-size: 20px;
        line-height: 1.4;
    }

    .about-system-hero p {
        max-width: 680px;

        margin: 6px 0 0;

        color: #dce8f8;

        font-size: 11.5px;
        line-height: 1.65;
    }

    .about-system-version {
        min-width: 120px;

        padding: 11px 13px;

        color: #173d7a;
        background: #ffffff;

        border-radius: 9px;

        text-align: center;
    }

    .about-system-version span {
        display: block;

        color: #718096;

        font-size: 9px;
    }

    .about-system-version strong {
        display: block;

        margin-top: 3px;

        font-size: 12px;
    }

    .about-system-grid {
        display: grid;
        grid-template-columns:
            repeat(2, minmax(0, 1fr));

        gap: 16px;
    }

    .about-system-card {
        overflow: hidden;

        background: #ffffff;

        border: 1px solid #e1e6ee;
        border-radius: 11px;

        box-shadow:
            0 4px 16px
            rgba(31, 41, 55, 0.04);
    }

    .about-system-card__header {
        display: flex;
        align-items: center;

        gap: 10px;

        padding: 14px 16px;

        background: #fafbfd;

        border-bottom: 1px solid #e7ebf1;
    }

    .about-system-card__icon {
        width: 36px;
        height: 36px;

        flex: 0 0 36px;

        display: flex;
        align-items: center;
        justify-content: center;

        color: #173d7a;
        background: #edf4ff;

        border-radius: 8px;

        font-size: 14px;
    }

    .about-system-card__header h3 {
        margin: 0;

        color: #1e293b;

        font-size: 13px;
    }

    .about-system-card__header p {
        margin: 3px 0 0;

        color: #8490a2;

        font-size: 9.5px;
    }

    .about-system-list {
        margin: 0;
        padding: 0 16px;
    }

    .about-system-list > div {
        display: grid;
        grid-template-columns:
            minmax(120px, 0.8fr)
            minmax(0, 1.5fr);

        gap: 14px;

        padding: 10px 0;

        border-bottom: 1px solid #edf0f4;
    }

    .about-system-list > div:last-child {
        border-bottom: 0;
    }

    .about-system-list dt {
        color: #758196;

        font-size: 10px;
        font-weight: 600;
    }

    .about-system-list dd {
        min-width: 0;

        margin: 0;

        color: #26344a;

        font-size: 10.5px;
        font-weight: 650;

        overflow-wrap: anywhere;
    }

    .about-system-list a {
        color: #1d5a9d;
        text-decoration: none;
    }

    .about-system-badge {
        display: inline-flex;

        padding: 3px 7px;

        color: #166534;
        background: #dcfce7;

        border-radius: 20px;

        font-size: 9px;
        font-weight: 800;
    }

    .about-system-notice {
        display: flex;
        align-items: flex-start;

        gap: 9px;

        margin: 15px;
        padding: 12px;

        color: #166534;
        background: #f0fdf4;

        border: 1px solid #bbf7d0;
        border-radius: 8px;
    }

    .about-system-notice p {
        margin: 0;

        font-size: 10.5px;
        line-height: 1.65;
    }

    .about-system-address {
        margin: 0 15px 15px;
        padding: 12px;

        color: #4b5870;
        background: #f8fafc;

        border: 1px solid #e5e9ef;
        border-radius: 8px;
    }

    .about-system-address strong {
        color: #26344a;
        font-size: 10.5px;
    }

    .about-system-address p {
        margin: 5px 0 0;

        font-size: 10px;
        line-height: 1.65;
    }

    @media (max-width: 850px) {
        .about-system-grid {
            grid-template-columns: 1fr;
        }

        .about-system-hero {
            align-items: flex-start;
            flex-direction: column;
        }

        .about-system-version {
            width: 100%;
        }
    }

    @media (max-width: 520px) {
        .about-system-hero__identity {
            align-items: flex-start;
            flex-direction: column;
        }

        .about-system-list > div {
            grid-template-columns: 1fr;
            gap: 4px;
        }
    }
</style>

@endpush