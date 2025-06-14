@php use Carbon\Carbon; @endphp

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Facture Globale</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            margin: 10px;
        }

        h2,
        h3,
        h4,
        p {
            margin: 2px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 6px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 3px;
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
    {{-- En-tête centré --}}
    <{{-- En-tête société --}} <table class="no-border" style="width: 100%; margin-bottom: 10px; border-collapse: collapse;">
        <tr>
            <td style="width: 22%; vertical-align: middle; text-align: left;">
                <img src="{{ public_path('images/logo.png') }}" alt="Logo" style="max-height: 90px;">
            </td>
            <td style="width: 78%; vertical-align: middle; text-align: center; padding-left: 10px;">
                <h2 style="margin: 0; font-size: 16px;">LA MANNE DES BRAVES S.A.R.L</h2>
                <p style="margin: 2px 0; font-size: 11px; font-weight: bold;">
                    TRANSITAIRE EN DOUANE OFFICIEL – VOTRE SATISFACTION, C'EST NOTRE AFFAIRE
                </br>
                </p>
                <p style="margin: 2px 0; font-size: 10px;">
                    N° Impôt : A1000859K &nbsp;&nbsp;&nbsp; RCCM : CDL/SHR/RCM15-B3463
                </p>
                <p style="margin: 2px 0; font-size: 10px;">
                    ID. NAT : 05-H1901-N57656K &nbsp;&nbsp;&nbsp; NUMÉRO AGREMENT : 000188
                </p>
            </td>
        </tr>
        </table>


        <h3 class="center" style="border: 1px solid black; padding: 4px;">FACTURE GLOBALE N°
            {{ $globalInvoice->global_invoice_number }}</h3>

        {{-- Infos client --}}
        <table class="no-border">
            <tr>
                <td>
                    <strong>Client :</strong><br>
                    {{ $globalInvoice->company->name }}<br>
                    {{ $globalInvoice->company->physical_address ?? 'N/A' }}<br>
                    NIF : {{ $globalInvoice->company->tax_id ?? 'N/A' }}
                </td>
                <td class="right">
                    Lubumbashi le {{ Carbon::parse($globalInvoice->issue_date)->format('d/m/Y') }}<br><br>
                    <strong>NOTRE COMPTE</strong> 1081911
                </td>
            </tr>
        </table>

        {{-- Détails des catégories --}}
        @php
            $categories = [
                'import_tax' => 'A. IMPORT DUTY & TAXES',
                'agency_fee' => 'B. AGENCY FEES',
                'extra_fee' => 'C. AUTRES FRAIS',
            ];
        @endphp

        @foreach ($categories as $cat => $label)
            @php
                $items = $globalInvoice->globalInvoiceItems->where('category', $cat);
                $subtotal = $items->sum('total_price');
            @endphp
            @if ($items->count())
                <h4>{{ $label }}</h4>
                <table>
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th class="right" style="width:15%;">Quantité</th>
                            <th class="right" style="width:20%;">Prix Unitaire</th>
                            <th class="right" style="width:20%;">Prix Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                            <tr>
                                <td>{{ $item->description }}</td>
                                <td class="right">{{ number_format($item->quantity, 2, ',', ' ') }}</td>
                                <td class="right">{{ number_format($item->unit_price, 2, ',', ' ') }}</td>
                                <td class="right">{{ number_format($item->total_price, 2, ',', ' ') }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="3" class="right"><strong>Sous-total</strong></td>
                            <td class="right"><strong>{{ number_format($subtotal, 2, ',', ' ') }}</strong></td>
                        </tr>
                    </tbody>
                </table>
            @endif
        @endforeach

        {{-- Total général --}}
        <table>
            <tr>
                <td class="right"><strong>MONTANT TOTAL :</strong></td>
                <td class="right"><strong>{{ number_format($globalInvoice->total_amount, 2, ',', ' ') }}</strong></td>
            </tr>
        </table>

        {{-- Notes éventuelles --}}
        @if ($globalInvoice->notes)
            <div style="margin-top: 8px;">
                <h4>Notes :</h4>
                <p>{!! nl2br(e($globalInvoice->notes)) !!}</p>
            </div>
        @endif

        {{-- Footer --}}
        <p style="margin-top: 6px;">Nous disons, Dollars Américains, Quatre Mille Vingt, quatre centimes</p>
        <p>Numéro compte : TMB 00017-25000-00232100001-85 USD</p>
        <p>Mode de paiement : Provision</p>

        <p class="right" style="margin-top: 10px;">CHRISTELLE NTANGA<br><strong>RESP FACTURATION</strong></p>

        <p class="center" style="margin-top: 6px; font-size: 9px;">
            960, Av. Chaussée Laurent Désiré Kabila, Immeuble Méthodiste, 2ème étage<br>
            Quartier Makatano, Commune de Lubumbashi<br>
            Tél : (+243)998180745, (+243)815056461, (+243)0977960987<br>
            E-mail : mannedesbraves@yahoo.fr, infos@mannedesbraves.com<br>
            Représentations : Kinshasa - Matadi - Kasumbalesa - Kolwezi
        </p>
</body>

</html>
