@php use Carbon\Carbon; @endphp

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Facture Proforma</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 4px;
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

        .header-table td {
            vertical-align: top;
        }

        .header-company {
            text-align: center;
        }

        .header-company h2 {
            margin: 0;
            font-size: 18px;
        }

        .header-company p {
            margin: 0;
        }

        .client-info td {
            vertical-align: top;
        }
    </style>
</head>

<body>
    {{-- En-tête avec logo et infos entreprise --}}
    <table class="no-border" style="margin-bottom: 10px; width: 100%;">
        <tr>
            <td style="text-align: center;">
                <img src="{{ public_path('images/logo.png') }}" alt="Logo" style="max-height: 90px;"><br><br>
                <h2 style="margin: 0; font-size: 18px;">LA MANNE DES BRAVES S.A.R.L</h2>
                <p style="margin: 0;">TRANSITAIRE EN DOUANE OFFICIEL</p>
                <p style="margin: 0;">VOTRE SATISFACTION, C'EST NOTRE AFFAIRE</p>
                <p style="margin: 0;">N° Impôt : A1000859K RCCM : CDL/SHR/RCM15-B3463</p>
                <p style="margin: 0;">ID. NAT : 05-H1901-N57656K NUMÉRO AGREMENT : 000188</p>
            </td>
        </tr>
    </table>

    <h3 class="center" style="border: 1px solid black; padding: 5px; margin-bottom: 10px;">FACTURE N°
        {{ $invoice->invoice_number }}</h3>

    {{-- Informations client --}}
    <table class="no-border client-info" style="margin-bottom: 10px;">
        <tr>
            <td>
                <strong>Client :</strong><br>
                {{ $invoice->company->name }}<br>
                {{ $invoice->company->address ?? 'Avenue Kasa-Vubu, Immeuble M. de la Paix' }}<br>

                RCCM : {{ $invoice->company->rccm ?? 'CD/KZ/KCM/14-B-020' }}<br>
                TAX N° : {{ $invoice->company->tax_number ?? 'A07040104' }}<br>
                VAT N° : {{ $invoice->company->vat_number ?? '0479/DGI/DGE/DIG/MB/TVA/2011' }}<br>
                ID NAT : {{ $invoice->company->id_nat ?? '14-B0500-N455970' }}
            </td>
            <td class="right" style="border: 1px solid black; padding-left: 10px;">
                Lubumbashi le {{ Carbon::parse($invoice->invoice_date)->format('d/m/Y') }}<br><br>
                <strong>NOTRE COMPTE</strong> 1081911
            </td>
        </tr>
    </table>

    {{-- Bloc dossier, fob, assurance, etc --}}
    <table style="margin-top: 10px;">
        <tr>
            <td><strong>NUMERO DOSSIER</strong></td>
            <td>{{ $invoice->folder?->folder_number ?? '24/MDB/KCC003' }}</td>
            <td><strong>DESCRIPTION</strong></td>
            <td>{{ $invoice->product ?? 'MGO' }}</td>
        </tr>
        <tr>
            <td><strong>P.O</strong></td>
            <td>{{ $invoice->operation_code ?? '4500499681' }}</td>
            <td><strong>POSITION TARIFAIRE</strong></td>
            <td>25.19.90.00</td>
        </tr>
        <tr>
            <td><strong>POIDS</strong></td>
            <td>{{ $invoice->weight ?? '38T' }}</td>
            <td><strong>TAUX DE CHANGE</strong></td>
            <td>{{ number_format($invoice->exchange_rate ?? 2840.4735, 4) }} CDF/USD</td>
        </tr>
        <tr>
            <td><strong>FOB/USD</strong></td>
            <td>{{ number_format($invoice->fob_amount ?? 24881.26, 2) }}</td>
            <td><strong>FRET/USD</strong></td>
            <td>{{ number_format($invoice->freight_amount ?? 5230, 2) }}</td>
        </tr>
        <tr>
            <td><strong>AUTRES CHARGES</strong></td>
            <td>ASSURANCE</td>
            <td></td>
            <td>{{ number_format($invoice->insurance_amount ?? 107.48, 2) }}</td>
        </tr>
        <tr>
            <td><strong>CIF/USD</strong></td>
            <td>{{ number_format($invoice->cif_amount ?? 30808.72, 2) }}</td>
            <td><strong>CIF/CDF</strong></td>
            <td>{{ number_format($invoice->converted_total ?? 8691125, 0) }}</td>
        </tr>
    </table>

    {{-- Section A --}}
    <h4 style="margin-top: 10px;">A. IMPORT DUTY & TAXES</h4>
    <table>
        <thead>
            <tr>
                <th>CODE</th>
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

    {{-- Section B --}}
    <h4 style="margin-top: 10px;">B. AGENCY FEES</h4>
    <table>
        <thead>
            <tr>
                <th>CODE</th>
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

    {{-- Section C --}}
    <h4 style="margin-top: 10px;">C. AUTRES FRAIS</h4>
    <table>
        <thead>
            <tr>
                <th>CODE</th>
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

    {{-- Totaux --}}
    <table style="margin-top: 10px;">
        <tr>
            <td class="right"><strong>TOTAL (A, B et C) / USD :</strong></td>
            <td class="right"><strong>{{ number_format($invoice->total_usd ?? 4020.4, 2) }}</strong></td>
        </tr>
    </table>

    {{-- Footer --}}
    <p style="margin-top: 30px;">Nous disons, Dollars Américains, Quatre Mille Vingt, quatre centimes</p>
    <p>Numéro compte : TMB 00017-25000-00232100001-85 USD</p>
    <p>Mode de paiement : Provision</p>

    <p class="right" style="margin-top: 40px;">CHRISTELLE NTANGA<br><strong>RESP FACTURATION</strong></p>

    <p style="margin-top: 40px; font-size: 10px;" class="center">
        960, Av. Chaussée Laurent Désiré Kabila, Immeuble Méthodiste, 2ème étage<br>
        Quartier Makatano, Commune de Lubumbashi<br>
        Tél : (+243)998180745, (+243)815056461, (+243)0977960987<br>
        E-mail : mannedesbraves@yahoo.fr, infos@mannedesbraves.com<br>
        Représentations : Kinshasa - Matadi - Kasumbalesa - Kolwezi
    </p>
</body>

</html>
