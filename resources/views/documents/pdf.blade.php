<!DOCTYPE html>
<html lang="ps" dir="rtl">

<head>
<meta charset="UTF-8">

<style>

*{
    font-family:notonaskh !important;
}

body{
    direction:rtl;
    text-align:right;
    font-size:13px;
    color:#000;
    margin:0;
    padding:0;
}

.page{
    position:relative;
    min-height:1000px;
    padding:25px 35px 120px 35px;
}

/* HEADER */

.header{
    text-align:center;
    position:relative;
    margin-bottom:15px;
}

.logo{
    width:80px;
    height:80px;
    object-fit:contain;
    margin-bottom:6px;
}

.header h5,
.header h6{
    margin:2px 0;
    font-weight:bold;
}

/* QR */

.qr{
    position:absolute;
    top:0;
    right:0;
}

/* LINE */

.line{
    border-top:2px solid #222;
    margin:15px 0 20px;
}

/* INFO BLOCK */

.info-table{
    width:100%;
    border-collapse:collapse;
    margin-bottom:25px;
}

.info-table td{
    border:1px solid #333;
    padding:8px;
    vertical-align:middle;
}

.label{
    background:#f1f1f1;
    font-weight:bold;
    width:18%;
    text-align:center;
}

.value{
    width:32%;
}

/* RTL + LTR */

.rtl{
    direction:rtl;
    unicode-bidi:plaintext;
    text-align:right;
}

.ltr{
    direction:ltr;
    unicode-bidi:plaintext;
    text-align:left;
}

/* BODY */

.content{
    margin-top:25px;
    line-height:2.2;
    text-align:justify;
    font-size:14px;
}

/* SIGNATURE */

.signature{
    width:100%;
    margin-top:90px;
    border:none;
}

.signature td{
    border:none;
    text-align:center;
    vertical-align:top;
    font-size:13px;
}

/* FOOTER */

.footer{
    position:absolute;
    bottom:15px;
    left:35px;
    right:35px;
    border-top:1px solid #777;
    padding-top:6px;
    font-size:11px;
    text-align:center;
}

</style>
</head>

<body>

<div class="page">

    {{-- HEADER --}}
    <div class="header">

        {{-- QR --}}
        <div class="qr">
            <img src="data:image/png;base64,{{ $qr }}" width="90">
        </div>

        {{-- LOGO --}}
        <img src="{{ public_path('images/logo.png') }}" class="logo">

        <h5>{{ __('emis.islamic_emirate') }}</h5>
        <h5>{{ __('emis.ministry_finance') }}</h5>
        <h6>{{ __('emis.general_directorate_budget') }}</h6>
        <h6>{{ __('emis.executive_management_office') }}</h6>

    </div>

    {{-- HR LINE --}}
    <div class="line"></div>

    {{-- DOCUMENT INFO --}}
    <table class="info-table">

        <tr>
            <td class="label">{{ __('emis.document_no') }}</td>
            <td class="value ltr">{{ $document->document_number }}</td>

            <td class="label">{{ __('emis.current_status') }}</td>
            <td class="value ltr">{{ strtoupper($document->status) }}</td>
        </tr>

        <tr>
            <td class="label">{{ __('emis.date') }}</td>
            <td class="value ltr">{{ $document->received_date }}</td>

            <td class="label">{{ __('emis.from') }}</td>
            <td class="value rtl">{{ $document->organization }}</td>
        </tr>

        <tr>
            <td class="label">{{ __('emis.subject') }}</td>
            <td colspan="3" class="rtl">
                {{ $document->subject }}
            </td>
        </tr>

        <tr>
            <td class="label">{{ __('emis.title') }}</td>
            <td colspan="3" class="rtl">
                {{ $document->title }}
            </td>
        </tr>

    </table>

    {{-- MAIN BODY --}}
    <div class="content">

        <p class="rtl">
            {{ __('emis.document_registered_text') }}
        </p>

        <p class="rtl">
            {{ __('emis.document_tracking_text') }}
        </p>

    </div>

    {{-- SIGNATURE --}}
    <table class="signature">

        <tr>

            <td>
                {{ __('emis.prepared_by') }}

                <br><br><br>

                ______________________
            </td>

            <td>
                {{ __('emis.reviewed_by') }}

                <br><br><br>

                ______________________
            </td>

            <td>
                {{ __('emis.approved_by') }}

                <br><br><br>

                ______________________
            </td>

        </tr>

    </table>

    {{-- FOOTER --}}
    <div class="footer">

        {{ __('emis.generated_by_emis') }}

        |
        
        <span class="ltr">{{ date('Y-m-d') }}</span>

    </div>

</div>

</body>
</html>