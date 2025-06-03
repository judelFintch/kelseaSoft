<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Facture Globale {{ $globalInvoice->global_invoice_number }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif; /* DejaVu Sans supporte bien les caractères UTF-8 */
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            margin: 0 auto;
            padding: 20px;
        }
        .header, .footer {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #222;
        }
        .company-details, .client-details {
            margin-bottom: 30px;
        }
        .company-details p, .client-details p {
            margin: 0;
            line-height: 1.6;
        }
        .company-details strong, .client-details strong {
            display: inline-block;
            min-width: 100px;
        }
        .invoice-info {
            text-align: right;
            margin-bottom: 30px;
        }
        .invoice-info p {
            margin: 0;
        }
        .invoice-title {
            text-align: center;
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 30px;
            color: #333;
            text-transform: uppercase;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        table th {
            background-color: #f4f4f4;
            font-weight: bold;
            color: #555;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .totals {
            margin-top: 20px;
            float: right; /* Pour aligner à droite */
            width: auto; /* Ajuster la largeur automatiquement */
        }
        .totals table {
            width: 100%; /* La table interne prendra la largeur de son conteneur .totals */
        }
        .totals table td {
            border: none;
            padding: 5px 8px;
        }
        .totals table tr.total-amount td {
            font-weight: bold;
            font-size: 1.2em;
            border-top: 2px solid #333;
        }
        .notes {
            margin-top: 40px;
            padding: 10px;
            border-top: 1px solid #eee;
        }
        .notes h4 {
            margin-top: 0;
            font-size: 14px;
        }
        .footer p {
            font-size: 10px;
            color: #777;
            border-top: 1px solid #eee;
            padding-top: 10px;
            margin-top: 30px;
        }
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
    </style>
</head>
<body>
    <div class="container">
        <table style="width: 100%; border: none;">
            <tr>
                <td style="width: 50%; border: none; vertical-align: top;">
                    <div class="company-details">
                        {{-- Informations de la compagnie émettrice --}}
                        {{-- Ces informations sont des placeholders et devraient être dynamiques --}}
                        <h2 style="margin-top: 0; margin-bottom: 10px; font-size: 18px;">{{ config('app.name', 'Votre Compagnie SARL') }}</h2>
                        <p>123 Rue de l'Exemple, Ville, Code Postal</p>
                        <p>Téléphone : +212 5 XX XX XX XX</p>
                        <p>Email : contact@votrecompagnie.com</p>
                        <p>NIF : XXXXXXXXX</p>
                        {{-- <p>ICE: XXXXXXXXXXXXXXXX</p> --}}
                        {{-- <p>RC: XXXXXX</p> --}}
                    </div>
                </td>
                <td style="width: 50%; border: none; vertical-align: top; text-align: right;">
                    <div class="invoice-info">
                        <h1 class="invoice-title" style="margin-top:0; margin-bottom: 20px; text-align:right;">FACTURE GLOBALE</h1>
                        <p><strong>Numéro :</strong> {{ $globalInvoice->global_invoice_number }}</p>
                        <p><strong>Date d'émission :</strong> {{ $globalInvoice->issue_date->format('d/m/Y') }}</p>
                        <p><strong>Date d'échéance :</strong> {{ $globalInvoice->due_date ? $globalInvoice->due_date->format('d/m/Y') : 'N/A' }}</p>
                    </div>
                </td>
            </tr>
        </table>

        @if($globalInvoice->company)
        <div class="client-details" style="margin-top: 30px; padding: 15px; border: 1px solid #eee;">
            <h3 style="margin-top:0; margin-bottom:10px; font-size:16px; color:#444;">Client :</h3>
            <p><strong>Nom :</strong> {{ $globalInvoice->company->name }}</p>
            <p><strong>Adresse :</strong> {{ $globalInvoice->company->physical_address ?? 'N/A' }}</p>
            <p><strong>NIF/Identifiant Fiscal :</strong> {{ $globalInvoice->company->tax_id ?? 'N/A' }}</p>
            {{-- Autres champs pertinents de la compagnie cliente --}}
        </div>
        @endif

        <table>
            <thead>
                <tr>
                    <th>Description</th>
                    <th class="text-right" style="width:15%;">Quantité</th>
                    <th class="text-right" style="width:20%;">Prix Unitaire</th>
                    <th class="text-right" style="width:20%;">Prix Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($globalInvoice->globalInvoiceItems as $item)
                    <tr>
                        <td>{{ $item->description }}</td>
                        <td class="text-right">{{ number_format($item->quantity, 2, ',', ' ') }}</td>
                        <td class="text-right">{{ number_format($item->unit_price, 2, ',', ' ') }} {{-- Devise --}}</td>
                        <td class="text-right">{{ number_format($item->total_price, 2, ',', ' ') }} {{-- Devise --}}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">Aucun article pour cette facture globale.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="clearfix">
            <div class="totals">
                <table>
                    {{-- Sous-total, TVA, etc. peuvent être ajoutés ici si nécessaire --}}
                    {{-- Exemple:
                    <tr>
                        <td class="text-right">Sous-Total :</td>
                        <td class="text-right">{{ number_format($globalInvoice->total_amount / 1.2, 2, ',', ' ') }} {{-- Devise --}}</td>
                    </tr>
                    <tr>
                        <td class="text-right">TVA (20%) :</td>
                        <td class="text-right">{{ number_format($globalInvoice->total_amount - ($globalInvoice->total_amount / 1.2), 2, ',', ' ') }} {{-- Devise --}}</td>
                    </tr>
                    --}}
                    <tr class="total-amount">
                        <td class="text-right" style="font-weight: bold;">MONTANT TOTAL :</td>
                        <td class="text-right" style="font-weight: bold;">{{ number_format($globalInvoice->total_amount, 2, ',', ' ') }} {{-- Devise --}}</td>
                    </tr>
                </table>
            </div>
        </div>

        @if($globalInvoice->notes)
        <div class="notes" style="margin-top: 60px; /* Plus d'espace si les totaux flottent */">
            <h4>Notes :</h4>
            <p>{{ nl2br(e($globalInvoice->notes)) }}</p>
        </div>
        @endif

        <div class="footer" style="margin-top: 50px;">
            <p>Termes de paiement : Payable à 30 jours net.</p>
            <p>
                Informations Bancaires : {{ config('app.bank_name', 'Nom de la Banque') }} -
                RIB : {{ config('app.bank_rib', 'XXXXXXXXXXXXXXXXXXXXXXXX') }}
            </p>
            <p>
                {{ config('app.name', 'Votre Compagnie SARL') }} -
                Capital : XX.XXX DHS -
                Mentions légales supplémentaires si nécessaire.
            </p>
        </div>
    </div>
</body>
</html>
