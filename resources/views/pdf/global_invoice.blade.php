@php
    $physicalAddress = $globalInvoice->company->physical_address ?? 'Aucune adresse';
    $formattedAddress = wordwrap($physicalAddress, 39, "\n", true);

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
    <title>Facture Globale</title>
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
            margin: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 2px;
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

    {{-- EN-TETE HARMONISÉ --}}
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

    <h3 class="center" style="border: 1px solid black; padding: 2px;">FACTURE GLOBALE N°
        {{ $globalInvoice->global_invoice_number }}</h3>

    {{-- INFOS CLIENT --}}
    <table class="no-border">
        <tr>
            <td>
                <p><strong>Client :</strong> {{ $globalInvoice->company->name }}</p>
                <p><strong>Adresse :</strong> {!! nl2br(e($formattedAddress)) !!}</p>
                <p class="text-xs text-gray-500">RCCM : {{ $globalInvoice->company->commercial_register }}</p>
                <p class="text-xs text-gray-500">{{ $globalInvoice->company->nbc_number }}</p>
                <p class="text-xs text-gray-500">{{ $globalInvoice->company->national_identification }}</p>
            </td>
            <td class="right">
                <p>Lubumbashi le {{ \Carbon\Carbon::parse($globalInvoice->created_at)->format('d/m/Y') }}</p>
                <p><strong>NOTRE COMPTE</strong> 1081911</p>
            </td>
        </tr>
    </table>

    {{-- DÉTAILS DE LA FACTURE GLOBALE --}}
    <h4 style="border-top: 1px solid #000;">DÉTAILS FACTURE GLOBALE</h4>
    @php
        $folders = $globalInvoice->invoices->load('folder')->pluck('folder')->filter();
        $declarationCount = $folders->filter(fn($f) => !empty($f->declaration_number))->unique('declaration_number')->count();
        $truckCount = $folders->filter(fn($f) => !empty($f->truck_number))->unique('truck_number')->count();
        $scelleItem = $globalInvoice->globalInvoiceItems->first(fn($i) => str_contains(strtolower($i->description), 'scelle'));
        $nacItem = $globalInvoice->globalInvoiceItems->first(fn($i) => str_contains(strtolower($i->description), 'nac'));
    @endphp
    <table class="no-border" style="margin-bottom: 4px;">
        <tr>
            <td><strong>Déclaration:</strong> {{ $declarationCount }}</td>
            <td><strong>Truck:</strong> {{ $truckCount }}</td>
            <td><strong>Scellés:</strong> {{ $scelleItem?->quantity ?? 0 }} ({{ number_format($scelleItem->total_price ?? 0, 2) }} USD)</td>
            <td><strong>NAC:</strong> {{ $nacItem?->quantity ?? 0 }} ({{ number_format($nacItem->total_price ?? 0, 2) }} USD)</td>
        </tr>
    </table>
    @foreach(['import_tax' => 'A. IMPORT DUTY & TAXES', 'agency_fee' => 'B. AGENCY FEES', 'extra_fee' => 'C. AUTRES FRAIS'] as $cat => $label)
        @php $items = $globalInvoice->globalInvoiceItems->where('category', $cat); @endphp
        @if($items->count())
            <h5 style="margin-top: 4px;">{{ $label }}</h5>
            <table>
                <thead>
                    <tr>
                        <th style="width: 15%;">RÉF.</th>
                        <th style="width: 45%;">LIBELLÉ</th>
                        <th style="width: 10%;" class="right">QTÉ</th>
                        <th style="width: 15%;" class="right">P.U</th>
                        <th style="width: 15%;" class="right">TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                        <tr>
                            <td>{{ $item->ref_code }}</td>
                            <td>{{ $item->description }}</td>
                            <td class="right">{{ number_format($item->quantity, 2) }}</td>
                            <td class="right">{{ number_format($item->unit_price, 2) }}</td>
                            <td class="right">{{ number_format($item->total_price, 2) }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="4" class="right"><strong>Sous-total</strong></td>
                        <td class="right"><strong>{{ number_format($items->sum('total_price'), 2) }}</strong></td>
                    </tr>
                </tbody>
            </table>
        @endif
    @endforeach
    <table>
        <tr>
            <td colspan="4" class="right"><strong>Total général</strong></td>
            <td class="right"><strong>{{ number_format($globalInvoice->total_amount, 2) }} USD</strong></td>
        </tr>
    </table>

    <p><strong>Montant en lettres :</strong> {{ amountToWords($globalInvoice->total_amount ?? 0) }}</p>
    <p>Numéro compte : TMB 00017-25000-00232100001-85 USD</p>
    <p>Mode de paiement : Provision</p>

    <p class="right" style="margin-top: 10px;">CHRISTELLE NTANGA<br><strong>RESP FACTURATION</strong></p>

    <hr style="border: none; border-top: 1px solid #333;">
    <p class="center" style="font-size: 8px;">
        960, Av. Chaussée Laurent Désiré Kabila, Immeuble Méthodiste, 2ème étage – Quartier Makatano, Commune de
        Lubumbashi<br>
        Tél : (+243)998180745, (+243)815056461, (+243)0977960987 – E-mail : mannedesbraves@yahoo.fr<br>
        Représentations : Kinshasa - Matadi - Kasumbalesa - Kolwezi
    </p>
    <p class="center" style="font-size: 8px;">Veuillez vous référer à la facture partielle.</p>

</body>

</html>
