<?php

namespace App\Http\Controllers;

use App\Models\ProdutoFornecedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProdutoFornecedorController extends Controller
{
    public function create()
    {
        return view('fornecedores.produtos.create');
    }

public function store(Request $request)
{

    $fornecedor = Auth::guard('fornecedores')->user();

    $request->validate([
        'nome' => 'required|string|max:255',
        'descricao' => 'required|string',
        'preco' => 'required|numeric|min:0',
        'estoque_imagem' => 'nullable|string',
        'caracteristicas' => 'required|string',
        'historico_modelos' => 'nullable|string',
        'tamanhos_disponiveis' => 'nullable|string',
        'genero' => 'required|in:MASCULINO,FEMININO,UNISSEX',
        'categoria' => 'required|string|max:100',
        'fotos.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // validação para cada imagem
        'ativo' => 'required|boolean',
    ]);

    $imagens = [];

    if ($request->hasFile('fotos')) {
        foreach ($request->file('fotos') as $file) {
            $path = $file->store('produtos', 'public'); // salva em storage/app/public/produtos
            $imagens[] = $path;
        }
    }

    ProdutoFornecedor::create([
        'nome' => $request->nome,
        'descricao' => $request->descricao,
        'preco' => $request->preco,
        'estoque_imagem' => $request->estoque_imagem,
        'caracteristicas' => $request->caracteristicas,
        'historico_modelos' => $request->historico_modelos,
        'tamanhos_disponiveis' => $request->tamanhos_disponiveis
            ? json_encode(array_map('trim', explode(',', $request->tamanhos_disponiveis)))
            : null,
        'genero' => $request->genero,
        'categoria' => $request->categoria,
        'fotos' => json_encode($imagens), // salva o array JSON com os caminhos
        'ativo' => $request->ativo,
        'slug' => Str::slug($request->nome) . '-' . uniqid(),
        'id_fornecedores' => $fornecedor->id_fornecedores,
    ]);

    return redirect()->route('fornecedores.produtos.index')
                     ->with('success', 'Produto cadastrado com sucesso!');
}


    public function index()
{
    $fornecedor = Auth::guard('fornecedores')->user();

    // Busca produtos deste fornecedor
    $produtos = ProdutoFornecedor::where('id_fornecedores', $fornecedor->id_fornecedores)->get();

    return view('fornecedores.produtos.index', compact('produtos'));
}

}