<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Facture #{{ str_pad($paiement->id, 6, '0', STR_PAD_LEFT) }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #1e293b; margin: 0; padding: 0; }
        .p-10 { padding: 40px; }
        .header-table { width: 100%; border-bottom: 2px solid #e2e8f0; padding-bottom: 20px; margin-bottom: 30px; }
        .company-info h2 { font-size: 22px; color: #0f172a; margin: 0 0 5px 0; }
        .invoice-details { text-align: right; }
        .invoice-details h3 { font-size: 20px; color: #4f46e5; margin: 0 0 5px 0; }
        .section-title { font-size: 12px; font-weight: bold; text-transform: uppercase; color: #64748b; margin-bottom: 10px; border-bottom: 1px solid #f1f5f9; padding-bottom: 5px; }
        .info-grid { width: 100%; margin-bottom: 30px; }
        .info-grid td { vertical-align: top; width: 50%; }
        table.items { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        table.items th { background: #f8fafc; padding: 12px; text-align: left; color: #475569; border-bottom: 2px solid #e2e8f0; }
        table.items td { padding: 12px; border-bottom: 1px solid #f1f5f9; }
        .text-right { text-align: right; }
        .totals-container { width: 100%; margin-top: 20px; }
        .totals-table { float: right; width: 280px; border-collapse: collapse; }
        .total-row td { padding: 8px 0; border-bottom: 1px solid #f1f5f9; }
        .grand-total { background: #0f172a; color: #fff; padding: 15px; border-radius: 8px; margin-top: 10px; }
        .grand-total td { color: #fff; border: none; }
        .footer { position: fixed; bottom: 40px; left: 40px; right: 40px; border-top: 1px solid #e2e8f0; padding-top: 10px; text-align: center; color: #94a3b8; font-size: 9px; }
        .badge { background: #dcfce7; color: #166534; padding: 4px 10px; border-radius: 10px; font-weight: bold; font-size: 10px; }
    </style>
</head>
<body>
    <div class="p-10">
        <table class="header-table">
            <tr>
                <td>
                    <div class="company-info">
                        <h2>AUTO-ÉCOLE PRO</h2>
                        <p>123 Boulevard Mohamed V, Safi<br>
                        contact@auto-ecole.ma | +212 522 00 00 00</p>
                    </div>
                </td>
                <td class="invoice-details">
                    <h3>FACTURE</h3>
                    <p>N° #{{ str_pad($paiement->id, 6, '0', STR_PAD_LEFT) }}<br>
                    Date: {{ $paiement->updated_at->format('d/m/Y') }}<br>
                    <span class="badge">PAYÉ</span></p>
                </td>
            </tr>
        </table>

        <table class="info-grid">
            <tr>
                <td>
                    <div class="section-title">Facturé à :</div>
                    <strong>{{ $paiement->candidat->user->name }}</strong><br>
                    {{ $paiement->candidat->user->email }}<br>
                    Tél: {{ $paiement->candidat->user->phone }}
                </td>
                <td style="text-align: right;">
                    <div class="section-title">Mode de Paiement :</div>
                    Carte Bancaire (Simulation)<br>
                    ID Transaction: TXN-{{ strtoupper(\Illuminate\Support\Str::random(10)) }}
                </td>
            </tr>
        </table>

        <table class="items">
            <thead>
                <tr>
                    <th>Description de la prestation</th>
                    <th class="text-right">Montant</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <strong>Formation : {{ $paiement->formation->nom }}</strong><br>
                        <span style="color: #64748b; font-size: 10px;">{{ $paiement->formation->description }}</span>
                    </td>
                    <td class="text-right font-bold">{{ number_format($paiement->montant, 2, ',', ' ') }} DH</td>
                </tr>
                <tr>
                    <td>Frais de dossier et inscription</td>
                    <td class="text-right">0,00 DH</td>
                </tr>
            </tbody>
        </table>

        <div class="totals-container">
            <table class="totals-table">
                <tr class="total-row">
                    <td>Sous-total</td>
                    <td class="text-right">{{ number_format($paiement->montant, 2, ',', ' ') }} DH</td>
                </tr>
                <tr class="total-row">
                    <td>TVA (0%)</td>
                    <td class="text-right">0,00 DH</td>
                </tr>
                <tr class="grand-total">
                    <td style="font-size: 14px; font-weight: bold;">TOTAL PAYÉ</td>
                    <td class="text-right" style="font-size: 18px; font-weight: 800;">{{ number_format($paiement->montant, 2, ',', ' ') }} DH</td>
                </tr>
            </table>
        </div>

        <div style="clear: both; margin-top: 150px; padding: 20px; background: #fdf2f2; border: 1px dashed #ef4444; border-radius: 12px; font-size: 10px;">
            <strong>Note importante :</strong> Cette facture fait office de preuve de paiement. Elle est générée électroniquement et ne nécessite aucune signature manuscrite. Aucun remboursement n'est possible une fois la formation entamée.
        </div>

        <div class="footer">
            AUTO-ÉCOLE PRO – ICE: 001234567890001 | RC: 123456<br>
            Merci de votre confiance et bonne chance pour votre permis !
        </div>
    </div>
</body>
</html>
