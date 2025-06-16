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
                <p><strong>Adresse :</strong> {{ $globalInvoice->company->physical_address ?? 'Aucune adresse' }}</p>
                <p><strong>Pays :</strong> {{ $globalInvoice->company->country ?? 'Non spécifié' }}</p>
                <p><strong>Email :</strong> {{ $globalInvoice->company->email ?? 'Non spécifié' }}</p>
            </td>
            <td class="right">
                <p>Lubumbashi le {{ \Carbon\Carbon::parse($globalInvoice->created_at)->format('d/m/Y') }}</p>
                <p><strong>NOTRE COMPTE</strong> 1081911</p>
            </td>
        </tr>
    </table>

    {{-- DÉTAILS DE LA FACTURE GLOBALE --}}
    <h4 style="border-top: 1px solid #000;">DÉTAILS FACTURE GLOBALE</h4>
    <table>
        <thead>
            <tr>
                <th style="width: 15%;">FACTURE N°</th>
                <th style="width: 60%;">DESCRIPTION</th>
                <th class="right" style="width: 25%;">MONTANT (USD)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($globalInvoice->globalInvoiceItems as $item)
                <tr>
                    <td>{{ $item->original_invoice_number }}</td>
                    <td>{{ $item->description }}</td>
                    <td class="right">{{ number_format($item->total_price, 2) }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="2" class="right"><strong>Total général</strong></td>
                <td class="right"><strong>{{ number_format($globalInvoice->total_amount, 2) }} USD</strong></td>
            </tr>
        </tbody>
    </table>

    <p class="right" style="margin-top: 10px;">CHRISTELLE NTANGA<br><strong>RESP FACTURATION</strong></p>

    <hr style="border: none; border-top: 1px solid #333;">
    <p class="center" style="font-size: 8px;">
        960, Av. Chaussée Laurent Désiré Kabila, Immeuble Méthodiste, 2ème étage – Quartier Makatano, Commune de
        Lubumbashi<br>
        Tél : (+243)998180745, (+243)815056461, (+243)0977960987 – E-mail : mannedesbraves@yahoo.fr<br>
        Représentations : Kinshasa - Matadi - Kasumbalesa - Kolwezi
    </p>

</body>

</html>
