<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuario;
use Illuminate\Support\Str;
use App\Models\PendingEmailChange;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailChangeConfirmation;
use App\Mail\CodigoRedefinicaoSenha;
use Illuminate\Support\Facades\DB;
use App\Models\ProdutoFornecedor;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use App\Models\ListaDesejo;



class UsuarioController extends Controller
{
    public function create()
    {
        return view('usuarios.create');
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'sexo'            => 'required|string',
            'nome_completo'   => 'required|string|max:50',
            'data_nascimento' => 'required|date',
            'email'           => 'required|email|unique:usuarios,email',
            'password'        => 'required|string|min:6',
            'telefone'        => 'required|string',
            'cpf'             => ['required', 'regex:/^\d{11}$/', 'unique:usuarios,cpf'],
            'foto'            => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'password.min' => 'A senha deve ter no mínimo 6 caracteres.',
            'cpf.regex'    => 'O CPF deve conter exatamente 11 dígitos numéricos.',
        ]);

        // Normaliza sexo para M ou F
        if (isset($dados['sexo'])) {
            $sexo         = strtolower($dados['sexo']);
            $dados['sexo'] = $sexo === 'masculino' ? 'M' : ($sexo === 'feminino' ? 'F' : null);
            if (!$dados['sexo']) {
                return back()->withErrors(['sexo' => 'Sexo inválido.'])->withInput();
            }
        }

        $dados['password'] = Hash::make($dados['password']);

        if ($request->hasFile('foto')) {
            $dados['foto'] = $request->file('foto')->store('fotos_usuario_final', 'public');
        }

        Usuario::create($dados);

        return redirect()->route('login.form')->with('success', 'Cadastro realizado com sucesso! Faça login para continuar.');
    }

    public function showLoginForm(Request $request)
    {
        if (Auth::guard('usuarios')->check()) {
            return redirect()->back()->withErrors([
                'login_ja_autenticado' => 'Você já está logado. Faça logout se quiser acessar a tela de login.'
            ]);
        }

        return view('usuarios.login');
    }

    public function login(Request $request)
    {
        $dados = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('usuarios')->attempt($dados)) {
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors(['login' => 'Credenciais inválidas'])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::guard('usuarios')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.form')->with('success', 'Você saiu do sistema.');
    }


  public function dashboard(Request $request)
{
    $usuario = auth()->guard('usuarios')->user(); // <<< adiciona esta linha

    // Usa o scope ativos() se existir
    $query = ProdutoFornecedor::ativos();

    // Últimos produtos (ex: últimos 4 adicionados, independente de filtro)
    $ultimosProdutos = ProdutoFornecedor::ativos()
                        ->orderBy('id_produtos', 'desc')
                        ->take(4)
                        ->get();


    // IDs dos produtos já na lista de desejos do usuário
    $idsDesejados = [];
    if ($usuario) {
        $idsDesejados = ListaDesejo::where('id_usuarios', $usuario->id)
                                   ->pluck('id_produtos')
                                   ->toArray();
    }

    // filtros simples
    if ($request->filled('genero')) {
        $query->where('genero', $request->genero);
    }

    if ($request->filled('categoria')) {
        $query->where('categoria', $request->categoria);
    }

    if ($request->filled('preco_min')) {
        $precoMin = floatval(str_replace(',', '.', $request->preco_min));
        $query->where('preco', '>=', $precoMin);
    }

    if ($request->filled('preco_max')) {
        $precoMax = floatval(str_replace(',', '.', $request->preco_max));
        $query->where('preco', '<=', $precoMax);
    }

    if ($request->filled('tamanho')) {
        $t = (string) $request->tamanho;
        $query->whereRaw('JSON_CONTAINS(tamanhos_disponiveis, ?)', ['"'.$t.'"']);
    }

// depois dos filtros
  // --- RANDOM (estável por sessão) ---
    $perPage = 21;
    $filterFingerprint = md5(json_encode($request->only(['genero','categoria','preco_min','preco_max','tamanho'])));
    $sessionKey = "produtos_random_seed_{$filterFingerprint}";

    // forçar novo embaralhamento via ?random=1
    if ($request->filled('random')) {
        $request->session()->forget($sessionKey);
    }

    $seed = $request->session()->get($sessionKey);
    if (!$seed) {
        $seed = mt_rand();
        $request->session()->put($sessionKey, $seed);
    }

    // remove qualquer orderBy anterior e aplica RAND(seed) — funciona no MySQL
    $produtosPaginados = $query
        ->reorder()
        ->orderByRaw('RAND(?)', [$seed])
        ->paginate($perPage)
        ->withQueryString();



    // Resposta AJAX
    if ($request->ajax()) {
        return response()->json([
            'html'       => view('usuarios.partials.produtos_cards', ['produtos' => $produtosPaginados, 'idsDesejados' => $idsDesejados])->render(),
            'pagination' => view('usuarios.partials.produtos_paginacao', ['produtos' => $produtosPaginados])->render(),
            'texto'      => $produtosPaginados->total() > 0
                ? "Exibindo {$produtosPaginados->firstItem()} a {$produtosPaginados->lastItem()} de {$produtosPaginados->total()} produtos"
                : "Nenhum produto encontrado"
        ]);
    }

$primeiroProduto = $produtosPaginados->first();

$variantes = $primeiroProduto
    ? ProdutoFornecedor::where('historico_modelos', $primeiroProduto->historico_modelos)
        ->get(['id_produtos', 'cor', 'slug', 'fotos', 'estoque_imagem'])
    : collect();


    // Retorno normal
    return view('usuarios.dashboard', [
        'produtos'        => $produtosPaginados,
        'ultimosProdutos' => $ultimosProdutos,
        'idsDesejados'    => $idsDesejados, 
        'variantes' => $variantes,
    ]);
}



    public function update(Request $request)
    {
        $usuario = Auth::guard('usuarios')->user();

        $dados = $request->validate([
            'nome_completo' => 'required|string|max:50',
        ]);

        $usuario->update($dados);

        return redirect()->back()->with('success', 'Perfil atualizado com sucesso!');
    }

    public function edit()
    {
        $usuario = Auth::guard('usuarios')->user();
        return view('usuarios.partials.perfil', compact('usuario'));
    }

    public function painel()
    {
        $usuario   = Auth::guard('usuarios')->user();
        $enderecos = $usuario->enderecos; // Relacionamento já deve existir no model
        return view('usuarios.perfil', compact('usuario', 'enderecos'));
    }

