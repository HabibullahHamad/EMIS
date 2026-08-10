<!DOCTYPE html>
<html lang="ps" dir="rtl">
<head>
    <meta charset="UTF-8">

    <style>
        @page {
            size: 53.98mm 85.60mm;
            margin: 0;
        }

        * {
            box-sizing: border-box;
        }

        html,
        body {
            width: 53.98mm;
            min-width: 53.98mm;
            max-width: 53.98mm;

            height: 85.60mm;
            min-height: 85.60mm;
            max-height: 85.60mm;

            margin: 0;
            padding: 0;
            overflow: hidden;

                font-family: bahijnazanin, dejavusans, sans-serif;

            background: #ffffff;
        }

        .card {
            width: 53.98mm;
            height: 85.60mm;

            margin: 0;
            padding: 0;

            border: 0.25mm solid #174b7a;
            border-collapse: collapse;
            border-spacing: 0;
            table-layout: fixed;

            overflow: hidden;
            background: #f6f9fd;
            color: #173451;
            direction: rtl;
        }

        /* =====================================================
           HEADER
           ===================================================== */

        .card-header {
            height: 15.50mm;
            padding: 1.50mm 1.70mm;

            vertical-align: middle;
            overflow: hidden;

            background: #165488;
            color: #ffffff !important;
        }

        .card-header,
        .card-header * {
            color: #ffffff !important;
        }

        .header-table,
        .photo-table,
        .information-table,
        .lower-table,
        .footer-table {
            width: 100%;
            margin: 0;
            padding: 0;

            border-collapse: collapse;
            border-spacing: 0;
            table-layout: fixed;
        }

        .logo-cell {
            width: 7.3mm;
            padding: 0;
            text-align: center;
            vertical-align: middle;
        }

        .logo {
            width: 6.2mm;
            height: 6.2mm;
        }

        .header-content {
            padding: 0;
            text-align: center;
            vertical-align: middle;
            line-height: 1.20;
        }

        .government-title {
            margin: 0;
            padding: 0;

            color: #ffffff !important;
            font-size: 7.4pt;
            font-weight: bold;
        }

        .ministry-title {
            margin-top: 0.35mm;

            color: #ffffff !important;
            font-size: 5.2pt;
        }

        .card-title {
            margin-top: 0.50mm;

            color: #ffffff !important;
            font-size: 6.1pt;
            font-weight: bold;
        }

        /* =====================================================
           BODY
           ===================================================== */

        .card-body {
            height: 61.60mm;
            padding: 1.35mm 2.20mm 0.85mm;

            vertical-align: top;
            overflow: hidden;

            background: #f6f9fd;
        }

        /* =====================================================
           CENTERED CIRCULAR IMAGE
           ===================================================== */

        .photo-table {
            direction: ltr;
        }

        .photo-cell {
            width: 100%;
            padding: 0;

            text-align: center;
            vertical-align: middle;
        }

        /*
         * No square frame or corner border.
         * The photograph itself is circular.
         */
        .photo {
            width: 20mm;
            height: 20mm;

            margin: 0;
            padding: 0;

            border: 0;
            border-radius: 50%;

            background: #ffffff;
        }

        .no-photo {
            display: inline-block;

            width: 20mm;
            height: 20mm;

            margin: 0;
            padding: 0;

            border: 0;
            border-radius: 50%;

            color: #718396;
            background: #e6eef6;

            text-align: center;
            font-size: 5pt;
            line-height: 20mm;
        }

        /* =====================================================
           NAME UNDER IMAGE
           ===================================================== */

        .person-name {
            width: 100%;
            margin-top: 0.65mm;
            padding: 0;

            color: #173451;
            text-align: center;

            font-size: 8.8pt;
            font-weight: bold;
            line-height: 1.15;
        }

        .person-job {
            width: 100%;
            margin-top: 0.20mm;
            padding: 0;

            color: #526b80;
            text-align: center;

            font-size: 5.2pt;
            font-weight: bold;
            line-height: 1.12;
        }

        /* =====================================================
           INFORMATION TABLE
           ===================================================== */

        .information-table {
            margin-top: 0.75mm;
            direction: rtl;
        }

        .information-table td {
            padding: 0.37mm 0.42mm;

            border-bottom: 0.13mm solid #d4e0eb;
            vertical-align: top;

            font-size: 4.70pt;
            line-height: 1.16;
        }

        .information-table .label {
            width: 39%;

            color: #536a7f;
            text-align: right;
            font-weight: bold;
            white-space: nowrap;
        }

        .information-table .value {
            width: 61%;

            color: #112f4d;
            text-align: right;
            font-weight: bold;
            word-wrap: break-word;
        }

        .information-table .ltr-value {
            direction: ltr;
            text-align: left;
        }

        /* =====================================================
           QR CODE AND STATUS
           ===================================================== */

        .lower-table {
            margin-top: 0.65mm;
            direction: ltr;
        }

        .qr-cell {
            width: 15mm;
            padding: 0;

            text-align: center;
            vertical-align: middle;
            direction: ltr;
        }

        .qr-code {
            width: 11.3mm;
            height: 11.3mm;
        }

        .qr-caption {
            margin-top: 0.25mm;

            color: #64788b;
            text-align: center;

            font-size: 3.75pt;
            line-height: 1.10;
        }

        .status-cell {
            padding: 0 1mm 0 0;

            text-align: right;
            vertical-align: middle;
            direction: rtl;

            font-size: 4.85pt;
            line-height: 1.45;
        }

        .status-label {
            color: #536a7f;
            font-weight: bold;
        }

        .status-value {
            color: #112f4d;
            font-weight: bold;
        }

        .status-badge {
            display: inline-block;

            padding: 0.42mm 1.60mm;
            border-radius: 2.20mm;

            color: #ffffff !important;
            background: #168452;

            font-size: 4.40pt;
            font-weight: bold;
        }

        .status-badge.revoked {
            background: #bb2d3b;
        }

        .status-badge.expired {
            background: #6c757d;
        }

        /* =====================================================
           FOOTER
           ===================================================== */

        .card-footer {
            height: 8.50mm;
            padding: 1.10mm 1.50mm;

            vertical-align: middle;
            overflow: hidden;

            background: #165488;
            color: #ffffff !important;
        }

        .card-footer,
        .card-footer * {
            color: #ffffff !important;
        }

        .footer-table {
            direction: rtl;
        }

        .footer-table td {
            width: 50%;
            padding: 0;

            color: #ffffff !important;
            text-align: center;
            vertical-align: middle;

            font-size: 4.50pt;
            font-weight: bold;
            line-height: 1.20;
        }

        .footer-label {
            display: block;
            margin-bottom: 0.20mm;

            color: #ffffff !important;
            font-size: 3.75pt;
            font-weight: normal;
        }
    </style>
