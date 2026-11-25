<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Barryvdh\DomPDF\Facade\Pdf;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\Route;

class RegistrationPdfController extends Controller
{
    public function badge(Registration $registration)
    {
        $qr = new QrCode($registration->uuid);
        $qrDataUri = (new PngWriter())->write($qr)->getDataUri();

        $pdf = Pdf::loadView('pdf.badge', [
            'registration' => $registration,
            'qrDataUri' => $qrDataUri,
        ])->setPaper([0, 0, 283.5, 425.2]); // ~10cm x 15cm

        return $pdf->stream("badge-{$registration->uuid}.pdf");
    }

    public function attestation(Registration $registration)
    {
        $registration->update(['attestation_generated_at' => now()]);

        $pdf = Pdf::loadView('pdf.attestation', [
            'registration' => $registration,
        ])->setPaper('a4', 'landscape');

        return $pdf->stream("attestation-{$registration->uuid}.pdf");
    }
}