public function showEmailForm()
    {
        $usuario = Auth::guard('usuarios')->user();
        return view('usuarios.partials.email', compact('usuario'));
    }

    // Processar pedido de troca de e-mail e enviar o e-mail de confirmação
    public function updateEmailRequest(Request $request)
{
    $request->validate([
        'novo_email' => 'required|email|unique:usuarios,email|unique:pending_email_changes,novo_email',
    ]);

    $usuario = Auth::guard('usuarios')->user();

    if (!$usuario) {
        return redirect()->route('login.form')->withErrors('Você precisa estar logado para trocar o e-mail.');
    }

    $token = bin2hex(random_bytes(30));

    PendingEmailChange::create([
        'usuario_id' => $usuario->id_usuarios,
        'novo_email' => $request->input('novo_email'),
        'token'     => $token,
    ]);

    // Enviar email para o e-mail atual (não para o novo)
    Mail::to($usuario->email)->send(new EmailChangeConfirmation($usuario, $token));

    return redirect()->back()->with('success', 'Um e-mail de confirmação foi enviado para seu endereço atual.');
}


    // Confirmar troca de e-mail via token
   public function confirmarNovoEmail($token)
{
    $pending = PendingEmailChange::where('token', $token)->first();

    if (!$pending) {
        return redirect()->route('dashboard')->withErrors('Token inválido ou expirado.');
    }

    $usuario = Usuario::find($pending->usuario_id);

    if (!$usuario) {
        return redirect()->route('dashboard')->withErrors('Usuário não encontrado.');
    }

    // Atualiza e-mail do usuário
    $usuario->email = $pending->novo_email;
    $usuario->save();

    $pending->delete();

    return redirect()->route('dashboard')->with('success', 'Seu e-mail foi atualizado com sucesso!');
}



