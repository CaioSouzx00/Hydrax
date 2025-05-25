<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <title>Hydrax - Cadastro Aprovado</title>
  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@600&family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>
<body style="margin:0; padding:0; background: linear-gradient(135deg, #0f172a, #0d1b1e, #030712); font-family: 'Poppins', sans-serif; color: white;">

  <table width="100%" cellpadding="0" cellspacing="0" style="padding: 40px 0;">
    <tr>
      <td align="center">
        <table width="600" cellpadding="0" cellspacing="0" style="background: rgba(15, 23, 42, 0.9); border-radius: 16px; overflow: hidden; box-shadow: 0 0 40px rgba(34,197,94,0.5); backdrop-filter: blur(12px);">

          <!-- Cabeçalho -->
          <tr>
            <td style="padding: 30px; text-align: center; background: linear-gradient(to right, #22c55e, #10b981, #059669);">
              <h1 style="margin: 0; font-size: 32px; font-family: 'Orbitron', sans-serif; color: #ffffff; text-shadow: 0 0 12px rgba(34,197,94,0.8); letter-spacing: 2px;">
                Hydrax
              </h1>
              <p style="margin: 6px 0 0; font-size: 16px; color: #d1fae5; font-weight: 600;">
                 Cadastro Aprovado
              </p>
            </td>
          </tr>

          <!-- Corpo -->
          <tr>
            <td style="padding: 40px; background-color: #0f172a;">
              <h2 style="color: #6ee7b7; margin-bottom: 18px; font-size: 22px; font-weight: 600;">
                Olá, {{ $fornecedor->nome_empresa }}
              </h2>

              <p style="margin-bottom: 24px; line-height: 1.7; color: #cbd5e1; font-size: 15px;">
                É com grande satisfação que informamos que seu cadastro como fornecedor foi <strong style="color:#22c55e;">aprovado</strong> com sucesso!
              </p>

              <p style="margin-bottom: 24px; line-height: 1.7; color: #cbd5e1; font-size: 15px;">
                Agora você já pode acessar o <strong style="color:#4ade80;">sistema Hydrax</strong> e aproveitar todos os recursos disponíveis para fornecedores. Faça o login para acessar sua conta.
              </p>

              <p style="margin-bottom: 24px; font-size: 15px; color: #86efac;">
                Seja bem-vindo à <strong style="color:#34d399;">rede Hydrax</strong>! Estamos animados com essa nova parceria.
              </p>

              <p style="font-size: 13px; color: #9ca3af; margin-top: 30px;">
                Atenciosamente,<br />Equipe <strong style="color:#4ade80;">SURA_CGKRY</strong>
              </p>
            </td>
          </tr>

          <!-- Rodapé -->
          <tr>
            <td style="padding: 25px; text-align: center; background-color: #1e293b; font-size: 12px; color: #9ca3af;">
              &copy; 2025 Hydrax - Todos os direitos reservados<br />
              <a href="https://www.hydrax.com" style="color: #34d399; text-decoration: none;">www.hydrax.com</a>
            </td>
          </tr>

        </table>
      </td>
    </tr>
  </table>

</body>
</html>
