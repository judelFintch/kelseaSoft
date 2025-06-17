@php
    use Carbon\Carbon;
    use App\Models\Tax;
    use App\Models\AgencyFee;
    use App\Models\ExtraFee;

    $physicalAddress = $invoice->company->physical_address ?? 'Aucune adresse renseignée';
    $formattedAddress = wordwrap($physicalAddress, 47, "\n", true);
    $cifAmountUsd = $invoice->cif_amount ?? 0;
    $exchangeRate = $invoice->exchange_rate ?? 0;
    $cifAmountCdf = $exchangeRate > 0 ? $cifAmountUsd * $exchangeRate : 0;

    $importTaxSubtotalCdf = $invoice->items->where('category', 'import_tax')->sum('amount_cdf');
    $importTaxSubtotalUsd = $invoice->exchange_rate ? $importTaxSubtotalCdf / $invoice->exchange_rate : 0;
    $agencySubtotal = $invoice->items->where('category', 'agency_fee')->sum('amount_usd');
    $extraFeeSubtotal = $invoice->items->where('category', 'extra_fee')->sum('amount_usd');

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
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            margin: 5px;
        }

        h2,
        h3,
        h4,
        p {
            margin: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 1.2px;
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

        .word-break {
            word-break: break-word;
            overflow-wrap: break-word;
            max-width: 280px;
            white-space: normal;
        }
    </style>
</head>

<body>

    <table class="no-border" style="margin-bottom: 0; padding: 0;">
    <tr>
        <td style="width: 18%; text-align: left; vertical-align: top; padding: 2px;">
            <img src="{{ public_path('images/logo.png') }}" alt="Logo" style="max-height: 95px;">
        </td>
        <td style="width: 82%; text-align: center; vertical-align: top; padding: 2px;">
            <h2 style="font-size: 25px; margin: 2px 0;">LA MANNE DES BRAVES S.A.R.L</h2>
            <p style="font-size: 20px; font-weight: bold; margin: 2px 0;">TRANSITAIRE EN DOUANE OFFICIEL</p>
            <p style="font-size: 12px; font-weight: bold; margin: 2px 0;">VOTRE SATISFACTION, C'EST NOTRE AFFAIRE</p>
            <p style="font-size: 12px; margin: 2px 0;">N° Impôt : A1000859X RCCM: CD/LSHI/RCCM15-B3463</p>
            <p style="font-size: 12px; margin: 2px 0;">ID. NAT : 05-H1901-N57656K NUMÉRO AGREMENT : 000188</p>
        </td>
    </tr>
</table>



    <h3 class="center" style="border: 1px solid black; padding: 2px;">FACTURE N° {{ $invoice->invoice_number }}</h3>

    <table class="no-border">
        <tr>
            <td class="word-break">
                <p><strong>Client :</strong> {{ $invoice->company->name }}</p>
                <p><strong>Adresse :</strong> {!! nl2br(e($formattedAddress)) !!}</p>
                <p class="text-xs text-gray-500">RCCM : {{ $invoice->company->commercial_register }}</p>
                 <p class="text-xs text-gray-500">{{ $invoice->company->nbc_number }}</p>
                <p class="text-xs text-gray-500">{{ $invoice->company->national_identification }}</p>

            </td>
            <td class="right">
                Lubumbashi le {{ Carbon::parse($invoice->invoice_date)->format('d/m/Y') }}<br>
                <strong>NOTRE COMPTE</strong> 1081911
            </td>
        </tr>
    </table>

    <table>
        <tr>
            <td><strong>NUMERO DOSSIER</strong></td>
            <td>{{ $invoice->folder?->folder_number ?? 'Non spécifié' }}</td>
            <td><strong>DESCRIPTION</strong></td>
            <td>{{ $invoice->folder->goods_type ?? 'MGO' }}</td>
        </tr>
        <tr>
            <td><strong>POSITION TARIFAIRE</strong></td>
            <td>{{ $invoice->folder->description ?? 'Non spécifiée' }}</td>
            <td><strong>POIDS</strong></td>
            <td>{{ $invoice->weight ?? 'Non spécifié' }}</td>
        </tr>
        <tr>
            <td><strong>TAUX DE CHANGE</strong></td>
            <td>{{ number_format($exchangeRate, 2) }} CDF/USD</td>
            <td><strong>FOB/USD</strong></td>
            <td>{{ number_format($invoice->fob_amount ?? 0, 2) }}</td>
        </tr>
        <tr>
            <td><strong>FRET/USD</strong></td>
            <td>{{ number_format($invoice->freight_amount ?? 0, 2) }}</td>
            <td><strong>ASSURANCE</strong></td>
            <td>{{ number_format($invoice->insurance_amount ?? 0, 2) }}</td>
        </tr>
        <tr>
            <td><strong>CIF/USD</strong></td>
            <td>{{ number_format($cifAmountUsd, 2) }}</td>
            <td><strong>CIF/CDF</strong></td>
            <td>{{ number_format($cifAmountCdf, 0) }}</td>
        </tr>
    </table>

    <h4 style="border-top: 1px solid #000; text-align: center;">A. IMPORT DUTY & TAXES</h4>
    <table>
        <thead>
            <tr>
                <th style="width: 80px;">RÉF.</th>
                <th style="width: 280px;">LIBELLÉ</th>
                <th style="width: 100px;" class="right">MONTANT/USD</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoice->items->where('category', 'import_tax') as $item)
                @php
                    $tax = Tax::find($item->tax_id);
                    $amountUsd = $invoice->exchange_rate > 0 ? $item->amount_cdf / $invoice->exchange_rate : 0;
                @endphp
                <tr>
                    <td>{{ $tax?->code ?? '---' }}</td>
                    <td class="word-break">{{ $item->label }}</td>
                    <td class="right">{{ number_format($amountUsd, 2) }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="2" class="right"><strong>Sous-total A</strong></td>
                <td class="right"><strong>{{ number_format($importTaxSubtotalUsd, 2) }}</strong></td>
            </tr>
        </tbody>
    </table>


    <h4 style="border-top: 1px solid #000; text-align: center;">B. AGENCY FEES</h4>
    <table>
        <thead>
            <tr>
                <th style="width: 80px;">RÉF.</th>
                <th style="width: 280px;">LIBELLÉ</th>
                <th style="width: 100px;" class="right">USD</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoice->items->where('category', 'agency_fee') as $item)
                @php $agency = AgencyFee::find($item->agency_fee_id); @endphp
                <tr>
                    <td>{{ $agency?->code ?? '---' }}</td>
                    <td class="word-break">{{ $item->label }}</td>
                    <td class="right">{{ number_format($item->amount_usd, 2) }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="2" class="right"><strong>Sous-total B</strong></td>
                <td class="right"><strong>{{ number_format($agencySubtotal, 2) }}</strong></td>
            </tr>
        </tbody>
    </table>

    <h4 style="border-top: 1px solid #000; text-align: center;">C. AUTRES FRAIS</h4>
    <table>
        <thead>
            <tr>
                <th style="width: 80px;">RÉF.</th>
                <th style="width: 280px;">LIBELLÉ</th>
                <th style="width: 100px;" class="right">USD</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoice->items->where('category', 'extra_fee') as $item)
                @php $extra = ExtraFee::find($item->extra_fee_id); @endphp
                <tr>
                    <td>{{ $extra?->code ?? '---' }}</td>
                    <td class="word-break">{{ $item->label }}</td>
                    <td class="right">{{ number_format($item->amount_usd, 2) }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="2" class="right"><strong>Sous-total A</strong></td>
                <td class="right"><strong>{{ number_format($extraFeeSubtotal, 2) }}</strong></td>
            </tr>
        </tbody>
    </table>



    <h4 style="border-top: 1px solid #000;">TOTAL GÉNÉRAL</h4>
    <table>
        <tr>
            <td colspan="2" class="right"><strong>TOTAL (A, B et C) / USD :</strong></td>
            <td class="right"><strong>{{ number_format($invoice->total_usd ?? 0, 2) }}</strong></td>
        </tr>
    </table>

    <p><strong>Montant en lettres :</strong> {{ amountToWords($invoice->total_usd ?? 0) }}</p>
    <p>Numéro compte : TMB 00017-25000-00232100001-85 USD</p>
    <p>Mode de paiement : Provision</p>

    {{-- Signature --}}
    <table class="no-border" style="width: 100%; margin-top: 8px; margin-bottom: 40px;">
        <tr>
            <td style="width: 60%;"></td>
            <td style="width: 40%; text-align: center;">
                <p><strong>CHRISTELLE NTANGA</strong></p>
                <p>RESP FACTURATION</p>
                <div style="border: 0px solid #000; height: 40px; margin-top: 5px;"></div>
            </td>
        </tr>
    </table>

    <hr style="border: none; border-top: 1px solid #333;">
    <p class="center" style="font-size: 11px;">
        960, Av. Chaussée Laurent Désiré Kabila, Immeuble Méthodiste, 2ème étage – Quartier Makatano, Commune de
        Lubumbashi<br>
        Tél : (+243)998180745, (+243)815056461, (+243)0977960987 – E-mail : mannedesbraves@yahoo.fr<br>
        Représentations : Kinshasa - Matadi - Kasumbalesa - Kolwezi
    </p>

</body>

</html>
