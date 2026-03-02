<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualização do Pedido</title>
</head>
<body style="font-family: Arial, sans-serif; background:#0b0b0b; color:#f1f1f1; padding:24px;">
    <div style="max-width:640px; margin:0 auto; background:#141414; border:1px solid #2a2a2a; border-radius:12px; padding:24px;">
        <h1 style="margin:0 0 12px; color:#14ba88;">Hydrax</h1>

        <p style="margin:0 0 16px;">Olá{{ $pedido->usuario?->nome_completo ? ', ' . $pedido->usuario->nome_completo : '' }}.</p>

        <p style="margin:0 0 16px;">
            Seu pedido <strong>#{{ $pedido->id }}</strong> foi atualizado.
        </p>

        <div style="background:#0b282a; border:1px solid rgba(20,186,136,0.25); border-radius:10px; padding:16px; margin:16px 0;">
            <p style="margin:0 0 8px;"><strong>Status:</strong> {{ strtoupper($pedido->status) }}</p>
            <p style="margin:0 0 8px;"><strong>Total:</strong> R$ {{ number_format($pedido->total, 2, ',', '.') }}</p>
            @if(!empty($pedido->codigo_rastreio))
                <p style="margin:0 0 8px;"><strong>Código de rastreio:</strong> {{ $pedido->codigo_rastreio }}</p>
            @endif
            @if(!empty($pedido->url_rastreio))
                <p style="margin:0;">
                    <a href="{{ $pedido->url_rastreio }}" target="_blank" rel="noopener noreferrer" style="color:#e29b37; text-decoration:underline;">Acompanhar entrega</a>
                </p>
            @endif
        </div>

        <h2 style="margin:18px 0 10px; font-size:16px; color:#e29b37;">Itens</h2>
        <ul style="margin:0; padding-left:18px;">
            @foreach($pedido->itens as $item)
                <li style="margin-bottom:6px;">
                    {{ $item->quantidade }}x {{ $item->produto?->nome ?? 'Produto' }}
                    @if(!empty($item->tamanho))
                        (tam. {{ $item->tamanho }})
                    @endif
                </li>
            @endforeach
        </ul>

        <p style="margin:18px 0 0; color:#b5b5b5; font-size:12px;">
            Se você não reconhece este pedido, entre em contato com o suporte.
        </p>
    </div>
</body>
</html>