public function pesquisaProdutos(Request $request)
{
    $prompt = strtolower(trim($request->input('prompt', '')));

    // ====== SE O USUÁRIO NÃO DIGITA NADA =============
    if ($prompt === '') {
        return view('usuarios.produtos.resultados', [
            'produtos' => collect(),
            'prompt' => ''
        ]);
    }

    // ===============================
    // 1. LISTA DE SINÔNIMOS INTELIGENTES
    // ===============================
    $sinonimos = [
        'corrida' => ['running', 'run', 'correr', 'esporte'],
        'casual' => ['dia a dia', 'lifestyle', 'street'],
        'preto' => ['black', 'escuro'],
        'branco' => ['white', 'claro'],
        'masculino' => ['homem', 'macho', 'men'],
        'feminino' => ['mulher', 'women'],
        'unissex' => ['uni', 'ambos'],
        'adidas' => ['adi', 'adiads', 'addidas'],
        'nike' => ['naike', 'nk'],
        'puma' => ['pma'],
    ];

    // ===============================
    // 2. NORMALIZA TEXTO + ADICIONA SINÔNIMOS
    // ===============================
    $tokens = array_filter(explode(' ', $prompt)); // REMOVE STRINGS VAZIAS
    $expandidos = [];

    foreach ($tokens as $t) {
        $expandidos[] = $t;

        foreach ($sinonimos as $chave => $lista) {
            if (in_array($t, $lista)) {
                $expandidos[] = $chave;
            }
        }
    }

    $expandidos = array_unique(array_filter($expandidos)); // SEGURANÇA DUPLA

    // ===============================
    // 3. BUSCA SEMÂNTICA INTELIGENTE
    // ===============================
    $query = ProdutoFornecedor::query()
        ->with('rotulos')
        ->where('ativo', true);

    $query->where(function ($q) use ($expandidos) {
        foreach ($expandidos as $t) {

            if (strlen($t) < 2) continue; // IGNORA COISAS COMO "a", "e", "de"

            $like = "%{$t}%";

            // BUSCA PRINCIPAL
            $q->orWhere('nome', 'LIKE', $like)
              ->orWhere('descricao', 'LIKE', $like)
              ->orWhere('caracteristicas', 'LIKE', $like)
              ->orWhere('cor', 'LIKE', $like)
              ->orWhere('categoria', 'LIKE', $like)
              ->orWhere('genero', 'LIKE', $like);

            // RÓTULOS (PESO MAIOR)
            $q->orWhereHas('rotulos', function ($qr) use ($like) {
                $qr->where('marca', 'LIKE', $like)
                   ->orWhere('categoria', 'LIKE', $like)
                   ->orWhere('estilo', 'LIKE', $like)
                   ->orWhere('genero', 'LIKE', $like);
            });
        }
    });

    $resultados = $query->get();

    // ===============================
    // 4. RANKING DOS PRODUTOS (IA fake)
    // ===============================
    $ranked = $resultados->map(function ($produto) use ($expandidos) {

        $score = 0;

        foreach ($expandidos as $t) {

            if ($t === '' || strlen($t) < 2) continue;

            $score += substr_count(strtolower($produto->nome), $t) * 4;
            $score += substr_count(strtolower($produto->descricao), $t) * 2;
            $score += substr_count(strtolower($produto->caracteristicas), $t) * 2;
            $score += substr_count(strtolower($produto->cor), $t);

            foreach ($produto->rotulos as $r) {
                $campos = strtolower(
                    $r->marca . ' ' .
                    $r->categoria . ' ' .
                    $r->estilo . ' ' .
                    $r->genero
                );
                $score += substr_count($campos, $t) * 6;
            }
        }

        $produto->score = $score;
        return $produto;

    })->sortByDesc('score')->values();

    return view('usuarios.produtos.resultados', [
        'produtos' => $ranked,
        'prompt' => $prompt
    ]);
}
}