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
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            margin: 5px;
            line-height: 1.1;
            font-size-adjust: 0.5;
        }

        h2,
        h3,
        h4,
        h5,
        p {
            margin: 2px 0;
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
            word-wrap: break-word;
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

        table,
        tr,
        td,
        th {
            page-break-inside: avoid;
        }

        .no-border {
            border: none;
        }
    </style>
</head>

<body>
    {{-- EN-TETE HARMONISÉ --}}
    <table class="no-border" style="width: 100%; border-collapse: collapse; margin-bottom: 10px;">
        <colgroup>
            <col style="width: 22%;">
            <col style="width: 78%;">
        </colgroup>
        <tr>
            {{-- Colonne logo --}}
            <td style="vertical-align: middle; padding: 0;">
                <img src="{{ public_path('images/logo.png') }}" alt="Logo"
                    style="max-height: 105px;  margin-left: 30px;" />
            </td>

            {{-- Colonne texte entreprise --}}
            <td style="text-align: left; vertical-align: top; padding: 0; ">
                <h2 style="margin-left: 1px; font-size: 24px;">LA MANNE DES BRAVES S.A.R.L</h2>
                <p style="margin-left: 20px; font-size: 17px; font-weight: bold;">TRANSITAIRE EN DOUANE OFFICIEL</p>
                <p style="margin-left: 25px; font-size: 13px; font-weight: bold;">VOTRE SATISFACTION, C'EST NOTRE
                    AFFAIRE</p>
                <p style="margin-left: 30px; font-size: 11px;">N° Impôt : A1000859X &nbsp;&nbsp; RCCM :
                    CD/LSHI/RCCM15-B3463</p>
                <p style="margin-left: 45px; font-size: 11px;">ID. NAT : 05-H1901-N57656K &nbsp;&nbsp; AGRÉMENT : 000188
                </p>
            </td>

        </tr>
    </table>

    <h3 class="center" style="border: 1px solid black; padding: 2px;">
        FACTURE GLOBALE N° {{ $globalInvoice->global_invoice_number }}
    </h3>

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


    @php
        $folders = $globalInvoice->invoices->load('folder')->pluck('folder')->filter();
        $declarationCount = $folders->filter(fn($f) => !empty($f->truck_number))->count();
        $truckCount = $folders->filter(fn($f) => !empty($f->truck_number))->unique('truck_number')->count();
        $scelleQty = $globalInvoice->globalInvoiceItems
            ->filter(fn($i) => str_contains(strtolower($i->description), 'scelle'))
            ->sum('quantity');
        $nacQty = $globalInvoice->globalInvoiceItems
            ->filter(fn($i) => str_contains(strtolower($i->description), 'nac'))
            ->sum('quantity');

        $scelleParDeclaration = $scelleQty;
        $scelleNewQty = $scelleParDeclaration;
    @endphp

    <table class="no-border" style="margin-bottom: 15px; margin-top: 10px;">
        <tr>
            <td><strong>Déclaration:</strong> {{ $declarationCount }}</td>
            <td><strong>Truck:</strong> {{ number_format($truckCount) }}</td>
            <td>
                <strong>Scellés:</strong> {{ number_format($scelleQty) }}
            </td>
            <td><strong>NAC:</strong> {{ number_format($nacQty) }}</td>

            <td><strong>PRODUIT:</strong> {{ $globalInvoice->product ?? '' }}</td>
        </tr>
    </table>

    @foreach (['import_tax' => 'A. IMPORT DUTY & TAXES', 'agency_fee' => 'B. AGENCY FEES', 'extra_fee' => 'C. AUTRES FRAIS'] as $cat => $label)
        @php $items = $globalInvoice->globalInvoiceItems->where('category', $cat); @endphp
        @if ($items->count())
            <h5 style="margin-top: 8px;">{{ $label }}</h5>
            <table>
                <thead>
                    <tr>
                        <th style="width: 15%;">RÉF.</th>
                        <th style="width: 10%;" class="right">NOMBRE</th>
                        <th style="width: 45%;">LIBELLÉ</th>
                        <th style="width: 15%;" class="right">TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        @php
                            $isScelle = str_contains(strtolower($item->ref_code), 'scelle');
                            $adjustedQty =
                                $isScelle && $scelleParDeclaration > 0
                                    ? round($item->total_price / $scelleParDeclaration, 2)
                                    : $item->quantity;
                        @endphp
                        <tr>
                            <td>{{ $item->ref_code }}</td>
                            {{-- QTÉ affichée selon scellé ou non --}}
                            @if ($isScelle)
                                <td class="right">{{ number_format($scelleQty, 2) }}</td>
                            @else
                                <td class="right">{{ number_format($adjustedQty, 2) }}</td>
                            @endif
                            <td>{{ $item->description }}</td>


                            {{-- TOTAL monétaire --}}
                            <td class="right">{{ number_format($item->total_price, 2) }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="3" class="right"><strong>Sous total</strong></td>
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

    <p class="right" style="margin-top: 10px; margin-bottom: 20px;">
        CHRISTELLE NTANGA <br>
        <strong>RESP FACTURATION</strong>
        <br><br><br><br><br><br>
    </p>

    <hr style="border: none; border-top: 1px solid #333;">

    <p class="center" style="font-size: 10px;">
        960, Av. Chaussée Laurent Désiré Kabila, Immeuble Méthodiste, 2ème étage – Quartier Makatano, Commune de
        Lubumbashi<br>
        Tél : (+243)998180745, (+243)815056461, (+243)0977960987 – E-mail : mannedesbraves@yahoo.fr<br>
        Représentations : Kinshasa – Matadi – Kasumbalesa – Kolwezi
    </p>

    <p class="center" style="font-size: 10px;">
        Veuillez vous référer à la facture partielle.
    </p>
</body>

</html>
