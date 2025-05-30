<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Facture - {{ $invoice->invoice_number }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #111;
            margin: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
        }
        th, td {
            border: 1px solid #999;
            padding: 6px;
            text-align: left;
        }
        .text-right {
            text-align: right;
        }
        .no-border td {
            border: none;
        }
        .section-title {
            background-color: #eee;
            font-weight: bold;
            padding: 8px;
        }
    </style>
</head>

<body>
    <div class="flex items-center justify-between mb-4">
        <div class="w-1/4">
            <img src="{{ public_path('storage/logos/la-manne-logo.png') }}" alt="Logo" class="h-20">
        </div>
        <center>
        <div class="w-3/4 text-center text-sm leading-tight">
            <h1 class="text-xl font-bold uppercase">LA MANNE DES BRAVES S.A.R.L</h1>
            <p>TRANSITAIRE EN DOUANE OFFICIEL</p>
            <p class="italic">VOTRE SATISFACTION, C’EST NOTRE AFFAIRE</p>
            <p>N° Impôt A1008059X &nbsp;&nbsp;&nbsp; RCCM : CD/LSH/RCCM/15-B3463</p>
            <p>ID.NAT 05-H4901-N57665K &nbsp;&nbsp;&nbsp; NUMÉRO AGRÉMENT 000188</p>
        </div>
        </center>
    </div>

    <hr class="border-t border-black my-2">

    <table class="no-border">
        <tr>
            <td><strong>Facture N° :</strong> {{ $invoice->invoice_number }}</td>
            <td><strong>Date :</strong> {{ $invoice->invoice_date->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <td><strong>Client :</strong> {{ $invoice->company->name }}</td>
            <td><strong>RCCM :</strong> {{ $invoice->company->rccm }}</td>
        </tr>
        <tr>
            <td><strong>N° Impôt :</strong> {{ $invoice->company->tax_number }}</td>
            <td><strong>Code Opération :</strong> {{ $invoice->operation_code }}</td>
        </tr>
    </table>

    <p class="section-title">Détails de l'opération</p>
    <table>
        <thead>
            <tr>
                <th>Produit</th>
                <th>Poids (Kg)</th>
                <th>FOB</th>
                <th>FRET</th>
                <th>Assurance</th>
                <th>CIF</th>
                <th>Devise</th>
                <th>Taux USD</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $invoice->product }}</td>
                <td class="text-right">{{ number_format($invoice->weight, 2) }}</td>
                <td class="text-right">{{ number_format($invoice->fob_amount, 2) }}</td>
                <td class="text-right">{{ number_format($invoice->freight_amount, 2) }}</td>
                <td class="text-right">{{ number_format($invoice->insurance_amount, 2) }}</td>
                <td class="text-right">{{ number_format($invoice->cif_amount, 2) }}</td>
                <td>{{ $invoice->currency->code?? ''}}</td>
                <td class="text-right">{{ number_format($invoice->exchange_rate, 2) }}</td>
            </tr>
        </tbody>
    </table>

    <p class="section-title">A. IMPORT DUTY & TAXES</p>
    <table>
        <tr>
            <th>Libellé</th>
            <th>Montant USD</th>
        </tr>
        @foreach ($invoice->items->where('category', 'import_tax') as $item)
            <tr>
                <td>{{ $item->label }}</td>
                <td class="text-right">{{ number_format($item->amount_usd, 2) }}</td>
            </tr>
        @endforeach
    </table>

    <p class="section-title">B. AGENCY FEES</p>
    <table>
        <tr>
            <th>Libellé</th>
            <th>Montant USD</th>
        </tr>
        @foreach ($invoice->items->where('category', 'agency_fee') as $item)
            <tr>
                <td>{{ $item->label }}</td>
                <td class="text-right">{{ number_format($item->amount_usd, 2) }}</td>
            </tr>
        @endforeach
    </table>

    <p class="section-title">C. AUTRES FRAIS</p>
    <table>
        <tr>
            <th>Libellé</th>
            <th>Montant USD</th>
        </tr>
        @foreach ($invoice->items->where('category', 'extra_fee') as $item)
            <tr>
                <td>{{ $item->label }}</td>
                <td class="text-right">{{ number_format($item->amount_usd, 2) }}</td>
            </tr>
        @endforeach
    </table>

    <p class="section-title">TOTAL À PAYER</p>
    <table>
        <tr>
            <th>Total en USD</th>
            <td class="text-right">{{ number_format($invoice->total_usd, 2) }} USD</td>
        </tr>
        <tr>
            <th>Montant Converti (CDF)</th>
            <td class="text-right">{{ number_format($invoice->converted_total, 2) }} CDF</td>
        </tr>
    </table>

    <div style="margin-top: 40px;">
        <p><strong>Compte Bancaire :</strong> EQUITY BANQUE CONGO S.A, N° 05024-01012784701-43</p>
        <p style="margin-top: 30px;"><strong>Signature et Cachet :</strong></p>
    </div>
</body>

</html>
