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
            background: #ffffff;
            color: #0a1526;
        }
        .border {
            margin: 16pt;
            border: 2pt solid #0a1526;
            padding: 8pt;
        }
        .inner {
            border: 1pt solid #f3700d;
            padding: 36pt 60pt;
            text-align: center;
        }
        .brand {
            font-size: 20pt;
            font-weight: bold;
            letter-spacing: 1pt;
            margin-bottom: 2pt;
        }
        .brand .ac { color: #f3700d; }
        .tagline {
            font-size: 9pt;
            color: #556;
            margin-bottom: 30pt;
        }
        .title {
            font-size: 28pt;
            font-weight: bold;
            letter-spacing: 3pt;
            color: #0a1526;
            margin-bottom: 30pt;
        }
        .lead {
            font-size: 12pt;
            color: #333;
            margin-bottom: 10pt;
        }
        .name {
            font-size: 24pt;
            font-weight: bold;
            color: #f3700d;
            margin: 14pt 0 20pt;
        }
        .body-text {
            font-size: 12pt;
            color: #333;
            line-height: 1.6;
            max-width: 480pt;
            margin: 0 auto 40pt;
        }
        .signatures {
            display: table;
            width: 100%;
            margin-top: 40pt;
        }
        .sign {
            display: table-cell;
            width: 50%;
            font-size: 10pt;
            color: #556;
        }
        .sign .line {
            margin-top: 30pt;
            border-top: 1pt solid #888;
            width: 160pt;
            display: inline-block;
        }
    </style>
</head>
<body>
    <div class="border">
        <div class="inner">
            <div class="brand"><span class="ac">A</span>RTISCODE</div>
            <div class="tagline">Innovation makes the future — Bertoua, Cameroun</div>

            <div class="title">ATTESTATION DE PARTICIPATION</div>

            <div class="lead">Nous certifions que</div>
            <div class="name">{{ $registration->nom }}</div>
            <div class="body-text">
                a participé à l'événement « {{ $registration->reference_label }} »,
                organisé par ARTISCODE Agency à Bertoua.
            </div>

            <div class="signatures">
                <div class="sign">
                    Fait à Bertoua, le {{ now()->isoFormat('D MMMM YYYY') }}
                </div>
                <div class="sign">
                    <div class="line">&nbsp;</div><br>
                    Direction ARTISCODE
                </div>
            </div>
        </div>
    </div>
</body>
</html>
