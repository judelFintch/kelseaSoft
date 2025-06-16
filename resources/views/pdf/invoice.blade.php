@php
use Carbon\Carbon;
$physicalAddress = $invoice->company->physical_address ?? 'Aucune adresse renseignée';
$formattedAddress = wordwrap($physicalAddress, 30, "\n", true);


function amountToWords($amount)
{
    $formatter = new \NumberFormatter('fr', \NumberFormatter::SPELLOUT);
    $amountParts = explode('.', number_format($amount, 2, '.', ''));
    $dollars = intval($amountParts[0]);
    $cents = intval($amountParts[1]);
    $words = ucfirst($formatter->format($dollars)) . ' dollars américains';
    if ($cents > 0) {
        $words .= ' et ' . $formatter->format($cents) . ' centimes';
    }
    return $words;
}
@endphp

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Facture Proforma</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 9px; margin: 5px; }
        h2, h3, h4, p { margin: 0; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 2px; }
        th, td { border: 1px solid #000; padding: 2px; text-align: left; }
        .no-border td, .no-border th { border: none; }
        .center { text-align: center; }
        .right { text-align: right; }
    </style>
</head>

<body>

<div style="page-break-inside: avoid;">

{{-- EN-TETE --}}
<table class="no-border">
    <tr>
        <td style="width: 18%; text-align: left; vertical-align: middle;">
            <img src="{{ public_path('images/logo.png') }}" alt="Logo" style="max-height: 110px;">
        </td>
        <td style="width: 82%; text-align: center; vertical-align: middle;">
            <h2 style="font-size: 16px;">LA MANNE DES BRAVES S.A.R.L</h2>
            <p style="font-size: 11px; font-weight: bold;">TRANSITAIRE EN DOUANE OFFICIEL</p>
            <p style="font-size: 11px; font-weight: bold;">VOTRE SATISFACTION, C'EST NOTRE AFFAIRE</p>
            <p style="font-size: 10px;">N° Impôt : A1000859X RCCM : CDL/SHR/RCM15-B3463</p>
            <p style="font-size: 10px;">ID. NAT : 05-H1901-N57656K NUMÉRO AGREMENT : 000188</p>
        </td>
    </tr>
</table>

<h3 class="center" style="border: 1px solid black; padding: 2px;">FACTURE N° {{ $invoice->invoice_number }}</h3>

{{-- INFOS CLIENT --}}
<table class="no-border">
    <tr>
        <td>
            <p><strong>Client :</strong> {{ $invoice->company->name }}</p>
           <p><strong>Adresse :</strong> {!! nl2br(e(wordwrap($invoice->company->physical_address ?? 'Aucune adresse renseignée', 70, "\n", true))) !!}</p>

            @if ($invoice->company->country)<p><strong>Pays :</strong> {{ $invoice->company->country }}</p>@endif
            @if ($invoice->company->email)<p><strong>Email :</strong> {{ $invoice->company->email }}</p>@endif
            @if ($invoice->company->code)<p><strong>Code :</strong> {{ $invoice->company->code }}</p>@endif
            @if ($invoice->company->nbc_number)<p><strong>Numéro NBC :</strong> {{ $invoice->company->nbc_number }}</p>@endif
            @if ($invoice->company->commercial_register)<p><strong>RCCM :</strong> {{ $invoice->company->commercial_register }}</p>@endif
            @if ($invoice->company->tax_id)<p><strong>Numéro Impôt :</strong> {{ $invoice->company->tax_id }}</p>@endif
            @if ($invoice->company->national_identification)<p><strong>ID National :</strong> {{ $invoice->company->national_identification }}</p>@endif
        </td>
        <td class="right">
            Lubumbashi le {{ Carbon::parse($invoice->invoice_date)->format('d/m/Y') }}<br>
            <strong>NOTRE COMPTE</strong> 1081911
        </td>
    </tr>
</table>

{{-- INFOS DOSSIER --}}
<table>
    <tr><td><strong>NUMERO DOSSIER</strong></td><td>{{ $invoice->folder?->folder_number ?? 'Non spécifié' }}</td><td><strong>DESCRIPTION</strong></td><td>{{ $invoice->product ?? 'MGO' }}</td></tr>
    <tr><td><strong>P.O</strong></td><td>{{ $invoice->operation_code ?? 'Non spécifié' }}</td><td><strong>POSITION TARIFAIRE</strong></td><td>{{ $invoice->tariff_position ?? 'Non spécifiée' }}</td></tr>
    <tr><td><strong>POIDS</strong></td><td>{{ $invoice->weight ?? 'Non spécifié' }}</td><td><strong>TAUX DE CHANGE</strong></td><td>{{ number_format($invoice->exchange_rate ?? 0, 2) }} CDF/USD</td></tr>
    <tr><td><strong>FOB/USD</strong></td><td>{{ number_format($invoice->fob_amount ?? 0, 2) }}</td><td><strong>FRET/USD</strong></td><td>{{ number_format($invoice->freight_amount ?? 0, 2) }}</td></tr>
    <tr><td><strong>AUTRES CHARGES</strong></td><td>ASSURANCE</td><td></td><td>{{ number_format($invoice->insurance_amount ?? 0, 2) }}</td></tr>
    <tr><td><strong>CIF/USD</strong></td><td>{{ number_format($invoice->cif_amount ?? 0, 2) }}</td><td><strong>CIF/CDF</strong></td><td>{{ number_format($invoice->converted_total ?? 0, 0) }}</td></tr>
</table>

{{-- A. IMPORT DUTY & TAXES --}}
<h4 style="border-top: 1px solid #000;">A. IMPORT DUTY & TAXES</h4>
<table>
<thead>
<tr><th style="width: 15%;">RÉF.</th><th style="width: 60%;">LIBELLÉ</th><th class="right" style="width: 25%;">MONTANT (CDF)</th></tr>
</thead>
<tbody>
@php $importTaxSubtotal = $invoice->items->where('category', 'import_tax')->sum('amount_cdf'); @endphp
@foreach ($invoice->items->where('category', 'import_tax') as $item)
<tr><td>{{ \Str::substr($item->label, 0, 3) }}</td><td>{{ $item->label }}</td><td class="right">{{ number_format($item->amount_cdf, 0) }}</td></tr>
@endforeach
<tr><td colspan="2" class="right"><strong>Sous-total</strong></td><td class="right"><strong>{{ number_format($importTaxSubtotal, 0) }}</strong></td></tr>
</tbody>
</table>

{{-- B. AGENCY FEES --}}
<h4 style="border-top: 1px solid #000;">B. AGENCY FEES</h4>
<table>
<thead>
<tr><th style="width: 15%;">RÉF.</th><th style="width: 60%;">LIBELLÉ</th><th class="right" style="width: 25%;">MONTANT (USD)</th></tr>
</thead>
<tbody>
@php $agencySubtotal = $invoice->items->where('category', 'agency_fee')->sum('amount_usd'); @endphp
@foreach ($invoice->items->where('category', 'agency_fee') as $item)
<tr><td>{{ \Str::limit($item->label, 3, '') }}</td><td>{{ $item->label }}</td><td class="right">{{ number_format($item->amount_usd, 2) }}</td></tr>
@endforeach
<tr><td colspan="2" class="right"><strong>Sous-total</strong></td><td class="right"><strong>{{ number_format($agencySubtotal, 2) }}</strong></td></tr>
</tbody>
</table>

{{-- C. AUTRES FRAIS --}}
<h4 style="border-top: 1px solid #000;">C. AUTRES FRAIS</h4>
<table>
<thead>
<tr><th style="width: 15%;">RÉF.</th><th style="width: 60%;">LIBELLÉ</th><th class="right" style="width: 25%;">MONTANT (USD)</th></tr>
</thead>
<tbody>
@php $extraFeeSubtotal = $invoice->items->where('category', 'extra_fee')->sum('amount_usd'); @endphp
@foreach ($invoice->items->where('category', 'extra_fee') as $item)
<tr><td>{{ \Str::limit($item->label, 6, '') }}</td><td>{{ $item->label }}</td><td class="right">{{ number_format($item->amount_usd, 2) }}</td></tr>
@endforeach
<tr><td colspan="2" class="right"><strong>Sous-total</strong></td><td class="right"><strong>{{ number_format($extraFeeSubtotal, 2) }}</strong></td></tr>
</tbody>
</table>

{{-- TOTAL --}}
<table>
<tr><td colspan="5" class="right"><strong>TOTAL (A, B et C) / USD :</strong> {{ number_format($invoice->total_usd ?? 0, 2) }}</td></tr>
</table>

<p><strong>Montant en lettres :</strong> {{ amountToWords($invoice->total_usd ?? 0) }}</p>
<p>Numéro compte : TMB 00017-25000-00232100001-85 USD</p>
<p>Mode de paiement : Provision</p>

<p class="right">CHRISTELLE NTANGA<br><strong>RESP FACTURATION</strong></p>
<hr style="border: none; border-top: 1px solid #333;">
<p class="center" style="font-size: 8px;">
960, Av. Chaussée Laurent Désiré Kabila, Immeuble Méthodiste, 2ème étage – Quartier Makatano, Commune de Lubumbashi<br>
Tél : (+243)998180745, (+243)815056461, (+243)0977960987 – E-mail : mannedesbraves@yahoo.fr<br>
Représentations : Kinshasa - Matadi - Kasumbalesa - Kolwezi
</p>

</div>

</body>
</html>
