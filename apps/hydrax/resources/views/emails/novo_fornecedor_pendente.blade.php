<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <title>Hydrax - Novo Fornecedor Pendente</title>
  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@600&family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>
<body style="margin:0; padding:0; background: linear-gradient(135deg, #1a1a2e, #2c1365, #1b1b3c); font-family: 'Poppins', sans-serif; color: white;">

  <table width="100%" cellpadding="0" cellspacing="0" style="padding: 40px 0;">
    <tr>
      <td align="center">
        <table width="600" cellpadding="0" cellspacing="0" style="background: rgba(20, 20, 40, 0.95); border-radius: 16px; overflow: hidden; box-shadow: 0 0 30px rgba(99,102,241,0.5); backdrop-filter: blur(10px);">

          <!-- Cabeçalho -->
          <tr>
            <td style="padding: 30px; text-align: center; background: linear-gradient(to right, #6366f1, #8b5cf6, #9333ea);">
              <h1 style="margin: 0; font-size: 32px; font-family: 'Orbitron', sans-serif; color: #ffffff; text-shadow: 0 0 8px rgba(255,255,255,0.3);">Hydrax</h1>
              <p style="margin: 6px 0 0; font-size: 15px; color: #e0e7ff;">Novo Fornecedor Pendente</p>
            </td>
          </tr>

          <!-- Corpo -->
          <tr>
            <td style="padding: 40px; background-color: #111827;">
              <h2 style="color: #93c5fd; margin-bottom: 18px; font-size: 20px;">Novo fornecedor aguardando aprovação</h2>
              <p style="margin-bottom: 24px; line-height: 1.7; color: #d1d5db; font-size: 15px;">
                Abaixo estão os detalhes do novo fornecedor aguardando aprovação no sistema:
              </p>

              <table width="100%" style="margin-bottom: 20px;">
                <tr>
                  <td style="color: #d1d5db; font-size: 15px;">
                    <strong>Empresa:</strong> {{ $fornecedor->nome_empresa }}
                  </td>
                </tr>
                <tr>
                  <td style="color: #d1d5db; font-size: 15px;">
                    <strong>CNPJ:</strong> {{ $fornecedor->cnpj }}
                  </td>
                </tr>
                <tr>
                  <td style="color: #d1d5db; font-size: 15px;">
                    <strong>Email:</strong> {{ $fornecedor->email }}
                  </td>
                </tr>
                <tr>
                  <td style="color: #d1d5db; font-size: 15px;">
                    <strong>Telefone:</strong> {{ $fornecedor->telefone }}
                  </td>
                </tr>
              </table>

              <p style="margin-top: 30px; margin-bottom: 20px; color: #9ca3af; font-size: 14px;">
                Para ver os fornecedores pendentes, clique no link abaixo:
              </p>

              <div style="text-align: center;">
                <a href="{{ url('/admin/fornecedores/pendentes') }}" style="background: linear-gradient(90deg, #4f46e5, #9333ea); color: #ffffff; padding: 12px 24px; border-radius: 8px; font-weight: bold; text-decoration: none; box-shadow: 0 0 8px rgba(147,51,234,0.5);">
                  Ver Fornecedores Pendentes
                </a>
              </div>

              <p style="font-size: 13px; color: #6b7280; margin-top: 30px;">
                Atenciosamente,<br />Equipe <strong style="color:#818cf8;">SURA_CGKRY</strong>
              </p>
            </td>
          </tr>

          <!-- Rodapé -->
          <tr>
            <td style="padding: 25px; text-align: center; background-color: #1f2937; font-size: 12px; color: #9ca3af;">
              &copy; 2025 Hydrax - Todos os direitos reservados<br />
              <a href="https://www.hydrax.com" style="color: #8b5cf6; text-decoration: none;">www.hydrax.com</a>
            </td>
          </tr>

        </table>
      </td>
    </tr>
  </table>

</body>
</html>
