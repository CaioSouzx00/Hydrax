<div style="font-family: Arial, sans-serif; padding:20px; background:#f4f4f4;">
    <h2 style="color:#000;">Pagamento Hydrax</h2>
    <p>Olá! Aqui está sua chave Pix para finalizar o pagamento:</p>

    <div style="font-size:20px; font-weight:bold; background:#fff; padding:12px; border-radius:8px; margin:10px 0;">
        {{ $chavePix }}
    </div>

    <p><strong>Total:</strong> R$ {{ number_format($total, 2, ',', '.') }}</p>

    <p style="font-size:12px; color:#666;">Se você não solicitou essa compra, ignore este e-mail.</p>
</div>
