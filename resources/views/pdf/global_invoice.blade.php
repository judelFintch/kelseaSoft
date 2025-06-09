@php use Carbon\Carbon; @endphp

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Facture Globale</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 4px; text-align: left; }
        .no-border td, .no-border th { border: none; }
        .center { text-align: center; }
        .right { text-align: right; }
    </style>
</head>

<body>
    <table class="no-border" style="margin-bottom: 10px;">
        <tr>
            <td style="width: 40%;">
                <img src="{{ public_path('images/logo.png') }}" alt="Logo" style="max-height: 90px;">
            </td>
            <td style="text-align: center;">
                <h2 style="margin: 0;">LA MANNE DES BRAVES S.A.R.L</h2>
                <p style="margin: 0;">TRANSITAIRE EN DOUANE OFFICIEL</p>
                <p style="margin: 0;">VOTRE SATISFACTION, C'EST NOTRE AFFAIRE</p>
                <p style="margin: 0;">N° Impôt : A1000859K RCCM : CDL/SHR/RCM15-B3463</p>
                <p style="margin: 0;">ID. NAT : 05-H1901-N57656K NUMÉRO AGREMENT : 000188</p>
            </td>
        </tr>
    </table>

    <h3 class="center" style="border: 1px solid black; padding: 5px;">FACTURE GLOBALE N° {{ $globalInvoice->global_invoice_number }}</h3>

    <table class="no-border">
        <tr>
            <td>
                <strong>Client :</strong><br>
                {{ $globalInvoice->company->name }}<br>
                {{ $globalInvoice->company->physical_address ?? 'N/A' }}<br>
                NIF : {{ $globalInvoice->company->tax_id ?? 'N/A' }}
            </td>
            <td class="right" style="border: 1px solid black; padding-left: 10px;">
                Lubumbashi le {{ Carbon::parse($globalInvoice->issue_date)->format('d/m/Y') }}<br><br>
                <strong>NOTRE COMPTE</strong> 1081911
            </td>
        </tr>
    </table>



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
