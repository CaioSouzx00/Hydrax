<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Seu carrinho está esperando!</title>
</head>
<body style="margin:0; padding:0; font-family: Arial, sans-serif; background-color:#111; color:#fff;">
  <table width="100%" cellpadding="0" cellspacing="0" style="max-width:600px; margin:auto; background-color:#1a1a1a; border-radius:12px; padding:20px;">
    <tr>
      <td>
        <h1 style="color:#fff; text-align:center;">Seu carrinho está esperando! 🛒</h1>
        <p style="color:#ccc; text-align:center;">Não deixe seus produtos favoritos acabarem no estoque.</p>
      </td>
    </tr>

    @php $total = 0; @endphp
    @foreach($carrinho->itens as $item)
      @php 
        $subtotal = $item->quantidade * $item->produto->preco;
        $total += $subtotal;
        $fotos = json_decode($item->produto->fotos ?? '[]', true);
        $foto = $fotos[0] ?? null;
      @endphp
      <tr>
        <td style="padding:15px; border-bottom:1px solid #333;">
          <table width="100%" cellpadding="0" cellspacing="0">
            <tr>
              <td width="80">
                <img src="{{ $foto ? asset('storage/' . $foto) : 'https://via.placeholder.com/100' }}" alt="{{ $item->produto->nome }}" style="width:80px; height:80px; object-fit:cover; border-radius:8px;">
              </td>
              <td style="padding-left:15px; vertical-align:top; color:#fff;">
                <p style="margin:0; font-weight:bold;">{{ $item->produto->nome }}</p>
                <p style="margin:2px 0; color:#aaa;">Tamanho: {{ $item->tamanho ?? 'Único' }}</p>
                <p style="margin:2px 0; color:#aaa;">Qtd: {{ $item->quantidade }}</p>
                <p style="margin:2px 0;">Preço: <strong>R$ {{ number_format($item->produto->preco, 2, ',', '.') }}</strong></p>
                <p style="margin:2px 0;">Subtotal: <strong>R$ {{ number_format($subtotal, 2, ',', '.') }}</strong></p>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    @endforeach

    <tr>
      <td style="padding:20px; text-align:center; color:#fff;">
        <h2>Total: R$ {{ number_format($total + 15, 2, ',', '.') }} (com entrega)</h2>
        <a href="{{ route('carrinho.finalizar') }}" style="display:inline-block; margin-top:15px; padding:12px 24px; background:#fff; color:#000; font-weight:bold; border-radius:8px; text-decoration:none;">FINALIZAR COMPRA</a>
      </td>
    </tr>

    <tr>
      <td style="padding:20px; text-align:center; color:#aaa; font-size:12px;">
        Pagamento seguro com:  
        <br>
        <img src="https://upload.wikimedia.org/wikipedia/commons/0/04/Visa.svg" style="height:20px; margin:5px;">
        <img src="https://upload.wikimedia.org/wikipedia/commons/2/2a/Mastercard-logo.svg" style="height:20px; margin:5px;">
        <img src="https://logospng.org/download/pix/logo-pix-icone-1024.png" style="height:20px; margin:5px;">
      </td>
    </tr>
  </table>
</body>
</html>