</head>

<body>
@php
    $focalPoint = $card->focalPoint;
    $entity = $focalPoint?->budgetEntity;

    /*
    |--------------------------------------------------------------------------
    | Display values
    |--------------------------------------------------------------------------
    */

    $fullName = $focalPoint?->full_name_ps
        ?: $focalPoint?->full_name_fa
        ?: $focalPoint?->full_name_en
        ?: '-';

    $entityName = $entity?->name_ps
        ?: $entity?->name_fa
        ?: $entity?->name_en
        ?: '-';

    $departmentName = $focalPoint?->directorate
        ?: $focalPoint?->department
        ?: $focalPoint?->official_position
        ?: '-';

    $issueDate = $card->issue_date
        ? \Illuminate\Support\Carbon::parse(
            $card->issue_date
        )->format('d-m-Y')
        : '-';

    $expiryDate = $card->expiry_date
        ? \Illuminate\Support\Carbon::parse(
            $card->expiry_date
        )->format('d-m-Y')
        : '-';

    /*
    |--------------------------------------------------------------------------
    | Card status
    |--------------------------------------------------------------------------
    */

    $expired = $card->expiry_date
        && now()->startOfDay()->gt(
            \Illuminate\Support\Carbon::parse(
                $card->expiry_date
            )->endOfDay()
        );

    $statusText = $card->card_status === 'revoked'
        ? 'باطل'
        : ($expired ? 'نېټه تېره' : 'معتبر');

    $statusClass = $card->card_status === 'revoked'
        ? 'revoked'
        : ($expired ? 'expired' : '');

    /*
    |--------------------------------------------------------------------------
    | Image helper
    |--------------------------------------------------------------------------
    */

    $fileToDataUri = static function (
        ?string $absolutePath
    ): ?string {
        if (
            !$absolutePath
            || !is_file($absolutePath)
            || !is_readable($absolutePath)
        ) {
            return null;
        }

        $extension = strtolower(
            pathinfo(
                $absolutePath,
                PATHINFO_EXTENSION
            )
        );

        $mime = match ($extension) {
            'png' => 'image/png',
            'gif' => 'image/gif',
            'webp' => 'image/webp',
            default => 'image/jpeg',
        };

        $contents = @file_get_contents(
            $absolutePath
        );

        if ($contents === false) {
            return null;
        }

        return 'data:' .
            $mime .
            ';base64,' .
            base64_encode($contents);
    };

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    */

    $resolvedLogoData = $logoData
        ?? $fileToDataUri(
            public_path('images/logo.png')
        );

    /*
    |--------------------------------------------------------------------------
    | Focal-point image
    |--------------------------------------------------------------------------
    |
    | The controller may already pass a centered circular $photoData.
    | Otherwise the original stored photograph is used.
    |
    */

    $resolvedPhotoData = $photoData ?? null;

    if (
        !$resolvedPhotoData
        && $focalPoint?->photo_path
    ) {
        $resolvedPhotoData = $fileToDataUri(
            public_path(
                'storage/' .
                ltrim(
                    $focalPoint->photo_path,
                    '/'
                )
            )
        );
    }
