<?php

namespace App\Http\Controllers;

use App\Models\ProdutoFornecedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProdutoFornecedorController extends Controller
{
    public function create()
    {
         return view('fornecedores.produtos.partials.create');
    }
public function store(Request $request)
{
    $fornecedor = Auth::guard('fornecedores')->user();

    $request->validate([
        'nome' => 'required|string|max:255',
        'descricao' => 'required|string',
        'preco' => 'required|numeric|min:0',
        'estoque_imagem.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', 
        'caracteristicas' => 'required|string',
        'historico_modelos' => 'nullable|string',
        'tamanhos_disponiveis' => 'nullable|string',
        'genero' => 'required|in:MASCULINO,FEMININO,UNISSEX',
        'categoria' => 'required|string|max:100',
        'fotos.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        'ativo' => 'required|boolean',
    ]);
       // Salvar imagens estoque

    $imagensEstoque = [];

    if ($request->hasFile('estoque_imagem')) {

        foreach ($request->file('estoque_imagem') as $file) {
            $imagensEstoque[] = $file->store('produtos/estoque', 'public');

        }

    }


    // Salvar imagens fotos
    $imagens = [];
    if ($request->hasFile('fotos')) {
        foreach ($request->file('fotos') as $file) {
            $imagens[] = $file->store('produtos', 'public');
        }
    }

    ProdutoFornecedor::create([
        'nome' => $request->nome,
        'descricao' => $request->descricao,
        'preco' => $request->preco,
        'estoque_imagem' => !empty($imagensEstoque) ? json_encode($imagensEstoque) : null,
        'caracteristicas' => $request->caracteristicas,
        'historico_modelos' => $request->historico_modelos,
        'tamanhos_disponiveis' => $request->tamanhos_disponiveis
        ? array_map('trim', explode(',', $request->tamanhos_disponiveis))
        : null,
        'genero' => $request->genero,
        'categoria' => $request->categoria,
        'fotos' => !empty($imagens) ? json_encode($imagens) : null,
        'ativo' => $request->ativo,
        'slug' => Str::slug($request->nome) . '-' . uniqid(),
        'id_fornecedores' => $fornecedor->id_fornecedores,
    ]);

    return redirect()->route('fornecedores.produtos.index')
                     ->with('success', 'Produto cadastrado com sucesso!');
}


public function update(Request $request, $id)
{
    $produto = ProdutoFornecedor::findOrFail($id);

    $request->validate([
        'nome' => 'required|string|max:255',
        'descricao' => 'required|string',
        'preco' => 'required|numeric|min:0',
        'estoque_imagem.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        'caracteristicas' => 'required|string',
        'historico_modelos' => 'nullable|string',
        'tamanhos_disponiveis' => 'nullable|string',
        'genero' => 'required|in:MASCULINO,FEMININO,UNISSEX',
        'categoria' => 'required|string|max:100',
        'fotos.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        'ativo' => 'required|boolean',
    ]);

    $data = $request->only([
        'nome',
        'descricao',
        'preco',
        'caracteristicas',
        'historico_modelos',
        'genero',
        'categoria',
        'ativo',
    ]);

    // Atualiza tamanhos disponíveis
    $data['tamanhos_disponiveis'] = $request->tamanhos_disponiveis
    ? array_map('trim', explode(',', $request->tamanhos_disponiveis))
    : null;


    // Atualiza fotos se enviar
    if ($request->hasFile('fotos')) {
        $fotosPaths = [];
        foreach ($request->file('fotos') as $foto) {
            $fotosPaths[] = $foto->store('produtos', 'public');
        }
        $data['fotos'] = json_encode($fotosPaths);
    }

        // Atualiza estoque_imagem se enviar
    if ($request->hasFile('estoque_imagem')) {

        $estoquePaths = [];

        foreach ($request->file('estoque_imagem') as $img) {
            $estoquePaths[] = $img->store('produtos/estoque', 'public');
        }

        $data['estoque_imagem'] = json_encode($estoquePaths);
    }

    // Atualiza slug
    $data['slug'] = \Str::slug($request->nome);

    $produto->update($data);

    return redirect()->back()->with('success', 'Produto atualizado com sucesso!');
}



    public function index()
{
    $fornecedor = Auth::guard('fornecedores')->user();

    // Busca produtos deste fornecedor
    $produtos = ProdutoFornecedor::where('id_fornecedores', $fornecedor->id_fornecedores)->get();

    return view('fornecedores.produtos.index', compact('produtos'));
}


public function listar()
{
    $fornecedor = Auth::guard('fornecedores')->user();

    $produtos = ProdutoFornecedor::where('id_fornecedores', $fornecedor->id_fornecedores)->get();

    foreach ($produtos as $produto) {
        $produto->tamanhos_disponiveis = is_array($produto->tamanhos_disponiveis)
            ? $produto->tamanhos_disponiveis
            : json_decode($produto->tamanhos_disponiveis ?? '[]', true);

        $produto->fotos = is_array($produto->fotos)
            ? $produto->fotos
            : json_decode($produto->fotos ?? '[]', true);

        $produto->estoque_imagem = is_array($produto->estoque_imagem)
            ? $produto->estoque_imagem
            : json_decode($produto->estoque_imagem ?? '[]', true);
    }

    return view('fornecedores.produtos.partials.listar', compact('produtos'));
}




public function edit($id)
{
    $produto = ProdutoFornecedor::findOrFail($id);

    return view('fornecedores.produtos.partials.edit', compact('produto'));
}

public function destroy($id)
{
    $produto = ProdutoFornecedor::findOrFail($id);

    // Se quiser apagar as imagens do storage, faça aqui:
    // Exemplo para apagar imagens principais:
    if (!empty($produto->fotos)) {
        $fotos = json_decode($produto->fotos, true);
        foreach ($fotos as $foto) {
            \Storage::disk('public')->delete($foto);
        }
    }
    // Exemplo para apagar imagens de estoque:


    if (!empty($produto->estoque_imagem)) {
        $estoqueImgs = json_decode($produto->estoque_imagem, true);

        foreach ($estoqueImgs as $img) {
            \Storage::disk('public')->delete($img);
        }
    }

    $produto->delete();

    return redirect()->back()->with('success', 'Produto excluído com sucesso!');
}
public function toggleProduto($id)
{
    $produto = ProdutoFornecedor::findOrFail($id);

    // Alterna entre ativo (1) e inativo (0)
    $produto->ativo = $produto->ativo ? 0 : 1;
    $produto->save();

    $statusTexto = $produto->ativo ? 'ATIVO' : 'INATIVO';

    return redirect()->back()->with('success', "Produto atualizado para {$statusTexto} com sucesso!");
}
}