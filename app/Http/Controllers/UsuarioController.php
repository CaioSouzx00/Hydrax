<?php

namespace App\Http\Controllers;

use App\Http\Requests\Usuario\StoreUsuarioRequest;
use App\Http\Requests\Usuario\UpdateUsuarioRequest;
use App\Http\Requests\Usuario\LoginUsuarioRequest;
use App\Http\Requests\Usuario\UpdateEmailRequest;
use App\Http\Requests\Usuario\CompletarCadastroRequest;
use App\Services\Usuario\UsuarioService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuario;
use App\Models\ProdutoFornecedor;
use App\Models\ListaDesejo;

/**
 * Controller responsável pelas operações relacionadas a usuários.
 * 
 * Refatorado seguindo Clean Code e SOLID:
 * - Validações movidas para Form Requests
 * - Lógica de negócio extraída para Services
 * - Controller mantém apenas orquestração e respostas HTTP
 */
class UsuarioController extends Controller
{
    /**
     * Service de usuário injetado via construtor.
     *
     * @var UsuarioService
     */
    protected UsuarioService $usuarioService;

    /**
     * Construtor com injeção de dependência do Service.
     *
     * @param UsuarioService $usuarioService
     */
    public function __construct(UsuarioService $usuarioService)
    {
        $this->usuarioService = $usuarioService;
    }

    /**
     * Exibe o formulário de cadastro.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('usuarios.create');
    }

    /**
     * Armazena um novo usuário.
     * 
     * Validação via StoreUsuarioRequest.
     * Lógica de negócio delegada ao UsuarioService.
     *
     * @param StoreUsuarioRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreUsuarioRequest $request)
    {
        $dados = $request->validated();
        
        // Incluir arquivo de foto se existir
        if ($request->hasFile('foto')) {
            $dados['foto'] = $request->file('foto');
        }

        $this->usuarioService->criarUsuario($dados);

        return redirect()->route('login.form')
            ->with('success', 'Cadastro realizado com sucesso! Faça login para continuar.');
    }

    /**
     * Exibe o formulário de login.
     *
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function showLoginForm(Request $request)
    {
        if (Auth::guard('usuarios')->check()) {
            return redirect()->back()->withErrors([
                'login_ja_autenticado' => 'Você já está logado. Faça logout se quiser acessar a tela de login.'
            ]);
        }

        return view('usuarios.login');
    }

    /**
     * Processa o login do usuário.
     * 
     * Validação via LoginUsuarioRequest.
     *
     * @param LoginUsuarioRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(LoginUsuarioRequest $request)
    {
        $credentials = $request->validated();

        if (Auth::guard('usuarios')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors(['login' => 'Credenciais inválidas'])->withInput();
    }

    /**
     * Processa o logout do usuário.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::guard('usuarios')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.form')->with('success', 'Você saiu do sistema.');
    }

    /**
     * Exibe o dashboard com produtos.
     *
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function dashboard(Request $request)
    {
        $usuario = auth()->guard('usuarios')->user();

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

        // Aplicar filtros
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
            $query->whereRaw('JSON_CONTAINS(tamanhos_disponiveis, ?)', ['"' . $t . '"']);
        }

        // RANDOM (estável por sessão)
        $perPage = 21;
        $filterFingerprint = md5(json_encode($request->only(['genero', 'categoria', 'preco_min', 'preco_max', 'tamanho'])));
        $sessionKey = "produtos_random_seed_{$filterFingerprint}";

        // Forçar novo embaralhamento via ?random=1
        if ($request->filled('random')) {
            $request->session()->forget($sessionKey);
        }

        $seed = $request->session()->get($sessionKey);
        if (!$seed) {
            $seed = mt_rand();
            $request->session()->put($sessionKey, $seed);
        }

        // Remove qualquer orderBy anterior e aplica RAND(seed)
        $produtosPaginados = $query
            ->reorder()
            ->orderByRaw('RAND(?)', [$seed])
            ->paginate($perPage)
            ->withQueryString();

        // Resposta AJAX
        if ($request->ajax()) {
            return response()->json([
                'html' => view('usuarios.partials.produtos_cards', [
                    'produtos' => $produtosPaginados,
                    'idsDesejados' => $idsDesejados
                ])->render(),
                'pagination' => view('usuarios.partials.produtos_paginacao', [
                    'produtos' => $produtosPaginados
                ])->render(),
                'texto' => $produtosPaginados->total() > 0
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
            'produtos' => $produtosPaginados,
            'ultimosProdutos' => $ultimosProdutos,
            'idsDesejados' => $idsDesejados,
            'variantes' => $variantes,
        ]);
    }

    /**
     * Atualiza o perfil do usuário.
     * 
     * Validação via UpdateUsuarioRequest.
     * Lógica de negócio delegada ao UsuarioService.
     *
     * @param UpdateUsuarioRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateUsuarioRequest $request)
    {
        $usuario = Auth::guard('usuarios')->user();
        $dados = $request->validated();

        $this->usuarioService->atualizarPerfil($usuario, $dados);

        return redirect()->back()->with('success', 'Perfil atualizado com sucesso!');
    }

    /**
     * Exibe o formulário de edição do perfil.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        $usuario = Auth::guard('usuarios')->user();
        return view('usuarios.partials.perfil', compact('usuario'));
    }

    /**
     * Exibe o painel do usuário.
     *
     * @return \Illuminate\View\View
     */
    public function painel()
    {
        $usuario = Auth::guard('usuarios')->user();
        $enderecos = $usuario->enderecos;
        return view('usuarios.perfil', compact('usuario', 'enderecos'));
    }