@endphp

<table class="card">
    {{-- =====================================================
         HEADER
         ===================================================== --}}
    <tr>
        <td class="card-header">
            <table class="header-table">
                <tr>
                    <td class="logo-cell">
                        @if($resolvedLogoData)
                            <img
                                src="{{ $resolvedLogoData }}"
                                class="logo"
                                alt="Logo"
                            >
                        @endif
                    </td>

                    <td class="header-content">
                        <div class="government-title">
                            د افغانستان اسلامي امارت
                        </div>

                        <div class="ministry-title">
                            د مالیې وزارت ـ د بودجې لوی ریاست
                        </div>

                        <div class="card-title">
                            د بودجوي فوکل پاینټ پېژندپاڼه
                        </div>
                    </td>

                    <td class="logo-cell">
                        @if($resolvedLogoData)
                            <img
                                src="{{ $resolvedLogoData }}"
                                class="logo"
                                alt="Logo"
                            >
                        @endif
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    {{-- =====================================================
         BODY
         ===================================================== --}}
    <tr>
        <td class="card-body">

            {{-- Centered circular photograph --}}
            <table class="photo-table">
                <tr>
                    <td class="photo-cell">
                        @if($resolvedPhotoData)
                            <img
                                src="{{ $resolvedPhotoData }}"
                                class="photo"
                                alt="Focal Point Photo"
                            >
                        @else
                            <span class="no-photo">
                                عکس نشته
                            </span>
                        @endif
                    </td>
                </tr>
            </table>

            {{-- Name directly under the photograph --}}
            <div class="person-name">
                {{ $fullName }}
            </div>

            {{-- Job title under the name --}}
            <div class="person-job">
                {{ $focalPoint?->job_title ?: '-' }}
            </div>

            {{-- Personal and official information --}}
            <table class="information-table">
                <tr>
                    <td class="label">
                        د کارت شمېره
                    </td>

                    <td class="value ltr-value">
                        {{ $card->card_number }}
                    </td>
                </tr>

                <tr>
                    <td class="label">
                        د پلار نوم
                    </td>

                    <td class="value">
                        {{ $focalPoint?->father_name ?: '-' }}
                    </td>
                </tr>

                <tr>
                    <td class="label">
                        د دندې عنوان
                    </td>

                    <td class="value">
                        {{ $focalPoint?->job_title ?: '-' }}
                    </td>
                </tr>

                <tr>
                    <td class="label">
                        بودجوي واحد
                    </td>

                    <td class="value">
                        {{ $entityName }}
                    </td>
                </tr>

                <tr>
                    <td class="label">
                        ریاست / څانګه
                    </td>

                    <td class="value">
                        {{ $departmentName }}
                    </td>
                </tr>

                <tr>
                    <td class="label">
                        د اړیکې شمېره
                    </td>

                    <td class="value ltr-value">
                        {{ $focalPoint?->phone ?: '-' }}
                    </td>
                </tr>

                <tr>
                    <td class="label">
                        د فوکل پاینټ کوډ
                    </td>

                    <td class="value ltr-value">
                        {{ $focalPoint?->focal_point_code ?: '-' }}
                    </td>
                </tr>
            </table>

            {{-- QR code and status --}}
            <table class="lower-table">
                <tr>
                    <td class="qr-cell">
                        <img
                            src="data:image/png;base64,{{ $qr }}"
                            class="qr-code"
                            alt="QR Code"
                        >

                        <div class="qr-caption">
                            د تایید لپاره سکین کړئ
                        </div>
                    </td>

                    <td class="status-cell">
                        <span class="status-label">
                            مالي کال:
                        </span>

                        <span class="status-value">
                            {{ $card->fiscal_year }}
                        </span>

                        <br>

                        <span class="status-label">
                            وضعیت:
                        </span>

                        <span class="status-badge {{ $statusClass }}">
                            {{ $statusText }}
                        </span>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    {{-- =====================================================
         FOOTER
         ===================================================== --}}
    <tr>
        <td class="card-footer">
            <table class="footer-table">
                <tr>
                    <td>
                        <span class="footer-label">
                            د صدور نېټه
                        </span>

                        {{ $issueDate }}
                    </td>

                    <td>
                        <span class="footer-label">
                            د ختمېدو نېټه
                        </span>

                        {{ $expiryDate }}
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>