<?php

namespace App\Http\Controllers;

use App\Http\Requests\Endereco\StoreEnderecoRequest;
use App\Http\Requests\Endereco\UpdateEnderecoRequest;
use App\Services\Endereco\EnderecoService;
use App\Models\EnderecoUsuario;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Controller responsável pelas operações relacionadas a endereços de usuários.
 * 
 * Refatorado seguindo Clean Code e SOLID:
 * - Validações movidas para Form Requests
 * - Lógica de negócio extraída para EnderecoService
 * - Controller mantém apenas orquestração e respostas HTTP
 */
class EnderecoUsuarioController extends Controller
{
    /**
     * Service de endereço injetado via construtor.
     *
     * @var EnderecoService
     */
    protected EnderecoService $enderecoService;

    /**
     * Construtor com injeção de dependência do Service.
     *
     * @param EnderecoService $enderecoService
     */
    public function __construct(EnderecoService $enderecoService)
    {
        $this->enderecoService = $enderecoService;
    }

    /**
     * Exibe o formulário de criação de endereço.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $usuario = Auth::guard('usuarios')->user();
        return view('usuarios.partials.create', compact('usuario'));
    }

    /**
     * Armazena um novo endereço.
     * 
     * Validação via StoreEnderecoRequest.
     * Lógica de negócio delegada ao EnderecoService.
     *
     * @param StoreEnderecoRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreEnderecoRequest $request)
    {
        $usuario = Auth::guard('usuarios')->user();
        $dados = $request->validated();

        try {
            $this->enderecoService->criarEndereco($usuario->id_usuarios, $dados);

            return redirect()
                ->route('carrinho.finalizar')
                ->with('success', 'Endereço cadastrado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['limite' => $e->getMessage()]);
        }
    }

    /**
     * Lista todos os endereços do usuário.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $usuario = Auth::guard('usuarios')->user();
        $enderecos = EnderecoUsuario::where('id_usuarios', $usuario->id_usuarios)->get();

        return view('usuarios.partials.enderecos', compact('usuario', 'enderecos'));
    }

    /**
     * Exibe o formulário de edição de endereço.
     *
     * @param EnderecoUsuario $endereco
     * @return \Illuminate\View\View
     */
    public function edit(EnderecoUsuario $endereco)
    {
        $usuario = Auth::guard('usuarios')->user();

        // Garante que o endereço pertence ao usuário logado
        if (!$this->enderecoService->pertenceAoUsuario($endereco, $usuario->id_usuarios)) {
            abort(403, 'Acesso negado');
        }

        return view('usuarios.partials.edit', compact('endereco'));
    }

    /**
     * Atualiza um endereço existente.
     * 
     * Validação via UpdateEnderecoRequest.
     * Lógica de negócio delegada ao EnderecoService.
     *
     * @param UpdateEnderecoRequest $request
     * @param EnderecoUsuario $endereco
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateEnderecoRequest $request, EnderecoUsuario $endereco)
    {
        $usuario = Auth::guard('usuarios')->user();

        if (!$this->enderecoService->pertenceAoUsuario($endereco, $usuario->id_usuarios)) {
            abort(403, 'Acesso negado');
        }

        $dados = $request->validated();
        $this->enderecoService->atualizarEndereco($endereco, $dados);

        return redirect()->route('usuario.painel')->with('success', 'Endereço atualizado com sucesso!');
    }

    /**
     * Exclui um endereço.
     *
     * @param EnderecoUsuario $endereco
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(EnderecoUsuario $endereco)
    {
        $endereco->delete();

        return redirect()->route('usuario.painel')->with('success', 'Endereço excluído com sucesso!');
    }

    /**
     * Exibe endereços de um usuário específico (método auxiliar).
     *
     * @param int $id ID do usuário
     * @return \Illuminate\View\View
     */
    public function conteudo($id)
    {
        $usuario = Usuario::findOrFail($id);
        $enderecos = EnderecoUsuario::where('id_usuarios', $id)->get();

        return view('usuarios.partials.enderecos', compact('usuario', 'enderecos'));
    }
}
