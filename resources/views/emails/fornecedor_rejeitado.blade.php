<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <title>Hydrax - Cadastro Rejeitado</title>
  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@600&family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>
<body style="margin:0; padding:0; background: linear-gradient(135deg, #1a1a2e, #3b0a38, #1b1b3c); font-family: 'Poppins', sans-serif; color: white;">

  <table width="100%" cellpadding="0" cellspacing="0" style="padding: 40px 0;">
    <tr>
      <td align="center">
        <table width="600" cellpadding="0" cellspacing="0" style="background: rgba(20, 20, 40, 0.95); border-radius: 16px; overflow: hidden; box-shadow: 0 0 35px rgba(239,68,68,0.4); backdrop-filter: blur(12px);">

          <!-- Cabeçalho -->
          <tr>
            <td style="padding: 30px; text-align: center; background: linear-gradient(to right, #7f1d1d, #991b1b, #dc2626);">
              <h1 style="margin: 0; font-size: 32px; font-family: 'Orbitron', sans-serif; color: #ffffff; text-shadow: 0 0 10px rgba(255,0,0,0.5);">Hydrax</h1>
              <p style="margin: 6px 0 0; font-size: 16px; color: #fecaca;">Cadastro Rejeitado</p>
            </td>
          </tr>

          <!-- Corpo -->
          <tr>
            <td style="padding: 40px; background-color: #1e1b2e;">
              <h2 style="color: #f87171; margin-bottom: 18px; font-size: 20px;">Olá, {{ $fornecedor->nome_empresa }}</h2>
              <p style="margin-bottom: 24px; line-height: 1.7; color: #fca5a5; font-size: 15px;">
                Lamentamos informar que seu cadastro como fornecedor foi <strong style="color:#ef4444;">rejeitado</strong>.
              </p>

              <p style="margin-bottom: 24px; line-height: 1.7; color: #e2e8f0; font-size: 15px;">
                Isso pode ter ocorrido devido a inconsistências nas informações ou não cumprimento dos critérios estabelecidos.
              </p>

              <p style="margin-bottom: 24px; line-height: 1.7; color:rgb(253, 224, 109); font-size: 15px;">
                Caso deseje revisar seu cadastro ou obter mais detalhes, entre em contato com a nossa equipe.
              </p>

              <p style="font-size: 13px; color: #9ca3af; margin-top: 30px;">
                Atenciosamente,<br />Equipe <strong style="color:#818cf8;">SURA_CGKRY</strong>
              </p>
            </td>
          </tr>

          <!-- Rodapé -->
          <tr>
            <td style="padding: 25px; text-align: center; background-color: #111827; font-size: 12px; color: #9ca3af;">
              &copy; 2025 Hydrax - Todos os direitos reservados<br />
              <a href="https://www.hydrax.com" style="color: #f87171; text-decoration: none;">www.hydrax.com</a>
            </td>
          </tr>

        </table>
      </td>
    </tr>
  </table>

</body>
</html>
