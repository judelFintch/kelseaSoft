@php
    $formattedAddress = wordwrap('960, Av. Chaussée Laurent Désiré Kabila, Immeuble Méthodiste, 2ème étage – Quartier Makatano, Commune de Lubumbashi', 39, "\n", true);
@endphp
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Rapport Transactions</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            margin: 5px;
        }
        h2, h3, p { margin: 0; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 2px; }
        th, td { border: 1px solid #000; padding: 2px; }
        .no-border td, .no-border th { border: none; }
        .center { text-align: center; }
        .right { text-align: right; }
    </style>
</head>
<body>
    <table class="no-border" style="margin-bottom: 10px;">
        <colgroup>
            <col style="width: 22%;">
            <col style="width: 78%;">
        </colgroup>
        <tr>
            <td style="vertical-align: middle; padding: 0;">
                <img src="{{ public_path('images/logo.png') }}" alt="Logo" style="max-height: 105px; margin-left: 30px;" />
            </td>
            <td style="text-align: left; vertical-align: top; padding: 0;">
                <h2 style="margin-left: 1px; font-size: 24px;">LA MANNE DES BRAVES S.A.R.L</h2>
                <p style="margin-left: 20px; font-size: 17px; font-weight: bold;">TRANSITAIRE EN DOUANE OFFICIEL</p>
                <p style="margin-left: 25px; font-size: 13px; font-weight: bold;">VOTRE SATISFACTION, C'EST NOTRE AFFAIRE</p>
                <p style="margin-left: 30px; font-size: 11px;">N° Impôt : A1000859X &nbsp;&nbsp; RCCM : CD/LSHI/RCCM15-B3463</p>
                <p style="margin-left: 45px; font-size: 11px;">ID. NAT : 05-H1901-N57656K &nbsp;&nbsp; AGRÉMENT : 000188</p>
            </td>
        </tr>
    </table>

    <h3 class="center" style="border: 1px solid black; padding: 2px;">RAPPORT DE TRANSACTIONS DU DOSSIER N° {{ $folder->folder_number }}</h3>

    <table class="no-border" style="margin-bottom: 10px;">
        <tr>
            <td><strong>Client :</strong> {{ $folder->client }}</td>
            <td class="right"><strong>Date :</strong> {{ optional($folder->folder_date)->format('d/m/Y') }}</td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th style="width: 80px;">Date</th>
                <th style="width: 200px;">Libellé</th>
                <th style="width: 60px;">Type</th>
                <th style="width: 100px;" class="right">Montant</th>
                <th style="width: 60px;">Devise</th>
                <th style="width: 100px;">Caisse</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $t)
                <tr>
                    <td>{{ optional($t->transaction_date)->format('d/m/Y') }}</td>
                    <td>{{ $t->label }}</td>
                    <td>{{ $t->type === 'income' ? 'Perçu' : 'Dépense' }}</td>
                    <td class="right">{{ $t->type === 'income' ? '+' : '-' }}{{ number_format($t->amount, 2, ',', ' ') }}</td>
                    <td>{{ $t->currency->code ?? '' }}</td>
                    <td>{{ $t->cashRegister->name ?? '-' }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="3" class="right"><strong>Total perçu</strong></td>
                <td class="right">{{ number_format($income, 2, ',', ' ') }}</td>
                <td>{{ $folder->currency->code ?? '' }}</td>
                <td></td>
            </tr>
            <tr>
                <td colspan="3" class="right"><strong>Total sortie</strong></td>
                <td class="right">{{ number_format($expense, 2, ',', ' ') }}</td>
                <td>{{ $folder->currency->code ?? '' }}</td>
                <td></td>
            </tr>
            <tr>
                <td colspan="3" class="right"><strong>Solde</strong></td>
                <td class="right">{{ $balance >= 0 ? '+' : '-' }}{{ number_format(abs($balance), 2, ',', ' ') }}</td>
                <td>{{ $folder->currency->code ?? '' }}</td>
                <td></td>
            </tr>
        </tbody>
    </table>

    <p class="center" style="font-size: 11px;">
        960, Av. Chaussée Laurent Désiré Kabila, Immeuble Méthodiste, 2ème étage – Quartier Makatano, Commune de Lubumbashi<br>
        Tél : (+243)998180745, (+243)815056461, (+243)0977960987 – E-mail : mannedesbraves@yahoo.fr<br>
        Représentations : Kinshasa - Matadi - Kasumbalesa - Kolwezi
    </p>
</body>
</html>
