<?php

namespace App\Http\Controllers;

use App\Models\EnderecoUsuario;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnderecoUsuarioController extends Controller
{
public function create()
{
    $usuario = Auth::guard('usuarios')->user();
    return view('usuarios.partials.create', compact('usuario'));
}


    // Processa o formulário de cadastro de endereço
public function store(Request $request)
{
    $usuario = Auth::guard('usuarios')->user();

    $quantidadeEnderecos = EnderecoUsuario::where('id_usuarios', $usuario->id_usuarios)->count();

    if ($quantidadeEnderecos >= 3) {
        return redirect()->back()->withErrors(['limite' => 'Você já cadastrou o número máximo de 3 endereços.']);
    }

    $validated = $request->validate([
        'cidade' => 'required|string|max:60',
        'cep' => 'required|string|max:10',
        'bairro' => 'required|string|max:60',
        'estado' => 'required|string|size:2',
        'rua' => 'required|string|max:60',
        'numero' => 'required|string|max:10',
    ]);

    $enderecoExistente = EnderecoUsuario::where('id_usuarios', $usuario->id_usuarios)
        ->where('cidade', $validated['cidade'])
        ->where('cep', $validated['cep'])
        ->where('bairro', $validated['bairro'])
        ->where('estado', $validated['estado'])
        ->where('rua', $validated['rua'])
        ->where('numero', $validated['numero'])
        ->exists();

    if ($enderecoExistente) {
        return redirect()->back()->withErrors(['duplicado' => 'Este endereço já está cadastrado.']);
    }

    $endereco = new EnderecoUsuario($validated);
    $endereco->id_usuarios = $usuario->id_usuarios;
    $endereco->save();

    return redirect()
        ->route('usuario.painel')
        ->with('success', 'Endereço cadastrado com sucesso!');
}

public function index()
{
    $usuario = Auth::guard('usuarios')->user();
    $enderecos = EnderecoUsuario::where('id_usuarios', $usuario->id_usuarios)->get();

    return view('usuarios.partials.enderecos', compact('usuario', 'enderecos'));
}


    // Exibe o formulário para editar o endereço
    public function edit(EnderecoUsuario $endereco)
    {
        $usuario = Auth::guard('usuarios')->user();

        // Garante que o endereço pertence ao usuário logado
        if ($endereco->id_usuarios !== $usuario->id_usuarios) {
            abort(403, 'Acesso negado');
        }

        return view('usuarios.partials.edit', compact('endereco'));
    }

    // Atualiza o endereço no banco
    public function update(Request $request, EnderecoUsuario $endereco)
    {
        $usuario = Auth::guard('usuarios')->user();

        if ($endereco->id_usuarios !== $usuario->id_usuarios) {
            abort(403, 'Acesso negado');
        }

        $validated = $request->validate([
            'cidade' => 'required|string|max:60',
            'cep' => 'required|string|max:10',
            'bairro' => 'required|string|max:60',
            'estado' => 'required|string|size:2',
            'rua' => 'required|string|max:60',
            'numero' => 'required|string|max:10',
        ]);

        $endereco->update($validated);

        return redirect()->route('usuario.painel')->with('success', 'Endereço atualizado com sucesso!');
    }

public function destroy(EnderecoUsuario $endereco)
{
    $endereco->delete();

    return redirect()->route('usuario.painel')->with('success', 'Endereço excluído com sucesso!');
}




public function conteudo($id)
{
    $usuario = Usuario::findOrFail($id);
    $enderecos = EnderecoUsuario::where('id_usuarios', $id)->get();

    return view('usuarios.partials.enderecos', compact('usuario', 'enderecos'));
}

}