    /**
     * Exibe o formulário para troca de e-mail.
     *
     * @return \Illuminate\View\View
     */
    public function showEmailForm()
    {
        $usuario = Auth::guard('usuarios')->user();
        return view('usuarios.partials.email', compact('usuario'));
    }

    /**
     * Processa a solicitação de troca de e-mail.
     * 
     * Validação via UpdateEmailRequest.
     * Lógica de negócio delegada ao UsuarioService.
     *
     * @param UpdateEmailRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateEmailRequest(UpdateEmailRequest $request)
    {
        $usuario = Auth::guard('usuarios')->user();

        if (!$usuario) {
            return redirect()->route('login.form')->withErrors('Você precisa estar logado para trocar o e-mail.');
        }

        $this->usuarioService->solicitarTrocaEmail($usuario, $request->validated()['novo_email']);

        return redirect()->back()->with('success', 'Um e-mail de confirmação foi enviado para seu endereço atual.');
    }

    /**
     * Confirma a troca de e-mail via token.
     * 
     * Lógica de negócio delegada ao UsuarioService.
     *
     * @param string $token
     * @return \Illuminate\Http\RedirectResponse
     */
    public function confirmarNovoEmail($token)
    {
        $sucesso = $this->usuarioService->confirmarTrocaEmail($token);

        if (!$sucesso) {
            return redirect()->route('dashboard')->withErrors('Token inválido ou expirado.');
        }

        return redirect()->route('dashboard')->with('success', 'Seu e-mail foi atualizado com sucesso!');
    }

    /**
     * Exibe a página de pesquisa de produtos com IA.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function pesquisaProdutos(Request $request)
    {
        $prompt = strtolower(trim($request->input('prompt', '')));

        // Se o usuário não digita nada
        if ($prompt === '') {
            return view('usuarios.produtos.resultados', [
                'produtos' => collect(),
                'prompt' => ''
            ]);
        }

        // Lista de sinônimos inteligentes
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

        // Normaliza texto + adiciona sinônimos
        $tokens = array_filter(explode(' ', $prompt));
        $expandidos = [];

        foreach ($tokens as $t) {
            $expandidos[] = $t;
            foreach ($sinonimos as $chave => $lista) {
                if (in_array($t, $lista)) {
                    $expandidos[] = $chave;
                }
            }
        }

        $expandidos = array_unique(array_filter($expandidos));

        // Busca semântica inteligente
        $query = ProdutoFornecedor::query()
            ->with('rotulos')
            ->where('ativo', true);

        $query->where(function ($q) use ($expandidos) {
            foreach ($expandidos as $t) {
                if (strlen($t) < 2) continue;

                $like = "%{$t}%";

                // Busca principal
                $q->orWhere('nome', 'LIKE', $like)
                    ->orWhere('descricao', 'LIKE', $like)
                    ->orWhere('caracteristicas', 'LIKE', $like)
                    ->orWhere('cor', 'LIKE', $like)
                    ->orWhere('categoria', 'LIKE', $like)
                    ->orWhere('genero', 'LIKE', $like);

                // Rótulos (peso maior)
                $q->orWhereHas('rotulos', function ($qr) use ($like) {
                    $qr->where('marca', 'LIKE', $like)
                        ->orWhere('categoria', 'LIKE', $like)
                        ->orWhere('estilo', 'LIKE', $like)
                        ->orWhere('genero', 'LIKE', $like);
                });
            }
        });

        $resultados = $query->get();

        // Ranking dos produtos (IA fake)
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

    /**
     * Exibe o formulário para completar cadastro.
     *
     * @return \Illuminate\View\View
     */
    public function completarCadastroForm()
    {
        $user = Auth::guard('usuarios')->user();
        return view('usuarios.completar-cadastro', compact('user'));
    }

    /**
     * Processa o completamento do cadastro.
     * 
     * Validação via CompletarCadastroRequest.
     * Lógica de negócio delegada ao UsuarioService.
     *
     * @param CompletarCadastroRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function salvarCadastro(CompletarCadastroRequest $request)
    {
        $user = Auth::guard('usuarios')->user();
        $dados = $request->validated();

        $this->usuarioService->completarCadastro($user, $dados);

        return redirect()->route('dashboard')->with('success', 'Cadastro atualizado!');
    }
}
