<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Confirmação de Novo E-mail</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f6f6f6; padding: 30px;">
    <div style="max-width: 600px; background-color: #ffffff; padding: 20px; margin: auto; border-radius: 8px;">
        <h2 style="color: #333;">Olá, {{ $usuario->nome_completo }} 👋</h2>
        <p style="font-size: 16px; color: #555;">
            Recebemos uma solicitação para trocar o seu e-mail. Para confirmar, clique no botão abaixo:
        </p>

        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ $link }}" style="background-color: #14ba88; color: #fff; padding: 12px 24px; border-radius: 6px; text-decoration: none;">
                Confirmar novo e-mail
            </a>
        </div>

        <p style="font-size: 14px; color: #999;">
            Se você não solicitou essa alteração, ignore este e-mail.
        </p>
    </div>
</body>
</html>
