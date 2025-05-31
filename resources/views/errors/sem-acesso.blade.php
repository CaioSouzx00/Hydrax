<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Acesso Negado</title>
    <style>
        body {
            background: #f8fafc;
            font-family: 'Arial', sans-serif;
            text-align: center;
            padding-top: 100px;
            color: #1f2937;
        }

        h1 {
            font-size: 48px;
            color: #dc2626;
        }

        p {
            font-size: 18px;
            margin-top: 20px;
        }

        a {
            margin-top: 30px;
            display: inline-block;
            background: #3b82f6;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
        }

        a:hover {
            background: #2563eb;
        }
    </style>
</head>
<body>
    <h1>🚫 Acesso Negado</h1>
    <p>Você não tem permissão para acessar esta página.</p>
    <a href="{{ url('/') }}">Voltar para o início</a>
</body>
</html>
