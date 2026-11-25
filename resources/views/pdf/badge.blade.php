<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        @page { margin: 0; }
        html, body {
            margin: 0;
            padding: 0;
            font-family: 'DejaVu Sans', sans-serif;
            background: #0a1526;
            color: #ffffff;
        }
        .card {
            width: 283.5pt;
            padding: 22pt 20pt 10pt;
            background: #0a1526;
        }
        .header {
            text-align: center;
            margin-bottom: 18pt;
        }
        .header .brand {
            font-size: 16pt;
            font-weight: bold;
            color: #ffffff;
            letter-spacing: 1pt;
        }
        .header .brand .ac {
            color: #f3700d;
        }
        .header .tagline {
            font-size: 7pt;
            color: #9aa5ba;
            margin-top: 2pt;
        }
        .badge-label {
            text-align: center;
            font-size: 8pt;
            text-transform: uppercase;
            letter-spacing: 2pt;
            color: #ffab4a;
            margin-bottom: 6pt;
        }
        .event-title {
            text-align: center;
            font-size: 13pt;
            font-weight: bold;
            color: #ffffff;
            margin-bottom: 20pt;
            padding: 0 10pt;
        }
        .participant-name {
            text-align: center;
            font-size: 20pt;
            font-weight: bold;
            color: #ffffff;
            margin-bottom: 6pt;
            padding: 10pt;
            border-top: 1pt solid #283956;
            border-bottom: 1pt solid #283956;
        }
        .participant-type {
            text-align: center;
            font-size: 10pt;
            color: #f3700d;
            font-weight: bold;
            margin-bottom: 24pt;
        }
        .qr {
            text-align: center;
            margin-bottom: 16pt;
        }
        .qr img {
            width: 110pt;
            height: 110pt;
        }
        .footer {
            text-align: center;
            font-size: 8pt;
            color: #9aa5ba;
        }
        .footer .ref {
            font-size: 7pt;
            color: #556;
            margin-top: 6pt;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="header">
            <div class="brand"><span class="ac">A</span>RTIS<span class="ac">C</span>ODE</div>
            <div class="tagline">Innovation makes the future</div>
        </div>

        <div class="badge-label">Badge participant</div>
        <div class="event-title">{{ $registration->reference_label }}</div>

        <div class="participant-name">{{ $registration->nom }}</div>
        @if($registration->participant_type)
            <div class="participant-type">{{ $registration->participant_type }}</div>
        @endif

        <div class="qr">
            <img src="{{ $qrDataUri }}" alt="QR">
        </div>

        <div class="footer">
            Bertoua, Cameroun
            <div class="ref">Réf. {{ $registration->uuid }}</div>
        </div>
    </div>
</body>
</html>
