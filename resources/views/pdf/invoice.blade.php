@php
    use Carbon\Carbon;

    function amountToWords($amount)
    {
        $formatter = new \NumberFormatter('fr', \NumberFormatter::SPELLOUT);
        $amountInt = intval($amount);
        $words = ucfirst($formatter->format($amountInt));
        return $words . ' dollars américains';
    }
@endphp

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Facture Proforma</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 9px;
            margin: 5px;
        }

        h2,
        h3,
        h4,
        p {
            margin: 1px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 4px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 2px;
            text-align: left;
        }

        .no-border td,
        .no-border th {
            border: none;
        }

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }
    </style>
</head>

<body>

    {{-- En-tête société --}}
    <table class="no-border">
        <tr>
            <td class="center">
                <img src="{{ public_path('images/logo.png') }}" alt="Logo" style="max-height: 50px;"><br>
                <h2>LA MANNE DES BRAVES S.A.R.L</h2>
                <p>TRANSITAIRE EN DOUANE OFFICIEL – VOTRE SATISFACTION, C'EST NOTRE AFFAIRE</p>
                <p>N° Impôt : A1000859K RCCM : CDL/SHR/RCM15-B3463</p>
                <p>ID. NAT : 05-H1901-N57656K NUMÉRO AGREMENT : 000188</p>
            </td>
        </tr>
    </table>

    {{-- Numéro de facture --}}
    <h3 class="center" style="border: 1px solid black; padding: 2px;">FACTURE N° {{ $invoice->invoice_number }}</h3>

    {{-- Informations client --}}
    {{-- Informations client enrichies --}}
    <table class="no-border">
        <tr>
            <td>
                <strong>Client :</strong><br>
                <strong>Raison Sociale :</strong> {{ $invoice->company->name }}<br>
                @if ($invoice->company->acronym)
                    <strong>Acronyme :</strong> {{ $invoice->company->acronym }}<br>
                @endif
                
                <strong>Adresse :</strong> {{ $invoice->company->physical_address ?? 'Aucune adresse renseignée' }}<br>
                @if ($invoice->company->country)
                    <strong>Pays :</strong> {{ $invoice->company->country }}<br>
                @endif
               
                @if ($invoice->company->email)
                    <strong>Email :</strong> {{ $invoice->company->email }}<br>
                @endif
                
                @if ($invoice->company->code)
                    <strong>Code :</strong> {{ $invoice->company->code }}<br>
                @endif
               
                @if ($invoice->company->nbc_number)
                    <strong>Numéro NBC :</strong> {{ $invoice->company->nbc_number }}<br>
                @endif
                @if ($invoice->company->commercial_register)
                    <strong>RCCM :</strong> {{ $invoice->company->commercial_register }}<br>
                @endif
                @if ($invoice->company->tax_id)
                    <strong>Numéro Impôt :</strong> {{ $invoice->company->tax_id }}<br>
                @endif
                @if ($invoice->company->national_identification)
                    <strong>ID National :</strong> {{ $invoice->company->national_identification }}<br>
                @endif
            </td>
            <td class="right">
                Lubumbashi le {{ Carbon::parse($invoice->invoice_date)->format('d/m/Y') }}<br><br>
                <strong>NOTRE COMPTE</strong> 1081911
            </td>
        </tr>
    </table>


    {{-- Informations dossier --}}
    <table>
        <tr>
            <td><strong>NUMERO DOSSIER</strong></td>
            <td>{{ $invoice->folder?->folder_number ?? 'Non spécifié' }}</td>
            <td><strong>DESCRIPTION</strong></td>
            <td>{{ $invoice->product ?? 'MGO' }}</td>
        </tr>
        <tr>
            <td><strong>P.O</strong></td>
            <td>{{ $invoice->operation_code ?? 'Non spécifié' }}</td>
            <td><strong>POSITION TARIFAIRE</strong></td>
            <td>{{ $invoice->tariff_position ?? 'Non spécifiée' }}</td>
        </tr>
        <tr>
            <td><strong>POIDS</strong></td>
            <td>{{ $invoice->weight ?? 'Non spécifié' }}</td>
            <td><strong>TAUX DE CHANGE</strong></td>
            <td>{{ number_format($invoice->exchange_rate ?? 0, 2) }} CDF/USD</td>
        </tr>
        <tr>
            <td><strong>FOB/USD</strong></td>
            <td>{{ number_format($invoice->fob_amount ?? 0, 2) }}</td>
            <td><strong>FRET/USD</strong></td>
            <td>{{ number_format($invoice->freight_amount ?? 0, 2) }}</td>
        </tr>
        <tr>
            <td><strong>AUTRES CHARGES</strong></td>
            <td>ASSURANCE</td>
            <td></td>
            <td>{{ number_format($invoice->insurance_amount ?? 0, 2) }}</td>
        </tr>
        <tr>
            <td><strong>CIF/USD</strong></td>
            <td>{{ number_format($invoice->cif_amount ?? 0, 2) }}</td>
            <td><strong>CIF/CDF</strong></td>
            <td>{{ number_format($invoice->converted_total ?? 0, 0) }}</td>
        </tr>
    </table>

    {{-- A. Taxes d'importation --}}
    <h4>A. IMPORT DUTY & TAXES</h4>
    <table>
        <thead>
            <tr>
                <th>RÉF.</th>
                <th>LIBELLÉ</th>
                <th class="right">MONTANT CDF</th>
            </tr>
        </thead>
        <tbody>
            @php $importTaxSubtotal = $invoice->items->where('category', 'import_tax')->sum('amount_cdf'); @endphp
            @foreach ($invoice->items->where('category', 'import_tax') as $item)
                <tr>
                    <td>{{ \Str::substr($item->label, 0, 3) }}</td>
                    <td>{{ $item->label }}</td>
                    <td class="right">{{ number_format($item->amount_cdf, 0) }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="2" class="right"><strong>Sous-total</strong></td>
                <td class="right"><strong>{{ number_format($importTaxSubtotal, 0) }}</strong></td>
            </tr>
        </tbody>
    </table>

    {{-- B. Frais agence --}}
    <h4>B. AGENCY FEES</h4>
    <table>
        <thead>
            <tr>
                <th>RÉF.</th>
                <th>LIBELLÉ</th>
                <th class="right">MONTANT (USD)</th>
                <th class="right">TVA (%)</th>
                <th class="right">TVA (USD)</th>
                <th class="right">MONTANT TOTAL</th>
            </tr>
        </thead>
        <tbody>
            @php
                $agencyItems = $invoice->items->where('category', 'agency_fee');
                $agencySubtotal = $agencyItems->sum('amount_usd');
                $agencySubtotalHt = round($agencySubtotal / 1.16, 2);
                $agencySubtotalTva = $agencySubtotal - $agencySubtotalHt;
            @endphp
            @foreach ($agencyItems as $item)
                @php
                    $ht = round($item->amount_usd / 1.16, 2);
                    $tva = $item->amount_usd - $ht;
                @endphp
                <tr>
                    <td>{{ \Str::limit($item->label, 3, '') }}</td>
                    <td>{{ $item->label }}</td>
                    <td class="right">{{ number_format($ht, 2) }}</td>
                    <td class="right">16</td>
                    <td class="right">{{ number_format($tva, 2) }}</td>
                    <td class="right">{{ number_format($item->amount_usd, 2) }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="2" class="right"><strong>Sous-total</strong></td>
                <td class="right"><strong>{{ number_format($agencySubtotalHt, 2) }}</strong></td>
                <td class="right">16</td>
                <td class="right"><strong>{{ number_format($agencySubtotalTva, 2) }}</strong></td>
                <td class="right"><strong>{{ number_format($agencySubtotal, 2) }}</strong></td>
            </tr>
        </tbody>
    </table>

    {{-- C. Autres frais --}}
    <h4>C. AUTRES FRAIS</h4>
    <table>
        <thead>
            <tr>
                <th>RÉF.</th>
                <th>LIBELLÉ</th>
                <th class="right">MONTANT (USD)</th>
            </tr>
        </thead>
        <tbody>
            @php $extraFeeSubtotal = $invoice->items->where('category', 'extra_fee')->sum('amount_usd'); @endphp
            @foreach ($invoice->items->where('category', 'extra_fee') as $item)
                <tr>
                    <td>{{ \Str::limit($item->label, 6, '') }}</td>
                    <td>{{ $item->label }}</td>
                    <td class="right">{{ number_format($item->amount_usd, 2) }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="2" class="right"><strong>Sous-total</strong></td>
                <td class="right"><strong>{{ number_format($extraFeeSubtotal, 2) }}</strong></td>
            </tr>
        </tbody>
    </table>

    {{-- Total général --}}
    <table>
        <tr>
            <td colspan="5" class="right"><strong>TOTAL (A, B et C) / USD :</strong>
                {{ number_format($invoice->total_usd ?? 0, 2) }}</td>
        </tr>
    </table>

    {{-- Montant en lettres --}}
    <p style="margin-top: 4px;"><strong>Montant en lettres :</strong> {{ amountToWords($invoice->total_usd ?? 0) }}</p>
    <p>Numéro compte : TMB 00017-25000-00232100001-85 USD</p>
    <p>Mode de paiement : Provision</p>

    {{-- Signature --}}
    <p class="right" style="margin-top: 6px;">CHRISTELLE NTANGA<br><strong>RESP FACTURATION</strong></p>
    <hr style="border: none; border-top: 1px solid #333; margin: 8px 0;">
    <p class="center" style="font-size: 8px; margin-top: 4px;">
        960, Av. Chaussée Laurent Désiré Kabila, Immeuble Méthodiste, 2ème étage – Quartier Makatano, Commune de
        Lubumbashi<br>
        Tél : (+243)998180745, (+243)815056461, (+243)0977960987 – E-mail : mannedesbraves@yahoo.fr<br>
        Représentations : Kinshasa - Matadi - Kasumbalesa - Kolwezi
    </p>

</body>

</html>
