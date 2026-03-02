<div style="font-family: Arial, Helvetica, sans-serif; background-color:#ffffff; color:#000; padding:40px; max-width:600px; margin:0 auto; border:1px solid #e5e5e5;">
    
    <!-- Logo / Header -->
    <div style="text-align:center; margin-bottom:30px;">
        <h1 style="font-size:28px; font-weight:900; text-transform:uppercase; letter-spacing:2px; margin:0;">Hydrax</h1>
        <div style="width:60px; height:4px; background:#000; margin:12px auto 0;"></div>
    </div>

    <!-- Título -->
    <h2 style="font-size:22px; font-weight:700; margin:0 0 20px;">Pagamento Confirmado</h2>

    <!-- Texto -->
    <p style="font-size:15px; line-height:1.6; margin:0 0 20px;">
        Olá! Aqui está a sua chave Pix para finalizar o pagamento com segurança:
    </p>

    <!-- Caixa Pix -->
    <div style="font-size:22px; font-weight:700; background:#f8f8f8; border:1px solid #000; padding:16px; text-align:center; border-radius:12px; margin-bottom:25px;">
        {{ $chavePix }}
    </div>

    <!-- Total -->
    <p style="font-size:16px; margin:0 0 10px;"><strong>Total:</strong> R$ {{ number_format($total, 2, ',', '.') }}</p>

    <!-- Botão -->
    <div style="text-align:center; margin:30px 0;">
        <a href="#" style="background:#000; color:#fff; text-decoration:none; font-weight:bold; font-size:14px; padding:14px 28px; border-radius:30px; display:inline-block; text-transform:uppercase; letter-spacing:1px;">
            Finalizar Pagamento
        </a>
    </div>

    <!-- Footer -->
    <p style="font-size:12px; color:#666; line-height:1.5; text-align:center; margin-top:30px;">
        Se você não solicitou essa compra, por favor ignore este e-mail.<br>
        © Hydrax - Todos os direitos reservados
    </p>
</div>
