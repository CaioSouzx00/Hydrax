<?php

namespace App\Http\Controllers;

use App\Models\EnderecoUsuario;
use App\Models\Usuario;
use Illuminate\Http\Request;

class EnderecoUsuarioController extends Controller
{
    // Exibe o formulário de criação do endereço
    public function create($id)
    {
        $usuario = Usuario::findOrFail($id);
        return view('usuarios.enderecos.create', compact('usuario'));
    }

    // Processa o formulário de cadastro de endereço
    public function store(Request $request, $id)
    {
        $quantidadeEnderecos = EnderecoUsuario::where('id_usuarios', $id)->count();

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

        $enderecoExistente = EnderecoUsuario::where('id_usuarios', $id)
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
        $endereco->id_usuarios = $id;
        $endereco->save();

        return redirect()
            ->route('usuario.painel', $id)
            ->with('success', 'Endereço cadastrado com sucesso!');
    }

    // Exibe o formulário de edição do endereço
    public function edit($id, $endereco_id)
    {
        $usuario = Usuario::findOrFail($id);
        $endereco = $usuario->enderecos()->where('id_endereco', $endereco_id)->firstOrFail();

        return redirect()->route('usuario.enderecos', ['id' => $id])
        ->with('success', 'Endereço atualizado com sucesso!');
    }

public function update(Request $request, $id, $endereco_id)
{

    $validated = $request->validate([
        'cidade' => 'required|string|max:100',
        'cep' => 'required|string|max:15',
        'bairro' => 'required|string|max:100',
        'estado' => 'required|string|max:50',
        'rua' => 'required|string|max:255',
        'numero' => 'required|string|max:10',
    ]);

    $endereco = EnderecoUsuario::where('id_usuarios', $id)->where('id_endereco', $endereco_id)->firstOrFail();

    $endereco->update($validated);

    return redirect()->route('usuario.enderecos', ['id' => $id])
        ->with('success', 'Endereço atualizado com sucesso!');
}

    // Exibe todos os endereços de um usuário
    public function index($id)
    {
        $usuario = Usuario::findOrFail($id);
        $enderecos = EnderecoUsuario::where('id_usuarios', $id)->get();

       return view('usuarios.enderecos.index', compact('usuario', 'enderecos'));
    }

    // Remove um endereço
    public function destroy($id, $endereco_id)
    {
        $endereco = EnderecoUsuario::where('id_usuarios', $id)
            ->where('id_endereco', $endereco_id)
            ->firstOrFail();

        $endereco->delete();

        return redirect()->route('usuario.painel', ['id' => $id])->with('success', 'Endereço excluído com sucesso!');
    }


public function conteudo($id)
{
    $usuario = Usuario::findOrFail($id);
    $enderecos = EnderecoUsuario::where('id_usuarios', $id)->get();

    return view('usuarios.partials.enderecos', compact('usuario', 'enderecos'));
}

}